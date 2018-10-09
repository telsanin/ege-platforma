<style type="text/css">
    table{
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid lightgray;
    }
</style>

<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>
<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>
<!--<input type="hidden" id="begin-time" value="--><?//=time()*1000?><!--"></input>-->
<input type="hidden" id="end-time" value="<?=time()*1000?>"></input>
<input type="hidden" id="last-zadacha" value="0"></input>

<?php

echo "<a href='/".$sUchenik."/".$sPredmet."/otchet'>Отчет по занятиям</a></br></br>";

if($sUchenik=='artem')
    if($sPredmet=='matematika')
        echo "Математика&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href='/".$sUchenik."/informatika/dz'>Информатика</a>";
    elseif($sPredmet=='informatika')
        echo "<a href='/".$sUchenik."/matematika/dz'>Математика</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Информатика";
?>

<p><b>ДОМАШНЕЕ ЗАДАНИЕ</b>:</p></br>

<?php

/*
лицевая часть сайта (для школьников и родителей)
домашнее задание ученика
*/

$SqlQuery = "SELECT `kommentarii-k-tekuschemu-dz`, `skryt-reshennye` FROM `uchenik-predmet` WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)){
    while ($row = $res->fetch_assoc()) {
        if ($row['kommentarii-k-tekuschemu-dz'] != '')
            echo "<font color='blue'>Комментарий:</br>" . $row['kommentarii-k-tekuschemu-dz'] . "</font></br></br>";
        $iSkrytReshennye=($row['skryt-reshennye']);
    }
}

//Вопросы:
$SqlQuery = "SELECT * FROM `uchenik-voprosy`, `voprosy` WHERE `uchenik-voprosy`.`id-voprosa`=`voprosy`.`id-voprosa` AND `voprosy`.`predmet`='".$sPredmet."' AND `uchenik-voprosy`.`aktualno`=1 AND `uchenik-voprosy`.`uchenik`='".$sUchenik."' ORDER BY `voprosy`.`zadanie`, `voprosy`.`id-voprosa`;";
$res = $mysqli->query($SqlQuery);
if($res->data_seek(0)){
    $iNumDZ = 1;
    echo "<p><b>Вопросы</b>:</p>";
    while ($row = $res->fetch_assoc()) {
        echo $iNumDZ++ . ") ";
        echo $row['text-voprosa'] . "</br>";
    }
    echo "</br>";
}

//Задачи:
$SqlQuery = "select count(`kolichestvo-popytok`) as count, `kolichestvo-popytok`  from `uchenik-zadachi` where `uchenik`='".$sUchenik."' and `predmet`='".$sPredmet."' and `urok`=2 and `aktualno`=1 and `resheno-pravilno`=1 group by `kolichestvo-popytok` asc;";
if($res = $mysqli->query($SqlQuery)) {
$res->data_seek(0);
    $sPopytki = "<table><tbody><tr><td>Сколько задач</td><td>С какой попытки</td></tr>";
    while ($row = $res->fetch_assoc()) {
        $sPopytki .= "<tr><td>".$row['count']."</td><td>".$row['kolichestvo-popytok']."</td></tr>";
    }
    $sPopytki .= "</tbody></table>";
}

//сформируем "задачную" часть отчета
$SqlQuery = "SELECT * FROM `uchenik-zadachi` WHERE `aktualno`=1 AND `urok`=2 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."';";
if($res = $mysqli->query($SqlQuery)){
    $iVsego = 0;
    $iReshal = 0;
    $iPravilno = 0;
    $iSumPopytok = 0;
    $iSumVremya = 0;
    $iOtmechenoRazobrat = 0;
    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        $iVsego++;
        if ($row['kolichestvo-popytok'])
            $iReshal++;
        if ($row['resheno-pravilno'])
            $iPravilno++;
        $iSumPopytok += $row['kolichestvo-popytok'];
        $iSumVremya += strtotime($row['vremya-vypolneniya']) - strtotime("00:00:00");
        if ($row['razobrat-na-zanyatii'])
            $iOtmechenoRazobrat++;
    }
    echo "Всего задач: ".$iVsego."</br>";
    if ($iReshal) {
        $iSredPopytok = round($iSumPopytok / $iReshal, 1);
        $iSredVremya = (int)($iSumVremya / $iReshal);
        echo "Попытался решить: ".$iReshal." (".round($iReshal / $iVsego * 100)."%)</br>";
        echo "Решено правильно: ".$iPravilno." (".round($iPravilno / $iVsego * 100)."%)</br>";
//        echo "Среднее количество попыток: " . $iSredPopytok . "</br>";
        echo $sPopytki;
        echo "Отмечено \"не получается, разобрать на занятии\": ".$iOtmechenoRazobrat."</br>";
        echo "Среднее время выполнения: ".gmdate("H:i:s", $iSredVremya)."</br>";
        echo "Общее время выполнения: ".gmdate("H:i:s", $iSumVremya)."</br>";
    }
    else {
        echo "Попытался решить: -</br>";
        echo "Решено правильно: -</br>";
        echo "Отмечено \"не получается, разобрать на занятии\": -</br>";
//        echo "Среднее количество попыток: -</br>";
        echo "Среднее время выполнения: -</br>";
        echo "Общее время выполнения: -</br>";
    }
}
//-сформируем "задачную" часть отчета

echo "</br>";

$SqlQuery = "SELECT * FROM `uchenik-zadachi`, `zadacha`  WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`aktualno`=1 AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`urok`='2' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' ORDER BY `zadacha`.`zadanie`, `zadacha`.`id-podtemy`;";
if($sParametr4=="sort")
    $SqlQuery = "SELECT * FROM `uchenik-zadachi`, `zadacha`  WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`aktualno`=1 AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`urok`='2' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' ORDER BY `zadacha`.`zadanie`, `razobrat-na-zanyatii` DESC, `resheno-pravilno` ASC, `kolichestvo-popytok` DESC;";
if($res = $mysqli->query($SqlQuery)){
//if($res->data_seek(0)){
    $res->data_seek(0);

    echo "<p><b>Задачи</b>:</p></br>";
    echo "<input type='checkbox' id='skryt-reshennye' ".($iSkrytReshennye?'checked':'')." /><label for='skryt-reshennye'>скрыть решенные правильно</label>";

    $iNumDZ = 1;
    $iOldIdPodtemy = 0;
    $iOldNomerZadaniya = 0;
    while ($row = $res->fetch_assoc()) {

        echo "<div " . (($iSkrytReshennye && $row["resheno-pravilno"]) ? "style='display: none;'" : "") . " class='zadacha' resheno-pravilno='" . $row['resheno-pravilno'] . "'>";

        //добавление горизонтальной полосы, разделяющией разные задания
        $iNomerZadaniya = $row['zadanie'];
        if ($iOldNomerZadaniya != 0)
            //если это НЕ первая строка
            if ($iNomerZadaniya != $iOldNomerZadaniya) {
                //если Задание изменилось
                $iOldNomerZadaniya = $iNomerZadaniya;
                echo "</br><hr style='height: 1px; background-color: black;'></br>";
            } else {
                //добавление горизонтальной полосы, разделяющией разные подтемы
                $iIdPodtemy = $row['id-podtemy'];
                if ($iIdPodtemy != $iOldIdPodtemy) {
                    //если подтема изменилась
                    $iOldIdPodtemy = $iIdPodtemy;
                    echo "<hr>";
                } else {
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

        //    if($row['srednee-vremya-vypolneniya']!="00:00:00")
        //        echo "в среднем: ".$row['srednee-vremya-vypolneniya']."</br>";
        echo "<span style='border: solid 1px;'>" . $row['zadanie'] . "</span>&nbsp;";
        echo $iNumDZ++ . ") ";
        echo $row['text-zadachi'] . "</br>";

        //    $filename =$sPredmet."-".$sZadanie."-".$row['id-zadachi'].".jpg";
        //    if (file_exists( $_SERVER['DOCUMENT_ROOT']."/img/".$filename))
        //        echo "<img src='/img/".$filename."'/></br>";
        if ($row['foto-teksta'])
            echo "<img src='/img/" . $row['foto-teksta'] . "'/></br>";

        $iVsyoPloho = ($row['razobrat-na-zanyatii'] ? "checked" : "");
        //вывод правильного ответа для тестирования
        //echo "</br>".$row['pravilnyi-otvet'];
        //-вывод правильного ответа для тестирования

        echo "<input type='hidden' id='vremya-predyduschih-popytok" . $row['id-zadachi'] . "' value=" . $row['vremya-vypolneniya'] . "></input>";

        if ($row['kolichestvo-popytok'] == 0) {
            echo "</br>Ответ: <input id='input" . $row['id-zadachi'] . "'></input>&nbsp;&nbsp;";
            echo "<button class='uveren' id='uveren" . $row['id-zadachi'] . "'>Уверен</button>&nbsp;&nbsp;";

            echo "<div style='display: none;' id='result" . $row['id-zadachi'] . "'></div>";
            echo "<div style='display: none;' id='kolichestvo-popytok" . $row['id-zadachi'] . "'>с <span id='kolichestvo" . $row['id-zadachi'] . "'>" . $row['kolichestvo-popytok'] . "</span> попытки</div>";
            echo "<div id='div-vsyo-ploho" . $row['id-zadachi'] . "'><input " . $iVsyoPloho . " class='vsyo-ploho' id='vsyo-ploho" . $row['id-zadachi'] . "' type='checkbox'/><label for='vsyo-ploho" . $row['id-zadachi'] . "'>не получается; разобрать на занятии</label></div>";
        }
        if ($row['kolichestvo-popytok'] > 0 && $row['resheno-pravilno']) {
            echo "<span id='result" . $row['id-zadachi'] . "' style='color: lime;'>Правильно :)</span>";
            echo "<div id='div-kolichestvo-popytok" . $row['id-zadachi'] . "'>с <span id='kolichestvo" . $row['id-zadachi'] . "'>" . $row['kolichestvo-popytok'] . "</span> попытки</div>";
        }

        if ($row['kolichestvo-popytok'] > 0 && !$row['resheno-pravilno']) {
            echo "</br>Ответ: <input id='input" . $row['id-zadachi'] . "'></input>&nbsp;&nbsp;";
            echo "<button class='uveren' id='uveren" . $row['id-zadachi'] . "'>Уверен</button>&nbsp;&nbsp;";
            echo "</br><span id='result" . $row['id-zadachi'] . "' style='color: red;'>Неправильно :(</span>";
            echo "<div id='div-kolichestvo-popytok" . $row['id-zadachi'] . "'>с <span id='kolichestvo" . $row['id-zadachi'] . "'>" . $row['kolichestvo-popytok'] . "</span> попытки</div>";
            echo "<div id='div-vsyo-ploho" . $row['id-zadachi'] . "'><input " . $iVsyoPloho . " class='vsyo-ploho' id='vsyo-ploho" . $row['id-zadachi'] . "' type='checkbox'/><label for='vsyo-ploho" . $row['id-zadachi'] . "'>не получается; разобрать на занятии</label></div>";
        }

        echo "</div>";

        //    echo "</br>";
    }
}