<?php
/*
массовая загрузка задач
*/

$SqlQuery = "SELECT `id-zadachi` FROM `zadacha` ORDER BY `id-zadachi` DESC;";
$res = $mysqli->query($SqlQuery);
$res->data_seek(0);
$row = $res->fetch_assoc();
echo "Номер последней задачи: ".$row["id-zadachi"];
echo "</br></br>";

echo "<button id='upload-zadachi'>Загрузить</button> файл .csv, <b>лежащий на ftp!</b></br>";
echo "<span id='answer'></span>";

//include_once $_SERVER['DOCUMENT_ROOT']."/SERVICE_import_from_txt.php";

