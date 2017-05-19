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
	var fun='YeInfo';
	var id='Vcl_KeyYeInfo'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"OtherKey",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,key,encodeURIComponent(document.getElementById(id).value));    
}
function download_pdf(url)
{
    dialog_message("下载PDF所用时间较长，<br/>请不要有任何操作，耐心等待。<br/>点击“确定”后开始下载...",function(){ 
		window.open(url,'_blank');
	})  
}
function class_modify()
{
	var val = $('#Vcl_Grade').val();
    if (val.length == 0) {
        dialog_message('请选择年级！')
        return
    }
    var val = $('#Vcl_ClassName').val();
    if (val.length == 0) {
        dialog_message('班级名称不能为空！')
        return
    }
    loading_show();
	$('#submit_form').submit();
}
function class_delete(id) {
    dialog_confirm('真的要删除这个班级吗？删除后不能恢复，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=ClassDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('YeClassTable')
        	}        	
        })
    })
}
function stu_change_class(id,name,class_name) {
	var a_arr=[];
	a_arr.push('<select name="Vcl_ClassId" id="Vcl_ClassId" class="form-control" style="width:auto">');
	a_arr.push('<option value="">请选择班级</option>');
	for(var i=0;i<a_class_list.length;i++)
	{
		var temp=a_class_list[i];
		a_arr.push('<option value="'+temp[0]+'">'+temp[1]+'</option>');
	}
	a_arr.push('</select>');
    dialog_confirm('幼儿姓名：<b>'+name+'</b><br/>原始班级名称：<b>'+class_name+'</b><br/><br/>请选择调整后的班级，之后请按确认按钮完成调班。<br/><br/>'+a_arr.join('\n'),function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=StuChangeClass'; //后台方法
        data = data + '&id=' + id+'&classid='+$('#Vcl_ClassId').val();
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
				$('.small_loading').fadeOut(100);
				dialog_success('调班成功！',function(){
					table_refresh('YeInfo')
				})
        	}        	
        })
    })
}