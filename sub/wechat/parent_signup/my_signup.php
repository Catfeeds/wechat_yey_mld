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
?>
	 <div class="page__hd">
        <h1 class="page__title" style="font-size:28px;">我的幼儿报名</h1>
        <p class="page__desc">简要说明</p>
    </div>
<?php
for($i=0;$i<$o_stu_wechat->getAllCount();$i++)
{
	?>
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
	        $s_button='';
	        //状态
	        switch($o_stu_wechat->getState($i))
	        {
	        	case 0:
	        		$s_html='<span class="weui-form-preview__value" style="color:#1AAD19">提交信息成功，等待通知信息核验</span>';
	        		$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_primary">修改</a>';
	        		$o_date = new DateTime('Asia/Chongqing');
					$s_date=$o_date->format('Y') . '-' . $o_date->format('m') . '-' . $o_date->format('d');
	        		$o_admission_setup=new Admission_Setup(1);
	        		if (strtotime($s_date)<=strtotime($o_admission_setup->getSignupEnd()))
	        		{
	        			$s_button.='<a class="weui-form-preview__btn weui-form-preview__btn_default" onclick="signup_cancel('.$o_stu_wechat->getStudentId($i).')" style="color:red">取消报名</a>';
	        		}
	        		break;
	        	case 1:
	        		$s_html='<span class="weui-form-preview__value" style="color:#1AAD19">等待进行信息核验</span>';
	        		$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">查看幼儿信息</a>';
	        		break;
	        	case 2:
	        		$s_html='<span class="weui-form-preview__value" style="color:#1AAD19">信息核验通过，等待见面</span>';
	        		$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">查看幼儿信息</a>';
	        		break;
	        }
	        echo($s_html);
	        ?>
	        </div>
        </div>
        <div class="weui-form-preview__ft">
         	<?php echo($s_button)?>
		</div>
    </div>
    <br/>
	<?php
}
?>

<script>
function signup_cancel(id)
{
    Dialog_Confirm('真的要取消报名吗？取消后您的幼儿信息将会永久删除。',function(){
    	Common_OpenLoading();
    	var data = 'Ajax_FunName=SignupCancel'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("../include/bn_submit.switch.php", data, function (json) {
        	window.location.href="my_signup.php?"+Date.parse(new Date());    	
        })
    })
}
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>