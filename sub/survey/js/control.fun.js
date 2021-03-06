$(function(){
	$('#Vcl_KeyParentSurveyManage').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_parent_survey_manage()   
	    }  
	}); 
	$('#Vcl_KeyParentSurveyManageProgress').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_parent_survey_manage_progress()   
	    }  
	}); 
	$('#Vcl_KeyParentSurveyManageAnswered').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_parent_survey_manage_answered()   
	    }  
	}); 
	$('#Vcl_KeyTeacherSurveyManage').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_teacher_survey_manage()   
	    }  
	}); 
	$('#Vcl_KeyTeacherSurveyManageProgress').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_teacher_survey_manage_progress()   
	    }  
	}); 
	$('#Vcl_KeyTeacherSurveyManageAnswered').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_teacher_survey_manage_answered()   
	    }  
	}); 
	$('#Vcl_KeyAppraiseManage').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_appraise_manage()   
	    }  
	}); 
	$('#Vcl_KeyAppraiseManageResult').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_appraise_manage_result()   
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
function search_for_parent_survey_manage_progress()
{
	var fun='ParentSurveyManageProgress';
	var id='Vcl_KeyParentSurveyManageProgress'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+$.cookie(fun+"Key")+"OtherKey",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,key,encodeURIComponent(document.getElementById(id).value));    
}
function search_for_teacher_survey_manage_progress()
{
	var fun='TeacherSurveyManageProgress';
	var id='Vcl_KeyTeacherSurveyManageProgress'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+$.cookie(fun+"Key")+"OtherKey",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,key,encodeURIComponent(document.getElementById(id).value));    
}
function search_for_parent_survey_manage_answered()
{
	var fun='ParentSurveyManageAnswered';
	var id='Vcl_KeyParentSurveyManageAnswered'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+$.cookie(fun+"Key")+"OtherKey",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,key,encodeURIComponent(document.getElementById(id).value));    
}
function search_for_teacher_survey_manage_answered()
{
	var fun='TeacherSurveyManageAnswered';
	var id='Vcl_KeyTeacherSurveyManageAnswered'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+$.cookie(fun+"Key")+"OtherKey",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,key,encodeURIComponent(document.getElementById(id).value));    
}
function search_for_appraise_manage_result()
{
	var fun='AppraiseManageResult';
	var id='Vcl_KeyAppraiseManageResult'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+$.cookie(fun+"Key")+"OtherKey",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,key,encodeURIComponent(document.getElementById(id).value));    
}
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
function search_for_parent_survey_manage()
{
	var fun='ParentSurveyManage';
	var id='Vcl_KeyParentSurveyManage'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function search_for_teacher_survey_manage()
{
	var fun='TeacherSurveyManage';
	var id='Vcl_KeyTeacherSurveyManage'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function parent_survey_manage_delete(id) {
    dialog_confirm('真的要删除这个问卷吗？删除后不能恢复，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=ParentSurveyManageDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('ParentSurveyManage')
        	}        	
        })
    })
}
function teacher_survey_manage_delete(id) {
    dialog_confirm('真的要删除这个问卷吗？删除后不能恢复，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=TeacherSurveyManageDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('TeacherSurveyManage')
        	}        	
        })
    })
}
function parent_survey_manage_end(id) {
    dialog_confirm('确认要结束这个问卷吗？<br/><br/>确认后：<br/>1. 所有未进行问卷的对象将不能再答题。<br/>2. 结束后将无法再次开启。<br/><br/>注：该操作不能撤销，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=ParentSurveyManageEnd'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('ParentSurveyManage')
        	}        	
        })
    })
}
function teacher_survey_manage_end(id) {
    dialog_confirm('确认要结束这个问卷吗？<br/><br/>确认后：<br/>1. 所有未进行问卷的对象将不能再答题。<br/>2. 结束后将无法再次开启。<br/><br/>注：该操作不能撤销，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=TeacherSurveyManageEnd'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('TeacherSurveyManage')
        	}        	
        })
    })
}
function parent_survey_manage_question_delete(id) {
    dialog_confirm('真的要删除这个问题吗？删除后不能恢复，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=ParentSurveyManageQuestionDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('ParentSurveyManageQuestion')
        	}        	
        })
    })
}
function teacher_survey_manage_question_delete(id) {
    dialog_confirm('真的要删除这个问题吗？删除后不能恢复，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=TeacherSurveyManageQuestionDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('TeacherSurveyManageQuestion')
        	}        	
        })
    })
}
function parent_survey_manage_copy(id) {
    dialog_confirm('确认要复制这个问卷吗？<br/><br/>确认后：<br/>1. 将创建一个未发布的问卷副本。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=ParentSurveyManageCopy'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('ParentSurveyManage')
        	}        	
        })
    })
}
function teacher_survey_manage_copy(id) {
    dialog_confirm('确认要复制这个问卷吗？<br/><br/>确认后：<br/>1. 将创建一个未发布的问卷副本。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=TeacherSurveyManageCopy'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('TeacherSurveyManage')
        	}        	
        })
    })
}
function parent_survey_manage_modify()
{	
    var val = $('#Vcl_Title').val();
    if (val.length == 0) {
        dialog_message('对不起，问卷标题不能为空！')
        return
    }
	loading_show();
	$('#submit_form').submit();
}
function teacher_survey_manage_modify()
{	
    var val = $('#Vcl_Title').val();
    if (val.length == 0) {
        dialog_message('对不起，问卷标题不能为空！')
        return
    }
	loading_show();
	$('#submit_form').submit();
}
function parent_survey_manage_question_modify()
{	
    var val = $('#Vcl_Question').val();
    if (val.length == 0) {
        dialog_message('对不起，题目不能为空！')
        return
    }
	if ($('#Vcl_Type').val()=='3' || $('#Vcl_Type').val()=='4')
	{
		
	}else{
		var val = $('#Vcl_Option_1').val();
	    if (val.length == 0) {
	        dialog_message('对不起，选项A不能为空！')
	        return
	    }
	    var val = $('#Vcl_Option_2').val();
	    if (val.length == 0) {
	    	dialog_message('对不起，选项B不能为空！')
	        return
	    }
	}    
	loading_show();
	$('#submit_form').submit();
}
function teacher_survey_manage_question_modify()
{	
    var val = $('#Vcl_Question').val();
    if (val.length == 0) {
        dialog_message('对不起，题目不能为空！')
        return
    }
	if ($('#Vcl_Type').val()=='3' || $('#Vcl_Type').val()=='4')
	{
		
	}else{
		var val = $('#Vcl_Option_1').val();
	    if (val.length == 0) {
	        dialog_message('对不起，选项A不能为空！')
	        return
	    }
	    var val = $('#Vcl_Option_2').val();
	    if (val.length == 0) {
	    	dialog_message('对不起，选项B不能为空！')
	        return
	    }
	}    
	loading_show();
	$('#submit_form').submit();
}
function parent_survey_manage_release()
{	
    var val = $('#Vcl_First').val();
    if (val.length == 0) {
        dialog_message('对不起，微信提醒标题不能为空！')
        return
    }
	var val = $('#Vcl_Remark').val();
    if (val.length == 0) {
        dialog_message('对不起，微信提醒内容不能为空！')
        return
    }
	dialog_confirm('确认要发布问卷吗！<br/><br/>确认后：<br/>1. 所有问卷对象的幼儿家长将陆续收到微信问卷提醒。<br/>2. 此问卷将不能被修改。<br/><br/>注：该操作不能撤销，请谨慎操作。',function(){
		loading_show();
		$('#submit_form').submit();	
	})
}
function teacher_survey_manage_release()
{	
    var val = $('#Vcl_First').val();
    if (val.length == 0) {
        dialog_message('对不起，微信提醒标题不能为空！')
        return
    }
	var val = $('#Vcl_Remark').val();
    if (val.length == 0) {
        dialog_message('对不起，微信提醒内容不能为空！')
        return
    }
	dialog_confirm('确认要发布问卷吗！<br/><br/>确认后：<br/>1. 所有问卷对象将陆续收到微信问卷提醒。<br/>2. 此问卷将不能被修改。<br/><br/>注：该操作不能撤销，请谨慎操作。',function(){
		loading_show();
		$('#submit_form').submit();	
	})
}
function parent_survey_manage_get_progress(id)
{
	//window.alert(id);
    var data='Ajax_FunName=ParentSurveyManageGetProgress&id='+id;//后台方法
    $.getJSON("include/bn_submit.switch.php",data,function (json){
		$('#status').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+json.status);
    })  
}
function teacher_survey_manage_get_progress(id)
{
	//window.alert(id);
    var data='Ajax_FunName=TeacherSurveyManageGetProgress&id='+id;//后台方法
    $.getJSON("include/bn_submit.switch.php",data,function (json){
		$('#status').html('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+json.status);
    })  
}
function parent_survey_manage_remember(id) {
    dialog_confirm('确认要发送再次提醒吗！<br/><br/>确认后：<br/>1. 所有未完成问卷的幼儿家长将陆续收到微信问卷提醒。<br/><br/>注：该操作不能撤销，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=ParentSurveyManageRemember'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		$('.small_loading').fadeOut(100);
        		dialog_success(json.text)
        	}        	
        })
    })
}
function teacher_survey_manage_remember(id) {
    dialog_confirm('确认要发送再次提醒吗！<br/><br/>确认后：<br/>1. 所有未完成问卷的教师将陆续收到微信问卷提醒。<br/><br/>注：该操作不能撤销，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=TeacherSurveyManageRemember'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		$('.small_loading').fadeOut(100);
        		dialog_success(json.text)
        	}        	
        })
    })
}
function search_for_appraise_manage()
{
	var fun='AppraiseManage';
	var id='Vcl_KeyAppraiseManage'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function appraise_manage_modify()
{	
    var val = $('#Vcl_Title').val();
    if (val.length == 0) {
        dialog_message('对不起，问卷标题不能为空！')
        return
    }
	loading_show();
	$('#submit_form').submit();
}
function appraise_manage_delete(id) {
    dialog_confirm('真的要删除这个问卷吗？删除后不能恢复，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=AppraiseManageDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('AppraiseManage')
        	}        	
        })
    })
}
function appraise_manage_release(id) {
	dialog_confirm('真的要发布这个问卷吗？<br/>发布后不能修改，请谨慎操作。',function(){
		$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=AppraiseManageRelease'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('AppraiseManage')
        	}      	
        })
    })
}
function appraise_manage_close(id) {
    dialog_confirm('真的要关闭这个问卷吗？',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=AppraiseManageClose'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('AppraiseManage')
        	}        	
        })
    })
}
function appraise_manage_open(id) {
    dialog_confirm('真的要开放这个问卷吗？',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=AppraiseManageOpen'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('AppraiseManage')
        	}        	
        })
    })
}
function appraise_manage_question_modify()
{	
    var val = $('#Vcl_Question').val();
    if (val.length == 0) {
        dialog_message('对不起，题目不能为空！')
        return
    }
	if ($('#Vcl_Type').val()=='3' || $('#Vcl_Type').val()=='4')
	{
		
	}else{
		var val = $('#Vcl_Option_1').val();
	    if (val.length == 0) {
	        dialog_message('对不起，选项A不能为空！')
	        return
	    }
	    var val = $('#Vcl_Option_2').val();
	    if (val.length == 0) {
	    	dialog_message('对不起，选项B不能为空！')
	        return
	    }
	}    
	loading_show();
	$('#submit_form').submit();
}
function appraise_manage_question_delete(id) {
    dialog_confirm('真的要删除这个问题吗？删除后不能恢复，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=AppraiseManageQuestionDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('AppraiseManageQuestion')
        	}        	
        })
    })
}
function appraise_manage_makeqrcode()
{
    var val = $('#Vcl_ClassId').val();
    if (val.length == 0) {
        dialog_message('请选择班级名称！')
        return
    }
	loading_show();
	$('#submit_form').submit();
}
function appraise_manage_copy(id) {
    dialog_confirm('确认要复制这个问卷吗？<br/><br/>确认后：<br/>1. 将创建一个未发布的问卷副本。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=AppraiseManageCopy'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('AppraiseManage')
        	}        	
        })
    })
}