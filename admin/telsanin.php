<style type="text/css">
    table{
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
    }
</style>

<table><thead><tr>
        <th>		</th><th>	ПН	</th><th>	ВТ	</th><th>	СР	</th><th>	ЧТ	</th><th>	ПТ	</th>
    </tr><thead><tbody>
    <tr>	<td>		</td><td>		</td><td>	Артем	</td><td>		</td><td>		</td><td>		</td>	</tr>
    <tr>	<td>	16:00	</td><td>	Елизавета	</td><td>	Никита	</td><td>	Егор	</td><td>	Егор	</td><td>	Никита	</td>	</tr>
    <tr>	<td>	17:05	</td><td>	Егор	</td><td>	Андрей	</td><td>	Елизавета	</td><td>	Андрей	</td><td>	Владимир	</td>	</tr>
    <tr>	<td>	18:10	</td><td>		</td><td>		</td><td>		</td><td>	Артем	</td><td>	Даниил	</td>	</tr>
    <tr>	<td>	19:15	</td><td>	Амир </td><td>		</td><td>		</td><td>	Артем	</td><td>		</td>	</tr>
    <tr>	<td>	20:20	</td><td>	Александр </td><td>		</td><td>  </td><td>  </td><td>	Александр	</td>	</tr>
    </tbody></table></br>


<?php

$SqlQuery1 = "SELECT `uchenik`, `predmet` FROM `uchenik-zadachi` GROUP BY `uchenik`, `predmet` ORDER BY `predmet` DESC;";
$res1 = $mysqli->query($SqlQuery1);
if($res1->data_seek(0)) {
    while ($row1 = $res1->fetch_assoc()) {
        if($row1['uchenik']<>"test"){
//            echo  "<b>".$row1['uchenik']."-".$row1['predmet']."</b></br>";

            echo "<a href='/telsanin/".$row1['uchenik']."/".$row1['predmet']."/dz'>".$row1['uchenik']."-".$row1['predmet']."</a></b></br>";

            //сформируем "задачную" часть отчета
            $SqlQuery = "SELECT * FROM `uchenik-zadachi` WHERE `aktualno`=1 AND `urok`=2 AND `uchenik-zadachi`.`uchenik`='" . $row1['uchenik'] . "' AND `uchenik-zadachi`.`predmet`='" . $row1['predmet'] . "';";
            $res = $mysqli->query($SqlQuery);
            $iVsego = 0;
            $iReshal = 0;
            $iPravilno = 0;
            $iSumPopytok = 0;
            $iSumVremya = 0;
            $iOtmechenoRazobrat = 0;
            if ($res->data_seek(0)) {
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
                if ($iReshal) {
                    $iSredPopytok = round($iSumPopytok / $iReshal, 1);
                    $iSredVremya = (int)($iSumVremya / $iReshal);
                    echo "Всего было задано: ".$iVsego."</br>";
                    echo "Попытался решить: " .$iReshal."</br>";
                    echo "Отмечено \"разобрать\": " . $iOtmechenoRazobrat."</br>";
                    echo "Решено правильно: ".$iPravilno." (".round($iPravilno / $iReshal * 100)."%)</br>";
                    echo "Среднее количество попыток: " . $iSredPopytok . "</br>";
                    echo "Среднее время выполнения: " . gmdate("H:i:s", $iSredVremya) . "</br>";
                    echo "Общее время выполнения: " . gmdate("H:i:s", $iSumVremya) . "</br>";
                } else {
                    echo "-</br>";
                }
            }
            echo "Пропустил: ";
            echo "<button class='propustil' id='".$row1['uchenik']."-".$row1['predmet']."-vchera'>Вчера</button>";
            echo "&nbsp;&nbsp";
            echo "<button class='propustil' id='".$row1['uchenik']."-".$row1['predmet']."-segodnya'>Сегодня</button>";
            echo "&nbsp;&nbsp";
            echo "<button class='propustil' id='".$row1['uchenik']."-".$row1['predmet']."-zavtra'>Завтра</button>";
            echo "</br></br>";
        }
    }
}
//-сформируем "задачную" часть отчета