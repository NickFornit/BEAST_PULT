<?
/*   последние 10 Правил
http://go/pages/rulles.php  


*/

$page_id = 6;
$title = "Правила, Стимул-Ответ-Эффект";
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/show_waiting.php");

// из-за конфликтов чтение-запись убрал авто обновление
?>
<div style='position:absolute;top:40px;left:350px;font-family:courier;font-size:16px;cursor:pointer;' onClick="location.reload(true)"><b>Обновить</b> - нет автоматического обновления<span style="padding-left:100px"><span> 
</div>

<div id='div_id' style='font-family:courier;font-size:16px;'>Нужен коннект с Beast.</div>
</div>

<div id='rules_info_id' style='font-family:courier;font-size:16px;'></div>


<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
var linking_address = '<? include($_SERVER["DOCUMENT_ROOT"] . "/common/linking_address.txt"); ?>';

// ждем пока не включат бестию
check_Beast_activnost(6);// после 6-го пульса И запускается get_info()
//get_info();

var old_size = 0;
var limitBasicID=0;//>0 - лимитировать показ только одним из базовых состояний Плохо,Норма,Хорошо


function get_info() {  
var AJAX = new ajax_support(linking_address + "?get_rulles_list_info=1", sent_get_info);
AJAX.send_reqest();
function sent_get_info(res) {
if(res.length<10)
	{
document.getElementById('rules_info_id').innerHTML = "Еще нет правил.";
	}

document.getElementById('div_id').innerHTML=res;

//show_dlg_alert("!!!!!!!!!!!",0); 
}

//setTimeout("get_info()",2000);из-за конфликтов чтение-запись убрал авто обновление
}

</script>

</body>
</html>