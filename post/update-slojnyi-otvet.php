<?php
/*
Этот файл вызывается из ***.js
обновляет строку в таблице zadacha (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на *** строки в таблицу БД
$sSlojnyiOtvetUchenika= $_POST["sslojnyiotvetuchenika"];
$iSlojnyiOtvetNumber = $_POST["islojnyiotvetnumber"];
$sPredmet = $_POST["spredmet"];
$sUchenik = $_POST["suchenik"];
$iIdZadachi = $_POST["idzadachi"];

//сформируем SQL-запрос
$SqlQuery = "
update 
  `uchenik-zadachi` 
set 
  `slojnyi-otvet-uchenika-".$iSlojnyiOtvetNumber."`='".$sSlojnyiOtvetUchenika."', `resheno-pravilno` = -1, `kolichestvo-popytok`=1
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