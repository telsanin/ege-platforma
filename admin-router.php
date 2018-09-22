<?php

/*
административная часть сайта
*/

//$sParametr1 = explode( '/', $sUrl )[0];
$sParametr2 = explode( '/', $sUrl )[1];
$sParametr3 = explode( '/', $sUrl )[2];
$sParametr4 = explode( '/', $sUrl )[3];
$sParametr5 = explode( '/', $sUrl )[4];

//http://ege-platforma.local/telsanin/zadachi/matematika/1
if($sParametr2 == "zadachi") {
    $sPredmet=$sParametr3;
    $iNomerZadaniya=$sParametr4;
    include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/zadachi.php";
}
//http://ege-platforma.local/telsanin/egor/matematika/1
else{
    //http://ege-platforma.local/telsanin/egor/matematika/1/urok
    if($sParametr4 == "urok"){
        $sUchenik=$sParametr2;
        $sPredmet=$sParametr3;
        $iNomerZadaniya=$sParametr4;
        include_once $_SERVER['DOCUMENT_ROOT']."/admin/urok.php";
    }
    //http://ege-platforma.local/telsanin/egor/matematika/1/dz
    elseif($sParametr4 == "dz"){
        $sUchenik = $sParametr2;
        $sPredmet = $sParametr3;
        $iNomerZadaniya = $sParametr4;
        include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/dz.php";
    }
    elseif($sParametr5 == "test"){
        $sUchenik = $sParametr2;
        $sPredmet = $sParametr3;
        $iNomerZadaniya = $sParametr4;
        include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/test.php";
    }
    else{
        //http://ege-platforma.local/telsanin/egor/matematika/1
        $sUchenik = $sParametr2;
        $sPredmet = $sParametr3;
        $iNomerZadaniya = $sParametr4;
        include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/urok-dz.php";
    }
}

?>

<!-- This is a button toggling the off-canvas sidebar -->
<button style="position: fixed; right: 0; top: 0;" class="uk-button" data-uk-offcanvas="{target:'#menu', mode:'slide'}">&#9776;</button>

<div id="menu" class="uk-offcanvas">
    <div class="uk-offcanvas-bar uk-offcanvas-bar-flip">
        <ul class="uk-nav uk-nav-parent-icon" data-uk-nav>
            <li class="uk-parent">
                <a href="#">Задачи</a>
                <ul class="uk-nav-sub" data-uk-nav">
                    <li class="uk-parent">
                        <div class="uk-panel">Математика</div>
                        <ul class="uk-nav-sub">
                            <li><a href="/telsanin/zadachi/matematika/3">Задание 3</a></li>
                            <li><a href="/telsanin/zadachi/matematika/2">Задание 2</a></li>
                            <li><a href="/telsanin/zadachi/matematika/1">Задание 1</a></li>
                        </ul>
                    </li>
                    <li class="uk-parent">
                        <div class="uk-panel">Информатика</div>
                        <ul class="uk-nav-sub">
                            <li><a href="/telsanin/zadachi/informatika/8">Задание 8</a></li>
                            <li><a href="/telsanin/zadachi/informatika/16">Задание 16</a></li>
                            <li><a href="/telsanin/zadachi/informatika/1">Задание 1</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <div class="uk-panel">Математика</div>
            <li class="uk-parent">
                <a href="#">Артем</a>
                <ul class="uk-nav-sub uk-nav-parent-icon">
                    <li><a href="/telsanin/artem/matematika/dz">Проверка ДЗ</a></li>
                    <li><a href="/telsanin/artem/matematika/urok">Урок</a></li>
                    <li><a href="/telsanin/artem/matematika/3">Задание 3</a></li>
                    <li><a href="/telsanin/artem/matematika/2">Задание 2</a></li>
                    <li><a href="/telsanin/artem/matematika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">Никита</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/nikita/matematika/dz">Проверка ДЗ</a></li>
                    <li><a href="/telsanin/nikita/matematika/urok">Урок</a></li>
                    <li><a href="/telsanin/nikita/matematika/3">Задание 3</a></li>
                    <li><a href="/telsanin/nikita/matematika/2">Задание 2</a></li>
                    <li><a href="/telsanin/nikita/matematika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">Егор</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/egor/matematika/dz">Проверка ДЗ</a></li>
                    <li><a href="/telsanin/egor/matematika/urok">Урок</a></li>
                    <li><a href="/telsanin/egor/matematika/3">Задание 3</a></li>
                    <li><a href="/telsanin/egor/matematika/2">Задание 2</a></li>
                    <li><a href="/telsanin/egor/matematika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">Андрей</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/andrei/matematika/dz">Проверка ДЗ</a></li>
                    <li><a href="/telsanin/andrei/matematika/urok">Урок</a></li>
                    <li><a href="/telsanin/andrei/matematika/3">Задание 3</a></li>
                    <li><a href="/telsanin/andrei/matematika/2">Задание 2</a></li>
                    <li><a href="/telsanin/andrei/matematika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">Елизавета</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/elizaveta/matematika/dz">Проверка ДЗ</a></li>
                    <li><a href="/telsanin/elizaveta/matematika/urok">Урок</a></li>
                    <li><a href="/telsanin/elizaveta/matematika/3">Задание 3</a></li>
                    <li><a href="/telsanin/elizaveta/matematika/2">Задание 2</a></li>
                    <li><a href="/telsanin/elizaveta/matematika/1">Задание 1</a></li>
                </ul>
            </li>
            <div class="uk-panel">Информатика</div>
            <li class="uk-parent">
                <a href="#">Артем</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/artem/informatika/dz">Проверка ДЗ</a></li>
                    <li><a href="/telsanin/artem/informatika/urok">Урок</a></li>
                    <li><a href="/telsanin/artem/informatika/8">Задание 8</a></li>
                    <li><a href="/telsanin/artem/informatika/16">Задание 16</a></li>
                    <li><a href="/telsanin/artem/informatika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">Даниил</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/daniil/informatika/dz">Проверка ДЗ</a></li>
                    <li><a href="/telsanin/daniil/informatika/urok">Урок</a></li>
                    <li><a href="/telsanin/daniil/informatika/8">Задание 8</a></li>
                    <li><a href="/telsanin/daniil/informatika/16">Задание 16</a></li>
                    <li><a href="/telsanin/daniil/informatika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">Егор</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/egor/informatika/dz">Проверка ДЗ</a></li>
                    <li><a href="/telsanin/egor/informatika/urok">Урок</a></li>
                    <li><a href="/telsanin/egor/informatika/8">Задание 8</a></li>
                    <li><a href="/telsanin/egor/informatika/16">Задание 16</a></li>
                    <li><a href="/telsanin/egor/informatika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">Никита</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/nikita/informatika/dz">Проверка ДЗ</a></li>
                    <li><a href="/telsanin/nikita/informatika/urok">Урок</a></li>
                    <li><a href="/telsanin/nikita/informatika/8">Задание 8</a></li>
                    <li><a href="/telsanin/nikita/informatika/16">Задание 16</a></li>
                    <li><a href="/telsanin/nikita/informatika/1">Задание 1</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>