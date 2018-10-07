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
$sKommentarii = $_POST["skommentarii"];
$sDate = $_POST["sdate"];
$sCvet = $_POST["scvet"];

if($sCvet=='krasnyi'||$sCvet=='zelenyi')
    $sCvet.='-kommentarii';

$sDate = date('Y-m-d',strtotime (str_replace('.','-',$sDate)));

//сформируем SQL-запрос
$SqlQuery = "UPDATE `otchet` SET `".$sCvet."`='".$sKommentarii."' WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."' AND `date`='".$sDate."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>