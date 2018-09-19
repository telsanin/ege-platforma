 <?php
/*
Этот файл вызывается из ***.js
добавляет строку в таблицу zadacha (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на добавление строки в таблицу БД
$sUchenik=$_POST["uchenik"];
$sPredmet=$_POST["predmet"];
$iIdVoprosa=$_POST["idvoprosa"];

//сформируем SQL-запрос
$SqlQuery = "INSERT INTO `uchenik-voprosy` (`uchenik`, `predmet`, `id-voprosa`, `aktualno`) VALUES ('".$sUchenik."', '".$sPredmet."', ".$iIdVoprosa.", 1);";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//отладочные строки
//echo $SqlQuery;
//echo mysqli_error();

?>