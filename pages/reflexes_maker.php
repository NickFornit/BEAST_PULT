<?
/* Редактор безусловных рефлексов
http://go/pages/reflexes.php  
*/

$page_id = -1;
$title = "Создание безусловных рефлексов без коннекта с Beast";
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
//include_once($_SERVER['DOCUMENT_ROOT']."/pult_js.php");
//////////////////////////////////////////////////////////////


$bsID=0;
if(isset($_GET['bsID']))
$bsID=$_GET['bsID'];

$id_list="";
$get_list=0;
if(isset($_GET['id_list']))
{
$id_list=$_GET['id_list'];

$get_list=explode(";",$id_list); 
}


?>
<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
function get_table()
{
var link="/pages/reflexes_maker_table.php?bsID=<?=$bsID?>&id_list=<?=$id_list?>";
//alert(link);
var AJAX = new ajax_support(link, sent_table_info);
AJAX.send_reqest();
function sent_table_info(res)
{
//show_dlg_alert(res,0);
if(res[0]!='!')
{ //alert(res);
show_dlg_alert(res,0);
return;
}
document.getElementById('table_id').innerHTML=res.substr(1);
}
}
</script>
<?
//////////////////////////////////////////////////////////////
echo "<div style='position:relative;'>
<hr>
<div style='position:absolute;top:-10px;left:50%;transform: translate(-50%, 0);background-color:#ffffff;padding-left:10px;padding-right:10px;'><b>Задать условия для таблицы ввода рефлексов</b>
</div>";

echo "<div style='position:absolute;top:10px;right:10px;border:solid 1px #8A3CA4;border-radius: 7px;padding:10px;box-shadow: 8px 8px 8px 0px rgba(122,122,122,0.3);background-color:#efefef;max-width:70%;font-size:14px;'>
<b>Поясненния:</b><br>
Редактор позволяет системно и быстро создавать новые безусловные рефлексы.<br>
Системно потому, что при выборе основных условий (в виде Базового состояния и сочетания Базовых контекстов) создается таблица со всеми возможными состояниями пусковых стимулов (действий с Пульта).
В таблице используются до 3-х всех допустимых сочетаний пусковых стимулов (ПС), исключая антагонистов (несовместимых) ПС.<br>
Остается дополнить правую колонку перечислением действий.<br>
Если для данного сочетания условий уже есть рефлекс, то он отмечается вставкой ID в первой колонке и его список действий невозможно исправить здесь (можно только в <a href='/pages/reflexes.php'>основном редакторе рефлексов</a>).<br>
<b>Использование:</b><br>
В верхнем выпадающем списке выбрать Базовый контекст и под ним – отметить Базовые контексты, которые будут условиями рефлекса (если при этом будут выбраны антагонисты, они отмечаются в списке и не используются).<br>
После нажатия кнопки “Создать таблицу для заполнения рефлексами” будет сформирована таблица, в правой колонке которой можно заполнить списком действий. После заполнения таблицы следует нажать под ней “Сохранить рефлексы”, после чего новые рефлексы будут дописаны после старых. 

</div>";

echo "<b>Базовое состояние:</b><br>
<select id='base_id' > 
<option value='1' "; if($bsID==1)echo "selected"; echo ">Плохо</option>
<option value='2' "; if($bsID==2)echo "selected"; echo ">Норма</option>
<option value='3' "; if($bsID==3)echo "selected"; echo ">Хорошо</option>
</select><br>
";



// антагонисты
$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/base_context_antagonists.txt");
$strArr = explode("\r\n", $progs);  //exit("$progs");
$antFromId = array();// антагонисты для каждого выбранного в списке $get_list ID контекста
foreach ($strArr as $str) {
	$par = explode("|", $str);
	$id = $par[0];
	if(!empty($get_list) && in_array($id,$get_list))
	{
	$as = explode(",", $par[1]); 
	$antFromId[$id]=array();
	foreach ($as as $a)
	{			
	array_push($antFromId[$id],$a);
	}
	}
}
// var_dump($antFromId);exit();

// Базовые контексты $baseContextArr
include_once($_SERVER['DOCUMENT_ROOT'] . "/lib/base_context_list.php");

/z допустимое сочетания контекстов
$contextsArr=array();// ID выбранных контекстов без антагонистов
echo "<b>Выбрать сочетания контекстов:</b><br> 
<select id='base_context_id' multiple='multiple' size=12>";
foreach($baseContextArr as $k => $v)
{   
echo "<option value='".$k."' ";
if(!empty($get_list))
{

if(in_array($k,$get_list))
{ 
// исключить антагонистов, проверка для каждого выбранного ID кроме ужеж прошедших проверку
$isAntagonist=0;
foreach($contextsArr as $g)
{ 
if(in_array($k,$antFromId[$g]))
{  
$isAntagonist=1;
}
}

if($isAntagonist)
{
//echo " style='background-color:#FFDDE1;' title='Это - антагонист.'";
echo " title='Это - антагонист.'";
}
else
{
array_push($contextsArr,$k);
}
	echo "selected";
}
}
if($isAntagonist)
echo ">".$k." ".$v[0]." - антагонист</option>";
else
echo ">".$k." ".$v[0]."</option>";

}
echo "</select><br>";



echo "<br><input type='button' value='Создать таблицу для заполнения рефлексами' onClick='choose_0()'>";
//////////////////////////////////////////////////////////////

echo "<div style='position:relative;'>
<hr>
<div style='position:absolute;top:-10px;left:50%;transform: translate(-50%, 0);background-color:#ffffff;padding-left:10px;padding-right:10px;'><b>Таблица для заполнения рефлексами</b>
</div>";
//var_dump($contextsArr);exit();
//////////////////////////////////////////////////////////////
if($bsID)
{
echo "<b>Выбранные условия:</b><br>";

echo "Базовое состояние: <b>";
switch($bsID)
{
case 1: echo "Плохо"; break;
case 2: echo "Норма"; break;
case 3: echo "Хорошо"; break;
}

echo "</b>&nbsp;&nbsp;&nbsp;&nbsp;Сочетения контекстов: <b>";
$n=0;
$contextStr="";
//var_dump($contextsArr);exit();
foreach ($contextsArr as $id)
{
if($n){
	$contextStr.=";";
	echo ", ";
}
$contextStr.=$id;
echo $id."&nbsp;".$baseContextArr[$id][0];

$n++;
} 
echo "</b>";

echo "<script>
get_table();
</script>";
}
//////////////////////////////////////// ТАБЛИЦА
echo "<div id='table_id'></div>";




//////////////////////////////////////////////////////////////
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/alert2_dlg.php");
?>
<script Language="JavaScript" src="/ajax/ajax_post.js"></script>
<script>
function choose_0()
{
var bsID=document.getElementById('base_id').selectedIndex +1;
//alert(bsID);

var combo=document.getElementById('base_context_id');
var len= combo.options.length; 
var id_list="";
for(var n = 0; n < len; n++)
{
if (combo.options[n].selected==true)
{
if(id_list.length>0)
	id_list+=";";
id_list+=combo.options[n].value;
}
}
if(id_list.length==0)
	{
show_dlg_alert("Нужно выбрать как минимум один Базовый контекст.",0);
return;
	}
// alert(id_list);
location.href='/pages/reflexes_maker.php?bsID='+bsID+'&id_list='+id_list;
}
//////////////////////////////////////////////

function reflex_saver()
{
var saveStr="";
var tr =0;
var nodes = document.getElementsByClassName('r_table'); //alert(nodes.length);
for(var i=0; i<nodes.length; i++) 
{
tr=nodes[i]; //alert(tr.cells[2].childNodes[0].value);return;
// пропускаем все, что имеет ID
if(tr.cells[0].innerHTML.length>0)
	continue;
// пропускаем все, что не содержит действий
if(tr.cells[2].childNodes[0].value.length==0)
	continue;

//alert(tr.cells[1].innerHTML);return;
saveStr+=tr.cells[1].childNodes[0].value+"|"+tr.cells[2].childNodes[0].value+"||";
}//for(

if(saveStr.length==0)
{
show_dlg_alert("Нет новых рефлексов, содержащих ID действий.",2000);
return;
}
/////////////////////////
saveStr="bsID=<?=$bsID?>&id_list=<?=$contextStr?>&saveStr="+saveStr;  // alert(saveStr);return;
var link="/pages/reflexes_maker_saver.php";
//alert(link);
var AJAX = new ajax_post_support(link,saveStr, sent_table_save,1);
AJAX.send_reqest();
function sent_table_save(res)
{
//show_dlg_alert(res,0);
if(res[0]!='!')
{ //alert(res);
show_dlg_alert(res,0);
return;
}
show_dlg_alert("Записаны новые рефлексы.",2000);
// убрать таблицу, чтобы второй раз не записывать (т.к. там нет ID рефлексов у только что записанных)
document.getElementById('table_id').innerHTML="";
}
}
////////////////////////////////
function show_actions_list(nid)
{
event.stopPropagation();
var selected=document.getElementById("input_" + nid).value;
//show_dlg_alert(nid,0);
event.stopPropagation();
		var AJAX = new ajax_support("/lib/get_actions_list.php?selected="+selected, sent_act_info);
		AJAX.send_reqest();

		function sent_act_info(res) {
			show_dlg_alert2("<br><span style='font-weight:normal;'>Выберите значения:<br>(используйте Ctrl+клик и Shift+клик)<br>" + res + "<br><input type='button' value='Выбрать значения' onClick='set_input_list("+nid + ")'>", 2);
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
		document.getElementById("input_" + nid).value = aStr;

		end_dlg_alert2();
}
</script>

