<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center><?php echo $pagination ?></center>

<?php

if($items->count()) { ?>

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
        <td class="catalog" width="120"><?php echo date(DATE_FORMAT, strtotime($item->st_date)) ?></td>
        <td><a href="<?php echo url::site(); ?>stadiums/info/id/<?php echo ($item->st_id) ?>"><?php echo html::specialchars($item->st_name) ?></a></td>
        <td class="catalog" width="180"><?php echo status::itemCheck($item->st_status) ?></td>
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>

<?php } ?>

<center><?php echo $pagination ?></center>