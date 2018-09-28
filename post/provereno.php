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

//разактуализируем решенные задачи
//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi` SET `aktualno`=0 WHERE `urok`='2' AND `resheno-pravilno`=1 AND `uchenik`='".$sUchenik."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//превратим новое дз в текущее дз
//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi` SET `urok`=2 WHERE `urok`='3' AND `uchenik`='".$sUchenik."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//добавим стоку в таблицу otchet
$sText="Домашнее задание проверено.";
$iCurDate=date('d.m.Y', ((int) time()/60/60/24)*24*60*60);
//сформируем SQL-запрос
$SqlQuery = "INSERT INTO `otchet` (`uchenik`, `predmet`, `dz`, `date`) VALUES ('".$sUchenik."', '".$sPredmet."', '".$sText."', '".$iCurDate."');";//выполним запрос
//выполним запрос
$res = $mysqli->query($SqlQuery);

?>