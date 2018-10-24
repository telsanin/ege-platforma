<?php

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

$sUrl = $_SERVER["REQUEST_URI"];

//удалим слеш в начале url'а
if( $sUrl!="/" ) {
    $sUrl=substr($sUrl,1,strlen($sUrl)-1);
}

/*если url содержит teltsanin, то это админка
если нет, то это лицевая часть для учеников и родителей*/
if (substr_count($sUrl, "telsanin")){
    //уберем telsanin/
//    $sUrl=substr_replace($sUrl,"",stripos($sUrl,"telsanin/"),strlen("telsanin/"));
    $sRole = "admin";
}
else
    $sRole = "front";
?>

<!DOCTYPE HTML>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <!--<meta charset="windows-1251">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.5/css/uikit.min.css" />

    <script src="/js/jquery.min.js"></script>
    <script src="/js/cconsole.js"></script>
    <script type="text/javascript" async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-MML-AM_CHTML"></script>

    <style type="text/css">
        p {margin: 0;}
        table{
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid lightgray;
        }
    </style>

    <script>
        $(function(){
            /*
             этот код будет выполняться после загрузки текущей
             */

            //вызов функций из моих js-плагинов
            functionCConsole();
        });
    </script>

    <?php
        include_once $_SERVER["DOCUMENT_ROOT"]."/".$sRole."/head.php";
    ?>
</head>


<body>

<?=(strpos($_SERVER["DOCUMENT_ROOT"], "teleginresume")?"<div style='position: fixed; top: 0; width: 100%;z-index: 1; border: solid 1px #4caf50; margin: 0; padding: 0;'></div>":"")?>

<div style="margin: 8px;">

    <header>
    </header>

    <?php
        include_once $_SERVER['DOCUMENT_ROOT']."/".$sRole."-router.php";
    ?>

    <footer>
    </footer>

</div>

</body>
</html>