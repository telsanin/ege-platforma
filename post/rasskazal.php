<?php
/*
Этот файл вызывается из ***.js
обновляет поле *** таблицы *** (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$sUchenik=$_POST["uchenik"];
$sPredmet=$_POST["predmet"];
$iVoprosNumber=$_POST["ivoprosnumber"];
$iAktualno=$_POST["iaktualno"];
$iOtvetil=($iAktualno?0:1);

//сформируем SQL-запрос
$SqlQuery = "UPDATE IGNORE `uchenik-voprosy` SET `aktualno`=".$iAktualno.", `otvetil`=".$iOtvetil." WHERE `id-voprosa`='".$iVoprosNumber."' AND `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>