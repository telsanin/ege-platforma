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
$iIdZadachi=$_POST["iidzadachi"];
$iAktualno=$_POST["iaktualno"];
$sPredmet=$_POST["spredmet"];

//сформируем SQL-запрос
if($iAktualno)
    $SqlQuery = "UPDATE `uchenik-zadachi` SET `uchenik-zadachi`.`aktualno`=1 WHERE `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`id-zadachi`=".$iIdZadachi.";";
else
    $SqlQuery = "UPDATE `uchenik-zadachi` SET `uchenik-zadachi`.`aktualno`=0 WHERE `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`id-zadachi`=".$iIdZadachi.";";

//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>