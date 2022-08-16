<?
/* выдать возможные сочетания Базовых контекстов в зависимости от Базового состояния
для http://go/pages/reflexes.php 

/pages/reflexes_maker_b_contexts.php?base_condition=1

Cостояния отдельных параметров гомеостаза не коррелируют с общим Базовым состоянием (определяемым в ГО func commonBadDetecting()) и тут сложности, например, Базовое состояние Хорошо возникает после улучшения после плохих диапазонов гомео-параметров.
Поэтому невозможно вычислить сочетаний активных Базовых контекстов, дающие Базовые состояния.
Так что параметр $base_condition НЕ ИСПОЛЬЗУЕТСЯ.

Алгоритм:
1.	Создать массив всех возможных сочетаний ячеек (СЯ) таблицы "Активности Базовых стилей".
2.	Начать перебор каждого из сочетаний СЯ и для каждого из них суммируем ID всех остальных ячеек "Активности Базовых стилей". Получаем все возможные сочетания контекстов при данном состоянии таблицы таблицы "Активности Базовых стилей". Из кажого суммарного сочетания убираем антагонистов, отрицательные контексты (которые должны госиться) и переводим сочетания контекстов в строки, оставляя только уникальные.
3.	В результате получаем все возможные сочетания контактов в виде строк с разделителем “;”.

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



// комбинации всех диапазонов таблицы "Активности Базовых стилей", т.е. 7 колонок и 8 строк = 56
// Число сочетаний: 3136
$diapazonsComb=array();
for($nCol=0;$nCol<56;$nCol++)
{
for($nRow=0;$nRow<56;$nRow++)
{
array_push($diapazonsComb,array($nCol,$nRow));
}
}
//var_dump($diapazonsComb);exit("<hr>Число сочетаний: ".count($diapazonsComb));


// по каждому сочетанию готовим суммы строк
$contextsArr0=array();// сочетания контекстов
$n=0;
foreach($diapazonsComb as $comb)
{
$curArr=array();

$col1=$comb[0]%7; 
$row1=(int)($comb[0]/7);
$curComb1=$contextArr[$row1+1][$col1];
$p1 = explode(",", $curComb1);
$col2=$comb[1]%7; 
$row2=(int)($comb[1]/7);
$curComb2=$contextArr[$row2+1][$col2];
$p2 = explode(",", $curComb2);         
//if($n==10) {var_dump($comb);exit("<hr> $col1 | $row1 || $col2 | $row2 || $curComb1 | $curComb2");}

$curArr=array_merge($p1,$p2);
$curArr=array_unique($curArr);
sort($curArr, SORT_NUMERIC);reset($curArr);
//if($n==10) {var_dump($curArr);exit("<hr> $col1 | $row1 || $col2 | $row2 || $curComb1 | $curComb2");}
array_push($contextsArr0,$curArr);
$n++;
}
//var_dump($contextsArr0);exit();


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