<?
/* спойлер с инструментами справа ввехху по клику на шестеренке
include_once($_SERVER["DOCUMENT_ROOT"]."/tools/tools.php");
*/


// набор инструментов (загрузка и сохранение памяти Beast)
echo "<div style='position:fixed;z-index:1000;top:0px;right:0px;' title='Инструменты.

В любой момент можно нажать Ctrl+S 
чтобы сохранить всю текущую память Beast 
в архиве с возможность последующего восстановления 
(как и архивы, сохраненные на дату-время).
'>
<div style='position:absolute;top:0px;right:0px;cursor:pointer;' onclick='event.stopPropagation();open_close(`block_id`,0)' ><img src='/img/tools.png'></div>
<div id='block_id' class='spoiler_block spoiler' style='position:absolute;top:30px;right:0px;
height:0px;
order-radius: 7px;
background-color:#eeeeee;
padding-left:10px;
padding-right:10px;
#!!!padding-bottom:5px;
outline:solid 1px #8A3CA4;outline-offset: -1px;
font-size:12pt;'>";

echo "<div id='tools_conteiner' style='display:none'>";

// СТРОКИ КОМАНД ИНСТРУМЕНТОВ:
echo "<div class='tools' title='Сохранить все текущее состояние в архиве CurrentMemory.' onClick='save_current_memory()'>Сохранить текущее состояние (Ctrl+S)</div>";

echo "<div class='tools' title='Сохранить текущую память Beast перед выключением. На это время приостанавливаются все процессы Beast и все виды памяти сохраняются из оперативной памяти в постоянную.' onClick='save_all_bot_files()'>Сохранить память Beast</div>";

echo "<div class='tools' title='Сохранить все текущее состояние в файлах памяти и записать в общий файл архива для возможности восстановления.' onClick='archive_all_bot_files()'>Создать архив всей памяти</div>";

echo "<div class='tools' title='Восстановить из архива все текущее состояние.' onClick='archive_restore()'>Востановить память из архива</div>";

echo "<div class='tools' title='Сбросить память Beast чтобы начать развитие заново с безусловных рефлексов.' onClick='removeing_all()'>Сбросить память</div>";

echo "<div class='tools' title='Корректное выключение Beast.' onClick='bot_closing()'>Выключить Beast</div>";


// это - только для нижнего отсупа:
echo "<div class='tools' ></div>";

echo "</div>";
echo "<div id='tools_conteiner_not' style='color:red;display:block'><b>Нужно сначала включить Beast</b></div>";


echo "</div>

</div>
</div>";
?>
<script>
function tools_show(on)
{
	if(on)
	{
document.getElementById('tools_conteiner').style.display="block";
document.getElementById('tools_conteiner_not').style.display="none";
	}
	else
	{
document.getElementById('tools_conteiner').style.display="none";
document.getElementById('tools_conteiner_not').style.display="block"; //alert("??ss");
wait_end();
	}

}

// Сохранить все текущее состояние в архиве CurrentMemory (Ctrl+S)
function save_current_memory()
{
var server="/tools/save_current_memory.php";
var AJAX = new ajax_support(server,sent_save_memory);
AJAX.send_reqest();
function sent_save_memory(res)
{
// alert(res);
if(res[0]!="!")
{
show_dlg_alert(res.substr(1),0);
//bot_closing();
return;
}

show_dlg_alert("<span style='font-size:14pt;font-weight:normal;;'>Память сохранена в архиве CurrentMemoryм.zip</span>",1500);
}

}
//////////////////////////////



// Действия инструментов спойлера
// спойлер закрывается по window.onmouseup  в /common/header.php
var tools_action_ID=0;
function save_all_bot_files()
{
tools_action_ID=1;
stop_activnost();
}
///////////////////////////////
function archive_all_bot_files()
{
tools_action_ID=2;  // нужно останавливать при архивировании чтобы все хохранить и замереть
stop_activnost();
}
// Востановить память из архива
function archive_restore()
{
//show_dlg_alert("Еще не сделано",0);return;
//show_dlg_confirm("Точно заменить память на выбранный архив?",1,-1,archive_restore2);
//tools_action_ID=3;
//stop_activnost();
// получить список имеющихся архивов
var server="/tools/memory_load.php";
var AJAX = new ajax_support(server,sent_save_memory);
AJAX.send_reqest();
function sent_save_memory(res)
{
// alert(res);
if(res[0]!="!")
{
show_dlg_alert(res.substr(1),0);
//bot_closing();
return;
}

show_dlg_alert("Архивы памяти:<br>"+res.substr(1),2);
start_activnost();
}
}
// восстановить архив
var cur_archive_file="";
function restore_archive(file)
{
cur_archive_file=file;
show_dlg_confirm("Точно заменить память на выбранный архив?","Да","Нет",restore_archive2);
}
function restore_archive2()
{
//alert(cur_archive_file);return;
//Влсстановить архив всей памяти
var server="/tools/restore_memory_server.php?file="+cur_archive_file;
var AJAX = new ajax_support(server,sent_restore_res);
AJAX.send_reqest();
function sent_restore_res(res)
{	
//alert(res);
if(res[0]!="!")
{	
show_dlg_alert("Не удалось восстановить память Beast из архива "+cur_archive_file,0);
return;
}
// выключить Beast
 bot_closing();

show_dlg_alert("Восстановлена память Beast из архива. "+cur_archive_file+
	"<br><br><span style='color:red'>Beast выключен</span> чтобы получить новую память при включении.",0);
}
}
// удалить архив
function remove_archive(file)
{
cur_archive_file=file;
show_dlg_confirm("Точно удалить выбранный архив?","Да","Нет",remove_archive2);
}
function remove_archive2()//Удалить файл архива
{
var server="/tools/delete_archive_server.php?file="+cur_archive_file;
var AJAX = new ajax_support(server,sent_restore_memory);
AJAX.send_reqest();
function sent_restore_memory(res)
{	
//alert(res);
if(res[0]!="!")
{
show_dlg_alert("Не удалось удалить файл архива "+cur_archive_file,0);
return;
}
//show_dlg_alert("Архив удален",0);
archive_restore();// выключить Beast
}
}
////////////////////////////////////

///////////////////////////////
function removeing_all()
{
show_dlg_confirm("Точно сбросить память до младенческого состяония?","Да","Нет",removeing_all2);
}
function removeing_all2()
{  
wait_begin();
bot_closing();// выключить Beast
setTimeout("removeing_all3()",2000);// выждать завершения процессов
}
function removeing_all3()
{
var AJAX = new ajax_support("/tools/cliner_mempry.php",sent_info);
AJAX.send_reqest();
function sent_info(res)
{
	wait_end();
//alert(res);
if(res[0]!="!")
{
show_dlg_alert(res.substr(1),0);
return;
}
show_dlg_alert("Память очищена, Beast выключен - в младенческом состоянии.",0);
}
}
///////////////////////////////






/////////////////////////////
// после остановки ГО совершить действие
function todo_action()
{
if(tools_action_ID==1)//Сохранить текущее состояние
{	
var AJAX = new ajax_support(linking_address+"?save_all_memory=1",sent_info_1);
AJAX.send_reqest();
function sent_info_1(res)
{
	wait_end();
//alert(res);
if(res!="yes")
{
show_dlg_alert("Не удалось сохранить память Beast",0);
bot_closing();
return;
}
show_dlg_alert("Память сохранена.",0);
start_activnost();
}
}
//////////////////

if(tools_action_ID==2)//Создать архив всей памяти
{	
var AJAX = new ajax_support(linking_address+"?save_all_memory=1",sent_info_1);
AJAX.send_reqest();
function sent_info_1(res)
{	
//alert(res);
if(res!="yes")
{
	wait_end();
show_dlg_alert("Не удалось сохранить память Beast",0);
bot_closing();
return;
}
// теперь создать архив
var server="/tools/memory_save.php";
var AJAX = new ajax_support(server,sent_save_memory);
AJAX.send_reqest();
function sent_save_memory(res)
{
wait_end();  // alert(res);
if(res[0]!="!")
{
show_dlg_alert(res,0);
bot_closing();
return;
}

show_dlg_alert("Архив создан и доступен в списке для восстановления:<br>"+res.substr(1),0);
start_activnost();
}

}
}
///////////////////////




}
////////////////////////////////////////////////////









/* это - глабальная блокировка-разблокировка всех действий на Пульте и Beast
для совершения критических операций, которым мешает такая активность.

*/
function stop_activnost()
{	
wait_begin();
var AJAX = new ajax_support(linking_address+"?stop_activnost=1",sent_info);
AJAX.send_reqest();
function sent_info(res)
{
//alert(res);
if(res!="stop")
{
wait_end();
show_dlg_alert("Не удалось остановить активность Beast, операция не совершена.",0);
return;
}
actived_contact=0;
// то, что нужно сделать в режиме блокировки активности
setTimeout("todo_action()",2000);
}
}
function start_activnost()
{
wait_end();
var AJAX = new ajax_support(linking_address+"?start_activnost=1",sent_info);
AJAX.send_reqest();
function sent_info(res)
{
//alert(res);
if(res!="active")
{
show_dlg_alert("Не удалось восстановить активность Beast...",0);
return;
}
actived_contact=1;
}
}
function bot_closing()
{
// wait_begin(); нет сигнала для сброса гифки 
actived_contact=0;
show_dlg_alert("Beast выключается...",2000);
var AJAX = new ajax_support(linking_address+"?bot_closing=1",sent_info);
AJAX.send_reqest();
function sent_info(res)
{
// не будет ответа
}
}

</script>
