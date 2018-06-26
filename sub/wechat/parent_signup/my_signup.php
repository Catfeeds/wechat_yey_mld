<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='我的幼儿报名';
require_once '../header.php';
require_once RELATIVITY_PATH.'include/bn_basic.class.php';
$o_bn_base=new Bn_Basic();
//验证学生信息是否在该用户名下
$o_stu_wechat=new Student_Info_Wechat_Wiew();
$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
if($o_stu_wechat->getAllCount()==0)
{
	?>
	<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;padding-left:30px;padding-right:30px;">
		<p class="weui-footer__text" style="font-size:1.5em">
		注意事项：
		</p>
		<p class="weui-footer__text" style="font-size:1.5em;text-align:left;margin-top:15px;">
		幼儿报名所使用的微信号既是幼儿园招生各阶段通知、验证的唯一号码，也是幼儿入园后家园联系的途径，敬请注意。
		</p>
	</div>
	<?php
}else{
?>
	 <div class="page__hd">
        <h1 class="page__title" style="font-size:28px;">我的幼儿报名</h1>
        <p class="page__desc">幼儿报名所使用的微信号既是幼儿招生各阶段通知、验证的唯一号码，也是幼儿入园后家园联系的途径，敬请注意。</p>
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
	        $s_add_html='';
	        $s_html='';
	        $s_button='';
	        //状态
	        switch($o_stu_wechat->getState($i))
	        {
	        	case 0:
	        		$s_html='<span class="weui-form-preview__value" style="color:#1AAD19">提交成功，等待信息初审</span>';
	        		$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_primary">修改</a>';
	        		$o_date = new DateTime('Asia/Chongqing');
					$s_date=$o_date->format('Y') . '-' . $o_date->format('m') . '-' . $o_date->format('d');
	        		$o_admission_setup=new Admission_Setup(1);
	        		if (strtotime($s_date)<=strtotime($o_admission_setup->getSignupEnd()))
	        		{
	        			$s_button.='<a class="weui-form-preview__btn weui-form-preview__btn_default" onclick="signup_cancel('.$o_stu_wechat->getStudentId($i).')" style="color:red">取消报名</a>';
	        		}else{
	        			$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        		}
	        		if($o_stu_wechat->getReject($i)==1)
	        		{
	        			$s_html='<span class="weui-form-preview__value" style="color:#d9534f">信息初审未通过，失去入园资格</span>';
	        			$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        		}
	        		break;
	        	case 1:	        		
	        		if($o_stu_wechat->getReject($i)==1)
	        		{
	        			if ($o_stu_wechat->getAuditorName ( $i )=='')
	        			{
	        				$s_html='<span class="weui-form-preview__value" style="color:#d9534f">未参加信息核验，失去入园资格</span>';
	        			}else{
	        				$s_html='<span class="weui-form-preview__value" style="color:#d9534f">信息核验未通过，失去入园资格</span>';
	        			}
	        			$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        		}else{
	        			//判断是否有通知存在。
	        			$o_reminder=new Wechat_Wx_User_Reminder();
	        			$o_reminder->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) );
	        			$o_reminder->PushWhere ( array ('&&', 'First', 'Like','%'.$o_stu_wechat->getStudentId($i).'%') );
	        			$o_reminder->PushWhere ( array ('&&', 'Keyword1', '=','等待信息核验') );
	        			$o_reminder->PushWhere ( array ('&&', 'MsgId', '=',$o_bn_base->getWechatSetup('MSGTMP_11')) );
	        			$o_reminder->PushOrder(array('Id','D'));
	        			if ($o_reminder->getAllCount()>0)
	        			{
	        				$s_first=str_replace('幼儿编号：'.$o_stu_wechat->getStudentId($i), '', $o_reminder->getFirst(0));
	        				$s_first=str_replace('幼儿姓名：'.$o_stu_wechat->getName($i), '', $s_first);
	        				$s_add_html='
							<div class="weui-form-preview__item">
					           <label class="weui-form-preview__label">报名通知</label>
					            <span class="weui-form-preview__value" style="text-align:left;color:#FFA200">'.$s_first.'</span>
					        </div>
							';
	        				$s_html='<span class="weui-form-preview__value" style="color:#1AAD19">等待信息核验</span>';
	        				$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        			}else{
	        				$s_html='<span class="weui-form-preview__value" style="color:#1AAD19">等待信息核验，请查阅状态详情</span>';
	        				$s_button='<a href="my_signup_state.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_primary">状态详情</a><a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        			}
	        		}
	        		break;
	        	case 2:
	        		$s_html='<span class="weui-form-preview__value" style="color:#1AAD19">等待入园互动，请查阅状态详情</span>';
	        		$s_button='<a href="my_signup_state.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_primary">状态详情</a><a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        		if($o_stu_wechat->getReject($i)==1)
	        		{
	        			$s_html='<span class="weui-form-preview__value" style="color:#d9534f">未参加入园互动，失去入园资格</span>';
	        			$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        		}
	        		break;
	        	case 3:
	        		$s_html='<span class="weui-form-preview__value" style="color:#1AAD19">入园互动已完成，请等候结果</span>';
	        		$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        		if($o_stu_wechat->getReject($i)==1)
	        		{
	        			$s_html='<span class="weui-form-preview__value" style="color:#d9534f">入园互动未通过，失去入园资格</span>';
	        			$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        		}
	        		break;
	        	case 4:
	        		$s_html='<span class="weui-form-preview__value" style="color:#FFA200">等待体检及结果，请查阅状态详情</span>';
	        		$s_button='<a href="my_signup_state.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_primary">状态详情</a><a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        		if($o_stu_wechat->getReject($i)==1)
	        		{
	        			$s_html='<span class="weui-form-preview__value" style="color:#d9534f">幼儿体检未通过，失去入园资格</span>';
	        			$s_button='<a href="signup_modify.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        		}
	        		break;
	        	case 5:
	        		$s_html='<span class="weui-form-preview__value" style="color:#FFA200">点击信息采集，完善信息</span>';
	        		$s_button='<a href="signup_finish_info.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_primary">信息采集</a>';
	        		break;
	        	case 6:
	        		$s_html='<span class="weui-form-preview__value" style="color:#1AAD19">已录取，报到注册请查阅状态详情</span>';
	        		$s_button='<a href="my_signup_state.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_primary">状态详情</a><a href="signup_finish_info.php?id='.$o_stu_wechat->getStudentId($i).'" class="weui-form-preview__btn weui-form-preview__btn_default">幼儿信息</a>';
	        		break;
	        }
	        echo($s_html);
	        ?>
	        </div>
	        <?php echo($s_add_html)?>
        </div>
        <div class="weui-form-preview__ft">
         	<?php echo($s_button)?>
		</div>
    </div>
    <br/>
	<?php
}
}
?>
	<div style="padding:15px; padding-top:0px">
		<a id="next" class="weui-btn weui-btn_primary" href="signup_agreement.php">+ 马上报名</a>
	</div>
<script>
function signup_cancel(id)
{
    Dialog_Confirm('真的要取消报名吗？取消后您的幼儿信息将会删除。',function(){
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