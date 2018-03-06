<?php
define ( 'RELATIVITY_PATH', '../../../' );
//require_once '../include/it_include.inc.php';
$s_title='食谱';
$s_creatives='王倩';
require_once '../header.php';
/*
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有食谱</p></div>';
$o_table=new Ek_Recomrecipe();
$o_table->PushOrder ( array ('Creationtime','D') );
$o_table->getAllCount();
$o_onboard=new Student_Onboard_Info_Class_Wechat_View();
$o_onboard->PushWhere ( array ('&&', 'UserId', '=', $o_wx_user->getId() ) );
$o_onboard->getAllCount();*/
?>

<style>

</style>
<div class="page">
	<div class="weui-footer" style="padding:20px;padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em;">幼儿园进入假期轮休阶段，公众号食谱暂停更新。如需了解菜谱可到幼儿园公示区查看。</p></div>
    


	<div style="padding:15px;">
		<a id="next" class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">关闭</a>
	</div>
<?php
require_once '../footer.php';
?>