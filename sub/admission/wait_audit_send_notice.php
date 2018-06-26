<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120102);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
//获取子模块菜单
ExportMainTitle(MODULEID,$O_Session->getUid());
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        	<span  class="glyphicon fa fa-users"></span>&nbsp;群发通知
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="WaitAuditSendNotice"/>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label><span class="must">*</span> 通知内容：</label>
	                     		<textarea  name="Vcl_First" maxlength="50" id="Vcl_First" type="text" style="width:100%" placeholder="必填，不能超过50字" class="form-control" rows="5"/></textarea>
	                     	</div>
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="send_notice()"><span class="glyphicon fa fa-send"></span>&nbsp;发送</button>
							</div>                   	
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
function send_notice()
{
	if (document.getElementById("Vcl_First").value == "") {
		dialog_message("通知内容不能为空！")
		return
	}
	if(check_remark(document.getElementById("Vcl_First").value)==false)
	{
		dialog_message("通知内容不能超过50个字！")
		return
	}
	dialog_confirm("确认要群发通知吗？<br/><br/>确认后：<br/>所有当前列表中的报名家长将陆续收到微信通知。<br/><br/>注：该操作不能撤销，请谨慎操作。",function (){document.getElementById('submit_form').submit();loading_show();});
}
function check_remark(fData)
{
	var intLength=0 
    for (var i=0;i<fData.length;i++) 
    { 
        if ((fData.charCodeAt(i) < 0) || (fData.charCodeAt(i) > 255)) 
            intLength=intLength+1
        else 
            intLength=intLength+1
    }
	if (intLength>50)
	{
		return false;
	}else{
		return true;
	}
}
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>