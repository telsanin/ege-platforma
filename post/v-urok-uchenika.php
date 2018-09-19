<?php
/*
Этот файл вызывается из .js
обновляет поле urok таблицы uchenik-zadachi (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$idZadachi=$_POST["idzadachi"];
$iVUrok=$_POST["ivurok"];
$sUchenik=$_POST["suchenik"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi` SET `urok`='".$iVUrok."' WHERE `id-zadachi`='".$idZadachi."' AND `uchenik`='".$sUchenik."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>