<?php
/*
Этот файл вызывается из ***.js
обновляет поле *** таблицы *** (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$sUchenik=$_POST["suchenik"];
$sPredmet=$_POST["spredmet"];

//разактуализируем правильно решенные задачи
//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi` SET `aktualno`=0 WHERE `urok`='2' AND `resheno-pravilno`=1 AND `uchenik`='".$sUchenik."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//превратим новое дз в текущее дз
//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi` SET `urok`=2 WHERE `urok`='3' AND `uchenik`='".$sUchenik."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

?>