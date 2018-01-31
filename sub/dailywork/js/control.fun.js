$(function(){

})
function payroll_release()
{	
    var val = $('#Vcl_Date').val();
    if (val.length == 0) {
        dialog_message('对不起，工资日期不能为空！')
        return
    }
	dialog_confirm('确认要发布工资信息吗！<br/><br/>确认后：<br/>1. 将不能修改。<br/><br/>注：该操作不能撤销，请谨慎操作。',function(){
		loading_show();
		$('#submit_form').submit();
	})
}
function recipe_input()
{
	dialog_confirm('请注意，此操作需要花费大约5-10分钟！<br/>为确保数据完整，请在结束前不要关闭或刷新本页面。<br/>请耐心等待。',function(){
		loading_show();
		$('#submit_form').submit()
	})
}
function cuisine_delete(id) {
    dialog_confirm('真的要删除这个菜肴吗？<br/>删除后不能恢复，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=CuisineDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text);
        	}else{
        		table_refresh('CuisineTable');
        	}        	
        })
    })
}
function recipe_modify()
{
	var val = $('#Vcl_ChangeId').val();
    if (val.length == 0) {
        dialog_message('请选择需要更换的菜肴！')
        return
    }
    loading_show();
	$('#submit_form').submit();
}