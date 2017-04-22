<?php
require_once 'include/it_include.inc.php';
$s_title='电子学生证';
require_once 'header.php';
$o_student=new Student_Info($_GET['id']);
//验证学生信息是否在该用户名下
$o_stu_wechat=new Student_Info_Wechat();
$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
$o_stu_wechat->PushWhere ( array ('&&', 'StudentId', '=',$o_student->getId()) ); 
if($o_stu_wechat->getAllCount()==0)
{
	//如果不在该用户名下，那么返回
	echo ('<script>location=\'student_idcard.php\'</script>');
	exit ( 0 );
}
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
	<div class="weui-cells__title">学生信息</div>
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">学生姓名</label>
                <em class="weui-form-preview__value"><?php echo($o_student->getName())?></em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
	        <div class="weui-form-preview__item">
	           <label class="weui-form-preview__label">证件类型</label>
	            <span class="weui-form-preview__value"><?php echo($o_student->getIdType())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">证件号</label>
	            <span class="weui-form-preview__value"><?php echo($o_student->getIdCard())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">年龄</label>
	            <span class="weui-form-preview__value"><?php echo(getAge($o_student->getBirthday()))?> 岁</span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">性别</label>
	            <span class="weui-form-preview__value"><?php echo($o_student->getSex())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">民族</label>
	            <span class="weui-form-preview__value"><?php echo($o_student->getNation())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">户籍</label>
	            <span class="weui-form-preview__value"><?php echo($o_student->getHArea())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">学籍</label>
	            <span class="weui-form-preview__value"><?php echo($o_student->getXArea())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">监护人</label>
	            <span class="weui-form-preview__value"><?php echo($o_student->getParentName())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">监护人电话</label>
	            <span class="weui-form-preview__value"><?php echo($o_student->getPhone())?></span>
	        </div>
        </div>
    </div>
    <div class="weui-cells__title">当前课程</div>
    <?php 
    $o_signup = new Student_Signup_View(); 
    $o_signup->PushWhere ( array ('&&', 'StudentId', '=',$o_student->getId()) );
    $o_signup->PushWhere ( array ('&&', 'IsRenew', '<>',2) );
    $o_signup->PushWhere ( array ('&&', 'State', '=',1) );
    $o_signup->PushWhere ( array ('&&', 'IsPay', '=',1) );
    $o_signup->PushOrder ( array ('SignupTime','D') );
    if ($o_signup->getAllCount()>0)
    {
    	for($i=0;$i<$o_signup->getAllCount();$i++)
    	{
    		?>
		    <div class="weui-form-preview">
		        <div class="weui-form-preview__hd">
		            <div class="weui-form-preview__item">
		                <label class="weui-form-preview__label">课程名称</label>
		                <em class="weui-form-preview__value"><?php echo($o_signup->getCourseName($i))?></em>
		            </div>
		        </div>
		        <div class="weui-form-preview__bd">
			        <div class="weui-form-preview__item">
			           <label class="weui-form-preview__label">学期</label>
			            <span class="weui-form-preview__value"><?php echo($o_signup->getTerm($i))?></span>
			        </div>
			        <div class="weui-form-preview__item">
			            <label class="weui-form-preview__label">上课时间</label>
			            <span class="weui-form-preview__value"><?php echo($o_signup->getTime($i))?></span>
			        </div>
			        <div class="weui-form-preview__item">
			            <label class="weui-form-preview__label">校址</label>
			            <span class="weui-form-preview__value"><?php echo($o_signup->getAddressName($i))?></span>
			        </div>
			        <div class="weui-form-preview__item">
			            <label class="weui-form-preview__label">教室</label>
			            <span class="weui-form-preview__value"><?php echo($o_signup->getClass($i))?></span>
			        </div>
		        </div>
		    </div>
			<?php
			if (($i+1)<$o_signup->getAllCount())
			{
				echo('<br/>');
			}
    	}
    }else{
    	?>
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label" style="width:100%;text-align:center;text-align-last:inherit">无&nbsp;&nbsp;课&nbsp;&nbsp;程</label>
            </div>
        </div>
    </div>
    	<?php
    }
    ?>
    <?php 
    $o_stu_wechat=new Student_Info_Wechat_View();
	$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
	if($o_stu_wechat->getAllCount()>1)
	{
		//只有大于一个学生，才显示返回。
		?>
		<div style="padding:15px;">
		    <a class="weui-btn weui-btn_default" href="javascript:history.back();">返回</a>
		</div>
		<?php
	}
    ?>
    
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once 'footer.php';?>