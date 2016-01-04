<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_MODER] & $this->access){ ?>

<td class="side_menu">

<div id="" class="body_left_panel shadow" >

    <b>Операции:</b>
    <ol id="nav">
        <?PHP if($this->accessRules['index'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Moderator_Controller::SUBPAGE_MAIN) { ?>id="selected"<?php } ?> title="Создать новую рассылку" href="<?php echo url::site(); ?>moderator">Информация</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['log'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Moderator_Controller::SUBPAGE_LOG) { ?>id="selected"<?php } ?> title="Создать новую рассылку" href="<?php echo url::site(); ?>moderator/log">Логи</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['notify'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Moderator_Controller::SUBPAGE_NOTIFY) { ?>id="selected"<?php } ?> title="Создать новую рассылку" href="<?php echo url::site(); ?>moderator/notify">Добавить рассылку</a></li>
        <?PHP } ?>
        <?PHP if($this->accessRules['history'] & $this->access){ ?>
            <li><a <?php if($selected_subpage == Moderator_Controller::SUBPAGE_HISTORY) { ?>id="selected"<?php } ?> title="Создать новую рассылку" href="<?php echo url::site(); ?>moderator/history">История рассылок</a></li>
        <?PHP } ?>
    </ol>

</div>

</td>

<?PHP } ?>