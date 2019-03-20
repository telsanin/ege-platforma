<style type="text/css">
    .pushedButton {
        border: solid 2px blue;
    }
</style>

<div id="oServiceMessages" style="position: fixed; bottom: 20px; left: 20px; background-color: white; padding: 10px; border: solid 1px gray; border-radius: 10px; display: none;">
</div>


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

//Меню
include_once $_SERVER["DOCUMENT_ROOT"]."/admin/menu.php";

?>