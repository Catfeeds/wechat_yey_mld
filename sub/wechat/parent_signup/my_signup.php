<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='我的幼儿报名';
require_once '../header.php';

//验证学生信息是否在该用户名下
$o_stu_wechat=new Student_Info_Wechat_Wiew();
$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
if($o_stu_wechat->getAllCount()==0)
{
	?>
	<div class="weui-footer" style="padding-top:100px;">
		<p class="weui-footer__text" style="font-size:1.5em">没有幼儿报名信息</p>
	</div>
	<?php
}
for($i=0;$i<$o_stu_wechat->getAllCount();$i++)
{
	?>
	 <div class="page__hd">
        <h1 class="page__title" style="font-size:28px;">我的幼儿报名</h1>
        <p class="page__desc">简要说明</p>
    </div>
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">幼儿编号</label>
                <em class="weui-form-preview__value"><?php echo($o_stu_wechat->getStudentId($i))?></em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
        	<div class="weui-form-preview__item">
                <label class="weui-form-preview__label">幼儿姓名</label>
                <em class="weui-form-preview__value"><?php echo($o_stu_wechat->getName($i))?></em>
            </div>
	        <div class="weui-form-preview__item">
	           <label class="weui-form-preview__label">证件类型</label>
	            <span class="weui-form-preview__value"><?php echo($o_stu_wechat->getIdType($i))?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">证件号</label>
	            <span class="weui-form-preview__value"><?php echo($o_stu_wechat->getId($i))?></span>
	        </div>
	        <div class="weui-form-preview__item">
	           <label class="weui-form-preview__label">性别</label>
	            <span class="weui-form-preview__value"><?php echo($o_stu_wechat->getSex($i))?></span>
	        </div>
	        <div class="weui-form-preview__item">
	           <label class="weui-form-preview__label">出生日期</label>
	            <span class="weui-form-preview__value"><?php echo($o_stu_wechat->getBirthday($i))?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">当前状态</label>
	        <?php 
	        $s_html='';
	        
	        //状态
	        switch($o_stu_wechat->getState($i))
	        {
	        	case 0:
	        		$s_html='<span class="weui-form-preview__value" style="color:#1AAD19">提交信息成功，等待通知材料核验</span>';
	        		break;
	        }
	        echo($s_html);
	        ?>
	        </div>
        </div>
        <div class="weui-form-preview__ft">
         	<a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="Dialog_Message(\'交费功能暂未开始使用，请耐心等待！\');">修改</a>
			<a class="weui-form-preview__btn weui-form-preview__btn_default" onclick="signup_cancel('.$o_signup->getId($j).')" style="color:red">取消报名</a>
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