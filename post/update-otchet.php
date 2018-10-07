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
$iIdPodtemy=$_POST["idpodtemy"];
$iNomerZadaniya=$_POST["izadanie"];

$sTextZanyatiya="";
$iCount=0;
$iFlag=1;
$SqlQuery = "SELECT count(`uchenik-zadachi`.`id-zadachi`) as count, `zadanie` FROM `uchenik-zadachi`, `zadacha` WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`urok`=1 AND `aktualno`=1 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`urok`=1 AND (`zadacha`.`zadanie`<'".$iNomerZadaniya."' OR (`zadacha`.`zadanie`='".$iNomerZadaniya."' AND `zadacha`.`id-podtemy`<".$iIdPodtemy.")) GROUP BY `zadacha`.`zadanie`;";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)) {
    $sTextZanyatiya.="<b>Содержание занятия:</b></br>";
    $sTextZanyatiya.="Работа над Заданием №";
    while ($row = $res->fetch_assoc()) {
        if ($iFlag)
            $iFlag = 0;
        else
            $sTextZanyatiya .= ", №";
        $sTextZanyatiya .= $row["zadanie"];
        $iCount += $row["count"];
    }
    $sTextZanyatiya .= "</br>";
    $sTextZanyatiya .= "Решено более " . $iCount . " задач</br>";
}
//сформируем SQL-запрос
$SqlQuery = "UPDATE `otchet` SET `zanyatie`='".$sTextZanyatiya."' WHERE `otchet`.`uchenik`='".$sUchenik."' AND `otchet`.`predmet`='".$sPredmet."' AND `otchet`.`date`='".date("Y.m.d")."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

?>