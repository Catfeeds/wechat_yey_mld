<?php
require_once 'include/it_include.inc.php';
$s_title='等待交费';
require_once 'header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有等待交费的记录</p></div>';
?>      
        <?php
        $o_sut_wechat=new Student_Info_Wechat();
        $o_sut_wechat->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId ()) ); 
        if ($o_sut_wechat->getAllCount()>0)
        {
        	$n_sum=0;
        	//根据学生编号，查找报名信息
        	for($i=0;$i<$o_sut_wechat->getAllCount();$i++)
        	{
        		$o_signup=new Student_Signup_View();
        		$o_signup->PushWhere ( array ('&&', 'StudentId', '=',$o_sut_wechat->getStudentId ($i)) ); 
        		$o_signup->PushWhere ( array ('&&', 'State', '=',1) ); 
        		$o_signup->PushWhere ( array ('&&', 'IsPay', '=',0) ); 
        		$o_signup->PushOrder ( array ('SignupTime','D' ) );
        		for($j=0;$j<$o_signup->getAllCount();$j++)
        		{
        			$n_sum++;
        			echo('
				        <div class="weui-form-preview">
				            <div class="weui-form-preview__hd">
				                <label class="weui-form-preview__label">课程名称</label>
				                <em class="weui-form-preview__value">'.$o_signup->getCourseName($j).'</em>
				            </div>
				            <div class="weui-form-preview__bd">
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">报名日期</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getSignupTime($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">科目</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getSubjectName($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">任课教师</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getTeacherName($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">学生姓名</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getName($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label" style="font-size:1.2em">总价</label>
				                    <span class="weui-form-preview__value" style="font-size:1.4em;color:red">¥'.sprintf("%.2f",$o_signup->getCounts ( $j )*$o_signup->getPrice ( $j )+$o_signup->getMateriale ( $j )).'</span>
				                </div>
				            </div>
				            <div class="weui-form-preview__ft">
				                <a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="Dialog_Message(\'交费功能暂未开始使用，请耐心等待！\');">马上交费</a>
				                <a class="weui-form-preview__btn weui-form-preview__btn_default" href="signup_show_detail.php?id='.$o_signup->getId($j).'">详细</a>
				            </div>
				        </div>
				        <br>
        			');
        		}
        	}
        	if ($n_sum==0)
        	{
        		echo($s_none);
        	}
        }else{
        	echo($s_none);
        }        
        ?>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once 'footer.php';?>