 <?php
/*
Этот файл вызывается из ***.js
обновляет строку в таблице zadacha (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на добавление строки в таблицу БД
$sFileName=$_POST["sfilename"];
$sPredmet = $_POST["spredmet"];
$sUchenik = $_POST["suchenik"];
$iIdZadachi = $_POST["idzadachi"];

//сформируем SQL-запрос
$SqlQuery = "update `uchenik-zadachi` set `foto-resheniya-uchenika`='".$sFileName."' where `id-zadachi`=".$iIdZadachi." AND `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysqli_error();

//echo $mysqli->insert_id;

?>