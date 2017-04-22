<?php
require_once 'include/it_include.inc.php';
$s_title='学生证';
require_once 'header.php';

//验证学生信息是否在该用户名下
$o_stu_wechat=new Student_Info_Wechat_View();
$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
if($o_stu_wechat->getAllCount()==1)
{
	echo ('<script>location=\'student_idcard_detail.php?id='.$o_stu_wechat->getStudentId(0).'\'</script>');
	exit ( 0 );
}
if($o_stu_wechat->getAllCount()==0)
{
	?>
	<div class="weui-footer" style="padding-top:100px;">
		<p class="weui-footer__text" style="font-size:1.5em">没有信息</p>
	</div>
	<?php
}
for($i=0;$i<$o_stu_wechat->getAllCount();$i++)
{
	$o_table=new Student_Info($o_stu_wechat->getStudentId($i));
	?>
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
        </div>
        <div class="weui-form-preview__ft">
			<a class="weui-form-preview__btn weui-form-preview__btn_default" href="student_idcard_detail.php?id=<?php echo($o_stu_wechat->getStudentId($i))?>">查看</a>
		</div>
    </div>
    <br/>
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