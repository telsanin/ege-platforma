<?php

$fileName = $_SERVER["DOCUMENT_ROOT"]."/stat/".$sUchenik.".html";

//строка - содержимое, которое будет записано в файл
$sFileContent = file_get_contents($fileName);

$filehandle = fopen($fileName, 'w');

$sNewText="След занятие\r\n";
$sNewText.="Что нужно было сделать: \r\n";

$sFileContent=$sNewText.$sFileContent;

fwrite($filehandle, $sFileContent);
fclose($filehandle);

echo "вроде записал";


