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
$iSkrytReshennye=$_POST["iskrytreshennye"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-predmet` SET `skryt-reshennye`=".$iSkrytReshennye." WHERE `uchenik`='".$sUchenik."' AND `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>