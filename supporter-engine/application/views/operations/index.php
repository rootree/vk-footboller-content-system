<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<center>

    <form action="" method="post">

        <input name="operations" value="0x1664" type="hidden"> 

        <table class="form">

            <tr>
                <td class="label">&nbsp;</td>
                <td class="elements">
                    <input type="submit" value="Обновить сервер">
                    <div class="smallInfo">
                        Операция опасная и требует концентрации. Пред обновление надо выкинуть всех пользоватлей из on-line
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label">&nbsp;</td>
                <td class="elements">
                    <a href="<?=STORE_WEB?>/itemsConf.xml">itemsConf.xml</a>
                    <div class="smallInfo">
                        Скачать клиентский фаил
                    </div>
                </td>
            </tr>

        </table>

    </form>

</center>