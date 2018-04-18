<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='数据加载失败';
require_once '../header.php';
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
        	<h2 class="weui-msg__title">数据加载失败</h2>
            <p class="weui-msg__desc">对不起，数据加载失败，请重新扫描二维码。</p>
        </div>
    </div>
    <div style="padding:15px;">
		<a class="weui-btn weui-btn_primary" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">确定</a>
	</div>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>