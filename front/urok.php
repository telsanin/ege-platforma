<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>
<p><b>ЗАНЯТИЕ</b></p>

<?php

/*
лицевая часть сайта (для школьников и родителей)
занятие
*/

//Задачи:
echo "<p><b>Задачи</b>:</p>";
$SqlQuery = "SELECT `uchenik-zadachi`.*, `zadacha`.`text-zadachi`, `foto-teksta`, `zadanie`, `id-podtemy` FROM `uchenik-zadachi`, `zadacha`  WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`urok`=1 AND `uchenik-zadachi`.`aktualno`=1 AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' ORDER BY `zadacha`.`zadanie`, `zadacha`.`id-podtemy`;";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$iNumDZ = 1;
$iOldIdPodtemy = 0;
$iOldNomerZadaniya = 0;
while ($row = $res->fetch_assoc()) {

    //добавление горизонтальной полосы, разделяющией разные задания
    $iNomerZadaniya = $row['zadanie'];
    if ($iOldNomerZadaniya!=0)
        //если это НЕ первая строка
        if($iNomerZadaniya!=$iOldNomerZadaniya){
            //если задание изменилось
            $iOldNomerZadaniya=$iNomerZadaniya;
            echo "</br></br><hr style='height: 1px; background-color: black;'></br>";
        }
        else{
            //добавление горизонтальной полосы, разделяющией разные подтемы
            $iIdPodtemy = $row['id-podtemy'];
            if($iIdPodtemy!=$iOldIdPodtemy){
                //если подтема изменилась
                $iOldIdPodtemy=$iIdPodtemy;
                echo "</br></br><hr></br>";
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

    echo "<span style='border: solid 1px;'>".$row['zadanie']."</span>&nbsp;";
    echo $iNumDZ++.") ";
    echo $row['text-zadachi']."</br>";
    if($row['foto-teksta'])
        echo "<img src='/img/".$row['foto-teksta']."'/></br>";
}