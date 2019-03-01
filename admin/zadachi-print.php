<?php

echo "</br>";
//echo "<input id='pokazat-vse' type='checkbox' /><label for='pokazat-vse'>показать все</label>";

echo "<input " . ($sParametr6=='vse'? "checked" : "") . " name='radio-filter' class='radio-filter' id='radio-filter-vse' type='radio'><label for='radio-filter-vse'>все</label>";
echo "<input ".($sParametr6=='' ? "checked" : "")." name='radio-filter' class='radio-filter' id='radio-filter' type='radio'><label for='radio-filter'>урокдз</label>";
echo "<input " . ($sParametr6=='urok' ? "checked" : "") . " name='radio-filter' class='radio-filter' id='radio-filter-urok' type='radio'><label for='radio-filter-urok'>урок</label>";

echo "</br></br>";

echo "<b>";
echo $sPredmet;
echo "</br>";
echo "Задание ".$iNomerZadaniya;
echo "</b>";

/*
лицевая часть сайта (для школьников и родителей)
занятие
*/

$sWhere="";
switch($sParametr6){
    case '':
    $sWhere=" AND urok<>0";
        break;
    case 'urok':
        $sWhere=" AND urok=1";
        break;
    case 'vse':
        $sWhere="";
        break;
}

//Задачи:
$SqlQuery = "SELECT `zadacha`.* FROM `zadacha`  WHERE `zadacha`.`predmet`='".$sPredmet."' AND `zadacha`.`zadanie`='".$iNomerZadaniya."'".$sWhere." ORDER BY `id-podtemy`, `sortirovka`;";
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

        //echo "<div urok='".$row['urok']."'".($row['urok']==0 ? " style='display: none'" : "").">";
    echo "<div>";


//    echo $iNumDZ++.") ";
//    echo $iNumDZ++ . "/".$num_rows.")&nbsp;";
//    echo "<span style='border: solid 1px;'>".$row['zadanie'].".".$row['absulutnaya-sortirovka']."</span>&nbsp;</br>";

    //    echo $iNumDZ++.") ";
  //echo $iNumDZ++ . "/".$num_rows.") ";
  echo "<span style='border: solid 1px;'>".$row['zadanie'].".".$row['absulutnaya-sortirovka']."</span>";
  if (!$row['zakonchili-na-etom'])
//    echo " ".($num_rows-$iNumDZ++ + 1);
  echo "</br>";

    echo $row['text-zadachi']."</br>";
    
    if($row['foto-teksta'])
//        echo "<img src='/img/".$row['foto-teksta']."'/></br>";
        echo "<img src='/img/".$sPredmet."-".$iNomerZadaniya."-".$row['id-zadachi'].".jpg'/></br>";

    echo "</div>";

}

echo "<input type='hidden' id='last-zadanie' value='".$iNomerZadaniya."'></input>";
