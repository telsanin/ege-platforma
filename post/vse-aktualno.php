<?php
/*
Этот файл вызывается из .js
обновляет поле urok таблицы uchenik-zadachi (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$sUchenik=$_POST["suchenik"];
$sPredmet=$_POST["spredmet"];
$iAim=$_POST["iaim"];
$iZadanie=$_POST["izadanie"];
$iAktualno=$_POST["iaktualno"];

//сформируем SQL-запрос
if($iAim==5)
    $SqlQuery = "UPDATE `uchenik-zadachi`, `zadacha` SET `uchenik-zadachi`.`aktualno`='".$iAktualno."' WHERE `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `zadacha`.`zadanie`='".$iZadanie."' AND `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi`;";
else
    $SqlQuery = "UPDATE `uchenik-zadachi`, `zadacha` SET `uchenik-zadachi`.`aktualno`='".$iAktualno."' WHERE `uchenik-zadachi`.`urok`='".$iAim."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `zadacha`.`zadanie`='".$iZadanie."' AND `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi`;";

//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>