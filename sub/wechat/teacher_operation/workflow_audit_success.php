<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='提交工作流程成功';
require_once '../header.php';
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title"><?php echo($s_title)?></h2>
            <p class="weui-msg__desc">
            	
            </p>
        </div>
    </div>
    <div style="padding:15px;">
		    <a class="weui-btn weui-btn_primary" href="workflow_audit.php">确定</a>
	    </div>
<script>
$(function () {
	
});
</script>  
<?php require_once '../footer.php';?>