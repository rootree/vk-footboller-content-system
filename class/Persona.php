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
class Persona {

    const thumbnail_size = 150;
    const thumbnail_store = 'thumbnail';

    const status_active     = 'st_active';
    const status_deleted    = 'st_deleted';

    protected $one = null;

    static function createOne(Image & $image, $persona_info, $coords = array()){

        $thumbnail_ext = Misc::getExt($image->getCopyFile());

        $sql = 'INSERT INTO tr_persona (
                    ps_first_name,
                    ps_last_name,
                    ps_width,
                    ps_height,
                    ps_x,
                    ps_y,
                    ps_ext,
                    ps_create_date,
                    ps_status
                ) VALUES (
                    "'.mysql_escape_string($persona_info['persona_name']).'",
                    "'.mysql_escape_string($persona_info['persona_last']).'",
                    "'.intval($coords['w']).'",
                    "'.intval($coords['h']).'",
                    "'.intval($coords['x']).'",
                    "'.intval($coords['y']).'",
                    "'.$thumbnail_ext.'",
                    NOW(),
                    "'.Persona::status_active.'"
                )';

        if(!mysql_query($sql)){
            throw new Exception('Не получилось создать персону. Надо перезагрузиться. ('.mysql_error().')');
        }

        $persona_id = mysql_insert_id();

        $thumbnail_file = SuperPath::get($persona_id . '.' . $thumbnail_ext, Persona::thumbnail_store);

        $cmd_command = 'convert ' . escapeshellarg($image->getCopyFile()) . ' ' .
                         '-crop "' . $coords['w'] . 'x' . $coords['h'] . '+' . $coords['x'] . '+' . $coords['y'] . '" '.
                         '-thumbnail "' . Persona::thumbnail_size . 'x' . Persona::thumbnail_size . '" ' .
                         escapeshellarg($thumbnail_file);

        system($cmd_command);




//        $src_file = SuperPath::get($image->getRealFileImage(), Image::path_src);
//
//        $size = getimagesize($src_file);
//        if(!is_array($size)){
//            throw new Exception('Кажеться файл оригинала не являеться изображением('.$src_file.')');
//        }
//
//        $zoom = ( $size[0] / $image->getImageInfo('im_copy_wigth') );
//         echo("$zoom");
//
//        $cmd_command = 'convert ' . escapeshellarg($src_file) . '  -coalesce ' .
//                '-crop "' . ($zoom * $coords['w']) . 'x' . ($zoom * $coords['h']) . '+' .
//                ($zoom * $coords['x']) . '+' . ($zoom * $coords['y']) . '" '.
//                " -geometry " . Persona::thumbnail_size . "x" . Persona::thumbnail_size . " +repage " .
//                escapeshellarg($thumbnail_file);
//echo $cmd_command;
//        system($cmd_command);
         
        return $persona_id;
    }

    public function __construct($persona_id){

        $sql = "select * from tr_persona where ps_id = {$persona_id} limit 1;";
        $result = mysql_query($sql);
        if(!$result){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

        if(!mysql_num_rows($result)){
            throw new Exception('Как странно! Не найдена выбранная персона ('.$persona_id.'). Попробуй зайти на основную странице и выбрать фотку снова');
        }

		$this->one = mysql_fetch_assoc($result);

    }

    public function getOneInfo($parameter_name = null){

        if(is_null($parameter_name)){
            $this->one['read_name'] = $this->getName();
            return $this->one;
        }

        if(!isset($this->one[$parameter_name])){
            throw new Exception('Не правильно указан параметер персоны ('.$parameter_name.')');
        }

        return $this->one[$parameter_name];
    }

    public function getName(){
        return self::getReadName($this->one['ps_first_name'], $this->one['ps_last_name']);
    }

    static function getReadName($first_name = null, $last_name = null){
        return (!empty($first_name) || !empty($last_name))
            ? $first_name . ' ' . $last_name
            : 'Без Имени' ;
    }

    public function deleteOne(){
        $sql = "update tr_persona set ps_status = '".Persona::status_deleted."' where ps_id = ".$this->one['ps_id'].";";
        if(!mysql_query($sql)){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')' . $sql);
        }
    }

    public function getStatus(){
        return $this->one['ps_status'];
    }

    public function setParameters($params){

        $sql = null;

        if(!is_array($params)){
            throw new Exception('Переданы не правильные данные персоны');
        }

        foreach($params as $param_name => $value){
            $sql .= $param_name . ' = "' . mysql_escape_string($value) . '", ';
        }

        if(is_null($sql)){
            return null;
        }

        $sql = substr($sql, 0, -2);

        $sql = "update tr_persona set " . $sql . " where ps_id = ".$this->one['ps_id'].";";
        if(!mysql_query($sql)){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')' . $sql);
        }

    }
}
