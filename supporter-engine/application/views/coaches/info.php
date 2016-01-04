<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

<center>

<form action="" method="post">
<input type="hidden" name="action" value="update"/>
    
<table class="form">

    <tr>
        <td class="label">Имя:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->ch_name) ?>
        </td>
    </tr>

 

    <tr>
        <td class="label">Фотография:</td>
        <td class="elements">

            <?php if(file_exists(STORE_DISK . '/' . STORE_COACHES . '/' . $item->ch_id . '.jpg')) { ?>
                <img src="<?php echo url::site() . STORE_WEB ?>/<?php echo STORE_COACHES ?>/<?php echo $item->ch_id ?>.jpg" /><br/>
            <?php } else { ?>
                <div class="smallInfo">
                    Изображение не обработано
                </div>
            <?php } ?>
                
            <a href="<?php echo @html::specialchars($item->ch_photo) ?>" target="_target"><?php echo @html::specialchars($item->ch_photo) ?></a><?php if($this->haveAccessByStatus($item->ch_status)) { ?> | <a href="<?php echo url::site(); ?>coaches/photo/id/<?php echo ($item->ch_id) ?>">Обработать</a><?php } ?>
        </td>
    </tr>

    <tr>
        <td class="label">Статус</td>
        <td class="elements">
            <?php echo status::itemCheck($item->ch_status) ?>
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="elements">
            <?php if($this->haveAccessByStatus($item->ch_status)) { ?><input style="display:inline;" type="submit" value="Принять"> | <a href="<?php echo url::site(); ?>coaches/edit/id/<?php echo ($item->ch_id) ?>">Отредактировать</a> | <?php } ?><a href="#" onclick="history.back(); return false;">Назад</a>
        </td>
    </tr>

</table>

</form>

</center>

<?php } ?>
 