$(function(){
	get_waiting_number(120101);
	get_waiting_number(120103);
	get_waiting_number(120105);
	get_waiting_number(120109);
})
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
function output(state)
{
	var data='Ajax_FunName=Output';//后台方法
    data=data+'&state='+state;
    loading_show();
    $.getJSON("include/bn_submit.switch.php",data,function (json){
    	loading_hide();
    	if (json.success==1)
    	{
    		window.open(json.url,'_blank')
    	}else{
    		dialog_error('导出失败，请重试，或与管理员联系！')
    	}
	})
}
function get_waiting_number(id)
{
	var data = 'Ajax_FunName=getWaitRead'+id; //后台方法
    $.getJSON("include/bn_submit.switch.php", data, function (json) {
    	//发送ajax到后台获取数值
    	if(json.number>0)
    	{
    		$('#sub_nav_'+id).show()
    		$('#sub_nav_'+id).html(json.number)
    	}else{
    		$('#sub_nav_'+id).hide()
    	}
	})
}