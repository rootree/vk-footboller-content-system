<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>


<center>

<table class="form">

    <tr>
        <td class="label">Игровой сервер:</td>
        <td class="elements">
            <?=($this->template->content->contentGameServer) ? "<span class='serverOk'>Ok</span>" : "<span class='serverError'>Нет соединения</span>"?>
            <div class="smallInfo">
                Ответ: <?=($this->template->content->contentGameServer) ? $this->template->content->contentGameServer : '---'?>
            </div>
        </td>
    </tr>

    <tr>
        <td class="label">Сервер статистики:</td>
        <td class="elements">
            <?=($this->template->content->contentStatisticServer) ? "<span class='serverOk'>Ok</span>" : "<span class='serverError'>Нет соединения</span>"?>
            <div class="smallInfo">
                Ответ: <?=($this->template->content->contentStatisticServer) ? $this->template->content->contentStatisticServer : '---'?>
            </div>
        </td>
    </tr>

    <tr>
        <td class="label">Сервер статики:</td>
        <td class="elements">
            <?=($this->template->content->contentStaticServer) ? "<span class='serverOk'>Ok</span>" : "<span class='serverError'>Нет соединения</span>"?>
            <div class="smallInfo">
                Ответ: <?=($this->template->content->contentStaticServer) ? $this->template->content->contentStaticServer : '---'?>
            </div>
        </td>
    </tr>

</table>
 
</center>