<?php
require_once 'include/it_include.inc.php';
$s_title='报名成功';
require_once 'header.php';
$o_table=new Student_Signup_View($_GET['id']);
//验证学生信息是否在该用户名下
$o_stu_wechat=new Student_Info_Wechat();
$o_stu_wechat->PushWhere ( array ('&&', 'StudentId', '=',$o_table->getStudentId()) ); 
$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
if ($o_stu_wechat->getAllCount()==0)
{
	echo "<script>location.href='signup.php'</script>"; 
	exit(0);
}
function AilterTextArea($s_text) {
	$s_content = $s_text;
	$s_content = str_replace ( "\n", "<br/>", $s_content );
	$s_content = str_replace ( "\r", "", $s_content );
	$s_content = str_replace ( "\\", "\\\\\\\\", $s_content );
	while ( ! (strpos ( $s_content, "<br/><br/>" ) === false) ) {
		$s_content = str_replace ( "<br/><br/>", "<br/>", $s_content );
	}
	$s_content = str_replace ( '  ', '&nbsp;&nbsp;', $s_content );
	return $s_content;
}
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">报名成功</h2>
            <p class="weui-msg__desc">您的报名已经成功提交，请等待录取。<br/>录取后，系统会以微信短消息的方式通知您进行交费，请耐心等待。</p>
        </div>
    </div>
    <div class="weui-cells__title">报名信息</div>
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">学生姓名</label>
                <em class="weui-form-preview__value"><?php echo($o_table->getName())?></em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
	        <div class="weui-form-preview__item">
	           <label class="weui-form-preview__label">证件类型</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getIdType())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">证件号</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getIdCard())?></span>
	        </div>
	    	<div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">监护人姓名</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getParentName())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">监护人手机</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getPhone())?></span>
	        </div>
        </div>
    </div>
    <div class="weui-cells__title">报名课程</div>
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">课程名称</label>
                <em class="weui-form-preview__value"><?php echo($o_table->getCourseName())?></em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
	        <div class="weui-form-preview__item">
	           <label class="weui-form-preview__label">科目</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getSubjectName())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">任课教师</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getTeacherName())?></span>
	        </div>
	    	<div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">上课时间</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getTime())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">校址</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getAddressName())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">教室</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getClass())?></span>
	        </div>	    	
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">容纳人数</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getSum())?>人</span>
	        </div>    
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">课时</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getCounts())?>次</span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">备注</label>
	            <span class="weui-form-preview__value"><?php echo(AilterTextArea($o_table->getNote()))?></span>
	        </div>
	    	<div class="weui-form-preview__item">
	    		<label class="weui-form-preview__label" style="font-size:1.2em">总价</label>
	    		<span class="weui-form-preview__value" style="font-size:1.4em;color:red">¥<?php echo(sprintf("%.2f",$o_table->getCounts ()*$o_table->getPrice ()+$o_table->getMateriale ()))?></span>
	    	</div>
        </div>
    </div>
    <div style="padding:15px;">
		    <a class="weui-btn weui-btn_primary" href="signup.php">确定</a>
	    </div>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once 'footer.php';?>