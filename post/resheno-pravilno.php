<?php
/*
Этот файл вызывается из front.js
обновляет поле resheno таблицы lenta-uchenika (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$idZadachi=$_POST["idzadachi"];
$sUchenik=$_POST["uchenik"];
$sPredmet=$_POST["predmet"];
$iResult=$_POST["result"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi` SET `resheno-pravilno`='".$iResult."' WHERE `id-zadachi`='".$idZadachi."' AND `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>