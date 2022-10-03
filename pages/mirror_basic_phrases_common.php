<?
/* Заполнить общий шаблон ответов  для http://go/pages/mirrors_automatizm.php

http://go/pages/mirror_basic_phrases_common.php

trigg|answers|ton,mood|actions
*/
$page_id = -1;
$title = "Заполнить общий шаблон ответов для имитации &quot;отзеркаливания&quot;";
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
//include_once($_SERVER['DOCUMENT_ROOT']."/pult_js.php");
//////////////////////////////////////////////////////////////

echo '<div style="position:absolute;top:35px;right:10px;color:red"> - только после формирования шаблонов условных рефлексов</div>';


if(isset($_POST['gogogo'])&&$_POST['gogogo']==1)
{
$out="";
foreach($_POST['trigg'] as $id => $trigg)
{
$_POST['answ'][$id]=trim($_POST['answ'][$id]);
$_POST['actn'][$id]=trim($_POST['actn'][$id]);
if(empty($_POST['answ'][$id]) && empty($_POST['actn'][$id]))// незаполненные фразы не писать
	continue;

$out.=$trigg."|".$_POST['answ'][$id]."|".$_POST['ton_mood'][$id]."|".$_POST['actn'][$id]."\r\n"; // exit("$out");
}

//exit("$out");
writing_file($_SERVER["DOCUMENT_ROOT"]."/lib/mirror_basic_phrases_common.txt",$out);

echo "<form name=\"refresh\" method=\"post\" action=\"/pages/mirror_basic_phrases_common.php\"></form>";
echo "<script language=\"JavaScript\">document.forms['refresh'].submit();</script>";
exit();
}
//////////////////////////////////////////////

// Пусковые стимулы
// все используемые фразы в шаблонах условных рефлексов
include_once($_SERVER['DOCUMENT_ROOT'] . "/pages/mirrors_automatizm_get_all_phrases.php");


///////////////////////////////////////
// сохраненные фразы-ответы   trigg|answers|ton,mood|actions
$file=$_SERVER["DOCUMENT_ROOT"]."/lib/mirror_basic_phrases_common.txt";
$progs = reading_file($file); 
$strArr = explode("\r\n", $progs);  //var_dump($strArr);exit();
$phraseArr=array();
	foreach ($strArr as $str) {
		if (empty($str))
			continue;
		$p = explode("|", $str);
		$phraseArr[$p[0]][0]=$p[1];
		$phraseArr[$p[0]][1]=$p[2];
		$phraseArr[$p[0]][2]=$p[3];
	}
//  var_dump($phraseArr);exit();

///////////////////////////////////////////////////////////////////////





$out="<table class='main_table' cellpadding=0 cellspacing=0 border=1 width='1000px'>
		<tr>
			<th width=150  class='table_header'>Пусковая фраза</th>
			<th  class='table_header'>Ответная фраза</th>
			<th  width=120 class='table_header'><nobr>Тон и настроение</nobr></th>
			<th  width=150 class='table_header'>Ответные действия</th>
		</tr>";

$nid=0;
foreach ($triggerPhraseArr as $tArr)
{
//	var_dump($resArr);exit();
$out.="<tr class='r_table highlighting' style='background-color:#eeeeee;' onClick='set_sel(this,`" . $index . "`)'>";

// пусковые стимулы
$out.="<td class='table_cell'><input type='hidden'  name='trigg[]' value='".$tArr."'><nobr>".$tArr."</nobr></td>";

// фразы-ответы
$answ="";
$tm="0,0";
$actn="";
if(isset($phraseArr[$tArr]))
{
$answ=$phraseArr[$tArr][0];
$tm=$phraseArr[$tArr][1];
$actn=$phraseArr[$tArr][2];
}
$out.="<td  class='table_cell'><input  name='answ[]' class='table_input' type='text' value='".$answ."' ></td>";

$out.="<td  class='table_cell'><input id='insert_".$nid."' name='ton_mood[]' class='table_input' type='text' value='".$tm."' ><img src='/img/down17.png' class='select_control' onClick='show_ton_mood(".$nid.")' title='Выбор Тона и Настроения'></td>";

$out.="<td  class='table_cell'><input id='insert2_".$nid."' name='actn[]' class='table_input' type='text' value='".$actn."' ><img src='/img/down17.png' class='select_control' onClick='show_actions_list(".$nid.")' title='Выбор действий'></td>";

$out.="</tr>";
$nid++;
}
$out.="</table>";

$out.="<br><input type='submit' value='Сохранить' >";


/////////////////////////////////////////////////////////
echo "<div style='font-size:16px;' >Фразы могут быть <b>НЕ уникальны</b><br>
В таблице показаны все встречающиеся в шаблонных условных рефлексах фразы.</div>";
echo 'Cохранение по Ctrl+S<form id="form_id" name="form" method="post" action="/pages/mirror_basic_phrases_common.php">';
echo $out;
echo "<input type='hidden' name='gogogo' value='1'>
</form>";




//////////////////////////////////////
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/alert2_dlg.php");

$ton_moode_dlg="<br><div style='text-align:left;'>
<b>Тон:</b> &nbsp; 
<input id='radio_0' type='radio' name='rdi' value='0' checked>0 нормальный &nbsp;
<input id='radio_1' type='radio' name='rdi' value='1'>1 вялый &nbsp;
<input id='radio_2' type='radio' name='rdi' value='2' >2 повышенный <br>

<br><b>Настроение:</b> &nbsp;
<input id='radio2_0' type='radio' name='rdi2' value='0' checked>0 Нормальное &nbsp;
<input id='radio2_1' type='radio' name='rdi2' value='1' >1 Хорошее &nbsp;
<input id='radio2_2' type='radio' name='rdi2' value='2' >2 Плохое &nbsp;
<input id='radio2_3' type='radio' name='rdi2' value='3'>3 Игровое &nbsp;
<input id='radio2_4' type='radio' name='rdi2' value='4'>4 Учитель &nbsp;
<input id='radio2_5' type='radio' name='rdi2' value='5'>5 Агрессивное&nbsp;
<input id='radio2_6' type='radio' name='rdi2' value='6'>6 Защитное &nbsp;
<input id='radio2_7' type='radio' name='rdi2' value='7'>7 Протест </div>";

?>
<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>

// сработает перед закрытием show_dlg_confirm
function onw_dlg_exit_proc()
{
//alert("onw_dlg_exit_proc");
var allr=document.getElementsByName('rdi'); //alert(allr.length);
var ton=0;
for(var i=0; i<allr.length; i++)
{
    if (allr[i].checked) 
	{
		ton=allr[i].value;
      break; 
	}
}
var allr=document.getElementsByName('rdi2');
var moode=0;
for(var i=0; i<allr.length; i++)
{
    if (allr[i].checked) 
	{
		moode=allr[i].value;
      break; 
	}
}
var inp=document.getElementById('insert_'+cur_ton_moode_id).value=ton+","+moode;

}
var cur_ton_moode_id=0;
function show_ton_mood(id)
{  
cur_ton_moode_id=id;
var cont=`<?=$ton_moode_dlg?>`;
is_onw_dlg_exit_proc=1; //предопределенная переменнная
show_dlg_alert("<br><span style='font-weight:normal;'>Выберите Тон и настроение:<br>" + cont + "<br>", 0);
// проставить выделение старого выбора
var inp=document.getElementById('insert_'+cur_ton_moode_id).value;
if(inp.length>0)
{
var tm=inp.split(","); //alert(tm[0]+" | "+tm[1]+" || "+tm.length);
  //alert(document.getElementById('radio_2').checked);
document.getElementById('radio_'+tm[0]).checked=true;
document.getElementById('radio2_'+tm[1]).checked=true;
}

//is_onw_dlg_exit_proc=0 - при закрытии само очистится
}
///////////////////////////////////
function set_sel(tr, id) {
		//	alert(id);
		var nodes = document.getElementsByClassName('highlighting'); //alert(nodes.length);
		for (var i = 0; i < nodes.length; i++) {
			nodes[i].style.border = "solid 1px #000000";
		}
		tr.style.border = "solid 2px #000000";
}

	// сохранение по Ctrl+S
var is_press_strl = 0;
document.onkeydown = function(event) { 
		var kCode = window.event ? window.event.keyCode : (event.keyCode ? event.keyCode : (event.which ? event.which : null))

		//alert(kCode);
		if (kCode == 17) // ctrl
			is_press_strl = 1;

		if (is_press_strl) {
			if (kCode == 83) {
				event.preventDefault();
				//alert("!!!!! ");
				save_CTRRLS();
				is_press_strl = 0;
				return false;
			}
		}
}
////////////////////
document.onmouseup = function(event) { 
var t = event.target || event.srcElement;    
while(t)
{ 
if(t.id == "div_dlg_alert2")
	 return;	    
t = t.offsetParent;
}
end_dlg_alert2(); 
}
///////////////////////////
function save_CTRRLS()
{
show_dlg_confirm("Сохранить список?",1,-1,prases_saver);
}
function prases_saver()
{
document.forms.form_id.submit();
}
//////////////////////////////////////
////////////////////////////////
function show_actions_list(nid)
{
event.stopPropagation();
var selected=document.getElementById("insert2_" + nid).value;
//show_dlg_alert(selected,0);
event.stopPropagation();
		var AJAX = new ajax_support("/lib/get_actions_list.php?selected="+selected, sent_act_info);
		AJAX.send_reqest();

		function sent_act_info(res) {
			show_dlg_alert2("<br><span style='font-weight:normal;'>Выберите значения:<br>" + res + "<br><input type='button' value='Выбрать значения' onClick='set_input_list("+nid + ")'>", 2);
		}
}
/////////////////////////////
function set_input_list(nid) {
var aStr = "";
var nodes = document.getElementsByClassName('chbx_identiser'); //alert(nodes.length);
for(var i=0; i<nodes.length; i++) 
{
if(nodes[i].checked)
	{
if(aStr.length > 0)
	aStr += ",";
aStr += nodes[i].value;
	}
}
		//alert(aStr);
		document.getElementById("insert2_" + nid).value = aStr;

		end_dlg_alert2();
}
/////////////////////////////////////////
</script>
<?
//////////////////////////////////////////////////////////////////////






function get_prase_exists($index)
{
global $phraseArr; //exit("$id");
//echo "$bsID | $id_list | $actions<br>";

if(isset($phraseArr[$index]))
	return $phraseArr[$index];// вернуть фразу

return "";
}
///////////////////////////////////////////////////
function get_actions($trArr)
{
	global $rActionsArr;
$acts="";
$aArr=explode(",",$trArr); 
foreach($aArr as $a)
{
	if(empty($a))
		continue;
	if(!empty($acts))
		$acts.=", ";
$acts.=$a." ".$rActionsArr[$a]."";
}
return $acts;
}
///////////////////////////////////////////////////
function reading_file($file)
{
if(!file_exists($file))
	return "";
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
///////////////////////////////////////////////////
function writing_file($file,$content)
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