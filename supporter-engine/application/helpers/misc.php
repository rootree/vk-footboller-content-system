<?php defined('SYSPATH') OR die('No direct access allowed.');



/**
 * @author Ivan Chura
 */
class misc_Core {

    static public $realPerMomey = 300;

    static public $reals = array(
        /* �������  =>  ������� � ������� ��� ����������, �� ������� + � ����������� �� ��������*/
        1 => 777,
        2 => 799,
        3 => 822,
        4 => 844,
        5 => 866,
        6 => 899,
        7 => 911,
        8 => 933,
        9 => 963,
        10 => 997
    );

    const ONE_REAL_FOR_IN_GAME = 1000;

    static public $energyGrid = array(
        /* �������  =>  ������� � ������� ��� ����������, �� ������� + � ����������� �� ��������*/
        1 => array(1, 1),
        2 => array(1.1, 2),
        3 => array(1.1, 0.05),
        4 => array(1.1, 0.05),
        5 => array(1.1, 0.05),
        6 => array(1.1, 0.05),
        7 => array(1.1, 0.05),
        8 => array(1.1, 0.05),
        9 => array(1.1, 0.05),
        10 => array(1.1, 0.05)
    );

    static public $footbollersGrid = array(
        /* �������  =>  �� ������� ������ ����� �������� ���*/
        1 => array(1, 0.01),
        2 => array(4, 0.02),
        3 => array(8, 0.03),
        4 => array(16, 0.04),
        5 => array(20, 0.05),
        6 => array(24, 0.06),
        7 => array(28, 0.07),
        8 => array(32, 0.08),
        9 => array(36, 0.09),
        10 => array(40, 0.10),
        11 => array(45, 0.12),
        12 => array(51, 0.14),
        13 => array(59, 0.16),
        14 => array(64, 0.19),
        15 => array(77, 0.25)
    );

    static public $priceGrid = array(
        /* �������  =>  пиченьки футболичтов ,  умножитель рейтинга, кофициент отличия тренера от фуболистов*/
        1 => array(10),
        2 => array(20),
        3 => array(27),
        4 => array(33),
        5 => array(39),
        6 => array(45),
        7 => array(59),
        8 => array(67),
        9 => array(75),
        10 => array(83),
        11 => array(89),
        12 => array(94),
        13 => array(99),
        14 => array(105),
        15 => array(110),
    );

    static public $coathPriceGrid = array(
        /* �������  =>  пиченьки футболичтов ,  умножитель рейтинга, кофициент отличия тренера от фуболистов*/
        1 => array(10),
        2 => array(20),
        3 => array(27),
        4 => array(33),
        5 => array(39),
        6 => array(45),
        7 => array(59),
        8 => array(61),
        9 => array(69),
        10 => array(72),
        11 => array(76),
        12 => array(81),
        13 => array(85),
        14 => array(91),
        15 => array(97),
    );

    static public $stadiumPriceGrid = array(
        /* �������  =>  пиченьки футболичтов ,  умножитель рейтинга, кофициент отличия тренера от фуболистов*/
        1 => array(15000),
        2 => array(17000),
        3 => array(19500),
        4 => array(23000),
        5 => array(26500),
        6 => array(29000),
        7 => array(31500),
        8 => array(33500),
        9 => array(35000),
        10 => array(37000),
        11 => array(39000),
        12 => array(43000),
        13 => array(48000),
        14 => array(52000),
        15 => array(57000),

    );

    static function getPrice($level, $rating){

        if(isset(misc::$priceGrid[$level + 1][0])){
            $max = misc::$priceGrid[$level + 1][0];
            $min = misc::$priceGrid[$level][0];
        }else{
            $max = misc::$priceGrid[$level][0];
            $min = misc::$priceGrid[$level - 1][0];
        }

        $ratingIndex = ceil(( $max - $min ) / 10);


        echo $max . " - " . $min . " ratingIndex" . $ratingIndex . "<br/>";
        
        $inGamePrice = misc::$priceGrid[$level][0] + $rating * $ratingIndex;
        $price = array(
            floor($inGamePrice * self::$realPerMomey),
            floor($inGamePrice )
        );

        return $price;
    }

    static function getPriceCoach($level, $rating){

        if(isset(misc::$priceGrid[$level + 1][0])){
            $max = misc::$priceGrid[$level + 1][0];
            $min = misc::$priceGrid[$level][0];
        }else{
            $max = misc::$priceGrid[$level][0];
            $min = misc::$priceGrid[$level - 1][0];
        }

        $ratingIndex = ceil(( $max - $min ) / 10);
 

        $inGamePrice = misc::$priceGrid[$level][0] + $rating * $ratingIndex;
        $inGamePrice *= 1.7;

        $price = array(
            floor($inGamePrice * misc::$realPerMomey),
            floor($inGamePrice)
        );

        return $price;
    }

    static function getStadiumPrice($level, $rating){

        if(isset(misc::$stadiumPriceGrid[$level + 1][0])){
            $max = misc::$stadiumPriceGrid[$level + 1][0];
            $min = misc::$stadiumPriceGrid[$level][0];
        }else{
            $max = misc::$stadiumPriceGrid[$level][0];
            $min = misc::$stadiumPriceGrid[$level - 1][0];
        }
 
        $ratingStuff = ceil(( $max - $min ) / 7);
        
        $inGamePrice = misc::$stadiumPriceGrid[$level][0] + $ratingStuff * $rating;
        $price = array(
            floor($inGamePrice),
            floor($inGamePrice / misc::$realPerMomey)
        );
        return $price;
    }

    static function getEnegry($level, $rating){
        return $rating * 0.02 + $level / 100 + 1;
    }

    static public $coachGrid = array(
        /* �������  =>  �� ������� ������ ����� �������� ���*/
        1 => array(10 ),
        2 => array(17 ),
        3 => array(24  ),
        4 => array(34 ),
        5 => array(46 ),
        6 => array(57 ),
        7 => array(69 ),
        8 => array(81 ),
        9 => array(99 ),
        10 => array(105 ),
        11 => array(112 ),
        12 => array(119 ),
        13 => array(125),
        14 => array(137 ),
        15 => array(155 ),
    );
    static function getCoachMultiplay($level, $rating){

        if(isset(misc::$coachGrid[$level + 1][0])){
            $max = misc::$coachGrid[$level + 1][0];
            $min = misc::$coachGrid[$level][0];
        }else{
            $max = misc::$coachGrid[$level][0];
            $min = misc::$coachGrid[$level - 1][0];
        }

        $ratingIndex = ceil(( $max - $min ) / 10);
        // ставка уровня + умножитель на рейтинг
        return floor(misc::$coachGrid[$level][0] + $rating * $ratingIndex);
    }

    static function getFootbollerMultiplay($level, $rating){
        return floor(misc::$footbollersGrid[$level][0] + $rating);
    }

    static public $stadiumGrid = array(
        /* �������  =>  �� ������� ������ ����� �������� ���*/
        1 => array(300),
        2 => array(350),
        3 => array(410),
        4 => array(470),
        5 => array(530),
        6 => array(590),
        7 => array(610),
        8 => array(660),
        9 => array(700),
    );
    static function getStadiumMultiplay($level, $rating){

        if(isset(misc::$stadiumGrid[$level + 1][0])){
            $max = misc::$stadiumGrid[$level + 1][0];
            $min = misc::$stadiumGrid[$level][0];
        }else{
            $max = misc::$stadiumGrid[$level][0];
            $min = misc::$stadiumGrid[$level - 1][0];
        }

        $ratingIndex = ceil(( $max - $min ) / 6);
        return floor(misc::$stadiumGrid[$level][0] + $rating * $ratingIndex);
    }

    static function getExt($fileName){
        preg_match('~(?:\.(.{3}))?$~',$fileName, $match_ext);
        return isset($match_ext[1]) ? $match_ext[1]: '';
    }

    static public function getMimeType($file_extension){

        $file_extension = strtolower($file_extension);

        //This will set the Content-Type to the appropriate setting for the file
        switch( $file_extension ) {
            case "pdf": $ctype="application/pdf"; break;
            case "exe": $ctype="application/octet-stream"; break;
            case "zip": $ctype="application/zip"; break;
            case "doc": $ctype="application/msword"; break;
            case "xls": $ctype="application/vnd.ms-excel"; break;
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpg"; break;
            case "mp3": $ctype="audio/mpeg"; break;
            case "wav": $ctype="audio/x-wav"; break;
            case "mpeg":
            case "mpg":
            case "mpe": $ctype="video/mpeg"; break;
            case "mov": $ctype="video/quicktime"; break;
            case "avi": $ctype="video/x-msvideo"; break;

            //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
            case "php":
            case "htm":
            case "html":
            case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;
            default: $ctype="application/force-download";
        }
        return $ctype;
    }


}



?>
