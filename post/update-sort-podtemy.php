<?php
/*
Этот файл вызывается из ***.js
обновляет поле *** таблицы *** (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$iIdPodtemyCurrent = $_POST["iidpodtemycurrent"];
$iIdPodtemyOther = $_POST["iidpodtemyother"];
$sPredmet = $_POST["spredmet"];
$iNomerZadaniya = $_POST["inomerzadaniya"];

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `id-podtemy`=-1 WHERE `id-podtemy`='".$iIdPodtemyCurrent."' and `predmet`='".$sPredmet."' and `zadanie`='".$iNomerZadaniya."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `id-podtemy`='".$iIdPodtemyCurrent."' WHERE `id-podtemy`='".$iIdPodtemyOther."' and `predmet`='".$sPredmet."' and `zadanie`='".$iNomerZadaniya."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `id-podtemy`='".$iIdPodtemyOther."' WHERE `id-podtemy`=-1 and `predmet`='".$sPredmet."' and `zadanie`='".$iNomerZadaniya."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

?>