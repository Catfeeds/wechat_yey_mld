$(function(){
	$('#Vcl_KeyYeInfo').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_yeinfo()   
	    }  
	});
	$('#Vcl_KeyUser').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_user()   
	    }  
	});
})
function search_for_user()
{
	var fun='NoticeCenterTeachcerTargetList';
	var id='Vcl_KeyUser'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value));    
}
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
	if (document.getElementById("Vcl_Type").value == "") {
		dialog_message("请选择通知类型！")
		return
	}
	if (document.getElementById("Vcl_Remark").value == "") {
		dialog_message("内容不能为空！")
		return
	}
	if (document.getElementById("Vcl_Target").value == "") {
		dialog_message("请选择发送对象！")
		return
	}
	if(check_remark(document.getElementById("Vcl_Remark").value)==false)
	{
		dialog_message("内容不能超过80个字！")
		return
	}
	document.getElementById ('Vcl_Comment').value=encodeURIComponent(ue.getContent())
	dialog_confirm("确认要群发通知吗？<br/><br/>确认后：<br/>1. 所有微信绑定过的幼儿家长将陆续收到微信通知。<br/>2. 发送后，可以在“<b>家长通知记录</b>”模块中查看历史记录。<br/><br/>注：该操作不能撤销，请谨慎操作。",function (){document.getElementById('submit_form').submit();loading_show();});
}
function teacher_send_notice_multiple()
{
	if (document.getElementById("Vcl_First").value == "") {
		dialog_message("标题不能为空！")
		return
	}
	if (document.getElementById("Vcl_Type").value == "") {
		dialog_message("请选择通知类型！")
		return
	}
	if (document.getElementById("Vcl_Remark").value == "") {
		dialog_message("内容不能为空！")
		return
	}
	if (document.getElementById("Vcl_Target").value == "") {
		dialog_message("请选择发送对象！")
		return
	}
	if(check_remark(document.getElementById("Vcl_Remark").value)==false)
	{
		dialog_message("内容不能超过80个字！")
		return
	}
	document.getElementById ('Vcl_Comment').value=encodeURIComponent(ue.getContent())
	dialog_confirm("确认要群发通知吗？<br/><br/>确认后：<br/>1. 所有微信绑定过的教师将陆续收到微信通知。<br/>2. 发送后，可以在“<b>教师通知记录</b>”模块中查看历史记录。<br/><br/>注：该操作不能撤销，请谨慎操作。",function (){document.getElementById('submit_form').submit();loading_show();});
}
function send_notice_single()
{
	if (document.getElementById("Vcl_First").value == "") {
		dialog_message("标题不能为空！")
		return
	}
	if (document.getElementById("Vcl_Type").value == "") {
		dialog_message("请选择通知类型！")
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
	dialog_confirm("确认要单发通知吗？<br/><br/>确认后：<br/>1. 微信绑定的幼儿家长将收到微信通知。<br/>2. 发送后，可以在“<b>家长通知记录</b>”模块中查看历史记录。<br/><br/>注：该操作不能撤销，请谨慎操作。",function (){document.getElementById('submit_form').submit();loading_show();});
}
function teacher_send_notice_single()
{
	if (document.getElementById("Vcl_First").value == "") {
		dialog_message("标题不能为空！")
		return
	}
	if (document.getElementById("Vcl_Type").value == "") {
		dialog_message("请选择通知类型！")
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
	dialog_confirm("确认要单发通知吗？<br/><br/>确认后：<br/>1. 微信绑定的教师将收到微信通知。<br/>2. 发送后，可以在“<b>教师通知记录</b>”模块中查看历史记录。<br/><br/>注：该操作不能撤销，请谨慎操作。",function (){document.getElementById('submit_form').submit();loading_show();});
}
function notice_type_modify()
{
	var val = $('#Vcl_Number').val();
    if (val.length == 0) {
        dialog_message('显示顺序不能为空！')
        return
    }
	var val = $('#Vcl_Name').val();
    if (val.length == 0) {
        dialog_message('类型名称不能为空！')
        return
    }	
    loading_show();
	$('#submit_form').submit();
}
function notice_type_delete(id) {
    dialog_confirm('真的要删除这个通知类型吗？',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=NoticeTypeDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('NoticeTypeTable')
        	}        	
        })
    })
}