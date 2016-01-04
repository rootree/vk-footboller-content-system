<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<center>

<form action="" method="post">

<table class="form">

    <tr>
        <td class="label">Логин:</td>
        <td class="elements">
            <input name="singin[mail]" value="<?php echo @html::specialchars($_POST['singin']['mail']) ?>" />
            <div class="smallInfo">
                Для регистрации обратитесь к администратору.
            </div>
        </td>
    </tr>
    
    <tr>
        <td class="label">Пароль:</td>
        <td class="elements">
            <input name="singin[word]" value="<?php echo @html::specialchars($_POST['singin']['word']) ?>" type="password" />
            <div class="smallInfo">
                Забыли пароль, обратитесь к администратору.
            </div>
        </td>
    </tr>
 
    <tr>
        <td class="label"></td>
        <td class="elements">
            <input type="submit" value="Авторизоваться">
        </td>
    </tr>

</table>

</form>

</center>