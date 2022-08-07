<?
/*  Индикация базовых контекстов
include_once($_SERVER['DOCUMENT_ROOT']."/pult_base_contexts.php");
*/


?><br>
<div style="position:relative;">
<div style="margin-bottom:10px;"><b>Состояние базовых контекстов:</b></div>
<span id='context_1' class='context' >Пищевой</span>
<span id='context_2' class='context' >Поиск</span>
<span id='context_3' class='context' >Игра</span>
<span id='context_4' class='context' >Гон</span>
<span id='context_5' class='context' >Защита</span>
<span id='context_6' class='context' >Лень</span>
<span id='context_7' class='context' >Ступор</span>
<span id='context_8' class='context' >Страх</span>
<span id='context_9' class='context' >Агрессия</span>
<span id='context_10' class='context' >Злость</span>
<span id='context_11' class='context' >Доброта</span>
<span id='context_12' class='context' >Сон</span>

<div style="position:absolute;top:0px;right:0px;color:#66B15C;"><b>
<?
switch($stages)
{
case 0:
echo "Нулевая стадия развития: до рождения.";
	break;
case 1:
echo "ПЕРВАЯ стадия развития: рождение Beast, условные рефлексы.";
	break;
case 2:
echo "ВТОРАЯ стадия развития: Формирование базовых автоматизмов.";
	break;
case 3:
echo "ТРЕТЬЯ стадия развития: Период подражания.";
	break;
case 4:
echo "ЧЕТВЕРТАЯ стадия развития: Период преступной инициативы.";
	break;
case 5:
echo "ПЯТАЯ стадия развития: Инициативное и творческое развитие.";
	break;
}
?>
</b></div>
</div>

<script>
var cf_color = {
1:"#E4FFEB",
2:"#FFE8FF",
3:"#FFE8E8",
4:"#FFC9D0",
5:"#CCC9FF",
6:"#D0CCD0",
7:"#FFFFD3",
8:"#FFC2C5",
9:"#FFA7DD",
10:"#FFA7DD",
11:"#C5F5FF",
12:"#D0CCD0"
}; 

for(i=1;i<13;i++)
{
document.getElementById("context_"+i).style.backgroundColor=cf_color[i];
}


function get_context_info(i_str)// в /pult_gomeo.php
{ 
//alert(i_str);
var pars=i_str.split("|");    //alert(pars[1]);
//alert("! "+pars[0]+" ! "+pars[1]+" ! "+pars[2]); 
for(i=0;i<pars.length;i++) // bcntx_1
{
if(pars[i].length<3)
	continue;
var p=pars[i].split(";");
var id=p[0];
var val=p[1];
set_active_id(id,val);
}
}

function set_active_id(id,set)
{  
//	if(id==1)alert(id+" | "+set);
if(set==1)
document.getElementById("context_"+id).style.boxShadow="0px 0px 6px 6px "+LightenDarkenColor(cf_color[id],-20);
else
if(document.getElementById("context_"+id))
document.getElementById("context_"+id).style.boxShadow="";
} 
//set_active_id(4,1);




</script>