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
$sPredmet=$_POST["spredmet"];
$iIdZadachi=$_POST["idzadachi"];
$iCheckBox=$_POST["icheckbox"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi` SET `zakonchili-na-etom`=0 WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi` SET `zakonchili-na-etom`='".$iCheckBox."' WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."' AND `id-zadachi`=".$iIdZadachi.";";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>