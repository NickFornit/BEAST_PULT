<?
/*  ������� ��� ������, ��������� �� �������� ���������. (AJAX)
/lib/cliner_condition_reflex_memory.php

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


cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/condition_reflexes.txt");
cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/trigger_stimuls_images.txt");


///////////////////////////////////////////////////
function cliner_file($file)
{
$hf=fopen($file,"wb+");
if($hf)
{
fwrite($hf,"",0);
fclose($hf);
return 1;
}
return 0;
}
//////////////////////////////////
?>