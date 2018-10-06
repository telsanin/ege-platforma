<style type="text/css">
    table{
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid lightgray;
    }
</style>

<?php

echo "Вернуться в <a href='/".$sUchenik."/".$sPredmet."/dz'>Домашнее задание</a></br></br>";

$SqlQuery = "SELECT `plan-obucheniya` FROM `uchenik-predmet` WHERE `uchenik-predmet`.`uchenik`='".$sUchenik."' AND `uchenik-predmet`.`predmet`='".$sPredmet."';";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)) {
    echo "<u>Общий план обучения:</u></br>";
    while ($row = $res->fetch_assoc()) {
        echo $row['plan-obucheniya'];
    }
echo "</br>";
}

$SqlQuery = "SELECT * FROM `otchet` WHERE `otchet`.`predmet`='".$sPredmet."' AND `otchet`.`uchenik`='".$sUchenik."' ORDER BY `otchet`.`date` DESC;";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)){
    echo "<u>Отчет по занятиям:</u></br>";
    $iNum=$res->num_rows;
    while ($row = $res->fetch_assoc()) {
//        echo date("d.m.Y",$row['date'])." ";
        echo date("d.m.Y",strtotime($row['date']))." ";
//        echo $row['date']." ";
        switch (date("N",$row['date'])) {
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
        echo $row['zanyatie'];
        echo $row['dz-voprosy'];
        echo $row['dz']."</br>";
    }
}