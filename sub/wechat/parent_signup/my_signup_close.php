<script type="text/javascript">
	location='my_signup.php';
</script>
<?php
exit(0);
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='我的幼儿报名';
require_once '../header.php';

	?>
	<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;padding-left:30px;padding-right:30px;">
		<p class="weui-footer__text" style="font-size:1.5em">
		注意事项：
		</p>
		<p class="weui-footer__text" style="font-size:1.5em;text-align:left;margin-top:15px;">
		幼儿报名所使用的微信号既是幼儿招生各阶段通知、验证的唯一号码，也是幼儿入园后家园联系的途径，敬请注意。
		</p>
	</div>
	<div style="padding:15px; padding-top:0px">
		<a id="next" class="weui-btn weui-btn_primary" onclick="Dialog_Message('报名尚未开始，请在有效日期内进行报名。')">+ 马上报名</a>
	</div>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>