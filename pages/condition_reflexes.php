<?
/*   Условные рефлексы
http://go/pages/condition_reflexes.php  

Формат записи:
ID|lev1|lev2 через ,|lev3 типа lev3TriggerStimulsID|ActionIDarr через ,|rank|lastActivation|activationTime
*/

$page_id = 5;
$title = "Условные рефлексы Beast";
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/show_waiting.php");

$out_str_for_del = ""
?>
<form name="refresh" method="post" action="/pages/condition_reflexes.php"></form>
<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
	var linking_address = '<? include($_SERVER["DOCUMENT_ROOT"] . "/common/linking_address.txt"); ?>';
	//alert(linking_address);
	function end_deleting(out) {
		show_dlg_alert("Beast выключается...", 2000);
		var AJAX = new ajax_support(linking_address + "?bot_closing=1", sent_info);
		AJAX.send_reqest();

		function sent_info(res) {
			// не будет ответа
		}
		//alert(out);
		setTimeout("delete_end('" + out + "')", 2000);
	}

	function delete_end(out) { //alert(out);
		var AJAX = new ajax_support("/pages/condition_reflexes_server.php?out=" + out, sent_end_info);
		AJAX.send_reqest();

		function sent_end_info(res) {
			//	alert(res);
			document.forms['refresh'].submit();
		}
	}
</script>
<?

// удаление рефлексов
if (isset($_POST['rdelID'])) {
	$delArr = explode("|", $_POST['rdelID']);
	$dArr = array();
	foreach ($delArr as $s) {
		if (empty($s)) {
			continue;
		}
		array_push($dArr, substr($s, 6));  //var_dump($dArr);exit();

	}
	$dCount = count($dArr);

	$str = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/condition_reflexes.txt");
	$list = explode("\r\n", $str);  //exit("! $str | ".$_GET['delete_id']);
	$out = "";
	$isDeleted = 0;
	foreach ($list as $s) {
		if (empty($s)) {
			continue;
		}
		$r = explode("|", $s);
		$id = $r[0];
		$isDeleting = 0;
		for ($n = 0; $n < $dCount; $n++) {
			if ($id == $dArr[$n]) {
				$isDeleting = 1;
				break;
			}
		}
		if (!$isDeleting) {
			$out .= $s . "|"; // exit($out);
		}
	}
	//exit(": ".$out);
	// !!! удалять нужно после выключения Beast т.к. там запоминаются файлы при выходе
	write_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/condition_reflexes.txt", $out);
	//exit(": ".$out);
	echo "<script>";
	// вырубить Beast и записать рефлексы после этого
	echo "show_dlg_alert('Выбранные рефлексы удалябтся.<br>Beast выключается.',1500);
		setTimeout(`end_deleting('" . $out . "');`,2000);";

	echo "</script>";
	exit();
}
?>

<div style='position:absolute;top:40px;left:360px;font-size:16px;cursor:pointer;color:#7E58FF;' onClick="open_anotjer_win('/pages/condition_reflexes_basic_phrases.php')" title="Создание базы простейщих фраз для заливки базы условных рефлексов."><b>Набить базовые фразы</b></div>

<div style='position:absolute;top:40px;right:360px;font-size:16px;cursor:pointer;color:#7E58FF;background-color:#eeeeee;padding-left:4px;padding-right:4px;border:solid 1px #8A3CA4;border-radius: 7px;' onClick="open_anotjer_win('/pages/condition_reflexes_basic_phrases_maker.php')" title="Сформировать условные рефлексы на основе списка фраз-синонимов.
ПОСЛЕ ПОЛНОЙ ГОТОВНОСТИ ФРАЗ-СИНОНИМОВ!"><b>Сформировать условные рефлексы</b></div>

<div style='position:absolute;top:40px;right:200px;font-family:courier;font-size:16px;cursor:pointer;' onClick="open_anotjer_win('/pages/condition_reflexes.htm')"><b>Пояснения</b></div>

<div style='position:absolute;top:40px;right:100px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_info()"><b>Обновить</b></div>



<div id='div_id' style='font-family:courier;font-size:16px;'>Нужен коннект с Beast.</div>
</div>

Рефлексы можно только удалить, после чего нужно перезапустить Beast. Чтобы создался новый рефлекс нужно не менее 3-х раз повторить воздействие пусковых стимулов, не обязательно подряд, - этим предотвращаются случайные, мусорные сочетания.
Для формирования условных рефлексов нужно потратить немало времени (в случае ребенка около года). Это - период взаимодействия с Beast любым образом, с разными сочетаниями действий и очень простых фраз <b>в различных состояниях его Базовых параметров</b> (для этой стадии развития можно устанавливать слайдерами Пульта).
Чем дольше этот период, тем более эффективные навыки получит Beast.

<div id='reflex_info_id' style='font-family:courier;font-size:16px;'></div>
<div style="position:relative;">
<input id="del_btn_id" type="button" value="Удалить выбранные рефлексы" style="position:absolute;top:0;right:5px;display:none;" onclick='delete_reflexes()'></div>

<form id="form_del" name="form_del" method="post" action="/pages/condition_reflexes.php">
	<input type="hidden" name="rdelID" value="">
</form>

<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
	var linking_address = '<? include($_SERVER["DOCUMENT_ROOT"] . "/common/linking_address.txt"); ?>';
	var old_size = 0;

	function get_info() {
		wait_begin();
		var AJAX = new ajax_support(linking_address + "?get_condition_reflex_info=1", sent_get_info);
		AJAX.send_reqest();

		function sent_get_info(res) {
			//alert(res);
			wait_end();
			document.getElementById('reflex_info_id').innerHTML = res;
			document.getElementById('del_btn_id').style.display = "block";
		}
	}
	get_info();

	function delete_reflexes(id) {
		show_dlg_confirm("Точно удалить?", "Да", "Нет", delete_reflexes2);
	}

	function delete_reflexes2() {
		var del_str = "";
		var nodes = document.getElementsByClassName('deleteCHBX'); //alert(nodes.length);
		for (var i = 0; i < nodes.length; i++) {
			if (nodes[i].checked) {
				del_str += nodes[i].id + "|";
			}
		}
		if (del_str.length == 0) {
			show_dlg_alert("Не выбраны рефлексы для удаления.", 0);
			return;
		}
		document.forms.form_del.rdelID.value = del_str;
		document.forms.form_del.submit();
	}
</script>

</body>
</html>