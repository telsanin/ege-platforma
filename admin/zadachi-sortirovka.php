<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>
<input type="hidden" id="zadanie" value="<?=$iNomerZadaniya?>"></input>
<input type="hidden" id="selectionnumber" value=""></input>
<input type="hidden" id="selectionpodtemanumber" value=""></input>

<?php

$SqlQuery = "SELECT * FROM `zadacha` WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `id-podtemy`, `sortirovka`;";
//if($sParametr5=="sort")
//    $SqlQuery = "SELECT * FROM `zadacha` WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `kommentarii`;";

echo "Сортировка ЗАДАЧ И ВОПРОСОВ по заданию</br>";
echo "предмет: <b>".$sPredmet."</b>&nbsp;&nbsp;&nbsp;";
echo "задание: <b>".$iNomerZadaniya."</b></br>";

echo "<p><b>ЗАДАЧИ</b>:</p>";

$res = $mysqli->query($SqlQuery);
$res->data_seek(0);

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

<div style="position: fixed; right:0; top: 100px;">
    <button id='zadachi-sortirovka' style="height: 40px; background: none; border: solid 1px red;">Пересч</button></br></br></br>
    <button id='only-sort' style="height: 40px; background: none; border: solid 1px gray;">Сорт</button></br></br></br>
    <button class="sort-podtemu" id="vverh-podtemu" style="height: 40px; background: none; border: solid 1px gray;">&uarr; Подт &uarr;</button></br></br>
    <button class="sort-zadachu" id="vverh-zadachu" style="height: 40px; background: none; border: solid 1px gray;">Вверх</button></br></br>
    <button class="sort-zadachu" id="vniz-zadachu" style="height: 40px; background: none; border: solid 1px gray;">Вниз</br></button></br></br>
    <button class="sort-podtemu" id="vniz-podtemu" style="height: 40px; background: none; border: solid 1px gray;">&darr; Подт &darr;</br></button></br></br></br>
</div>

<table>
<tr>
<th>Подт</th>
<!--<th>Подт</th>-->
<th>С</th>
<th>Текст</th>
<!--<th>Отв</th>-->
<th>Картинка</th>
</tr>

<?php

$iOldIdGruppyAnalogov = '';
while ($row = $res->fetch_assoc()) {

    $iIdGruppyAnalogov = $row['id-podtemy'];
    $sTopBorderClass="";
    if($iIdGruppyAnalogov!=$iOldIdGruppyAnalogov)
        $sTopBorderClass=" trborder";
    echo "<tr podt='".$row['id-podtemy']."' class='tr-for-selection".$sTopBorderClass."' id='tr-for-selection-".$row['id-zadachi']."'>";

    echo "<td>";
    echo "<input style='border: none;' size=1 class='kommentarii' id='kommentarii".$row['id-zadachi']."' name='kommentarii".$row['id-zadachi']."' value='".$row['kommentarii']."'/>";
    echo "</td>";
//    echo "<td>";
    echo "<input type='hidden' style='border: none;' size=1 class='id-podtemy' id='id-podtemy".$row['id-zadachi']."' name='id-podtemy".$row['id-zadachi']."' value='".$row['id-podtemy']."'/>";
//    echo "</td>";
    echo "<td>";
        echo "<input style='border: none;' size=1 width='1px' class='sortirovka' id='sortirovka".$row['id-zadachi']."' name='sortirovka".$row['id-zadachi']."' value='".$row['sortirovka']."'/>";
    echo "</td>";
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