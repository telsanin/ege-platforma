<?php

$uploaddir = $_SERVER["DOCUMENT_ROOT"]."/img/";
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo '<pre>';

//is_uploaded_file($_FILES['userfile']['tmp_name']);

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Файл корректен и был успешно загружен.\n";
} else {
    echo "Возможная атака с помощью файловой загрузки!\n";
}

echo 'Некоторая отладочная информация:';
print_r($_FILES);

print "</pre>";