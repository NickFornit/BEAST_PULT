/*
<script Language="JavaScript" src="/ajax/ajax.js"></script>
var AJAX = new ajax_support('<?=$script_url?>',sent_request_mess);
AJAX.send_reqest();
function sent_request_mess(resOut)
{
alert(resOut);
}

function ajax_support(script_url,own_function):
script_url - ������ ����������� �������, ��������: '/sys/link_counter.php?ref='+ref+'&txt='+descr
own_function - ���� ������� ��� ������ ������ �� ������ (�� ������, � ������)
*/
function ajax_support(script_url,own_function)
{
	//alert(script_url);
var req;
var timer_id=0;

this.send_reqest=function ()
{ //alert(out_function_name);
this.do_reqest(script_url);
}


this.do_reqest=function (url) 
{
var brauser=0;
    // branch for native XMLHttpRequest object
    if (window.XMLHttpRequest) 
	{ 
     req = new XMLHttpRequest();
     brauser=1;   
    // branch for IE/Windows ActiveX version
    } 
	else 
	if (window.ActiveXObject) 
	{
        req = new ActiveXObject("Microsoft.XMLHTTP");
        brauser=1;        
    }

if (typeof(req) == 'undefined') 
{
//alert('Cannot create XMLHTTP instance.');
return false;
}

req.onreadystatechange = function(e) 
{
//timer_id = window.setTimeout("req.abort();", 5000);// ��������� � �������� ������
    
    if(req.readyState == 4) 
	{
//clearTimeout(timer_id);
        status = req.status; 
        // req.statusText; - �������� ������         
        // only if "OK"
if (req.status == 200) 
{
//alert(req.responseText);
if(typeof(own_function)!='function')
	{
//alert("�� ������� ������� ��� ������ ��������� (������ �������� ajax_support())");
return;
	}
own_function(req.responseText);

}
else
{			
// own_function("<error_ajax>");           //alert("�� ������� �������� ������:\n" + req.statusText);
}
} 
}
//alert(url);	

req.open("GET", url, true);

req.send(null);


}


}