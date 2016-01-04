<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

<form action="" method="post">

<table class="form">
    <!--<tr>
        <td class="label">Проект:</td>
        <td class="elements">
            <label><input type="radio" name="group1" value="Milk"> «Город грешников»</label><br>
            <label><input type="radio" name="group1" value="Milk"> «Что-нибуть ещё»</label><br>
        </td>
    </tr>-->

    <tr>
        <td class="label">Оповещение:</td>
        <td class="elements">
            <textarea name="messageForSend"><?php echo @html::specialchars($_POST['messageForSend']) ?></textarea>
            <div class="smallInfo">
                Внимание! Сообщения у пользователя затирают друг друга, т.е. если приложение вышлет несколько сообщений, пользователь увидит только одно последнее сообщения. Поэтому стоит проверить, может предыдущая рассылка не закончена, создав сейчас новую рассылку есть вероятность что пользователь не увидит предыдущую рассылку.<br/>
                Ограничения: от 4 до 1024 символов.
            </div>
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="elements">
            <input type="submit" value="Разослать">
        </td>
    </tr>

</table>

</form>

</center>