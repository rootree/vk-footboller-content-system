<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

<form action="" method="post">

<table class="form">

    <tr>
        <td class="label">Имя:</td>
        <td class="elements">
            <input name="footballer[name]" size="50" value="<?php echo @html::specialchars($item->cp_name) ?>" />
            <div class="smallInfo">
                На русском, до 100 символов.
            </div>
        </td>
    </tr>
    
    <tr>
        <td class="label">Использовать:</td>
        <td class="elements">
            <input  <?php echo ($item->cp_used) ? 'checked="checked"' : '' ?>  type="checkbox" name="footballer[used]" value="<?php echo @html::specialchars($item->cp_used) ?>" /> Да

        </td>
    </tr>
 
    <tr>
        <td class="label">Страна:</td>
        <td class="elements">
            <select name="footballer[country]">
                <?php foreach ($GLOBALS['countries'] as $countryId => $countryName){
                    echo '<option value="' . $countryId . '" ' . ($item->cp_country_code == $countryId ? "selected" : "") . '>' . $countryName . '</option>';
                } ?>

            </select>
            <div class="smallInfo"><br/></div>
        </td>
    </tr>

    <tr>
        <td class="label">Райтинг:</td>
        <td class="elements">
            <input name="footballer[moder_rating]" value="<?php echo @html::specialchars($item->moder_rating) ?>" />
            <div class="smallInfo">
                Оценка аналитика.
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