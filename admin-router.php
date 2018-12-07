<style type="text/css">
    .pushedButton {
        border: solid 2px blue;
    }
</style>

<?php

/*
административная часть сайта
*/

//подключаем функцию логгинга чего угодно; include: если файла не будет - выдастся Warning и работа продолжится
//работает так: logger('любой текст');
//include $_SERVER["DOCUMENT_ROOT"]."/PART_logger.php";
//
//

//$sParametr1 = explode( '/', $sUrl )[0];
$sParametr2 = explode( '/', $sUrl )[1];
$sParametr3 = explode( '/', $sUrl )[2];
$sParametr4 = explode( '/', $sUrl )[3];
$sParametr5 = explode( '/', $sUrl )[4];
$sParametr6 = explode( '/', $sUrl )[5];

if($sUrl == "telsanin" or $sUrl == "telsanin/") {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/telsanin.php";
}
else {
    //http://ege-platforma.local/telsanin/zadachi/edit/matematika/1
    if($sParametr2 == "zadachi") {

        //TopBlock
        echo "<div style='position: fixed; top: 15px; width: 100%; align: auto; background: white;'>";

        $sButton1Class = "";
        $sButton2Class = "";
        $sButton3Class = "";
        $sButton4Class = "";

        switch ($sParametr5){
            case 'upload':
                $sButton1Class = " pushedButton";
                break;
            case 'edit':
                $sButton2Class = " pushedButton";
                break;
            case 'sort':
                $sButton3Class = " pushedButton";
                break;
            case 'print':
                $sButton4Class = " pushedButton";
                break;
            case '':
                $sButton4Class = " pushedButton";
                break;
        }

        echo "<button class='top-block".$sButton1Class."' id='top-block-upload'>upload</button>&nbsp;&nbsp;";
        echo "<button class='top-block".$sButton2Class."' id='top-block-edit'>edit</button>&nbsp;&nbsp;";
        echo "<button class='top-block".$sButton3Class."' id='top-block-sort'>sort</button>&nbsp;&nbsp;";
        echo "<button class='top-block".$sButton4Class."' id='top-block-print'>print</button>&nbsp;&nbsp;";

        echo "</div>";
        echo "</br></br>";
        //-TopBlock

        switch($sParametr5){
            case "upload":
                include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/upload.php";
                break;
            case "edit":
                $sPredmet=$sParametr3;
                $iNomerZadaniya=$sParametr4;
                include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/zadachi.php";
                break;
            case "sort":
                $sPredmet=$sParametr3;
                $iNomerZadaniya=$sParametr4;
                include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/zadachi-sortirovka.php";
                break;
            case "print":
                $sPredmet=$sParametr3;
                $iNomerZadaniya=$sParametr4;
                include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/zadachi-print.php";
                break;
            case "":
                $sPredmet=$sParametr3;
                $iNomerZadaniya=$sParametr4;
                include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/zadachi-print.php";
                break;
        }
    }
    //http://ege-platforma.local/telsanin/egor/matematika/1
    elseif($sParametr2 == "testing"){
        include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/testing.php";
    }
    else{

            $sUchenik=$sParametr2;
            $sPredmet=$sParametr3;
            $iNomerZadaniya=$sParametr4;

            //TopBlock
//            if($sParametr4 == "urok"||$sParametr4 == "urok-uchenika"||$sParametr4 == "dz"||$sParametr4 == "dz-uchenika"||$sParametr4 == "otchet"||$sParametr4 == "otchet-uchenika") {
            $aTopBlock[0][0] = 0;
            $aTopBlock[0][1] = 0;
            $aTopBlock[0][2] = 0;
            $aTopBlock[1][0] = 0;
            $aTopBlock[1][1] = 0;
            $aTopBlock[1][2] = 0;

            $SqlQuery = "SELECT IF(((`resheno-pravilno`=1) OR (`reshali-na-zanyatii`=1)),1,0) AS rp, `uchenik-zadachi`.urok, count(`uchenik-zadachi`.urok) as count FROM `uchenik-zadachi`, zadacha WHERE `zadacha`.`id-zadachi`=`uchenik-zadachi`.`id-zadachi` and uchenik='" . $sUchenik . "' and `uchenik-zadachi`.predmet='" . $sPredmet . "'";
            if(!($sParametr4 == "urok"||$sParametr4 == "urok-uchenika"||$sParametr4 == "dz"||$sParametr4 == "dz-uchenika"||$sParametr4 == "otchet"||$sParametr4 == "otchet-uchenika"))
                $SqlQuery .= " and zadanie=".$iNomerZadaniya."";
            $SqlQuery .= " group by rp, `uchenik-zadachi`.urok;";

            if ($res = $mysqli->query($SqlQuery)) {
                $res->data_seek(0);
                while ($row = $res->fetch_assoc()) {
                    if ($row['rp'])
                        $aTopBlock[1][$row['urok']] = $row['count'];
                    else
                        $aTopBlock[0][$row['urok']] = $row['count'];
                }
            }

            echo "<div style='position: fixed; top: 0; width: 100%; align: auto; background: white;'>";
            echo "<div>";
            echo "<font color='Gray'>---: <span id='TopBlockReshenoVNigde'>" . $aTopBlock[1][0] . "</span></font>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
            echo "<font color='RoyalBlue'>сделано: <span id='TopBlockReshenoVUroke'>" . $aTopBlock[1][1] . "</span></font>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
            echo "<font color='IndianRed'>сделано: <span id='TopBlockReshenoVVydannomDz'>" . $aTopBlock[1][2] . "</span></font>";
            echo "</div>";
            echo "<div>";
            echo "---: <span id='TopBlockVNigde'>" . $aTopBlock[0][0] . "</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
            echo "<font color='blue'>в уроке:&nbsp;&nbsp;&nbsp;<span id='TopBlockVUroke'>" . $aTopBlock[0][1] . "</span></font>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;";
            echo "<font color='red'>в выданном дз: <span id='TopBlockVVydannomDz'>" . $aTopBlock[0][2] . "</span></font>";
            echo "</div>";

            $sButton1Class="";
            $sButton2Class="";
            $sButton3Class="";
            $sButton4Class="";

            if($sParametr4=='urok'||$sParametr4=='urok-uchenika')
                $sButton2Class="pushedButton";
            elseif($sParametr4=='dz'||$sParametr4=='dz-uchenika')
                $sButton3Class="pushedButton";
            elseif($sParametr4=='otchet'||$sParametr4=='otchet-uchenika')
                $sButton4Class="pushedButton";
            else
                $sButton1Class="pushedButton";

            echo "<button class='".$sButton1Class."' id='urokdz'>урок-дз</button>&nbsp;&nbsp;";
            echo "<button class='".$sButton2Class."' id='urok'>урок</button>&nbsp;&nbsp;";
            echo "<button class='".$sButton3Class."' id='dz'>дз</button>&nbsp;&nbsp;";
            echo "<button class='".$sButton4Class."' id='otchet'>отчет</button>&nbsp;&nbsp;";

            if($sParametr4 == "urok"||$sParametr4 == "urok-uchenika"||$sParametr4 == "dz"||$sParametr4 == "dz-uchenika"||$sParametr4 == "otchet"||$sParametr4 == "otchet-uchenika") {
                echo "<input id='rejim' type='checkbox' ";
                echo(($sParametr4 == "urok-uchenika" || $sParametr4 == "dz-uchenika" || $sParametr4 == "otchet-uchenika") ? " checked " : "");
                echo "/><label for='rejim'>Ученик</label>&nbsp;";
            }

            echo "</div>";
            //-TopBlock

//            echo "</br></br></br>";
//        }

        //http://ege-platforma.local/telsanin/egor/matematika/urok
        if($sParametr4 == "urok"){
            include_once $_SERVER['DOCUMENT_ROOT']."/admin/urok.php";
        }
        elseif($sParametr4 == "urok-uchenika"){
            //http://ege-platforma.local/telsanin/egor/matematika/urok-uchenika
            echo "</br></br></br>";
            include_once $_SERVER['DOCUMENT_ROOT']."/front/urok.php";
        }
        //http://ege-platforma.local/telsanin/egor/matematika/dz
        elseif($sParametr4 == "dz"){
            include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/dz.php";
        }
        //http://ege-platforma.local/telsanin/egor/matematika/dz-uchenika
        elseif($sParametr4 == "dz-uchenika"){
            echo "</br></br></br>";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/front/dz.php";
        }
        elseif($sParametr4 == "otchet"){
            include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/otchet.php";
        }
        elseif($sParametr4 == "otchet-uchenika"){
            echo "</br>";
            include_once $_SERVER['DOCUMENT_ROOT'] . "/front/otchet.php";
        }
        else{
            //http://ege-platforma.local/telsanin/egor/matematika/1
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
                        <div class="uk-nav-header">Информатика</div>
                        <ul class="uk-nav-sub">
                            <li><a href="/telsanin/zadachi/informatika/23/sort">Задание 23</a></li>
                            <li><a href="/telsanin/zadachi/informatika/22/sort">Задание 22</a></li>
                            <li><a href="/telsanin/zadachi/informatika/18/sort">Задание 18</a></li>
                            <li><a href="/telsanin/zadachi/informatika/17/sort">Задание 17</a></li>
                            <li><a href="/telsanin/zadachi/informatika/14/sort">Задание 14</a></li>
                            <li><a href="/telsanin/zadachi/informatika/13/sort">Задание 13</a></li>
                            <li><a href="/telsanin/zadachi/informatika/12/sort">Задание 12</a></li>
                            <li><a href="/telsanin/zadachi/informatika/10/sort">Задание 10</a></li>
                            <li><a href="/telsanin/zadachi/informatika/9/sort">Задание 9</a></li>
                            <li><a href="/telsanin/zadachi/informatika/7/sort">Задание 7</a></li>
                            <li><a href="/telsanin/zadachi/informatika/6/sort">Задание 6</a></li>
                            <li><a href="/telsanin/zadachi/informatika/5/sort">Задание 5</a></li>
                            <li><a href="/telsanin/zadachi/informatika/4/sort">Задание 4</a></li>
                            <li><a href="/telsanin/zadachi/informatika/15/sort">Задание 15</a></li>
                            <li><a href="/telsanin/zadachi/informatika/3/sort">Задание 3</a></li>
                            <li><a href="/telsanin/zadachi/informatika/2/sort">Задание 2</a></li>
                            <li><a href="/telsanin/zadachi/informatika/26/sort">Задание 26</a></li>
                            <li><a href="/telsanin/zadachi/informatika/27/sort">Задание 27</a></li>
                            <li><a href="/telsanin/zadachi/informatika/25/sort">Задание 25</a></li>
                            <li><a href="/telsanin/zadachi/informatika/24/sort">Задание 24</a></li>
                            <li><a href="/telsanin/zadachi/informatika/21/sort">Задание 21</a></li>
                            <li><a href="/telsanin/zadachi/informatika/20/sort">Задание 20</a></li>
                            <li><a href="/telsanin/zadachi/informatika/19/sort">Задание 19</a></li>
                            <li><a href="/telsanin/zadachi/informatika/11/sort">Задание 11</a></li>
                            <li><a href="/telsanin/zadachi/informatika/8/sort">Задание 8</a></li>
                            <li><a href="/telsanin/zadachi/informatika/16/sort">Задание 16</a></li>
                            <li><a href="/telsanin/zadachi/informatika/1/sort">Задание 1</a></li>
                        </ul>
                    </li>
                    <li class="uk-parent">
                        <div class="uk-nav-header">Математика</div>
                        <ul class="uk-nav-sub">
                            <li><a href="/telsanin/zadachi/matematika/19/sort">Задание 19</a></li>
                            <li><a href="/telsanin/zadachi/matematika/17/sort">Задание 17</a></li>
                            <li><a href="/telsanin/zadachi/matematika/15/sort">Задание 15</a></li>
                            <li><a href="/telsanin/zadachi/matematika/13/sort">Задание 13</a></li>
                            <li><a href="/telsanin/zadachi/matematika/12/sort">Задание 12</a></li>
                            <li><a href="/telsanin/zadachi/matematika/11/sort">Задание 11</a></li>
                            <li><a href="/telsanin/zadachi/matematika/10/sort">Задание 10</a></li>
                            <li><a href="/telsanin/zadachi/matematika/9/sort">Задание 9</a></li>
                            <li><a href="/telsanin/zadachi/matematika/8/sort">Задание 8</a></li>
                            <li><a href="/telsanin/zadachi/matematika/7/sort">Задание 7</a></li>
                            <li><a href="/telsanin/zadachi/matematika/6/sort">Задание 6</a></li>
                            <li><a href="/telsanin/zadachi/matematika/5/sort">Задание 5</a></li>
                            <li><a href="/telsanin/zadachi/matematika/4/sort">Задание 4</a></li>
                            <li><a href="/telsanin/zadachi/matematika/3/sort">Задание 3</a></li>
                            <li><a href="/telsanin/zadachi/matematika/2/sort">Задание 2</a></li>
                            <li><a href="/telsanin/zadachi/matematika/1/sort">Задание 1</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="uk-nav-divider"></li>

            <li class="uk-nav-header">Математика:</li>
                <li><a href="/telsanin/elizaveta/matematika/dz">ЕЛИЗАВЕТА</a><a style="margin-left: 20px;" href="/elizaveta/matematika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/egor/matematika/dz">ЕГОР</a><a style="margin-left: 20px;" href="/egor/matematika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/nikita/matematika/dz">НИКИТА</a><a style="margin-left: 20px;" href="/nikita/matematika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/artem/matematika/dz">АРТЕМ</a><a style="margin-left: 20px;" href="/artem/matematika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/andrei/matematika/dz">АНДРЕЙ</a><a style="margin-left: 20px;" href="/andrei/matematika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/anastasiya/matematika/dz">АНАСТАСИЯ</a><a style="margin-left: 20px;" href="/anastasiya/matematika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/denis/matematika/dz">ДЕНИС</a><a style="margin-left: 20px;" href="/denis/matematika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/rostislav/matematika/dz">РОСТИСЛАВ</a><a style="margin-left: 20px;" href="/rostislav/matematika/dz/sort">дз ученика</a></li>

            <li class="uk-nav-divider"></li>

            <li class="uk-nav-header">Информатика:</li>
                <li><a href="/telsanin/daniil/informatika/dz">ДАНИИЛ</a><a style="margin-left: 20px;" href="/daniil/informatika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/artem/informatika/dz">АРТЕМ</a><a style="margin-left: 20px;" href="/artem/informatika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/ilya/informatika/dz">ИЛЬЯ</a><a style="margin-left: 20px;" href="/ilya/informatika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/aleksandr/informatika/dz">АЛЕКСАНДР</a><a style="margin-left: 20px;" href="/aleksandr/informatika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/amir/informatika/dz">АМИР</a><a style="margin-left: 20px;" href="/amir/informatika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/viktoriya/informatika/dz">ВИКТОРИЯ</a><a style="margin-left: 20px;" href="/viktoriya/informatika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/farid/informatika/dz">ФАРИД</a><a style="margin-left: 20px;" href="/farid/informatika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/denis/informatika/dz">ДЕНИС</a><a style="margin-left: 20px;" href="/denis/informatika/dz/sort">дз ученика</a></li>
                <li><a href="/telsanin/vladislav/informatika/dz">ВЛАДИСЛАВ</a><a style="margin-left: 20px;" href="/vladislav/informatika/dz/sort">дз ученика</a></li>
        </ul>
    </div>
<!--</div><button style="position: fixed; right: 0; top: 0;" class="uk-button" data-uk-offcanvas="{target:'#menu', mode:'slide'}">&#9776;</button>-->
<!---->
<!--<div id="menu" class="uk-offcanvas uk-contrast">-->
<!--    <div class="uk-offcanvas-bar uk-offcanvas-bar-flip">-->
<!--        <ul class="uk-nav uk-nav-offcanvas uk-nav-parent-icon" data-uk-nav>-->
<!---->
<!--            <li class="uk-nav-header">-->
<!--                <a href="/telsanin">расписание</a>-->
<!--            </li>-->
<!--            <li class="uk-nav-divider"></li>-->
<!---->
<!--            <li class="uk-parent">-->
<!--            <a href="#">ЗАДАЧИ</a>-->
<!--                <ul class="uk-nav-sub" data-uk-nav">-->
<!--                    <li class="uk-parent">-->
<!--                        <div class="uk-nav-header">Математика</div>-->
<!--                        <ul class="uk-nav-sub">-->
<!--                            <li><a href="/telsanin/zadachi/edit/matematika/7">Задание 7</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/matematika/6">Задание 6</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/matematika/5">Задание 5</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/matematika/4">Задание 4</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/matematika/3">Задание 3</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/matematika/2">Задание 2</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/matematika/1">Задание 1</a></li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                    <li class="uk-parent">-->
<!--                        <div class="uk-nav-header">Информатика</div>-->
<!--                        <ul class="uk-nav-sub">-->
<!--                            <li><a href="/telsanin/zadachi/edit/informatika/20">Задание 20</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/informatika/19">Задание 19</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/informatika/11">Задание 11</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/informatika/8">Задание 8</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/informatika/16">Задание 16</a></li>-->
<!--                            <li><a href="/telsanin/zadachi/edit/informatika/1">Задание 1</a></li>-->
<!--                        </ul>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </li>-->
<!---->
<!--            <li class="uk-nav-divider"></li>-->
<!---->
<!--            <li class="uk-nav-header">Математика:</li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">ЕГОР</a>-->
<!--                <ul class="uk-nav-sub">-->
<!--                    <li><a href="/telsanin/egor/matematika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/egor/matematika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/egor/matematika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/egor/matematika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/egor/matematika/5">Задание 5</a></li>-->
<!--                    <li><a href="/telsanin/egor/matematika/4">Задание 4</a></li>-->
<!--                    <li><a href="/telsanin/egor/matematika/3">Задание 3</a></li>-->
<!--                    <li><a href="/telsanin/egor/matematika/2">Задание 2</a></li>-->
<!--                    <li><a href="/telsanin/egor/matematika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">НИКИТА</a>-->
<!--                <ul class="uk-nav-sub">-->
<!--                    <li><a href="/telsanin/nikita/matematika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/nikita/matematika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/nikita/matematika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/nikita/matematika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/nikita/matematika/5">Задание 5</a></li>-->
<!--                    <li><a href="/telsanin/nikita/matematika/4">Задание 4</a></li>-->
<!--                    <li><a href="/telsanin/nikita/matematika/3">Задание 3</a></li>-->
<!--                    <li><a href="/telsanin/nikita/matematika/2">Задание 2</a></li>-->
<!--                    <li><a href="/telsanin/nikita/matematika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">АНДРЕЙ</a>-->
<!--                <ul class="uk-nav-sub">-->
<!--                    <li><a href="/telsanin/andrei/matematika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/andrei/matematika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/andrei/matematika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/andrei/matematika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/andrei/matematika/5">Задание 5</a></li>-->
<!--                    <li><a href="/telsanin/andrei/matematika/4">Задание 4</a></li>-->
<!--                    <li><a href="/telsanin/andrei/matematika/3">Задание 3</a></li>-->
<!--                    <li><a href="/telsanin/andrei/matematika/2">Задание 2</a></li>-->
<!--                    <li><a href="/telsanin/andrei/matematika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">АРТЕМ</a>-->
<!--                <ul class="uk-nav-sub uk-active">-->
<!--                    <li><a href="/telsanin/artem/matematika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/artem/matematika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/artem/matematika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/artem/matematika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/artem/matematika/5">Задание 5</a></li>-->
<!--                    <li><a href="/telsanin/artem/matematika/4">Задание 4</a></li>-->
<!--                    <li><a href="/telsanin/artem/matematika/3">Задание 3</a></li>-->
<!--                    <li><a href="/telsanin/artem/matematika/2">Задание 2</a></li>-->
<!--                    <li><a href="/telsanin/artem/matematika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">ЕЛИЗАВЕТА</a>-->
<!--                <ul class="uk-nav-sub">-->
<!--                    <li><a href="/telsanin/elizaveta/matematika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/elizaveta/matematika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/elizaveta/matematika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/elizaveta/matematika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/elizaveta/matematika/5">Задание 5</a></li>-->
<!--                    <li><a href="/telsanin/elizaveta/matematika/4">Задание 4</a></li>-->
<!--                    <li><a href="/telsanin/elizaveta/matematika/3">Задание 3</a></li>-->
<!--                    <li><a href="/telsanin/elizaveta/matematika/2">Задание 2</a></li>-->
<!--                    <li><a href="/telsanin/elizaveta/matematika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--        <li class="uk-parent">-->
<!--            <a href="#">ВЛАДИМИР</a>-->
<!--            <ul class="uk-nav-sub uk-active">-->
<!--                <li><a href="/telsanin/vladimir/matematika/dz">Дз - проверка</a></li>-->
<!--                <li><a href="/telsanin/vladimir/matematika/urok">Урок - проведение</a></li>-->
<!--                <li class="uk-nav-divider"></li>-->
<!--                <li><a class="uk-active" href="/telsanin/vladimir/matematika/dz-uchenika">Дз</a></li>-->
<!--                <li><a href="/telsanin/vladimir/matematika/urok-uchenika">Урок</a></li>-->
<!--                <li class="uk-nav-divider"></li>-->
<!--                <li><a href="/telsanin/vladimir/matematika/5">Задание 5</a></li>-->
<!--                <li><a href="/telsanin/vladimir/matematika/4">Задание 4</a></li>-->
<!--                <li><a href="/telsanin/vladimir/matematika/3">Задание 3</a></li>-->
<!--                <li><a href="/telsanin/vladimir/matematika/2">Задание 2</a></li>-->
<!--                <li><a href="/telsanin/vladimir/matematika/1">Задание 1</a></li>-->
<!--            </ul>-->
<!--        </li>-->
<!--            <li class="uk-nav-divider"></li>-->
<!--            <li class="uk-nav-header">Информатика:</li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">ДАНИИЛ</a>-->
<!--                <ul class="uk-nav-sub">-->
<!--                    <li><a href="/telsanin/daniil/informatika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/daniil/informatika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/daniil/informatika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/daniil/informatika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/daniil/informatika/20">Задание 20</a></li>-->
<!--                    <li><a href="/telsanin/daniil/informatika/11">Задание 11</a></li>-->
<!--                    <li><a href="/telsanin/daniil/informatika/8">Задание 8</a></li>-->
<!--                    <li><a href="/telsanin/daniil/informatika/16">Задание 16</a></li>-->
<!--                    <li><a href="/telsanin/daniil/informatika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">АРТЕМ</a>-->
<!--                <ul class="uk-nav-sub">-->
<!--                    <li><a href="/telsanin/artem/informatika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/artem/informatika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/artem/informatika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/artem/informatika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/artem/informatika/20">Задание 20</a></li>-->
<!--                    <li><a href="/telsanin/artem/informatika/11">Задание 11</a></li>-->
<!--                    <li><a href="/telsanin/artem/informatika/8">Задание 8</a></li>-->
<!--                    <li><a href="/telsanin/artem/informatika/16">Задание 16</a></li>-->
<!--                    <li><a href="/telsanin/artem/informatika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">ЕГОР</a>-->
<!--                <ul class="uk-nav-sub">-->
<!--                    <li><a href="/telsanin/egor/informatika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/egor/informatika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/egor/informatika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/egor/informatika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/egor/informatika/20">Задание 20</a></li>-->
<!--                    <li><a href="/telsanin/egor/informatika/11">Задание 11</a></li>-->
<!--                    <li><a href="/telsanin/egor/informatika/8">Задание 8</a></li>-->
<!--                    <li><a href="/telsanin/egor/informatika/16">Задание 16</a></li>-->
<!--                    <li><a href="/telsanin/egor/informatika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">АМИР</a>-->
<!--                <ul class="uk-nav-sub">-->
<!--                    <li><a href="/telsanin/amir/informatika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/amir/informatika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/amir/informatika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/amir/informatika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/amir/informatika/20">Задание 20</a></li>-->
<!--                    <li><a href="/telsanin/amir/informatika/11">Задание 11</a></li>-->
<!--                    <li><a href="/telsanin/amir/informatika/8">Задание 8</a></li>-->
<!--                    <li><a href="/telsanin/amir/informatika/16">Задание 16</a></li>-->
<!--                    <li><a href="/telsanin/amir/informatika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">АЛЕКСАНДР</a>-->
<!--                <ul class="uk-nav-sub">-->
<!--                    <li><a href="/telsanin/aleksandr/informatika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/aleksandr/informatika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/aleksandr/informatika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/aleksandr/informatika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/aleksandr/informatika/20">Задание 20</a></li>-->
<!--                    <li><a href="/telsanin/aleksandr/informatika/11">Задание 11</a></li>-->
<!--                    <li><a href="/telsanin/aleksandr/informatika/8">Задание 8</a></li>-->
<!--                    <li><a href="/telsanin/aleksandr/informatika/16">Задание 16</a></li>-->
<!--                    <li><a href="/telsanin/aleksandr/informatika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="uk-parent">-->
<!--                <a href="#">ИЛЬЯ</a>-->
<!--                <ul class="uk-nav-sub">-->
<!--                    <li><a href="/telsanin/ilya/informatika/dz">Дз - проверка</a></li>-->
<!--                    <li><a href="/telsanin/ilya/informatika/urok">Урок - проведение</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a class="uk-active" href="/telsanin/ilya/informatika/dz-uchenika">Дз</a></li>-->
<!--                    <li><a href="/telsanin/ilya/informatika/urok-uchenika">Урок</a></li>-->
<!--                    <li class="uk-nav-divider"></li>-->
<!--                    <li><a href="/telsanin/ilya/informatika/20">Задание 20</a></li>-->
<!--                    <li><a href="/telsanin/ilya/informatika/11">Задание 11</a></li>-->
<!--                    <li><a href="/telsanin/ilya/informatika/8">Задание 8</a></li>-->
<!--                    <li><a href="/telsanin/ilya/informatika/16">Задание 16</a></li>-->
<!--                    <li><a href="/telsanin/ilya/informatika/1">Задание 1</a></li>-->
<!--                </ul>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
<!--</div>-->

<script>
//    UIkit.offcanvas.show('#menu');
</script>