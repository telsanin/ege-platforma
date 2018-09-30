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

//сформируем "задачную" часть отчета
$SqlQuery = "SELECT * FROM `uchenik-zadachi` WHERE `aktualno`=1 AND `urok`=2 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' AND `uchenik-zadachi`.`predmet`='".$sPredmet."';";
$res = $mysqli->query($SqlQuery);
$iVsego = 0;
$iReshal = 0;
$iPravilno = 0;
$iSumPopytok = 0;
$iSumVremya = 0;
$iOtmechenoRazobrat = 0;
if($res->data_seek(0)) {
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
    $iSredPopytok = round($iSumPopytok / $iReshal, 1);
    $iSredVremya = (int)($iSumVremya / $iReshal);
    echo "Попытался решить: ".round($iReshal / $iVsego * 100)."% (".$iReshal." задач из ".$iVsego. ")</br>";
    echo "Отмечено \"все плохо\": " . $iOtmechenoRazobrat . " (" . round($iOtmechenoRazobrat / $iVsego * 100) . "%)</br>";
    if ($iReshal) {
        echo "Решено правильно: ".round($iPravilno / $iReshal * 100)."% (".$iPravilno.")</br>";
        echo "Среднее количество попыток: " . $iSredPopytok . "</br>";
        echo "Среднее время выполнения: " . gmdate("H:i:s", $iSredVremya) . "</br>";
        echo "Общее время выполнения: " . gmdate("H:i:s", $iSumVremya) . "</br></br>";
    } else {
        echo "Решено правильно: -</br>";
        echo "Среднее количество попыток: -</br>";
        echo "Среднее время выполнения: -</br>";
        echo "Общее время выполнения: -</br></br>";
    }
}
//-сформируем "задачную" часть отчета


echo "<p><b>Вопросы</b>:</p>";

//Вопросы:
$SqlQuery = "SELECT * FROM `uchenik-voprosy`, `voprosy` WHERE `uchenik-voprosy`.`id-voprosa`=`voprosy`.`id-voprosa` AND `voprosy`.`predmet`='".$sPredmet."' AND `uchenik-voprosy`.`aktualno`=1 AND `uchenik-voprosy`.`uchenik`='".$sUchenik."';";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$iNumDZ = 1;
while ($row = $res->fetch_assoc()) {
    echo $iNumDZ++.") ";
//    echo $row['text-voprosa'];
//    echo "<input class='vopros-aktualen' id='vopros-aktualen".$row['id-voprosa']."' type='checkbox'/><label for='vopros-aktualen".$row['id-voprosa']."'>рассказал</label>";
    echo "<input ".($row['aktualno']==1?"checked":"")." class='otvetil' id='otvetil".$row['id-voprosa']."' type='checkbox'/><label for='otvetil".$row['id-voprosa']."'>".$row['text-voprosa']."</label>";
    echo "</br>";
}
echo "</br>";

echo "<button id='zafiksirovat'>Зафиксировать для статистики</button></br></br>";
echo "<button id='provereno'>Разактуализировать правильно решенные задачи</button></br></br>";

//Задачи:
echo "<p><b>Задачи</b>:</p>";

$SqlQuery = "SELECT * FROM `uchenik-zadachi`, `zadacha`  WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`urok`='2' AND `uchenik-zadachi`.`aktualno`=1 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' ORDER BY `razobrat-na-zanyatii` DESC, `resheno-pravilno` ASC, `kolichestvo-popytok` DESC;";
$res = $mysqli->query($SqlQuery);
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
        echo "<div id='div-vsyo-ploho" . $row['id-zadachi'] . "'><input disabled " . $iVsyoPloho . " class='vsyo-ploho' id='vsyo-ploho" . $row['id-zadachi'] . "' type='checkbox'/><label for='vsyo-ploho" . $row['id-zadachi'] . "'>Не понимаю; разобрать на занятии</label></div>";
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

    echo "Всего: ".date("H:i:s",intval($tObscheeVremyaVypolneniya)-3*3600)."</br></br>";
    //приходится вычитать 3 часа из-за часовых поясов

?>