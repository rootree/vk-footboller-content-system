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
                <td class="label">Чемпионат:</td>
                <td class="elements">
                    <select name="footballer[champ]">
                        <option value="" disabled="disabled">-</option>
                        <?php foreach ($champ as $champEntry) { ?>
                            <option value="<?php echo $champEntry->cp_id ?>"><?php echo $champEntry->cp_name ?> (<?php echo $GLOBALS['countries'][$champEntry->cp_country_code] ?>)</option>
                        <?php } ?>
                    </select>
                    <div class="smallInfo"><br/></div>
                </td>
            </tr>

    <tr>
        <td class="label">Логотип:</td>
        <td class="elements">
            <input name="footballer[photo]" value="<?php echo @html::specialchars($_POST['footballer']['photo']) ?>" />
            <div class="smallInfo">
                Нужно указать ссылку на логотип, с полным адресов (http://...)
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