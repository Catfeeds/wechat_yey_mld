<?php
require_once 'include/it_include.inc.php';
$s_title='申请发票成功';
require_once 'header.php';
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title"><?php echo($s_title)?></h2>
            <p class="weui-msg__desc">您的发票申请已成功提交，请等待发票领取通知。<br/>发票打印后，系统会以微信短消息的方式通知您进行领取，请耐心等待。</p>
        </div>
    </div>
    <div style="padding:15px;">
		    <a class="weui-btn weui-btn_primary" href="record_pay.php?<?php echo(time())?>">确定</a>
	    </div>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once 'footer.php';?>