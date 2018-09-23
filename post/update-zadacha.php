 <?php
/*
Этот файл вызывается из ***.js
обновляет строку в таблице zadacha (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на добавление строки в таблицу БД
$iIdZadachi=$_POST["iidzadachi"];
$sFileName=$_POST["sfilename"];

//сформируем SQL-запрос
$SqlQuery = "update `zadacha` set `foto-teksta`='".$sFileName."' where `id-zadachi`=".$iIdZadachi.";";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysqli_error();

//echo $mysqli->insert_id;

?>