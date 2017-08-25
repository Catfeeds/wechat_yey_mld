function dailywork_workflow_new_change_check(obj,id,value)
{
	var input=$('#Vcl_'+id).val();
	if($(obj).is(':checked'))
	{		
		input=input.replace('%'+value+'%','');
		$('#Vcl_'+id).val(input+'%'+value+'%')
	}else{
		input=input.replace('%'+value+'%','');
		$('#Vcl_'+id).val(input)
	}
}
function dailywork_workflow_submit(a_must,a_name)
{
	for(var i=0;i<a_must.length;i++)
	{
		if (a_must[i]==1)
		{
			if ($('#Vcl_'+(i+1)).val()=='')
			{
				Dialog_Message("["+a_name[i]+"] 不能为空！",function(){
					document.getElementById("Vcl_"+(i+1)).focus()
				})		
				return
			}
		}
	}
	Dialog_Confirm('真的要提交工作流程申请吗？',function(){
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	});
}
function dailywork_workflow_pass_submit(a_must,a_name)
{
	for(var i=0;i<a_must.length;i++)
	{
		if (a_must[i]==1)
		{
			if ($('#Vcl_'+(i+1)).val()=='')
			{
				Dialog_Message("["+a_name[i]+"] 不能为空！",function(){
					document.getElementById("Vcl_"+(i+1)).focus()
				})		
				return
			}
		}
	}
	Dialog_Confirm('真的通过审批吗？',function(){
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	});
}
function dailywork_workflow_reject_submit()
{
	if ($('#Vcl_Reason').val()=='')
	{
		Dialog_Message("[退回修改/不通过 原因] 不能为空！",function(){
			document.getElementById("Vcl_Reason").focus()
		})		
		return
	}
	Dialog_Confirm('真的要不通过审批吗？<br/>不通过后，本申请将退回申请人处并不等再次修改提交。',function(){
		$('#Vcl_Type').val('Reject')
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	});
}
