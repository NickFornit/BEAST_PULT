<?
/* выдать возможные сочетания Базовых контекстов в зависимости от Базового состояния
для http://go/pages/reflexes.php 

/pages/reflexes_maker_b_contexts.php?base_condition=1

Cостояния отдельных параметров гомеостаза не коррелируют с общим Базовым состоянием (определяемым в ГО func commonBadDetecting()) и тут сложности, например, Базовое состояние Хорошо возникает после улучшения после плохих диапазонов гомео-параметров.
Поэтому невозможно вычислить сочетаний активных Базовых контекстов, дающие Базовые состояния.
Так что параметр $base_condition НЕ ИСПОЛЬЗУЕТСЯ.

Алгоритм:
1.	Создать массив всех возможных без внутренних повторений) сочетаний ячеек (СЯ) таблицы "Активности Базовых стилей".
2.	Начать перебор каждого из сочетаний СЯ и для каждого из них суммируем ID сочетаний контекстов этих ячеек. Получаем все возможные сочетания контекстов таблицы таблицы "Активности Базовых стилей". Из кажого суммарного сочетания убираем антагонистов, отрицательные контексты (которые должны госиться) и переводим сочетания контекстов в строки, оставляя только уникальные.
3.	В результате получаем все возможные сочетания контекстов в виде строк с разделителем “;”.

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


/*
// тестирование правильности алгоритма выборки рабочих сочетаний
$tComb=array();
$nNumbers=5;
for($n=1;$n<$nNumbers;$n++)
{
array_push($tComb,array($n));
$a2=array();
array_push($a2,$n);
for($m=$n+1;$m<$nNumbers;$m++)
{
array_push($a2,$m);// добавляется по одному
array_push($tComb,$a2);
} 
}
// из каждого сочетания убираем по 1 кроме крайних
foreach($tComb as $comb)
{
	if(count($comb)<3)
		continue;
	$arr=$comb;
	for($m=1;$m<count($comb)-1;$m++)
	{
      unset($arr[$m]);
	  array_push($tComb,$arr);
	}

}
 var_dump($tComb);exit();



// все рабочие сочетания (без перестановочных повторений) номеров ячеек таблицы "Активности Базовых стилей" 29316 сочетаний для проверки моего алгоритма (предыдущий по коду)
$cellComb = array();
$cellStr= array();
for($m=0;$m<5;$m++)
array_push($cellStr,$m);

function placing($chars, $from=0, $to = 0){
	global $cellStr;
    $cnt = count($chars);
    if(($from == 0) && ($to == 0)){
        $from = 1;
        $to = $cnt;
    }
    if($from == 0) $from = 1;
    if($to == 0) $to = $from;
    if($from < $to){
        $plac = [];
        for($num = $from; $num <= $to; $num++){
            $plac = array_merge($plac, placing($cellStr, $num));
        }
    }else{
        $plac = [""];   
        for($n = 0; $n < $from; $n++){
            $plac_old = $plac;
            $plac = [];
            foreach($plac_old as $item){
                $last = strlen($item)-1;
                for($m = $n; $m < $cnt; $m++){
                    if($chars[$m] > $item[$last]){
                        $plac[] = $item.$chars[$m];
                    }
                }
            }
        }
    }
    return $plac;
}

$cellComb = placing($cellStr);
var_dump($cellComb);exit();
*/
///////////////////////////////////////////////////////



// все рабочие сочетания (без перестановочных повторений) номеров ячеек таблицы "Активности Базовых стилей" 29316 сочетаний
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