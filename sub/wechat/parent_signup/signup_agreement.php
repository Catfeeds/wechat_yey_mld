<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='报名须知';
require_once '../header.php';
?>
 	<div class="page__hd" style="padding:15px;">
        <h1 class="page__title" style="font-size:25px;text-align:center;padding-top:20px;padding-bottom:15px;">2017年招生公告</h1>
        <p class="page__desc" style="color:#666666;font-size:16px;">
根据上级指示精神，现对我园2017年招生工作公告如下：<br/><br/>
一、招生年龄范围：<br/>
    2014年8月31日之前出生的适龄幼儿<br/><br/>
二、招生名额：<br/>
 小班：75名，中班：6名，大班：3名<br/><br/>
三、报名流程：<br/>
（一）报名： 6月2日—6月11日。6月12日起报名平台不再接收新报名申请。报名方式：关注“马连道幼儿园”公众号，利用“社会关注”栏目下的“招生报名”功能如实填报幼儿信息并提交，报名成功后获得幼儿编号并请牢记。<br/><br/>
（二）证件资格审验：<br/>
1、幼儿园对公众号上的报名信息进行审验后，于6月12日17：00前对登记信息清晰、符合报名条件的报名信息进行初审通过。家长通过我的幼儿报名中“当前状态”查看，点击“状态详情”获取信息核验时段、地点及注意事项。<br/><br/>
2、6月17日上午8:00—12:00, 家长持报名手机，在规定的时段、地点，有序扫码入园，进行信息核验。家长请务必携带相关证件，即:户口本、幼儿身份证、房产证或租赁合同（房主与幼儿的关系）。幼儿预防接种证（小绿本）。其他特殊证明（华侨、烈士、现役军人、残疾等）。<br/><br/>
3、对于符合见面条件的，家长通过我的幼儿报名中“当前状态”查看，点击“状态详情”获取见面时段、地点及注意事项。家长需按照时段地点由一名监护人按时携带幼儿参加见面会。<br/><br/>
（三）见面会：6月24日—6月25日，家长持报名手机，在规定的时段、地点，有序扫码入园，参加见面会。一名幼儿只能由一名监护人带领参加见面会。参与见面会的幼儿进行见面前家长可以请幼儿牢记幼儿编号或将写有幼儿编号的纸条由幼儿转交见面老师，幼儿见面过程中家长需在操场上的家长见面处进行家长见面。<br/><br/>
（四）预录取阶段：7月4－7月12日，家长通过我的幼儿报名中“当前状态”查看，点击“状态详情”获取体检时间、地点及注意事项。家长需按照时间地点及注意事项要求由监护人按时携带幼儿参加体检。体检完成后，家长看到我的幼儿报名中“当前状态”为“等待信息采集”后请及时进行信息采集。“信息采集”工作完成后“当前状态”会变为“已录取”，家长需点击“状态详情”查看报到注册时间地点，并按要求进行报到注册手续，完成报到注册手续后，幼儿被马连道幼儿园录取。<br/><br/>
（五）未录取幼儿信息处置：9月30日前，对于通过关注微信公众号报名的所有幼儿信息，幼儿园会统一进行个人信息删除操作，届时我的幼儿报名下的报名信息将取消，以保护个人信息不因报名而泄露。<br/><br/>
感谢您的参与！<br/><br/><br/>
幼儿园咨询电话:52990927转8008 <br/>
招生期间咨询时间:<br/>工作日9:00-10：00      15：00-16：00<br/><br/>
说明：请家长结合招生流程时间点关注幼儿报名中的“当前状态”，如未收到状态变化，说明您已失去入园资格，请您抓紧联系其它园。名额有限，幼儿园不再另行通知，敬请谅解。<br/><br/>
			<span style="float:right;">
			马连道幼儿园<br/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2016.6.3
			</span><br/><br/>
      	</p>
    </div>
    <div style="padding:15px;">
		 <a class="weui-btn weui-btn_disabled weui-btn_primary"><span>20</span> 已阅读并同意</a>
		 <a id="next" href="signup_form.php" class="weui-btn weui-btn_primary" style="display:none">已阅读并同意</a>
		 <a onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));" class="weui-btn weui-btn_default">不同意</a>
	</div>
<script>
$(function(){
<?php 
//判断是否为合法报名时段
$o_setup=new Admission_Setup(1); 
$o_date = new DateTime('Asia/Chongqing');
$s_date=$o_date->format('Y') . '-' . $o_date->format('m') . '-' . $o_date->format('d');
if (strtotime($s_date)<strtotime($o_setup->getSignupStart()))
{
	echo('Dialog_Message("报名开始时间为：'.$o_setup->getSignupStart().' ，请在有效日期内进行报名。",function(){location=\'my_signup.php\'});
	');
}
if (strtotime($s_date)>strtotime($o_setup->getSignupEnd()))
{
	echo('Dialog_Message("报名已截至，截至时间：<br/>'.$o_setup->getSignupEnd().' ",function(){location=\'my_signup.php\'});');
}
?>
});
count_down(21)
function count_down(a) {
    if (a == 1) {                
        $(".weui-btn_disabled").remove();
        $("#next").css("display", "block");
    } else {
        a--;
        $(".weui-btn_disabled span").html(a);
        setTimeout(function () { count_down(a) }, 1000);
    }
}
</script>
<?php
require_once '../footer.php';
?>