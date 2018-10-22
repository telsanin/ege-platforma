<?

//!!!нужно для корректной работы fgetcsv
//setlocale(LC_ALL, 'ru_RU.CP1251');
//setlocale(LANG, 'ru_RU.CP1251');
//!!!нужно для корректной работы fgetcsv

//подключимся к БД
$DbAccessFile=$_SERVER['DOCUMENT_ROOT']."/_db-info.php";
include_once $DbAccessFile;

//импортируем файл
$file_name="upload.txt";
$path_src_file=str_replace("\\","/",$_SERVER['DOCUMENT_ROOT']."/upload/".$file_name);//если в пути есть обратные слеши, заменим их прямыми
load_data($path_src_file,chr(9),'zadacha');




function load_data($file, $column_divider, $table_name){

    global $mysqli;
    $insert_affected_rows=0;
    $status='';

    $file_name = fopen($file, 'r');

    $sql_query_insert='INSERT INTO `'.$table_name.'` ';

    $i=0;
    $s=0;
    while($str_arr=fgetcsv($file_name,0,$column_divider)){
//    while($str_arr1=fgets($file_name)){

//     $str_arr=explode(chr(9), iconv('windows-1251','utf-8',$str_arr1));

     $s++;

     $only_null=true;
        $j=0;
        $sql_query_values='';
        foreach($str_arr as $k=>$v){

    // 	$v=str_replace('"','',$v);

            $v = iconv('windows-1251','utf-8', $v);

            if($v<>'') $only_null=false;
            if($v=='') $v='';
            $j++;
            if($j>1) $sql_query_values.=',';//между строками

            if ($s==1){
//              $v=str_replace(';','"`,`"',$v);
                $v="`".$v."`";
                $sql_query_values.=$v;
            }
            else{
//                $v=str_replace(';','","',$v);
                //$newv=str_replace(',','","',$v);
                //$v=$newv;
                $sql_query_values.='"'.$v.'"';
        }
            }

        if ($s==1) $fields_str=$sql_query_values;

        if(!$only_null){
            $i++;
            if($s>2 and $i>1) $sql_query_insert.=',';//между перечнями (xx,xx,...,xx),(xx,xx,...,xx)
            $sql_query_insert.='('.$sql_query_values.')';//вставим перечень значений полей
            if($s==1) $sql_query_insert.=' VALUES ';//если это первая строка файла, то значит перечень=перечень имен полей, значит надо вставить VALUES
        }

        if($i>=100){
            $sql_query_insert.=';';

            //$sql_query_insert="INSERT INTO pages (url) VALUES ('123')";
            //echo $sql_query_insert.'<br><br><br><br>';


            $query_result_insert=mysqli_query($mysqli, $sql_query_insert);
            if($query_result_insert){
                $insert_affected_rows+=mysqli_affected_rows();
                //echo '&nbsp;&nbsp;обработано записей: '.$s.'<br/>';
                //echo '&nbsp;&nbsp;добавлено записей: '.$insert_affected_rows.'<br/><br/>';
            }
            else {
                echo "ошибка! ";
                echo mysqli_error();
                $status.=mysqli_error();
            }
            $i=0;
            $sql_query_insert='INSERT INTO '.$table_name.' ('.$fields_str.') VALUES ';
        }
    }

    $sql_query_insert.=';';





    //echo $sql_query_insert.'<br><br><br><br>';

    $query_result_insert = mysqli_query($mysqli, $sql_query_insert);
    if($query_result_insert){
        $insert_affected_rows += mysqli_affected_rows($mysqli);
        //echo '&nbsp;&nbsp;обработано записей: '.$s.'<br/>';
        //echo '&nbsp;&nbsp;добавлено записей: '.$insert_affected_rows.'<br/><br/>';
    }
    else{
        echo "ошибка! ";
//        echo mysqli_error();
//        $status.=mysqli_error();
    }
    $status.='&nbsp;&nbsp;готово!<br/>';
    echo '&nbsp;&nbsp;ОБНОВЛЕНИЕ ДАННЫХ ИЗ ФАЙЛА .CSV<br/>';
    echo '&nbsp;&nbsp;обработано записей (включая названия полей): '.$s.'<br/>';
    echo '&nbsp;&nbsp;добавлено записей: '.$insert_affected_rows.'<br/><br/>';
    if ($s-$insert_affected_rows<>1) echo "<span style='color:red;'>ВНИМАНИЕ - ОШИБКА: обработано добавлено меньше записей, чем нужно!!</span>";

    fclose($file_name);

//    include_once $_SERVER['DOCUMENT_ROOT']."/post/sortirovka.php?initial=1";
    include_once $_SERVER['DOCUMENT_ROOT']."/post/sortirovka.php";

    echo '&nbsp;&nbsp;Перенумерованы подтемы<br/>';
    echo '&nbsp;&nbsp;Перенумерована сортировка<br/>';

    return $status;

}

?>