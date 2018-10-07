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
    echo "<span style='color:red;'>введите в URL номер задания!</span></br>";

echo "Формирование УРОКА И ДЗ для ученика</br>";
echo "ученик: <b>".$sUchenik."</b></br>";
echo "предмет: <b>".$sPredmet."</b></br></br>";

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

echo "сделать все: <input class='vse-radio-v-urok-uchenika' id='radio-none' type='radio' value='0' /><label for='radio-none'>-</label>";
echo "<input class='vse-radio-v-urok-uchenika' id='radio-urok' type='radio' value='1' /><label style='color: blue;' for='radio-urok'>в урок</label>";
echo "<input class='vse-radio-v-urok-uchenika' id='radio-dzvy' type='radio' value='2' /><label style='color: red;' for='radio-dzvy'>в выданном дз</label>";
echo "<input class='vse-radio-v-urok-uchenika' id='radio-dzdz' type='radio' value='3' /><label style='color: green;' for='radio-dzdz'>в новом дз</label></br></br>";

echo "<span style='color: black;'>все-все: </span><input class='vse-aktualno' id='radio-aktualno-0-vse' type='radio' value='0' name='radio-aktualno-vse' /><label for='radio-aktualno-0-vse'>-</label>";
echo "<input class='vse-aktualno' id='radio-aktualno-1-vse' type='radio' value='1' name='radio-aktualno-vse' /><label for='radio-aktualno-1-vse'>актуально</label></br>";

echo "<span style='color: blue;'>все в урокe: </span><input class='vse-aktualno' id='radio-aktualno-0-vurok' type='radio' value='0' name='radio-aktualno-vurok' /><label for='radio-aktualno-0-vurok'>-</label>";
echo "<input class='vse-aktualno' id='radio-aktualno-1-vurok' type='radio' value='1' name='radio-aktualno-vurok' /><label for='radio-aktualno-1-vurok'>актуально</label></br>";

echo "<span style='color: red;'>все в выданном дз : </span><input class='vse-aktualno' id='radio-aktualno-0-vvydannomdz' type='radio' value='0' name='radio-aktualno-vvydannomdz' /><label for='radio-aktualno-0-vvydannomdz'>-</label>";
echo "<input class='vse-aktualno' id='radio-aktualno-1-vvydannomdz' type='radio' value='1' name='radio-aktualno-vvydannomdz' /><label for='radio-aktualno-1-vvydannomdz'>актуально</label></br>";

echo "<span style='color: green;'>все в новом дз: </span><input class='vse-aktualno' id='radio-aktualno-0-vnovomdz' type='radio' value='0' name='radio-aktualno-vnovomdz' /><label for='radio-aktualno-0-vnovomdz'>-</label>";
echo "<input class='vse-aktualno' id='radio-aktualno-1-vnovomdz' type='radio' value='1' name='radio-aktualno-vnovomdz' /><label for='radio-aktualno-1-vnovomdz'>актуально</label></br></br>";

echo "<button id='provereno'>Разактуализировать правильно решенные, очистить комментарий</button></br></br>";

echo "сделать нерешенные: <input class='nereshennye-radio-v-urok-uchenika' id='nereshennye-radio-none' type='radio' value='0' /><label for='nereshennye-radio-none'>-</label>";
echo "<input class='nereshennye-radio-v-urok-uchenika' id='nereshennye-radio-urok' type='radio' value='1' /><label style='color: blue;' for='nereshennye-radio-urok'>в урок</label>";
echo "<input class='nereshennye-radio-v-urok-uchenika' id='nereshennye-radio-dzvy' type='radio' value='2' /><label style='color: red;' for='nereshennye-radio-dzvy'>в выданном дз</label>";
echo "<input class='nereshennye-radio-v-urok-uchenika' id='nereshennye-radio-dzdz' type='radio' value='3' /><label style='color: green;' for='nereshennye-radio-dzdz'>в новом дз</label></br></br>";


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

    if($row['urok']==0)
        if($row['kolichestvo-popytok']>0)
            echo "<div style='color: Gray;'>";
        else
            echo "<div style='color: Black;'>";

    if($row['urok']==1)
        if($row['kolichestvo-popytok']>0)
            echo "<div style='color: RoyalBlue;'>";
        else
            echo "<div style='color: Blue;'>";

    if($row['urok']==2)
        if($row['kolichestvo-popytok']>0)
            echo "<div style='color: IndianRed;'>";
        else
            echo "<div style='color: Red;'>";

    if($row['urok']==3)
        if($row['kolichestvo-popytok']>0)
            echo "<div style='color: MediumSeaGreen;'>";
        else
            echo "<div style='color: Green;'>";



    echo ($row['zakonchili-na-etom']?"<b>":"");


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


    echo "<button>Вверх</button>&nbsp;&nbsp;<button>Вниз</button></br>";

    echo "<input ".($row['zakonchili-na-etom']==1?"checked":"")." class='zakonchili-na-etom' id='zakonchili-na-etom".$row['id-zadachi']."' type='checkbox'/><label for='zakonchili-na-etom".$row['id-zadachi']."'>последней сделали</label></br>";

    echo "<input type='checkbox' id='reshal-".$row['id-zadachi']."' disabled ".($row['kolichestvo-popytok']>0?"checked":"")."><label>решал</label>";
    if ($row['kolichestvo-popytok'] > 0)
        if ($row['resheno-pravilno'])
            echo "&nbsp;<span id='result" . $row['id-zadachi'] . "' style='color: lime;'>Правильно :)</span></br>";
        else
            echo "&nbsp;<span id='result" . $row['id-zadachi'] . "' style='color: red;'>Неправильно :(</span></br>";
    else
        echo "</br>";

    echo "<input type='checkbox' class='zadacha-uchenika-aktualna' id='aktualno".$row['id-zadachi']."' ".($row['aktualno']>0?"checked":"")."><label for='aktualno".$row['id-zadachi']."'>актуально</label></br>";

    echo "</div>";

    echo ($row['zakonchili-na-etom']?"</b>":"");
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