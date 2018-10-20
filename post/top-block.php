<?php
/*
Этот файл вызывается из .js
обновляет поле urok таблицы uchenik-zadachi (через AJAX).
*/

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//параметры полученного POST-запроса на обновление поля записи БД
$sUchenik=$_POST["suchenik"];
$sPredmet=$_POST["spredmet"];
$iZadanie=$_POST["izadanie"];

//сформируем SQL-запрос
//$SqlQuery = "select `uchenik-zadachi`.urok, count(`uchenik-zadachi`.urok) as count from `uchenik-zadachi`, zadacha where `zadacha`.`id-zadachi`=`uchenik-zadachi`.`id-zadachi` and uchenik='".$sUchenik."' and `uchenik-zadachi`.predmet='".$sPredmet."' and zadanie=".$iZadanie." group by `uchenik-zadachi`.urok;";
$SqlQuery = "SELECT IF((`resheno-pravilno`=1) OR (`reshali-na-zanyatii`=1),1,0) AS rp, `uchenik-zadachi`.urok, count(`uchenik-zadachi`.urok) as count FROM `uchenik-zadachi`, zadacha WHERE `zadacha`.`id-zadachi`=`uchenik-zadachi`.`id-zadachi` and uchenik='".$sUchenik."' and `uchenik-zadachi`.predmet='".$sPredmet."'";
if($iZadanie)
    $SqlQuery .=" and zadanie=".$iZadanie;
$SqlQuery .=" group by rp, `uchenik-zadachi`.urok;";
//выполним запрос
if($res = $mysqli->query($SqlQuery)) {
    $res->data_seek(0);
    $aTopBlock['TopBlockReshenoVNigde']=0;
    $aTopBlock['TopBlockReshenoVUroke']=0;
    $aTopBlock['TopBlockReshenoVVydannomDz']=0;
    $aTopBlock['TopBlockVNigde']=0;
    $aTopBlock['TopBlockVUroke']=0;
    $aTopBlock['TopBlockVVydannomDz']=0;
    while ($row = $res->fetch_assoc()){
        if($row['rp']) {
            switch ($row['urok']) {
                case 0:
                    $aTopBlock['TopBlockReshenoVNigde'] = $row['count'];
                    break;
                case 1:
                    $aTopBlock['TopBlockReshenoVUroke'] = $row['count'];
                    break;
                case 2:
                    $aTopBlock['TopBlockReshenoVVydannomDz'] = $row['count'];
                    break;
            }
        }
        else {
            switch($row['urok']) {
                case 0:
                    $aTopBlock['TopBlockVNigde'] = $row['count'];
                    break;
                case 1:
                    $aTopBlock['TopBlockVUroke'] = $row['count'];
                    break;
                case 2:
                    $aTopBlock['TopBlockVVydannomDz'] = $row['count'];
                    break;
            }
        }
    }
}
//отладочные строки
echo json_encode($aTopBlock);
//echo mysql_error();

?>