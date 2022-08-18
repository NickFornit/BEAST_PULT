<?
/*  ������������� ������� ��������� ������� ����������

include_once($_SERVER['DOCUMENT_ROOT'] . "/pages/reflexes_maker_context_combinations.php");
*/



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



////////// ������� ���������� ������� ������
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
// ������������ ������������ ��������� ������� ������� ���������
$tComb=array();
$nNumbers=5;
for($n=1;$n<$nNumbers;$n++)
{
array_push($tComb,array($n));
$a2=array();
array_push($a2,$n);
for($m=$n+1;$m<$nNumbers;$m++)
{
array_push($a2,$m);// ����������� �� ������
array_push($tComb,$a2);
} 
}
// �� ������� ��������� ������� �� 1 ����� �������
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



// ��� ������� ��������� (��� ��������������� ����������) ������� ����� ������� "���������� ������� ������" 29316 ��������� ��� �������� ����� ��������� (���������� �� ����)
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



// ��� ������� ��������� (��� ��������������� ����������) ������� ����� ������� "���������� ������� ������" 29316 ���������
$cellComb=array();
$nNumbers=56;
for($n=0;$n<$nNumbers;$n++)
{
array_push($cellComb,array($n));
$a2=array();
array_push($a2,$n);
for($m=$n+1;$m<$nNumbers;$m++)
{
array_push($a2,$m);// ����������� �� ������
array_push($cellComb,$a2);
} 
}
// �� ������� ��������� ������� �� 1 ����� �������
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




// �� ������� ��������� ������� ����� �����
$contextsArr0=array();// ��������� ����������
$n=0;
foreach($cellComb as $ccomb)
{
$sumArr=array();// �������� �������� ����� ������� ��������� $ccomb
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


// ������ ������������, ������������� ��������� (������� ������ ��������) � ��������� ��������� ���������� � ������, �������� ������ ����������
$contextsArr=array();// ��������� ����������
foreach($contextsArr0 as $comb)
{
$str="";  
$minusArr=array();
$antArr=array();

foreach($comb as $a)// ���������� � �������� �������������
{
	if($a<0){
		array_push($minusArr,-$a);
	}
}
$antArr=array();// ��� �������� ������������
foreach($comb as $a)
{
	if($a<0){
		continue;
	}
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
}
$contextsArr=array_unique($contextsArr);// ����� ��������� - 35 :)

//var_dump($contextsArr);exit("<hr>����� ���������: ".count($contextsArr));






///////////////////////////////////////////
// ����������� �� ����������� ���� ����������
uasort($contextsArr, "cmpare");
function cmpare($a, $b) 
{ 
    if (strlen($a) == strlen($b)) {
        return 0;
    }
    return (strlen($a) < strlen($b)) ? -1 : 1;
}

// var_dump($contextsArr);exit("<hr>����� ���������: ".count($contextsArr));


// ��������� ������ ����� ���������� � ���.�����  combo_contexts_str.txt
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