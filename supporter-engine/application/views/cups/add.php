<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

<form action="" method="post">

<table class="form">

    <tr>
        <td class="label">Название:</td>
        <td class="elements">
            <input name="footballer[name]"  size="50" value="<?php echo @html::specialchars($_POST['footballer']['name']) ?>" />
            <div class="smallInfo">
                На русском, до 100 символов.
            </div>
        </td>
    </tr>
    <tr>
        <td class="label">Использовать:</td>
        <td class="elements">
            <input type="checkbox" name="footballer[used]" value="1" /> Да

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
        <td class="label">Райтинг:</td>
        <td class="elements">
            <input name="footballer[moder_rating]" value="<?php echo @html::specialchars($_POST['footballer']['moder_rating']) ?>" />
            <div class="smallInfo">
                Оценка аналитика.
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