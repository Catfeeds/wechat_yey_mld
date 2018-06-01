<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='入园互动入场验证';
require_once '../header.php';
$b_ticket=false;
//验证学生信息是否在该用户名下
$o_stu_wechat=new Student_Info_Wechat_Wiew(); 
$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
//验证是否有信息核验资格
for($i=0;$i<$o_stu_wechat->getAllCount();$i++)
{
	if ($o_stu_wechat->getState($i)>=2)
	{
		$b_ticket=true;
		break;
	}
}
if ($b_ticket)
{
	?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">入园互动入场通过<br/>
            <span style="font-size:32px;">时段：<?php 
        require_once RELATIVITY_PATH.'include/bn_basic.class.php';
		$o_bn_base=new Bn_Basic();
        $o_reminder=new Wechat_Wx_User_Reminder();
		$o_reminder->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) );
		$o_reminder->PushWhere ( array ('&&', 'MsgId', '=',$o_bn_base->getWechatSetup('MSGTMP_03')) );
		$o_reminder->PushOrder(array('Id','D'));
		$o_reminder->getAllCount();
		echo($o_reminder->getKeyword4(0));
            ?></span></h2>
            <p class="weui-msg__desc">您好，请入场进行入园互动</p>
        </div>
    </div>
    <div class="weui-cells__title">幼儿报名信息</div>
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
	            <span class="weui-form-preview__value"><?php echo($o_stu_wechat->getName($i))?></span>
	        </div>
	        <div class="weui-form-preview__item">
	           <label class="weui-form-preview__label">证件类型</label>
	            <span class="weui-form-preview__value"><?php echo($o_stu_wechat->getIdType($i))?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">证件号</label>
	            <span class="weui-form-preview__value"><?php echo($o_stu_wechat->getId($i))?></span>
	        </div>
        </div>
    </div>
    <div style="padding:15px;">
		    <a class="weui-btn weui-btn_primary" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">确定</a>
	    </div>
	<?php
}else{
	?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">没有入园互动入场资格</h2>
            <p class="weui-msg__desc">对不起，您没有入园互动入场资格</p>
        </div>
    </div>
    <div style="padding:15px;">
		<a class="weui-btn weui-btn_primary" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">确定</a>
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
<?php require_once '../footer.php';?>