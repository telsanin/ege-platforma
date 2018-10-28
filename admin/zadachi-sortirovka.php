<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>
<input type="hidden" id="zadanie" value="<?=$iNomerZadaniya?>"></input>
<input type="hidden" id="selectionnumber" value=""></input>
<input type="hidden" id="selectionpodtemanumber" value=""></input>

<?php

$SqlQuery = "SELECT * FROM `zadacha` WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `id-podtemy`, `sortirovka`;";
//if($sParametr5=="sort")
//    $SqlQuery = "SELECT * FROM `zadacha` WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `kommentarii`;";

echo "</br></br>";
echo "Сортировка ЗАДАЧ И ВОПРОСОВ по заданию</br>";
echo "предмет: <b>".$sPredmet."</b>&nbsp;&nbsp;&nbsp;";
echo "задание: <b>".$iNomerZadaniya."</b></br>";

echo "<p><b>ЗАДАЧИ</b>:</p>";

$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$num_rows = mysqli_num_rows($res);

?>

<style type="text/css">
    table{
        border-collapse: collapse;
    }
    table, th, td {
        /*border-bottom: 1px solid lightgray;*/
        border-top: 1px solid lightgray;
        border-left: 1px solid lightgray;
        border-right: 1px solid lightgray;
    }
    .trborder td {
        border-top: solid 1px gray;
    }
</style>

<div style="position: fixed; top:0; left: 170px;">
    <button id='zadachi-sortirovka' style="height: 40px; background: white; border: solid 1px red;">По подт</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button id='only-sort' style="height: 40px; background: white; border: solid 1px gray;">По ном</button>
</div>
<div style="position: fixed; bottom:0; left: 30px;">
    <button class="sort-podtemu" id="vniz-podtemu" style="height: 40px; background: white; border: solid 1px gray;">&darr; Подт &darr;</br></button>
    <button class="sort-zadachu" id="vniz-zadachu" style="height: 40px; background: white; border: solid 1px gray;">Вниз</br></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button class="sort-zadachu" id="vverh-zadachu" style="height: 40px; background: white; border: solid 1px gray;">Вверх</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button class="sort-podtemu" id="vverh-podtemu" style="height: 40px; background: white; border: solid 1px gray;">&uarr; Подт &uarr;</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<table>
<tr>
<th>Подт</th>
<th>Ном</th>
<!--<th>С</th>-->
<th>Текст</th>
<!--<th>Отв</th>-->
<th>Картинка</th>
</tr>

<?php

$iNum=1;
$iOldIdGruppyAnalogov = '';
while ($row = $res->fetch_assoc()) {

    $iIdGruppyAnalogov = $row['id-podtemy'];
    $sTopBorderClass="";
    if($iIdGruppyAnalogov!=$iOldIdGruppyAnalogov)
        $sTopBorderClass=" trborder";
    echo "<tr podt='".$row['id-podtemy']."' class='tr-for-selection".$sTopBorderClass."' id='tr-for-selection-".$row['id-zadachi']."'>";

    echo "<td>";
    echo "<textarea cols='4' rows='5' style='border: none;' size=1 class='kommentarii' id='kommentarii".$row['id-zadachi']."' name='kommentarii".$row['id-zadachi']."'>".$row['kommentarii']."</textarea>";
    echo "</td>";
    echo "<td>";
    echo "<textarea cols='3' rows='4' style='border: none;' size=1 class='id-podtemy' id='id-podtemy".$row['id-zadachi']."' name='id-podtemy".$row['id-zadachi']."'>".$row['id-podtemy']."</textarea></br>".$iNum++."/".$num_rows;
    echo "</td>";
//    echo "<td>";
        echo "<input type='hidden' style='border: none;' size=1 width='1px' class='sortirovka' id='sortirovka".$row['id-zadachi']."' name='sortirovka".$row['id-zadachi']."' value='".$row['sortirovka']."'/>";
//    echo "</td>";
    echo "<td>";
        echo mb_substr($row['text-zadachi'],0,200,'UTF-8');
    echo "</td>";
//    echo "<td>";
//        echo $row['pravilnyi-otvet'];
//    echo "</td>";
    echo "<td width='250px'>";
        if($row['foto-teksta'])
//            echo "<img src='/img/".$row['foto-teksta']."'/></br>";
            echo "<img src='/img/".$sPredmet."-".$iNomerZadaniya."-".$row['id-zadachi'].".jpg'/></br>";
    echo "</td>";

    echo "</tr>";

    $iOldIdGruppyAnalogov = $iIdGruppyAnalogov;

}

?>

</table>