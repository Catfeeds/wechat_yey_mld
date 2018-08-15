<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='当前状态';
require_once '../header.php';

require_once RELATIVITY_PATH.'include/bn_basic.class.php';
$o_bn_base=new Bn_Basic();
//验证学生信息是否在该用户名下
$o_stu=new Student_Info_Wechat_Wiew();
$o_stu->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
$o_stu->PushWhere ( array ('&&', 'StudentId', '=',$_GET['id']) ); 
if ($o_stu->getAllCount()==0)
{
	echo "<script>location.href='my_signup.php'</script>"; 
	exit(0);
}
$s_state='';
switch($o_stu->getState(0))
{
	case 1:
		$s_state='等待进行信息核验';
		//读取核验通过提醒，已发消息的最近一条
		$o_reminder=new Wechat_Wx_User_Reminder();
		$o_reminder->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) );
		$o_reminder->PushWhere ( array ('&&', 'Keyword1', '=',$_GET['id']) );
		$o_reminder->PushWhere ( array ('&&', 'MsgId', '=',$o_bn_base->getWechatSetup('MSGTMP_02')) );
		$o_reminder->PushOrder(array('Id','D'));
		$o_reminder->getAllCount();
		$s_html='
				<div class="weui-form-preview">
     				<div class="weui-form-preview__bd">
     					<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">幼儿编号</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword1(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">幼儿姓名</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword2(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">核验日期</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword3(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">核验时段</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword4(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">核验地点</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword5(0).'</span>
            			</div>
     				</div>     				
    		 	</div>
		';
		break;
	case 2:
		$s_state='信息核验通过<br/>等待入园互动';
		//读取核验通过提醒，已发消息的最近一条
		$o_reminder=new Wechat_Wx_User_Reminder();
		$o_reminder->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) );
		$o_reminder->PushWhere ( array ('&&', 'Keyword1', '=',$_GET['id']) );
		$o_reminder->PushWhere ( array ('&&', 'MsgId', '=',$o_bn_base->getWechatSetup('MSGTMP_03')) );
		$o_reminder->PushOrder(array('Id','D'));
		$o_reminder->getAllCount();
		$s_html='
				<div class="weui-form-preview">
     				<div class="weui-form-preview__bd">
     					<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">幼儿编号</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword1(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">幼儿姓名</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword2(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">日期</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword3(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">时段</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword4(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">地点</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword5(0).'</span>
            			</div>
     				</div>     				
    		 	</div>
		';
		break;
	case 4:
		$s_state='等待进行幼儿体检<br/>及结果';
		//读取核验通过提醒，已发消息的最近一条
		$o_reminder=new Wechat_Wx_User_Reminder();
		$o_reminder->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) );
		$o_reminder->PushWhere ( array ('&&', 'Keyword1', '=',$_GET['id']) );
		$o_reminder->PushWhere ( array ('&&', 'MsgId', '=',$o_bn_base->getWechatSetup('MSGTMP_04')) );
		$o_reminder->PushOrder(array('Id','D'));
		$o_reminder->getAllCount();
		$s_html='
				<div class="weui-form-preview">
     				<div class="weui-form-preview__bd">
     					<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">幼儿编号</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword1(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">幼儿姓名</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword2(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">体检时间</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword3(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">体检地址</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword4(0).'</span>
            			</div>
     				</div>     				
    		 	</div>
		';
		break;
	case 6:
		$s_state='已录取';
		//读取核验通过提醒，已发消息的最近一条
		$o_reminder=new Wechat_Wx_User_Reminder();
		$o_reminder->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) );
		$o_reminder->PushWhere ( array ('&&', 'Keyword1', '=',$_GET['id']) );
		$o_reminder->PushWhere ( array ('&&', 'MsgId', '=',$o_bn_base->getWechatSetup('MSGTMP_06')) );
		$o_reminder->PushOrder(array('Id','D'));
		$o_reminder->getAllCount();
		$s_html='
				<div class="weui-form-preview">
     				<div class="weui-form-preview__bd">
     					<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">幼儿编号</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword1(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">幼儿姓名</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword2(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">证件类型</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword3(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">证件号码</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword4(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">班级类型</label>
	                		<span class="weui-form-preview__value">'.$o_reminder->getKeyword5(0).'</span>
            			</div>
            			<div class="weui-form-preview__item">
	                		<label class="weui-form-preview__label">是否服从班级类型调剂</label>
	                		<span class="weui-form-preview__value">'.$o_stu->getCompliance(0).'</span>
            			</div>
     				</div>     				
    		 	</div>
		';
		break;
	default:
		echo "<script>location.href='my_signup.php'</script>"; 
		exit(0);
		break;
}
function format_remark($s_str)
{
	$s_str=str_replace('如需查看幼儿报名信息，请点击详情', '',$s_str);
	$s_str=str_replace('入园互动注意事项请点击详情查看。', '',$s_str);
	$s_str=str_replace('幼儿体检注意事项请点击详情查看。', '',$s_str);
	$s_str=str_replace('幼儿体检注意事项请点击详情查看。', '',$s_str);
	$s_str=str_replace('公交车站', '<br/>公交车站',$s_str);
	$s_str=str_replace('信息核验注意事项请点击详情查看。', '',$s_str);
	return $s_str;
}
?>
<style>
.weui-media-box:before {
	border-top: 0px solid #E5E5E5;
}
.weui-media-box_text .weui-media-box__title {
	margin-bottom: 0px;
	text-overflow:inherit;
	white-space:inherit;
}
</style>
	 <div class="page__hd" style="padding-bottom:20px;">
        <h1 class="page__title" style="font-size:28px;"><?php echo($s_state)?></h1>
     </div>
     <div class="page__bd">
     <div class="weui-panel weui-panel_access">
            <div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_text">
                    <h4 class="weui-media-box__title"><?php echo($o_reminder->getFirst(0))?></h4>
                </div>
                <?php echo($s_html)?>
                <div class="weui-media-box weui-media-box_text">
                    <h4 class="weui-media-box__title"><?php echo(format_remark($o_reminder->getRemark(0)));?></h4>
                    <?php 
                    if ($o_stu->getState(0)==1)
                    {
                    ?>
                	<h4 class="weui-media-box__title" style="text-align:center;font-size:22px;padding-top:15px;padding-bottom:15px;"><b>信息核验注意事项</b></h4>
                    <h4 class="weui-media-box__title" style="font-size:14px;color:#333333">
<span style="text-decoration:underline">家长持报名手机及幼儿编号</span>，在规定的时段、地点，有序进行信息核验。家长请务必携带自行打印的“报名信息登记表”和相关证件原件、复印件，即：户口本、出生证、房产证或租赁合同（能证明房主与幼儿的关系）、幼儿预防接种证、其他特殊证明（如烈士子女证明等）。
					</h4>
					<?php 
                    }
					?>
					<?php 
                    if ($o_stu->getState(0)==2)
                    {
                    ?>
                	<h4 class="weui-media-box__title" style="text-align:center;font-size:22px;padding-top:15px;padding-bottom:15px;"><b>入园互动注意事项</b></h4>
                    <h4 class="weui-media-box__title" style="font-size:14px;color:#333333">
<span style="text-decoration:underline">家长持报名手机及幼儿编号</span>，在规定的时段、地点，有序扫码入园，参加入园互动。一名幼儿只能由一名监护人带领参加入园互动。
					</h4>
					<?php 
                    }
					?>
                    <?php 
                    if ($o_stu->getState(0)==4)
                    {
                    ?>
                	<h4 class="weui-media-box__title" style="text-align:center;font-size:22px;padding-top:15px;padding-bottom:15px;"><b>体检注意事项</b></h4>
                    <h4 class="weui-media-box__title" style="font-size:14px;color:#333333">
1. 请家长尽量按照园所通知的体检日期进行体检。<br/><br/>
2. 幼儿入园体检化验需空腹，请幼儿在体检前8小时禁食、禁奶，如体检当日已进食，请择日抽血。<br/><br/>
3. 请家长尽量携带幼儿医保卡就诊挂号，减少等待时间、避免手写出现错误信息。<br/><br/>
4. 体检报告由幼儿园统一领取。
					</h4>
					<?php 
                    }
					?>
					<?php 
                    if ($o_stu->getState(0)==6)
                    {
                    ?>
                	<h4 class="weui-media-box__title" style="text-align:center;font-size:22px;padding-top:15px;padding-bottom:15px;"><b>注意事项</b></h4>
                    <h4 class="weui-media-box__title" style="font-size:14px;color:#333333">
家长您好：请于2018年8月22日早8:50到北京市西城区马连道党群活动服务中心（地址：北京市西城区广外街道红莲南路57-2号）参加马连道幼儿园新生家长学校“育儿有道，助推儿童健康成长”培训，请您务必准时参加。（监护人参加不带幼儿）
					</h4>
					<?php 
                    }
					?>
                </div>    
            </div>            
        </div>
     </div>
     <br/>
	<div style="padding:15px; padding-top:0px">
		<a id="next" class="weui-btn weui-btn_default" href="my_signup.php">返回</a>
	</div>
<script>
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>