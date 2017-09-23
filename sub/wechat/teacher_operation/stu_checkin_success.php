<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='提交考勤结果成功';
require_once '../header.php';
require_once RELATIVITY_PATH . 'sub/ye_info/include/db_table.class.php';
$o_checkingin=new Student_Onboard_Checkingin_Class_View($_GET['id']);
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title"><?php echo($s_title)?></h2>
            <p class="weui-msg__desc">
            	班级名称：<?php echo($o_checkingin->getClassName())?><br/>
            	总人数：<?php echo($o_checkingin->getCheckinginSum()+$o_checkingin->getAbsenteeismSum())?> 人<br/>
            	本日出勤人数：<?php echo($o_checkingin->getCheckinginSum())?> 人<br/>
            	本日缺勤人数：<span style="color:red"><?php echo($o_checkingin->getAbsenteeismSum())?></span> 人<br/>
            </p>
        </div>
    </div>
    <div style="padding:15px;">
		    <a class="weui-btn weui-btn_primary" href="stu_checkin.php">确定</a>
	    </div>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>