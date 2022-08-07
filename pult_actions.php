<?
/*  Действия по отношению к Beast
 include_once($_SERVER['DOCUMENT_ROOT']."/pult_actions.php");
*/
$food_portion='<select id="food_portion_id" title="Порция энергии в процентах от полного насыщения энергии." style="border:0;background-color:#E4FFEB;" onClick="event.stopPropagation();"> 
<option value="1">20%</option>
<option value="2" selected>50%</option>
<option value="3">80%</option>
</select>';
?>
<br>
<div id="action_block_id" style='padding:10px;background-color:#ffffff;'>
<div style='position:relative;'>
<b>(Де)мотивирующие дйствия в ответ на действия Beast</b> (могут вызывать безусловные рефлексы):
<a href='/pages/reflex_tree.php' style='position:absolute;top:0px;right:0px;'>Дерево рефлексов</a></div>
Могут быть совершены несколько действий подряд, контекст которых удерживается в течении 10 пульсов для рефлексов. Для психики контекст последнего действия остается до следующего любого действия или до 100 пульсов.<br>
<br>
<span id="act_1" class='actions actions_red' onClick="to_action(1)" title="Оператору непонятны-неодобряет действия Beast.">Непонятно</span>
<span id="act_2" class='actions actions_green' onClick="to_action(2)" title="Оператор понимает-одобряет действия Beast.">Понятно</span>
<span id="act_3" class='actions actions_red' onClick="to_action(3)" title="Наказание за действия Beast.">Наказать</span>
<span id="act_4" class='actions actions_green' onClick="to_action(4)" title="Поощрение действий Beast">Поощрить</span> <br><br>
<span id="act_5" class='actions actions_green' onClick="to_action(5)" title='Пополнение энергии.' ><?=$food_portion?>Накормить</span>
<span id="act_6" class='actions actions_blue' onClick="to_action(6)" title="Снижение сресса.">Успокоить</span>
<span id="act_7" class='actions actions_gray' onClick="to_action(7)" title="Уменьшение потребности в общении при критическом значении.">Предложить поиграть</span>
<span id="act_8" class='actions actions_gray' onClick="to_action(8)" title="Уменьшение потребности учиться при критическом значении.">Предложить поучить</span>
<span id="act_9" class='actions actions_gray' onClick="to_action(9)" title="Показательное игнорирование.">Игнорировать</span>
<span id="act_10" class='actions actions_red' onClick="to_action(10)" title="Увеличить повреждения.">Сделать больно</span>
<span id="act_11" class='actions actions_green' onClick="to_action(11)" title="Улучшение нескольких показателей.">Сделать приятно</span><br><br>
<span id="act_12" class='actions actions_red' onClick="to_action(12)" title="Показательная обида">Заплакать</span>
<span id="act_13" class='actions actions_green' onClick="to_action(13)" title="Улучшение нескольких показателей.">Засмеяться</span>
<span id="act_14" class='actions actions_green' onClick="to_action(14)" title="Поощрить действия Beast, показать сопреживание.">Обрадоваться</span>
<span id="act_15" class='actions actions_red' onClick="to_action(15)" title="Показательное недовольство опасными действиями Beast.">Испугаться</span>
<span id="act_16" class='actions actions_blue' onClick="to_action(16)" title="Улучшение ранее ухудшенных состояний.">Простить</span>
<span id="act_17" class='actions actions_blue' onClick="to_action(17)" title="Улучшение параметра Повреждения.">Вылечить</span>

</div>

<script>
var linking_address='<?include($_SERVER["DOCUMENT_ROOT"]."/common/linking_address.txt");?>';
var actionsArr = new Array();
for(i=0;i<17;i++)
{
actionsArr[i]=0;
}
function to_action(id)
{
// Не позволять включать антагонистов
var atgnst=0;
switch(id)
{
case 1: if(actionsArr[2]==1) atgnst=1; break;
case 2: if(actionsArr[1]==1) atgnst=1;break;
case 3: if(actionsArr[4]==1) atgnst=1;break;
case 4: if(actionsArr[3]==1) atgnst=1;break;
}
if(atgnst==1)
{
	show_dlg_alert("Уже действует антагонист.",2000);
	return;
}
if(0)// 1 - тестирование без Beast
	{
	actionsArr[id]=1;
	document.getElementById("act_"+id).style.boxShadow="0px 0px 6px 6px #FFFFCC";
	set_desactivation(id);
	}
var food_portion=document.getElementById("food_portion_id").selectedIndex+1;
//alert(food_portion);
var AJAX = new ajax_support(linking_address+"?set_action="+id+"&food_portion="+food_portion,sent_action);
AJAX.send_reqest();
function sent_action(res)
{
actionsArr[id]=1;
document.getElementById("act_"+id).style.boxShadow="0px 0px 6px 6px #FFFFCC";
set_desactivation(id);
show_dlg_alert("Действие совершено.",2000);
}

//МЕНЯТЬ ФОН (розовый или голубой) БЛОКА ДЕЙСТВИЙ /pult_actions.php ПРИ НАЖАТИЯХ НА 5 ПУЛЬСОВ
var AJAX = new ajax_support("/pages/gomeostaz_get_motivation.php?id="+id,sent_motivation_action);
AJAX.send_reqest();
function sent_motivation_action(res) // action_block_id
{
if(res=="+")
document.getElementById("action_block_id").style.backgroundColor="#DDEBFF";
if(res=="-")
document.getElementById("action_block_id").style.backgroundColor="#FFE4E1";
}
clearTimeout(actionMoodTimerID);
actionMoodTimerID=setTimeout("clinerBGmotivationAct()",5000);
}
var actionMoodTimerID=0
function clinerBGmotivationAct()
{
document.getElementById("action_block_id").style.backgroundColor="";
}
//////////////////////////////////
var actionTimerID=0
function set_desactivation(id)
{
actionTimerID=setTimeout("desactivation("+id+")",10000);
}
function desactivation(id)
{
actionsArr[id]=0;
document.getElementById("act_"+id).style.boxShadow="";
}
function desactivationAll()
{
var nodes = document.getElementsByClassName('actions'); //alert(nodes.length);
for(var i=0; i<nodes.length; i++) 
{ 
nodes[i].style.boxShadow="";
}
}
</script>