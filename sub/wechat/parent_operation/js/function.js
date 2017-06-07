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
