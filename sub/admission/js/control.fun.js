$(function(){
	$('#Vcl_KeySignup').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_signup()   
	    }  
	}); 
	$('#Vcl_KeyWaitAudit').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_wait_audit()   
	    }  
	});  
	$('#Vcl_KeyAuditPass').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_audit_pass()   
	    }  
	});
	$('#Vcl_KeyMeetResult').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_meet_result()   
	    }  
	}); 
	$('#Vcl_KeyHealthWait').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_health_wait()   
	    }  
	}); 
	$('#Vcl_KeyInfoWait').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_info_wait()   
	    }  
	}); 
	$('#Vcl_KeyAdmission').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_admission()   
	    }  
	}); 
})
function search_for_signup()
{
	var fun='StudentSignupTable';
	var id='Vcl_KeySignup'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function search_for_wait_audit()
{
	var fun='WaitAuditTable';
	var id='Vcl_KeyWaitAudit'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function search_for_audit_pass()
{
	var fun='AuditPassTable';
	var id='Vcl_KeyAuditPass'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function search_for_meet_result()
{
	var fun='MeetResultTable';
	var id='Vcl_KeyMeetResult'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function search_for_health_wait()
{
	var fun='HealthWaitTable';
	var id='Vcl_KeyHealthWait'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function search_for_info_wait()
{
	var fun='InfoWaitTable';
	var id='Vcl_KeyInfoWait'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function search_for_Admission()
{
	var fun='AdmissionTable';
	var id='Vcl_KeyAdmission'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function select_all(obj)
{
	if(obj.checked)
	{
		for(var i=0;i<$('tbody input[type=checkbox]').length;i++)
		{
			obj=$('tbody input[type=checkbox]')[i]
			obj.checked=true;
		}
	}else{
		for(var i=0;i<$('tbody input[type=checkbox]').length;i++)
		{
			obj=$('tbody input[type=checkbox]')[i]
			obj.checked=false;
		}
	}
}
function select_submit()
{
	var a_data=[];
	for(var i=0;i<$('tbody input[type=checkbox]').length;i++)
	{
		obj=$('tbody input[type=checkbox]')[i]
		if (obj.checked)
		{
			a_data.push(obj.value);
		}
	}
	if(a_data.length==0)
	{
		dialog_message("请先选择报名信息！")
		return
	}
	document.getElementById('Vcl_FunName').value='SendAuditNotice';
	document.getElementById('Vcl_StuId').value=arrayToJson(a_data)
	dialog_confirm("确认通知选中幼儿监护人吗？<br/><br/>确认后：<br/>1. 幼儿监护人的微信将收到信息核验通知。<br/>2. 选中的幼儿报名信息将会进入“<b>等待信息核验</b>”模块。<br/>3. 本页面将会被刷新。<br/><br/>注：该操作不能撤销，请谨慎操作。",function (){document.getElementById('submit_form').submit();loading_show();});
}
function select_submit_reject()
{
	var a_data=[];
	for(var i=0;i<$('tbody input[type=checkbox]').length;i++)
	{
		obj=$('tbody input[type=checkbox]')[i]
		if (obj.checked)
		{
			a_data.push(obj.value);
		}
	}
	if(a_data.length==0)
	{
		dialog_message("请先选择报名信息！")
		return
	}
	document.getElementById('Vcl_StuId').value=arrayToJson(a_data)
	dialog_confirm("真的要不通过选中的幼儿报名吗？<br/><br/>确认后：幼儿监护人的报名信息状态将变为未通过。",function (){
		document.getElementById('Vcl_FunName').value='SignupReject';
		document.getElementById('submit_form').submit();
		loading_show();
	});
}
function meet_select_submit()
{
	var a_data=[];
	for(var i=0;i<$('tbody input[type=checkbox]').length;i++)
	{
		obj=$('tbody input[type=checkbox]')[i]
		if (obj.checked)
		{
			a_data.push(obj.value);
		}
	}
	if(a_data.length==0)
	{
		dialog_message("请先选择报名信息！")
		return
	}
	document.getElementById('Vcl_FunName').value='SendHealthNotice';
	document.getElementById('Vcl_StuId').value=arrayToJson(a_data)
	dialog_confirm("确认通知选中幼儿监护人进行幼儿体检吗？<br/><br/>确认后：<br/>1. 幼儿监护人的微信将收到体检通知。<br/>2. 选中的幼儿报名信息将会进入“<b>等待体检审核</b>”模块。<br/>3. 本页面将会被刷新。<br/><br/>注：该操作不能撤销，请谨慎操作。",function (){document.getElementById('submit_form').submit();loading_show();});
}
function audit_select_submit()
{
	var a_data=[];
	for(var i=0;i<$('tbody input[type=checkbox]').length;i++)
	{
		obj=$('tbody input[type=checkbox]')[i]
		if (obj.checked)
		{
			a_data.push(obj.value);
		}
	}
	if(a_data.length==0)
	{
		dialog_message("请先选择报名信息！")
		return
	}
	document.getElementById('Vcl_FunName').value='SendMeetNotice';
	document.getElementById('Vcl_StuId').value=arrayToJson(a_data)
	dialog_confirm("确认通知选中幼儿监护人吗？<br/><br/>确认后：<br/>1. 幼儿监护人的微信将收到见面通知。<br/>2. 选中的幼儿报名信息将会进入“<b>等待见面</b>”模块。<br/>3. 本页面将会被刷新。<br/><br/>注：该操作不能撤销，请谨慎操作。",function (){document.getElementById('submit_form').submit();loading_show();});
}
function health_select_submit()
{
	var a_data=[];
	for(var i=0;i<$('tbody input[type=checkbox]').length;i++)
	{
		obj=$('tbody input[type=checkbox]')[i]
		if (obj.checked)
		{
			a_data.push(obj.value);
		}
	}
	if(a_data.length==0)
	{
		dialog_message("请先选择报名信息！")
		return
	}
	document.getElementById('Vcl_FunName').value='SendFinishInfoNotice';
	document.getElementById('Vcl_StuId').value=arrayToJson(a_data)
	dialog_confirm("确认通知选中幼儿监护人进行幼儿信息完善吗？<br/><br/>确认后：<br/>1. 幼儿监护人的微信将收到体检通知。<br/>2. 监护人完善信息后，将会自动收到录取通知。<br/>3. 选中的幼儿报名信息将会进入“<b>等待完善信息</b>”模块。<br/>4. 本页面将会被刷新。<br/><br/>注：该操作不能撤销，请谨慎操作。",function (){document.getElementById('submit_form').submit();loading_show();});
}
function arrayToJson(o) {
    var r = [];
    if (typeof o == "string") return "\"" + o.replace(/([\'\"\\])/g, "\\$1").replace(/(\n)/g, "\\n").replace(/(\r)/g, "\\r").replace(/(\t)/g, "\\t") + "\"";
    if (typeof o == "object") {
      if (!o.sort) {
        for (var i in o)
          r.push(i + ":" + arrayToJson(o[i]));
        if (!!document.all && !/^\n?function\s*toString\(\)\s*\{\n?\s*\[native code\]\n?\s*\}\n?\s*$/.test(o.toString)) {
          r.push("toString:" + o.toString.toString());
        }
        r = "{" + r.join() + "}";
      } else {
        for (var i = 0; i < o.length; i++) {
          r.push(arrayToJson(o[i]));
        }
        r = "[" + r.join() + "]";
      }
      return r;
    }
    return o.toString();
  }
function select_submit_assign_class(obj)
{
	if (obj.value=='')
	{
		return
	}
	var a_data=[];
	for(var i=0;i<$('tbody input[type=checkbox]').length;i++)
	{
		obj=$('tbody input[type=checkbox]')[i]
		if (obj.checked)
		{
			a_data.push(obj.value);
		}
	}
	if(a_data.length==0)
	{
		dialog_message("请先选择报名信息！")
		return
	}
	document.getElementById('Vcl_StuId').value=arrayToJson(a_data)
	dialog_confirm("真的将的<b>"+a_data.length+"</b>名幼儿分配到<b>"+$('#assign .selected .text').html()+"</b>吗？<br/><br/>确认后：幼儿信息将移动至幼儿信息模块，不可撤销，请谨慎操作！",function (){
		document.getElementById('submit_form').submit();
		loading_show();
	},function(){
		$('#Vcl_ClassId').selectpicker('val','');//下拉框归位
	});
}
function setup_modify()
{	
	loading_show();
	$('#submit_form').submit();
}