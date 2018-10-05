<?php

/*
административная часть сайта
*/

//$sParametr1 = explode( '/', $sUrl )[0];
$sParametr2 = explode( '/', $sUrl )[1];
$sParametr3 = explode( '/', $sUrl )[2];
$sParametr4 = explode( '/', $sUrl )[3];
$sParametr5 = explode( '/', $sUrl )[4];

if($sUrl == "telsanin" or $sUrl == "telsanin/") {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/telsanin.php";
}
else {
    //http://ege-platforma.local/telsanin/zadachi/matematika/1
    if($sParametr2 == "zadachi") {
        $sPredmet=$sParametr3;
        $iNomerZadaniya=$sParametr4;
        include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/zadachi.php";
    }
    //http://ege-platforma.local/telsanin/egor/matematika/1
    else{
        //http://ege-platforma.local/telsanin/egor/matematika/urok
        if($sParametr4 == "urok"){
            $sUchenik=$sParametr2;
            $sPredmet=$sParametr3;
            $iNomerZadaniya=$sParametr4;
            include_once $_SERVER['DOCUMENT_ROOT']."/admin/urok.php";
        }
        elseif($sParametr4 == "urok-uchenika"){
            //http://ege-platforma.local/telsanin/egor/matematika/urok-uchenika
            $sUchenik=$sParametr2;
            $sPredmet=$sParametr3;
            $iNomerZadaniya=$sParametr4;
            include_once $_SERVER['DOCUMENT_ROOT']."/front/urok.php";
        }
        //http://ege-platforma.local/telsanin/egor/matematika/dz
        elseif($sParametr4 == "dz"){
            $sUchenik = $sParametr2;
            $sPredmet = $sParametr3;
            $iNomerZadaniya = $sParametr4;
            include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/dz.php";
        }
        //http://ege-platforma.local/telsanin/egor/matematika/dz-uchenika
        elseif($sParametr4 == "dz-uchenika"){
            $sUchenik = $sParametr2;
            $sPredmet = $sParametr3;
            $iNomerZadaniya = $sParametr4;
            include_once $_SERVER['DOCUMENT_ROOT'] . "/front/dz.php";
        }
        elseif($sParametr2 == "test"){
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
}

?>

<!-- This is a button toggling the off-canvas sidebar -->
<button style="position: fixed; right: 0; top: 0;" class="uk-button" data-uk-offcanvas="{target:'#menu', mode:'slide'}">&#9776;</button>

<div id="menu" class="uk-offcanvas uk-contrast">
    <div class="uk-offcanvas-bar uk-offcanvas-bar-flip">
        <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>

            <li class="uk-nav-header">
                <a href="/telsanin">расписание</a>
            </li>
            <li class="uk-nav-divider"></li>

            <li class="uk-parent">
            <a href="#">ЗАДАЧИ</a>
                <ul class="uk-nav-sub" data-uk-nav">
                    <li class="uk-parent">
                        <div class="uk-nav-header">Математика</div>
                        <ul class="uk-nav-sub">
                            <li><a href="/telsanin/zadachi/matematika/7">Задание 7</a></li>
                            <li><a href="/telsanin/zadachi/matematika/6">Задание 6</a></li>
                            <li><a href="/telsanin/zadachi/matematika/5">Задание 5</a></li>
                            <li><a href="/telsanin/zadachi/matematika/4">Задание 4</a></li>
                            <li><a href="/telsanin/zadachi/matematika/3">Задание 3</a></li>
                            <li><a href="/telsanin/zadachi/matematika/2">Задание 2</a></li>
                            <li><a href="/telsanin/zadachi/matematika/1">Задание 1</a></li>
                        </ul>
                    </li>
                    <li class="uk-parent">
                        <div class="uk-nav-header">Информатика</div>
                        <ul class="uk-nav-sub">
                            <li><a href="/telsanin/zadachi/informatika/20">Задание 20</a></li>
                            <li><a href="/telsanin/zadachi/informatika/19">Задание 19</a></li>
                            <li><a href="/telsanin/zadachi/informatika/11">Задание 11</a></li>
                            <li><a href="/telsanin/zadachi/informatika/8">Задание 8</a></li>
                            <li><a href="/telsanin/zadachi/informatika/16">Задание 16</a></li>
                            <li><a href="/telsanin/zadachi/informatika/1">Задание 1</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="uk-nav-divider"></li>

            <li class="uk-nav-header">Математика:</li>
            <li class="uk-parent">
                <a href="#">ЕГОР</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/egor/matematika/dz">Дз - проверка</a></li>
                    <li><a href="/telsanin/egor/matematika/urok">Урок - проведение</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a class="uk-active" href="/telsanin/egor/matematika/dz-uchenika">Дз</a></li>
                    <li><a href="/telsanin/egor/matematika/urok-uchenika">Урок</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/telsanin/egor/matematika/5">Задание 5</a></li>
                    <li><a href="/telsanin/egor/matematika/4">Задание 4</a></li>
                    <li><a href="/telsanin/egor/matematika/3">Задание 3</a></li>
                    <li><a href="/telsanin/egor/matematika/2">Задание 2</a></li>
                    <li><a href="/telsanin/egor/matematika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">НИКИТА</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/nikita/matematika/dz">Дз - проверка</a></li>
                    <li><a href="/telsanin/nikita/matematika/urok">Урок - проведение</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a class="uk-active" href="/nikita/matematika/dz">Дз</a></li>
                    <li><a href="/nikita/matematika/urok">Урок</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/telsanin/nikita/matematika/5">Задание 5</a></li>
                    <li><a href="/telsanin/nikita/matematika/4">Задание 4</a></li>
                    <li><a href="/telsanin/nikita/matematika/3">Задание 3</a></li>
                    <li><a href="/telsanin/nikita/matematika/2">Задание 2</a></li>
                    <li><a href="/telsanin/nikita/matematika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">АНДРЕЙ</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/andrei/matematika/dz">Дз - проверка</a></li>
                    <li><a href="/telsanin/andrei/matematika/urok">Урок - проведение</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a class="uk-active" href="/andrei/matematika/dz">Дз</a></li>
                    <li><a href="/andrei/matematika/urok">Урок</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/telsanin/andrei/matematika/5">Задание 5</a></li>
                    <li><a href="/telsanin/andrei/matematika/4">Задание 4</a></li>
                    <li><a href="/telsanin/andrei/matematika/3">Задание 3</a></li>
                    <li><a href="/telsanin/andrei/matematika/2">Задание 2</a></li>
                    <li><a href="/telsanin/andrei/matematika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">АРТЕМ</a>
                <ul class="uk-nav-sub uk-active">
                    <li><a href="/telsanin/artem/matematika/dz">Дз - проверка</a></li>
                    <li><a href="/telsanin/artem/matematika/urok">Урок - проведение</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a class="uk-active" href="/artem/matematika/dz">Дз</a></li>
                    <li><a href="/artem/matematika/urok">Урок</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/telsanin/artem/matematika/5">Задание 5</a></li>
                    <li><a href="/telsanin/artem/matematika/4">Задание 4</a></li>
                    <li><a href="/telsanin/artem/matematika/3">Задание 3</a></li>
                    <li><a href="/telsanin/artem/matematika/2">Задание 2</a></li>
                    <li><a href="/telsanin/artem/matematika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">ЕЛИЗАВЕТА</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/elizaveta/matematika/dz">Дз - проверка</a></li>
                    <li><a href="/telsanin/elizaveta/matematika/urok">Урок - проведение</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a class="uk-active" href="/elizaveta/matematika/dz">Дз</a></li>
                    <li><a href="/elizaveta/matematika/urok">Урок</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/telsanin/elizaveta/matematika/5">Задание 5</a></li>
                    <li><a href="/telsanin/elizaveta/matematika/4">Задание 4</a></li>
                    <li><a href="/telsanin/elizaveta/matematika/3">Задание 3</a></li>
                    <li><a href="/telsanin/elizaveta/matematika/2">Задание 2</a></li>
                    <li><a href="/telsanin/elizaveta/matematika/1">Задание 1</a></li>
                </ul>
            </li>
        <li class="uk-parent">
            <a href="#">ВЛАДИМИР</a>
            <ul class="uk-nav-sub uk-active">
                <li><a href="/telsanin/vladimir/matematika/dz">Дз - проверка</a></li>
                <li><a href="/telsanin/vladimir/matematika/urok">Урок - проведение</a></li>
                <li class="uk-nav-divider"></li>
                <li><a class="uk-active" href="/vladimir/matematika/dz">Дз</a></li>
                <li><a href="/vladimir/matematika/urok">Урок</a></li>
                <li class="uk-nav-divider"></li>
                <li><a href="/telsanin/vladimir/matematika/5">Задание 5</a></li>
                <li><a href="/telsanin/vladimir/matematika/4">Задание 4</a></li>
                <li><a href="/telsanin/vladimir/matematika/3">Задание 3</a></li>
                <li><a href="/telsanin/vladimir/matematika/2">Задание 2</a></li>
                <li><a href="/telsanin/vladimir/matematika/1">Задание 1</a></li>
            </ul>
        </li>
            <li class="uk-nav-divider"></li>
            <li class="uk-nav-header">Информатика:</li>
            <li class="uk-parent">
                <a href="#">ДАНИИЛ</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/daniil/informatika/dz">Дз - проверка</a></li>
                    <li><a href="/telsanin/daniil/informatika/urok">Урок - проведение</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a class="uk-active" href="/daniil/informatika/dz">Дз</a></li>
                    <li><a href="/daniil/informatika/urok">Урок</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/telsanin/daniil/informatika/11">Задание 11</a></li>
                    <li><a href="/telsanin/daniil/informatika/8">Задание 8</a></li>
                    <li><a href="/telsanin/daniil/informatika/16">Задание 16</a></li>
                    <li><a href="/telsanin/daniil/informatika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">АРТЕМ</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/artem/informatika/dz">Дз - проверка</a></li>
                    <li><a href="/telsanin/artem/informatika/urok">Урок - проведение</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a class="uk-active" href="/artem/informatika/dz">Дз</a></li>
                    <li><a href="/artem/informatika/urok">Урок</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/telsanin/artem/informatika/11">Задание 11</a></li>
                    <li><a href="/telsanin/artem/informatika/8">Задание 8</a></li>
                    <li><a href="/telsanin/artem/informatika/16">Задание 16</a></li>
                    <li><a href="/telsanin/artem/informatika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">ЕГОР</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/egor/informatika/dz">Дз - проверка</a></li>
                    <li><a href="/telsanin/egor/informatika/urok">Урок - проведение</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a class="uk-active" href="/egor/informatika/dz">Дз</a></li>
                    <li><a href="/egor/informatika/urok">Урок</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/telsanin/egor/informatika/11">Задание 11</a></li>
                    <li><a href="/telsanin/egor/informatika/8">Задание 8</a></li>
                    <li><a href="/telsanin/egor/informatika/16">Задание 16</a></li>
                    <li><a href="/telsanin/egor/informatika/1">Задание 1</a></li>
                </ul>
            </li>
            <li class="uk-parent">
                <a href="#">НИКИТА</a>
                <ul class="uk-nav-sub">
                    <li><a href="/telsanin/nikita/informatika/dz">Дз - проверка</a></li>
                    <li><a href="/telsanin/nikita/informatika/urok">Урок - проведение</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a class="uk-active" href="/nikita/informatika/dz">Дз</a></li>
                    <li><a href="/nikita/informatika/urok">Урок</a></li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="/telsanin/nikita/informatika/11">Задание 11</a></li>
                    <li><a href="/telsanin/nikita/informatika/8">Задание 8</a></li>
                    <li><a href="/telsanin/nikita/informatika/16">Задание 16</a></li>
                    <li><a href="/telsanin/nikita/informatika/1">Задание 1</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<script>
//    UIkit.offcanvas.show('#menu');
</script>