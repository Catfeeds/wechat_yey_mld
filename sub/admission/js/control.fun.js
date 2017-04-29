$(function(){
	$('#Vcl_KeySignup').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_signup()   
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
	document.getElementById('Vcl_StuId').value=arrayToJson(a_data)
	dialog_confirm("确认通知选中幼儿监护人吗？<br/><br/>确认后：<br/>1. 幼儿监护人的微信将收到信息核验通知。<br/>2. 选中的幼儿报名信息将会进入等待信息核验模块。<br/>3. 本页面将会被刷新。<br/><br/>注：操作过程中，请不要关闭或刷新浏览器。",function (){document.getElementById('submit_form').submit();loading_show();});
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