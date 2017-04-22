function info_modify()
{
	var val = $('#Vcl_Name').val();
    if (val.length == 0) {
        dialog_message(Language['Message009'])
        return
    }
    loading_show();
	$('#submit_form').submit();
}
function password_modify()
{	
	var val = $('#Vcl_OldPassword').val();
    if (val.length == 0) {
        dialog_message(Language['Message012'])
        return
    }
    var val = $('#Vcl_Password').val();
    if (val.length == 0) {
        dialog_message(Language['Message010'])
        return
    }
    if (val.length < 6) {
        dialog_message(Language['Message007'])
        return
    }
    if (val != $('#Vcl_Password2').val()) {
        dialog_message(Language['Message008'])
        return
    }
	loading_show();
	$('#submit_form').submit();
}
//根据业务需要，可以自行获取红点
function get_red_point(n_module_id)
{
	var number=5;
	//发送ajax到后台获取数值
	if(number>0)
	{
		$('#sub_nav_'+n_module_id).show()
	}else{
		$('#sub_nav_'+n_module_id).hide()
	}
}
function wechat_unbinding() {
    dialog_confirm('真的要解除微信绑定吗？',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=WechatUnbinding'; //后台方法
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	location='binding_wechat.php';      	
        })
    })
}
function wechat_get_binding_status() {
    var data = 'Ajax_FunName=WechatGetBindingStatus'; //后台方法
    $.getJSON("include/bn_submit.switch.php", data, function (json) {
    	if(json.flag==1)
		{
			var a_arr=[];
			a_arr.push('<div class="item" style="text-align:center">');
	        a_arr.push('	<img style="width:50%" src="'+json.photo+'">');
	        a_arr.push('</div>');
	        a_arr.push('<div class="item">');
	        a_arr.push('	<label>当前绑定微信昵称：</label>');
	        a_arr.push('	<fieldset disabled>');
	        a_arr.push('	<input value="'+json.name+'" maxlength="20" type="text" style="width:100%" class="form-control" aria-describedby="basic-addon1" readonly="readonly"/>');
	        a_arr.push('	</fieldset>	');
	        a_arr.push('</div>');
			a_arr.push('<div class="item">');
			a_arr.push('	<button id="user_add_btn" type="button" class="btn btn-danger" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="wechat_unbinding()">解除绑定</button>');
			a_arr.push('</div>');
			$('.sss_form').html(a_arr.join('\n'));
			window.clearInterval(N_Timer);
		}
    })
}