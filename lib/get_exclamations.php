<?
/*  Выдать контрол для выбора слов для http://go/pages/condition_reflexes_basic_phrases.php
http://go/lib/get_exclamations.php
*/
header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=UTF-8');

$id=$_GET['id'];

$exclamations=array(
"ага",
"ай",
"больно",
"бью",
"верю",
"вместе",
"да",
"давай",
"делай",
"дерусь",
"должен",
"еда",
"жаль",
"здорово",
"здравствуй",
"игнорирую",
"играть",
"интересно",
"испугался",
"ищу",
"кричу",
"лечу",
"люблю",
"мама",
"можешь",
"на",
"надо",
"накажу",
"накормлю",
"накормлю",
"научись",
"ненавижу",
"непонятно",
"нет",
"ну",
"нужно",
"о",
"обязан",
"ого",
"ой",
"оп",
"опасно",
"опасно",
"папа",
"плачу",
"плохо",
"понятно",
"понятно",
"попытайся",
"привет",
"приятно",
"прощаю",
"радую",
"рискни",
"родной",
"сделай",
"слушай",
"смеюсь",
"спокойно",
"страшно",
"стыдно",
"трудно",
"убью",
"уверен",
"ударю",
"улыбаюсь",
"ух",
"учи",
"хорошо",
"хочу",
"целую",
"чушь",
"эй",
"я",
"ясно"
);

sort($exclamations, SORT_STRING);
reset($exclamations);

$out="<table border=0 style='width:800px;font-size:14px;'><tr>";
	$nCol = 0;
	$n = 0;
foreach($exclamations as $word)
{
if ($nCol == 6) { 
	$out.="</tr><tr>";
	$nCol = 0;
}									//exit($str);

$out.="<td align='left' style='cursor:pointer;' onClick='insert_word(".$id.",`".$word."`)'><nobr>".$word."</nobr></td>";
	
$nCol++;
$n++;
}
$out.="</tr></table>";

echo $out;