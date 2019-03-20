<?php

/*
В этом файле будут собраны повторно используемые функции приложения.
Если станет понятно, что требуется ООП, то переделаю функции в методы объектов
*/

function fGetArrayFromSelect($sSelect){
//получение массива как результата SELECT запроса к БД

  global $mysqli;

  if($res = $mysqli->query($sSelect)) {
    $res->data_seek(0);

    $i = 1;
    while ($row = $res->fetch_assoc()) {
      $aResult[$i] = $row;
      $i++;
    }

    return $aResult;
  }
}

?>