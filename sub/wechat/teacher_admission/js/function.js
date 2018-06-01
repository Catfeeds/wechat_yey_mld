function audit_approve()
{
	Dialog_Confirm("真的要通过信息核验吗？",function(){
		Common_OpenLoading();
		document.getElementById("submit_form").submit();
	})
}
function audit_reject()
{
	$('#Vcl_FunName').val('AuditReject');
	Common_OpenLoading();
	document.getElementById("submit_form").submit();
}
function meet_submit()
{
	Dialog_Confirm("真的要提交入园互动结果吗？",function(){
		Common_OpenLoading();
		document.getElementById("submit_form").submit();
	})
}
