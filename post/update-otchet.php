 <?php
/*
Этот файл вызывается из ***.js
добавляет строку в таблицу zadacha (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на добавление строки в таблицу БД
$sPredmet=$_POST["spredmet"];
$sUchenik=$_POST["suchenik"];

$sText="Занятие проведено успешно";

//сформируем SQL-запрос
$SqlQuery = "UPDATE `otchet` SET `uchenik`='".$sUchenik."', `predmet`='".$sPredmet."', `zanyatie`='".$sText."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

?>