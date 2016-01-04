<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if($teams->count()): ?>

<center>

    <form action="./" method="post">

        <table class="form">

            <tr>
                <td class="label">Имя:</td>
                <td class="elements">
                    <input name="footballer[name]" value="<?php echo @html::specialchars($_POST['footballer']['name']) ?>" />
                    <div class="smallInfo">
                        На русском, до 100 символов.
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label">Год рождения:</td>
                <td class="elements">
                    <input name="footballer[year]" value="<?php echo @html::specialchars($_POST['footballer']['year']) ?>" />
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

                            <option value="<?php echo $champEntry->tm_id ?>"><?php echo $champEntry->tm_name ?></option>


                        <?php } ?>

                    </select>
                    <div class="smallInfo"><br/></div>
                </td>
            </tr>

            <tr>
                <td class="label">Амплуа:</td>
                <td class="elements">

                    <label><input type="radio" name="footballer[line]" value="<?php echo FOOTBALLER_LINE_FORWARD?>">Нападающий</label>
                    <label><input type="radio" name="footballer[line]" value="<?php echo FOOTBALLER_LINE_HALFSAFER?>">Полузащитник</label>
                    <label><input type="radio" name="footballer[line]" value="<?php echo FOOTBALLER_LINE_SAFER?>">Защитник</label>
                    <label><input type="radio" name="footballer[line]" value="<?php echo FOOTBALLER_LINE_GOALKEEPER?>">Вратарь</label>

                    <div class="smallInfo"><br/></div>
                </td>
            </tr>

  <!--          <tr>
                <td class="label">Рейтинг:</td>
                <td class="elements">
                    <label><input type="radio" name="footballer[rating]" value="1">1</label>
                    <label><input type="radio" name="footballer[rating]" value="2">2</label>
                    <label><input type="radio" name="footballer[rating]" value="3">3</label>
                    <label><input type="radio" name="footballer[rating]" value="4">4</label>
                    <label><input type="radio" name="footballer[rating]" value="5">5</label>
                    <div class="smallInfo">
                        Рейтинг влияет на будушую цену. Чем он больше, тем выше цена.
                    </div>
                </td>
            </tr>
-->
            <tr>
                <td class="label">Фотография: <nobr>(для анкеты)</nobr></td>
                <td class="elements">
                    <input name="footballer[photo]" value="<?php echo @html::specialchars($_POST['footballer']['photo']) ?>" />
                    <div class="smallInfo">
                        Нужно указать ссылку на фотографию игрока, с полным адресов (http://...)
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label">Фотография: <nobr>(лучший гол)</nobr></td>
                <td class="elements">
                    <input name="footballer[photo_best]" value="<?php echo @html::specialchars($_POST['footballer']['photo_best']) ?>" />
                    <div class="smallInfo">
                        http://...)
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

<?php else: ?>

<div class="input_info shadow">
    Перед заведение игроков стоит завести команды, в которых они будут играть.
</div>

<?php endif ?>