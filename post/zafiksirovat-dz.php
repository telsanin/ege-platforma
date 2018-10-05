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

//сформируем "задачную" часть отчета
$SqlQuery = "SELECT * FROM `uchenik-zadachi` WHERE `aktualno`=1 AND `urok`=2 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."';";
$res = $mysqli->query($SqlQuery);
$iVsego = 0;
$iReshal = 0;
$iPravilno = 0;
$iSumPopytok = 0;
$iSumVremya = 0;
$iOtmechenoRazobrat = 0;
if($res->data_seek(0))
    $TextZadachi="<b>Задачи, которые нужно было решить:</b></br>";
    while ($row = $res->fetch_assoc()) {
        $iVsego++;
        if($row['kolichestvo-popytok'])
            $iReshal++;
        if($row['resheno-pravilno'])
            $iPravilno++;
        $iSumPopytok += $row['kolichestvo-popytok'];
        $iSumVremya += strtotime($row['vremya-vypolneniya'])-strtotime("00:00:00");
        if($row['razobrat-na-zanyatii'])
            $iOtmechenoRazobrat++;
    }
$iSredPopytok = round($iSumPopytok/$iReshal,1);
$iSredVremya = (int) ($iSumVremya/$iReshal);
$TextZadachi.="Попытался решить: ".$iReshal." задач из ".$iVsego." (".round($iReshal/$iVsego*100)."%)</br>";
$TextZadachi.="Решено правильно: ".$iPravilno." (".round($iPravilno/$iVsego*100)."%)</br>";
$TextZadachi.="Отмечено \"не понимаю; разобрать на занятии\": ".$iOtmechenoRazobrat."</br>";
$TextZadachi.="Среднее количество попыток: ".$iSredPopytok."</br>";
$TextZadachi.="Среднее время выполнения: ".gmdate("H:i:s", $iSredVremya)."</br>";
$TextZadachi.="Общее время выполнения: ".gmdate("H:i:s", $iSumVremya)."</br>";
//-сформируем "задачную" часть отчета

//добавим строку в таблицу otchet
$iCurDate=date('d.m.Y', ((int) time()/60/60/24)*24*60*60);
$SqlQuery = "INSERT INTO `otchet` (`uchenik`, `predmet`, `dz`, `date`) VALUES ('".$sUchenik."', '".$sPredmet."', '".$TextZadachi."', '".$iCurDate."');";//выполним запрос
$res = $mysqli->query($SqlQuery);
//-добавим строку в таблицу otchet