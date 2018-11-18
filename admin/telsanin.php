<table><thead><tr>
            <th>		    </th><th>	ПН	        </th><th>	ВТ	    </th><th>	СР	        </th><th>	ЧТ	    </th><th>	ПТ	        </th>
    </tr><thead><tbody>
<tr>	    <td>		    </td><td>		        </td><td>	Артем	</td><td>		        </td><td>		    </td><td>		        </td>	</tr>
    <tr>	<td>	16:00	</td><td>	Елизавета   </td><td>	Никита	</td><td>	Егор	    </td><td>	Егор	</td><td>	Никита	    </td>	</tr>
    <tr>	<td>	17:05	</td><td>	Егор        </td><td>	Андрей	</td><td>	Елизавета	</td><td>	Андрей	</td><td>		</td>	</tr>
    <tr>	<td>	18:10	</td><td>	Виктория </td><td>	Егор	</td><td> Виктория </td><td>	Артем	</td><td>	Даниил	    </td>	</tr>
    <tr>	<td>	19:15	</td><td>	Амир        </td><td>	Илья    </td><td>   Фарид   </td><td>	Артем	</td><td>  Ростислав       </td>	</tr>
    <tr>	<td>	20:20	</td><td>	Александр   </td><td>		    </td><td>   Анастасия   </td><td>   Денис   </td><td>	Александр	</td>	</tr>
    </tbody></table></br>


<?php

$sLastPredmet='';

$SqlQuery1 = "SELECT `uchenik-zadachi`.`uchenik`, `uchenik-zadachi`.`predmet`, `propuscheno` FROM `uchenik-zadachi` INNER JOIN `uchenik-predmet` ON `uchenik-zadachi`.`uchenik`=`uchenik-predmet`.`uchenik` AND `uchenik-zadachi`.`predmet`=`uchenik-predmet`.`predmet` GROUP BY `uchenik-zadachi`.`uchenik`, `uchenik-predmet`.`predmet` ORDER BY `uchenik-predmet`.`predmet` DESC, `uchenik-zadachi`.`uchenik`;";
$res1 = $mysqli->query($SqlQuery1);
if($res1->data_seek(0)) {
    while ($row1 = $res1->fetch_assoc()) {


        $sCurrentPredmet = '-';
        $sUchenik = '-';

        $iPropuscheno = $row1['propuscheno'];
        $sCurrentPredmet = $row1['predmet'];
        $sUchenik = $row1['uchenik'];

        if($sCurrentPredmet<>$sLastPredmet){
            if($sLastPredmet<>'')
                echo "============================</br></br>";
            $sLastPredmet = $sCurrentPredmet;
        }

        if($row1['uchenik']<>"test"){
//            echo  "<b>".$row1['uchenik']."-".$row1['predmet']."</b></br>";
            echo "<a href='/telsanin/".$row1['uchenik']."/".$row1['predmet']."/dz'>".$row1['uchenik']."-".$row1['predmet']."</a></b></br>";

            $SqlQuery = "select count(`kolichestvo-popytok`) as count, `kolichestvo-popytok`  from `uchenik-zadachi` where `uchenik`='".$row1['uchenik']."' and `predmet`='".$row1['predmet']."' and `urok`=2 and `aktualno`=1 and `resheno-pravilno`=1 group by `kolichestvo-popytok` asc;";
            if($res = $mysqli->query($SqlQuery)) {
                $res->data_seek(0);
                $sPopytki = "<table><tbody><tr><td>Сколько задач</td><td>С какой попытки</td></tr>";
                while ($row = $res->fetch_assoc()) {
                    $sPopytki .= "<tr><td>".$row['count']."</td><td>".$row['kolichestvo-popytok']."</td></tr>";
                }
                $sPopytki .= "</tbody></table>";
            }

            $iZadanie=0;
            $iAbsolutnayaSortirovka=0;


            $SqlQuery = "select `zadacha`.`zadanie`, `zadacha`.`absulutnaya-sortirovka` from `uchenik-zadachi` inner join `zadacha` on `uchenik-zadachi`.`id-zadachi`=`zadacha`.`id-zadachi` where `uchenik-zadachi`.`uchenik`='".$sUchenik."' and `zakonchili-na-etom`=1 and `zadacha`.`predmet`='".$sCurrentPredmet."';";
            if($res = $mysqli->query($SqlQuery)) {
                $res->data_seek(0);
                while ($row5 = $res->fetch_assoc()) {
                    $iZadanie=$row5['zadanie'];
                    $iAbsolutnayaSortirovka=$row5['absulutnaya-sortirovka'];
                }
            }
            
            $iZadachVZadanii=0;

            $SqlQuery = "select max(`zadacha`.`absulutnaya-sortirovka`) as max from `zadacha` where `predmet`='".$sCurrentPredmet."' and `zadanie`=".$iZadanie.";";
            if($res = $mysqli->query($SqlQuery)) {
                $res->data_seek(0);
                while ($row6 = $res->fetch_assoc()) {
                    $iZadachVZadanii=$row6['max'];
                }
            }

            echo "Закончили на: ".$iZadanie.".".$iAbsolutnayaSortirovka."/".$iZadachVZadanii;
            echo "</br>";


            //сформируем "задачную" часть отчета
//            $SqlQuery = "SELECT *, `uchenik-predmet`.`ssylka-na-dz-reshu-ege`,`uchenik-predmet`.`propuscheno`  FROM `uchenik-zadachi` INNER JOIN `uchenik-predmet` ON `uchenik-zadachi`.`uchenik`=`uchenik-predmet`.`uchenik` AND `uchenik-zadachi`.`predmet`=`uchenik-predmet`.`predmet` WHERE `aktualno`=1 AND `urok`=2 AND `uchenik-zadachi`.`uchenik`='" . $row1['uchenik'] . "' AND `uchenik-zadachi`.`predmet`='".$row1['predmet']."'";
            $SqlQuery = "SELECT *, `uchenik-predmet`.`ssylka-na-dz-reshu-ege` FROM `uchenik-zadachi` INNER JOIN `uchenik-predmet` ON `uchenik-zadachi`.`uchenik`=`uchenik-predmet`.`uchenik` AND `uchenik-zadachi`.`predmet`=`uchenik-predmet`.`predmet` WHERE `aktualno`=1 AND `urok`=2 AND `uchenik-zadachi`.`uchenik`='" . $row1['uchenik'] . "' AND `uchenik-zadachi`.`predmet`='".$row1['predmet']."'";
            if($res = $mysqli->query($SqlQuery)){
                $iVsego = 0;
                $iReshal = 0;
                $iPravilno = 0;
                $iNepravilno = 0;
                $iSumPopytok = 0;
                $iSumVremya = 0;
                $iOtmechenoRazobrat = 0;
                $res->data_seek(0);
                while ($row = $res->fetch_assoc()) {
                    $iVsego++;
                    if ($row['kolichestvo-popytok'])
                        $iReshal++;
                    if ($row['resheno-pravilno']==1)
                        $iPravilno++;
                    if ($row['resheno-pravilno']==-1)
                        $iNepravilno++;
                    $iSumPopytok += $row['kolichestvo-popytok'];
                    $iSumVremya += strtotime($row['vremya-vypolneniya']) - strtotime("00:00:00");
                    if ($row['razobrat-na-zanyatii'])
                        $iOtmechenoRazobrat++;
                    $iDzNaReshuEge=0;
                    if($row['ssylka-na-dz-reshu-ege'])
                        $iDzNaReshuEge=1;
                    $sPredmet=$row['predmet'];
                }
                echo "Всего было задано: ".$iVsego."&nbsp;&nbsp;&nbsp;";
                if($iDzNaReshuEge)
//                    echo "<input type='checkbox' checked disabled /><span>&nbsp;ДЗ на Решу ЕГЭ</span></br>";
                    if($sPredmet=='informatika')
                        echo "<a target='_blank' href='https://inf-ege.sdamgia.ru/teacher?a=tests'>дз на решу егэ</a></br>";
                    else
                        echo "<a target='_blank' href='https://math-ege.sdamgia.ru/teacher?a=tests'>дз на решу егэ</a></br>";

                if ($iReshal&&$iPravilno) {
                    $iSredPopytok = round($iSumPopytok / $iReshal, 1);
                    $iSredVremya = (int)($iSumVremya / $iReshal);
//                    echo "Попытался решить: " .$iReshal."</br>";
                    if($iOtmechenoRazobrat)
                        echo "Отмечено \"разобрать\": " . $iOtmechenoRazobrat."</br>";
                    if($iNepravilno)
                        echo "<font color='red'>Не получилось: </font>".$iNepravilno."</br>";
                    if($iVsego-$iReshal)
                        echo "<font color='magenta'>Не решал: </font>".($iVsego-$iReshal)."</br>";
                    if($iPravilno)
                        echo "<font color='lime'>Получилось: </font>".$iPravilno." (".round($iPravilno / $iVsego * 100)."%)</br>";
//                    echo "Среднее количество попыток: " . $iSredPopytok . "</br>";
                    echo "Среднее время выполнения: " . gmdate("H:i:s", $iSredVremya) . "</br>";
                    echo "Общее время выполнения: " . gmdate("H:i:s", $iSumVremya) . "</br>";
                    if($iPravilno)
                        echo $sPopytki;
                }

            }
            echo "<div>";
//            echo "<span style='border-bottom: dashed 1px;' class='propuski-show-hide'>Пропуски:</span></br>";

            echo "<a style='border-bottom: dashed 1px;' class='propuski-show-hide' href=''>Пропуски ".($iPropuscheno?"(".$iPropuscheno.")":"").":</a></br>";
            echo "<div class='propuski' style='display: none;'>";
//            if($iPropuscheno)
//                echo "<span style='color: red;'>пропущено: ".$iPropuscheno."</span></br>";
//            else
                echo "</br>";
            echo "<button class='propustil' id='".$row1['uchenik']."-".$row1['predmet']."-vchera'>Вчера</button>";
            echo "&nbsp;&nbsp";
            echo "<button class='propustil' id='".$row1['uchenik']."-".$row1['predmet']."-segodnya'>Сегод</button>";
            echo "&nbsp;&nbsp";
            echo "<button class='propustil' id='".$row1['uchenik']."-".$row1['predmet']."-zavtra'>Завтра</button>";
            echo "&nbsp;&nbsp";
            echo "<button class='propustil' id='".$row1['uchenik']."-".$row1['predmet']."-poslezavtra'>Послез</button>";
            echo "</br>";

//            echo "<button class='vosstanovil' id='".$row1['uchenik']."-".$row1['predmet']."-vosstanovil'>Восстановил</button>";
//            echo "&nbsp;&nbsp";
//            echo "-1 занятие";
            echo " восстановил:</br>";
            echo "<button class='vosstanovil' id='".$row1['uchenik']."-".$row1['predmet']."-minus'>&nbsp;&nbsp;-1&nbsp;&nbsp;</button>";
            echo "&nbsp;&nbsp;";
            echo "<button class='vosstanovil' id='".$row1['uchenik']."-".$row1['predmet']."-plus'>&nbsp;&nbsp;+1&nbsp;&nbsp;</button>";
//            echo "&nbsp;&nbsp;";
            echo "</div></div></br>";

        }
    }
}
//-сформируем "задачную" часть отчета