<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

<form action="" method="post">

<table class="form">

    <tr>
        <td class="label">Название:</td>
        <td class="elements">
            <input name="footballer[name]" value="<?php echo @html::specialchars($_POST['footballer']['name']) ?>" />
            <div class="smallInfo">
                На русском, до 100 символов.
            </div>
        </td>
    </tr>

    <tr>
        <td class="label">Город:</td>
        <td class="elements">
            <input name="footballer[city]" value="<?php echo @html::specialchars($_POST['footballer']['city']) ?>" /> 
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
                    echo '<option value="' . $countryId . '">' . $countryName . '</option>';
                } ?>

            </select>
            <div class="smallInfo"><br/></div>
        </td>
    </tr>

    <tr>
        <td class="label">Уровень:</td>
        <td class="elements">
            <label><input type="radio" name="footballer[level]" value="1">1</label>
            <label><input type="radio" name="footballer[level]" value="2">2</label>
            <label><input type="radio" name="footballer[level]" value="3">3</label>
            <label><input type="radio" name="footballer[level]" value="4">4</label>
            <label><input type="radio" name="footballer[level]" value="5">5</label>
            <label><input type="radio" name="footballer[level]" value="6">6</label>
            <label><input type="radio" name="footballer[level]" value="7">7</label>
            <label><input type="radio" name="footballer[level]" value="8">8</label>
            <label><input type="radio" name="footballer[level]" value="9">9</label>
            <label><input type="radio" name="footballer[level]" value="10">10</label>
            <div class="smallInfo">
                Нужно выбрать в диапозоне от 1 до 10, 10 - самый лучший.
            </div>
        </td>
    </tr>

    <tr>
        <td class="label">Фотография:</nobr></td>
        <td class="elements">
            <input name="footballer[photo]" value="<?php echo @html::specialchars($_POST['footballer']['photo']) ?>" />
            <div class="smallInfo">
                Нужно указать ссылку на фотографию стадиона, с полным адресов (http://...)
            </div>
        </td>
    </tr>

    <tr>
        <td class="label"></td>
        <td class="elements">
            <input type="submit" value="Добавить">
        </td>
    </tr>

</table>

</form>

</center>