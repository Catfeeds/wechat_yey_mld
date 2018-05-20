<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='在线准考证打印报名信息登记表';
require_once '../header.php';
//按照OpenId搜索表格，是否存在，如果存在那么修改session_id，否则新建
$o_signup_login=new Student_Info_Print_Login();
$o_signup_login->PushWhere ( array ('&&', 'OpenId', '=',$o_wx_user->getOpenId()) );
if ($o_signup_login->getAllCount()>0)
{
	$o_signup_login=new Student_Info_Print_Login($o_signup_login->getId(0));
}else{
	$o_signup_login=new Student_Info_Print_Login();
	$o_signup_login->setOpenId($o_wx_user->getOpenId());
}
$o_signup_login->setSessionId($_GET['id']);
$o_signup_login->Save();
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">登陆成功</h2>
            <p class="weui-msg__desc">您的微信号已经成功登陆在线报名信息登记表，请耐心等待电脑端页面跳转。</p>
        </div>
    </div>
    <div style="padding:15px;">
		<a class="weui-btn weui-btn_primary" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">确定</a>
	</div>
<script>
$(function () {
	//禁止分享
	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
});
</script> 
<?php require_once '../footer.php';?>