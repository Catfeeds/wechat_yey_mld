<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='学生列表';
require_once '../header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有学生信息</p></div>';
function getAge($birthday)
{
	$age = strtotime($birthday); 
	if($age === false){ 
		return false; 
	} 
	list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age)); 
	$now = strtotime("now"); 
	list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now)); 
	$age = $y2 - $y1; 
	if((int)($m2.$d2) < (int)($m1.$d1)) 
	$age -= 1; 
	return $age; 
}
?>      
        <?php
        //验证是否名下有该课程，如果没有，返回
        $o_course=new Base_User_Wechat_Course_View();
        $o_course->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId ()) ); 
        $o_course->PushWhere ( array ('&&', 'IsRenew', '=',0) );   
        $o_course->PushWhere ( array ('&&', 'CourseId', '=',$_GET['id']) ); 
        if ($o_course->getAllCount()==0)
        {
        	echo "<script>location.href='stu_course_list.php'</script>"; 
			exit(0);
        }    
        $o_signup=new Student_Signup_View();
        $o_signup->PushWhere ( array ('&&', 'CourseId', '=',$_GET['id']) );
		$o_signup->PushWhere ( array ('&&', 'State', '<',2) );
		$o_signup->PushOrder ( array ('State',A) );
		$o_signup->PushOrder ( array ('IsPay',A) );
        for($i=0;$i<$o_signup->getAllCount();$i++)
        {
        	//根据不通状态，显示状态信息，和相应按钮
        	$s_button='';
        	$s_state='<span class="weui-form-preview__value state'.$o_signup->getId($i).'" style="color:#0BB20C">已交费</span>';
        	if ($o_signup->getState($i)==0)
        	{
        		//等待录取
        		$s_state='<span class="weui-form-preview__value state'.$o_signup->getId($i).'" style="color:#EEA236">等待录取</span>';
        		$s_button='<div class="weui-form-preview__ft btn'.$o_signup->getId($i).'">
				                <a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="teacher_in_confirm('.$o_signup->getId($i).')">确认录取</a>
				            </div>';
        	}
        	if ($o_signup->getState($i)==1 && $o_signup->getIsPay($i)==0)
        	{
        		//等待交费
        		$s_state='<span class="weui-form-preview__value state'.$o_signup->getId($i).'" style="color:red">未交费</span>';
        		$s_button='<div class="weui-form-preview__ft btn'.$o_signup->getId($i).'">
				                <a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="teacher_pay_remind('.$o_signup->getId($i).')">提醒交费</a>
				                <a class="weui-form-preview__btn weui-form-preview__btn_default" onclick="teacher_in_cancel('.$o_signup->getId($i).')" style="color:red">取消录取</a>
				            </div>';
        	}
        				echo('
				        <div class="weui-form-preview">
				            <div class="weui-form-preview__hd">
				                <label class="weui-form-preview__label">学生姓名</label>
				                <em class="weui-form-preview__value">'.$o_signup->getName($i).'</em>
				            </div>
				            <div class="weui-form-preview__bd">
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">年龄</label>
				                    <span class="weui-form-preview__value">'.getAge($o_signup->getBirthday($i)).'岁</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">证件号</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getIdCard($i).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">户籍/学籍</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getHArea($i).'/'.$o_signup->getXArea($i).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">监护人/电话</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getParentName($i).'/'.$o_signup->getPhone($i).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">状态</label>
				                    '.$s_state.'				                    
				                </div>
				            </div>
				            '.$s_button.'
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