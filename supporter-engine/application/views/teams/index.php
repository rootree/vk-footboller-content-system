<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center><?php echo $pagination ?></center>

<?php

if($items->count()) { ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№</th>
        <!-- <th>Дата создания</th>-->
        <th>Команда</th>
        <th>Чемпионат</th>
        <th>Тренер</th>
        <th>Кол.фут.</th>
        <th>Уровень</th>
        <th>Наполнение</th>
        <th>Статус</th>
    </tr>

<?php

$count = 0;

foreach ($items as $item) {

    $count ++;

    $class = "";

    if ($count % 2 == 0) {
            $class="modTwo";
    }
  
?>

    <tr class="hightLight <?php echo $class ?>" >
        <td class="catalog" width="20"><?php echo $current_first_item ?></td> 
        <td><a href="<?php echo url::site(); ?>teams/info/id/<?php echo ($item->tm_id) ?>"><?php echo html::specialchars($item->tm_name) ?></a></td>
        <td  width="320"><a href="<?php echo url::site(); ?>cups/info/id/<?php echo ($item->cp_id) ?>"><?php echo html::specialchars($item->cp_name) ?></a></td>

        <td   width="150">
            <? if(!empty($item->ch_name)) { ?>
                <a href="<?php echo url::site(); ?>coaches/info/id/<?php echo ($item->ch_id) ?>"><?php echo html::specialchars($item->ch_name) ?></a></td>
            <? } else { ?>
                -
            <? } ?>
        <td class="catalog" width="20"><?php echo html::specialchars($item->footballers_count) ?></td>
        
        <td class="catalog" width="20"><?php echo html::specialchars($item->cp_level) ?></td>
        <td class="catalog" width="100"><?php echo status::completeCheck($item->tm_complete) ?></td>

        <td class="catalog" width="180"><?php echo status::itemCheck($item->tm_status) ?></td>
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>

<?php } ?>

<center><?php echo $pagination ?></center>