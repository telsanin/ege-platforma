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

//сформируем "вопросную" часть отчета
$SqlQuery = "SELECT `text-voprosa`, `aktualno`, `otvetil` FROM `uchenik-voprosy`, `voprosy` WHERE `uchenik-voprosy`.`id-voprosa`=`voprosy`.`id-voprosa` AND `uchenik-voprosy`.`predmet`='".$sPredmet."' AND (`uchenik-voprosy`.`otvetil`=1 OR `uchenik-voprosy`.`aktualno`=1) AND `uchenik-voprosy`.`uchenik`='".$sUchenik."';";
$res = $mysqli->query($SqlQuery);
$iNumDZ = 1;
if($res->data_seek(0))
    $TextVoprosy="<b>Вопросы, к которым нужно было подготовиться:</b></br>";
    while ($row = $res->fetch_assoc()) {
        $TextVoprosy.=$iNumDZ++.") ";
        if($row['aktualno'])
            $TextVoprosy.=$row["text-voprosa"]."<font color=\'red\'> - неуверенно</font></br>";
        else
            $TextVoprosy.=$row["text-voprosa"]."<font color=\'lime\'> - успешно</font></br>";
    }
//-сформируем "вопросную" часть отчета

//обновим строку таблицы otchet
//$iCurDate=date('d.m.Y', ((int) time()/60/60/24)*24*60*60);
$dCurDate=date('Y.m.d');
$SqlQuery = "UPDATE `otchet` SET `dz-voprosy`='".$TextVoprosy."' WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."' AND `date`='".$dCurDate."';";
$res = $mysqli->query($SqlQuery);
//-обновим строку таблицы otchet

//сделаем все поля `otvetil` этого ученика = 0
$SqlQuery = "UPDATE `uchenik-voprosy` SET `otvetil`=0 WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
$res = $mysqli->query($SqlQuery);
//-сделаем все поля `otvetil` этого ученика = 0
