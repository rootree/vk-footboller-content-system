<?php defined('SYSPATH') OR die('No direct access allowed.');



/**
 * Вывод сообщений об ошибках
 *
 * @author Ivan Chura
 */
class status_Core {
 
    public static function notify($code){
 
        switch ($code) {
            case NOTIFY_STATUS_NEW:      return 'Ждёт исполнения';
            case NOTIFY_STATUS_STARTED:  return 'Выполняеться...';
            case NOTIFY_STATUS_ENTED:    return 'Завершена';
            case NOTIFY_STATUS_CANCELED: return 'Отменена';

            case ITEM_STATUS_NEW:  return 'Не проверянный';

            default:                     return 'O.o';
        }

    }

    public static function itemCheck($code){

        switch ($code) {
            case ITEM_STATUS_PARSE:       return 'Требует анализа';
            case ITEM_STATUS_NEW:       return 'Не проверянный';
            case ITEM_STATUS_SENT:      return 'Проработан';
            case ITEM_STATUS_IN_GAME:   return 'Используеться в игре';
            default:                    return 'O.o';
        }

    }

    public static function line($code){
 
        switch ($code) {
            case FOOTBALLER_LINE_FORWARD:      return 'Форвард';
            case FOOTBALLER_LINE_HALFSAFER:    return 'Полу-защиткик';
            case FOOTBALLER_LINE_SAFER:        return 'Защитник';
            case FOOTBALLER_LINE_GOALKEEPER:   return 'Вратарь';

            default:                           return 'O.o';
        }

    }

    public static function completeCheck($code){

        switch ($code) {
            case 0:       return 'Пусто';
            case 1:       return 'Не закончено';
            case 2:      return 'Наполнено';
            default:                    return 'O.o';
        }

    }

}



?>
