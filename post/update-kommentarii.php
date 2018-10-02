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

//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-predmet` SET `kommentarii-k-tekuschemu-dz`='".$sKommentarii."' WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>