<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>
<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>

<input type="hidden" id="last-time" value="<?=time()*1000?>"></input>
<input type="hidden" id="last-zadacha" value="0"></input>
<?php
/*
административная часть сайта
занятие с учеником
*/
?>

<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>

<?php

echo "ЗАНЯТИЕ - проведение</b></br>";
echo "ученик: <b>".$sUchenik."</b></br>";
echo "предмет: <b>".$sPredmet."</b></br>";

//Задачи:
echo "<p><b>Задачи</b>:</p>";
$SqlQuery = "SELECT `uchenik-zadachi`.*, `zadacha`.`text-zadachi`, `zadanie`, `id-podtemy`, `pravilnyi-otvet`, `reshenie` FROM `uchenik-zadachi`, `zadacha`  WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `aktualno`=1 AND `uchenik-zadachi`.`urok`='1' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' ORDER BY `zadacha`.`zadanie`, `zadacha`.`id-podtemy`;";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
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
                echo "</br></br>";
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

    echo "<div>";

    echo "в среднем: ".$row['srednee-vremya-vypolneniya']."</br>";
    echo "<button class='sbrosit-vremya'>Сбросить время</button></br>";
    echo "<span class='zadanie' style='border: solid 1px;'>".$row['zadanie']."</span>&nbsp;";
    echo $iNumDZ++.") ";
    echo $row['text-zadachi']."</br>";
    echo "<b>Ответ: </b></br>" . $row['pravilnyi-otvet'];
    echo "</br><b>Решение:</b></br>".($row['reshenie']?$row['reshenie']:"-")."</br>";

    echo "<input ".($row['urok']==0?"checked":"")." class='radio-v-urok-uchenika' id='radio-none".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='0'><label for='radio-none".$row['id-zadachi']."''>-</label>";
    echo "<input ".($row['urok']==1?"checked":"")." class='radio-v-urok-uchenika' id='radio-urok".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='1'><label for='radio-urok".$row['id-zadachi']."'>в урок</label>";
    echo "<input ".($row['urok']==2?"checked":"")." class='radio-v-urok-uchenika' id='radio-dzvy".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='2'><label for='radio-dzvy".$row['id-zadachi']."'>в выданном дз</label>";
    echo "<input ".($row['urok']==3?"checked":"")." class='radio-v-urok-uchenika' id='radio-dzdz".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='3'><label for='radio-dzdz".$row['id-zadachi']."'>в новом дз</label></br>";

    echo "<button class='zafiksirovat-vremya' id='zafiksirovat-vremya".$row['id-zadachi']."'>Зафиксировать время</button>&nbsp;";
    echo "<span id='fiks-vremya".$row['id-zadachi']."'></span></br>";
    echo "<input ".($row['zakonchili-na-etom']==1?"checked":"")." class='zakonchili-na-etom' id='zakonchili-na-etom".$row['id-zadachi']."' type='checkbox'/><label for='zakonchili-na-etom".$row['id-zadachi']."'>последней сделали</label>";
    echo "<button class='razaktualizirovat' id='razaktualizirovat".$row['id-podtemy']."'>разактуализировать пред подтемы (и пред задания)</button>";

    echo "</div>";

}

//Вопросы:
echo "</br><p><b>Вопросы</b>:</p>";
$SqlQuery = "SELECT DISTINCT `voprosy`.`id-voprosa`, `voprosy`.`text-voprosa`, `aktualno` FROM `uchenik-voprosy`, `voprosy` WHERE `uchenik-voprosy`.`id-voprosa`=`voprosy`.`id-voprosa` AND `uchenik-voprosy`.`uchenik`='".$sUchenik."';";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$iNumDZ = 1;
while ($row = $res->fetch_assoc()) {
    echo $iNumDZ++.") ";
    echo $row['text-voprosa'];
    echo "<input ".($row['aktualno']==1?"checked":"")." class='vopros-aktualen' id='vopros-aktualen".$row['id-voprosa']."' type='checkbox'/><label for='vopros-aktualen".$row['id-voprosa']."'>актуален</label>";
    echo "</br>";
}
