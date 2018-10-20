<?php
/*
Этот файл вызывается из ***.js
добавляет строку в таблицу zadacha (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на добавление строки в таблицу БД
$sUchenik=$_POST["suchenik"];
$sPredmet=$_POST["spredmet"];
//$iIdPodtemy=$_POST["idpodtemy"];
$iSortirovka=$_POST["isortirovka"];
$iNomerZadaniya=$_POST["izadanie"];

$sTextZanyatiya="";
$iCount=0;
//$iFlag=1;

//!!!
//здесь есть проблема в том, что в информатике задания идут не по порядку
//и если мы решали №16 а потом №8, то если текущая задача в задании №8, то все задачи из №16
//не попадут в этот отчет

$SqlQuery = "SELECT count(`uchenik-zadachi`.`id-zadachi`) as count, `zadanie` FROM `uchenik-zadachi`, `zadacha` WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`urok`=1 AND `reshali-na-zanyatii`=0 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' AND (`uchenik-zadachi`.`sortirovka`<=".$iSortirovka." OR `resheno-pravilno`=-1 OR `razobrat-na-zanyatii`);";

//$SqlQuery = "SELECT count(`uchenik-zadachi`.`id-zadachi`) as count, `zadanie` FROM `uchenik-zadachi`, `zadacha` WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`urok`=1 AND `reshali-na-zanyatii`=0 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND (`zadacha`.`zadanie`<'".$iNomerZadaniya."' OR (`zadacha`.`zadanie`='".$iNomerZadaniya."' AND `uchenik-zadachi`.`sortirovka`<=".$iSortirovka.")) GROUP BY `zadacha`.`zadanie`;";

//$SqlQuery = "SELECT count(`uchenik-zadachi`.`id-zadachi`) as count, `zadanie` FROM `uchenik-zadachi`, `zadacha` WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`urok`=1 AND `resheno-pravilno`<>2 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND (`zadacha`.`zadanie`<'".$iNomerZadaniya."' OR (`zadacha`.`zadanie`='".$iNomerZadaniya."' AND `uchenik-zadachi`.`sortirovka`<=".$iSortirovka.")) GROUP BY `zadacha`.`zadanie`;";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)) {
//    $sTextZanyatiya.="<b>Содержание занятия:</b></br>";
    $sTextZanyatiya.="Работа над Заданием №";
    while ($row = $res->fetch_assoc()) {
//        if ($iFlag)
//            $iFlag = 0;
//        else
//            $sTextZanyatiya .= ", №";
        $sTextZanyatiya .= $row["zadanie"];
//        $iCount += $row["count"];
        $iCount = $row["count"];
    }
    $sTextZanyatiya .= "</br>";
    $sTextZanyatiya .= "Решено более " . $iCount . " задач</br>";
}
//$res = $mysqli->query($SqlQuery);
//if($res->data_seek(0)) {
//    $sTextZanyatiya.="<b>Содержание занятия:</b></br>";
//    $sTextZanyatiya.="Работа над Заданием №";
//    while ($row = $res->fetch_assoc()) {
//        if ($iFlag)
//            $iFlag = 0;
//        else
//            $sTextZanyatiya .= ", №";
//        $sTextZanyatiya .= $row["zadanie"];
//        $iCount += $row["count"];
//    }
//    $sTextZanyatiya .= "</br>";
//    $sTextZanyatiya .= "Решено более " . $iCount . " задач</br>";
//}
//сформируем SQL-запрос

$sInitialTextZanyatiya = "";
$SqlQuery = "SELECT `zanyatie`FROM otchet WHERE `otchet`.`uchenik`='".$sUchenik."' AND `otchet`.`predmet`='".$sPredmet."' AND `otchet`.`date`='".date("Y.m.d")."';";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)) {
    while ($row = $res->fetch_assoc()) {
        $sInitialTextZanyatiya = $row['zanyatie'];
    }
}

$SqlQuery = "UPDATE `otchet` SET `zanyatie`='".$sInitialTextZanyatiya.$sTextZanyatiya."' WHERE `otchet`.`uchenik`='".$sUchenik."' AND `otchet`.`predmet`='".$sPredmet."' AND `otchet`.`date`='".date("Y.m.d")."';";

//$SqlQuery = "UPDATE `otchet` SET `zanyatie`='".$sTextZanyatiya."' WHERE `otchet`.`uchenik`='".$sUchenik."' AND `otchet`.`predmet`='".$sPredmet."' AND `otchet`.`date`='".date("Y.m.d")."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

?>