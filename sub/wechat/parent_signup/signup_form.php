<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='报名信息登记';
require_once '../header.php';
?>
	<form action="../include/bn_submit.switch.php" id="submit_form_checkid" method="post" target=ajax_submit_frame>
		<input type="hidden" name="Vcl_FunName" value="CheckId"/>
		<input type="hidden" name="Vcl_CheckId" id="Vcl_CheckId" value=""/>
	</form>
	<form action="../include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
		<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
		<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
		<input type="hidden" name="Vcl_FunName" value="Signup"/>
			<?php 
				require_once 'signup_detail.php';
			?>
	    <div style="padding:15px;">
	    	<a id="next" class="weui-btn weui-btn_primary" onclick="submit_signin(false)">提交报名信息</a>
	    	<a id="next" class="weui-btn weui-btn_default" onclick="location='my_signup.php?'+Date.parse(new Date())">取消</a>
	    </div>
	</form>
<script type="text/javascript" src="js/function.js"></script>
<script>

</script>
<?php
require_once '../footer.php';
?>