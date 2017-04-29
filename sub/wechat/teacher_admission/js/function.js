function audit_approve()
{
	Dialog_Confirm("真的要通过信息核验吗？",function(){
		Common_OpenLoading();
		document.getElementById("submit_form").submit();
	})
}
