<?php

$sParametr1 = explode( '/', $sUrl )[0];
$sParametr2 = explode( '/', $sUrl )[1];
$sParametr3 = explode( '/', $sUrl )[2];
$sParametr4 = explode( '/', $sUrl )[3];

if($sParametr3 == "dz"){
    $sUchenik = $sParametr1;
    $sPredmet = $sParametr2;
    include_once $_SERVER['DOCUMENT_ROOT']."/front/dz.php";
}
elseif($sParametr3 == "urok"){
    $sUchenik = $sParametr1;
    $sPredmet = $sParametr2;
    include_once $_SERVER['DOCUMENT_ROOT']."/front/urok.php";
}
elseif($sParametr3 == "stat"){
    $sUchenik = $sParametr1;
    $sPredmet = $sParametr2;
    #include_once $_SERVER['DOCUMENT_ROOT']."/front/stat.php";

    #!это временно - на время перехода!
    include_once $_SERVER['DOCUMENT_ROOT']."/stat/".$sUchenik."-".$sPredmet."/index.html";
    #-!это временно - на время перехода!

}