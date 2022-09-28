<?
/*  дерево автоматизмов
http://go/pages/automatizm_tree.php  
*/

$page_id = 6;
$title = "Дерево автоматизмов";
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/header.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/common/show_waiting.php");
?>

<div style='position:absolute;top:40px;left:300px;font-family:courier;font-size:16px;cursor:pointer;' onClick="location.reload(true)">Обновить</div>

<div id='div_id' style='font-family:courier;font-size:16px;'>Нужен коннект с Beast.</div>
</div>

<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
var linking_address = '<? include($_SERVER["DOCUMENT_ROOT"] . "/common/linking_address.txt"); ?>';

// ждем пока не включат бестию
check_Beast_activnost(4);// после 4-го пульса И запускается get_info()
////////////////////////////////////////////////////////////////////////

//show_dlg_alert("Ожидаем 4 секунды...",0);
//setTimeout("get_info()",4000);

	function get_info() { //alert("!!!!");
		wait_begin();
		var AJAX = new ajax_support(linking_address + "?get_automatizm_tree=1", sent_info);
		AJAX.send_reqest();
		function sent_info(res) {
			//alert(res);
			wait_end();
			document.getElementById('div_id').innerHTML = res;
		}
	}

/*
	// проверяется размер /memory_psy/automatizm_tree.txt
	var old_size = 0;
	function chech_new_info() {
		var AJAX = new ajax_support("/pages/automatizm_tree_checker.php", sent_size_info);
		AJAX.send_reqest();
		function sent_size_info(res) {
			//alert(res);
			if (old_size != res) {
				get_info();
				old_size = res;
			}
			setTimeout("chech_new_info()", 2000);
		}
	}
*/
</script>

</div>
</body>

</html>