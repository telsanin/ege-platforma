<?php
/*
Этот файл вызывается из ***.js
обновляет поле *** таблицы *** (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$idZadachi=$_POST["idzadachi"];
$sKommentarii=$_POST["skommentarii"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `kommentarii`='".$sKommentarii."' WHERE `id-zadachi`='".$idZadachi."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>