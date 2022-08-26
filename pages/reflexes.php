<?
/* Редактор безусловных рефлексов
http://go/pages/reflexes.php  
*/
$sorting=0;
if(isset($_GET['sorting']))
$sorting=$_GET['sorting'];

$selected=0;
if(isset($_GET['selected']))
$selected=$_GET['selected'];

$page_id = 4;
$title = "Редактор безусловных рефлексов";
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
//include_once($_SERVER['DOCUMENT_ROOT']."/pult_js.php");

if (filesize($_SERVER['DOCUMENT_ROOT'] . "/memory_reflex/condition_reflexes.txt") > 6) {
	echo "<div style='color:red;border:solid 1px #8A3CA4;padding:10px;background-color:#DDEBFF;'>Этот редактор <b>НЕ СЛЕДУЕТ ИСПОЛЬЗОВАТЬ</b> потому, что уже есть условные рефлексы.<br>Чтобы использовать редактор, нужно сбросить память Beast (на странице Пульса справа вверху нажать шестеренку и выбрать &quot;Сбросить память&quot;) <br>или <b>просто удалить содержимое в файле /memory_reflex/condition_reflexes.txt</b></div>";
}


echo "<div style='position:absolute;top:40px;left:500px;'><a href='/pages/reflexes_maker.php' title='Создание безусловных рефлексов в зависимости от заданных условий без коннекта с Beast.'>Набивка рефлексов</a></div>";


echo "<div style='position:absolute;top:40px;left:700px;'><a href='/pages/reflex_tree.php'>Дерево рефлексов</a></div>";
//exit("!!!!");

//////////////////////////////////////// САБМИТЫ
///////////////////////////////////////////////
/*
if(isset($_POST['gogogo'])&&$_POST['gogogo']==1)
{
$out=""; 
//var_dump($_POST);exit();
$n=0;
$back="";// чисто для контроля
foreach($_POST['id1'] as $id => $str)
{
$id1=trim($str);
$id2=trim($_POST['id2'][$id]);
$id3=trim($_POST['id3'][$id]);
$id4=trim($_POST['id4'][$id]);
$id5=trim($_POST['id5'][$id]);

$out.=$id1."|".$id2."|".$id3."|".$id4."|".$id5."\r\n";
}

//exit("$out");
write_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/dnk_reflexes.txt",$out);

echo "<form name=\"refresh\" method=\"post\" action=\"/pages/reflexes.php\"></form>";
echo "<script language=\"JavaScript\">document.forms['refresh'].submit();</script>";
exit();
}
*/
////////////////////////////////////////// УДАЛЕНИЕ
if (isset($_GET['delete_id'])) {
	$deln = (int)$_GET['delete_id']; //exit("! $deln");
	$str = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/dnk_reflexes.txt");
	$list = explode("\r\n", $str);  //exit("! $str | ".$_GET['delete_id']);
	$wArr = array();
	$out = "";
	$n = 0;
	foreach ($list as $s) {
		if (empty($s)) {
			$n++;
			continue;
		}
		//exit("! $id | $s");
		if ($n == $deln) {
			$n++;
			continue;
		}
		$out .= $s . "\r\n";
		$n++;
	}
	//exit("! $deln | $n");
	write_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/dnk_reflexes.txt", $out);

	echo "<form name=\"refresh\" method=\"post\" action=\"/pages/reflexes.php\"></form>";
	echo "<script language=\"JavaScript\">document.forms['refresh'].submit();</script>";
	exit();
}
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/alert2_dlg.php");

echo "<div class='main_page_div' style=''>";
?>

<script Language="JavaScript" src="/ajax/ajax_form_post.js"></script>



<span class="spoiler_header" onclick="open_close('lib_block_id',1)" style="cursor:pointer;font-size:16px"><?=set_sopiler_icon('lib_block_id')?><b>Справочные данные</b></span>
<div id="lib_block_id" class="spoiler_block spoiler" style="position:relative;z-index:10;top:0px;left:0px;padding-left:15px;background-color:#ffffff;width:1100px;height:0px;">
	Для ввода условий срабатывания рефлекса нужно использовать ID этих условий:
	<h2 class="header_h2">Первый уровень - ID базовых состояний:</h2>
	<span style='padding-right:20px;'>1 - Похо</span>
	<span style='padding-right:20px;'>2 - Норма</span>
	<span style='padding-right:20px;'>3 - Хорошо</span>
	<h2 class="header_h2">Второй уровень - ID актуальных Базовых Контекстов через запятую:</h2>
<?
include_once($_SERVER['DOCUMENT_ROOT'] . "/lib/base_context_list.php");
foreach($baseContextArr as $id => $val)
{
echo "<span style='padding-right:20px;' title='".$val[1]."'>".$id." ".$val[0]."</span>";
}
?>

	<h2 class="header_h2">Третий уровень - ID пусковых стимулов через запятую:</h2>
	Антагонисты окрашены в разные цвета. <span style='color:red'>Нельзя, чтобы в условии были антагонистические ID.</span><br>
<?
include_once($_SERVER['DOCUMENT_ROOT'] . "/lib/actions_from_pult.php");
foreach ($actionsFromPultArr as $k => $v)
{
$bg="#000000";
if($k==1 ||$k==3 ||$k==10 ||$k==12 ||$k==15)
	$bg="#ff3300";
if($k==2 ||$k==4 ||$k==11 ||$k==13 ||$k==14)
	$bg="#009D00";
$v[1]=str_replace(" ","&nbsp;",$v[1]);
echo "<span style='padding-left:20px;color:".$bg."' title='".$v[1]."'>".$k."&nbsp;".$v[0]."</span> ";
}
?>


	<hr>
	<h2 class="header_h2"><a href="/pages/terminal_actions.php">Действия рефлекса</a> - ID одновременных действий через запятую:</h2>
	<?
	$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/terminal_actons.txt");
	$strArr = explode("\r\n", $progs);
	echo "<table border=0><tr>";
	$nCol = 0;
	$n = 0;
	foreach ($strArr as $str) {
		if (empty($str) || $str[0] == '#')
			continue;
		if ($nCol == 8) {
			echo "</tr><tr>";
			$nCol = 0;
		}
		$p = explode("|", $str);
		$id = $p[0];
		$str = $id . " " . $p[1];

		$bg = "";
		if ($id < 30) {
			$bg = "style='color:#B16DB4;'";
		}
		echo "<td " . $bg . ">" . $str . "</td>";

		$nCol++;
		$n++;
	}
	echo "</tr></table>";
	?>
</div>
	<div style="position:relative;">
		<hr>
		<div style="position:absolute;top:-10px;left:50%;transform: translate(-50%, 0);background-color:#FFFFCC;">
			<nobr>При щелчке на строке сверху в желтом боксе показывается расшифровка введенных данных.</nobr>
		</div>
	</div>

	<div id="helper_id" style="position:fixed;z-index:1000;top:0px;right:0px;
background-color:#FFFFCC;
padding:6px;
box-shadow: 8px 8px 8px 0px rgba(122,122,122,0.3);
border:solid 1px #81853D; border-radius: 7px;"></div>


<span style="color:red">Если для каких-то действий НЕ заполнена строка рефлекса, задающая условия</span>, то будет выдавать "<b>Игнорирует</b>".<br>
<br>
<div style="position:relative;">
	<h2 id="h2_id" class="header_h2" style="margin-top:0px;">Рефлексы:</h2>
	<div style="position:absolute;top:0px;left:150px;">Сохранение: <b>Ctrl+S</b></div>
	<a style="position:absolute;top:0px;right:0px;cursor:pointer;" href="/pages/reflexes_help.htm" target="_blank">Пояснение как заполнять таблицу</a>
</div>

<div style="position:relative;margin-bottom:4px;">
Показывать только: 
<span class="filtre_item" onClick='set_philter(1)' <?echo set_filter_bg(1)?>>Плохо</span>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="filtre_item" onClick='set_philter(2)' <?echo set_filter_bg(2)?>>Норма</span>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="filtre_item" onClick='set_philter(3)' <?echo set_filter_bg(3)?>>Хорошо</span>&nbsp;&nbsp;&nbsp;&nbsp;
<span class="filtre_item" onClick='set_philter(4)' <?echo set_filter_bg(4)?>>Без Пусковых стимулов</span>
<span class="filtre_item" onClick='set_philter(0)' <?echo set_filter_bg(0)?>>Показать ВСЕ</span>
</div>
<?
function set_filter_bg($nF)
{
	global $selected;  // exit("! $selected");
	switch($nF)
	{
case 1: if($selected==1)return "style='background-color:#C2FFC5;'"; break;
case 2: if($selected==2)return "style='background-color:#C2FFC5;'"; break;
case 3: if($selected==3)return "style='background-color:#C2FFC5;'"; break;
case 4: if($selected==4)return "style='background-color:#C2FFC5;'"; break;
case 0: if($selected==0)return "style='background-color:#C2FFC5;'"; break;
	}
}
?>

<form id="form_id" name="form" method="post" action="/pages/reflexes.php">
	<table id="main_table" class="main_table" cellpadding=0 cellspacing=0 border=1 width='100%' style="font-size:14px;">
		<tr>
			<th width=70 class='table_header' style='cursor:pointer;background-color:#DDDDFF;' title='Сортировка по ID' onClick='sorting(1)'>ID<br>рефлекса</th>
			<th width=70 class='table_header' style='cursor:pointer;background-color:#DDDDFF;' title='Сортировка по Базовому состоянию' onClick='sorting(2)'>ID (1 уровень)<br>
				<nobr>базового состояния</nobr>
			</th>
			<th width='25%' class='table_header'>ID (2) актуальных контекстов<br>через запятую</th>
			<th width='25%' class='table_header'>ID (3) пусковых стимулов<br>через запятую</th>
			<th width='25%' class='table_header'>ID действий<br>через запятую</th>
			<th width='30' class='table_header' title="Удалить рефлекс">Х</th>
		</tr>
		<?
		// считать файл 
		$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/dnk_reflexes.txt");
		$strArr = explode("\r\n", $progs);  //var_dump($strArr);exit();
// реально возможные сочетания контекстов
$c_list = read_file($_SERVER["DOCUMENT_ROOT"] . "/pages/combinations/combo_contexts_str.txt");
$c_list=str_replace(";",",",$c_list);
$allowContextArr=explode("\r\n",$c_list); // var_dump($allowContextArr);exit();

if($sorting)
{
	if($sorting==2)
	{
uasort($strArr, "sort_cmp");
	}
}
function sort_cmp($a, $b)
{
	$par1 = explode("|", $a);
	$par2 = explode("|", $b);

    if ($par1[1] == $par2[1]) {
        return 0;
    }
    return ($par1[1] < $par2[1]) ? -1 : 1;
}
////////////////////////////////////////////////////////////////////////

		$n = 0;
		$lastID = 1;
		$notAllowContexts=0;// 1 - есть невозможные сочетания контекстов
		foreach ($strArr as $str) {
			if (empty($str))
				continue;
			$par = explode("|", $str);
			$id = $par[0];
//exit("$selected | ".$par[1]);
if($selected==1 && $par[1]!=1 ||
	$selected==2 && $par[1]!=2 ||
	$selected==3 && $par[1]!=3 ||
	$selected==4 && !empty($par[3]))// не показывать эту строку
{
echo "<input type='hidden' name='id1[" . $id . "]' value='" . $par[0] . "'  >";
echo "<input type='hidden' name='id2[" . $id . "]' value='" . $par[1] . "'  >";
echo "<input type='hidden' name='id3[" . $id . "]' value='" . $par[2] . "'  >";
echo "<input type='hidden' name='id4[" . $id . "]' value='" . $par[3] . "'  >";
echo "<input type='hidden' name='id5[" . $id . "]' value='" . $par[4] . "'  >";
}
else
{
			echo "<tr class='highlighting' onClick='set_sel(this," . $id . ")'>
<td class='table_cell' style='width:40px;background-color:#eeeeee;' ><input type='hidden' name='id1[" . $id . "]' value='" . $par[0] . "'  >" . $par[0] . "</td>";
			$bg = "";
			$title = "";
			if (empty($par[1])) {
				$bg = "style='background-color:#FFDADD;'";
				$title = "title='Рефлекс будет привящан ко всем узлам дерева данного уровня.'";
			}
			echo "<td class='table_cell'><input class='table_input firstlevel' type='text' name='id2[" . $id . "]' " . only_int_inp() . "  value='" . $par[1] . "'  " . $bg . " " . $title . "></td>";
			$bg = "";
			$title = "";
			if (empty($par[2])) {
				$bg = "style='background-color:#FFDADD;'";
				$title = "title='Рефлекс будет привящан ко всем узлам дерева данного уровня.'";
			}

$c_title="title='Сочетание Базовых контекстов.'";
if(!in_array($par[2],$allowContextArr))
{
$bg="style='background-color:#FF858B;'";
$c_title="title='НЕВОЗМОЖНОЕ сочетание Базовых контекстов.'";
$notAllowContexts=1;// 1 - есть невозможные сочетания контекстов
}

			echo "<td class='table_cell'><input id='lev2_" . $id . "' class='table_input firstlevel' type='text' name='id3[" . $id . "]' " . only_numbers_and_Comma_input() . "  value='" . $par[2] . "' " . $bg . " " . $c_title . "><img src='/img/down17.png' class='select_control' onClick='show_control(this,2," . $id . ")' title='Выберите сочетание'></td>";
			$bg = "";
			$title = "";
			if (empty($par[3])) {
				$bg = "style='background-color:#FFDADD;'";
				$title = "title='Рефлекс будет привящан ко всем узлам дерева данного уровня.'";
			}
			echo "<td class='table_cell'><input id='lev3_" . $id . "' class='table_input' type='text' name='id4[" . $id . "]' " . only_numbers_and_Comma_input() . "  value='" . $par[3] . "' " . $bg . " " . $title . "><img src='/img/down17.png' class='select_control' onClick='show_control(this,3," . $id . ")' title='Выбор значений'></td>";

			$bg = "";
			$title = "";
			if (empty($par[4])) {
				$bg = "style='background-color:#FFB8B8;'";
				$title = "title='Рефлекс - БЕЗ ДЕЙСТВИЙ!'";
			}
			echo "<td class='table_cell'><input id='lev4_" . $id . "' class='table_input' type='text' name='id5[" . $id . "]' " . only_numbers_and_Comma_input() . "  value='" . $par[4] . "' " . $bg . " " . $title . "><img src='/img/down17.png' class='select_control' onClick='show_control(this,4," . $id . ")' title='Выбор значений'></td>";
			echo "<td class='table_cell' align='center'  title='Удалить рефлекс'><a href='/pages/reflexes.php?delete_id=" . $n . "' onclick='return confirm(\"Точно удалить?!\")'><img src='/img/delete.gif'></a></td>
</tr>";
			$n++;
			$lastID = $id + 1;
}
		}
		?>
	</table>

	<div style="position:relative;">
		<input type='hidden' name='gogogo' value='1'>
		<input id='removeNotAllowe_id' type='hidden' name='removeNotAllowe' value='0'>
		<input style="position:absolute;top:0px;right:0px;" type="button" name="saver" value="Сохранить" onClick="check_and_sabmit(0)">
<?
if($notAllowContexts)// 1 - есть невозможные сочетания контекстов
{
echo '<input style="position:absolute;top:0px;left:50%;transform: translate(-50%, 0);" type="button" name="saver" value="Удалить рефлексы c невозможными сочетаниями контекстов" onClick="check_and_sabmit(1)" title="При сохранении очистить таблицу от рефлексов с невозможными сочетаниями Базовых контекстов.">';
}
?>

		<input style="position:absolute;top:0px;left:0px;" type="button" name="addnew" value="Добавить новую строку" onClick="add_new_line()">
	</div>
</form>
<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
	function check_and_sabmit(removeNotAllowe) {
if(removeNotAllowe)
			{
	document.getElementById('removeNotAllowe_id').value=1;
			}  

		var nodes = document.getElementsByClassName('firstlevel'); //alert(nodes.length);
		for (var i = 0; i < nodes.length; i++) {
			if (nodes[i].value.length == 0) {
				show_dlg_alert("ID 1 и 2-го  уровеня (стоблцы 2 и 3) должны быть заполнены.", 0); 
				return;
			}
		}
		//document.forms.form.submit();
		wait_begin();
		var AJAX = new ajax_form_post_support('form_id', '/pages/reflexes_server.php', sent_request_res);
		AJAX.send_form_reqest();

		function sent_request_res(res) {
			wait_end();
			if (res != '!') {
				show_dlg_alert(res, 0);
				return;
			}
			show_dlg_alert("Сохранено", 1500);
			setTimeout("location.reload(true)", 1500);
		}
	}
	var lastID = <?= $lastID ?>;

	function add_new_line() {
		var tbl = document.getElementById('main_table');
		var currow = tbl.rows.length;
		tbl.insertRow(currow);
		tbl.rows[currow].insertCell(0);
		tbl.rows[currow].cells[0].style.backgroundColor = "#eeeeee";
		tbl.rows[currow].cells[0].innerHTML = "<input type='hidden' value='" + lastID + "' name='id1[" + lastID + "]'>" + lastID + "";
		tbl.rows[currow].insertCell(1);
		tbl.rows[currow].cells[1].innerHTML = "<input class='table_input' type='text' name='id2[" + lastID + "]' <? echo only_int_inp(); ?>  value=''  >";
		tbl.rows[currow].insertCell(2);
		tbl.rows[currow].cells[2].className="table_cell";
		tbl.rows[currow].cells[2].innerHTML = "<input  id='lev2_"+ lastID + "' class='table_input' type='text' name='id3[" + lastID + "]' <? echo only_numbers_and_Comma_input(); ?>   value='' ><img src='/img/down17.png' class='select_control' onClick='show_control(this,2,"+ lastID + ")' title='Выберите сочетание'>";
		tbl.rows[currow].insertCell(3);
		tbl.rows[currow].cells[3].className="table_cell";
		tbl.rows[currow].cells[3].innerHTML = "<input id='lev3_"+ lastID + "' class='table_input' type='text' name='id4[" + lastID + "]' <? echo only_numbers_and_Comma_input(); ?>   value='' ><img src='/img/down17.png' class='select_control' onClick='show_control(this,3,"+ lastID + ")' title='Выберите сочетание'>";
		tbl.rows[currow].insertCell(4);
		tbl.rows[currow].cells[4].className="table_cell";
		tbl.rows[currow].cells[4].innerHTML = "<input id='lev4_"+ lastID + "' class='table_input' type='text' name='id5[" + lastID + "]' <? echo only_numbers_and_Comma_input(); ?>   value='' ><img src='/img/down17.png' class='select_control' onClick='show_control(this,4,"+ lastID + ")' title='Выберите сочетание'>";

		lastID++;
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
				check_and_sabmit();
				is_press_strl = 0;
				return false;
			}
		}
	}

	window.onscroll = function(event) {
// игнорировать если спойлер справочника свернут
if(parseInt(document.getElementById('lib_block_id').style.height)==0)
	return;

		//var posY=document.scrollingElement.scrollTop;
		//	alert(window.pageYOffset);
		if (window.pageYOffset > 70) {
			document.getElementById("lib_block_id").style.position = "fixed";
			document.getElementById("lib_block_id").style.left = "20px";
			document.getElementById("lib_block_id").style.top = "0px";
			document.getElementById("h2_id").style.marginTop = "400px";
		} else {
			document.getElementById("lib_block_id").style.position = "relative";
			document.getElementById("lib_block_id").style.left = "0px";
			document.getElementById("lib_block_id").style.top = "0px";
			document.getElementById("h2_id").style.marginTop = "0px";
		}
	}
	////////////////////////////
	function set_sel(tr, id) {
		//	alert(id);
		var nodes = document.getElementsByClassName('highlighting'); //alert(nodes.length);
		for (var i = 0; i < nodes.length; i++) {
			nodes[i].style.border = "solid 1px #000000";
		}
		tr.style.border = "solid 2px #000000";

		var AJAX = new ajax_form_post_support('form_id', '/pages/reflex_helper.php?id=' + id, sent_info_res);
		AJAX.send_form_reqest();

		function sent_info_res(res) {
			set_help(tr, res);
		}
	}
	////////////////////////////
	function set_help(tr, inf) {
		document.getElementById("helper_id").style.display = "block";
		document.getElementById("helper_id").innerHTML = inf;
	}

	window.onmouseup = function(e) {
		document.getElementById("helper_id").style.display = "none";
		var nodes = document.getElementsByClassName('highlighting'); //alert(nodes.length);
		for (var i = 0; i < nodes.length; i++) {
			nodes[i].style.border = "solid 1px #000000";
		}

	}
	////////////////////////////
	function show_control(img, kind, id) {
		event.stopPropagation();
// alert(kind+" | "+id);
if(kind==2)// более удобный контрол сочетаний контекстов
{
show_contexts_list(id);
return;
}
if(kind==3)// более удобный контрол сочетаний пусковых стимулов
{
show_triggers_list(id);
return;
}
if(kind==4)// более удобный контрол сочетаний действий Beast
{
show_actions_list(id);
return;
}
		var AJAX = new ajax_support("/lib/get_multiselectiong.php?kind=" + kind + "&id=" + id, sent_act_info);
		AJAX.send_reqest();

		function sent_act_info(res) {
			show_dlg_alert2("<br><span style='font-weight:normal;'>Выберите значения:<br>(используйте Ctrl+клик и Shift+клик)<br>" + res + "<br><input type='button' value='Выбрать значения' onClick='set_input_val(" + kind + "," + id + ")'>", 2);
		}
	}
	/////////////////////////////
	function set_input_val(kind, id) {
		var aStr = "";
		var combo = document.getElementById('select_combo');
		var len = combo.options.length;
		for (var n = 0; n < len; n++) {
			if (combo.options[n].selected == true) {
				if (aStr.length > 0)
					aStr += ",";
				aStr += combo.options[n].id;
			}
		}
		//alert(aStr);
		//alert(document.getElementById("lev2_"+id).value);
		switch (kind) {
			case 2:
				document.getElementById("lev2_" + id).value = aStr;
				break;
			case 3:
				document.getElementById("lev3_" + id).value = aStr;
				break;
			case 4:
				document.getElementById("lev4_" + id).value = aStr;
				break;
		}
		end_dlg_alert2();
	}

/////////////////////////////
function show_contexts_list(nid)
{
event.stopPropagation();
var selected=document.getElementById("lev2_" + nid).value;
//show_dlg_alert(nid,0);
event.stopPropagation();
		var AJAX = new ajax_support("/lib/get_context_list.php?nid="+nid+"&selected="+selected, sent_context_info);
		AJAX.send_reqest();

		function sent_context_info(res) {
			show_dlg_alert2("<br><span style='font-weight:normal;'>Выберите сочетание Базовых контекстов:<br>" + res + "<br>", 2);
		}
}
function set_input2_list(nid,list) { // alert(nid+" | "+list);
		//alert(aStr);
		document.getElementById("lev2_" + nid).value = list;
		document.getElementById("lev2_" + nid).style.backgroundColor="#ffffff";
		end_dlg_alert2();
}
///////////////////////////////////////
function show_triggers_list(nid)
{
event.stopPropagation();
var selected=document.getElementById("lev3_" + nid).value;
//show_dlg_alert(nid,0);
event.stopPropagation();
		var AJAX = new ajax_support("/lib/get_triggers_list.php?nid="+nid+"&selected="+selected, sent_triggers_info);
		AJAX.send_reqest();

		function sent_triggers_info(res) {
			show_dlg_alert2("<br><span style='font-weight:normal;'>Выберите сочетание Пусковых стимулов:<br>" + res + "<br>", 2);
		}
}
function set_input3_list(nid,list) { // alert(nid+" | "+list);
		//alert(aStr);
		document.getElementById("lev3_" + nid).value = list;
		document.getElementById("lev3_" + nid).style.backgroundColor="#ffffff";
		end_dlg_alert2();
}
/////////////////////////////////////
function show_actions_list(nid)
{
event.stopPropagation();
var selected=document.getElementById("lev4_" + nid).value;
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
		document.getElementById("lev4_" + nid).value = aStr;

		end_dlg_alert2();
}
////////////////////////////////////////////////////////////////
function sorting(nCol)
{
if(nCol==2)
var link='/pages/reflexes.php?sorting='+nCol;
else
var link='/pages/reflexes.php?sorting=0';
<?if($selected){
echo "link+='&selected=".$selected."';";
}?> 
location.href=link;
}
////////////////////
function set_philter(kind)
{
	if(kind==0)
	{
location.href='/pages/reflexes.php';
return;
	}
var link='/pages/reflexes.php?selected='+kind;
<?if($sorting){
echo "link+='&sorting=".$sorting."';";	
}?>
location.href=link;
}
</script>
</div>
<br><br><br><a href='/pages/reflexes_maker.php' title='Начать набивать рефлексы в зависимости от разных условий.' title='Создание безусловных рефлексов в зависимости от заданных условий без коннекта с Beast.'>Быстрая набивка рефлексов</a><br><br><br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>