<?
/*   список автоматизмов
http://go/pages/automatizm_table.php  

Формат записи:
id|BranchID|Usefulness||Sequence||NextID|Energy|Belief
*/

$page_id = -1;
$title = "Список автоматизмов";
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/show_waiting.php");

$out_str_for_del = ""
?>
<div style='position:absolute;top:40px;right:100px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_info()"><b>Обновить</b></div>



<div id='div_id' style='font-family:courier;font-size:16px;'>Нужен коннект с Beast.</div>
</div>


<div id='automatizm_info_id' style='font-family:courier;font-size:16px;'></div>



<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
var linking_address = '<? include($_SERVER["DOCUMENT_ROOT"] . "/common/linking_address.txt"); ?>';
var old_size = 0;
var limitBasicID=0;//>0 - лимитировать показ только одним из базовых состояний Плохо,Норма,Хорошо
wait_begin();
//setTimeout("get_info()",1000);
get_info();
	function get_info() {
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
</script>

</body>
</html>