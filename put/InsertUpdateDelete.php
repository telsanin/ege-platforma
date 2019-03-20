<?php

/*
Выполнение через AJAX любого Insert/Update/Delete SQL-запроса, заданного строкой
Этот файл выполняется при POST-запросе AJAX (хотя по REST должен быть PUT/POST/DELETE-запрос)
Возвращает
'1' в случае успеха
'0' в случае неудачи
[ код ошибки MySql php почему-то выводить не умеет.. :( ]
*/

//подключимся к БД
$DbAccessFile = $_SERVER['DOCUMENT_ROOT'] . "/_db-info.php";
include_once $DbAccessFile;
//-подключимся к БД

//параметры полученного POST-запроса
$sSqlQuery = $_POST["sSqlQuery"];

//выполним запрос
if ($mysqli->query($sSqlQuery))
	echo 'success';
else
	echo 'fail';

//отладочные строки
//echo $SqlQuery;
//echo $mysqli->error;


