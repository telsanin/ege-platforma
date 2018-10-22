<?php
/*
Этот файл вызывается из ***.js
обновляет поле *** таблицы *** (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$iSelectionNumber = $_POST["icurrentid"];
$iOtherSelectionNumber = $_POST["iotherid"];
$iSortSelection = $_POST["icurrentsortnumber"];
$iSortOtherSelection = $_POST["iothersortnumber"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `sortirovka`='".$iSortOtherSelection."' WHERE `id-zadachi`='".$iSelectionNumber."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `sortirovka`='".$iSortSelection."' WHERE `id-zadachi`='".$iOtherSelectionNumber."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

?>