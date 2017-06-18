$(function(){
	$('#Vcl_KeyYeInfo').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_yeinfo()   
	    }  
	});
})
function search_for_yeinfo()
{
	var fun='NoticeCenterTargetList';
	var id='Vcl_KeyYeInfo'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"OtherKey",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,key,encodeURIComponent(document.getElementById(id).value));    
}
function check_remark(fData)
{
	var intLength=0 
    for (var i=0;i<fData.length;i++) 
    { 
        if ((fData.charCodeAt(i) < 0) || (fData.charCodeAt(i) > 255)) 
            intLength=intLength+1
        else 
            intLength=intLength+1
    }
	if (intLength>80)
	{
		return false;
	}else{
		return true;
	}
}
function send_notice_multiple()
{
	if (document.getElementById("Vcl_First").value == "") {
		dialog_message("标题不能为空！")
		return
	}
	if (document.getElementById("Vcl_Remark").value == "") {
		dialog_message("内容不能为空！")
		return
	}
	if(check_remark(document.getElementById("Vcl_Remark").value)==false)
	{
		dialog_message("内容不能超过80个字！")
		return
	}
	document.getElementById ('Vcl_Comment').value=encodeURIComponent(ue.getContent())
	dialog_confirm("确认要群发通知吗？<br/><br/>确认后：<br/>1. 所有微信绑定过的幼儿家长将陆续收到微信通知。<br/>2. 发送后，可以在“<b>通知记录</b>”模块中查看历史记录。<br/><br/>注：该操作不能撤销，请谨慎操作。",function (){document.getElementById('submit_form').submit();loading_show();});
}

