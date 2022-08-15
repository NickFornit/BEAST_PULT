<?
/* ������ ��������� ��������� ������� ���������� � ����������� �� �������� ���������
��� http://go/pages/reflexes.php 

/pages/reflexes_maker_b_contexts.php?base_condition=1

C�������� ��������� ���������� ���������� �� ����������� � ����� ������� ���������� (������������ � �� func commonBadDetecting()) � ��� ���������, ��������, ������� ��������� ������ ��������� ����� ��������� ����� ������ ���������� �����-����������.
������� ���������� ��������� ��������� �������� ������� ����������, ������ ������� ���������.
��� ��� �������� $base_condition �� ������������.

��������:
1.	������� ������ ���� ��������� ��������� ���������� ���������� (��), � ������� ��� ���������� ����������-������������, ��� � ����� ���� 35 ��������� 8-� ����������.
2.	������ ������� ������� �� ��������� �� � ��� ������� ID �.��������� ��������� ID ��������jd �� ������ ������� ������� "���������� ������� ������" ��� ������� ��������� id �.����������. �������� ��� ��������� ��������� ���������� ��� ������ ��������� �.����������. 
3.	� ���������� �������� ��� ��������� ��������� ��������� � ���� ����� � ������������ �;� � ������ ������������ � ������������ (� ������� "���������� ������� ������") ����������.

���������:
��-�� ����, ��� ��� ��������� ��������� � ������� "���������� ������� ������", ��� ������������� ������ ��� ��������� ���������� �.���������� � �� ��� �������� ��������� ����������.
*/

header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_ALL, "ru_RU.UTF-8");

$base_condition=$_GET['base_condition']; // �� ������������ �.�. ��� ������������� �����������
$get_list=$_GET['get_list'];  //exit($get_list);

// �����������
$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/base_context_antagonists.txt");
$strArr = explode("\r\n", $progs);  //exit("$progs");
$antFromId = array();// ����������� ��� ������� ���������� � ������ $get_list ID ���������
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

// ������� ��������� $baseContextArr - ������ ��� ��������� ���� ������� ����������
include_once($_SERVER['DOCUMENT_ROOT'] . "/lib/base_context_list.php");



////////// ���������� ������� ������ ��� ��������� ���� ��������� ��������� ������� ����������
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


$aComb=array();// ���������� ���� �.����������
for($n=1;$n<9;$n++)
{
array_push($aComb,array($n));
$a2=array();
array_push($a2,$n);
for($m=$n+1;$m<9;$m++)
{
array_push($a2,$m);// ����������� �� ������
array_push($aComb,$a2);
} 
}
// var_dump($aComb);exit();

///////////////////////////////////////////////////////

$contextsArr=array();// ��������� � ���� 1;2
$n=0;
foreach($aComb as $idArr)
{
	$contCol=array();// ��������� � ���� 1;2 - ��� ������ ���������� �.����������
	for($nCol=0;$nCol<7;$nCol++)
	{
		$contCol[$nCol]=array();
	}
foreach($idArr as $id)// id �.����������
{ 

foreach($contextArr[$id] as $sa)// ������ ������� "���������� ������� ������"
{ 
// ��������� ��������� �� ������ ������� ������� ��� ������� ��������� id �.����������
$minusArr=array();
for($nCol=0;$nCol<7;$nCol++)
	{
$p = explode(",", $contextArr[$id][$nCol]);  
sort($p, SORT_NUMERIC);reset($p);// �� ��������, ����� ����� ���� ������� �������������

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
// �������� ������ ����������, ������ ������������ � ��������� ��������� ���������� � ������
for($nCol=0;$nCol<7;$nCol++)
	{
		$contCol[$nCol]=array_unique($contCol[$nCol]);
		$str="";
$antArr=array();// ��� �������� ������������
		foreach($contCol[$nCol] as $a)
		{
			if(empty($a) )// || $a<0
				continue;
// ������ ������������� ��������� (������� ������ ��������)
if(in_array($a,$minusArr))
{
continue;
}

// ��������� ������������, �������� ��� ������� ���������� ID ����� ��� ��������� ��������
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

// ����������� �� ����������� ���� ����������
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

// ������� ���������
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