<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php if(isset($size)): ?>

<script type="text/javascript" language="JavaScript"><!--

    document.photoSizeW = <?php echo $size[0] ?>;
    document.photoSizeH = <?php echo $size[1] ?>;

    document.templateW = <?PHP echo $templateW ?>;
    document.templateH = <?PHP echo $templateH ?>;

//--></script>
<center>

    <form action="" method="post">

        <table class="form">

            <tr>
                <td class="label"></td>
                <td class="elements">
                    <a id="rehook" href="#">Отметить футболиста</a>
                </td>
            </tr>

            <tr>
                <td class="label">
                    <div style="width:<?PHP echo $templateW ?>px;height:<?PHP echo $templateH ?>px;overflow:hidden;">
                        <img id="preview" src="<?php echo @html::specialchars($srcPhoto) ?>" />
                    </div>
                </td>
                <td class="elements">
                    <img id="cropbox" src="<?php echo @html::specialchars($srcPhoto) ?>"/>
                </td>
            </tr>

            <tr>
                <td class="label"></td>
                <td class="elements">
                    <input type="submit" value="Обрезать"> | <a href="<?php echo url::site() ?>sponsors/info/id/<?php echo $item->sp_id ?>">Назад</a>
                </td>
            </tr>
  
        </table>

        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="x2" name="x2" />
        <input type="hidden" id="y2" name="y2" />
        <input type="hidden" id="w" name="w" />
        <input type="hidden" id="h" name="h" />
        <input type="hidden" id="persona_id" name="persona_id" value="0"/>

    </form>

</center>

<?php endif ?>