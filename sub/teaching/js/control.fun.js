$(function(){
	$('#Vcl_KeyWeiTeach').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_wei_teach()   
	    }  
	}); 
	$('ins').click(function(){
		//先获得自己是否选中
		var parent=this.parentNode
		var own=$(parent).find('input')
		own=own[0]
		//将是他的子，都选上
		if (own.checked) {
			$(this.parentNode.parentNode).find('.sub_role').iCheck('check')
			uncheck_parent(this,true)
		}else{
			$(this.parentNode.parentNode).find('.sub_role').iCheck('uncheck')
			uncheck_parent(this,true)
		}		
	})
})
function uncheck_parent(obj,loop)
{
	try{
	var father=$(obj.parentNode.parentNode.parentNode).children('.icheckbox_square-blue').children('input')//获取父选项
	var bother=$(obj.parentNode.parentNode.parentNode).children('.sub_role')//获取同级的DIV
	var b=false
	var b2=true
	for(var i=0;i<bother.length;i++)
	{
		var temp=$(bother[i]).children('.icheckbox_square-blue').children('input')
		if (temp[0].checked)//检验每个并列的是否被选中
		{
			b=true
		}else{
			b2=false
		}
	}
	if (b==true)
	{
		$(father[0]).iCheck('uncheck')//如果并列的选项都未选，那么取消父选项的勾选
	}
	if (b2==true)
	{
		$(father[0]).iCheck('check')//如果并列的都选中，那么勾选父选项
	}
	if (loop)
	{
		uncheck_parent(father[0],false)//在往上看一级的父选项
	}
	} catch (e) {
    }
}
function search_for_wei_teach()
{
	var fun='WeiTeachTable';
	var id='Vcl_KeyWeiTeach'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function wei_teach_add_submit()
{
	if (document.getElementById("Vcl_Title").value == "") {
		dialog_message("标题不能为空！")
		return
	}
	if (ue.getContentTxt() == "") {
		dialog_message("微教学内容简述不能为空！")
		return
	}
	if (document.getElementById("Vcl_Video").value == "") {
		dialog_message("教学视频地址不能为空！")
		return
	}	
	document.getElementById ('Vcl_Comment').value=encodeURIComponent(ue.getContent())
	document.getElementById('submit_form').submit();
	loading_show();
}
function wei_teach_delete(id) {
    dialog_confirm('真的要删除这个微教学吗？删除后不能恢复，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=WeiTeachDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('WeiTeachTable')
        	}        	
        })
    })
}
function wei_teach_review(id)
{
	dialog_confirm('请使用微信扫描下方二维码进行预览：<br/><br/><img style="width:50%;margin-left:25%" src="wei_teach_review_qrcode.php?id='+id+'"/>');
}
function wei_teach_release()
{	
	dialog_confirm('确认要发布微教学吗！<br/><br/>确认后：<br/>1. 此微教学将不能被修改。<br/><br/>注：该操作不能撤销，请谨慎操作。',function(){
		loading_show();
		$('#submit_form').submit();	
	})
}