<?
function logger($text, $mode="a"){

//подключаем функцию логгинга чего угодно; include: если файла не будет - выдастся Warning и работа продолжится
//работает так: logger('любой текст');
//include $_SERVER["DOCUMENT_ROOT"]."/PART_logger.php";

//запись чего угодно в лог
	$filenameLog = ($_SERVER['DOCUMENT_ROOT'].'/_log_anything.txt');

	$content=date("y.m.d H:i:s").chr(13);
	$content.=$text.chr(13).chr(13);

	$handleLog = fopen($filenameLog, $mode);
//	fwrite($handleLog, iconv('Windows-1251', 'UTF-8', $content));
	fwrite($handleLog, $content);
	fclose($handleLog);
}
?>