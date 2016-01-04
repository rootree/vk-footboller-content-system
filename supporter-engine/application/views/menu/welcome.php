<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?PHP if($GLOBALS['ACCESS'][PAGE_MAIN] & $this->access){ ?>

<td class="side_menu">

<div id="" class="body_left_panel shadow" >

    <b>Платежи:</b>
    <ol id="nav">
        <li><a title=""   href="#graph_type_6">По часам</a></li>
        <li><a title="On-"  href="#graph_type_7">По дням</a></li>
    </ol>

    <br/>

    <b>Пользователи:</b>
    <ol id="nav">
        <li><a title=""   href="#graph_type_1">DAU</a></li>
        <li><a title="On-"  href="#graph_type_4">MAU</a></li>
        <li><a title=""   href="#graph_type_2">Активные пользователи</a></li>
        <li><a title=""   href="#graph_type_5">On-line пользователи</a></li>
        <li><a title=""   href="#graph_type_3">Регистрации</a></li>
    </ol>

    <br/>
    <a title="Duty schedule" id="selected" href="#">Всё в одном</a>

</div>

</td>

<?PHP } ?>