<?
/*  Удалить память, зависимую от данной стадии. (AJAX)
/lib/cliner_stadies_memory.php 

*/
header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_ALL, "ru_RU.UTF-8");
mb_http_input('UTF-8');
mb_http_output('UTF-8');
mb_internal_encoding("UTF-8");

$next_level=$_GET['next_level'];

switch ($next_level){
  case 0: // до рождения
    cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/reflex_tree.txt");
    cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/condition_reflexes.txt");
    cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/trigger_stimuls_images.txt");
    cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/base_style_images.txt");
    break;
  case 1: // после рождения
    cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/condition_reflexes.txt");
    cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_reflex/trigger_stimuls_images.txt");
    break;
  case 2: // автоматизмы
  case 3:
    cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/automatizm_images.txt");
    cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/automatizm_tree.txt");
    cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/action_images.txt");
    cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/verbal_images.txt");
    break;
}
cliner_all_psy();

function cliner_all_psy(){
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/cerebellum_reflex.txt");
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/trigger_and_actions.txt");
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/action_images_mental.txt");
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/episod_memory.txt");
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/goNext.txt");
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/importance.txt");
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/purpose_images.txt");
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/rules.txt");
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/situation_images.txt");
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/trigger_and_actions_mental.txt");
  cliner_file($_SERVER["DOCUMENT_ROOT"]."/memory_psy/understanding_tree.txt");
}

///////////////////////////////////////////////////
function cliner_file($file)
{
$hf=fopen($file,"wb+");
if($hf)
{
fwrite($hf,"",0);
fclose($hf);
return 1;
}
return 0;
}
//////////////////////////////////
?>