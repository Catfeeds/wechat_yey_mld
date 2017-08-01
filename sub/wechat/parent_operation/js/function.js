function submit_binding()
{
	if (document.getElementById("Vcl_Name").value=="")
	{
		Dialog_Message("幼儿信息的 [幼儿姓名] 不能为空！",function(){
			document.getElementById("Vcl_Name").focus()
		})		
		return
	}
	if (document.getElementById("Vcl_ID").value=="")
	{
		Dialog_Message("幼儿信息的 [证件号码] 不能为空！",function(){
			document.getElementById("Vcl_ID").focus()
		})		
		return
	}
	if (document.getElementById("Vcl_JhName").value=="")
	{
		Dialog_Message("家长信息的 [姓名] 不能为空！",function(){
			document.getElementById("Vcl_JhName").focus()
		})		
		return
	}
	if (document.getElementById("Vcl_JhPhone").value=="")
	{
		Dialog_Message("家长信息的 [手机号] 不能为空！",function(){
			document.getElementById("Vcl_JhPhone").focus()
		})		
		return
	}	
	Common_OpenLoading();
	document.getElementById("submit_form").submit();	 
}
function survey_answer_submit()
{
	Common_OpenLoading();
	document.getElementById("submit_form").submit();	
}
function askforleave_submit()
{
	if (document.getElementById("Vcl_StartDate").value=="")
	{
		Dialog_Message("[请假日期] 不能为空！",function(){
		})		
		return
	}
	var s_startdate=document.getElementById("Vcl_StartDate").value
	var s_currentdate=document.getElementById("Vcl_CurrentDate").value
	if (new Date(s_startdate.replace(/-/g,"\/"))<new Date(s_currentdate.replace(/-/g,"\/")))
	{
		Dialog_Message("[请假日期] 必须大于或等于今天！",function(){
		})		
		return
	}
	if (document.getElementById("Vcl_EndDate").value=="")
	{
		Dialog_Message("[请假天数] 不能为空！",function(){
		})		
		return
	}
	if (!(parseInt(document.getElementById("Vcl_EndDate").value)>0))
	{
		Dialog_Message("[请假天数] 必须大于0！",function(){
		})		
		return
	}
	if (document.getElementById("Vcl_Comment").value=="")
	{
		Dialog_Message("[简述原因] 不能为空！",function(){
		})		
		return
	}	
	Dialog_Confirm('请确认是否提交请假信息！',function(){
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	});
}
function askforleave_cancel(id)
{
    Dialog_Confirm('真的要取消请假吗？',function(){
    	Common_OpenLoading();
    	var data = 'Ajax_FunName=ParentAskForLeaveCancel'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("../include/bn_submit.switch.php", data, function (json) {
        	window.location.href="askforleave_record.php?"+Date.parse(new Date());  	
        })
    })
}
