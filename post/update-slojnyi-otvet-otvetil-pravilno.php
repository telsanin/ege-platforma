<?php
/*
Этот файл вызывается из ***.js
обновляет строку в таблице zadacha (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на *** строки в таблицу БД
$iOtvetilPravilno= $_POST["iotvetilpravilno"];
$iReshenoPravino = $_POST["ireshenopravino"];
$iSlojnyiOtvetNumber = $_POST["islojnyiotvetnumber"];
$sPredmet = $_POST["spredmet"];
$sUchenik = $_POST["suchenik"];
$iIdZadachi = $_POST["idzadachi"];

//сформируем SQL-запрос
$SqlQuery = "
update 
  `uchenik-zadachi` 
set 
  `slojnyi-otvet-otvetil-pravilno-".$iSlojnyiOtvetNumber."`='".$iOtvetilPravilno."', `resheno-pravilno` = '".$iReshenoPravino."'
where 
    `uchenik`='".$sUchenik."' 
    AND `predmet`='".$sPredmet."' 
    AND `id-zadachi`='".$iIdZadachi."';
";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//отладочные строки
//echo $SqlQuery;
//echo mysqli_error();

//echo $mysqli->insert_id;

?>