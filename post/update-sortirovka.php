<?php
/*
Этот файл вызывается из ***.js
обновляет поле *** таблицы *** (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$iIdZadachi = $_POST["iidzadachi"];
$iSortirovka = $_POST["isortirovka"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `sortirovka`='".$iSortirovka."' WHERE `id-zadachi`='".$iIdZadachi."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>