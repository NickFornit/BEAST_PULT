<?
/* Редактор гомеостаза
http://go/pages/gomeostaz.php
*/

$page_id = 1;
$title = "Редактор гомеостаза";
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
//include_once($_SERVER['DOCUMENT_ROOT']."/pult_js.php");
// общий движок связи с Ботом
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/linking.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/alert2_dlg.php");

//////////////////////////////////////// САБМИТЫ
//Действия оператора - гомеостатический эффект
if (isset($_POST['gogogo']) && $_POST['gogogo'] == 20) {
	$out = "";
	//var_dump($_POST['ID']);exit();
	$n = 0;
	foreach ($_POST['effect'] as $id => $str) {
		$effect = $_POST['effect'][$id];
		$effect_common = $_POST['effect_common'][$id];

		if ($n) {
			$out .= "\r\n";
		}
		$out .= $id . "|" . $effect . "|" . $effect_common;
		$n++;
	}

	//exit($out);
	write_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/Gomeostaz_pult_actions.txt", $out);

	echo "<form name=\"refresh\" method=\"post\" action=\"/pages/gomeostaz.php#gogogo20\"></form>";
	echo "<script language=\"JavaScript\">document.forms['refresh'].submit();</script>";
	exit();
}

if (isset($_POST['gogogo']) && $_POST['gogogo'] == 11) {
	$out = "";
	$limitOut = "";
	//var_dump($_POST['speed']);exit();
	$n = 0;
	foreach ($_POST['weight'] as $id => $str) {
		if ($n) {
			$out .= "\r\n";
			$limitOut .= "\r\n";
		}
		$out .= $id . "|" . $_POST['weight'][$id] . "|" . $_POST['speed'][$id];
		$limitOut .= $id . "|" . $_POST['limits'][$id];

		$n++;
	}

	//exit($out);
	write_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/GomeostasWeight.txt", $out);
	write_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/GomeostazLimits.txt", $limitOut);

	echo "<form name=\"refresh\" method=\"post\" action=\"/pages/gomeostaz.php\"></form>";
	echo "<script language=\"JavaScript\">document.forms['refresh'].submit();</script>";
	exit();
}

if (isset($_POST['gogogo']) && $_POST['gogogo'] == 12) {
	$out = "";
	//var_dump($_POST['ID']);exit();
	$n = 0;
	foreach ($_POST['weight'] as $id => $str) {
		$weight = $_POST['weight'][$id];

		if ($n) {
			$out .= "\r\n";
		}
		$out .= $id . "|" . $weight;

		$n++;
	}

	//exit($out);
	write_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/base_context_weight.txt", $out);

	echo "<form name=\"refresh\" method=\"post\" action=\"/pages/gomeostaz.php\"></form>";
	echo "<script language=\"JavaScript\">document.forms['refresh'].submit();</script>";
	exit();
}
/*
if (isset($_POST['gogogo']) && $_POST['gogogo'] == 3) {
	$out = "";
	//var_dump($_POST['bad']);exit();
	$n = 0;
	foreach ($_POST['id'] as $id => $str) {
		$out .= $id;
		$out .= "|" . $_POST['bad'][$id];
		$out .= "|" . $_POST['well'][$id];
		$out .= "|" . $_POST['d1'][$id];
		$out .= "|" . $_POST['d2'][$id];
		$out .= "|" . $_POST['d3'][$id];
		$out .= "|" . $_POST['d4'][$id];
		$out .= "|" . $_POST['d5'][$id];
		$out .= "\r\n"; // exit();

		$n++;
	}

	//exit($out);
	write_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/base_context_activnost.txt", $out);

	echo "<form name=\"refresh\" method=\"post\" action=\"/pages/gomeostaz.php#gogogo3\"></form>";
	echo "<script language=\"JavaScript\">document.forms['refresh'].submit();</script>";
	exit();
}

if (isset($_POST['gogogo']) && $_POST['gogogo'] == 4) {
	$out = "";
	//var_dump($_POST['id']);exit();
	$n = 0;
	foreach ($_POST['id'] as $id => $str) {
		$out .= $id;
		$out .= "|" . $_POST['ant'][$id];
		$out .= "\r\n";                       // exit();

		$n++;
	}
	//exit($out);
	write_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/base_context_antagonists.txt", $out);

	echo "<form name=\"refresh\" method=\"post\" action=\"/pages/gomeostaz.php#gogogo4\"></form>";
	echo "<script language=\"JavaScript\">
document.forms['refresh'].submit();</script>";
	exit();
}
*/
echo "<div class='main_page_div' style=''>";

$reflStr = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/dnk_reflexes.txt");
if(strlen($reflStr)>10)
{

echo "<div style='background-color:#FFDADD;padding:10px;
border:solid 1px #8A3CA4;border-radius: 7px;' ><b>ЭТИМ РЕДАКТОРОМ НЕ СЛЕДУЕТ ПОЛЬЗОВАТЬСЯ!</b><br>
Потому, что уже есть рефлексы в http://go/pages/reflexes.php.<br>
При ЛЮБЫХ изменениях будуь нарушены все зависимые структуры, которые следует очистить (в редакторе http://go/pages/reflexes.php нажать на &quot;Удалить рефлексы&quot;) или же очень аккуратно, вручную все скорректировать!<br>
</div>";
}
?>

<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script Language="JavaScript" src="/ajax/ajax_form_post.js"></script>

<div style="position:relative">
<h2 class="header_h2">Жизненные параметры гомеостаза</h2>
<div style="position:absolute;top:0px;right:0px;cursor:pointer;" onClick="open_anotjer_win('gomeostaz_help.htm')"><b>Важные пояснения</b></div>
</div>
Эти параметры – жестко заданы, можно менять только веса их значимости, влияющие на определения общего критического состояния. Даже программно их не следует пытаться менять, они задействованы во многих “наследуемых” предопределенных реакциях.<br>
<span style="color:red;">Для Энергия порог нормы - после заданного значения.</span>

<table class="main_table" cellpadding=0 cellspacing=0 border=1 width='100%'>
	<tr>
		<th class='table_header'>ID</th>
		<th width=150 class='table_header'>Жизненный параметр</th>
		<th class='table_header'>Назначение параметра</th>
		<th width=70 class='table_header'>Вес значимости в %</th>
		<th width=70 class='table_header'>Скорость изменения % в час</th>
		<th width=70 class='table_header' title="С какого процента значения начинается норма параметра. Для Энергия и Повреждения порог нормы - после заданного значения.">Порог нормы в %</th>
	</tr>

	<form name="form2" method="post" action="/pages/gomeostaz.php">
		<?
		$nameArr = array(
			1 => array("Энергия", "Уменьшается со временем и расходовании."),
			2 => array("Стресс", "Накапливается в течении дня и снимается во время сна. Увеличивается при стрессовых ситуациях."),
			3 => array("Гон", "Жизненный параметр данного вида. Постепенно нарастает и требует разрядки."),
			4 => array("Потребность в общении", "Жизненный параметр данного вида. Постепенно нарастает и требует разрядки."),
			5 => array("Потребность в обучении", "Зависит от ситуации, но нарастает пока не будет разрядки."),
			6 => array("Поиск", "Основа поискового поведения. Зависит от ситуации, но нарастает в депривации."),
			7 => array("Самосохранение", "Жадность, эгоизм, самозащита, страх смерти. Зависит от ситуации, может сам уменьшаться при благополучии."),
			8 => array("Повреждения", "Параметр общего состояния организма. Повреждения нарастают со временем.")

		);
		// считать файлы

		$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/GomeostazLimits.txt");
		$strArr = explode("\r\n", $progs);
		$limits = array();
		foreach ($strArr as $s) {
			$p = explode("|", $s);
			$limits[$p[0]] = $p[1];
		}
		$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/GomeostasWeight.txt");
		$strArr = explode("\r\n", $progs);
		foreach ($strArr as $str) {
			$par = explode("|", $str);
			$id = $par[0];
			echo "
<tr>
<td class='table_cell' style='width:40px;'>" . $par[0] . "</td>
<td class='table_cell'><b>" . str_replace(" ", "&nbsp;", $nameArr[$par[0]][0]) . "</b></td>
<td class='table_cell' style='font-size:12px;'>" . $nameArr[$par[0]][1] . "</td>
<td class='table_cell'><input class='table_input' type='text' name='weight[" . $id . "]' " . only_numbers_input() . "  value='" . $par[1] . "'  ></td>
<td class='table_cell'><input class='table_input' type='text' name='speed[" . $id . "]' " . only_numbers_input() . "  value='" . $par[2] . "'  ></td>
<td class='table_cell'><input class='table_input' type='text' name='limits[" . $id . "]' " . only_numbers_input() . "  value='" . $limits[$id] . "'  ></td>
</tr>";
		}
		?>
</table>
<input type='hidden' name='gogogo' value='11'>
<input type="submit" name="submit" value="Сохранить">
</form>

<h2 class="header_h2" style="margin-top:20px;">Базовые стили поведения (базовые контексты рефлексов)</h2>
Эти параметры – жестко заданы, можно менять только веса их значимости, влияющие на взаимную конкурентность стилей поведения. Даже программно их не следует пытаться менять, они задействованы во многих “наследуемых” предопределенных реакциях.<br>
<table class="main_table" cellpadding=0 cellspacing=0 border=1 width='100%'>
	<tr>
		<th class='table_header'>ID</th>
		<th width=150 class='table_header'>Базовый контекст</th>
		<th class='table_header'>Назначение контекста</th>
		<th width=70 class='table_header'>Вес значимости в %</th>
	</tr>

	<form name="form" method="post" action="/pages/gomeostaz.php">
		<?
		include_once($_SERVER['DOCUMENT_ROOT'] . "/lib/base_context_list.php");
		$nameArr = $baseContextArr;

		// считать файл 
		$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/base_context_weight.txt");
		$strArr = explode("\r\n", $progs);
		foreach ($strArr as $str) {
			$par = explode("|", $str);
			echo "<tr>
<td class='table_cell' style='width:40px;'>" . $par[0] . "</td>
<td class='table_cell'><b>" . str_replace(" ", "&nbsp;", $nameArr[$par[0]][0]) . "</b></td>
<td class='table_cell' style='font-size:12px;'>" . $nameArr[$par[0]][1] . "</td>
<td class='table_cell'><input class='table_input' type='text' name='weight[" . $par[0] . "]' " . only_numbers_input() . "  value='" . $par[1] . "'  ></td>
</tr>";
		}
		?>
</table>
<input type='hidden' name='gogogo' value='12'>
<input type="submit" name="submit" value="Сохранить">
</form>
<br><br>

<a name="gogogo4"></a>
<? // АНТАГОНИСТЫ
// считать файл со строками  ID|7,5,12
$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/base_context_antagonists.txt");
$strArr = explode("\r\n", $progs);  //exit("$progs");
$iArr = array();
foreach ($strArr as $str) {
	$par = explode("|", $str);
	$id = $par[0];
	$iArr[$id] = $par[1];
}
//var_dump($iArr);exit();





//////////////////// активность контекстов
?>
<div style="background-color:#E1EEFF;">
<span style='font-size:16px;color:red'>Эти 2 таблицы НЕЛЬЗЯ редактировать после того, как начали заполнять таблицу рефлексов!</span>
<div style="position:relative">
	<h2 class="header_h2" style="margin-top:0px;">Несовместимость активностей Базовых стилей:</h2>
	<div style="position:absolute;top:0px;right:0px;cursor:pointer;" onClick="open_anotjer_win('active_contextx.htm')"><b>Важные пояснения</b></div>
</div>
Для каждого из Базовых стилей нужно задать строку с перечислением (через запятую) ID тех стилей, которые с ним не совместимы.</span>
<form id="form4" name="form4" method="post" action="/pages/gomeostaz.php">
	<table class="main_table" cellpadding=0 cellspacing=0 border=1 width='100%'>
		<tr>
			<th width=200 class='table_header'>Параметр</th>
			<th class='table_header'>Строка ID антагонистов (через запятую)</th>
			<th width=200 class='table_header'>Параметр</th>
			<th class='table_header'>Строка ID антагонистов (через запятую)</th>
		</tr>
		<?
		$name = "";
		for ($n = 1; $n < 13; $n++) {
			switch ($n) {
				case 1:
					$name = "Пищевой";
					break;
				case 2:
					$name = "Поиск";
					break;
				case 3:
					$name = "Игра";
					break;
				case 4:
					$name = "Гон";
					break;
				case 5:
					$name = "Защита";
					break;
				case 6:
					$name = "Лень";
					break;
				case 7:
					$name = "Ступор";
					break;
				case 8:
					$name = "Страх";
					break;
				case 9:
					$name = "Агрессия";
					break;
				case 10:
					$name = "Злость";
					break;
				case 11:
					$name = "Доброта";
					break;
				case 12:
					$name = "Сон";
					break;
			}
			if (($n - 1) % 2 == 0) {
				echo "<tr>
<td class='table_cell' >" . $n . "." . $name . "<input type='hidden' name='id[" . $n . "]' value='" . $n . "' ></td>
<td class='table_cell'><input id='col_ant_" . $n . "' class='table_input' type='text' name='ant[" . $n . "]' " . only_int_inp() . "  value='" . $iArr[$n] . "' ><img src='/img/down17.png' class='select_control' onClick='show_control_ant(this," . $n . ")' title='Выбор значений'></td>";
			} else {
				echo "<td class='table_cell' >" . $n . "." . $name . "<input type='hidden' name='id[" . $n . "]' value='" . $n . "' ></td>
<td class='table_cell'><input id='col_ant_" . $n . "' class='table_input' type='text' name='ant[" . $n . "]' " . only_int_inp() . "  value='" . $iArr[$n] . "' ><img src='/img/down17.png' class='select_control' onClick='show_control_ant(this," . $n . ")' title='Выбор значений'></td>
</tr>";
			}
		}
		?>
	</table>
	<input type='hidden' name='gogogo' value='4'>
	<input type="button" name="submit4" value="Сохранить" onClick="save_date()">
	<div id="korrect_kontext_1" style="display:inline-block;bottom:0px;right:0px;padding:4px;color:red;"></div>
</form>
<br>

<a name="gogogo3"></a>
Активность Базовых стилей поведения зависит от сочетания Базовых параметров гомеостаза в одном из 7 своих состояний (по заголовкам таблицы), причем состояние "Возврат в норму" зависит от предыдущего состояния "Выход из нормы" и не является диапазоном значений параметра гомеостаза. <span style="color:red;">Это определяет основы поведения Best и к редактированию нужно относиться <b>с особой осторожностью</b>.</span>
<div style="position:relative">
	<h2 class="header_h2" style="margin-top:0px;">Активности Базовых стилей (из более 3-х стилей в сочетании гасятся самые слабые по весу):</h2>
	<div style="position:absolute;top:0px;right:0px;cursor:pointer;" onClick="open_anotjer_win('active_contextx.htm')"><b>Важные пояснения</b></div>
</div>
Чтобы погасить ID стиля, нужно перед ним поставить знак "-", например: "4,-3" означает, что стиль с ID=3 будет погашен. При этом действуют установки таблицы: "Несовместимость активностей Базовых стилей".<br>

<?
// считать файл со строками  ID|bad|1|2|3|4|5
$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/base_context_activnost.txt");
$strArr = explode("\r\n", $progs);  //exit("$progs");
$iArr = array();

foreach ($strArr as $str) {
	$par = explode("|", $str);
	$id = $par[0];
	$iArr[$id][0] = $par[1];
	$iArr[$id][1] = $par[2];
	$iArr[$id][2] = $par[3];
	$iArr[$id][3] = $par[4];
	$iArr[$id][4] = $par[5];
	$iArr[$id][5] = $par[6];
	$iArr[$id][6] = $par[7];
}

?>
<form id="form3" name="form3" method="post" action="/pages/gomeostaz.php">
	<table class="main_table" cellpadding=0 cellspacing=0 border=1 width='100%'>
		<tr>
			<th width=170 class='table_header'>Параметр</th>
			<th class='table_header'>Выход из нормы</th>
			<th class='table_header'>Возврат в норму</th>
			<th class='table_header'>Норма 0-19%</th>
			<th class='table_header'>Норма 20-39%</th>
			<th class='table_header'>Норма 40-59%</th>
			<th class='table_header'>Норма 60-79%</th>
			<th class='table_header'>Норма 80-100%</th>
		</tr>
		<?
		for ($n = 1; $n < 9; $n++) {
			$name = "";
			switch ($n) {
				case 1:
					$name = "Энергия";
					break;
				case 2:
					$name = "Стресс";
					break;
				case 3:
					$name = "Гон";
					break;
				case 4:
					$name = "Потребность в общении";
					break;
				case 5:
					$name = "Потребность в обучении";
					break;
				case 6:
					$name = "Поиск";
					break;
				case 7:
					$name = "Самосохранение";
					break;
				case 8:
					$name = "Повреждения";
					break;
			}
			echo "<tr>
<td class='table_cell' >" . $name . "<input type='hidden' name='id[" . $n . "]' value='" . $n . "' ></td>
<td class='table_cell'><input id='col_1_" . $n . "' class='table_input' type='text' name='bad[" . $n . "]' " . only_int_inp() . "  value='" . $iArr[$n][0] . "' ><img src='/img/down17.png' class='select_control' onClick='show_control(this,1," . $n . ")' title='Выбор значений'></td>
<td class='table_cell'><input id='col_2_" . $n . "' class='table_input' type='text' name='well[" . $n . "]' " . only_int_inp() . "  value='" . $iArr[$n][1] . "' ><img src='/img/down17.png' class='select_control' onClick='show_control(this,2," . $n . ")' title='Выбор значений'></td>
<td class='table_cell'><input id='col_3_" . $n . "' class='table_input' type='text' name='d1[" . $n . "]' " . only_int_inp() . "  value='" . $iArr[$n][2] . "' ><img src='/img/down17.png' class='select_control' onClick='show_control(this,3," . $n . ")' title='Выбор значений'></td>
<td class='table_cell'><input id='col_4_" . $n . "' class='table_input' type='text' name='d2[" . $n . "]' " . only_int_inp() . "  value='" . $iArr[$n][3] . "' ><img src='/img/down17.png' class='select_control' onClick='show_control(this,4," . $n . ")' title='Выбор значений'></td>
<td class='table_cell'><input id='col_5_" . $n . "' class='table_input' type='text' name='d3[" . $n . "]' " . only_int_inp() . "  value='" . $iArr[$n][4] . "' ><img src='/img/down17.png' class='select_control' onClick='show_control(this,5," . $n . ")' title='Выбор значений'></td>
<td class='table_cell'><input  id='col_6_" . $n . "' class='table_input' type='text' name='d4[" . $n . "]' " . only_int_inp() . "  value='" . $iArr[$n][5] . "' ><img src='/img/down17.png' class='select_control' onClick='show_control(this,6," . $n . ")' title='Выбор значений'></td>
<td class='table_cell'><input  id='col_7_" . $n . "' class='table_input' type='text' name='d5[" . $n . "]' " . only_int_inp() . "  value='" . $iArr[$n][6] . "' ><img src='/img/down17.png' class='select_control' onClick='show_control(this,7," . $n . ")' title='Выбор значений'></td>
</tr>";
		}
		?>
	</table>
	<input type='hidden' name='gogogo' value='3'>
	<input type="button" name="submit3" value="Сохранить" onClick="save_date()">
	<div id="korrect_kontext_2" style="display:inline-block;bottom:0px;right:0px;padding:4px;color:red;"></div>
</form>

</div>
<?
//////////////////// КОНЕЦ активность контекстов




?>

<a name="gogogo20"></a>
<h2 class="header_h2" style="margin-top:20px;">Действия оператора - гомеостатический эффект</h2>
Кнопки дейставий жестко заданы, можно менять только эффект изменения гомеостатических параметров при их нажатии.<br>
В столбце действий нужно писать ID параметра гомеостаза, который будет изменен, символ ">" и оказываемое действие в % (+/-). Эффекты разделяются через запятую.<br>
В столбце Эффект 5 пульсов нужно проставить + (позитивный эффект) или - (негативный эффект). Здесь имеются в виду не Базовые состояния (Плохо или Хорошо) а (де)мотивирующее настроение в ответ на действия Beast.

<form id="form5" name="form5" method="post" action="/pages/gomeostaz.php">
	<table class="main_table" cellpadding=0 cellspacing=0 border=1 width='100%'>
		<tr>
			<th class='table_header'>ID</th>
			<th width=150 class='table_header'>Название действия</th>
			<th class='table_header'>Суть действия по данной кнопке </th>
			<th width=250 class='table_header'>Воздействия:<br>gomeo1ID>%,gomeo2ID>%,...</th>
			<th width=60 class='table_header' title='Позитивный или негативный'>Эффект</th>
		</tr>
		<?
		include_once($_SERVER['DOCUMENT_ROOT'] . "/lib/actions_from_pult.php");

		$nameArr = $actionsFromPultArr;

		// считать файл 
		$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/Gomeostaz_pult_actions.txt");
		$strArr = explode("\r\n", $progs);
		foreach ($strArr as $str) {
			$par = explode("|", $str);
			$id = $par[0];
			echo "<tr>
<td class='table_cell'style='width:40px;' >" . $id . "<input type='hidden' name='id[" . $id . "]' value='" . $id . "' ></td>
<td class='table_cell'><b>" . str_replace(" ", "&nbsp;", $nameArr[$id][0]) . "</b></td>
<td class='table_cell' style='font-size:12px;'>" . $nameArr[$id][1] . "</td>";
			if ($id == 5)
				echo "<td class='table_cell'>На кнопке есть выбор.<input type='hidden' name='effect[" . $id . "]' value=''></td>";
			else
				echo "<td class='table_cell'><input class='table_input' type='text' name='effect[" . $id . "]' " . only_allow_inp() . "  value='" . $par[1] . "'  ></td>";

			echo "<td class='table_cell'><input class='table_input' type='text' name='effect_common[" . $id . "]' " . only_allow_inp2() . "  value='" . $par[2] . "'  ></td>";

			echo "</tr>";
		}
		?>
	</table>
	<input type='hidden' name='gogogo' value='20'>
	<input type="button" name="submit5" value="Сохранить" onClick="sent_korrect_kontext(3,'form5')">
	<div id="korrect_kontext_3" style="display:inline-block;bottom:0px;right:0px;padding:4px;color:red;"></div>
</form>
<br><br>

<?
function only_allow_inp()
{
	// СТРОГО В ОДНУ СТРОКУ!
	$out = <<<EOD
onKeyDown='only_allow_inp(this)' onKeyUp='only_allow_inp(this)' onMouseUp='only_allow_inp(this)'
EOD;
	return $out;
}
function only_allow_inp2()
{
	// СТРОГО В ОДНУ СТРОКУ!
	$out = <<<EOD
onKeyDown='only_allow_inp2(this)' onKeyUp='only_allow_inp2(this)' onMouseUp='only_allow_inp2(this)'
EOD;
	return $out;
}
?>
<script>
	//function sent_korrect_kontext_(val){
	//	bot_contact_get("korrekt_sprw="+val,text_res_korrekt);
	//	function text_res_korrekt(res){
	//		document.getElementById('korrect_kontext_'+val).innerHTML=res;
	//		if(res=="Ошибок не обнаружено")
	//			document.getElementById('korrect_kontext_'+val).style.color='green';
	//		else
	//			document.getElementById('korrect_kontext_'+val).style.color='red';
	//	}
	//}

	function only_allow_inp(inp) {
		var val = inp.value;
		inp.value = val.replace(/[^0-9,\-\>]/g, '');
	}

	function only_allow_inp2(inp) {
		var val = inp.value;
		inp.value = val.replace(/[^\-\+]/g, '');
		inp.value = inp.value.substr(0, 1);
	}

	function show_control(img, columnN, id) {
		event.stopPropagation();
		var AJAX = new ajax_support("/pages/gomeostaz_get_multiselectiongs.php?columnN=" + columnN + "&id=" + id, sent_act_info);
		AJAX.send_reqest();

		function sent_act_info(res) {
			show_dlg_alert2("<br><span style='font-weight:normal;'>Выберите значения:<br>(используйте Ctrl+клик и Shift+клик)<br>" + res + "<br><input type='button' value='Выбрать значения' onClick='set_input_val(" + columnN + "," + id + ")'>", 2);
		}
	}

	function set_input_val(columnN, id) {
		var aStr = "";
		var combo = document.getElementById('select_activ');
		var len = combo.options.length;
		for (var n = 0; n < len; n++) {
			if (combo.options[n].selected == true) {
				if (aStr.length > 0)
					aStr += ",";
				aStr += combo.options[n].id;
			}
		}
		var combo = document.getElementById('select_passive');
		var len = combo.options.length;
		for (var n = 0; n < len; n++) {
			if (combo.options[n].selected == true) {
				if (aStr.length > 0)
					aStr += ",";
				aStr += "-" + combo.options[n].id;
			}
		}
		//alert("col_"+columnN+"_"+id);
		document.getElementById("col_" + columnN + "_" + id).value = aStr;

		end_dlg_alert2();
	}

	function show_control_ant(img, id) {
		event.stopPropagation();
		var AJAX = new ajax_support("/pages/gomeostaz_get_multiselectiongs_ant.php?id=" + id, sent_act_info);
		AJAX.send_reqest();

		function sent_act_info(res) {
			show_dlg_alert2("<br><span style='font-weight:normal;'>Выберите значения:<br>(используйте Ctrl+клик и Shift+клик)<br>" + res + "<br><input type='button' value='Выбрать значения' onClick='set_input_ant_val(" + id + ")'>", 2);
		}
	}

	function set_input_ant_val(id) {
		var aStr = "";
		var combo = document.getElementById('select_antagonist');
		var len = combo.options.length;
		for (var n = 0; n < len; n++) {
			if (combo.options[n].selected == true) {
				if (aStr.length > 0)
					aStr += ",";
				aStr += combo.options[n].id;
			}
		}
		//alert(aStr);
		document.getElementById("col_ant_" + id).value = aStr;
		//alert(document.getElementById("col_ant_"+id).value);

		end_dlg_alert2();
	}

	function sent_korrect_kontext(id, form_id) {
		var AJAX = new ajax_form_post_support(form_id, '/pages/correct_fill_spraw_' + id + '.php', sent_request_res);
		AJAX.send_form_reqest();

		function sent_request_res(res) { 
//alert(id+" | "+res);
			if (res == "*") {	
				document.forms.form5.submit();
			} 
			else
			{
				document.getElementById('korrect_kontext_' + id).innerHTML = res;
				show_dlg_alert("Ошибка показана красным.", 2000);
			}
		}
	}
//////////////////////////////////////////////
/* save_date() записывает содержимое обоих таблиц (для активности контекстов) без проверки, как есть.
Проверка осуществляется только при нажатии Сохранить под каждой из таблиц.
Это позволяет вносить измнения в обе таблицы по результатам проверки 
с окончательным сохранениям по кнопкам Сохранить.
*/
function save_date()
{
show_dlg_confirm("При изменении этих таблиц<br><span style='color:red'>необходимо будет изменить списки сочетаний контекстов</span><br>которые пока что делаются вручную<br>в папке /pages/combinations/.","ДА, сохранить изменения.","Отмена сохранения",save_date2);
//show_dlg_confirm("Уверены?","да","нет",save_date2);
}
function save_date2()
{
// проверка первой таблицы
var AJAX = new ajax_form_post_support("form4", '/pages/correct_fill_spraw_1.php', sent_request4_res);
AJAX.send_form_reqest();
function sent_request4_res(res)
{
if (res != "*")
	{
document.getElementById('korrect_kontext_1').innerHTML = res;
show_dlg_alert("Ошибка показана красным.", 2000);
return;
	}
// запись первой таблицы
var AJAX = new ajax_form_post_support("form4", '/pages/gomeostaz_saver.php', sent_save4_res);
AJAX.send_form_reqest();
function sent_save4_res(res)
{
// проверка второй таблицы
var AJAX = new ajax_form_post_support("form3", '/pages/correct_fill_spraw_2.php', sent_request3_res);
AJAX.send_form_reqest();
function sent_request3_res(res)
{
if (res != "*")
	{
document.getElementById('korrect_kontext_2').innerHTML = res;
show_dlg_alert("Ошибка показана красным.", 2000);
return;
	}
// запись второй таблицы
var AJAX = new ajax_form_post_support("form3", '/pages/gomeostaz_saver.php', sent_save3_res);
AJAX.send_form_reqest();
function sent_save3_res(res)
{
show_dlg_alert("Сохранено.",1500);
document.getElementById('korrect_kontext_1').innerHTML ="";
document.getElementById('korrect_kontext_2').innerHTML ="";
}
}
}
}
}
</script>