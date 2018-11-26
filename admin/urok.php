<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>
<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>
<input type="hidden" id="last-time" value="<?=time()*1000?>"></input>
<input type="hidden" id="last-zadacha" value="0"></input>
<input type="hidden" id="urokurok" value="urok"></input>

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

echo "</br></br>";
echo "ЗАНЯТИЕ - проведение</b></br>";
echo "ученик: <b>".$sUchenik."</b>&nbsp;&nbsp;&nbsp;";
echo "предмет: <b>".$sPredmet."</b></br>";

//Задачи:
echo "<b>Задачи</b>: ";
$SqlQuery = "SELECT `uchenik-zadachi`.*, `zadacha`.`sortirovka`, `zadacha`.`text-zadachi`, `zadanie`, `foto-teksta`, `id-podtemy`, `pravilnyi-otvet`, `reshenie`, `zadacha`.`id-podtemy`, `zadacha`.`slojnyi-otvet-1`, `zadacha`.`slojnyi-otvet-2`, `zadacha`.`slojnyi-otvet-3`, `zadacha`.`absulutnaya-sortirovka` FROM `uchenik-zadachi`, `zadacha`  WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `zadacha`.`predmet`='".$sPredmet."' AND (`reshali-na-zanyatii`<>1 OR `zakonchili-na-etom`=1) AND `uchenik-zadachi`.`urok`='1' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' ORDER BY `razobrat-na-zanyatii` DESC, `resheno-pravilno` ASC, `zadacha`.`zadanie`, `id-podtemy`, `zadacha`.`sortirovka`;";
$res = $mysqli->query($SqlQuery);
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
        if($row['resheno-pravilno']==1 or $row['reshali-na-zanyatii']==1)
            echo "<div style='color: Gray;'>";
        else
            echo "<div style='color: Black;'>";

    if($row['urok']==1)
        if($row['resheno-pravilno']==1 or $row['reshali-na-zanyatii']==1)
            echo "<div style='color: RoyalBlue;'>";
        else
            echo "<div style='color: Blue;'>";

    if($row['urok']==2)
        if($row['resheno-pravilno']==1 or $row['reshali-na-zanyatii']==1)
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
    echo "<span class='zadanie' style='display:none;'>".$row['zadanie']."</span>";
//    echo $iNumDZ++.") ";
    echo $iNumDZ++ . "/".$num_rows.") ";
    echo "<span style='border: solid 1px;'>".$row['zadanie'].".".$row['absulutnaya-sortirovka']."</span>&nbsp;</br>";

    echo $row['text-zadachi']."</br>";

    echo "<input hidden class='id-podtemy' value='".$row['id-podtemy']."' /></br>";

    if($row['foto-teksta'])
//        echo "<img src='/img/".$row['foto-teksta']."'/></br>";
        echo "<img src='/img/".$sPredmet."-".$iNomerZadaniya."-".$row['id-zadachi'].".jpg'/></br>";

    if (($sPredmet == 'matematika' && $row['zadanie']*1 >= 13) || ($sPredmet == 'informatika' && (($row['zadanie']*1 >= 24)||($row['slojnyi-otvet-1']!='')))) {
        //задачи с полным решением
        echo "<b>Ответы: </b></br>";
        $iSlojnyiOtvetNumber = 1;
        while($row["slojnyi-otvet-".$iSlojnyiOtvetNumber]<>"") {
            if($row["slojnyi-otvet-".$iSlojnyiOtvetNumber]=='img')
                echo "<img src='/img/".$sPredmet."-".$iNomerZadaniya."-".$row['id-zadachi']."-slojnyi-otvet-".$iSlojnyiOtvetNumber.".jpg' /></br>";
            else
//                echo $row["slojnyi-otvet-".$iSlojnyiOtvetNumber]."</span></br>";
                echo $iSlojnyiOtvetNumber . ".</br>" . $row["slojnyi-otvet-" . $iSlojnyiOtvetNumber]."</br></br>";
            $iSlojnyiOtvetNumber++;
        }
        //-задачи с полным решением
    }
    else {
        //зачачи с числовым ответом
        echo "<b>Ответ: </b>" . $row['pravilnyi-otvet']."</br>";
        //-зачачи с числовым ответом
    }


    if($row['reshenie'])
        echo "</br><b>Решение:</b></br>".$row['reshenie']."</br>";
//        echo "</br><b>Решение:</b></br>".($row['reshenie']?$row['reshenie']:"-")."</br>";

//    if($row['kolichestvo-popytok'])
//        echo "<input type='checkbox' id='reshal-".$row['id-zadachi']."' disabled ".($row['kolichestvo-popytok']>0?"checked":"")."><label>решал</label>";

    $iReshal = $row['resheno-pravilno'];
    if ($row['reshali-na-zanyatii'])
        $iReshal = 2;

//    if ($row['kolichestvo-popytok'] > 0)
    switch($row['resheno-pravilno']){
        case -1:
            echo "&nbsp;<span id='result" . $row['id-zadachi'] . "' style='color: red;'>Неправильно :(</span>&nbsp;</br>";
            break;
        case 1:
            echo "&nbsp;<span id='result" . $row['id-zadachi'] . "' style='color: lime;'>Правильно :)</span>&nbsp;</br>";
            break;
    }

    if($row['reshali-na-zanyatii'])
        echo "<span id='result" . $row['id-zadachi'] . "' style='color: blue;'>решали на занятии</span></br>";

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
//echo "(".mysqli_num_rows($res).")";

echo "<input type='hidden' id='last-zadanie' value='".$iNomerZadaniya."'></input>";

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

?>

<!--Добавление вопроса-->
<input type="hidden" id="zadanie" value="<?=$iNomerZadaniya?>"></input>

</br><b>Добавить вопрос:</b></br>
Текст:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea id="text-voprosa" cols="42" rows="5"></textarea></br>
Ответ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input size ="39" id="otvet-na-vopros"/></br>
<button id="insert-vopros-ucheniku">Добавить</button>

<!--/Добавление вопроса-->