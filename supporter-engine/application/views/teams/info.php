<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if($item) {

?>

<center>

<form action="" method="post">
<input type="hidden" name="action" value="update"/>
    
<table class="form">

    <tr>
        <td class="label">Название:</td>
        <td class="elements">
            <?php echo @html::specialchars($item->tm_name) ?>
        </td>
    </tr>
 
    <tr>
        <td class="label">Фотография:</td>
        <td class="elements">

            <?php if(file_exists(STORE_DISK . '/' . STORE_TEAMS . '/' . $item->tm_id . '.jpg')) { ?>
                <img src="<?php echo url::site() . STORE_WEB ?>/<?php echo STORE_TEAMS ?>/<?php echo $item->tm_id ?>.jpg" /><br/>
            <?php } else { ?>
                <div class="smallInfo">
                    Изображение не обработано
                </div>
            <?php } ?>
                
            <a href="<?php echo @html::specialchars($item->tm_photo) ?>" target="_target"><?php echo @html::specialchars($item->tm_photo) ?></a><?php if($this->haveAccessByStatus($item->tm_status)) { ?> | <a href="<?php echo url::site(); ?>teams/photo/id/<?php echo ($item->tm_id) ?>">Обработать</a><?php } ?>
        </td>
    </tr>
 
    <tr>
        <td class="label">Статус</td>
        <td class="elements">
            <?php echo status::itemCheck($item->tm_status) ?>
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="elements">
            <?php if($this->haveAccessByStatus($item->tm_status)) { ?><input style="display:inline;" type="submit" value="Принять"> | <a href="<?php echo url::site(); ?>teams/edit/id/<?php echo ($item->tm_id) ?>">Отредактировать</a> | <?php } ?><a href="#" onclick="history.back(); return false;">Назад</a>
        </td>
    </tr>

    <tr>
        <td colspan="2"><hr/></td>
    </tr>

    <tr>
        <td class="label">Чемпионат:</td>
        <td class="elements">
            <a href="<?php echo url::site(); ?>cups/info/id/<?php echo ($item->cp_id) ?>"><?php echo html::specialchars($item->cp_name) ?></a>
        </td>
    </tr>

    <tr>
        <td class="label">Наполнение:</td>
        <td class="elements">
            <?php echo status::completeCheck($item->tm_complete) ?>
        </td>
    </tr>

<? if($coaches) { ?>

    <tr>
        <td colspan="2"><hr/></td>
    </tr>

    <tr>
        <td class="label">Имя тренера:</td>
        <td class="elements">
            <?php echo @html::specialchars($coaches->ch_name) ?>
        </td>
    </tr>


    <tr>
        <td class="label">Фотография:</td>
        <td class="elements">

            <?php if(file_exists(STORE_DISK . '/' . STORE_COACHES . '/' . $coaches->ch_id . '.jpg')) { ?>
                <img src="<?php echo url::site() . STORE_WEB ?>/<?php echo STORE_COACHES ?>/<?php echo $coaches->ch_id ?>.jpg" /><br/>
            <?php } else { ?>
                <div class="smallInfo">
                    Изображение не обработано
                </div>
            <?php } ?>

            <a href="<?php echo @html::specialchars($coaches->ch_photo) ?>" target="_target"><?php echo @html::specialchars($coaches->ch_photo) ?></a><?php if($this->haveAccessByStatus($coaches->ch_status)) { ?> | <a href="<?php echo url::site(); ?>coaches/photo/id/<?php echo ($coaches->ch_id) ?>">Обработать</a><?php } ?>
        </td>
    </tr>

    <tr>
        <td class="label">Статус:</td>
        <td class="elements">
            <?php echo status::itemCheck($coaches->ch_status) ?>
        </td>
    </tr>
 
    <tr>
        <td colspan="2"><hr/></td>
    </tr>

<?php } ?>

</table>

</form>



<?php

if($footballers->count()) { ?>
        

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№</th>
        <!-- <th>Дата создания</th>-->
        <th>Состав команды</th> 
        <th>Фото на аватар</th>
        <th>Фото "Лучший гол"</th>
        <th>Статус</th>
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
        <!-- <td class="catalog" width="120"><?php echo date(DATE_FORMAT, strtotime($item->ft_date)) ?></td>-->
        <td><a href="<?php echo url::site(); ?>footballers/info/id/<?php echo ($item->ft_id) ?>"><?php echo html::specialchars($item->ft_name) ?></a></td>

        <td class="catalog" width="180">
            <?php if(file_exists(STORE_DISK . '/' . STORE_AVATARS. '/' . $item->ft_id . '.jpg')) { ?>
                есть
            <?php } else { ?>
                <span class="delete"> нет </span>
            <?php } ?></td>
         <td class="catalog" width="180">   
            <?php if(file_exists(STORE_DISK . '/' . STORE_BEST. '/' . $item->ft_id . '.jpg')) { ?>
                есть
            <?php } else { ?>
                <span class="delete"> нет </span>
            <?php } ?></td>





        <td class="catalog" width="180"><?php echo status::itemCheck($item->ft_status) ?></td>
    </tr>

<?php
    $current_first_item ++;
}
?>

</table>

<?php } ?>



</center>

<?php } ?>
 