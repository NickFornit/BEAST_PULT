<?
/* выдать возможные сочетания Базовых контекстов в зависимости от Базового состояния
для http://go/pages/reflexes.php 

/pages/reflexes_maker_b_contexts.php?base_condition=1

Cостояния отдельных параметров гомеостаза не коррелируют с общим Базовым состоянием (определяемым в ГО func commonBadDetecting()) и тут сложности, например, Базовое состояние Хорошо возникает после улучшения после плохих диапазонов гомео-параметров.
Поэтому невозможно вычислить сочетаний активных Базовых контекстов, дающие Базовые состояния.
Так что параметр $base_condition НЕ ИСПОЛЬЗУЕТСЯ.

Алгоритм:
1.	Создать массив всех возможных сочетаний параметров гомеостаза (МГ), в которых нет внутренних повторений-перестановок, это – всего лишь 35 сочетаний 8-и параметров.
2.	Начать перебор каждого из сочетаний МГ и для каждого ID г.параметра суммируем ID контекстjd по каждой колонке таблицы "Активности Базовых стилей" для данного сочетания id г.параметров. Получаем все возможные сочетания контекстов при данном сочетании г.параметров. 
3.	В результате получаем все возможные сочетания контактов в виде строк с разделителем “;” с учетом антагонистов и минусованных (в таблице "Активности Базовых стилей") контекстов.

Пояснение:
Из-за того, что все сочетания прописаны в теблице "Активности Базовых стилей", нет необходимости делать все возможные комбинации г.параметров и по ним выявлять сочетания контекстов.
*/

header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_ALL, "ru_RU.UTF-8");

$base_condition=$_GET['base_condition']; // НЕ ИСПОЛЬЗУЕТСЯ т.к. нет отпределенной зависимости
$get_list=$_GET['get_list'];  //exit($get_list);

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



////////// Активности Базовых стилей для получения всех возможных сочетаний Базовых контекстов
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


$aComb=array();// комбинации всех г.параметров
for($n=1;$n<9;$n++)
{
array_push($aComb,array($n));
$a2=array();
array_push($a2,$n);
for($m=$n+1;$m<9;$m++)
{
array_push($a2,$m);// добавляется по одному
array_push($aComb,$a2);
} 
}
// var_dump($aComb);exit();

///////////////////////////////////////////////////////

$contextsArr=array();// сочетания в виде 1;2
$n=0;
foreach($aComb as $idArr)
{
	$contCol=array();// сочетания в виде 1;2 - для ланной комбинации г.параметров
	for($nCol=0;$nCol<7;$nCol++)
	{
		$contCol[$nCol]=array();
	}
foreach($idArr as $id)// id г.параметров
{ 

foreach($contextArr[$id] as $sa)// строка таблицы "Активности Базовых стилей"
{ 
// суммируем контексты по каждой колонке таблицы для данного сочетания id г.параметров
$minusArr=array();
for($nCol=0;$nCol<7;$nCol++)
	{
$p = explode(",", $contextArr[$id][$nCol]);  
sort($p, SORT_NUMERIC);reset($p);// по алфавиту, чтобы можно было удалять повторяющиеся

foreach($p as $a)
{
	if(empty($a))
		continue;

	if($a<0)
	{
		array_push($minusArr,$a);
		continue;
	}
array_push($contCol[$nCol],$a);
} // foreach($p as $a)
	}//for($nCol=0;$nCol<7;$nCol++) 
}
}
/////////////////////////////////
// оставить только уникальные, убрать антагонистов и перевести сочетания контекстов в строки
for($nCol=0;$nCol<7;$nCol++)
	{
		$contCol[$nCol]=array_unique($contCol[$nCol]);
		$str="";
$antArr=array();// для проверки антагонистов
		foreach($contCol[$nCol] as $a)
		{
			if(empty($a) )// || $a<0
				continue;
// убрать отрицательнеы контексты (которые должны госиться)
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
	}//for($nCol=0;$nCol<7;$nCol++)
	/////////////////////////////////

//var_dump($contCol);exit();
//array_push($contCol[$nCol],$a);
//var_dump($contextsArr);exit();
$n++;
}
$contextsArr=array_unique($contextsArr);
//var_dump($contextsArr);exit();

// расположить по возрастанию чила контекстов
uasort($contextsArr, "cmpare");
function cmpare($a, $b) 
{ 
    if (strlen($a) == strlen($b)) {
        return 0;
    }
    return (strlen($a) < strlen($b)) ? -1 : 1;
}
// var_dump($contextsArr);exit();




///////////////////////////////////////////////////////////////

// собрать комбобокс
$out="<select id='base_context_id' size=12 style='max-width:360px;'>";// multiple='multiple' 
foreach($contextsArr as $aArr)
{
	$str="";
	$p = explode(";", $aArr);
	foreach($p as $a)
{
	if(empty($a) || $a<0)
		continue;
if(!empty($str))
	{
	$str.=",&nbsp;";
	}

	$str.=$a."&nbsp;".$baseContextArr[$a][0];
}

$out.="<option value='".$aArr."' ";   //exit($get_list."<hr>".$aArr);
if(!empty($get_list) && $get_list==$aArr)
{
$out.="selected";
}

$out.=" title='".$str."'>".$str."</option>";
//	array_push($contextsNameArr,$str);
}
$out.="</select><br>";

//exit($out);
echo "!".$out;

///////////////////////////////////////////////////
function read_file($file)
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