<?
/*   последние 10 правил
http://go/pages/rulles.php  


*/

$page_id = 6;
$title = "Последние 10 правил";
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/show_waiting.php");

?>
<div id='div_id' style='font-family:courier;font-size:16px;'>Нужен коннект с Beast.</div>
</div>

<div id='rules_info_id' style='font-family:courier;font-size:16px;'></div>


<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
var linking_address = '<? include($_SERVER["DOCUMENT_ROOT"] . "/common/linking_address.txt"); ?>';

// ждем пока не включат бестию
check_Beast_activnost(4);// после 4-го пульса И запускается get_info()

var old_size = 0;
var limitBasicID=0;//>0 - лимитировать показ только одним из базовых состояний Плохо,Норма,Хорошо


function get_info() {
var AJAX = new ajax_support(linking_address + "?get_rulles_list_info=1", sent_get_info);
AJAX.send_reqest();
function sent_get_info(res) {

document.getElementById('rules_info_id').innerHTML = res;
document.getElementById('div_id').innerHTML="";

setTimeout("get_info",1000);
}
}

</script>

</body>
</html>