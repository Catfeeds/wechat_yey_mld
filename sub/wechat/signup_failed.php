<?php
require_once 'include/it_include.inc.php';
$s_title='报名失败';
require_once 'header.php';
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">报名失败</h2>
            <p class="weui-msg__desc">对不起，该课程已经没有名额，请选择其他课程！</p>
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
                <a href="signup.php" class="weui-btn weui-btn_primary">确定</a>
            </p>
        </div>
    </div>
<script>

$(function () {

}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once 'footer.php';?>