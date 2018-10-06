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

$SqlQuery = "select count(`kolichestvo-popytok`) as count, `kolichestvo-popytok`  from `uchenik-zadachi` where `uchenik`='".$sUchenik."' and `predmet`='".$sPredmet."' and `urok`=2 and `aktualno`=1 and `resheno-pravilno`=1 group by `kolichestvo-popytok` asc;";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)) {
    $sPopytki = "<table><tbody><tr><td>Сколько задач</td><td>С какой попытки</td></tr>";
    while ($row = $res->fetch_assoc()) {
        $sPopytki .= "<tr><td>".$row['count']."</td><td>".$row['kolichestvo-popytok']."</td></tr>";
    }
    $sPopytki .= "</tbody></table>";
}

//сформируем "задачную" часть отчета
$SqlQuery = "SELECT * FROM `uchenik-zadachi` WHERE `aktualno`=1 AND `urok`=2 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."';";
$res = $mysqli->query($SqlQuery);
$iVsego = 0;
$iReshal = 0;
$iPravilno = 0;
$iSumPopytok = 0;
$iSumVremya = 0;
$iOtmechenoRazobrat = 0;
$TextZadachi='';
if($res->data_seek(0)) {
    $TextZadachi = "<b>Задачи, которые нужно было решить:</b></br>";
    while ($row = $res->fetch_assoc()) {
        $iVsego++;
        if ($row['kolichestvo-popytok'])
            $iReshal++;
        if ($row['resheno-pravilno'])
            $iPravilno++;
        $iSumPopytok += $row['kolichestvo-popytok'];
        $iSumVremya += strtotime($row['vremya-vypolneniya']) - strtotime("00:00:00");
        if ($row['razobrat-na-zanyatii'])
            $iOtmechenoRazobrat++;
    }
    $iSredPopytok = round($iSumPopytok / $iReshal, 1);
    $iSredVremya = (int)($iSumVremya / $iReshal);
    $TextZadachi .= "Попытался решить: " . $iReshal . " задач из " . $iVsego . " (" . round($iReshal / $iVsego * 100) . "%)</br>";
    $TextZadachi .= "Решено правильно: " . $iPravilno . " (" . round($iPravilno / $iVsego * 100) . "%)</br>";
    $TextZadachi .=$sPopytki;
    //$TextZadachi.="Среднее количество попыток: ".$iSredPopytok."</br>";
    $TextZadachi .= "Отмечено \"не получается, разобрать на занятии\": " . $iOtmechenoRazobrat . "</br>";
    $TextZadachi .= "Среднее время выполнения: " . gmdate("H:i:s", $iSredVremya) . "</br>";
    $TextZadachi .= "Общее время выполнения: " . gmdate("H:i:s", $iSumVremya) . "</br>";
//-сформируем "задачную" часть отчета
}

//добавим строку в таблицу otchet
$iCurDate=date('Y.m.d', ((int) time()/60/60/24)*24*60*60);

//include_once $_SERVER['DOCUMENT_ROOT']."/PART_logger.php";
//logger($TextZadachi);

$SqlQuery = "INSERT INTO `otchet` (`uchenik`, `predmet`, `dz`, `date`) VALUES ('".$sUchenik."', '".$sPredmet."', '".$TextZadachi."', '".$iCurDate."');";//выполним запрос
$res = $mysqli->query($SqlQuery);

//-добавим строку в таблицу otchet