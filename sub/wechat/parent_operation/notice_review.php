<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='通知详情';
require_once '../header.php';

require_once RELATIVITY_PATH.'include/bn_basic.class.php';
$o_bn_base=new Bn_Basic();
//验证是否为绑定家长
$o_stu=new Student_Onboard_Info_Wechat();
$o_stu->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
if ($o_stu->getAllCount()==0)
{
	echo "<script>document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));</script>"; 
	exit(0);
}
require_once RELATIVITY_PATH . 'sub/notice_center/include/db_table.class.php';
$o_notice=new Notice_Center_Record($_GET['id']);
if (!($o_notice->getUid()>0))
{
	//不合法就退出
	echo "<script>document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));</script>"; 
	exit(0);
}
?>
<style>
.weui-media-box_text p{
	margin-top:10px !important;
	padding-top:0px !important;
	padding-bottom:0px !important;
	font-size:18px !important;
	line-height:150% !important;;
}
.weui-media-box_text b{
	font-size:20px !important;
}
.weui-media-box_text strong{
	font-size:20px !important;
}
</style>
     <div class="page__bd">
     <div class="weui-cells__title">通知详情</div>
     <div class="weui-panel weui-panel_access">
            <div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_text">
                	<?php echo(rawurldecode($o_notice->getComment()))?>
                </div>    
            </div>            
        </div>
     </div>
     <br/>
	<div style="padding:15px; padding-top:0px">
		<a id="next" class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">返回</a>
	</div>
<script>
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>