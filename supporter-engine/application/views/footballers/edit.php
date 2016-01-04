<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <table class="form">

            <tr>
                <td class="label">Имя:</td>
                <td class="elements">
                    <input name="footballer[name]" value="<?php echo @html::specialchars($item->ft_name) ?>" />
                    <div class="smallInfo">
                        На русском, до 100 символов.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label">Год рождения:</td>
                <td class="elements">
                    <input name="footballer[year]" value="<?php echo @html::specialchars($item->ft_year) ?>" />
                    <div class="smallInfo">
                         4-е цифры.
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
                <td class="label">Амплуа:</td>
                <td class="elements">

                    <label><input type="radio" name="footballer[line]" value="<?php echo FOOTBALLER_LINE_FORWARD?>" checked="<?php echo ($item->ft_line == FOOTBALLER_LINE_FORWARD ? "checked" : "") ?>">Нападающий</label>
                    <label><input type="radio" name="footballer[line]" value="<?php echo FOOTBALLER_LINE_HALFSAFER?>" checked="<?php echo ($item->ft_line == FOOTBALLER_LINE_FORWARD ? "checked" : "") ?>" >Полузащитник</label>
                    <label><input type="radio" name="footballer[line]" value="<?php echo FOOTBALLER_LINE_SAFER?>" checked="<?php echo ($item->ft_line == FOOTBALLER_LINE_FORWARD ? "checked" : "") ?>" >Защитник</label>
                    <label><input type="radio" name="footballer[line]" value="<?php echo FOOTBALLER_LINE_GOALKEEPER?>" checked="<?php echo ($item->ft_line == FOOTBALLER_LINE_FORWARD ? "checked" : "") ?>" >Вратарь</label>

                    <div class="smallInfo"><br/></div>
                </td>
            </tr>
 

            <tr>
                <td class="label">Фотография: <nobr>(для анкеты)</nobr></td>
                <td class="elements">
                    <input name="footballer[photo]" value="<?php echo @html::specialchars($item->ft_photo) ?>" />
                    <div class="smallInfo">
                        Нужно указать ссылку на фотографию игрока, с полным адресов (http://...)
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label">Фотография: <nobr>(лучший гол)</nobr></td>
                <td class="elements">
                    <input name="footballer[photo_best]" value="<?php echo @html::specialchars($item->ft_photo_best) ?>" />
                    <div class="smallInfo">
                        http://...)
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