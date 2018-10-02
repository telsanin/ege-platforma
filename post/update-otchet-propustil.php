<?php
/*
Этот файл вызывается из ***.js
добавляет строку в таблицу zadacha (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на добавление строки в таблицу БД
$sUchenik=$_POST["suchenik"];
$sPredmet=$_POST["spredmet"];
$sDate=$_POST["sdate"];

$sTextZanyatiya="Занятие пропущено</br>";

//сформируем SQL-запрос
$SqlQuery = "INSERT INTO `otchet` (`uchenik`,`predmet`,`date`, `zanyatie`) VALUES ('".$sUchenik."','".$sPredmet."','".$sDate."','".$sTextZanyatiya."');";
//выполним запрос
$res = $mysqli->query($SqlQuery);

?>