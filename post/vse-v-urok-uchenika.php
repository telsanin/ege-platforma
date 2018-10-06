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
$iUrok=$_POST["surok"];
$iZadanie=$_POST["izadanie"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi`, `zadacha` SET `uchenik-zadachi`.`urok`='".$iUrok."' WHERE `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `zadacha`.`zadanie`='".$iZadanie."' AND `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi`;";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>