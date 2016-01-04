<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

<center>

<form action="" method="post">
<input type="hidden" name="action" value="update"/>
    
<table class="form">

    <tr>
        <td class="label">Имя:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->ft_name) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Год рождения:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->ft_year) ?>
        </td>
    </tr> 
 
    <tr>
        <td class="label">Амплуа:</td>
        <td class="elements">
            <?php echo status::line($item->ft_line) ?>
        </td>
    </tr>
  
    <tr>
        <td class="label">Фотография: <nobr>(для анкеты)</nobr></td>
        <td class="elements">

            <?php if(file_exists(STORE_DISK . '/' . STORE_AVATARS . '/' . $item->ft_id . '.jpg')) { ?>
                <img src="<?php echo url::site() . STORE_WEB ?>/<?php echo STORE_AVATARS ?>/<?php echo $item->ft_id ?>.jpg" /><br/>
            <?php } else { ?>
                <div class="smallInfo">
                    Изображение не обработано
                </div>
            <?php } ?>
                
            <a href="<?php echo @html::specialchars($item->ft_photo) ?>" target="_target"><?php echo @html::specialchars($item->ft_photo) ?></a><?php if($this->haveAccessByStatus($item->ft_status)) { ?> | <a href="<?php echo url::site(); ?>footballers/photo/id/<?php echo ($item->ft_id) ?>">Обработать</a><?php } ?>
        </td>
    </tr>

    <tr>
        <td class="label">Фотография: <nobr>(лучший гол)</nobr></td>
        <td class="elements">
 
            <?php if(file_exists(STORE_DISK . '/' . STORE_BEST. '/' . $item->ft_id . '.jpg')) { ?>
                <img src="<?php echo url::site() . STORE_WEB ?>/<?php echo STORE_BEST ?>/<?php echo $item->ft_id ?>.jpg" /><br/>
            <?php } else { ?>
                <div class="smallInfo">
                    Изображение не обработано
                </div>
            <?php } ?>

            <a href="<?php echo @html::specialchars($item->ft_photo_best) ?>" target="_target"><?php echo @html::specialchars($item->ft_photo_best) ?></a><?php if($this->haveAccessByStatus($item->ft_status)) { ?> | <a href="<?php echo url::site(); ?>footballers/photo/id/<?php echo ($item->ft_id) ?>/best/1">Обработать</a><?php } ?>
        </td>
    </tr>

    <tr>
        <td class="label">Статус</td>
        <td class="elements">
            <?php echo status::itemCheck($item->ft_status) ?>
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="elements">
            <?php if($this->haveAccessByStatus($item->ft_status)) { ?>
                <input style="display:inline;" type="submit" value="Принять"> | <a href="<?php echo url::site(); ?>footballers/edit/id/<?php echo ($item->ft_id) ?>">Отредактировать</a> |
            <?php } ?><a href="#" onclick="history.back(); return false;">Назад</a>
        </td>
    </tr>

</table>

</form>

</center>

<?php } ?>
 