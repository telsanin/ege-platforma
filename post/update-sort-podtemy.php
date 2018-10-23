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

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `id-podtemy`=-1 WHERE `id-podtemy`='".$iIdPodtemyCurrent."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `id-podtemy`='".$iIdPodtemyCurrent."' WHERE `id-podtemy`='".$iIdPodtemyOther."';";
//выполним запрос
$res = $mysqli->query($SqlQuery);

//сформируем SQL-запрос
$SqlQuery = "UPDATE `zadacha` SET `id-podtemy`='".$iIdPodtemyOther."' WHERE `id-podtemy`=-1;";
//выполним запрос
$res = $mysqli->query($SqlQuery);

?>