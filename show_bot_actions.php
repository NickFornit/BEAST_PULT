<?
/* вывод на Пульт действий Beast 
include_once($_SERVER['DOCUMENT_ROOT']."/show_bot_actions.php");

Каждая акция приходит в формате: вид действия (1 - действие рефлекса, 2 - фраза) затем строка акции,
например: "1|Предлогает поиграть" или "2|Привет!"
Может передаваться неограниченная последовательность акций, разделенных "||"
например: "1|Предлогает поиграть||2|Привет!"
*/



?>
<div id="div_bot_action"
style="
position:fixed;
z-index: 100;
bottom: 10px;right: 10px;
max-height:600px;
min-width:250px;
overflow:auto;
display:none;
padding: 10px;padding-top:4px;padding-bottom:4px;
border:solid 2px #8A3CA4;
color:#000000;background-color:#eeeeee;
font-size:16px;font-family:Arial;font-weight:normal;
box-shadow: 8px 8px 8px 0px rgba(122,122,122,0.3);border-radius: 10px;
text-align:left;
"></div>

<script>
/*
Каждая акция - в формате: вид действия (1 - действие рефлекса, 2 - фраза) затем строка акции,
например: "1|Предлогает поиграть" или "2|Привет!"
Можно передавать неограниченную последовательность акций, разделяя их "||"
например: "1|Предлогает поиграть||2|Привет!"
*/
function new_bot_action(act_str)
{
var aOut="";
var actArr=act_str.split("||");
var act="";
var actKind=0;
var actStr="";
for(n=0;n<actArr.length;n++)
{
	if(actArr[n].length==0)
		continue;
act=actArr[n].split("|");
if(act.length!=2)
	{
alert("Неверно прописана акция: "+act_str);
return; // кривая акция
	}
//	alert(actKind);
actKind=act[0];   //actKind=3;
actStr=act[1];

if(actKind==1)
aOut+="<b>Безусловный рефлекс:</b><br>"+actStr+"<br>";
else
if(actKind==2)
aOut+="<b>Beast говорит:</b><br>"+actStr+"<br>";
else
if(actKind==3)// автоматизм
aOut+="<div style=\"padding:10px;background-color:#CCE8FF;border-radius: 7px;box-shadow: 8px 8px 8px 0px rgba(122,122,122,0.3);\"><b>Автоматизм:</b><br>"+actStr+"</div>";
else
	{
alert("Неверно прописана акция: "+act_str);
return; // кривая акция
	}
}

show_dlg_bot_action(aOut);
}
////////////////////////
var actTimer=0;
function show_dlg_bot_action(str)
{
end_dlg_bot_action();
setTimeout("show_dlg_bot_action2('"+str+"')",250);
}
function show_dlg_bot_action2(str)
{
//крестик
var exit="<div class='alert_exit' style='top:2px; right:2px;' title='закрыть' onClick='end_dlg_bot_action();'><span style='position:relative; top:-1px; left:1px;'>&#10006;</span></div>";

document.getElementById('div_bot_action').innerHTML=exit+
"<div style='margin-bottom:10px;'><b>Действия Beast:</b></div>"+str;
document.getElementById('div_bot_action').style.display="block";



actTimer=setTimeout("end_dlg_bot_action()",10000);
}
////////////////////////////

function end_dlg_bot_action()
{
clearTimeout(actTimer);// если закрыли крестиком, тут же готовность получить новую акцию
document.getElementById('div_bot_action').style.display="none";
}

//new_bot_action("1|Предлогает поиграть||2|Привет!");
</script>