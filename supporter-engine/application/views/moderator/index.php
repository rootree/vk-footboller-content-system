<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

<form action="" method="post">

<table class="form">

    <tr>
        <td class="label">Поиск по ID:</td>
        <td class="elements">
            <input name="userId" value="<?php echo @html::specialchars($_POST['userId']) ?>" />
            <div class="smallInfo">
                Укажите уникальный номер игрока
            </div>
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="elements">
            <input type="submit" value="Поиск">
        </td>
    </tr>

</table>

</form>

</center>


<? if(isset($team)){ ?>
        
<center>

<h3><?=$team->userName?></h3>

<table class="form">

    <tr>
        <td class="label"><div class="smallInfo">Название команды:</div></td>
        <td class="elements"><?=$team->teamName?>
        </td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo"><?=$team->teamLogoId?></div></td>
        <td class="elements"><a target="_blank"  href="<?php echo url::site(); ?>teams/info/id/<?php echo ($team->teamLogoId) ?>">
            <img src="<?php echo url::site() . STORE_WEB ?>/<?php echo STORE_TEAMS ?>/<?php echo $team->teamLogoId ?>.jpg" /></a>
        </td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Тренер:</div></td>
        <td class="elements">
            ID:<?=$team->trainerId?>
            <? if($team->trainerId){ ?> <br/>
            <a target="_blank" href="<?php echo url::site(); ?>coaches/info/id/<?php echo ($team->trainerId) ?>">
                <img src="<?php echo url::site() . STORE_WEB ?>/<?php echo STORE_COACHES ?>/<?php echo $team->trainerId ?>.jpg" />
            </a><? } ?>
        </td>
    </tr>

    <tr>
        <td class="elements" colspan="2"><hr/></td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Уровень:</div></td>
        <td class="elements"><?=$team->level?>
        </td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Опыт:</div></td>
        <td class="elements"><?=$team->experience?>
        </td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Очки обучения:</div></td>
        <td class="elements"><?=$team->studyPoints?>
        </td>
    </tr>

    <tr>
        <td class="elements" colspan="2"><hr/></td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Ингейм:</div></td>
        <td class="elements"><?=$team->money?>
        </td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Реалы:</div></td>
        <td class="elements"><?=$team->realMoney?>
        </td>
    </tr>

    <tr>
        <td class="elements" colspan="2"><hr/></td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Энергия:</div></td>
        <td class="elements"><?=$team->energy?>
        </td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Энергии всего:</div></td>
        <td class="elements"><?=$team->energyMax?>
        </td>
    </tr>

    <tr>
        <td class="elements" colspan="2"><hr/></td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Нападение:</div></td>
        <td class="elements"><?=$team->paramForward?>
        </td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Полузащита:</div></td>
        <td class="elements"><?=$team->paramHalf?>
        </td>
    </tr>

    <tr>
        <td class="label"><div class="smallInfo">Защита:</div></td>
        <td class="elements"><?=$team->paramSafe?>
        </td>
    </tr>

    <tr>
        <td class="elements" colspan="2"><hr/></td>
    </tr>

</table>

<? if(isset($team->footballers)){ ?>

<h3>Состав команды</h3>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№</th>
        <th>ID футболиста</th>
        <th>Уровень</th>
        <th>Друг</th>
        <th>В игре</th>
    </tr>

<?php

$count = 0;
$current_first_item = 1;

foreach ($team->footballers as $item) {

    $count ++;

    $class = "";

    if ($count % 2 == 0) {
            $class="modTwo";
    }

?>

    <tr class="hightLight <?php echo $class ?>" >
        <td class="catalog" width="20"><?php echo $current_first_item ?></td> 
        <td><a target="_blank" href="<?php echo url::site(); ?>footballers/info/id/<?php echo ($item->id) ?>"><?php echo html::specialchars($item->id) ?></a></td>
        <td class="catalog" width="180"><?php echo ($item->level) ?></td>
        <td class="catalog" width="180"><?php echo (($item->isFriend) ? "<b>Да</b>" : "Нет") ?></td>
        <td class="catalog" width="180"><?php echo (($item->isActive) ? "<b>Да</b>" : "Нет") ?></td>
    </tr>

<?php
    $current_first_item ++;
}
?>

</table>

<? } ?>

<? if(isset($team->sponsors)){ ?>

<h3>Спонсоры команды</h3>

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№</th>
        <th>ID спонсора</th>
        <th>Энергия</th>
    </tr>

<?php

$count = 0;
$current_first_item = 1;



foreach ($team->sponsors as $item) {

    $count ++;

    $class = "";

    if ($count % 2 == 0) {
            $class="modTwo";
    }

?>

    <tr class="hightLight <?php echo $class ?>" >
        <td class="catalog" width="20"><?php echo $current_first_item ?></td>
        <td><a target="_blank" href="<?php echo url::site(); ?>sponsors/info/id/<?php echo ($item->id) ?>"><?php echo html::specialchars($item->id) ?></a></td>
        <td class="catalog" width="180"><?php echo ($item->energy) ?></td>
    </tr>

<?php
    $current_first_item ++;
}
?>

</table>


</center>

<? }} ?>

