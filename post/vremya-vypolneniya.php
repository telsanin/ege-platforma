<?php
/*
Этот файл вызывается из front.js
обновляет поле $iVremyaVypolneniya таблицы uchenik-zadachi (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$idZadachi=$_POST["idzadachi"];
$sUchenik=$_POST["uchenik"];
$iVremyaVypolneniya=$_POST["vremyavypolneniya"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi` SET `vremya-vypolneniya`='".$iVremyaVypolneniya."' WHERE `id-zadachi`='".$idZadachi."' AND `uchenik`='".$sUchenik."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>