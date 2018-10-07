<style type="text/css">
    table{
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid lightgray;
    }
</style>

<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>
<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>

<?php

echo "Вернуться в <a href='/telsanin/".$sUchenik."/".$sPredmet."/dz'>Домашнее задание</a></br></br>";

$SqlQuery = "SELECT `plan-obucheniya`, `propuscheno` FROM `uchenik-predmet` WHERE `uchenik-predmet`.`uchenik`='".$sUchenik."' AND `uchenik-predmet`.`predmet`='".$sPredmet."';";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)) {
    echo "<u>Общий план обучения:</u></br>";
    while ($row = $res->fetch_assoc()) {
        echo $row['plan-obucheniya'];
        $iPropuscheno=$row['propuscheno'];
    }
echo "</br>";
}

$SqlQuery = "SELECT * FROM `otchet` WHERE `otchet`.`predmet`='".$sPredmet."' AND `otchet`.`uchenik`='".$sUchenik."' ORDER BY `otchet`.`date` DESC;";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)){

    echo "<u>Отчет по занятиям:</u></br>";

    if($iPropuscheno)
        echo "</br><font color='red'>Пропущенных и пока не восстановленных занятий: </br><b>".$iPropuscheno."</b></font></br></br>";

    $iNum=$res->num_rows;
    while ($row = $res->fetch_assoc()) {
//        echo date("d.m.Y",$row['date'])." ";
        echo "<div>";
        echo "<span class='data-zanyatiya'>".date("d.m.Y",strtotime($row['date']))."</span> ";
//        echo $row['date']." ";
//        switch (date("N",$row['date'])) {
        switch (date("N",strtotime(str_replace(".","-",$row['date'])))) {
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
        echo "<input id='data-zanyatiya-input' value='".$row['date']."' />";
        echo "</br>";
        echo "<b>Занятие №".$iNum--."</b></br>";
        echo $row['dz-voprosy'];
        echo $row['dz'];
        echo $row['zanyatie'];
        echo "<textarea class='otchet-kommentarii' cols='42' rows='4' id='kommentarii-zanyatie'>".$row['zanyatie']."</textarea></br>";
        echo "<font color='blue'>".$row['zelenyi-kommentarii']."</font></br>";
        echo "<textarea class='otchet-kommentarii' style='color: blue;' cols='42' rows='4' id='kommentarii-zelenyi'>".$row['zelenyi-kommentarii']."</textarea></br>";
        echo "<font color='red'>".$row['krasnyi-kommentarii']."</font></br>";
        echo "<textarea class='otchet-kommentarii' style='color: red;' cols='42' rows='4' id='kommentarii-krasnyi'>".$row['krasnyi-kommentarii']."</textarea></br>";
        echo "</br></div>";
    }
}