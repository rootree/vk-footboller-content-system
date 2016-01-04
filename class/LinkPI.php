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
class LinkPI {

    static function detectPersonaOnImage($image_id, $persona_id, $coords, $desc){
        $sql = 'INSERT INTO tr_persona_image
                    (pi_widht, pi_height, pi_x, pi_y, pi_desc, ps_id, im_id)
                VALUES (
                    "'.intval($coords['x2']).'",
                    "'.intval($coords['y2']).'",
                    "'.intval($coords['x']).'",
                    "'.intval($coords['y']).'",
                    "'.mysql_escape_string($desc).'",
                    "'.intval($persona_id).'",
                    "'.intval($image_id).'"
                )';

        if(!mysql_query($sql)){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. (' . mysql_error() . ')' . $sql);
        }
    }

    static function getOtherPersonaOnImage($image_id){

        $sql = "SELECT tr_persona.ps_id as id, tr_persona.*
                 FROM tr_persona
                 LEFT OUTER JOIN tr_persona_image ON
                    tr_persona_image.ps_id = tr_persona.ps_id AND
                    tr_persona_image.im_id = {$image_id}
                 WHERE
                    tr_persona_image.ps_id IS NULL AND
                    tr_persona.ps_status = '".Persona::status_active."';";

        $result = mysql_query($sql);
        if(!$result){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

        if(!mysql_num_rows($result)){
            return array();
        }else{

            $people = array();

            while ($row = mysql_fetch_assoc($result)) {
                $row['read_name'] = Persona::getReadName($row['ps_first_name'], $row['ps_last_name']);
                $people[] = $row;
            }

        }

		return $people;

    }

    static function unTagPersonaFromImage($image_id, $persona_id){

        $sql = "delete
                from tr_persona_image
                where
                    im_id = {$image_id} and
                    ps_id = {$persona_id};";

        $result = mysql_query($sql);
        if(!$result){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

    }

    static function getPeopleOnImage($image_id){

        $sql = "select *
                from tr_persona_image
                join tr_persona on
                    tr_persona.ps_id = tr_persona_image.ps_id and
                    tr_persona.ps_status = '".Persona::status_active."'
                where im_id = {$image_id};";

        $result = mysql_query($sql);
        if(!$result){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

        if(!mysql_num_rows($result)){
            return array();
        }else{

            $people = array();

            while ($row = mysql_fetch_assoc($result)) {
                $row['read_name'] = Persona::getReadName($row['ps_first_name'], $row['ps_last_name']);
                $people[$row['ps_id']] = $row;
            }

        }

		return $people;

    }

    static function getImagesOfPersona($persona_id){

        $sql = "select *
                from tr_persona_image
                join tr_persona on
                     tr_persona.ps_id = tr_persona_image.ps_id and
                     tr_persona.ps_status = '".Persona::status_active."'
                join tr_images on
                     tr_images.im_id = tr_persona_image.im_id and
                     tr_images.im_status != '".Image::status_deleted."'
                where tr_persona_image.ps_id = '".$persona_id."';";

        $result = mysql_query($sql);
        if(!$result){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

        if(!mysql_num_rows($result)){
            return array();
        }else{

            $images = array();

            while ($row = mysql_fetch_assoc($result)) {
                $images[] = $row;
            }

        }

		return $images;
    }

    static function getImages(){

        $sql = "select *
                from tr_images
                where im_status != '".Image::status_deleted."';";

        $result = mysql_query($sql);
        if(!$result){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

        if(!mysql_num_rows($result)){
            return array();
        }else{

            $images = array();

            while ($row = mysql_fetch_assoc($result)) {
                $images[] = $row;
            }

        }

		return $images;

    }

    static function getPeople(){

        $sql = "select *
                from tr_persona
                where ps_status = '".Persona::status_active."';";

        $result = mysql_query($sql);
        if(!$result){
            throw new Exception('Что-то случилось с компьютером. Надо перезагрузиться. ('.mysql_error().')');
        }

        if(!mysql_num_rows($result)){
            return array();
        }else{

            $people = array();

            while ($row = mysql_fetch_assoc($result)) {
                $row['read_name'] = Persona::getReadName($row['ps_first_name'], $row['ps_last_name']);
                $people[] = $row;
            }

        }

		return $people;

    }

}
