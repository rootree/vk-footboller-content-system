<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>
 
<form action="" method="post">

<table class="form">

    <tr>
        <td class="label">Название:</td>
        <td class="elements">
            <input name="footballer[name]" value="<?php echo @html::specialchars($item->sp_name) ?>" />
            <div class="smallInfo">
                На русском, до 100 символов.
            </div>
        </td>
    </tr>
  
    <tr>
        <td class="label">Уровень:</td>
        <td class="elements">
            <label><input type="radio" name="footballer[level]" value="1" <?php echo ($item->sp_level == '1' ? "checked" : "") ?> >1</label>
            <label><input type="radio" name="footballer[level]" value="2" <?php echo ($item->sp_level == '2' ? "checked" : "") ?> >2</label>
            <label><input type="radio" name="footballer[level]" value="3"  <?php echo ($item->sp_level == '3' ? "checked" : "") ?> >3</label>
            <label><input type="radio" name="footballer[level]" value="4"  <?php echo ($item->sp_level == '4' ? "checked" : "") ?> >4</label>
            <label><input type="radio" name="footballer[level]" value="5"  <?php echo ($item->sp_level == '5' ? "checked" : "") ?> >5</label>
            <label><input type="radio" name="footballer[level]" value="6"  <?php echo ($item->sp_level == '6' ? "checked" : "") ?> >6</label>
            <label><input type="radio" name="footballer[level]" value="7"  <?php echo ($item->sp_level == '7' ? "checked" : "") ?> >7</label>
            <label><input type="radio" name="footballer[level]" value="8" <?php echo ($item->sp_level == '8' ? "checked" : "") ?> >8</label>
            <label><input type="radio" name="footballer[level]" value="9"  <?php echo ($item->sp_level == '9' ? "checked" : "") ?> >9</label>
            <label><input type="radio" name="footballer[level]" value="10"  <?php echo ($item->sp_level == '10' ? "checked" : "") ?> >10</label>
            <div class="smallInfo">
                Нужно выбрать в диапозоне от 1 до 10, 10 - самый лучший.
            </div>
        </td>
    </tr>

    <tr>
        <td class="label">Рейтинг:</td>
        <td class="elements">
            <label><input type="radio" name="footballer[rating]" value="1"  <?php echo ($item->sp_rating == 1 ? "checked" : "") ?> >1</label>
            <label><input type="radio" name="footballer[rating]" value="2"  <?php echo ($item->sp_rating == 2 ? "checked" : "") ?> >2</label>
            <label><input type="radio" name="footballer[rating]" value="3"  <?php echo ($item->sp_rating == 3 ? "checked" : "") ?> >3</label>
            <label><input type="radio" name="footballer[rating]" value="4"  <?php echo ($item->sp_rating == 4 ? "checked" : "") ?> >4</label>
            <label><input type="radio" name="footballer[rating]" value="5" <?php echo ($item->sp_rating == 5 ? "checked" : "") ?> >5</label>
            <div class="smallInfo">
                Рейтинг влияет на будушую цену. Чем он больше, тем выше цена.
            </div>
        </td>
    </tr>

    <tr>
        <td class="label">Фотография: <nobr>(для анкеты)</nobr></td>
        <td class="elements">
            <input name="footballer[photo]" value="<?php echo @html::specialchars($item->sp_photo) ?>" />
            <div class="smallInfo">
                Нужно указать ссылку на фотографию спонсора, с полным адресов (http://...)
            </div>
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="elements">
            <input type="submit" value="Редактировать"> | <a href="#" onclick="history.back(); return false;">Назад</a>
        </td>
    </tr>

</table>

</form>

</center>