<style type="text/css">
    table{
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid lightgray;
    }
</style>

<?php
/*
административная часть сайта
домашнее задание ученика - проверка
*/
?>

<input type="hidden" id="uchenik" value="<?=$sUchenik?>"></input>
<input type="hidden" id="predmet" value="<?=$sPredmet?>"></input>
<input type="hidden" id="last-time" value="<?=time()*1000?>"></input>
<input type="hidden" id="last-zadacha" value="0"></input>

<?php

echo "ДОМАШНЕЕ ЗАДАНИЕ - проверка</b></br>";
echo "ученик: <b>".$sUchenik."</b></br>";
echo "предмет: <b>".$sPredmet."</b></br></br>";

$SqlQuery = "SELECT `kommentarii-k-tekuschemu-dz` FROM `uchenik-predmet` WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
if($res = $mysqli->query($SqlQuery)){
$res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        echo "<font color='blue'>Комментарий:</br>".($row['kommentarii-k-tekuschemu-dz']?($row['kommentarii-k-tekuschemu-dz']."</br>"):"")."</font>";
        echo "<textarea cols='42' rows='4' id='kommentarii'>".$row['kommentarii-k-tekuschemu-dz']."</textarea></br></br>";
    }
}

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
if($res = $mysqli->query($SqlQuery)) {
    $iVsego = 0;
    $iReshal = 0;
    $iPravilno = 0;
    $iSumPopytok = 0;
    $iSumVremya = 0;
    $iOtmechenoRazobrat = 0;
    $res->data_seek(0);
    //    echo "<b>Насколько сделано ДЗ:</b></br>";
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
        echo "Попытался решить: " . $iReshal . " задач из " . $iVsego . " (" . round($iReshal / $iVsego * 100) . "%)</br>";
        echo "Решено правильно: " . $iPravilno . " (" . round($iPravilno / $iVsego * 100) . "%)</br>";
        echo $sPopytki;
        //$TextZadachi.="Среднее количество попыток: ".$iSredPopytok."</br>";
        echo "Отмечено \"не получается, разобрать на занятии\": " . $iOtmechenoRazobrat . "</br>";
        echo "Среднее время выполнения: " . gmdate("H:i:s", $iSredVremya) . "</br>";
        echo "Общее время выполнения: " . gmdate("H:i:s", $iSumVremya) . "</br>";
    } else {
        echo "Попытался решить: -</br>";
        echo "Решено правильно: -</br>";
        echo "Отмечено \"не получается, разобрать на занятии\": -</br>";
//        echo "Среднее количество попыток: -</br>";
        echo "Среднее время выполнения: -</br>";
        echo "Общее время выполнения: -</br>";
    }
}
//-сформируем "задачную" часть отчета

echo "<button id='zafiksirovat'>Задачи -> в отчет (создать)</button></br></br>";

//Вопросы:
echo "<p><b>Вопросы</b>:</p>";

$SqlQuery = "SELECT * FROM `uchenik-voprosy`, `voprosy` WHERE `uchenik-voprosy`.`id-voprosa`=`voprosy`.`id-voprosa` AND `voprosy`.`predmet`='".$sPredmet."' AND `uchenik-voprosy`.`aktualno`=1 AND `uchenik-voprosy`.`uchenik`='".$sUchenik."';";
if($res = $mysqli->query($SqlQuery)) {
    $res->data_seek(0);
    $iNumDZ = 1;
    while ($row = $res->fetch_assoc()) {
        echo $iNumDZ++ . ") ";
        //    echo $row['text-voprosa'];
        //    echo "<input class='vopros-aktualen' id='vopros-aktualen".$row['id-voprosa']."' type='checkbox'/><label for='vopros-aktualen".$row['id-voprosa']."'>рассказал</label>";
        echo "<input " . ($row['aktualno'] == 1 ? "checked" : "") . " class='otvetil' id='otvetil" . $row['id-voprosa'] . "' type='checkbox'/><label for='otvetil" . $row['id-voprosa'] . "'>" . $row['text-voprosa'] . "</label>";
        echo($row['otvet-na-vopros'] ? "</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ответ: " . $row['otvet-na-vopros'] : "");
        //    echo "<input ".($row['aktualno']==1?"checked":"")." class='otvetil' id='otvetil".$row['id-voprosa']."' type='checkbox'/>";
        echo "</br>";
    }
    echo "</br>";
}

echo "<button id='voprosy-v-otchet'>Вопросы -> в отчет (обновить)</button></br></br>";
echo "<button id='provereno'>Разактуализировать правильно решенные, очистить комментарий</button></br></br>";
echo "<button id='razakrualizirovat-vse-aktualnye'>Разактуализировать все актуальные</button></br></br>";
echo "<button id='novye-sdelat-tekuschimi'>Новые сделать текущими и актуализировать</button></br></br>";

//Задачи:
echo "<p><b>Задачи</b>:</p>";

$SqlQuery = "SELECT * FROM `uchenik-zadachi`, `zadacha`  WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`urok`='2' AND `uchenik-zadachi`.`aktualno`=1 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' ORDER BY `razobrat-na-zanyatii` DESC, `resheno-pravilno` ASC, `kolichestvo-popytok` DESC;";
if($res = $mysqli->query($SqlQuery)) {
    $res->data_seek(0);
    $tObscheeVremyaVypolneniya=0;
    $iNumDZ = 1;
    while ($row = $res->fetch_assoc()) {

        $tObscheeVremyaVypolneniya += (strtotime($row['vremya-vypolneniya']) - strtotime("00:00:00"));

        //добавление горизонтальной полосы, разделяющией разные номера заданий
        $iZadanie = $row['zadanie'];
        if ($iOldZadanie != 0)
            //если это НЕ первая строка
            if ($iZadanie != $iOldZadanie) {
                //если задание изменилось
                $iOldZadanie = $iZadanie;
                echo "<hr style='height: 1px; background-color: black;'></br>";
            } else {
                echo "</br>";
            }
        else {
            //если это первая строка, инициализируем iIdPodtemy значением из первой строки
            $iOldZadanie = $iZadanie;
        }
        //-добавление горизонтальной полосы, разделяющией разные номера заданий

        if ($row['srednee-vremya-vypolneniya'] != "00:00:00")
            echo "в среднем: " . $row['srednee-vremya-vypolneniya'] . "</br>";
        echo "<span style='border: solid 1px;'>" . $row['zadanie'] . "</span>&nbsp;";
        echo $iNumDZ++ . ") ";
        echo $row['text-zadachi'] . "</br>";
        if ($row['foto-teksta'])
            echo "<img src='/img/" . $row['foto-teksta'] . "'/></br>";

        $iVsyoPloho = ($row['razobrat-na-zanyatii'] ? "checked" : "");
        //вывод правильного ответа для тестирования
        //echo "</br>".$row['pravilnyi-otvet'];
        //-вывод правильного ответа для тестирования

        //если решено правильно с 1й попытки и не отмечено "все плохо"
        if (!($row['kolichestvo-popytok'] == 1 && !$row['razobrat-na-zanyatii'] && $row['resheno-pravilno']))
            echo "<div id='div-vsyo-ploho" . $row['id-zadachi'] . "'><input disabled " . $iVsyoPloho . " class='vsyo-ploho' id='vsyo-ploho" . $row['id-zadachi'] . "' type='checkbox'/><label for='vsyo-ploho" . $row['id-zadachi'] . "'>не получается; разобрать на занятии</label></div>";
        //-если решено правильно с 1й попытки и не отмечено "все плохо"

        if ($row['kolichestvo-popytok'] > 0)
            if ($row['resheno-pravilno'])
                echo "<div id='result" . $row['id-zadachi'] . "' style='color: lime;'>Правильно :)</div>";
            else
                echo "<div id='result" . $row['id-zadachi'] . "' style='color: red;'>Неправильно :(</div>";
        else
            if (!$row['razobrat-na-zanyatii'])
                echo "<span id='result" . $row['id-zadachi'] . "' style='color: magenta;'>Не решал!</span></br>";
        if ($row['kolichestvo-popytok'] > 0)
            echo "<div id='div-kolichestvo-popytok" . $row['id-zadachi'] . "'>с <span id='kolichestvo" . $row['id-zadachi'] . "'>" . $row['kolichestvo-popytok'] . "</span> попытки</div>";

        //если решено правильно с 1й попытки и не отмечено "все плохо"
        if (!($row['kolichestvo-popytok'] == 1 && !$row['razobrat-na-zanyatii'] && $row['resheno-pravilno'])) {
            echo "Правильный ответ:</br>" . $row['pravilnyi-otvet'];
            echo "</br>Решение:</br>" . ($row['reshenie'] ? $row['reshenie'] : "-");
            echo "</br>";
        }
        //-если решено правильно с 1й попытки и не отмечено "все плохо"

        echo $row['vremya-vypolneniya'] . "</br>";
        echo "<input type='checkbox' class='zadacha-uchenika-aktualna' id='aktualno" . $row['id-zadachi'] . "' " . ($row['aktualno'] > 0 ? "checked" : "") . "><label for='aktualno" . $row['id-zadachi'] . "'>актуально</label></br></br>";

    }
}
echo "Всего: ".date("H:i:s",intval($tObscheeVremyaVypolneniya)-3*3600)."</br></br>";
//приходится вычитать 3 часа из-за часовых поясов

?>