<?php

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//$iInitial=$_POST["initial"];
//if($iInitial)
//    $sOrder="from `zadacha` ORDER BY `predmet`, `zadanie`, `kommentarii`) as s";
//else
//    $sOrder="from `zadacha` ORDER BY `predmet`, `zadanie`, `kommentarii`, `id-podtemy`) as s";

//сформируем SQL-запрос
$SqlQuery = "SET @old_predmet = '';
    SET @old_zadanie = -1;
    SET @old_kommentarii = '';
    SET @num = 0;
    update `zadacha` inner join (
    select @num := CASE 
    WHEN (@old_predmet <> `predmet`) OR (@old_zadanie <> `zadanie`) THEN 10
    ELSE 
        CASE 
        WHEN @old_kommentarii <> `kommentarii` THEN @num+10
        ELSE @num
        END
    END 
    AS `new-id-podtemy`,
    `id-zadachi`,
    `predmet`,
    `zadanie`,
    `id-podtemy`,
    IF(`kommentarii`='','я', `kommentarii`) as kommentarii,
    @old_predmet:=`predmet`,
    @old_zadanie:=`zadanie`,
    @old_kommentarii:=`kommentarii`
    from `zadacha` ORDER BY `predmet`, `zadanie`, `kommentarii`, 'sortirovka') as s 
    on `zadacha`.`id-zadachi`=`s`.`id-zadachi`
    set `zadacha`.`id-podtemy`=`s`.`new-id-podtemy`
    ;";


$SqlQuery .="SET @old_predmet = '';
    SET @old_zadanie = -1;
    SET @num = -1;
    update `zadacha` inner join (
    select @num := CASE
    WHEN (@old_predmet <> `predmet`) OR (@old_zadanie <> `zadanie`) THEN 1
    ELSE @num + 1
    END AS `new-sortirovka`,
    `id-zadachi`,
    `predmet`,
    `zadanie`,
    `id-podtemy`,
    `sortirovka`,
    @old_predmet:=`predmet`,
    @old_zadanie :=`zadanie`
    from `zadacha` ORDER BY `predmet`, `zadanie`, `id-podtemy`, `sortirovka`) as s
    on `zadacha`.`id-zadachi`=`s`.`id-zadachi`
    set `zadacha`.`sortirovka`=`s`.`new-sortirovka`
;";

//выполним запрос
//if (!$mysqli->multi_query($SqlQuery))
//    echo "Не удалось выполнить мультизапрос: (" . $mysqli->errno . ") " . $mysqli->error;

/* запускаем мультизапрос */
if ($mysqli->multi_query($SqlQuery)) {
    do {
        /* получаем первый результирующий набор */
        if ($result = $mysqli->store_result()) {
            while ($row = $result->fetch_row()) {
                printf("%s\n", $row[0]);
            }
            $result->free();
        }
        /* печатаем разделитель */
        if ($mysqli->more_results()) {
            printf("-----------------\n");
        }
    } while ($mysqli->next_result());
}

/* закрываем соединение */
$mysqli->close();


//$SqlQuery=str_replace(array("\r","\n"),' ',$SqlQuery);

//echo "<pre>".$SqlQuery."</pre>";
//echo "</br>";

//$SqlQuery = $mysqli->real_escape_string($SqlQuery);
//$res = $mysqli->multi_query($SqlQuery);
//echo $mysqli->affected_rows;

//sleep(5);

//$SqlQuery = "SET @old_predmet = '';
//    SET @old_zadanie = -1;
//    SET @num = -1;
//    update `zadacha` inner join (
//    select @num := CASE
//    WHEN (@old_predmet <> `predmet`) OR (@old_zadanie <> `zadanie`) THEN 1
//    ELSE @num + 1
//    END AS `new-sortirovka`,
//    `id-zadachi`,
//    `predmet`,
//    `zadanie`,
//    `id-podtemy`,
//    `sortirovka`,
//    @old_predmet:=`predmet`,
//    @old_zadanie :=`zadanie`
//    from `zadacha` ORDER BY `predmet`, `zadanie`, `id-podtemy`, `id-zadachi`, `sortirovka`) as s
//    on `zadacha`.`id-zadachi`=`s`.`id-zadachi`
//    set `zadacha`.`sortirovka`=`s`.`new-sortirovka`
//    ;";
////выполним запрос
//$SqlQuery=str_replace(array("\r","\n"),' ',$SqlQuery);

//выполним запрос
//$res = $mysqli->multi_query($SqlQuery);
//echo $mysqli->affected_rows;
//echo $mysqli->error;
//if (!$mysqli->multi_query($SqlQuery))
//    echo "Не удалось выполнить мультизапрос: (" . $mysqli->errno . ") " . $mysqli->error;

?>