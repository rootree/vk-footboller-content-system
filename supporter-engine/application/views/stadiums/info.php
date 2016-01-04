<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

<center>

<form action="" method="post">
<input type="hidden" name="action" value="update"/>
    
<table class="form">

    <tr>
        <td class="label">Имя:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->st_name) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Описание:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->st_city) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Страна:</td>
        <td class="elements">
            <?php echo $GLOBALS['countries'][$item->st_country_code] ?>
        </td>
    </tr>

    <tr>
        <td class="label">Уровень:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->st_level) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Фотография: <nobr>(для анкеты)</nobr></td>
        <td class="elements">

            <?php if(file_exists(STORE_DISK . '/' . STORE_STADIUMS . '/' . $item->st_id . '.jpg')) { ?>
                <img src="<?php echo url::site() . STORE_WEB ?>/<?php echo STORE_STADIUMS ?>/<?php echo $item->st_id ?>.jpg" /><br/>
            <?php } else { ?>
                <div class="smallInfo">
                    Изображение не обработано
                </div>
            <?php } ?>
                
            <a href="<?php echo @html::specialchars($item->st_photo) ?>" target="_target"><?php echo @html::specialchars($item->st_photo) ?></a><?php if($this->haveAccessByStatus($item->st_status)) { ?> | <a href="<?php echo url::site(); ?>stadiums/photo/id/<?php echo ($item->st_id) ?>">Обработать</a><?php } ?>
        </td>
    </tr> 

    <tr>
        <td class="label">Статус</td>
        <td class="elements">
            <?php echo status::itemCheck($item->st_status) ?>
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="elements">
            <?php if($this->haveAccessByStatus($item->st_status)) { ?><input style="display:inline;" type="submit" value="Принять"> | <a href="<?php echo url::site(); ?>stadiums/edit/id/<?php echo ($item->st_id) ?>">Отредактировать</a> | <?php } ?><a href="#" onclick="history.back(); return false;">Назад</a>
        </td>
    </tr>

</table>

</form>

</center>

<?php } ?>
 