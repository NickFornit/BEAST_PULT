<?
/*  ��������� ��������� ����� (AJAX)
/lib/separate_words_str_server.php 

*/
header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_ALL, "ru_RU.UTF-8");
mb_http_input('UTF-8');
mb_http_output('UTF-8');
mb_internal_encoding("UTF-8");

//var_dump($_POST);exit();
$text=$_POST['text'];


include_once($_SERVER["DOCUMENT_ROOT"]."/lib/separate_words_str.php"); 
$out=prepare_str($text); //  exit($out);

// ������ �������� �������� ������, ��� �������� ������ js �������:
$out=str_replace("\n","",$out);

//exit("\r\n $out");

//$out=urlencode($out); - � golang �� ����� ������� ���������� ������ urldecode
$out=str_replace("%","{#1}",$out);// ���������� ������������ %
//$out=str_replace('"',"{#2}",$out);
$out=str_replace('"','',$out);// ������� ������ ������� (����� ����� ������ :)

echo $out;
?>