<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>
<input type="hidden" id="zadanie" value="<?=$iNomerZadaniya?>"></input>

<?php

$SqlQuery = "SELECT * FROM `zadacha` WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `id-podtemy`, `sortirovka`;";
//if($sParametr5=="sort")
//    $SqlQuery = "SELECT * FROM `zadacha` WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `kommentarii`;";

echo "Формирование ЗАДАЧ И ВОПРОСОВ по заданию</br>";
echo "предмет: <b>".$sPredmet."</b></br>";
echo "задание: <b>".$iNomerZadaniya."</b></br>";

?>

<!--Добавление задачи-->

</br><b>Добавить задачу:</b></br>
<input type="checkbox" id="s-moimi-ciframi"/><label for="s-moimi-ciframi">С моими цифрами</label></br>
Текст:</br><textarea id="text-zadachi" cols='42' rows="5"></textarea></br>
Ответ:</br><input size='39' id='pravilnyi-otvet'/></br></br>
<button id="insert-zadacha">Добавить</button></br></br>
Решение:</br><textarea id="reshenie" cols='42' rows="5"></textarea></br>
<input size=1 class="id-podtemy" id="id-podtemy" name="id-podtemy"/><label for="id-podtemy"></label>&nbsp;&nbsp;&nbsp;
<input size=31 class="kommentarii" id="kommentarii" name="kommentarii"/><label for="kommentarii"></label></br></br>

<form id="fileForm" method="post" enctype="multipart/form-data" action="">
    <input type="file" id="file" name="file" />
    <input type="submit" id="btn" value="Загрузить и добавить/обновить картинку" />
</form></br>
<!--/Добавление задачи-->

<?php

echo "<p><b>ЗАДАЧИ</b>:</p>";
$res = $mysqli->query($SqlQuery);
//$res->data_seek(0);
//$row = $res->fetch_assoc();
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
    echo $iNum++ . ")</br>";
    echo "<textarea class='text-zadachi' id='text-zadachi".$row['id-zadachi']."' cols='42' rows='7'>".$row['text-zadachi']."</textarea></br>";
//    echo "<span class='text-zadachi'>".$row['text-zadachi']."</span></br>";
//    echo "<img src='/img/matematika-3-123.jpg'/></br>";


    if (($sPredmet == 'matematika' && $row['zadanie']*1 >= 13 && $row['zadanie']*1 != 17) || ($sPredmet == 'informatika' && $row['zadanie']*1 >= 24)) {
        $iSlojnyiOtvetNumber = 1;
        while($row["slojnyi-otvet-".$iSlojnyiOtvetNumber]<>"") {
            echo "<div>";
            echo "Слож отв ".$iSlojnyiOtvetNumber.":</br>";
            echo "<input hidden class='slojnyu-otvet-number' value='".$iSlojnyiOtvetNumber."'/>";
            echo "<textarea class='slojnyi-otvet' id='slojnyi-otvet".$row['id-zadachi']."' cols='42' rows='5'>".$row["slojnyi-otvet-".$iSlojnyiOtvetNumber]."</textarea></br>";
            $iSlojnyiOtvetNumber++;
            echo "</div>";
        }
    }
    else {
        echo "<b>Ответ:</b></br>";
        echo "<textarea class='pravilnyi-otvet' id='pravilnyi-otvet" . $row['id-zadachi'] . "' cols='42' rows='1'>" . $row['pravilnyi-otvet'] . "</textarea>";
    }

//    echo "<span class='pravilnyi-otvet'>".$row['pravilnyi-otvet']."</span>";

//    $filename=$sPredmet."-".$iNomerZadaniya."-".$row['id-zadachi'].".jpg";
//    if (file_exists( $_SERVER['DOCUMENT_ROOT']."/img/".$filename))
//        echo "<img src='/img/".$filename."'/></br>";

    if($row['foto-teksta'])
//        echo "<img src='/img/".$row['foto-teksta']."'/></br>";
        echo "<img src='/img/".$sPredmet."-".$iNomerZadaniya."-".$row['id-zadachi'].".jpg'/></br>";
//    echo "</br><b>Решение:</b></br>".($row['reshenie']?$row['reshenie']:"-")."</br>";
    echo "</br>Решение:</br>";
    echo "<textarea class='reshenie' id='reshenie".$row['id-zadachi']."' cols='42' rows='7'>".$row['reshenie']."</textarea></br>";
    echo "<input disabled ".($row['s-moimi-ciframi']==1?"checked":"")." class='s-moimi-ciframi' id='s-moimi-ciframi".$row['id-zadachi']."' type='checkbox'/><label for='s-moimi-ciframi".$row['id-zadachi']."'>с моими цифрами</label></br>";

    echo "<input ".($row['urok']==0?"checked":"")." class='radio-v-urok' id='radio-none".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='0'><label for='radio-none".$row['id-zadachi']."''>-</label>";
    echo "<input ".($row['urok']==1?"checked":"")." class='radio-v-urok' id='radio-urok".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='1'><label for='radio-urok".$row['id-zadachi']."'>в урок</label>";
    echo "<input ".($row['urok']==3?"checked":"")." class='radio-v-urok' id='radio-dzdz".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='3'><label for='radio-dzdz".$row['id-zadachi']."'>в дз</label></br></br>";

//    echo "</div>";

    echo "<input size=1 class='id-podtemy' id='id-podtemy".$row['id-zadachi']."' name='id-podtemy".$row['id-zadachi']."' value='".$row['id-podtemy']."'/><label for='id-podtemy".$row['id-zadachi']."'></label>&nbsp;&nbsp;&nbsp;";
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