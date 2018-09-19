 <?php
/*
Этот файл вызывается из ***.js
добавляет строку в таблицу zadacha (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на добавление строки в таблицу БД
$sPredmet=$_POST["predmet"];
$sNomerZadaniya=$_POST["nomerzadaniya"];
$sTextVoprosa=$_POST["textvoprosa"];
$sOtvetNaVopros=$_POST["otvetnavopros"];

//сформируем SQL-запрос
$SqlQuery = "INSERT INTO `voprosy` (`predmet`, `zadanie`, `text-voprosa`, `otvet-na-vopros`) VALUES ('".$sPredmet."', '".$sNomerZadaniya."', '".$sTextVoprosa."','".$sOtvetNaVopros."');";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//узнаем id только что добавленного вопроса
$SqlQuery = "SELECT `voprosy`.`id-voprosa` FROM `voprosy` WHERE `voprosy`.`text-voprosa`='".$sTextVoprosa."';";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$row = $res->fetch_assoc();
//-узнаем id только что добавленного вопроса
echo $row['id-voprosa'];

//отладочные строки
//echo $SqlQuery;
//echo mysqli_error();

?>