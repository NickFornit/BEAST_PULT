<?
/*  диалог общения с Beast
 include_once($_SERVER['DOCUMENT_ROOT']."/pult_Bot_dialog.php");
*/

echo "<hr>";

echo '<div id="about_bot_ready" style="margin-top:10px;color:red;">Beast еще не пришел в себя, общение невозможно.</div>';

if($stages>0)
{
echo '<div style="margin-top:10px;color:;">По возможности предваряйте фразы подходящими действиями, сначала нажав кнопку (или несколько подряд) внизу.</div>';
}


?>
<div style="position:relative;border:solid 1px #8A3CA4;background-color:#cccccc;width:1000px;padding:10px;
margin-top:10px;">

<b>Поcлать сообщение Beast</b>: <span id="stadia_warn" style="color:red;"></span><br>
<div style='position:absolute;top:10px;right:10px;'><nobr><input type="checkbox" value="1" onChange="switch_input_rejim(this)"> - набивка рабочих фраз без отсеивания мусорных слов</nobr></div>
<div id="note_rejim_id" style='position:absolute;top:0px;left:50%;transform: translate(-50%, 0);color:red;display:none;'><nobr>Это - режим формирования вербальных распознавателей, а не диалог с Beast!</nobr></div>
<script>
var is_input_rejim=1;
function switch_input_rejim(ch)
{
	if(ch.checked==true)
	{
document.getElementById('note_rejim_id').style.display="block";
is_input_rejim=0;
	}
	else
	{
document.getElementById('note_rejim_id').style.display="none";
is_input_rejim=1;
	}
}
</script>

<div style="position:relative;">
<div style="position:absolute;top:10px;left:-20px;color:red;cursor:pointer;padding:4px;border:solid 1px #8A3CA4;border-radius:50%;background-color:#ffffff" title="Очистить окно ввода" onClick="cliner_textarea()"><b>X</b></div>
<textarea id="input_id"  style="width:calc(100% - 10px);;" rows="6" maxlength="500" onMouseDown="click_textarea()" onKeyDown="click_textarea()" disabled>Привет</textarea><br>
<b>Тон:</b> 
<input id='radio_1' type='radio' name='rdi' value='4' >повышенный 
<input id="radio_2" type='radio' name='rdi' value='0' checked>нормальный 
<input id="radio_3" type='radio' name='rdi' value='3'>вялый 

&nbsp;&nbsp;<b>Передать контекст своего настроения:</b><br>
<input id='radio2_4' type='radio' name='rdi2' value='0' checked>Нормальное &nbsp;&nbsp;
<input id='radio2_4' type='radio' name='rdi2' value='20' >Хорошее &nbsp;&nbsp; 
<input id="radio2_5" type='radio' name='rdi2' value='21' >Плохое &nbsp;&nbsp;
<input id="radio2_6" type='radio' name='rdi2' value='22'>Игровое &nbsp;&nbsp;
<input id="radio2_7" type='radio' name='rdi2' value='23'>Учитель &nbsp;&nbsp;
<input id="radio2_8" type='radio' name='rdi2' value='24'>Агрессивное&nbsp;&nbsp;
<input id="radio2_9" type='radio' name='rdi2' value='25'>Защитное &nbsp;&nbsp;
<input id="radio2_10" type='radio' name='rdi2' value='26'>Протест &nbsp;&nbsp;

<input id="input_button_id" type="button"  value="Послать" onClick="sent_go()" style="position:absolute;bottom:0px;right:0px;padding:4px;" disabled> 
</div>
<div id='recognized_block_id' style="position:relative;margin-top:10px;background-color:#eeeeee;padding:4px;min-height:40px;">
<div style="position:absolute;top:4px;right:170px;font-size:12px;"><nobr><a href='/pages/words_tree.php' target='showpage2' style='position:absolute;top:0px;right:0px;'>Дерево слов</a></nobr></div>
<div style="position:absolute;top:4px;right:80px;font-size:12px;"><nobr><a href='/pages/phrase_tree.php' target='showpage2' style='position:absolute;top:0px;right:0px;'>Дерево фраз</a></nobr></div>
<div style="position:absolute;top:4px;right:4px;font-size:12px;cursor:pointer;" onClick="tree_cliner()" title="Очистить дерево слов и фраз чтобы начать заново.">- очистить</div>

<span style="color:#666666;font-size:15px;">Распознаное:</span><br><span id="pult_result_id" style="margin-top:10px;height:20px;"></span>
</div>

</div>


<script Language="JavaScript" src="/ajax/ajax_post.js"></script>
<script>

function tree_cliner()
{
	show_dlg_confirm("Вам придется заново набивать фразы.<br>Точно очистить детектор фраз?",1,1,cliner_continue);

}
function cliner_continue()
{
var AJAX = new ajax_support("/lib/tree_cliner_server.php",sent_tree_cliner);
AJAX.send_reqest();
function sent_tree_cliner(res)
{
show_dlg_alert("Деревья слов и фраз очищены.",0);
}
}
function cliner_textarea()
{
end_dlg_alert();
//end_ReceiveAnsvetFromPult();
document.getElementById('input_id').value="";
document.getElementById('input_id').focus();
}
function sent_go()
{
var txt=document.getElementById('input_id').value;

var tone=0;
var moode=0;
var allr=document.getElementsByName('rdi');
for(var i=0; i<allr.length; i++)
{
    if (allr[i].checked) 
	{
		tone=allr[i].value;
      break; 
	}
 }
//alert(tone);
allr=document.getElementsByName('rdi2');
for(var i=0; i<allr.length; i++)
{
    if (allr[i].checked) 
	{
		moode=allr[i].value;
      break; 
	}
 }
//alert(moode);

///////////////////////////////////////////
var server="/lib/separate_words_str_server.php";
var params="text="+txt;    //alert(txt);return;
var AJAX = new ajax_post_support(server,params,sent_request_bot,1);
AJAX.send_reqest();
function sent_request_bot(res)
{
//alert(res);return;
bot_contact("is_input_rejim="+is_input_rejim+"&pult_tone="+tone+"&pult_mood="+moode+"&text_dlg="+res,text_bot_answer);
}
}

function text_bot_answer(res)
{ 
//	alert(res);
if(res=="POST")
{
show_dlg_alert('Не воспринят текст...',3000);
//setTimeout(`document.forms['refresh'].submit();`,2000);
return;
}

document.getElementById('pult_result_id').innerHTML=res;

//show_dlg_alert(res,2000);
//setTimeout(`document.forms['refresh'].submit();`,2000);
}
////////////////////////////
function click_textarea()
{
end_dlg_alert();
//end_ReceiveAnsvetFromPult();
}
//////////////////////////////
</script>