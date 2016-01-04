<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

<form action="/moderator/log" method="post" >

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

<h3><?=$team->userName?> (<?=$team->teamName?>)</h3>
 

<table id="bin" cellspacing="0" cellpadding="5" >

    <tr>
        <th>№</th>
        <th>Дата</th>
        <th>Команда</th>
        <th>Получено</th>
        <th>Отправлено</th>
    </tr>

<?php

$count = 0;
$current_first_item = 1;

foreach ($requests as $request) {

    $date = $request->getElementsByTagName( "date" )->item(0)->nodeValue;
    $command = $request->getElementsByTagName( "command" )->item(0)->nodeValue;
    $body = $request->getElementsByTagName( "body" )->item(0)->nodeValue;
    $responce = $request->getElementsByTagName( "responce" )->item(0)->nodeValue;

    $count ++;

    $class = "";

    if ($count % 2 == 0) {
            $class="modTwo";
    }

?>

    <tr class="hightLight <?php echo $class ?>" >
        <td class="catalog" width="20"><?php echo $current_first_item ?></td> 
        <td class="catalog" width="180"><?=$date?></td>
        <td class="catalog" width="180"><?php echo ($command) ?></td>
        <td ><a href='#' onclick='
if(document.getElementById("history<?=$current_first_item?>").style.display == "block"){
    document.getElementById("history<?=$current_first_item?>").style.display = "none";
}else{
    document.getElementById("history<?=$current_first_item?>").style.display = "block";
};return false;'>Показать</a>
            <div id='history<?=$current_first_item?>' style="display:none;"><?php echo ($body) ?></div></td>
        <td ><a href='#' onclick='
if(document.getElementById("historyRR<?=$current_first_item?>").style.display == "block"){
    document.getElementById("historyRR<?=$current_first_item?>").style.display = "none";
}else{
    document.getElementById("historyRR<?=$current_first_item?>").style.display = "block";
};return false;'>Показать</a> 
            <div id='historyRR<?=$current_first_item?>' style="display:none;"><?php echo ($responce) ?></div></td>

    </tr>
<?php
    $current_first_item ++;
}
?>

</table>



</center>

<? } ?>

