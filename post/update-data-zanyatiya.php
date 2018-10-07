<?php
/*
Этот файл вызывается из ***.js
обновляет поле *** таблицы *** (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$sUchenik = $_POST["suchenik"];
$sPredmet = $_POST["spredmet"];
$sDateFrom = $_POST["sdatefrom"];
$sDateTo = $_POST["sdateto"];

$sDateFrom = str_replace('.','-',date('Y-m-d',strtotime (str_replace('.','-',$sDateFrom))));

//сформируем SQL-запрос
$SqlQuery = "UPDATE `otchet` SET `date`='".$sDateTo."' WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."' AND `date`='".$sDateFrom."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>