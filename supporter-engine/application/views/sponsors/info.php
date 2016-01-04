<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

<center>

<form action="" method="post">
<input type="hidden" name="action" value="update"/>
    
<table class="form">

    <tr>
        <td class="label">Имя:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->sp_name) ?>
        </td>
    </tr>
  
    <tr>
        <td class="label">Уровень:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->sp_level) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Рейтинг:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->sp_rating) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Фотография: <nobr>(для анкеты)</nobr></td>
        <td class="elements">

            <?php if(file_exists(STORE_DISK . '/' . STORE_SPONSORS . '/' . $item->sp_id . '.jpg')) { ?>
                <img src="<?php echo url::site() . STORE_WEB ?>/<?php echo STORE_SPONSORS ?>/<?php echo $item->sp_id ?>.jpg" /><br/>
            <?php } else { ?>
                <div class="smallInfo">
                    Изображение не обработано
                </div>
            <?php } ?>
                
            <a href="<?php echo @html::specialchars($item->sp_photo) ?>" target="_target"><?php echo @html::specialchars($item->sp_photo) ?></a><?php if($this->haveAccessByStatus($item->sp_status)) { ?> | <a href="<?php echo url::site(); ?>sponsors/photo/id/<?php echo ($item->sp_id) ?>">Обработать</a><?php } ?>
        </td>
    </tr>
 
    <tr>
        <td class="label">Статус</td>
        <td class="elements">
            <?php echo status::itemCheck($item->sp_status) ?>
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="elements">
            <?php if($this->haveAccessByStatus($item->sp_status)) { ?><input style="display:inline;" type="submit" value="Принять"> | <a href="<?php echo url::site(); ?>sponsors/edit/id/<?php echo ($item->sp_id) ?>">Отредактировать</a> | <?php } ?><a href="#" onclick="history.back(); return false;">Назад</a>
        </td>
    </tr>

</table>

</form>

</center>

<?php } ?>
 