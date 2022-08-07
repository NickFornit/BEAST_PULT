<?
/* Подсказка по строке рефлекса.
/pages/reflex_helper.php?id=1
*/

header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_ALL, "ru_RU.UTF-8");

include_once($_SERVER['DOCUMENT_ROOT']."/common/common.php");

$id=$_GET['id'];


// считать файл 
$progs=read_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/dnk_reflexes.txt");
$strArr=explode("\r\n",$progs); // var_dump($strArr);exit();
$n=0;
$lastID=1;
foreach($strArr as $str)
{                         //exit($str);
$par=explode("|",$str);   // var_dump($par);exit();
							// exit($id."<br>".$par[0]);
if($id==$par[0])
{

$lev1=get_info_1($par[1]);
$lev2=get_info_2($par[2]);
$lev3=get_info_3($par[3]);
$lev4=get_info_4($par[4]);  //exit($lev1."<br>".$lev2."<br>".$lev3."<br>".$lev4);

$inf=$lev1."<br>".$lev2."<br>".$lev3."<br>".$lev4;

exit($inf);
}

}
/////////////////////////////////////////////
function get_info_1($str)
{
	$str=trim($str);
	switch($str)
	{
case 1: return "1 Плохо"; break;
case 2: return "2 Норма"; break;
case 3: return "3 Хорошо"; break;
	} 
}
////////////////////////////////////////
function get_info_2($str)
{
$inf="";
$pArr=explode(",",$str);
foreach($pArr as $s)
{
	$s=trim($s);
	if(empty($s))
		continue;
if(!empty($inf))
	$inf.="; ";
	switch($s)
	{
case 1: $inf.="1 Пищевой "; break;
case 2: $inf.="2 Поиск"; break;
case 3: $inf.="3 Игра"; break;
case 4: $inf.="4 Гон"; break;
case 5: $inf.="5 Защита"; break;
case 6: $inf.="6 Лень"; break;
case 7: $inf.="7 Ступор"; break;
case 8: $inf.="8 Страх"; break;
case 9: $inf.="9 Агрессия"; break;
case 10: $inf.="10 Злость"; break;
case 11: $inf.="11 Доброта"; break;
case 12: $inf.="12 Сон"; break;
	} 
}
return $inf;
}
//////////////////////////////////////////
function get_info_3($str)
{
	if(empty($str))
	{
return "Любые действия или без действий.";
	}
$inf="";
$pArr=explode(",",$str);   // exit($str);
foreach($pArr as $s)
{
	$s=trim($s);
	if(empty($s))
		continue;
if(!empty($inf))
	$inf.="; ";
	switch($s)
	{
case 1: $inf.="1 Непонятно"; break;
case 2: $inf.="2 Понятно"; break;
case 3: $inf.="3 Наказать"; break;
case 4: $inf.="4 Поощрить"; break;
case 5: $inf.="5 Накормить"; break;
case 6: $inf.="6 Успокоить"; break;
case 7: $inf.="7 Предложить поиграть"; break;
case 8: $inf.="8 Предложить поучить"; break;
case 9: $inf.="9 Игнорировать"; break;
case 10: $inf.="10 Сделать больно"; break;
case 11: $inf.="11 Сделать приятно"; break;
case 12: $inf.="12 Заплакать"; break;
case 13: $inf.="13 Засмеяться"; break;
case 14: $inf.="14 Обрадоваться"; break;
case 15: $inf.="15 Испугаться"; break;
case 16: $inf.="16 Простить"; break;
case 17: $inf.="17 Вылечить"; break;
	} 
}
return $inf;
}
//////////////////////////////////////
function get_info_4($str)
{                           //  exit($str);
$inf="";
$idArr=array();
$pArr=explode(",",$str);  //var_dump($pArr);exit();
foreach($pArr as $s)
{
	$s=trim($s);
	if(empty($s))
		continue;
array_push($idArr,$s);
}                      //var_dump($idArr);exit();

$progs=read_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/terminal_actons.txt");
$strArr=explode("\r\n",$progs);
foreach($strArr as $str)
{
if(empty($str) || $str[0]=='#')
	continue;
									//exit($str);
$p=explode("|",$str);
$id=$p[0];
if(in_array($id,$idArr))
	{                        // exit($str);
	if(!empty($inf))
	$inf.="; ";
$inf.=$id." ".$p[1];
	}
}
return $inf;
}
//////////////////////////////////



?>