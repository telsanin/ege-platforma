<?
function logger($text, $mode="a"){
//запись чего угодно в лог
	$filenameLog = (dirname(__FILE__).'/_log_anything.txt');

	$content=date("y.m.d H:i:s").chr(13);
	$content.=$text.chr(13).chr(13);

	$handleLog = fopen($filenameLog, $mode);
//	fwrite($handleLog, iconv('Windows-1251', 'UTF-8', $content));
	fwrite($handleLog, $content);
	fclose($handleLog);
}
?>