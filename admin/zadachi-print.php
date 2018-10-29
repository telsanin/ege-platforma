<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>
<p><b>ЗАНЯТИЕ</b></p>

<?php

/*
лицевая часть сайта (для школьников и родителей)
занятие
*/

//Задачи:
echo "<p><b>Задачи</b>:</p>";
$SqlQuery = "SELECT `zadacha`.* FROM `zadacha`  WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."' ORDER BY `id-podtemy`, `sortirovka`;";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$num_rows = mysqli_num_rows($res);
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
//            echo "</br></br><hr style='height: 1px; background-color: black;'></br>";
            echo "</br></br>===</br>";
        }
        else{
            //добавление горизонтальной полосы, разделяющией разные подтемы
            $iIdPodtemy = $row['id-podtemy'];
            if($iIdPodtemy!=$iOldIdPodtemy){
                //если подтема изменилась
                $iOldIdPodtemy=$iIdPodtemy;
//                echo "</br></br><hr></br>";
                echo "</br></br>---</br>";
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

    if($row['reshali-na-zanyatii']==1)
        echo "<div style='color: Gray;'>";
    else
        echo "<div style='color: Black;'>";

    echo ($row['zakonchili-na-etom']?"<b>":"");

    echo "<span style='border: solid 1px;'>".$row['zadanie']."</span>&nbsp;";
//    echo $iNumDZ++.") ";
    echo $iNumDZ++ . "/".$num_rows.") ";
    echo $row['text-zadachi']."</br>";
    if($row['foto-teksta'])
//        echo "<img src='/img/".$row['foto-teksta']."'/></br>";
        echo "<img src='/img/".$sPredmet."-".$iNomerZadaniya."-".$row['id-zadachi'].".jpg'/></br>";

    echo ($row['zakonchili-na-etom']?"</b>":"");

    echo "</div>";

}

echo "<input type='hidden' id='last-zadanie' value='".$iNomerZadaniya."'></input>";
