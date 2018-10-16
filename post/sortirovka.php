<?php

$SqlQuery = "SET @old_predmet = '';
    SET @old_zadanie = -1;
    SET @old_id_podtemy = -1;
    SET @num = 0;
    update `zadacha` inner join (
    select @num := CASE 
    WHEN (@old_predmet <> `predmet`) OR (@old_zadanie <> `zadanie`) THEN 10
    ELSE 
        CASE 
        WHEN @old_id_podtemy <> `id-podtemy` THEN @num+10
        ELSE @num
        END
    END 
    AS `new-id-podtemy`,
    `id-zadachi`,
    `predmet`,
    `zadanie`,
    `id-podtemy`,
    @old_predmet:=`predmet`,
    @old_zadanie:=`zadanie`,
    @old_id_podtemy:=`id-podtemy`
    from `zadacha` ORDER BY `predmet`, `zadanie`, `id-podtemy`, `id-zadachi`) as s 
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
    from `zadacha` ORDER BY `predmet`, `zadanie`, `id-podtemy`, `id-zadachi`, `sortirovka`) as s
    on `zadacha`.`id-zadachi`=`s`.`id-zadachi`
    set `zadacha`.`sortirovka`=`s`.`new-sortirovka`
;";


//$SqlQuery=str_replace(array("\r","\n"),' ',$SqlQuery);

//echo "<pre>".$SqlQuery."</pre>";
//echo "</br>";

//выполним запрос
//$SqlQuery = $mysqli->real_escape_string($SqlQuery);
//$res = $mysqli->multi_query($SqlQuery);
//echo $mysqli->affected_rows;
if (!$mysqli->multi_query($SqlQuery))
    echo "Не удалось выполнить мультизапрос: (" . $mysqli->errno . ") " . $mysqli->error;

//sleep(5);

$SqlQuery = "SET @old_predmet = '';
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
    from `zadacha` ORDER BY `predmet`, `zadanie`, `id-podtemy`, `id-zadachi`, `sortirovka`) as s
    on `zadacha`.`id-zadachi`=`s`.`id-zadachi`
    set `zadacha`.`sortirovka`=`s`.`new-sortirovka`
    ;";
//выполним запрос
$SqlQuery=str_replace(array("\r","\n"),' ',$SqlQuery);

//выполним запрос
//$res = $mysqli->multi_query($SqlQuery);
//echo $mysqli->affected_rows;
//echo $mysqli->error;
//if (!$mysqli->multi_query($SqlQuery))
//    echo "Не удалось выполнить мультизапрос: (" . $mysqli->errno . ") " . $mysqli->error;

?>