<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Base path of the web site. If this includes a domain, eg: localhost/kohana/
 * then a full URL will be used, eg: http://localhost/kohana/. If it only includes
 * the path, and a site_protocol is specified, the domain will be auto-detected.
 */

/**
 * Force a default protocol to be used by the site. If no site_protocol is
 * specified, then the current protocol is used, or when possible, only an
 * absolute path (with no protocol/domain) is used.
 */
$config['site_protocol'] = 'http';

/**
 * Name of the front controller for this application. Default: index.php
 *
 * This can be removed by using URL rewriting.
 */
$config['index_page'] = '';

/**
 * Fake file extension that will be added to all generated URLs. Example: .html
 */
$config['url_suffix'] = '';

/**
 * Length of time of the internal cache in seconds. 0 or FALSE means no caching.
 * The internal cache stores file paths and config entries across requests and
 * can give significant speed improvements at the expense of delayed updating.
 */
$config['internal_cache'] = FALSE;

/**
 * Internal cache directory.
 */
$config['internal_cache_path'] = APPPATH.'cache/';

/**
 * Enable internal cache encryption - speed/processing loss
 * is neglible when this is turned on. Can be turned off
 * if application directory is not in the webroot.
 */
$config['internal_cache_encrypt'] = FALSE;

/**
 * Encryption key for the internal cache, only used
 * if internal_cache_encrypt is TRUE.
 *
 * Make sure you specify your own key here!
 *
 * The cache is deleted when/if the key changes.
 */
$config['internal_cache_key'] = 'foobar-changeme';

/**
 * Enable or disable gzip output compression. This can dramatically decrease
 * server bandwidth usage, at the cost of slightly higher CPU usage. Set to
 * the compression level (1-9) that you want to use, or FALSE to disable.
 *
 * Do not enable this option if you are using output compression in php.ini!
 */
$config['output_compression'] = FALSE;

/**
 * Enable or disable global XSS filtering of GET, POST, and SERVER data. This
 * option also accepts a string to specify a specific XSS filtering tool.
 */
$config['global_xss_filtering'] = TRUE;

/**
 * Enable or disable hooks.
 */
$config['enable_hooks'] = FALSE;

/**
 * Log thresholds:
 *  0 - Disable logging
 *  1 - Errors and exceptions
 *  2 - Warnings
 *  3 - Notices
 *  4 - Debugging
 */
$config['log_threshold'] = 1;

/**
 * Message logging directory.
 */
$config['log_directory'] = APPPATH.'logs';

/**
 * Enable or disable displaying of Kohana error pages. This will not affect
 * logging. Turning this off will disable ALL error pages.
 */
$config['display_errors'] = TRUE;

/**
 * Enable or disable statistics in the final output. Stats are replaced via
 * specific strings, such as {execution_time}.
 *
 * @see http://docs.kohanaphp.com/general/configuration
 */
$config['render_stats'] = TRUE;

/**
 * Filename prefixed used to determine extensions. For example, an
 * extension to the Controller class would be named MY_Controller.php.
 */
$config['extension_prefix'] = 'MY_';

/**
 * Additional resource paths, or "modules". Each path can either be absolute
 * or relative to the docroot. Modules can include any resource that can exist
 * in your application directory, configuration files, controllers, views, etc.
 */
$config['modules'] = array
(
    // MODPATH.'auth',      // Authentication
    // MODPATH.'kodoc',     // Self-generating documentation
    // MODPATH.'gmaps',     // Google Maps integration
    // MODPATH.'archive',   // Archive utility
    // MODPATH.'payment',   // Online payments
    // MODPATH.'unit_test', // Unit testing
);

/**
 * Список всех проектов
 */
$config['projects'] = array
(
    1 => array(
        'title'         => '«****»',
        'api_secret'    => '****',
        'api_id'        => '****',
        'db'            => 'crazy_statistic',
        'table'         => 'crazy_test',
        'field'         => 'user_VK_id',
        'speed_mailing' => 40, // Скорость рассылки в мил.сек 
    )
);

define('PAGE_LOGIN', 'login');
define('PAGE_MAIN', 'welcome');
define('PAGE_FOOTBALLERS', 'footballers');
define('PAGE_COACHES', 'coaches');
define('PAGE_STADIUMS', 'stadiums');
define('PAGE_TEAMS', 'teams');
define('PAGE_MODER', 'moderator');
define('PAGE_SPONSORS', 'sponsors');
define('PAGE_OPERATIONS', 'operations');
define('PAGE_CUPS', 'cups');

define('ACCESS_GUEST', 8);
define('ACCESS_ADMIN', 1);
define('ACCESS_MODER', 2);
define('ACCESS_VIEWER', 4);

define('WORD_SOLT', 'FUZZ');

$GLOBALS['ACCESS'] = array(
    PAGE_LOGIN => ACCESS_GUEST,
    PAGE_MAIN => ACCESS_ADMIN + ACCESS_MODER + ACCESS_VIEWER,
    PAGE_FOOTBALLERS => ACCESS_ADMIN + ACCESS_MODER,
    PAGE_COACHES => ACCESS_ADMIN + ACCESS_MODER ,
    PAGE_STADIUMS => ACCESS_ADMIN + ACCESS_MODER ,
    PAGE_TEAMS => ACCESS_ADMIN + ACCESS_MODER ,
    PAGE_SPONSORS => ACCESS_ADMIN + ACCESS_MODER ,
    PAGE_CUPS => ACCESS_ADMIN + ACCESS_MODER ,
    PAGE_OPERATIONS => ACCESS_ADMIN,
    PAGE_MODER => ACCESS_ADMIN + ACCESS_VIEWER,
);

define('TYPE_ERROR', '1');
define('TYPE_INFO',  '0');

define('NOTIFY_STATUS_NEW',      '1');
define('NOTIFY_STATUS_STARTED',  '2');
define('NOTIFY_STATUS_ENTED',    '3');
define('NOTIFY_STATUS_CANCELED', '4');

define('DATE_FORMAT', 'd.m.Y H:s');
define('BASE_PATH', "http://".$_SERVER['SERVER_NAME']."/");


define('ITEM_STATUS_PARSE', '0');
define('ITEM_STATUS_NEW', '1');
define('ITEM_STATUS_SENT', '2');
define('ITEM_STATUS_IN_GAME', '4');
define('ITEM_STATUS_RECOMMIT', '8');
define('ITEM_STATUS_BACKUP', '16');

$GLOBALS['ACCESS_BY_STATUS'] = array(
    ITEM_STATUS_PARSE => ACCESS_ADMIN + ACCESS_MODER,
    ITEM_STATUS_NEW => ACCESS_ADMIN + ACCESS_MODER,
    ITEM_STATUS_SENT => ACCESS_ADMIN,
    ITEM_STATUS_IN_GAME => ACCESS_ADMIN,
    ITEM_STATUS_RECOMMIT => ACCESS_ADMIN,
    ITEM_STATUS_BACKUP => ACCESS_ADMIN
);

define('FOOTBALLER_LINE_FORWARD', '1');
define('FOOTBALLER_LINE_HALFSAFER', '2');
define('FOOTBALLER_LINE_SAFER', '3');
define('FOOTBALLER_LINE_GOALKEEPER', '4');

define('FOOTBALLER_LINE_COACH', '5');

define('IMAGE_AVATAR_H', '158');
define('IMAGE_AVATAR_W', '158');

define('IMAGE_BEST_H', '181');
define('IMAGE_BEST_W', '181');

define('IMAGE_STADIUM_H', '202');
define('IMAGE_STADIUM_W', '360');

define('STORE_AVATARS', 'avatarPhotos');
define('STORE_BEST', 'bestPhotos');
define('STORE_STADIUMS', 'stadiums');
define('STORE_COACHES', 'coaches');
define('STORE_TEAMS', 'teams');
define('STORE_SPONSORS', 'sponsors');

define('STORE_GAME_AVATARS', 'FOOTBALLER');
define('STORE_GAME_BEST', 'BEST');
define('STORE_GAME_STADIUMS', 'STADIUM');
define('STORE_GAME_COACHES', 'FOOTBALLER');
define('STORE_GAME_TEAMS', 'TEAM');
define('STORE_GAME_SPONSORS', 'SPONSOR');

        $urlGameServer = 'http://109.234.155.18/';
        $urlStaticServer = 'http://109.234.155.18:8080/content/testConnection.txt';
        $urlStatisticServer = 'http://xobmen.ru/ZS/';

switch ($GLOBALS['runningOn']){

    case 2: // Работа
	
		$config['site_domain'] = 'supporter.loc/';
        define("ITEMS_XML", "C:/srv/footboll/client/html-template/data/itemsConf.xml");
        define('PATH_ENGINE', 'C:\srv\footboll\supporter\supporter-engine');
        define('STORE_WEB', '/STORE');
        define('STORE_DISK', 'D:/football/supporter/htdocs/STORE');
        define('STORE_GAME', 'D:/football/static');

        define('DB_USER', 'root');
        define('DB_PASS', '111111');
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'test');

        define('DB_SUPPORT_USER', 'root');
        define('DB_SUPPORT_PASS', '111111');
        define('DB_SUPPORT_HOST', 'localhost');
        define('DB_SUPPORT_NAME', 'football');

        break;
    case 5:  // Server

		$config['site_domain'] = 'xobmen.ru/';

        define("ITEMS_XML", "/home1/webnizer/footballer-support/itemsConf.xml");

        define('PATH_ENGINE', '/home1/webnizer/footballer-support');
        define('STORE_WEB', '/STORE');
        define('STORE_DISK', '/home1/webnizer/public_html/xobmen/STORE');
        define('STORE_GAME', '/home1/webnizer/public_html/footballer');

        define('DB_USER', '535698_football');
        define('DB_PASS', '****');
        define('DB_HOST', 'localhost');
        define('DB_NAME', '535698_football');

        define('DB_SUPPORT_USER', 'root');
        define('DB_SUPPORT_PASS', '****');
        define('DB_SUPPORT_HOST', 'localhost');
        define('DB_SUPPORT_NAME', 'football');

        break;
}

define('TYPE_FOOTBALLER', 'FOOTBALLER');
define('TYPE_COACH', 'COACH');


$GLOBALS['countries'] = array(
    0 => "-",
    19 => "Австралия",
    20 => "Австрия",
    5 => "Азербайджан",
    21 => "Албания",
    22 => "Алжир",
    23 => "Американское Самоа",
    24 => "Ангилья",
    25 => "Ангола",
    26 => "Андорра",
    27 => "Антигуа и Барбуда",
    28 => "Аргентина",
    6 => "Армения",
    29 => "Аруба",
    30 => "Афганистан",
    31 => "Багамы",
    32 => "Бангладеш",
    33 => "Барбадос",
    34 => "Бахрейн",
    3 => "Беларусь",
    35 => "Белиз",
    36 => "Бельгия",
    37 => "Бенин",
    38 => "Бермуды",
    39 => "Болгария",
    40 => "Боливия",
    41 => "Босния и Герцеговина",
    42 => "Ботсвана",
    43 => "Бразилия",
    44 => "Бруней-Даруссалам",
    45 => "Буркина-Фасо",
    46 => "Бурунди",
    47 => "Бутан",
    48 => "Вануату",
    49 => "Англия",
    50 => "Венгрия",
    51 => "Венесуэла",
    52 => "Виргинские острова, Британские",
    53 => "Виргинские острова, США",
    54 => "Восточный Тимор",
    55 => "Вьетнам",
    56 => "Габон",
    57 => "Гаити",
    58 => "Гайана",
    59 => "Гамбия",
    60 => "Гана",
    61 => "Гваделупа",
    62 => "Гватемала",
    63 => "Гвинея",
    64 => "Гвинея-Бисау",
    65 => "Германия",
    66 => "Гибралтар",
    67 => "Гондурас",
    68 => "Гонконг",
    69 => "Гренада",
    70 => "Гренландия",
    71 => "Греция",
    7 => "Грузия",
    72 => "Гуам",
    73 => "Дания",
    231 => "Джибути",
    74 => "Доминика",
    75 => "Доминиканская Республика",
    76 => "Египет",
    77 => "Замбия",
    78 => "Западная Сахара",
    79 => "Зимбабве",
    8 => "Израиль",
    80 => "Индия",
    81 => "Индонезия",
    82 => "Иордания",
    83 => "Ирак",
    84 => "Иран",
    85 => "Ирландия",
    86 => "Исландия",
    87 => "Испания",
    88 => "Италия",
    89 => "Йемен",
    90 => "Кабо-Верде",
    4 => "Казахстан",
    91 => "Камбоджа",
    92 => "Камерун",
    10 => "Канада",
    93 => "Катар",
    94 => "Кения",
    95 => "Кипр",
    96 => "Кирибати",
    97 => "Китай",
    98 => "Колумбия",
    99 => "Коморы",
    100 => "Конго",
    101 => "Конго, демократическая республика",
    102 => "Коста-Рика",
    103 => "Кот д`Ивуар",
    104 => "Куба",
    105 => "Кувейт",
    11 => "Кыргызстан",
    106 => "Лаос",
    12 => "Латвия",
    107 => "Лесото",
    108 => "Либерия",
    109 => "Ливан",
    110 => "Ливийская Арабская Джамахирия",
    13 => "Литва",
    111 => "Лихтенштейн",
    112 => "Люксембург",
    113 => "Маврикий",
    114 => "Мавритания",
    115 => "Мадагаскар",
    116 => "Макао",
    117 => "Македония",
    118 => "Малави",
    119 => "Малайзия",
    120 => "Мали",
    121 => "Мальдивы",
    122 => "Мальта",
    123 => "Марокко",
    124 => "Мартиника",
    125 => "Маршалловы Острова",
    126 => "Мексика",
    127 => "Микронезия, федеративные штаты",
    128 => "Мозамбик",
    15 => "Молдова",
    129 => "Монако",
    130 => "Монголия",
    131 => "Монтсеррат",
    132 => "Мьянма",
    133 => "Намибия",
    134 => "Науру",
    135 => "Непал",
    136 => "Нигер",
    137 => "Нигерия",
    138 => "Нидерландские Антилы",
    139 => "Нидерланды",
    140 => "Никарагуа",
    141 => "Ниуэ",
    142 => "Новая Зеландия",
    143 => "Новая Каледония",
    144 => "Норвегия",
    145 => "Объединенные Арабские Эмираты",
    146 => "Оман",
    147 => "Остров Мэн",
    148 => "Остров Норфолк",
    149 => "Острова Кайман",
    150 => "Острова Кука",
    151 => "Острова Теркс и Кайкос",
    152 => "Пакистан",
    153 => "Палау",
    154 => "Палестинская автономия",
    155 => "Панама",
    156 => "Папуа - Новая Гвинея",
    157 => "Парагвай",
    158 => "Перу",
    159 => "Питкерн",
    160 => "Польша",
    161 => "Португалия",
    162 => "Пуэрто-Рико",
    163 => "Реюньон",
    1 => "Россия",
    164 => "Руанда",
    165 => "Румыния",
    9 => "США",
    166 => "Сальвадор",
    167 => "Самоа",
    168 => "Сан-Марино",
    169 => "Сан-Томе и Принсипи",
    170 => "Саудовская Аравия",
    171 => "Свазиленд",
    172 => "Святая Елена",
    173 => "Северная Корея",
    174 => "Северные Марианские острова",
    175 => "Сейшелы",
    176 => "Сенегал",
    177 => "Сент-Винсент",
    178 => "Сент-Китс и Невис",
    179 => "Сент-Люсия",
    180 => "Сент-Пьер и Микелон",
    181 => "Сербия",
    182 => "Сингапур",
    183 => "Сирийская Арабская Республика",
    184 => "Словакия",
    185 => "Словения",
    186 => "Соломоновы Острова",
    187 => "Сомали",
    188 => "Судан",
    189 => "Суринам",
    190 => "Сьерра-Леоне",
    16 => "Таджикистан",
    191 => "Таиланд",
    192 => "Тайвань",
    193 => "Танзания",
    194 => "Того",
    195 => "Токелау",
    196 => "Тонга",
    197 => "Тринидад и Тобаго",
    198 => "Тувалу",
    199 => "Тунис",
    17 => "Туркмения",
    200 => "Турция",
    201 => "Уганда",
    18 => "Узбекистан",
    2 => "Украина",
    202 => "Уоллис и Футуна",
    203 => "Уругвай",
    204 => "Фарерские острова",
    205 => "Фиджи",
    206 => "Филиппины",
    207 => "Финляндия",
    208 => "Фолклендские острова",
    209 => "Франция",
    210 => "Французская Гвиана",
    211 => "Французская Полинезия",
    212 => "Хорватия",
    213 => "Центрально-Африканская Республика",
    214 => "Чад",
    230 => "Черногория",
    215 => "Чехия",
    216 => "Чили",
    217 => "Швейцария",
    218 => "Швеция",
    219 => "Шпицберген и Ян Майен",
    220 => "Шри-Ланка",
    221 => "Эквадор",
    222 => "Экваториальная Гвинея",
    223 => "Эритрея",
    14 => "Эстония",
    224 => "Эфиопия",
    226 => "Южная Корея",
    227 => "Южно-Африканская Республика",
    228 => "Ямайка",
    229 => "Япония",


    300 => "Голландия",
    301 => "Шотландия",
);

