<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center><?php echo $pagination ?></center>

<?php

if($items->count()) { ?>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№</th>
       <!--  <th>Дата создания</th>-->
        <th>Футболисты</th>
        <th>Команда</th> 
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
        <!-- <td class="catalog" width="120"><?php echo date(DATE_FORMAT, strtotime($item->ft_date)) ?></td>-->
        <td><a href="<?php echo url::site(); ?>footballers/info/id/<?php echo ($item->ft_id) ?>"><?php echo html::specialchars($item->ft_name) ?></a></td>

        <td  width="320"><a href="<?php echo url::site(); ?>teams/info/id/<?php echo ($item->tm_id) ?>"><?php echo html::specialchars($item->tm_name) ?></a></td>

        <td class="catalog" width="180"><?php echo status::itemCheck($item->ft_status) ?></td>
    </tr>

<?php
    $current_first_item ++;
}
?>
 
</table>

<?php } ?>

<center><?php echo $pagination ?></center>