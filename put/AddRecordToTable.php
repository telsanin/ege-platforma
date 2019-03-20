<?php

/*
Добавление записи, заданной JSON-объектом (поле-значение) в указанную таблицу БД через AJAX
Этот файл выполняется при POST-запросе AJAX (хотя по REST должен быть PUT-запрос)
Возвращает
'1' в случае успеха
'0' в случае неудачи
[ код ошибки MySql php почему-то выводить не умеет.. :( ]
*/

//подключимся к БД
$DbAccessFile = $_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;
//-подключимся к БД

//параметры полученного POST-запроса
$sTable = $_POST["sTable"];
$jData = $_POST["jData"];

//сформируем SQL-запрос
$SqlQuery = "INSERT INTO ".$sTable." ";
$SqlQuery .= "(";
foreach($jData as $key => $value) {
  $SqlQuery .= "`" . $key . "`, ";
}
//удалим последнюю запятую
$SqlQuery = substr($SqlQuery, 0, strlen($SqlQuery) - strlen(", "));
$SqlQuery .= ") ";
$SqlQuery .= "VALUES (";

foreach($jData as $key => $value) {
  $SqlQuery .= "'" . $value . "', ";
}
//удалим последнюю запятую
$SqlQuery = substr($SqlQuery, 0, strlen($SqlQuery) - strlen(", "));
$SqlQuery .= ");";

//выполним запрос
if ($mysqli->query($SqlQuery))
  echo 1;
else
  echo 0;

//отладочные строки
//echo $SqlQuery;
//echo $mysqli->error;

