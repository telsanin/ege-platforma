<?php
/*
Этот файл вызывается из front.js
обновляет поле razobrat-na-zanyatii таблицы uchenik-zadachi (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$idZadachi=$_POST["idzadachi"];
$sUchenik=$_POST["uchenik"];
$iRazobratNaZanyatii=$_POST["razobratnazanyatii"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `uchenik-zadachi` SET `razobrat-na-zanyatii`='".$iRazobratNaZanyatii."' WHERE `id-zadachi`='".$idZadachi."' AND `uchenik`='".$sUchenik."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysql_error();

?>