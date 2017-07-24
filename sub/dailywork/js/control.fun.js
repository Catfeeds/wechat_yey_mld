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