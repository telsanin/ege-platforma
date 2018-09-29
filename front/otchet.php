<?php

$SqlQuery = "SELECT `plan-obucheniya` FROM `uchenik` WHERE `uchenik`.`uchenik`='".$sUchenik."';";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0))
    while ($row = $res->fetch_assoc()) {
        echo $row['plan-obucheniya'];
    }

$SqlQuery = "SELECT * FROM `otchet` WHERE `otchet`.`predmet`='".$sPredmet."' AND `otchet`.`uchenik`='".$sUchenik."' ORDER BY `otchet`.`date` DESC;";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)){
    echo "<p><b>Отчет по занятиям</b>:</p>";
    $iNum=$res->num_rows;
    while ($row = $res->fetch_assoc()) {
        echo date("d.m.Y",strtotime($row['date']))." ";
        switch (date("N",strtotime($row['date']))) {
            case 1:
                echo "ПН";
                break;
            case 2:
                echo "ВТ";
                break;
            case 3:
                echo "СР";
                break;
            case 4:
                echo "ЧТ";
                break;
            case 5:
                echo "ПТ";
                break;
            case 6:
                echo "СБ";
                break;
            case 7:
                echo "ВС";
                break;
        }
        echo "</br>";
        echo "<b>Занятие №".$iNum--."</b></br>";
        echo $row['zanyatie']."</br>";
        echo $row['dz'] . "</br>";
    }
}