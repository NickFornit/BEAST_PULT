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


// сгенерировать рабочие сочетания Базовых контекстов
include_once($_SERVER['DOCUMENT_ROOT'] . "/pages/reflexes_maker_context_combinations.php");


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