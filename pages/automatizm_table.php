<?
/*   список автоматизмов
http://go/pages/automatizm_table.php  

Формат записи:
id|BranchID|Usefulness||Sequence||NextID|Energy|Belief
*/

$page_id = 6;
$title = "Список штатных автоматизмов";
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/show_waiting.php");

$out_str_for_del = ""
?>
<div style='position:absolute;top:40px;left:350px;font-family:courier;font-size:16px;cursor:pointer;' onClick="location.reload(true)"><b>Обновить</b><span style="padding-left:100px"><span>(Только один штатный автматизм привязывается к узлу Дерева)</div>



<div id='div_id' style='font-family:courier;font-size:16px;'>Нужен коннект с Beast.</div>
</div>


<div id='automatizm_info_id' style='font-family:courier;font-size:16px;'></div>



<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
var linking_address = '<? include($_SERVER["DOCUMENT_ROOT"] . "/common/linking_address.txt"); ?>';

// ждем пока не включат бестию
check_Beast_activnost(4);// после 4-го пульса И запускается get_info()

var old_size = 0;
var limitBasicID=0;//>0 - лимитировать показ только одним из базовых состояний Плохо,Норма,Хорошо


function get_info() {
	end_dlg_alert();
	wait_begin();
		var AJAX = new ajax_support(linking_address + "?limitBasicID="+limitBasicID+"&get_automatizm_list_info=1", sent_get_info);
		AJAX.send_reqest();

		function sent_get_info(res) {
			//alert(res);
			wait_end();
			document.getElementById('automatizm_info_id').innerHTML = res;
document.getElementById('div_id').innerHTML="Информация - по щелчку на Пусковой стимул или Действия автоматизма.";
					}
	}
	

function show_level(base)
{
	limitBasicID=base;
get_info();
}
//////////////////////////////////////////////

function show_trigger(triggerID)
{
//alert(triggerID);
var AJAX = new ajax_support(linking_address + "?triggerID="+triggerID+"&get_trigger_info=1", sent_trigger_info);
AJAX.send_reqest();
function sent_trigger_info(res) {
			//alert(res);
show_dlg_alert(res,0);
}
}

function show_actions(id,sequence)
{
//alert(sequence);
var AJAX = new ajax_support(linking_address + "?autmzmID="+id+"&sequence="+sequence+"&get_sequence_info=1", sent_sequence_info);
AJAX.send_reqest();
function sent_sequence_info(res) {
			//alert(res);
res=res.replace(/\<\/b\>/g,'</b><br>');
show_dlg_alert("<div style='text-align:left;font-weight:normal;'>"+res+"</div>",0);
}
}
function show_emotion(emotionID)
{
var AJAX = new ajax_support(linking_address + "?emotionID="+emotionID+"&get_emotion_info=1", sent_emotion_info);
AJAX.send_reqest();
function sent_emotion_info(res) {
			//alert(res);
res=res.replace(/\<\/b\>/g,'</b><br>');
show_dlg_alert("<div style='text-align:left;font-weight:normal;'>"+res+"</div>",0);
}
}

</script>

</body>
</html>