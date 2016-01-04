<?php defined('SYSPATH') OR die('No direct access allowed.');



/**
 * Вывод сообщений об ошибках
 *
 * @author Ivan Chura
 */
class messages_Core {
 
    public static function show($messages, $type){

        $outPut = NULL;

        if(!is_null($messages)) {

            if ($type != TYPE_ERROR) {
                $type = 'info';
            }else {
                $type = 'input_error';
            }

            $outPut .= '<div class="' . $type . ' shadow">';
            if(is_array($messages)) {

                $outPut .= '<ol>';

                foreach ($messages as $error) {
                    $outPut .= '<li>' . $error . '</li>';
                }

                $outPut .= '</ol>';

            }else {
                $outPut .= $messages;
            }

            $outPut .= '</div>';

        }

        return '<center>' . $outPut . '</center>';

    }

}



?>
