<?
/*  Выдать контрол для выбора Пусковых стимулов из списка ДЛЯ РЕФЛЕКСОВ
/lib/get_triggers_list.php?nid=1&selected=1,3
*/
header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=UTF-8');

$nid=$_GET['nid'];
$selected=$_GET['selected'];


// реально возможные сочетания контекстов
$c_list = read_file($_SERVER["DOCUMENT_ROOT"] . "/pages/combinations/list_triggers_str.txt");
//$c_list=str_replace(";",",",$c_list);
$triggersIdArr=explode("\r\n",$c_list); // var_dump($triggersIdArr);exit();
$nsel=0;
$n=0;
foreach($triggersIdArr as $str)
{
//	echo "$selected==$str <br>";
if($selected==$str)
	{
$nsel=$n; // exit("> $nsel");
	}

$n++;
}


$c_list = read_file($_SERVER["DOCUMENT_ROOT"] . "/pages/combinations/list_triggers_names.txt");
//$c_list=str_replace(";",",",$c_list);
$triggersnamesArr=explode("\r\n",$c_list); // var_dump($triggersnamesArr);exit();
$out="";
$n=0;
foreach($triggersnamesArr as $str)
{
	if(substr_count($str, ',')>1)// не более 2-х сочетаний контектосв!
	continue;

	$bg="";
	if($nsel==$n)
	{
		$bg="#cccccc";
//		exit("> $nsel");
	}
$out.="<div style='text-align:left;cursor:pointer;background-color:".$bg.";' onClick='set_input3_list(".$nid.",`".$triggersIdArr[$n]."`)'>".$str."</div>";
$n++;
}

exit($out);

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