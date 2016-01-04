<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

<form action="" method="post">

<table class="form">

    <tr>
        <td class="label">Имя:</td>
        <td class="elements">
            <input name="footballer[name]" value="<?php echo @html::specialchars($item->st_name) ?>" />
            <div class="smallInfo">
                На русском, до 100 символов.
            </div>
        </td>
    </tr>

    <tr>
        <td class="label">Город:</td>
        <td class="elements">
            <input name="footballer[city]" value="<?php echo @html::specialchars($item->st_city) ?>" />
            <div class="smallInfo">
                На русском, до 100 символов.
            </div>
        </td>
    </tr>

    <tr>
        <td class="label">Страна:</td>
        <td class="elements">
            <select name="footballer[country]">
                <?php foreach ($GLOBALS['countries'] as $countryId => $countryName){
                    echo '<option value="' . $countryId . '" ' . ($item->st_country_code == $countryId ? "selected" : "") . '>' . $countryName . '</option>';
                } ?>

            </select>
            <div class="smallInfo"><br/></div>
        </td>
    </tr>

    <tr>
        <td class="label">Уровень:</td>
        <td class="elements">
            <label><input type="radio" name="footballer[level]" value="1" checked="<?php echo ($item->st_level == 1 ? "checked" : "") ?>" >1</label>
            <label><input type="radio" name="footballer[level]" value="2" checked="<?php echo ($item->st_level == 2 ? "checked" : "") ?>" >2</label>
            <label><input type="radio" name="footballer[level]" value="3" checked="<?php echo ($item->st_level == 3 ? "checked" : "") ?>" >3</label>
            <label><input type="radio" name="footballer[level]" value="4" checked="<?php echo ($item->st_level == 4 ? "checked" : "") ?>" >4</label>
            <label><input type="radio" name="footballer[level]" value="5" checked="<?php echo ($item->st_level == 5 ? "checked" : "") ?>" >5</label>
            <label><input type="radio" name="footballer[level]" value="6" checked="<?php echo ($item->st_level == 6 ? "checked" : "") ?>" >6</label>
            <label><input type="radio" name="footballer[level]" value="7" checked="<?php echo ($item->st_level == 7 ? "checked" : "") ?>" >7</label>
            <label><input type="radio" name="footballer[level]" value="8" checked="<?php echo ($item->st_level == 8 ? "checked" : "") ?>" >8</label>
            <label><input type="radio" name="footballer[level]" value="9" checked="<?php echo ($item->st_level == 9 ? "checked" : "") ?>" >9</label>
            <label><input type="radio" name="footballer[level]" value="10" checked="<?php echo ($item->st_level == 10 ? "checked" : "") ?>" >10</label>
            <div class="smallInfo">
                Нужно выбрать в диапозоне от 1 до 10, 10 - самый лучший.
            </div>
        </td>
    </tr>

    <tr>
        <td class="label">Фотография: <nobr>(для анкеты)</nobr></td>
        <td class="elements">
            <input name="footballer[photo]" value="<?php echo @html::specialchars($item->st_photo) ?>" />
            <div class="smallInfo">
                Нужно указать ссылку на фотографию стадиона, с полным адресов (http://...)
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