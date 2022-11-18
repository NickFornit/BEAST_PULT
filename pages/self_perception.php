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
<div  class='navigator_button' style='position:absolute;top:38px;left:300px;' onClick="get_autimat_table()" title='Ментальные автоматизмы'>Таблица автоматизмов</div>

<div class='navigator_button' style='position:absolute;top:38px;left:510px;' onClick="get_tree1()" title='Дерево текущей ситуации с произвольной активацией'>Дерево понимания</div>


<div id='div_id' style='font-family:courier;font-size:16px;'>Нужен коннект с Beast.</div>
</div>
</center>
<div style='margin-top:10px;text-align:left;'>
<hr style='width:90%' align='left'>

В детстве опыт ответов на то, чего пока не знаешь набирается или пробно
или отзеркаливаются чужие ответы. Это становится шаблоном ответа в данной ситуации.<br>
Шаблон усложняется после ответа на ответ и растет цепочка понимания как можно отвечать.<br>
каждый может вспомнить, как учился отвечать на колкости.<br>
Если тебе сказали - "ты дурак", и раньше никогда так не было, очень важно как другие детки на такое отвечали,
ты просто делашь точно так же, отвечаешь "Сам дурак". А тебе: "От дурака слышу!",<br>
ты опять в ступоре, но постепенно набираются цепочки: на такою предъяву - такой-то ответ.<br>
И, как в обучении игры в шахматы развиваются последовательности действий от исходной комбинации.<br>

Вся детская лексика - практически только такие цепочки.<br>
Цепочки Правил в Эпиз.памяти создабт карту решений в контексте одной темы:<br>
карты местности - куда идти после очередного шага,
карту игры в шахматы: как ходить в данной позиции и на сколько шагов вперед обдумывать решения.<br>
<div class='navigator_button'  onClick="get_rules()" title='Ментальные Правила - опыт последовательности ментальных автоматизмов'>Список Правил</div><br>
<hr style='width:90%' align='left'>


Цикл обдумывания - субъективный ориентировочный рефлекс, каждой шаг которого основывается на информации, даваемой предыдущим шагом
с целью найти подходящие действия для данной ситуации, что дает возможность снова сориентироваться.<br>
После каждой активации по объективному оринентировочному рефлексу возникает цикл ментальной обработки информации, который заключается в поиске подходящей информационной функции, запуска ментального автоматизма этой функции, получения новой информации, использования ее последущей инфо-функцией и так - до создания ментального автоматизма запуска моторного действия, которое проверяется на успешность и прописывается как моторный автоматизм.<br>
<div  class='navigator_button'  onClick="get_cicles()" title='Ментальные циклы - кратковременная память'>Циклы</div>
<hr style='width:90%' align='left'>


Значимость элементов восприятия - как объекта произвольного внимания: 
того из всего воспринимаемого, что имеет наибольшую значимость
т.к. именно наибольшая значимость должна осмысливаться.<br>

Кроме того, значимости объектов - это и есть модель понимания данного объекта внимания -
его значимость в разных условиях и то, какие действия могут быть совершены при этом.<br>

Значимость - величина от -10 0 до 10, приобретаемая объектов внимания в данной ситуации
- берется из результата пробных действий и связывается ос всеми компонентами воспринимаемого в этих условиях.<br>

Оценке значимости подлежат элементы действия оператора:
кнопки воздействия, фразы и отдельные слова, принимающие значимость фразы.<br>
<div  class='navigator_button'  onClick="get_imp_obj()" title=''>Объекты значимости</div>
<hr style='width:90%' align='left'>



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


function get_imp_obj()
{
open_anotjer_win("/pages/mental_importance.php");
}
</script>

</div>
</body>
</html>