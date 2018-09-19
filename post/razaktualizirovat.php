<?php
/*
Этот файл вызывается из ***.js
обновляет поле *** таблицы *** (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$sUchenik=$_POST["suchenik"];
$iNomerZadaniya=$_POST["izadanie"];
$iIdPodtemy=$_POST["idpodtemy"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi`, `zadacha` SET `uchenik-zadachi`.`aktualno`=0, `zakonchili-na-etom`=0 WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`urok`=1 AND (`zadacha`.`zadanie`<'".$iNomerZadaniya."' OR (`zadacha`.`zadanie`='".$iNomerZadaniya."' AND `zadacha`.`id-podtemy`<".$iIdPodtemy."));";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>