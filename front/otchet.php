<?php

$SqlQuery = "SELECT * FROM `otchet` WHERE `otchet`.`predmet`='".$sPredmet."' AND `otchet`.`uchenik`='".$sUchenik."' ORDER BY `otchet`.`date`;";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)){
    echo "<p><b>Отчет по занятиям</b>:</p>";
    while ($row = $res->fetch_assoc()) {
        echo date("d:m:Y",strtotime($row['date'])) . "</br>";
        echo $row['zanyatie'] . "</br>";
        echo $row['dz'] . "</br></br>";
    }
}
