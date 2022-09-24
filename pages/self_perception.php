<?
/*   Стрнаница текущего самоощущения Beast
http://go/pages/self_perception.php  

*/
$page_id=6;
$title="Психика Beast";
include_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
include_once($_SERVER['DOCUMENT_ROOT']."/common/show_waiting.php");


?>
<div  style='position:absolute;top:38px;left:250px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_info()"><b>Обновить</b></div>
<div  style='position:absolute;top:38px;left:370px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_autimat_table()">Таблица автоматизмов</div>

<div  style='position:absolute;top:38px;left:590px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_tree1()">Дерево автоматизмов</div>
<div  style='position:absolute;top:38px;left:800px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_tree2()">Дерево понимания</div>

<div id='div_id' style='font-family:courier;font-size:16px;'>Нужен коннект с Beast.</div>
</div>



Еще не доделано.





<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
var linking_address='<?include($_SERVER["DOCUMENT_ROOT"]."/common/linking_address.txt");?>';
function get_info()
{
wait_begin();
var AJAX = new ajax_support(linking_address+"?get_self_perception_info=1",sent_info);
AJAX.send_reqest();
function sent_info(res)
{
//alert(res);
wait_end();
document.getElementById('div_id').innerHTML=res;
}
}
get_info();
setTimeout("chech_new_info()",2000);

function get_autimat_table()
{
open_anotjer_win("/pages/automatizm_table.php");
}

function get_tree1()
{
//alert("Дерево автоматизмов");
open_anotjer_win("/pages/automatizm_tree.php");
}
function get_tree2()
{
alert("Дерево понимания");
}
//////////////////////////////

var old_size=0;
function chech_new_info()
{
var AJAX = new ajax_support("/pages/self_perception_checher.php",sent_size_info);
AJAX.send_reqest();
function sent_size_info(res)
{
	//alert(res);
if(old_size!=res)
{
get_info();
}
old_size=res;
setTimeout("chech_new_info()",2000);
}
}
</script>

</div>
</body>
</html>