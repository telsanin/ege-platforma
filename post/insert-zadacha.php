 <?php
/*
Этот файл вызывается из ***.js
добавляет строку в таблицу zadacha (через AJAX).
*/

 //подключаем функцию логгинга чего угодно; include: если файла не будет - выдастся Warning и работа продолжится
 //работает так: logger('любой текст');
//include $_SERVER["DOCUMENT_ROOT"]."/PART_logger.php";

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на добавление строки в таблицу БД
$sPredmet=$_POST["predmet"];
$sNomerZadaniya=$_POST["nomerzadaniya"];
$sTextZadachi=$_POST["textzadachi"];
$sPravilnyiOtvet=$_POST["pravilnyiotvet"];
$sReshenie=$_POST["reshenie"];
$iSMoimiCiframi=$_POST["smoimiciframi"];

//сформируем SQL-запрос
$SqlQuery = "INSERT INTO `zadacha` (`predmet`, `zadanie`, `text-zadachi`, `pravilnyi-otvet`, `reshenie`, `s-moimi-ciframi`) VALUES ('".$sPredmet."', '".$sNomerZadaniya."', '".$sTextZadachi."','".$sPravilnyiOtvet."', '".$sReshenie."', '".$iSMoimiCiframi."');";
//выполним запрос
$res = $mysqli->query($SqlQuery);
//отладочные строки
//echo $SqlQuery;
//echo mysqli_error();

echo $mysqli->insert_id;
//logger($mysqli->insert_id);

?>