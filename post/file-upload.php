<?php

//$uploaddir = '/img/';
//$uploaddir = '/';
//$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$uploadfile ="img/123.gif";

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