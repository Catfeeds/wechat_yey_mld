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
function dailywork_workflow_submit(a_id,a_must,a_name)
{
	for(var i=0;i<a_id.length;i++)
	{
		if (a_must[i]==1)
		{
			if ($('#Vcl_'+a_id[i]).val()=='')
			{
				Dialog_Message("["+a_name[i]+"] 不能为空！",function(){
					document.getElementById("Vcl_"+a_id[i]).focus()
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
function dailywork_workflow_pass_submit(a_id,a_must,a_name)
{
	for(var i=0;i<a_id.length;i++)
	{
		if (a_must[i]==1)
		{
			if ($('#Vcl_'+a_id[i]).val()=='')
			{
				Dialog_Message("["+a_name[i]+"] 不能为空！",function(){
					document.getElementById("Vcl_"+a_id[i]).focus()
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
function dailywork_workflow_return_submit()
{
	if ($('#Vcl_Reason').val()=='')
	{
		Dialog_Message("[退回修改/不通过 原因] 不能为空！",function(){
			document.getElementById("Vcl_Reason").focus()
		})		
		return
	}
	Dialog_Confirm('真的要退回修改吗？',function(){
		$('#Vcl_Type').val('Return');
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	});
}
function choose_credential_image(token)
{
	wx.chooseImage({
	    count: 1, // 默认9
	    sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
	    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
	    success: function (res) {
	    	var localids=res.localIds;
	    	wx.uploadImage({
	    	    localId:localids.toString(), // 需要上传的图片的本地ID，由chooseImage接口获得
	    	    isShowProgressTips: 1, // 默认为1，显示进度提示
	    	    success: function (res) {
	    	        var serverId = res.serverId; // 返回图片的服务器端ID
	    	        $('#level_photo').attr('src','http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId)	    	        
	    	        $('#Vcl_Picture').val('http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId)
	    	    },
	    	    fail:function(res){
	    	    	Dialog_Message('上传失败，请重试！');
			   }
	    	});
	    }
	});
}
function survey_answer_submit()
{
	Common_OpenLoading();
	document.getElementById("submit_form").submit();	
}
