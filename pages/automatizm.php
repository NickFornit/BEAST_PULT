<?
/*   Стрнаница автоматизмов Beast
http://go/pages/automatizm.php  

*/
$page_id=6;
$title="Автоматизмы Beast";
include_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");
include_once($_SERVER['DOCUMENT_ROOT']."/common/show_waiting.php");


?>
<div  style='position:absolute;top:38px;left:250px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_autimat_table"><b>Обновить</b></div>

<div  style='position:absolute;top:38px;left:370px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_autimat_table()">Таблица автоматизмов</div>
<div  style='position:absolute;top:38px;left:590px;font-family:courier;font-size:16px;cursor:pointer;' onClick="get_tree1()">Дерево автоматизмов</div>


<!--  НЕТ СРАЗУ ЗАГРУЖАЕМОГО КОНТЕНТА div id='div_id' style='font-family:courier;font-size:16px;'>Нужен коннект с Beast.</div>
</div -->


<div style="width:1000px;">
Для тестирования возможно избежать долгий период воспитания с формированием автоматизмов и просто сгенерировать автоматизмы на основе существующих рефлексов (с приоритетом условных рефлексов).<br>
При этом у автоматизмов будут установлены опции уже проверенного автоматизма с полезностью, равной 1 (вполне полезно). Это правомерно потому, что рефлексы создавались уже полезными для своих условий.<br>
В дальнейшем такие автоматизмы будут проверяться в зависимости от реакции оператора и изменения состояния Beast, корректируясь настолько эффективно, насколько позволяет текущая стадия развития.
<br><br>
<div  style='display: inline-block;relative;font-family:courier;font-size:16px;cursor:pointer;
border:solid 1px #8A3CA4;border-radius: 7px;padding-left:4px;padding-right:4px;
background-color:#eeeeee;' onClick="make_automatizms()">Создать автоматизмы на основе существующих рефлексов</div><br>
<br>
<div id='res_div_id' style='font-family:courier;font-size:21px;color:green;font-weight:bold;'></div>
<div id='div_id' style='font-family:courier;font-size:21px;color:red;font-weight:bold;'></div>
</div>
<br>
<br>
Для стадии 3 так же необходимо длительное время для отзеркаливания реакций оператора в различных ситуациях. Это время возможно сократить для тестирования, запустив редактор создания зеркальных автоматизмов (первичного жизненного импринтингового опыта) на основе существующих автоматизмов.<br>
При этом уже будут вставлены умолчательные значения в виде предположительной инверсии реакций автоматизма.
<br><br>
<div  style='display: inline-block;relative;font-family:courier;font-size:16px;cursor:pointer;
border:solid 1px #8A3CA4;border-radius: 7px;padding-left:4px;padding-right:4px;
background-color:#eeeeee;' onClick="open_anotjer_win('/pages/mirrors_automatizm.php')" >Начать набивку зеркальных автоматизмов на основе существующих</div><br>
<br>


</div>

</div>



<script Language="JavaScript" src="/ajax/ajax.js"></script>
<script>
var linking_address='<?include($_SERVER["DOCUMENT_ROOT"]."/common/linking_address.txt");?>';


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
// процесс идет в ГО
var type_reqwest_go=0;// 1 - создать автоматизмы из рефлексов
function make_automatizms()
{
//exists_connection(); // если нет коннекта, будет сообщение
// ждем пока не включат бестию
check_Beast_activnost(4);// после 4-го пульса И запускается get_info()
type_reqwest_go=1; //alert(type_reqwest_go);
}
function get_info() 
{
if(type_reqwest_go==1)/////////////////////////////
{
var linking_address = '<? include($_SERVER["DOCUMENT_ROOT"] . "/common/linking_address.txt"); ?>';
wait_begin();
var AJAX = new ajax_support(linking_address + "?make_automatizms_from_reflexes=1", sent_process_info);
AJAX.send_reqest();
function sent_process_info(res) {
			//alert(res);
wait_end();
document.getElementById('res_div_id').innerHTML = res;
}
}/////////////////////////////

}
</script>

</body>
</html>