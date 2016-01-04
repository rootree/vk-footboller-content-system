<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center><?php echo $pagination ?></center>

<?php

if(count($items)) { ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№</th>
        <th>Дата создания</th>
        <th>Содержание</th>
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
        <td class="catalog" width="120"><?php echo date(DATE_FORMAT, strtotime($item->notify_date)) ?></td>
        <td><?php echo html::specialchars($item->notify_message) ?></td>
        <td class="catalog" width="180"><?php echo status::notify($item->notify_status) ?></td>
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>

<?php } ?>

<center><?php echo $pagination ?></center>