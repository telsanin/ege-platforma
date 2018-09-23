<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>
<input type="hidden" id="zadanie" value="<?=$iNomerZadaniya?>"></input>

<?php

$SqlQuery = "SELECT * FROM `zadacha` WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `id-podtemy`, `kommentarii`;";
if($sParametr5=="sort")
    $SqlQuery = "SELECT * FROM `zadacha` WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `kommentarii`;";

echo "Формирование ЗАДАЧ И ВОПРОСОВ по заданию</br>";
echo "предмет: <b>".$sPredmet."</b></br>";
echo "задание: <b>".$iNomerZadaniya."</b></br>";

echo "<p><b>ЗАДАЧИ</b>:</p>";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$row = $res->fetch_assoc();
$iOldIdGruppyAnalogov = $row['id-podtemy'];
$res->data_seek(0);
$iNum = 1;
while ($row = $res->fetch_assoc()) {
    $iIdGruppyAnalogov = $row['id-podtemy'];

    if($row['urok']==0) echo "<div style='color: black;'>";
    if($row['urok']==1) echo "<div style='color: blue;'>";
    if($row['urok']==3) echo "<div style='color: brown;'>";

//    if($row['s-moimi-ciframi'])
//        echo "С моими цифрами</br>";
    echo $iNum++ . ") ";
    echo "<span class='text-zadachi'>".$row['text-zadachi']."</span></br>";
    if($row['foto-teksta'])
        echo "<img style='width: 200px;' src='/img/".$row['foto-teksta']."'/></br>";
//    echo "<img src='/img/matematika-3-123.jpg'/></br>";
    echo "<b>Ответ: </b><span class='pravilnyi-otvet'>".$row['pravilnyi-otvet']."</span>";
//    echo "</br><b>Решение:</b></br>".($row['reshenie']?$row['reshenie']:"-")."</br>";
    echo "</br>Решение:</br>";
    echo "<textarea class='reshenie' id='reshenie".$row['id-zadachi']."' cols='42' rows='7'>".$row['reshenie']."</textarea></br>";
    echo "<input disabled ".($row['s-moimi-ciframi']==1?"checked":"")." class='s-moimi-ciframi' id='s-moimi-ciframi".$row['id-zadachi']."' type='checkbox'/><label for='s-moimi-ciframi".$row['id-zadachi']."'>с моими цифрами</label></br>";

    echo "<input ".($row['urok']==0?"checked":"")." class='radio-v-urok' id='radio-none".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='0'><label for='radio-none".$row['id-zadachi']."''>-</label>";
    echo "<input ".($row['urok']==1?"checked":"")." class='radio-v-urok' id='radio-urok".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='1'><label for='radio-urok".$row['id-zadachi']."'>в урок</label>";
    echo "<input ".($row['urok']==3?"checked":"")." class='radio-v-urok' id='radio-dzdz".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='3'><label for='radio-dzdz".$row['id-zadachi']."'>в дз</label></br></br>";

//    echo "</div>";

    echo "<input size=1 class='id-podtemy' id='id-podtemy".$row['id-zadachi']."' name='id-podtemy".$row['id-zadachi']."' value='".$row['id-podtemy']."'/><label for='id-podtemy".$row['id-zadachi']."'</label>&nbsp;&nbsp;&nbsp;";
    echo "<input size=31 class='kommentarii' id='kommentarii".$row['id-zadachi']."' name='kommentarii".$row['id-zadachi']."' value='".$row['kommentarii']."'/><label for='kommentarii".$row['id-zadachi']."'></label></br></br>";
    echo "<button>Вверх</button>&nbsp;&nbsp;&nbsp;<button>Вниз</button></br></br>";

    echo "<form class='upload-form' id='frm".$row['id-zadachi']."' method='post' enctype='multipart/form-data' action=''>";
    echo "<input type='file' id='file".$row['id-zadachi']."' name='file".$row['id-zadachi']."' />";
    echo "<input type='submit' value='Добавить'/>";
    echo "</form></br>";

    echo "<button class='copy-task' id='copy-task".$row['id-zadachi']."'>Скопировать задачу</button>";
    echo "</div></br>";

    if ($iIdGruppyAnalogov <> $iOldIdGruppyAnalogov) {
        $iOldIdGruppyAnalogov=$iIdGruppyAnalogov;
        echo "<button>Вверх подтему</button>&nbsp;&nbsp;<button>Вниз подтему</button>";
        echo "</br></br></br>";
    }
    else
        echo "</br>";

}
?>

<!--Добавление задачи-->

</br></br></br></br><b>Добавить задачу:</b></br>
<input type="checkbox" id="s-moimi-ciframi"/><label for="s-moimi-ciframi">С моими цифрами</label></br>
Решение:</br><textarea id="reshenie" cols='42' rows="5"></textarea></br>
Текст:</br><textarea id="text-zadachi" cols='42' rows="5"></textarea></br>
Ответ:</br><input size="39" id="pravilnyi-otvet"/></br></br>

<form id="fileForm" method="post" enctype="multipart/form-data" action="">
    <input type="file" id="file" name="file" /></br></br>
    <input type="submit" id="btn" value="Добавить" />
</form>

<!--<button id="insert-zadacha">Добавить</button>-->
<!--/Добавление задачи-->

<?php

//Вопросы:
echo "</br></br></br><p><b>ВОПРОСЫ</b>:</p>";
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
Текст:</br><textarea cols="42" id="text-voprosa" rows="5"></textarea></br>
Ответ:</br><input size="39" id="otvet-na-vopros"/></br></br>
<button id="insert-vopros">Добавить</button>

<!--/Добавление вопроса-->