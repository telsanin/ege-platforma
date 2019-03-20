<?php

/*
Выполнение через AJAX любого Select SQL-запроса, заданного строкой
Этот файл выполняется при POST-запросе AJAX (хотя по REST должен быть GET-запрос)
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

//Если запрос ничего не вернет, то AJAX вернет ''
$sResult = '';
//выполним запрос
if ($oResult = $mysqli->query($sSqlQuery)) {
	while ($row = $oResult->fetch_row()) {
		$sResult = $row[0];
		echo $sResult;
	}
}
//else
//	echo 'fail';

//отладочные строки
//echo $SqlQuery;
//echo $mysqli->error;


