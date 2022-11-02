<?
/*   Стрнаница текущего самоощущения Beast
http://go/pages/self_perception.php  

*/
$page_id=7;
$title="Психика Beast";
include_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
include_once($_SERVER['DOCUMENT_ROOT']."/common/show_waiting.php");


?>
<div  style='position:absolute;top:38px;left:180px;font-family:courier;font-size:16px;cursor:pointer;' onClick="location.reload(true)"><b>Обновить</b></div>
<div  style='position:absolute;top:38px;left:300px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_autimat_table()" title='Ментальные автоматизмы'>Таблица автоматизмов</div>

<div  style='position:absolute;top:38px;left:510px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_tree1()" title='Дерево текущей ситуации с произвольной активацией'>Дерево понимания</div>
<div  style='position:absolute;top:38px;left:680px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_rules()" title='Ментальные Правила - опыт последовательности ментальных автоматизмов'>Правила</div>

<div  style='position:absolute;top:38px;left:780px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_cicles()" title='Ментальные циклы - кратковременная память'>Циклы</div>

<div id='div_id' style='font-family:courier;font-size:16px;'>Нужен коннект с Beast.</div>
</div>



<br>
<br>
<br>
<br>




<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
var linking_address='<?include($_SERVER["DOCUMENT_ROOT"]."/common/linking_address.txt");?>';

// ждем пока не включат бестию
check_Beast_activnost(6);// после 4-го пульса И запускается get_info()

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

setTimeout("chech_new_info()",2000);
}
}
//get_info();
//setTimeout("chech_new_info()",2000);

function get_autimat_table()
{
open_anotjer_win("/pages/mental_automatizm_table.php");
}

function get_tree1()
{
//alert("Дерево автоматизмов");
open_anotjer_win("/pages/mental_automatizm_tree.php");
}
function get_rules()
{
//alert("Дерево понимания");
open_anotjer_win("/pages/mental_rules.php");
}
function get_cicles(){
open_anotjer_win("/pages/mental_cicles.php");
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