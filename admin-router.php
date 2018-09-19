<?php

/*
административная часть сайта
*/

//$sParametr1 = explode( '/', $sUrl )[0];
$sParametr2 = explode( '/', $sUrl )[1];
$sParametr3 = explode( '/', $sUrl )[2];
$sParametr4 = explode( '/', $sUrl )[3];
$sParametr5 = explode( '/', $sUrl )[4];

//http://ege-platforma.local/telsanin/zadachi/matematika/1
if($sParametr2 == "zadachi") {
    $sPredmet=$sParametr3;
    $iNomerZadaniya=$sParametr4;
    include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/zadachi.php";
}
//http://ege-platforma.local/telsanin/egor/matematika/1
else{
    //http://ege-platforma.local/telsanin/egor/matematika/1/urok
    if($sParametr4 == "urok"){
        $sUchenik=$sParametr2;
        $sPredmet=$sParametr3;
        $iNomerZadaniya=$sParametr4;
        include_once $_SERVER['DOCUMENT_ROOT']."/admin/urok.php";
    }
    //http://ege-platforma.local/telsanin/egor/matematika/1/dz
    elseif($sParametr4 == "dz"){
        $sUchenik = $sParametr2;
        $sPredmet = $sParametr3;
        $iNomerZadaniya = $sParametr4;
        include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/dz.php";
    }
    elseif($sParametr5 == "test"){
        $sUchenik = $sParametr2;
        $sPredmet = $sParametr3;
        $iNomerZadaniya = $sParametr4;
        include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/test.php";
    }
    else{
        //http://ege-platforma.local/telsanin/egor/matematika/1
        $sUchenik = $sParametr2;
        $sPredmet = $sParametr3;
        $iNomerZadaniya = $sParametr4;
        include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/urok-dz.php";
    }
}