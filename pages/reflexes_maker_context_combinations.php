<?
/*  сгенерировать рабочие сочетания Базовых контекстов

include_once($_SERVER['DOCUMENT_ROOT'] . "/pages/reflexes_maker_context_combinations.php");
*/



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






// все рабочие сочетания (без перестановочных повторений) номеров ячеек таблицы "Активности Базовых стилей" 29316 сочетаний

/*
$cellComb=array();
$nNumbers=56;
for($n=0;$n<$nNumbers;$n++)
{
array_push($cellComb,array($n));
$a2=array();
array_push($a2,$n);
for($m=$n+1;$m<$nNumbers;$m++)
{
array_push($a2,$m);// добавляется по одному
array_push($cellComb,$a2);
} 
}
// из каждого сочетания убираем по 1 кроме крайних
foreach($cellComb as $comb)
{
	if(count($comb)<3)
		continue;
	$arr=$comb;
	for($m=1;$m<count($comb)-1;$m++)
	{
      unset($arr[$m]);
	  array_push($cellComb,$arr);
	}

}
// var_dump($cellComb);exit();
*/

include_once($_SERVER['DOCUMENT_ROOT'] . "/lib/get_ubicum_combination.php");

$cellComb=get_ubicum_combination(56);
//var_dump($cellComb);exit();




// по каждому сочетанию готовим суммы строк
$contextsArr0=array();// сочетания контекстов
$n=0;
foreach($cellComb as $ccomb)
{
$sumArr=array();// сумматор значений ячеек данного сочетания $ccomb
foreach($ccomb as $nCell)
{
$col1=$nCell%7; 
$row1=(int)($nCell/7);
$curComb1=$contextArr[$row1+1][$col1];
$p = explode(",", $curComb1);
$sumArr=array_merge($sumArr,$p);
}
//var_dump($pArr);exit();
$sumArr=array_unique($sumArr);
sort($sumArr, SORT_NUMERIC);reset($sumArr);
//if($n==10) {var_dump($sumArr);exit("<hr> $col1 | $row1 || $col2 | $row2 || $curComb1 | $curComb2");}
array_push($contextsArr0,$sumArr);
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
write_combo_file($_SERVER["DOCUMENT_ROOT"]."/pages/combo_contexts_str.txt",$list_id);
write_combo_file($_SERVER["DOCUMENT_ROOT"]."/pages/combo_contexts_names.txt",$list_name);


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
?>