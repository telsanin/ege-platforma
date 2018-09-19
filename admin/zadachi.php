<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>
<input type="hidden" id="zadanie" value="<?=$iNomerZadaniya?>"></input>

<?php
$SqlQuery = "SELECT * FROM `zadacha` WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `id-podtemy`, `kommentarii`;";
if($sParametr5=="sort")
    $SqlQuery = "SELECT * FROM `zadacha` WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `kommentarii`;";

echo $sPredmet."</br>";
echo $iNomerZadaniya."</br>";

$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$row = $res->fetch_assoc();
$iOldIdGruppyAnalogov = $row['id-podtemy'];
$res->data_seek(0);
$iNum = 1;
while ($row = $res->fetch_assoc()) {
    $iIdGruppyAnalogov = $row['id-podtemy'];
    if ($iIdGruppyAnalogov <> $iOldIdGruppyAnalogov) {
        $iOldIdGruppyAnalogov=$iIdGruppyAnalogov;
        echo "</br></br><button>Вверх подтему</button>&nbsp;&nbsp;<button>Вниз подтему</button>";
        echo "</br></br><hr></br>";
    }
    else
        echo "</br></br>";

    if($row['urok']==0) echo "<div style='color: black;'>";
    if($row['urok']==1) echo "<div style='color: blue;'>";
    if($row['urok']==3) echo "<div style='color: brown;'>";

//    if($row['s-moimi-ciframi'])
//        echo "С моими цифрами</br>";
    echo $iNum++ . ") ";
    echo "<span class='text-zadachi'>".$row['text-zadachi']."</span></br>";
    echo "<b>Ответ: </b><span class='pravilnyi-otvet'>".$row['pravilnyi-otvet']."</span>";
//    echo "</br><b>Решение:</b></br>".($row['reshenie']?$row['reshenie']:"-")."</br>";
    echo "</br><b>Решение:</b></br>";
    echo "<textarea class='reshenie' id='reshenie".$row['id-zadachi']."' cols='100' rows='7'>".$row['reshenie']."</textarea></br>";
    echo "<input disabled ".($row['s-moimi-ciframi']==1?"checked":"")." class='s-moimi-ciframi' id='s-moimi-ciframi".$row['id-zadachi']."' type='checkbox'/><label for='s-moimi-ciframi".$row['id-zadachi']."'>с моими цифрами</label></br>";

    echo "<input ".($row['urok']==0?"checked":"")." class='radio-v-urok' id='radio-none".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='0'><label for='radio-none".$row['id-zadachi']."''>-</label>";
    echo "<input ".($row['urok']==1?"checked":"")." class='radio-v-urok' id='radio-urok".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='1'><label for='radio-urok".$row['id-zadachi']."'>в урок</label>";
    echo "<input ".($row['urok']==3?"checked":"")." class='radio-v-urok' id='radio-dzdz".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='3'><label for='radio-dzdz".$row['id-zadachi']."'>в дз</label></br>";

//    echo "</div>";

    echo "<button>Вверх</button>&nbsp;&nbsp;<button>Вниз</button>";
    echo "&nbsp;&nbsp;&nbsp;<input size=1 class='id-podtemy' id='id-podtemy".$row['id-zadachi']."' name='id-podtemy".$row['id-zadachi']."' value='".$row['id-podtemy']."'/><label for='id-podtemy".$row['id-zadachi']."'>&nbsp;подтема</label>";
    echo "&nbsp;&nbsp;&nbsp;<input size=40 class='kommentarii' id='kommentarii".$row['id-zadachi']."' name='kommentarii".$row['id-zadachi']."' value='".$row['kommentarii']."'/><label for='kommentarii".$row['id-zadachi']."'>&nbsp;коммент</label></br>";
    echo "<button class='copy-task' id='copy-task".$row['id-zadachi']."'>Скопировать задачу</button>";
    echo "</div>";
}
?>

<!--Добавление задачи-->

</br></br></br></br><b>Добавить задачу:</b></br>
<input type="checkbox" id="s-moimi-ciframi"/><label for="s-moimi-ciframi">С моими цифрами</label></br>
Решение: <textarea id="reshenie" cols="100" rows="5"></textarea></br>
Текст:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea id="text-zadachi" cols="100" rows="5"></textarea></br>
Ответ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="pravilnyi-otvet"/></br>
<button id="insert-zadacha">Добавить</button>

<!--/Добавление задачи-->

<?php

//Вопросы:
echo "</br></br><p><b>Вопросы</b>:</p>";
$SqlQuery = "SELECT DISTINCT `voprosy`.`id-voprosa`, `voprosy`.`text-voprosa` FROM `voprosy` WHERE `voprosy`.`predmet`='".$sPredmet."' AND `voprosy`.`zadanie`='".$iNomerZadaniya."' ;";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$iNumDZ = 1;
while ($row = $res->fetch_assoc()) {
    echo $iNumDZ++.") ";
    echo $row['text-voprosa'];
    echo "</br>";
}

?>

<!--Добавление вопроса-->

</br><b>Добавить вопрос:</b></br>
Текст:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea id="text-voprosa" cols="100" rows="5"></textarea></br>
Ответ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="otvet-na-vopros"/></br>
<button id="insert-vopros">Добавить</button>

<!--/Добавление вопроса-->