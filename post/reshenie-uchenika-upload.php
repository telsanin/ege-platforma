<?php

//подключаем функцию логгинга чего угодно; include: если файла не будет - выдастся Warning и работа продолжится
//работает так: logger('любой текст');
//include $_SERVER["DOCUMENT_ROOT"]."/PART_logger.php";

$uploaddir = $_SERVER["DOCUMENT_ROOT"]."/resheniya-uchenikov/";
$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);

echo '<pre>';

//logger($uploaddir);
//logger($uploadfile);
//logger(basename($_FILES['userfile']['name']));

//is_uploaded_file($_FILES['userfile']['tmp_name']);

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
//    logger("Файл корректен и был успешно загружен.\n");
} else {
    echo "Возможная атака с помощью файловой загрузки!\n";
//    logger("Возможная атака с помощью файловой загрузки!\n");
}

echo 'Некоторая отладочная информация:';
print_r($_FILES);
//logger($_FILES);

print "</pre>";