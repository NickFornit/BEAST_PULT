<?
/*  Заливка текстов для дерева слов
http://go/pages/words.php  

*/
$page_id=2;
$title="Массовая Заливка больших текстов для дерева слов";
include_once($_SERVER['DOCUMENT_ROOT']."/common/header.php");


if(isset($_POST['gogogo']))
{
echo "<script>wait_show();</script>";
$text=$_POST['txt_list']; 
/* НЕ вижу смысла разделять слова на корень и окончание.
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/indexer_stemmer_UTF8.php");
$stemmer = new Lingua_Stem_Ru();
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/separate_str.php");
$out=prepare_str($text,$stemmer);
*/
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/separate_words_str.php"); 
$out=prepare_str($text);

// залить в Beast:

// иногда остаются переносы строки, что вызывает ошибку js поэтому:
$out=str_replace("\n","",$out);

//exit("\r\n $out");

//$out=urlencode($out); - в golang не нашел реально подходящую замену urldecode
$out=str_replace("%","{#1}",$out);// достаточно экранировать %
//$out=str_replace('"',"{#2}",$out);
$out=str_replace('"','',$out);// кавычки просто очищаем (пусть будет афазия :)

include_once($_SERVER['DOCUMENT_ROOT']."/common/linking.php");
echo "<form name=\"refresh\" method=\"post\" action=\"/pages/words.php\"></form>";
?>
<script Language="JavaScript" src="/ajax/ajax_post.js"></script>
<script> 
	//alert("!!!!!");
bot_contact("text_block=<?=$out?>",text_block_answer);
function text_block_answer(res)
{ 
wait_end();
//	alert(res);
if(res=="POST")
{
show_dlg_alert('Слишком длинный текст для передачи...',3000);
setTimeout(`document.forms['refresh'].submit();`,2000);
return;
}
show_dlg_alert('Залито в Beast',2000);
setTimeout(`document.forms['refresh'].submit();`,2000);
}
</script>

<?
exit();
}
///////////////////////////////////////////////


echo "<div class='main_page_div' style='margin-top:20px;'>Массированную заливку стоит использовать только для тестирования и экспериментирования.<br>
Для рабочего формирования вербальных распознавателей следует использовать ввод из “Поcлать сообщение Beastу”.<br>Сначала следует приготовить текст фраз для такого формирования (например как <a href='/sourse_texts/verbal_detector_phrases.txt' target='_blank'>этот</a>).<br>Затем вводить их по несколько фраз с контролем распознавания (внизу показывается распознанная часть).
</div>";



echo "<div class='main_page_div' style='margin-top:50px;'>";

echo "<a href='/pages/words_temp.php' target='showpage1' style='position:absolute;top:-25px;right:0px;'>Показать накопитель слов-фраз</a>";
echo "<a href='/pages/words_tree.php' target='showpage2' style='position:absolute;top:0px;right:120px;'>Показать дерево слов</a>&nbsp;
<a href='/pages/phrase_tree.php' target='showpage2' style='position:absolute;top:0px;right:0px;'>Дерево фраз</a>";

/////////////////////////////////////////////////////////////
?>
<h2 class="header_h2">Текст для формирования у Beast дерева (иерархии распознавания) слов</h2>
Тексты призваны составить набор наиболее встречающихся слов и фраз - примитивов вербального восприятия.

<br><br>
<form  name="form" method="post" action="/pages/words.php" >
Текст, до ~1 мб чтобы не слишком долго обрабатывало:<br>
<textarea id="txt_list_id" name="txt_list" style="width:1000px;height:500px;"></textarea><br>



<input type='hidden' name='gogogo' value='1'>
<input  type="submit" name="submit" value="Добавить в сенсор слов и фраз">
</form>


</div>
</body>
</html>