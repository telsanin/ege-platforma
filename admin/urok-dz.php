<?php
/*
административная часть сайта
формирование урока и дз для ученика
*/
?>

<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>
<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>
<input type="hidden" id="zadanie" value="<?=$iNomerZadaniya?>"></input>

<?php

if($iNomerZadaniya=='')
    echo "введите в URL номер задания!</br>";

//$SqlQuery = "SELECT * FROM `zadacha`, `zadachi-uchenika` WHERE `zadacha`.`id-zadachi`=`zadachi-uchenika`.`id-zadachi` ORDER BY `zadachi-uchenika`.`id-podtemy`;";
$SqlQuery = "SELECT * FROM `zadacha`, `uchenik-zadachi` WHERE `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' AND `zadacha`.`id-zadachi`=`uchenik-zadachi`.`id-zadachi` ORDER BY `zadacha`.`id-podtemy`;";
?>

<button id="import-zadach-ucheniku">Импорт задач и вопросов - и урок и дз</button></br></br>
Урок</br>
<button id="import-zadach-ucheniku-urok">Импорт задач и вопросов - урок</button></br></br>
<button disabled id="">Сделать новый урок - текущим</button></br></br>
Дз</br>
<button id="import-zadach-ucheniku-dz">Импорт задач и вопросов - дз</button></br></br>
<button disabled id="">Сделать новое ДЗ - текущим</button></br></br>
<!--<button>Импорт задач - урок</button></br></br>-->
<!--<button>Импорт задач - дз</button>-->

<?php

echo "Формирование УРОКА И ДЗ для ученика</br>";
echo "ученик: <b>".$sUchenik."</b></br>";
echo "предмет: <b>".$sPredmet."</b></br>";

echo "<p><b>Задачи</b>:</p>";

$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$row = $res->fetch_assoc();
$res->data_seek(0);
$iNum = 1;
$iOldIdGruppyAnalogov = $row['id-podtemy'];
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
    if($row['urok']==2) echo "<div style='color: red;'>";

    if($row['s-moimi-ciframi'])
        echo "С моими цифрами</br>";
    echo "<span style='border: solid 1px;'>".$row['zadanie']."</span>&nbsp;";
    echo $iNum++ . ") ";
    echo $row['text-zadachi']."</br>";
    if($row['foto-teksta'])
        echo "<img src='/img/".$row['foto-teksta']."'/></br>";

    echo "<b>Ответ: </b>" . $row['pravilnyi-otvet'];
    echo "</br><b>Решение:</b></br>".($row['reshenie']?$row['reshenie']:"-")."</br>";

    echo "<input ".($row['urok']==0?"checked":"")." class='radio-v-urok-uchenika' id='radio-none".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='0'><label for='radio-none".$row['id-zadachi']."''>-</label>";
    echo "<input ".($row['urok']==1?"checked":"")." class='radio-v-urok-uchenika' id='radio-urok".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='1'><label for='radio-urok".$row['id-zadachi']."'>в урок</label>";
    echo "<input ".($row['urok']==2?"checked":"")." class='radio-v-urok-uchenika' id='radio-dzvy".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='2'><label for='radio-dzvy".$row['id-zadachi']."'>в выданном дз</label>";
    echo "<input ".($row['urok']==3?"checked":"")." class='radio-v-urok-uchenika' id='radio-dzdz".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='3'><label for='radio-dzdz".$row['id-zadachi']."'>в новом дз</label></br>";

    echo "</div>";

    echo "<button>Вверх</button>&nbsp;&nbsp;<button>Вниз</button></br>";
    echo "<input type='checkbox' disabled ".($row['kolichestvo-popytok']>0?"checked":"")."><label>решал</label></br>";
    echo "<input type='checkbox' class='zadacha-uchenika-aktualna' id='aktualno".$row['id-zadachi']."' ".($row['aktualno']>0?"checked":"")."><label for='aktualno".$row['id-zadachi']."'>актуально</label></br>";
}

//Вопросы:
echo "<p><b>Вопросы</b>:</p>";
$SqlQuery = "SELECT DISTINCT `voprosy`.`id-voprosa`, `voprosy`.`text-voprosa`, `aktualno` FROM `uchenik-voprosy`, `voprosy` WHERE `uchenik-voprosy`.`id-voprosa`=`voprosy`.`id-voprosa` AND `voprosy`.`zadanie`='".$iNomerZadaniya."' AND `uchenik-voprosy`.`uchenik`='".$sUchenik."' AND `voprosy`.`predmet`='".$sPredmet."';";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$iNumDZ = 1;
while ($row = $res->fetch_assoc()) {
    echo $iNumDZ++.") ";
//    echo $row['text-voprosa'];
//    echo "<input ".($row['aktualno']==1?"checked":"")." class='vopros-aktualen' id='vopros-aktualen".$row['id-voprosa']."' type='checkbox'/><label for='vopros-aktualen".$row['id-voprosa']."'>актуален</label>";

    echo "<input ".($row['aktualno']==1?"checked":"")." class='vopros-aktualen' id='vopros-aktualen".$row['id-voprosa']."' type='checkbox'/><label for='vopros-aktualen".$row['id-voprosa']."'>".$row['text-voprosa']."</label>";



    echo "</br>";
}

?>

<!--Добавление вопроса-->

</br><b>Добавить вопрос:</b></br>
Текст:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea id="text-voprosa" cols="42" rows="5"></textarea></br>
Ответ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input size ="39" id="otvet-na-vopros"/></br>
<button id="insert-vopros-ucheniku">Добавить</button>

<!--/Добавление вопроса-->