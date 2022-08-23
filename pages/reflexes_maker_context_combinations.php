<?
/*  сгенерировать рабочие сочетания Базовых контекстов

include_once($_SERVER['DOCUMENT_ROOT'] . "/pages/reflexes_maker_context_combinations.php");
для http://go/pages/reflexes_maker.php 

В ДАННЫЙ МОМЕНТ ЭТОТ СКРИПТ НЕ ИСПОЛЬЗУЕТСЯ вот почему.

Проверено немало алгоритмов фомрирования списков (наиболее эффективные для PHP собраны в array_combinations.php), но до сих пор ни один не используется вот почему:
1. время выполнения оказывается неприемлемо долгим при создании неповторяющихся комбинайиций из 8х7 ячеек. Многие алгоритмы вызывают ошибки недостатка памяти (даже, использующие yield PHP).
Даже в ГО профессиональный алгоритм работает неприемлемое время (tools.combinations_maker.go).
2. Наличие антагонистов и гасящих контекстов делает результат зависимым от способа обработки.

Поэтому сейчас используются файлы готовых списков в папке /pages/combinations/ составленные на основе ранее полученных вариантов и проверненные эвристически.
!!! В случае изменения таблицы "Активности Базовых стилей"(в http://go/pages/gomeostaz.php) 
наобходимо пересматривать списки 
/pages/combinations/combo_contexts_str.txt
и
/pages/combinations/combo_contexts_names.txt

В случае, если будет сделан генератор сочетаний, то он должен срабатывать при запуске из Публта, из менб Инструментов (шестеренка) и обновлять списки, а при каждом редактировании таблицы "Активности Базовых стилей" должно быть предупреждение о необходимости обновления списков.
*/

//ini_set('memory_limit', '2024M');

///////////////////////////////////////////////////////

// антагонисты
$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/base_context_antagonists.txt");
$strArr = explode("\r\n", $progs);  //exit("$progs");
$antFromId = array();// антагонисты для каждого выбранного в списке $get_list ID контекста
foreach ($strArr as $str) {
	$par = explode("|", $str);
	$id = $par[0];
	$as = explode(",", $par[1]); 
	$antFromId[$id]=array();
	foreach ($as as $a)
	{			
	array_push($antFromId[$id],$a);
	}
}
// var_dump($antFromId);exit();

// Базовые контексты $baseContextArr - только для получения имен базовых контекстов
include_once($_SERVER['DOCUMENT_ROOT'] . "/lib/base_context_list.php");



////////// таблица Активности Базовых стилей
$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/base_context_activnost.txt");
$strArr = explode("\r\n", $progs);  //exit("$progs");
$contextArr = array();
foreach ($strArr as $str) {
	$par = explode("|", $str);
	$id = $par[0];

$contextArr[$id]=array();
	for($n=1;$n<8;$n++)
	{
	array_push($contextArr[$id],$par[$n]);
	}
}
// var_dump($contextArr);exit();
//////////////////////////////////////////////////////////////////////


//!!!! сделать все возможные сочетаия 12 контекстов, и потом из каждой поудалять антагонистов,
//??? в список антагонистов включить минусы из таблицы




$contextsArr0=array();// сочетания контекстов


$combArr=array();
$countC=count($contextArr[1]);
$out = "";
$arr1 = $contextArr[1];
$arr2 = $contextArr[2];
$arr3 = $contextArr[3];
$arr4 = $contextArr[4];
$arr5 = $contextArr[5];
$arr6 = $contextArr[6];
$arr7 = $contextArr[7];
$arr8 = $contextArr[8];
for ($n1=0; $n1 < $countC; $n1++) {
	for ($n2=0; $n2 < $countC; $n2++) {
		for ($n3=0; $n3 < $countC; $n3++) {
			for ($n4=0; $n4 < $countC; $n4++) {
				for ($n5=0; $n5 < $countC; $n5++) {
					for ($n6=0; $n6 < $countC; $n6++) {
						for ($n7=0; $n7 < $countC; $n7++) {
							for ($n8=0; $n8 < $countC; $n8++) {
								$out .= $arr1[$n1]."|".$arr2[$n2]."|".$arr3[$n3]."|".$arr4[$n4]."|".$arr5[$n5]."|".$arr6[$n6]."|".$arr7[$n7]."|".$arr8[$n8]; //exit($out);
								array_push($combArr, $out);
							}
						}
					}
				}
			}
		}
	}
}

$combArr = array_unique($combArr); 
var_dump($combArr);exit();

$out="";
foreach($combArr as $ccomb)
{
$out.=$ccomb."\r\n";
}
$out=md5($str)."\r\n".$out;
write_combo_file($_SERVER["DOCUMENT_ROOT"]."/lib/contexts_combin.txt",$out);
exit("1111");


$list=read_combo_file($_SERVER["DOCUMENT_ROOT"]."/lib/contexts_combin.txt");
$combArr = explode("\r\n", $list);   
var_dump($combArr);exit();

// по каждому сочетанию готовим суммы строк
$contextsArr0=array();// сочетания контекстов
$n=0;
foreach($combArr as $ccomb)
{
$sumArr=array();// сумматор значений ячеек данного сочетания $ccomb
$pArr = explode("|", $ccomb);
foreach($pArr as $cell)
{
$sumArr=array_merge($sumArr,$cell);
}
//var_dump($pArr);exit();
$sumArr=array_unique($sumArr);
sort($sumArr, SORT_NUMERIC);reset($sumArr);
//if($n==10) {var_dump($sumArr);exit("<hr> $col1 | $row1 || $col2 | $row2 || $curComb1 | $curComb2");}
array_push($contextsArr0,$sumArr);
$n++;
}
var_dump($contextsArr0);exit();


// убрать антагонистов, отрицательнеы контексты (которые должны госиться) и перевести сочетания контекстов в строки, оставить только уникальные
$contextsArr=array();// сочетания контекстов
foreach($contextsArr0 as $comb)
{
$str="";  
$minusArr=array();
$antArr=array();

foreach($comb as $a)// подготовка к удалению отрицательных
{
	if($a<0){
		array_push($minusArr,-$a);
	}
}
$antArr=array();// для проверки антагонистов
foreach($comb as $a)
{
	if($a<0){
		continue;
	}
// убрать отрицательнеы контексты (которые должны гаситься)
if(in_array($a,$minusArr))
{
continue;
}

// исключить антагонистов, проверка для каждого выбранного ID кроме уже прошедших проверку
if(1)
{
$isAntagonist=0;
foreach($antArr as $g)
{ 
if(in_array($a,$antFromId[$g]))
{  
$isAntagonist=1;  // var_dump($antArr); exit("<hr> $a");
}
}
if($isAntagonist)
continue;
}

	if(!empty($str))
			{
				$str.=";";
			}
			$str.=$a;
			array_push($antArr,$a);
}
array_push($contextsArr,$str);
}
$contextsArr=array_unique($contextsArr);// Число сочетаний - 35 :)

//var_dump($contextsArr);exit("<hr>Число сочетаний: ".count($contextsArr));






///////////////////////////////////////////
// расположить по возрастанию чила контекстов
uasort($contextsArr, "cmpare");
function cmpare($a, $b) 
{ 
    if (strlen($a) == strlen($b)) {
        return 0;
    }
    return (strlen($a) < strlen($b)) ? -1 : 1;
}

// var_dump($contextsArr);exit("<hr>Число сочетаний: ".count($contextsArr));


// сохранять строки комбо контекстов в раб.файле  combo_contexts_str.txt
$list_id="";
$list_name="";
foreach($contextsArr as $str)
{
$list_id.=$str."\r\n";

$s="";
	$p = explode(";", $str);
foreach($p as $a)
{
	if(empty($a) || $a<0)
		continue;
if(!empty($s))
	{
	$s.=", ";
	}

	$s.=$a." ".$baseContextArr[$a][0];
}
$list_name.=$s."\r\n";
}
write_combo_file($_SERVER["DOCUMENT_ROOT"]."/pages/combinations/combo_contexts_str.txt",$list_id);
write_combo_file($_SERVER["DOCUMENT_ROOT"]."/pages/combinations/combo_contexts_names.txt",$list_name);


///////////////////////////////////////////////////
function write_combo_file($file,$content)
{
$hf=fopen($file,"wb+");
if($hf)
{
fwrite($hf,$content,strlen($content));
fclose($hf);
chmod($file, 0666);
return 1;
}
return 0;
}
//////////////////////////////////
///////////////////////////////////////////////////
function read_combo_file($file)
{
if(filesize($file)==0)
	return "";
$hf=fopen($file,"rb");
if($hf)
{
$contents=fread($hf,filesize($file));
fclose($hf);
return $contents;
}//if($hf)
return "";
}
///////////////////////////////////////////////////
?>