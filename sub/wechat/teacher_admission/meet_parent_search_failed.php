<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='搜索结果';
require_once '../header.php';
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
        <?php 
        if ($_GET['id']==1)
        {
        	?>
        	<h2 class="weui-msg__title">未找到幼儿信息</h2>
        	<?php
        }elseif ($_GET['id']==2)
        {
        	?>
        	<h2 class="weui-msg__title">未通知见面</h2>
            <p class="weui-msg__desc">请注意，您搜索的幼儿，没有见面资格。</p>
        	<?php
        }else{
        	?>
        	<h2 class="weui-msg__title">已完成见面</h2>
            <p class="weui-msg__desc">您搜索的幼儿，已经完成家长见面结果提交，不能重复操作。</p>
        	<?php
        }
        ?>
        </div>
    </div>
    <div style="padding:15px;">
		<a class="weui-btn weui-btn_primary" onclick="location='meet_parent_search.php?'+Date.parse(new Date())">确定</a>
	</div>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>