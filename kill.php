<?
/*
http://go/kill.php



*/
header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=UTF-8');

$res=shell_exec('taskkill /F /IM "go_build_BOT.exe"');
echo "Выключен";

?>