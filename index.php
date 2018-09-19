<!DOCTYPE HTML>
<html lang="ru">

<?php

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

$sUrl = $_SERVER["REQUEST_URI"];

//удалим слеш в начале url'а
if( $sUrl!="/" ) {
    $sUrl=substr($sUrl,1,strlen($sUrl)-1);
}
/*если url содержит telsanin, то это админка
если нет, то это лицевая часть для учеников и родителей*/

if (substr_count($sUrl, "telsanin")){
    //уберем telsanin/
//    $sUrl=substr_replace($sUrl,"",stripos($sUrl,"telsanin/"),strlen("telsanin/"));
    $sRole = "admin";
}
else
    $sRole = "front";
?>

<head>
<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/".$sRole."/head.php";
?>
</head>


<body>


<header>
</header>

<?php
include_once $_SERVER['DOCUMENT_ROOT']."/".$sRole."-router.php";
?>

<footer>
</footer>

</body>
</html>