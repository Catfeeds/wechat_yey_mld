<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='课程列表';
require_once '../header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有相关课程</p></div>';
?>      
        <?php
        $o_course=new Base_User_Wechat_Course_View();
        $o_course->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId ()) ); 
        $o_course->PushWhere ( array ('&&', 'IsRenew', '=',0) );        	
        for($i=0;$i<$o_course->getAllCount();$i++)
        {	
        	//计算已录取的学生
			$o_temp=new Student_Signup();
			$o_temp->PushWhere ( array ('&&', 'CourseId', '=',$o_course->getCourseId($i)) );	
			$o_temp->PushWhere ( array ('&&', 'State', '=',1) );	
			$n_isin=$o_temp->getAllCount();
			//计算已交费的学生
			$o_temp=new Student_Signup();
			$o_temp->PushWhere ( array ('&&', 'CourseId', '=',$o_course->getCourseId($i)) );	
			$o_temp->PushWhere ( array ('&&', 'State', '=',1) );	
			$o_temp->PushWhere ( array ('&&', 'IsPay', '=',1) );	
			$n_ispay=$o_temp->getAllCount();
			//计算待录取的学生
			$o_temp=new Student_Signup();
			$o_temp->PushWhere ( array ('&&', 'CourseId', '=',$o_course->getCourseId($i)) );	
			$o_temp->PushWhere ( array ('&&', 'State', '=',0) );	
			$n_waiting=$o_temp->getAllCount();
        				echo('
				        <div class="weui-form-preview">
				            <div class="weui-form-preview__hd">
				                <label class="weui-form-preview__label">课程名称</label>
				                <em class="weui-form-preview__value">'.$o_course->getCourseName($i).'</em>
				            </div>
				            <div class="weui-form-preview__bd">
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">上课时间</label>
				                    <span class="weui-form-preview__value">'.$o_course->getTime($i).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">容纳人数</label>
				                    <span class="weui-form-preview__value">'.$o_course->getSum($i).' 人</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">等待录取</label>
				                    <span class="weui-form-preview__value" style="color:#EEA236">'.$n_waiting.' 人</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">已经录取</label>
				                    <span class="weui-form-preview__value">'.$n_isin.' 人</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">已经交费</label>
				                    <span class="weui-form-preview__value" style="color:#0BB20C">'.$n_ispay.' 人</span>
				                </div>
				            </div>
				            <div class="weui-form-preview__ft">
				                <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="stu_course_signup.php?id='.$o_course->getCourseId($i).'">进入</a>
				            </div>
				        </div>
				        <br>
        				');
        }
        if ($i==0)
        {
        	echo($s_none);
        }     
        ?>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>