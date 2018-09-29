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
$iVoprosNumber=$_POST["ivoprosnumber"];
$iRasskazal=$_POST["irasskazal"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE IGNORE `uchenik-voprosy` SET `aktualno`=".$iRasskazal." WHERE `id-voprosa`='".$iVoprosNumber."' AND `uchenik`='".$sUchenik."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>