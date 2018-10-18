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
//$iZadanie=$_POST["izadanie"];

//сформируем SQL-запрос

//resheno-pravilno=-1 решил неправильно
//resheno-pravilno=0 не решал
//resheno-pravilno=1 решил правильно
//resheno-pravilno=2 решили на уроке
//$SqlQuery = "UPDATE `uchenik-zadachi`, `zadacha` SET `uchenik-zadachi`.`urok`='".$iUrok."' WHERE `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `zadacha`.`zadanie`='".$iZadanie."' AND `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `resheno-pravilno`<>1 AND `urok`=2;";
$SqlQuery = "UPDATE `uchenik-zadachi`, `zadacha` SET `uchenik-zadachi`.`urok`='".$iUrok."' WHERE `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `resheno-pravilno`<>1 AND `uchenik-zadachi`.`urok`=2;";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>