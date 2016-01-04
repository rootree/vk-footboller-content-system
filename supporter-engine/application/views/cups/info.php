<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(count($item)) { ?>

<center>

<form action="" method="post">
<input type="hidden" name="action" value="update"/>
    
<table class="form">

    <tr>
        <td class="label">Имя:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->cp_name) ?>
        </td>
    </tr>

    <tr>
        <td class="label">Используеться:</td>
        <td class="elements">
            <?php echo ($item->cp_used) ? 'Да' : 'Нет' ?>
        </td>
    </tr>
 

    <tr>
        <td class="label">Страна:</td>
        <td class="elements">
            <?php echo $GLOBALS['countries'][$item->cp_country_code] ?>
        </td>
    </tr> 
    <tr>
        <td class="label">Рейтинг:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->moder_rating) ?>
        </td>
    </tr>
 

    <tr>
        <td class="label">Статус</td>
        <td class="elements">
            <?php echo status::itemCheck($item->cp_status) ?>
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="elements">
            <?php if($this->haveAccessByStatus($item->cp_status)) { ?><input style="display:inline;" type="submit" value="Принять"> | <a href="<?php echo url::site(); ?>cups/edit/id/<?php echo ($item->cp_id) ?>">Отредактировать</a> | <?php } ?><a href="#" onclick="history.back(); return false;">Назад</a>
        </td>
    </tr>

</table>

</form>

<?php

if($footballers->count()) { ?>


<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№</th>
        <th>Команда</th>
        <th>Наполнение</th>
        <th>Тренер</th>
        <th>Кол.фут.</th>
    </tr>

<?php

$count = 0;
$current_first_item = 1;

foreach ($footballers as $item) {

    $count ++;

    $class = "";

    if ($count % 2 == 0) {
            $class="modTwo";
    }

?>

    <tr class="hightLight <?php echo $class ?>" >
        <td class="catalog" width="20"><?php echo $current_first_item ?></td>
        <td><a href="<?php echo url::site(); ?>teams/info/id/<?php echo ($item->tm_id) ?>"><?php echo html::specialchars($item->tm_name) ?></a></td>

        <td class="catalog" width="100"><?php echo status::completeCheck($item->tm_complete) ?></td>

        <td   width="150">
            <? if(!empty($item->ch_name)) { ?>
                <a href="<?php echo url::site(); ?>coaches/info/id/<?php echo ($item->ch_id) ?>"><?php echo html::specialchars($item->ch_name) ?></a></td>
            <? } else { ?>
                -
            <? } ?>
        <td class="catalog" width="20"><?php echo html::specialchars($item->footballers_count) ?></td>

    </tr>

<?php
    $current_first_item ++;
}
?>

</table>

<?php } ?>
    
</center>

<?php } ?>
 