<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>
<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>
<input type="hidden" id="last-time" value="<?=time()*1000?>"></input>
<input type="hidden" id="last-zadacha" value="0"></input>

<!--<button id='urokdz'>урок-дз</button>-->
<!--<button id="urok">урок</button>-->
<!--<button id="dz">дз</button>-->
<!--<button id="otchet">отчет</button>-->
<!--<input id="rejim" type="checkbox" /><label for="rejim">Ученик</label>-->
</br>

<?php
/*
административная часть сайта
занятие с учеником
*/
?>

<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>

<?php

echo "<div style='position: fixed; top: 0; width: 100%; align: auto; background: white;'>";
echo "<button id='urokdz'>урок-дз</button>&nbsp;&nbsp;";
echo "<button id='urok'>урок</button>&nbsp;&nbsp;";
echo "<button id='dz'>дз</button>&nbsp;&nbsp;";
echo "<button id='otchet'>отчет</button>&nbsp;&nbsp;";
echo "<input id='rejim' type='checkbox' /><label for='rejim'>Ученик</label>&nbsp;";
echo "</div>";

echo "ЗАНЯТИЕ - проведение</b></br>";
echo "ученик: <b>".$sUchenik."</b>&nbsp;&nbsp;&nbsp;";
echo "предмет: <b>".$sPredmet."</b></br>";

//Задачи:
echo "<b>Задачи</b>: ";
$SqlQuery = "SELECT `uchenik-zadachi`.*, `zadacha`.`sortirovka`, `zadacha`.`text-zadachi`, `zadanie`, `foto-teksta`, `id-podtemy`, `pravilnyi-otvet`, `reshenie` FROM `uchenik-zadachi`, `zadacha`  WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `zadacha`.`predmet`='".$sPredmet."' AND (`resheno-pravilno`<>2 OR `zakonchili-na-etom`=1) AND `uchenik-zadachi`.`urok`='1' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' ORDER BY `zakonchili-na-etom` DESC, `razobrat-na-zanyatii` DESC, `resheno-pravilno` ASC, `zadacha`.`zadanie`, `uchenik-zadachi`.`sortirovka`;";
$res = $mysqli->query($SqlQuery);

//echo "(".mysqli_num_rows($res).")";

$res->data_seek(0);
$num_rows = mysqli_num_rows($res);
$iNumDZ = 1;
$iOldIdPodtemy = 0;
$iOldNomerZadaniya = 0;
while ($row = $res->fetch_assoc()) {

    //добавление горизонтальной полосы, разделяющией разные задания
    $iNomerZadaniya = $row['zadanie'];
    $iIdPodtemy = $row['id-podtemy'];
    if ($iOldNomerZadaniya!=0)
        //если это НЕ первая строка
        if($iNomerZadaniya!=$iOldNomerZadaniya){
            //если задание изменилось
            $iOldNomerZadaniya=$iNomerZadaniya;
            echo "</br><hr style='height: 1px; background-color: black;'></br>";
        }
        else{
            //добавление горизонтальной полосы, разделяющией разные подтемы
            if($iIdPodtemy!=$iOldIdPodtemy){
                //если подтема изменилась
                $iOldIdPodtemy=$iIdPodtemy;
                echo "</br><hr></br>";
            }
            else{
                echo "</br>";
            }
            //-добавление горизонтальной полосы, разделяющией разные подтемы
        }
    else {
        //если это первая строка, инициализируем iIdPodtemy значением из первой строки
        $iOldNomerZadaniya = $iNomerZadaniya;
        $iOldIdPodtemy = $iIdPodtemy;
        echo "</br></br>";
    }
    //-добавление горизонтальной полосы, разделяющией разные задания

    if($row['urok']==0)
        if($row['resheno-pravilno']>0)
            echo "<div style='color: Gray;'>";
        else
            echo "<div style='color: Black;'>";

    if($row['urok']==1)
        if($row['resheno-pravilno']>0)
            echo "<div style='color: RoyalBlue;'>";
        else
            echo "<div style='color: Blue;'>";

    if($row['urok']==2)
        if($row['resheno-pravilno']>0)
            echo "<div style='color: IndianRed;'>";
        else
            echo "<div style='color: Red;'>";

//    if($row['urok']==3)
//        if($row['kolichestvo-popytok']>0)
//            echo "<div style='color: MediumSeaGreen;'>";
//        else
//            echo "<div style='color: Green;'>";

    echo ($row['zakonchili-na-etom']?"<b>":"");

//    echo "в среднем: ".$row['srednee-vremya-vypolneniya']."</br>";
//    echo "<button class='sbrosit-vremya'>Сбросить время</button></br>";
    echo "<span class='zadanie' style='border: solid 1px;'>".$row['zadanie']."</span>&nbsp;";
//    echo $iNumDZ++.") ";
    echo $iNumDZ++ . "/".$num_rows.") ";
    echo $row['text-zadachi']."</br>";
    if($row['foto-teksta'])
        echo "<img src='/img/".$row['foto-teksta']."'/></br>";

    echo "<b>Ответ: </b>" . $row['pravilnyi-otvet']."</br>";

    if($row['reshenie'])
        echo "</br><b>Решение:</b></br>".$row['reshenie']."</br>";
//        echo "</br><b>Решение:</b></br>".($row['reshenie']?$row['reshenie']:"-")."</br>";

//    if($row['kolichestvo-popytok'])
//        echo "<input type='checkbox' id='reshal-".$row['id-zadachi']."' disabled ".($row['kolichestvo-popytok']>0?"checked":"")."><label>решал</label>";

//    if ($row['kolichestvo-popytok'] > 0)
    switch($row['resheno-pravilno']){
        case -1:
            echo "&nbsp;<span id='result" . $row['id-zadachi'] . "' style='color: red;'>Неправильно :(</span></br>";
            break;
        case 0:
            break;
        case 1:
            echo "&nbsp;<span id='result" . $row['id-zadachi'] . "' style='color: lime;'>Правильно :)</span></br>";
            break;
        case 2:
            echo "&nbsp;<span id='result" . $row['id-zadachi'] . "' style='color: blue;'>На занятии</span></br>";
            break;
    }

    //если решено правильно с 1й попытки и не отмечено "все плохо"
    $iVsyoPloho = ($row['razobrat-na-zanyatii'] ? "checked" : "");
    if ($row['razobrat-na-zanyatii'])
        echo "<div id='div-vsyo-ploho" . $row['id-zadachi'] . "'><input disabled " . $iVsyoPloho . " class='vsyo-ploho' id='vsyo-ploho" . $row['id-zadachi'] . "' type='checkbox'/><label for='vsyo-ploho" . $row['id-zadachi'] . "'>не получается; разобрать на занятии</label></div>";
    //-если решено правильно с 1й попытки и не отмечено "все плохо"

    echo "<button class='razaktualizirovat' id='razaktualizirovat".$row['sortirovka']."'>разакт пред задания и -> в отчет</button></br>";

    echo "<div style='text-align: right;'><input ".($row['zakonchili-na-etom']==1?"checked":"")." class='zakonchili-na-etom' id='zakonchili-na-etom".$row['id-zadachi']."' type='checkbox'/><label for='zakonchili-na-etom".$row['id-zadachi']."'>последней сделали</label></div>";

    echo "<input ".($row['urok']==0?"checked":"")." class='radio-v-urok-uchenika' id='radio-none".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='0'><label for='radio-none".$row['id-zadachi']."''>-</label>";
    echo "<input ".($row['urok']==1?"checked":"")." class='radio-v-urok-uchenika' id='radio-urok".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='1'><label for='radio-urok".$row['id-zadachi']."'>в урок</label>";
    echo "<input ".($row['urok']==2?"checked":"")." class='radio-v-urok-uchenika' id='radio-dzvy".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='2'><label for='radio-dzvy".$row['id-zadachi']."'>в выданном дз</label>";
//    echo "<input ".($row['urok']==3?"checked":"")." class='radio-v-urok-uchenika' id='radio-dzdz".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='3'><label for='radio-dzdz".$row['id-zadachi']."'>в новом дз</label></br>";

//    echo "<button class='zafiksirovat-vremya' id='zafiksirovat-vremya".$row['id-zadachi']."'>Зафиксировать время</button>&nbsp;";
//    echo "<span id='fiks-vremya".$row['id-zadachi']."'></span></br>";

    echo ($row['zakonchili-na-etom']?"</b>":"");

    echo "</div>";

//    echo "<input type='checkbox' class='zadacha-uchenika-aktualna' id='aktualno".$row['id-zadachi']."' ".($row['aktualno']>0?"checked":"")."><label for='aktualno".$row['id-zadachi']."'>актуально</label></br></br>";

}

//Вопросы:
echo "</br><p><b>Вопросы (по заданию, которое последнее в уроке)</b>:</p>";
$SqlQuery = "SELECT `voprosy`.`id-voprosa`, `voprosy`.`text-voprosa`, `aktualno` FROM `uchenik-voprosy`, `voprosy` WHERE `uchenik-voprosy`.`id-voprosa`=`voprosy`.`id-voprosa` AND `voprosy`.`zadanie`='".$iNomerZadaniya."' AND `voprosy`.`predmet`='".$sPredmet."' AND `uchenik-voprosy`.`uchenik`='".$sUchenik."';";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$iNumDZ = 1;
while ($row = $res->fetch_assoc()) {
    echo $iNumDZ++.") ";
//    echo ;
    echo "<input ".($row['aktualno']==1?"checked":"")." class='vopros-aktualen' id='vopros-aktualen".$row['id-voprosa']."' type='checkbox'/><label for='vopros-aktualen".$row['id-voprosa']."'>".$row['text-voprosa']."</label>";
    echo "</br>";
}
