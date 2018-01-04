<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='问卷调查';
require_once '../header.php';
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">完成问卷调查</h2>
            <p class="weui-msg__desc">您已经完成问卷调查，感谢您的支持与配合。</p>
            <p class="weui-msg__desc" style="text-align:left;margin-top:20px;">
            <?php
            	if ($_GET['id']>0)
				{
					$o_survey=new Survey_Teacher($_GET['id']);
					require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
					$o_bn_base=new Bn_Basic();
					echo($o_bn_base->AilterTextArea($o_survey->getComment()));
				}
			?></p>
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