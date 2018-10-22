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

<!--<button id='urokdz'>урок-дз</button>-->
<!--<button id="urok">урок</button>-->
<!--<button id="dz">дз</button>-->
<!--<button id="otchet">отчет</button>-->
<!--<input id="rejim" type="checkbox" /><label for="rejim">Ученик</label>-->
</br></br></br>
<?php

echo "<a href='/telsanin/".$sUchenik."/".$sPredmet."/otchet'>Отчет по занятиям</a></br>";

echo "ДОМАШНЕЕ ЗАДАНИЕ - проверка</b></br>";
//echo "ученик: <b>".$sUchenik."</b></br>";
//echo "предмет: <b>".$sPredmet."</b></br></br>";
echo "ученик: <b>".$sUchenik."</b>&nbsp;&nbsp;&nbsp;";
echo "предмет: <b>".$sPredmet."</b>&nbsp;&nbsp;&nbsp;";
echo "</br>";

$SqlQuery = "SELECT `kommentarii-k-tekuschemu-dz`, `ssylka-na-dz-reshu-ege` FROM `uchenik-predmet` WHERE `uchenik`='".$sUchenik."' AND `predmet`='".$sPredmet."';";
if($res = $mysqli->query($SqlQuery)){
$res->data_seek(0);
    while ($row = $res->fetch_assoc()) {
        echo "<font color='blue'>Комментарий:</br>".($row['kommentarii-k-tekuschemu-dz']?($row['kommentarii-k-tekuschemu-dz']."</br>"):"")."</font>";
        echo "<textarea cols='42' rows='4' id='kommentarii'>".$row['kommentarii-k-tekuschemu-dz']."</textarea></br>";
        echo "<font color='blue'>Ссылка на ДЗ на Решу ЭГЭ:";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        if($sPredmet=='informatika')
            echo "<a target='_blank' href='https://inf-ege.sdamgia.ru/teacher?a=tests'>Работы</a></br>";
        else
            echo "<a target='_blank' href='https://math-ege.sdamgia.ru/teacher?a=tests'>Работы</a></br>";

        echo ($row['ssylka-na-dz-reshu-ege']?($row['ssylka-na-dz-reshu-ege']):"")."</font>";



        echo "<textarea cols='42' rows='4' id='ssylka-na-dz-reshu-ege'>".$row['ssylka-na-dz-reshu-ege']."</textarea></br>";
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
//    $iVsego = 0;
//    $iReshal = 0;
//    $iPravilno = 0;
//    $iSumPopytok = 0;
//    $iSumVremya = 0;
//    $iOtmechenoRazobrat = 0;
//    $res->data_seek(0);
//    //    echo "<b>Насколько сделано ДЗ:</b></br>";
//    while ($row = $res->fetch_assoc()) {
//
//        $iVsego++;
//        if ($row['kolichestvo-popytok'])
//            $iReshal++;
//        if ($row['resheno-pravilno'])
//            $iPravilno++;
//        $iSumPopytok += $row['kolichestvo-popytok'];
//        $iSumVremya += strtotime($row['vremya-vypolneniya']) - strtotime("00:00:00");
//        if ($row['razobrat-na-zanyatii'])
//            $iOtmechenoRazobrat++;
//    }
//    echo "Всего задач: ".$iVsego."</br>";
//    if ($iReshal) {
//        $iSredPopytok = round($iSumPopytok / $iReshal, 1);
//        $iSredVremya = (int)($iSumVremya / $iReshal);
//        echo "Попытался решить: " . $iReshal . " задач из " . $iVsego . " (" . round($iReshal / $iVsego * 100) . "%)</br>";
//        echo "Решено правильно: " . $iPravilno . " (" . round($iPravilno / $iVsego * 100) . "%)</br>";
//        if($iPravilno)
//            echo $sPopytki;
//        //$TextZadachi.="Среднее количество попыток: ".$iSredPopytok."</br>";
//        echo "Отмечено \"не получается, разобрать на занятии\": " . $iOtmechenoRazobrat . "</br>";
//        echo "Среднее время выполнения: " . gmdate("H:i:s", $iSredVremya) . "</br>";
//        echo "Общее время выполнения: " . gmdate("H:i:s", $iSumVremya) . "</br>";
//    } else {
//        echo "Попытался решить: -</br>";
//        echo "Решено правильно: -</br>";
//        echo "Отмечено \"не получается, разобрать на занятии\": -</br>";
////        echo "Среднее количество попыток: -</br>";
//        echo "Среднее время выполнения: -</br>";
//        echo "Общее время выполнения: -</br>";
//    }
    $iVsego = 0;
    $iReshal = 0;
    $iPravilno = 0;
    $iNepravilno = 0;
    $iSumPopytok = 0;
    $iSumVremya = 0;
    $iOtmechenoRazobrat = 0;
    $res->data_seek(0);
    while ($row = $res->fetch_assoc()) {

//        if($row['urok']==0)
//            if($row['resheno-pravilno']>0)
//                echo "<div style='color: Gray;'>";
//            else
//                echo "<div style='color: Black;'>";

        $iVsego++;
        if ($row['kolichestvo-popytok'])
            $iReshal++;
        if ($row['resheno-pravilno']==1)
            $iPravilno++;
        if ($row['resheno-pravilno']==-1)
            $iNepravilno++;
//        $iSumPopytok += $row['kolichestvo-popytok'];
        $iSumVremya += strtotime($row['vremya-vypolneniya']) - strtotime("00:00:00");
        if ($row['razobrat-na-zanyatii'])
            $iOtmechenoRazobrat++;

//        if($row['urok']==0)
//            echo "</div>";
    }
    if ($iReshal&&$iPravilno) {
        $iSredPopytok = round($iSumPopytok / $iReshal, 1);
        $iSredVremya = (int)($iSumVremya / $iReshal);
        echo "Всего было задано: ".$iVsego."</br>";
//                    echo "Попытался решить: " .$iReshal."</br>";
        echo "Отмечено \"разобрать\": <b>".$iOtmechenoRazobrat."</b></br>";
        if($iNepravilno)
            echo "<font color='red'>Не получилось: </font><b>".$iNepravilno."</b></br>";
        if($iVsego-$iReshal)
            echo "<font color='magenta'>Не решал: </font><b>".($iVsego-$iReshal)."</b></br>";
        if($iPravilno)
            echo "<font color='lime'>Получилось: </font><b>".$iPravilno."</b> (".round($iPravilno / $iVsego * 100)."%)</br>";
//                    echo "Среднее количество попыток: " . $iSredPopytok . "</br>";
        echo "Среднее время выполнения: " . gmdate("H:i:s", $iSredVremya) . "</br>";
        echo "Общее время выполнения: " . gmdate("H:i:s", $iSumVremya) . "</br>";
        if($iPravilno)
            echo $sPopytki;
    } else {
        echo "Всего было задано: ".$iVsego."</br>";
    }
}
//-сформируем "задачную" часть отчета

echo "</br>";
echo "Задачи -> в отчет (создать)";
echo "&nbsp;&nbsp";
echo "<button class='zafiksirovat' id='zafiksirovat-segodnya'>Сег</button>";
echo "&nbsp;&nbsp";
echo "<button class='zafiksirovat' id='zafiksirovat-zavtra'>Зав</button>";
echo "&nbsp;&nbsp";
echo "<button class='zafiksirovat' id='zafiksirovat-poslezavtra'>Пос</button></br></br>";

//Вопросы:
echo "<p><b>Вопросы</b>: (!если снимаешь - он как-бы ответил!)</p>";

$SqlQuery = "SELECT * FROM `uchenik-voprosy`, `voprosy` WHERE `uchenik-voprosy`.`id-voprosa`=`voprosy`.`id-voprosa` AND `voprosy`.`predmet`='".$sPredmet."' AND `uchenik-voprosy`.`aktualno`=1 AND `uchenik-voprosy`.`uchenik`='".$sUchenik."';";
if($res = $mysqli->query($SqlQuery)) {
    $res->data_seek(0);
    $iNumDZ = 1;
    while ($row = $res->fetch_assoc()) {




//        if()
//            if()
//            else
//
//        if($row['urok']==2)
//            if($row['resheno-pravilno']>0)
//            else
//
//        if($row['urok']==3)
//            if($row['resheno-pravilno']>0)
//            else

        echo $iNumDZ++ . ") ";
        //    echo $row['text-voprosa'];
        //    echo "<input class='vopros-aktualen' id='vopros-aktualen".$row['id-voprosa']."' type='checkbox'/><label for='vopros-aktualen".$row['id-voprosa']."'>рассказал</label>";
        echo "<input " . ($row['aktualno'] == 1 ? "checked" : "") . " class='otvetil' id='otvetil" . $row['id-voprosa'] . "' type='checkbox'/><label for='otvetil" . $row['id-voprosa'] . "'>" . $row['text-voprosa'] . "</label>";
        echo($row['otvet-na-vopros'] ? "</br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ответ: " . $row['otvet-na-vopros'] : "");
        //    echo "<input ".($row['aktualno']==1?"checked":"")." class='otvetil' id='otvetil".$row['id-voprosa']."' type='checkbox'/>";
        echo "</br>";

//        echo "</div>";
    }
    echo "</br>";
}

echo "<button id='voprosy-v-otchet'>Вопросы -> в отчет (обновить)</button> (сегодня)</br></br>";
echo "<button id='provereno'>разактуал правиль решен, очис коммент</button></br></br>";
//echo "<button id='razakrualizirovat-vse-aktualnye'>Разактуализировать все актуальные</button></br></br>";
//echo "<button id='novye-sdelat-tekuschimi'>Новые сделать текущими и актуализировать</button></br></br>";

echo "нереш правиль: ";
//echo "<input class='nereshennye-radio-v-urok-uchenika' name='nereshennye-radio-v-urok-uchenika' id='nereshennye-radio-none' type='radio' value='0' /><label for='nereshennye-radio-none'>---</label>";
echo "<input class='nereshennye-radio-v-urok-uchenika' name='nereshennye-radio-v-urok-uchenika' id='nereshennye-radio-urok' type='radio' value='1' /><label style='color: blue;' for='nereshennye-radio-urok'>в урок</label>";
//echo "<input class='nereshennye-radio-v-urok-uchenika' name='nereshennye-radio-v-urok-uchenika' id='nereshennye-radio-dzvy' type='radio' value='2' /><label style='color: red;' for='nereshennye-radio-dzvy'>в выданном дз</label></br></br>";


//Задачи:
echo "<p><b>Задачи</b>:</p>";

//$SqlQuery = "SELECT `uchenik-zadachi`.* FROM `uchenik-zadachi`;";

//$SqlQuery = "SELECT `zadacha`.`pravilnyi-otvet`, `zadacha`.`zadanie`, `zadacha`.`text-zadachi`, `zadacha`.`foto-teksta`, `uchenik-zadachi`.`sortirovka`, `uchenik-zadachi`.`uchenik`, `uchenik-zadachi`.`predmet`, `uchenik-zadachi`.`urok`, `uchenik-zadachi`.`id-zadachi`, `uchenik-zadachi`.`resheno-pravilno`, `uchenik-zadachi`.`vremya-vypolneniya`, `uchenik-zadachi`.`kolichestvo-popytok`, `uchenik-zadachi`.`razobrat-na-zanyatii`, `uchenik-zadachi`.`aktualno`, `uchenik-zadachi`.`zakonchili-na-etom` FROM `uchenik-zadachi`, `zadacha`  WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`urok`='2' AND `uchenik-zadachi`.`aktualno`=1 AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' ORDER BY `razobrat-na-zanyatii` DESC, `resheno-pravilno` ASC, `kolichestvo-popytok` DESC, `zadanie`, `sortirovka`;";

$SqlQuery = "SET @num = 0; 
SELECT distinct k.* 
FROM `uchenik-zadachi` INNER JOIN (
SELECT @num:=@num+1 as `new-sortirovka`, s.* 
FROM `uchenik-zadachi` INNER JOIN (
SELECT `uchenik-zadachi`.*, `zadacha`.`pravilnyi-otvet`, `zadacha`.`zadanie`, `zadacha`.`text-zadachi`, `zadacha`.`foto-teksta`
FROM `uchenik-zadachi`, `zadacha` 
WHERE `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` AND `uchenik-zadachi`.`aktualno`=1 AND `uchenik-zadachi`.`predmet`='".$sPredmet."' AND `uchenik-zadachi`.`urok`='2' AND `uchenik-zadachi`.`uchenik`='".$sUchenik."' 
ORDER BY `zadacha`.`zadanie`, `uchenik-zadachi`.`sortirovka`) 
AS s ON s.`id-zadachi`=`uchenik-zadachi`.`id-zadachi` 
WHERE `uchenik-zadachi`.`predmet`='".$sPredmet."' AND`uchenik-zadachi`.`uchenik`='".$sUchenik."') 
as k ON k.`id-zadachi`=`uchenik-zadachi`.`id-zadachi` 
ORDER BY `razobrat-na-zanyatii` DESC, `resheno-pravilno` ASC, `kolichestvo-popytok` DESC, `zadanie`, `sortirovka`;
";


//if (!$mysqli->multi_query($SqlQuery)) {
//    echo "Не удалось выполнить мультизапрос: (" . $mysqli->errno . ") " . $mysqli->error;
//}
//do {
//    if ($res = $mysqli->store_result()) {
//        var_dump($res->fetch_all(MYSQLI_ASSOC));
//        $res->free();
//    }
//} while ($mysqli->more_results() && $mysqli->next_result());


$tObscheeVremyaVypolneniya=0;
$iNumDZ = 1;

//if($res = $mysqli->multi_query($SqlQuery)) {
//    $res->data_seek(0);
//    $num_rows = mysqli_num_rows($res);
//    while ($row = $res->fetch_assoc()) {

$res = $mysqli->multi_query($SqlQuery);
do {
    if ($res = $mysqli->store_result()) {
        $rows =  $res->fetch_all(MYSQLI_ASSOC);
        $res->free();
        $num_rows = count($rows);
        foreach($rows as $row) {

//        echo "<div>";
            if ($row['urok'] == 0)
                if ($row['resheno-pravilno'] == 1 or $row['reshali-na-zanyatii'] == 1)
                    echo "<div style='color: Gray;'>";
                else
                    echo "<div style='color: Black;'>";

            if ($row['urok'] == 1)
                if ($row['resheno-pravilno'] == 1 or $row['reshali-na-zanyatii'] == 1)
                    echo "<div style='color: RoyalBlue;'>";
                else
                    echo "<div style='color: Blue;'>";

            if ($row['urok'] == 2)
                if ($row['resheno-pravilno'] == 1 or $row['reshali-na-zanyatii'] == 1)
                    echo "<div style='color: IndianRed;'>";
                else
                    echo "<div style='color: Red;'>";

//        if($row['urok']==3)
//        if($row['resheno-pravilno']>0)
//                echo "<div style='color: MediumSeaGreen;'>";
//            else
//                echo "<div style='color: Green;'>";

            $tObscheeVremyaVypolneniya += (strtotime($row['vremya-vypolneniya']) - strtotime("00:00:00"));

            //добавление горизонтальной полосы, разделяющией разные номера заданий
            $iZadanie = $row['zadanie'];
            if ($iOldZadanie != 0)
                //если это НЕ первая строка
                if ($iZadanie != $iOldZadanie) {
                    //если задание изменилось
                    $iOldZadanie = $iZadanie;
                    echo "<hr style='height: 1px; background-color: black;'>";
                } else {
                    echo "</br>";
                }
            else {
                //если это первая строка, инициализируем iIdPodtemy значением из первой строки
                $iOldZadanie = $iZadanie;
            }
            //-добавление горизонтальной полосы, разделяющией разные номера заданий


//        if ($row['srednee-vremya-vypolneniya'] != "00:00:00")
//            echo "в среднем: " . $row['srednee-vremya-vypolneniya'] . "</br>";
            echo "<span style='border: solid 1px;'>" . $row['zadanie'] . "</span>&nbsp;";
//        echo $iNumDZ++ . ") ";
//            echo $iNumDZ++ . "/" . $num_rows . ") ";
            echo $row['new-sortirovka'] . "/" . $num_rows . ") ";
            echo $row['text-zadachi'] . "</br>";
            if ($row['foto-teksta'])
                echo "<img src='/img/" . $row['foto-teksta'] . "'/></br>";

            echo "Ответ: " . $row['pravilnyi-otvet'];
            echo "</br>";
            //если решено правильно с 1й попытки и не отмечено "все плохо"
//        if (!($row['kolichestvo-popytok'] == 1 && !$row['razobrat-na-zanyatii'] && $row['resheno-pravilno'])) {
            if ($row['reshenie'])
                echo "</br>Решение:</br>" . $row['reshenie'] . "</br>";
//              echo "</br>Решение:</br>" . ($row['reshenie'] ? $row['reshenie'] : "-");
//            echo "</br>";
//        }
            //-если решено правильно с 1й попытки и не отмечено "все плохо"

            //вывод правильного ответа для тестирования
            //echo "</br>".$row['pravilnyi-otvet'];
            //-вывод правильного ответа для тестирования

            $iReshal = $row['resheno-pravilno'];
            if ($row['reshali-na-zanyatii'])
                $iReshal = 2;

            //        echo "<input hidden id='reshal-".$row['id-zadachi']."' value='".$row['kolichest']."'/>";
//        echo "<input hidden id='reshal-".$row['id-zadachi']."' value='".($row['resheno-pravilno']>0?1:0)."'/>";
            echo "<input hidden id='reshal-" . $row['id-zadachi'] . "' value='" . $iReshal . "'/>";

            switch ($row['resheno-pravilno']) {
                case -1:
                    echo "<b><span id='result" . $row['id-zadachi'] . "' style='color: red;'>Неправильно :(</span></b>";
                    break;
                case 0:
                    echo "<b><span id='result" . $row['id-zadachi'] . "' style='color: magenta;'>Не решал!</span></b>";
                    break;
                case 1:
                    echo "<b></b><span id='result" . $row['id-zadachi'] . "' style='color: lime;'>Правильно :)</span></b>";
                    break;
            }

            if ($row['reshali-na-zanyatii'])
                echo "<b></b><span id='result" . $row['id-zadachi'] . "' style='color: blue;'>На занятии</span></b>";

            if ($row['kolichestvo-popytok'] > 0)
                echo "&nbsp;&nbsp;&nbsp;<span id='div-kolichestvo-popytok" . $row['id-zadachi'] . "'></span>с <span id='kolichestvo" . $row['id-zadachi'] . "'>" . $row['kolichestvo-popytok'] . "</span> попытки</span>&nbsp;&nbsp;&nbsp;" . $row['vremya-vypolneniya'];

            echo "</br>";

//        $iVsyoPloho = ($row['razobrat-na-zanyatii'] ? "checked" : "");
//        if (!($row['kolichestvo-popytok'] == 1 && !$row['razobrat-na-zanyatii'] && $row['resheno-pravilno']))
            if ($row['razobrat-na-zanyatii'])
//        echo "<span id='div-vsyo-ploho" . $row['id-zadachi'] . "'><input disabled " . $iVsyoPloho . " class='vsyo-ploho' id='vsyo-ploho" . $row['id-zadachi'] . "' type='checkbox'/><label for='vsyo-ploho" . $row['id-zadachi'] . "'>не получается; разобрать на занятии</label></span></br>";
                echo "<span id='div-vsyo-ploho" . $row['id-zadachi'] . "'><input disabled checked class='vsyo-ploho' id='vsyo-ploho" . $row['id-zadachi'] . "' type='checkbox'/><label for='vsyo-ploho" . $row['id-zadachi'] . "'>не получается; разобрать на занятии</label></span></br>";
//        else
//            echo "</br>";
            //-если решено правильно с 1й попытки и не отмечено "все плохо"

//        echo ;
//        echo "<input type='checkbox' class='zadacha-uchenika-aktualna' id='aktualno" . $row['id-zadachi'] . "' " . ($row['aktualno'] > 0 ? "checked" : "") . "><label for='aktualno" . $row['id-zadachi'] . "'>актуально</label></br>";

            echo "<input " . ($row['urok'] == 0 ? "checked" : "") . " class='radio-v-urok-uchenika' id='radio-none" . $row['id-zadachi'] . "' name='urok" . $row['id-zadachi'] . "' type='radio' value='0'><label for='radio-none" . $row['id-zadachi'] . "''>---</label>";
            echo "<input " . ($row['urok'] == 1 ? "checked" : "") . " class='radio-v-urok-uchenika' id='radio-urok" . $row['id-zadachi'] . "' name='urok" . $row['id-zadachi'] . "' type='radio' value='1'><label for='radio-urok" . $row['id-zadachi'] . "'>в урок</label>";
            echo "<input " . ($row['urok'] == 2 ? "checked" : "") . " class='radio-v-urok-uchenika' id='radio-dzvy" . $row['id-zadachi'] . "' name='urok" . $row['id-zadachi'] . "' type='radio' value='2'><label for='radio-dzvy" . $row['id-zadachi'] . "'>в выданном дз</label>";
//        echo "<input ".($row['urok']==3?"checked":"")." class='radio-v-urok-uchenika' id='radio-dzdz".$row['id-zadachi']."' name='urok".$row['id-zadachi']."' type='radio' value='3'><label for='radio-dzdz".$row['id-zadachi']."'>в новом дз</label></br></br>";

//        echo "</br>";
            echo "</br>";
            echo "</div>";

//        }}
        }}}
        while ($mysqli->more_results() && $mysqli->next_result());


//}

echo "</br>";

echo "<input type='hidden' id='last-zadanie' value='".$iZadanie."'></input>";

echo "Всего: ".date("H:i:s",intval($tObscheeVremyaVypolneniya)-3*3600)."</br></br>";
//приходится вычитать 3 часа из-за часовых поясов

//Вопросы:
echo "</br><p><b>Вопросы (по заданию, которое последнее в уроке)</b>:</p>";
$SqlQuery = "SELECT `voprosy`.`id-voprosa`, `voprosy`.`text-voprosa`, `aktualno` FROM `uchenik-voprosy`, `voprosy` WHERE `uchenik-voprosy`.`id-voprosa`=`voprosy`.`id-voprosa` AND `voprosy`.`zadanie`='".$iZadanie."' AND `voprosy`.`predmet`='".$sPredmet."' AND `uchenik-voprosy`.`uchenik`='".$sUchenik."';";
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