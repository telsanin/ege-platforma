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

test

<?php

echo 'test';