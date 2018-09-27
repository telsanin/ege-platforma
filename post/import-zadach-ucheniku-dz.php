<?php

/*
Этот файл вызывается из ***.js
добавляет строки в таблицу *** (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на добавление строки в таблицу БД
$sUchenik=$_POST["suchenik"];
$sPredmet=$_POST["spredmet"];
$iZadanie=$_POST["izadanie"];

//сформируем SQL-запрос
//$SqlQuery = "INSERT INTO `zadacha` (`text-zadachi`, `predmet`, `pravilnyi-otvet`, `zadanie`, `s-moimi-ciframi`) VALUES ('".$sText."','".$sPredmet."','".$sPravilnyiOtvet."','".$sNomerZadaniya."','".$iSMoimiCiframi."');";

$SqlQuery = "INSERT IGNORE INTO `uchenik-zadachi` (`id-zadachi`, `urok`, `uchenik`, `predmet`, `aktualno`) SELECT `zadacha`.`id-zadachi`, `zadacha`.`urok`, '".$sUchenik."', '".$sPredmet."', 1 FROM `zadacha` WHERE `zadacha`.`predmet` = '".$sPredmet."' AND `zadacha`.`urok`=3 AND `zadacha`.`zadanie` = ".$iZadanie.";";
//выполним запрос
$res = $mysqli->query($SqlQuery);

$SqlQuery = "INSERT IGNORE INTO `uchenik-voprosy` (`id-voprosa`, `uchenik`, `predmet`) SELECT `voprosy`.`id-voprosa`, '".$sUchenik."', '".$sPredmet."' FROM `voprosy` WHERE `voprosy`.`predmet` = '".$sPredmet."' AND `voprosy`.`zadanie` = ".$iZadanie.";";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysqli_error();

?>