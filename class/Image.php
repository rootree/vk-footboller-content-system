<?php
// +----------------------------------------------------------------------+
// | IsMyFamily.name - History of your family                             |
// +----------------------------------------------------------------------+
// | Copyright (c) 2009 - 2010                                            |
// +----------------------------------------------------------------------+
// | Authors: Ivan Chura <ivan.chura@gmail.com>                           |
// +----------------------------------------------------------------------+

/**
 * @version 1.0
 * @author Ivan Chura <ivan.chura@gmail.com>
 */
class Image {

    private $info = null;
    private $file_name = null;

    const status_loaded     = 'st_loaded';
    const status_copied     = 'st_copied';
    const status_edited     = 'st_edited';
    const status_saved      = 'st_saved';
    const status_deleted    = 'st_deleted';

    const path_src          = 'src';

    static $formats = array(
        'big'       => '604',
        'medium'    => '130'
    );

    static $acceptImageTypes = array(
        'image/jpeg'
    );

    static function createImage(array $uploaded_image){

        if(UPLOAD_ERR_OK != $uploaded_image['error']){
            throw new Exception('Плохой код загрузки ('.$uploaded_image['error'].')');
        }

        if(!in_array($uploaded_image['type'], self::$acceptImageTypes)){
            throw new Exception('Мы не принимаем данный тип файлов "'.$uploaded_image['type'].'". Нанужны только картинки.');
        }

        $sql = 'INSERT INTO TR_IMAGES
                    (im_file_name, im_desc, im_create_date, im_place, im_create_year, im_status)
                    VALUES
                    ("'.$uploaded_image['name'].'", "", NOW(), "", 0000, "'.Image::status_loaded.'")';

        if(!mysql_query($sql)){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

        $image_id = mysql_insert_id();

        $src_file = SuperPath::get($image_id, Image::path_src) . "." . Misc::getExt($uploaded_image['name']);
        if(!move_uploaded_file($uploaded_image['tmp_name'], $src_file)){
            throw new Exception('Не получилось сохранить файл. Попробовато надо ещё, поле перезагрузки.');
        }

        $ext = Misc::getExt($uploaded_image['name']);

        self::createCopy($image_id, $ext);
        self::updateCopySize($image_id, $ext);

        return $image_id;

    }

    static function createCopy($image_id, $ext){

        $src_file = SuperPath::get($image_id, Image::path_src) . "." . $ext;
        if(!file_exists($src_file)){
            throw new Exception('Не найден фаил исходной фотографии (' . $src_file . ')' );
        }

        foreach(Image::$formats as $format => $size){

            $copy_file = SuperPath::get($image_id, $format) . "." . $ext;

            $cmd_command = "convert –quality 100 " . escapeshellarg($src_file) . " -coalesce  -geometry " . Image::$formats[$format] .
                                "x" . Image::$formats[$format] . " +repage " . escapeshellarg($copy_file);

            system($cmd_command);

        }

    }

    public static function updateCopySize($image_id, $ext = 'jpg') {

        $copy_file = SuperPath::get($image_id, 'big') . "." . $ext;

        $size = getimagesize($copy_file);
        if(!is_array($size)){
            throw new Exception('Кажеться файл копии не являеться изображением('.$copy_file.')');
        }

        $sql = 'UPDATE TR_IMAGES SET
                    im_copy_wigth = "'.$size[0].'",
                    im_copy_height = "'.$size[1].'"
                WHERE im_id = '.$image_id;

        if(!mysql_query($sql)){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

    }

    public function __construct($image_id){

        $sql = "select * from tr_images where im_id = {$image_id} limit 1;";
        $result = mysql_query($sql);
        if(!$result){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

        if(!mysql_num_rows($result)){
            throw new Exception('Как странно! Не найдена выбранная фотография ('.$image_id.'). Попробуй зайти на основную странице и выбрать фотку снова');
        }

		$this->info = mysql_fetch_assoc($result);
		$this->file_name = $this->info['im_id'] . "." . Misc::getExt($this->info['im_file_name']);

    }

    public function rotateCopy($degree = 0){

        foreach(Image::$formats as $format => $size){

            $copy_file = SuperPath::get($this->file_name, $format);

            $cmd_command = "convert " . escapeshellarg($copy_file) . " -coalesce  -rotate {$degree} +repage " . escapeshellarg($copy_file);
            system($cmd_command);

        }
    }

    public function reStore(){
        $ext = Misc::getExt($this->file_name);
        self::createCopy($this->info['im_id'], $ext);
        self::updateCopySize($this->info['im_id'], $ext);
    }

    public function cropCopy($coords){

        $src_file = SuperPath::get($this->file_name, Image::path_src);

        $size = getimagesize($src_file);
        if(!is_array($size)){
            throw new Exception('Кажеться файл оригинала не являеться изображением('.$src_file.')');
        }

        $zoom = round( $size[0] / $this->info['im_copy_wigth'], 4);

        foreach(Image::$formats as $format => $size){

            $copy_file = SuperPath::get($this->file_name, $format);

            $cmd_command = 'convert ' . escapeshellarg($src_file) . '  -coalesce ' .
                    '-crop "' . ceil($zoom * $coords['w']) . 'x' . ceil($zoom * $coords['h']) . '+' .
                    ceil($zoom * $coords['x']) . '+' . ceil($zoom * $coords['y']) . '" '.
                    " -geometry " . Image::$formats[$format] . "x" . Image::$formats[$format] . " +repage " .
                    escapeshellarg($copy_file);
 
            system($cmd_command);

        }

        self::updateCopySize($this->info['im_id'], Misc::getExt($src_file));
        
    }

    public function getCopyFile(){
        return SuperPath::get($this->file_name, 'big');
    }

    public function getImageInfo($parameter_name){

        if(!isset($this->info[$parameter_name])){
            throw new Exception('Не правильно указан параметер изображения ('.$parameter_name.')');
        }

        return $this->info[$parameter_name];
    }

    public function setImageInfo($new_parameters){

        $sql = "update tr_images set
                    im_desc = '".mysql_escape_string($new_parameters['image_desc'])."',
                    im_place = '".mysql_escape_string($new_parameters['image_place'])."',
                    im_create_year = '".$new_parameters['image_year']."'
                where im_id = ".$this->info['im_id'];

        if(!mysql_query($sql)){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

        if($this->getStatus() != Image::status_edited){
            $this->setStatus(Image::status_edited);
        }

    }

    public function setStatus($new_status){
        $sql = "update tr_images set im_status = '$new_status' where im_id = ".$this->info['im_id'].";";
        if(!mysql_query($sql)){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }
    }

    public function getStatus(){
        return $this->info['im_status'];
    }

    public function getRealFileImage(){
        return $this->file_name;
    }

    public function forwardByStatus(){
        switch($this->info['im_status']){
            case Image::status_loaded: Misc::redirect('/copy_image.php?image_id=' . $this->info['im_id']); break;
            #case Image::status_copied: Misc::redirect('/desc_image.php?image_id=' . $this->info['im_id']); break;
        }
    }

    public function deleteImage(){
        $this->setStatus(Image::status_deleted);
    }
 
}
