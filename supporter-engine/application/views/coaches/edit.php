<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <table class="form">

            <tr>
                <td class="label">Имя:</td>
                <td class="elements">
                    <input name="footballer[name]" value="<?php echo @html::specialchars($item->ch_name) ?>" />
                    <div class="smallInfo">
                        На русском, до 100 символов.
                    </div>
                </td>
            </tr>



            <tr>
                <td class="label">Команда:</td>
                <td class="elements">
                    <select name="footballer[team]">
                        <optgroup  label="">
                        <option value="" disabled="disabled">-</option>
                    <? $lastChampName = null; ?>
                    <?php foreach ($teams as $champEntry) {  ?>

                        <? if ($champEntry->cp_id != $lastChampName ) { $lastChampName = $champEntry->cp_id; ?>
                            </optgroup> <optgroup label="<?php echo $champEntry->cp_name ?> (<?php echo $GLOBALS['countries'][$champEntry->cp_country_code] ?>)">
                        <? } ?>

                        <option  <?php if( $champEntry->tm_id == $item->tm_id) { ?>selected="selected" <?php } ?> value="<?php echo $champEntry->tm_id ?>"><?php echo $champEntry->tm_name ?></option>


                        <?php } ?>

                    </select>
                    <div class="smallInfo"><br/></div>
                </td>
            </tr>

        

            <tr>
                <td class="label">Фотография:</td>
                <td class="elements">
                    <input name="footballer[photo]" value="<?php echo @html::specialchars($item->ch_photo) ?>" />
                    <div class="smallInfo">
                        Нужно указать ссылку на фотографию тренера, с полным адресов (http://...)
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