<?php

/*
Этот файл вызывается из ...
... (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметр полученного GET-запроса
$iId=$_GET["idzadachi"];

//имя таблицы в БД
$DbTableName = "zadacha";
//сформируем SQL-запрос
$SqlQuery = "SELECT `zadacha`.`pravilnyi-otvet` FROM `zadacha` WHERE `zadacha`.`id-zadachi`='".$iId."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
$row = $res->fetch_assoc();
echo $row['pravilnyi-otvet'];
//отладочные строки
//echo mysql_error();