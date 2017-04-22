<?php
require_once 'include/it_include.inc.php';
$s_title='填写报名信息';
require_once 'header.php';
$o_course=new Course_Info_View($_GET['id']);
if ($o_course->getName()=='' || $o_course->getName()==null)
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
	<div class="weui-cells__title">课程详细信息</div>
	<form action="include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
		<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
		<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
		<input type="hidden" name="Vcl_FunName" value="CourseSignup"/>
		<input type="hidden" name="Vcl_CourseId" value="<?php echo($_GET['id'])?>"/>
	<div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">课程名称</label>
                <em class="weui-form-preview__value"><?php echo($o_course->getName())?></em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
	    	<div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">学期</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getTerm())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	           <label class="weui-form-preview__label">科目</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getSubjectName())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">任课教师</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getTeacherName())?></span>
	        </div>
	    	<div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">上课时间</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getTime())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">校址</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getAddressName())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">教室</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getClass())?></span>
	        </div>	    	
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">招生对象</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getTarget())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">容纳人数</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getSum())?>人</span>
	        </div>    
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">学费（元/次）</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getPrice())?>元</span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">材料费</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getMateriale())?>元</span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">课时</label>
	            <span class="weui-form-preview__value"><?php echo($o_course->getCounts())?>次</span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">备注</label>
	            <span class="weui-form-preview__value"><?php echo(AilterTextArea($o_course->getNote()))?></span>
	        </div>
	    	<div class="weui-form-preview__item">
	    		<label class="weui-form-preview__label" style="font-size:1.2em">总价</label>
	    		<span class="weui-form-preview__value" style="font-size:1.4em;color:red">¥<?php echo(sprintf("%.2f",$o_course->getCounts ()*$o_course->getPrice ()+$o_course->getMateriale ()))?></span>
	    	</div>
        </div>
    </div>
    <br>
    <div class="weui-cells__title">选择报名学生</div>
    <div class="weui-cells weui-cells_radio">
    	<?php 
    	$o_stu=new Student_Info_Wechat_View();
    	$o_stu->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) );
    	$o_stu->PushOrder ( array ('StudentId','D' ) );
    	for($i=0;$i<$o_stu->getAllCount();$i++)
    	{
    		$s_checked='';
    		if($i==0)
    		{
    			$s_checked=' checked="checked"';
    		}
    		echo('
	    	<label class="weui-cell weui-check__label" for="Vcl_StudentId_'.$o_stu->getId($i).'" style="padding-right:0px;">
	            <div class="weui-cell__bd">
	                <p>'.$o_stu->getName($i).' 
	                <br>
	                <span style="font-size:0.7em;color:#999999">'.$o_stu->getIdType($i).'：'.$o_stu->getIdCard($i).'</span>
	                <br>
	                <span style="font-size:0.7em;color:#999999">监护人：'.$o_stu->getParentName($i).'</span>
	                <br>
	                <span style="font-size:0.7em;color:#999999">监护人手机：'.$o_stu->getPhone($i).'</span>
	                </p>	                
	            </div>
	            <div class="weui-cell__ft">
	                <input type="radio" class="weui-check" name="Vcl_StudentId" value="'.$o_stu->getStudentId($i).'" id="Vcl_StudentId_'.$o_stu->getId($i).'"'.$s_checked.'>
	                <span class="weui-icon-checked"></span>
	            </div>
	            <div class="weui-cell__ft" style="margin:0px;">
	                <button class="weui-vcode-btn" onclick="location=\'student_modify.php?course_id='.$_GET['id'].'&student_id='.$o_stu->getId($i).'\'">修改</button>
	            </div>
	        </label>
    		');
    	}
    	?>        
        <a href="student_add.php?course_id=<?php echo($_GET['id'])?>" class="weui-cell weui-cell_link">
            <div class="weui-cell__bd">添加学生信息</div>
        </a>
    </div>
    <br>
    <div style="padding:15px;">
	    <a href="javascript:;" class="weui-btn weui-btn_primary" onclick="course_signup(<?php echo($o_stu->getAllCount())?>)">提交报名</a>
    </div>
    <div style="padding:15px;padding-top:0px;">
	    <a href="javascript:history.go(-1);" class="weui-btn weui-btn_default">取消</a>
    </div>
</form>
<script>
$(function () {
	//禁止分享
	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
}); 

</script>  
<?php require_once 'footer.php';?>