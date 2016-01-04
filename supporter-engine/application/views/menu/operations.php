<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_OPERATIONS] & $this->access){ ?>

<td class="side_menu">

<div id="" class="body_left_panel shadow" >

    <b>Операции:</b>
    <ol id="nav">
        <?PHP if($this->accessRules['index'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Operations_Controller::SUBPAGE_MAIN) { ?>id="selected"<?php } ?> title="Создать новую рассылку" href="<?php echo url::site(); ?>operations">Импорт обновлений</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['updates'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Operations_Controller::SUBPAGE_UPDATES) { ?>id="selected"<?php } ?> title="" href="<?php echo url::site(); ?>operations/updates">Обновить прогресс</a></li>
        <?PHP } ?>
    </ol>
 
</div>

</td>

<?PHP } ?>