<?php
/*
Этот файл вызывается из zadachi.js
обновляет поле urok таблицы zadachi (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$idZadachi=$_POST["idzadachi"];
$iVUrok=$_POST["ivurok"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `urok`='".$iVUrok."' WHERE `id-zadachi`='".$idZadachi."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>