<?
/*  задатчики жизненных параметров
include_once($_SERVER["DOCUMENT_ROOT"]."/pult_gomeo.php");

При стадии развития 
if ($stages > 4) {
	$slider_block = "disabled";  - не давать рулить оператору
*/

$progs = read_file($_SERVER["DOCUMENT_ROOT"] . "/memory_reflex/GomeostazLimits.txt");
$strArr = explode("\r\n", $progs);
$limits = array();
foreach ($strArr as $s) {
	$p = explode("|", $s);
	$limits[$p[0]] = $p[1];
}
//var_dump($limits);exit();
function set_porog1($limit)  // set_porog1($limits[1])
{
	$w_norm = 100 - $limit;
	echo '<div class="slider_bad" style="left:0%;width:' . $limit . '%;" >&nbsp;</div>
<div class="slider_norm" style="left:' . $limit . '%;width:' . $w_norm . '%;" >
<span class="slider_shkala" style="left:20%">|</span>
<span class="slider_shkala" style="left:40%">|</span>
<span class="slider_shkala" style="left:60%">|</span>
<span class="slider_shkala" style="left:80%">|</span>
</div>';
}
function set_porog2($limit)
{
	$w_norm = 100 - $limit;
	echo '<div class="slider_bad" style="left:' . $limit . '%;width:' . $w_norm . '%;" >&nbsp;</div>
<div class="slider_norm" style="left:0%;width:' . $limit . '%;" >
<span class="slider_shkala" style="left:20%">|</span>
<span class="slider_shkala" style="left:40%">|</span>
<span class="slider_shkala" style="left:60%">|</span>
<span class="slider_shkala" style="left:80%">|</span>
</div>';
}

$slider_block = "";
if ($stages > 4) {
	$slider_block = "disabled";
}

function slider($id, $name, $title1, $title2, $title3)
{
	global $limits, $slider_block;
	echo <<<EOD
<div id='status_$id' class='status' style='position:absolute;top:4px;left:4px;'  title='$title1'></div>
<span title="$title2"><b>$name</b><div id="gpar_$id" style="position:absolute;top:0px;right:0px;font-weight:bold;color:blue;"></div>
</div> 
<div class="slider_wrapper">
<input id="slider_$id" type="range" class="slider" min="0" max="100" step="1" value="0"  title="$title3"  onChange="setting_gomeo_par(this,$id)" onmousemove="slider_val(this,$id);" onmouseOut="slider_out()" $slider_block >
EOD;
	if ($id == 1)
		echo set_porog1($limits[$id]);
	else
		echo set_porog2($limits[$id]);
	echo "</div>";
}
?>

<b>Управление жизненными параметрами</b>
<?
if(stages_dev <5){
echo '<span style="color:red;cursor:pointer;padding-left:2px;padding-right:2px;border:solid 1px #8A3CA4;border-radius:50%;background-color:#ffffff" title="Сбросить все жизненные параметры в 0" onClick="cliner_gomeo_pars(this)"><b>X</b></span> &nbsp;&nbsp;&nbsp;&nbsp;';
}
?>
- не использовать в качестве ответа на действия Beast:<br>
<table border=0 cellpadding=0 cellspacing=4 width='100%'>
	<tr>
		<td class="slider_td" title="" valign="top">
			<? slider(1, "Энергия", "",  "Уменьшается со временем и расходовании", "Задать запас энергии"); ?>
		</td>

		<td class="slider_td" title="">
			<? slider(2, "Уровень стресса", "",  "Накапливается в течении дня и снимается во время сна. Увеличивается при стрессовых ситуациях", "Задать уровень стресса"); ?>
		</td>
		<td class="slider_td" title="">
			<? slider(3, "Уровень гона", "",  "Жизненный параметр данного вида. Постепенно нарастает и требует разрядки", "Задать уровень гона"); ?>
		</td>
		<td class="slider_td" title="">
			<? slider(4, "Потребность в общении", "",  "Жизненный параметр данного вида. Постепенно нарастает и требует разрядки", "Задать уровень потребности в общении"); ?>
		</td>
	</tr>
	<tr>
		<td class="slider_td" title="Beast не экспериментирует в этом контексте!">
			<? slider(5, "Потребность в обучении", "", "Зависит от ситуации, но нарастает пока не будет разрядки", "Задать уровень потребности в обучении"); ?>
		</td>
		<td class="slider_td" title="Beast начнает часто экспериментировать (10 сек от последней активности Пульта)">
			<? slider(6, "Любопытство", "",  "Основа поискового поведения. Зависит от ситуации, но нарастает в депривации", "Задать уровень любопытва"); ?>
		</td>
		<td class="slider_td" title="">
			<? slider(7, "Самосохранение",  "", "Жадность, эгоизм, самозащита, страх. Зависит от ситуации, может сам уменьшаться при благополучии.", "Задать жадность"); ?>
		</td>
		<td class="slider_td" title="">
			<? slider(8, "Повреждения", "",  "Параметр общего состояния организма. Повреждения нарастают со временем.", "Задать уровень повреждений"); ?>
		</td>
	</tr>
</table>

<script>
// текущие условия в виде "3|2,5,8|11" - базовое|сочетание контекстов|пусковые стимулы
var current_condition="";
var current_basik="";
var current_contexts="";
var current_triggers="";
var ful_condition_str="";

	//get_cut_bot_params();// начать опрос состояния Beast раз в 2 сек
	var consol_win_id = 0;
	var slider_timerId = 0;

	function slider_val(slider, n) {
		clearTimeout(slider_timerId);
		not_allow_get_gomeo = 1; // 1-блокировка изменений при установки новых значений
		document.getElementById('gpar_' + n).innerHTML = slider.value;
	}

	function slider_out() {
		slider_timerId = setTimeout("slider_out2()", 1000);
	}

	function slider_out2() {
		not_allow_get_gomeo = 0; // снять блокировку изменений при установки новых значений
	}
	/////////////////
	function set_active_td(id, set) {
		if (set == '1')
			document.getElementById(id).style.boxShadow = "0px 0px 4px 4px #69FF66";
		else
			document.getElementById(id).style.boxShadow = "0px 0px 0px 0px #ffffff";
	}
	/////////////////
	var new_gomeo_par_id = 0;
	var cur_gomeo_val = 0;

	function setting_gomeo_par(slider, id) {
		//alert(id);
		//not_allow_get_gomeo=0; 
		new_gomeo_par_id = id;
		cur_gomeo_val = slider.value;
		//slider_val(slider,id)
	}

////////////////////////  sent_get_params(res)  //////////////////////////
var old_period_val=0;
function sent_get_params(res) {  //  alert("!!!!!!!!!!!! 111111");
		if (res == "!!!") // Смерть beast
		{
			//alert(res);
			is_Beast_Death();
			return;
		}

		// готовность к новому запросу после ответа Beast
		after_answer_server();

		// при нормальной отправке активности с Пульта - котороткое сообще, чтобы видно было что сработало.
		//alert(res);
		var p = res.split("#|#"); // 

		// состояние гомеостаза
		var pars = p[0].split("|"); //alert(pars);
		//document.getElementById('bot_params').innerHTML="Запас энергии: <b>"+pars[0]+"%</b> Уровень стресса <b>"+pars[1]+"%</b> Уровень гона <b>"+pars[2]+"%</b> Пртребность в общении <b>"+pars[3]+"%</b> Пртребность в обучении <b>"+pars[4]+"%</b>";
		for (i = 0; i < pars.length; i++) {
			if (pars[i].length == 0)
				continue;
			var g = pars[i].split(";"); //alert(pars[i]);
			var id = g[0];
			var val = g[1]; //alert(id+" | "+val);
			document.getElementById('slider_' + id).value = val; //alert(document.getElementById('slider_1').value);
			document.getElementById('gpar_' + id).innerHTML = val;

			if (id == 8) {
				check_dander_warn_event(val);
			}
		}

		// статусы параметров
		var pars = p[1].split("|");
		for (i = 0; i < pars.length; i++) {
			if (pars[i].length == 0)
				continue;
			var g = pars[i].split(";"); //alert(pars[i]);
			var id = g[0];
			var val = g[1]; // if(id==1) alert(id+" | "+val);
			var color = "#CCFF66";
			var color2 = "#CCFFC1";
			var title = "Жизненные параметры в норме.";
			valueS="Норма"
			if (val == 1) {
				color = "#FFD3EB";
				color2 = "red";
				title = "Жизненные параметры ВЫШЛИ ИЗ НОРМЫ";
				valueS="Плохо"
			} else
			if (val == 3) {
				color = "#CCFFC1";
				color2 = "green";
				title = "Жизненные параметры вернулись в норму.";
				valueS="Хорошо"
			}

			if (id == 0) // общее состояние
			{
				if (valueS == "Хорошо")
					document.body.style.backgroundColor = "#DDEBFF";
				if (valueS == "Плохо")
					document.body.style.backgroundColor = "#FFE4E1";

				document.getElementById('common_status_id').style.backgroundColor = color;
				document.getElementById('common_status_id').innerHTML = valueS; //alert(title);
				document.getElementById('common_status_id').title=title;
				continue;
			}
			//if(id==1) alert(id+" | "+val+" | "+color);
			document.getElementById('status_' + id).style.backgroundColor = color2;
			document.getElementById('status_' + id).title = valueS;
		}

		get_context_info(p[2]);

		//document.getElementById('gpar_1_2').innerHTML=p[3];
		// p[3] СВОБОДНА, можно что-то передать.

		larve_enabled();
		//alert(p[4])
		// время жизни:
var yeas = parseInt(p[4] / (3600 * 24 * 365));
var month = parseInt( (p[4] - yeas*3600*24*365)/ (3600*24*30)  );
var days = parseInt((p[4] - yeas*3600*24*365  - month*3600*24*30)/ (3600*24)); 
document.getElementById('life_time_id').innerHTML = "Возраст: "+yeas+" лет "+month+" мес "+days+" дней";

/* постоянно доступно текущее состояние:
1|2,5,8|11
Базовое состояние
Активные контексты
Пусковые стимулы
*/
current_condition=p[3];  // alert(current_condition);
if(current_condition.length>3)
{
document.getElementById('condition_button_id').style.display="block";
}
else
document.getElementById('condition_button_id').style.display="none";

// строка контекстов
current_contexts="";   // alert(current_condition);
var cA=current_condition.split("|");  
if(cA[1].length>0)
{
var c=cA[1].split(",");
for(i=0;i<c.length;i++)
	{
	if(current_contexts.length>0)
		current_contexts+=", ";
current_contexts+=contextsName[parseInt(c[i])];
	}
document.getElementById('contect_list_id').innerHTML="("+current_contexts+")";

check_cur_conditions_words(cA[0],cA[1]);
}
else
document.getElementById('contect_list_id').innerHTML="";

// текущее базовое состояние
var current_basik="";   
switch(parseInt(cA[0]))
{
case 1: current_basik="1 Плохо"; break;
case 2: current_basik="2 Норма"; break;
case 3: current_basik="3 Хорошо"; break;
} // alert(current_basik);
// текущее состояние пусковых стимулов 
var current_triggers=""; // show_dlg_alert2(cA[2],0);
if(cA[2].length>0)  
{
var c=cA[2].split(",");
for(i=0;i<c.length;i++)
	{
	if(current_triggers.length>0)
		current_triggers+=", ";
current_triggers+=triggersName[parseInt(c[i])];
	}
}
ful_condition_str=current_basik+"<br>"+current_contexts+"<br>"+current_triggers+"<br>";
// alert(ful_condition_str);

// открывать только еще не открыт div_dlg_alert2 чтобы не перебивать уже открытый
if(document.getElementById('div_dlg_alert2').style.display=="none")
{
		if (p[5].indexOf("NOREFLEX") == 0) {
			dialog_no_reflex(current_condition, ful_condition_str,0);
		}
		if (p[5].indexOf("IGNORED") == 0) {
			dialog_no_reflex(current_condition, ful_condition_str,1);
		}
}

//Действует период ожидания реакции оператора на действие автоматизма?
if(p[6].length>0)
{
var periodI=document.getElementById('time_limit_id');
//show_dlg_alert(old_period_val+" < "+p[6],0);
	if(old_period_val < 1*p[6])
	{
	//alert("!!!! 20");
	periodI.style.fontSize="30px";
	}else{
	periodI.style.fontSize="18px";
	}
periodI.innerHTML="Осталось времени на ответ: "+p[6]+" сек";
periodI.style.display="block";
old_period_val=1*p[6];
}
else
{
document.getElementById('time_limit_id').style.display="none";
old_period_val=0;
}

///////////////////////// индикация готовности к общению
var beast_ready=1*p[7];   // alert(beast_ready);
switch(beast_ready)
{     
case 0:
var ready_str="<span style='color=#000000background-color:#ffffff;border-radius: 7px;padding-left:3px;padding-right:3px;font-size: 15px;' title=''>Beast еще не пришел в себя, общение невозможно.</span>";
break;
case 1:
if(stages_dev <2)
var ready_str="<span class='luminous_text_blue' style='background-color:#ffffff;border-radius: 7px;padding-left:3px;padding-right:3px;font-size: 15px;color:#585CFF;' title=''>Beast очнулся и восприимчив к воздействиям.</span>";
else
var ready_str="<span class='luminous_text_blue' style='background-color:#ffffff;border-radius: 7px;padding-left:3px;padding-right:3px;font-size: 15px;color:#585CFF;' title=''>Психика Beast активрована, но без осознания.</span>";
break;
case 2:
var ready_str="<span class='luminous_text_green' style='background-color:#ffffff;border-radius: 7px;padding-left:3px;padding-right:3px;font-size: 15px;color:#008800;' title=''>Beast готов к общению.</span>";
if(startPsichicNow==0)
startPsichicNow=1;
break;
}
document.getElementById('about_bot_ready').innerHTML = "<nobr>"+ready_str+"</nobr>";
///////////////////////////////
		
}// КОНЕЦ sent_get_params(res)


var contextsName={
1:"1 Пищевой",
2:"2 Поиск",
3:"3 Игра",
4:"4 Гон",
5:"5 Защита",
6:"6 Лень",
7:"7 Ступор",
8:"8 Страх",
9:"9 Агрессия",
10:"10 Злость",
11:"11 Доброта",
12:"12 Сон"
};
var triggersName={
1:"1 Непонятно ",
2:"2 Понятно ",
3:"3 Наказать ",
4:"4 Поощрить ",
5:"5 Накормить ",
6:"6 Успокоить ",
7:"7 Предложить поиграть",
8:"8 Предложить поучить",
9:"9 Игнорировать ",
10:"10 Сделать больно",
11:"11 Сделать приятно",
12:"12 Заплакать ",
13:"13 Засмеяться ",
14:"14 Обрадоваться",
15:"15 Испугаться ",
16:"16 Простить",
17:"17 Вылечить"
};

// сбросить локально в GomeostazParams.txt, а если Включен, то послать на ГО.
function cliner_gomeo_pars(parent)
{
	show_dlg_control("Сделать:<br><div class='cliner_button' onclick='cliner_gomeo_pars2(0)'>Плохо</div>&nbsp;&nbsp;<div class='cliner_button' onclick='cliner_gomeo_pars2(100)'>Норма</div>",parent);

}
function cliner_gomeo_pars2(value)
{
	var server = "/lib/cliner_gomeo_pars.php?value="+value;    
	var AJAX = new ajax_support(server, sent_cliner_gomeo);
	AJAX.send_reqest();
function sent_cliner_gomeo(res)
{
// alert(exists_connect);
	if (exists_connect) 
		{     
var AJAX = new ajax_support(linking_address + "?cliner_gomeo_pars="+value, sent_cliner_gomeo_go);
AJAX.send_reqest();  
function sent_cliner_gomeo_go(res) 
{

}
		}
}
end_dlg_control();
show_dlg_alert("Установлено",1500);
}
</script>
<style>
.cliner_button /* кнопка выбора очитки жизненных параметров */
{
position:relative;
#margin-top:10px;
border:solid 1px #666666;
border-radius:4px;
color:#000000;
text-align:center;
cursor:pointer;
background:linear-gradient(180deg, #eeeeee, #dddddd);
font-size:15px;
padding-left:4px;
padding-right:4px;
display:inline-block;
}
.cliner_button:hover
{
background:linear-gradient(180deg, #dddddd, #eeeeee);
}
</style>