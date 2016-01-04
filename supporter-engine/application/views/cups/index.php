<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center><?php echo $pagination ?></center>

<?php

if($items->count()) { ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№</th>
       <!--  <th>Дата создания</th>-->
        <th>Содержание</th>
        <th>Статус</th>
        <th>Наполнение</th>
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
        <td class="catalog" width="20"><?php echo $current_fircp_item ?></td> 
        <td><a href="<?php echo url::site(); ?>cups/info/id/<?php echo ($item->cp_id) ?>"><?php echo html::specialchars($item->cp_name) ?></a></td>
        <td class="catalog" width="180"><?php echo status::itemCheck($item->cp_status) ?></td>
        <td class="catalog" width="180"><?php echo html::specialchars($item->cp_complete) ?>%</td>
    </tr>

<?php
    $current_fircp_item ++;
}
?>
 
</table>

<?php } ?>

<center><?php echo $pagination ?></center>