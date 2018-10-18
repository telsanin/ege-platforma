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
$sSsylkaNaDzReshuEge = $_POST["ssylka"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-predmet` SET `ssylka-na-dz-reshu-ege`='".$sSsylkaNaDzReshuEge."' WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>