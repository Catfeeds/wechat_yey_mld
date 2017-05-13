<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='报名须知';
require_once '../header.php';
?>
 	<div class="page__hd" style="padding:15px;">
        <h1 class="page__title" style="font-size:25px;text-align:center;padding-top:20px;padding-bottom:15px;">2016年招生公告</h1>
        <p class="page__desc">
根据上级指示精神，现对我园2016年招生工作公告如下：<br/><br/>
一、招生年龄范围：<br/>
    2013年8月31日之前出生的适龄幼儿<br/><br/>
二、招生名额：<br/>
 小班：75名 中班：6名 大班：3名<br/><br/>
三、报名流程：<br/>
（一）报名：6月3日早8:30—10日早8:30。6月10日早8:30后关闭登陆平台。报名方式：从幼儿园网站（http://www.mldyey.com/）下载报名表，把文件名改为幼儿姓名，填写后上传到幼儿园邮箱。<br/>
　邮箱地址：m121127@126.com<br/><br/>
（二）证件资格审验：<br/>
1、幼儿园对网上的报名登记表进行审验后，于6月13日17：00前对登记信息清晰、符合报名条件的，通过邮箱向家长下发“报名审验登记准入单”。家长自行打印报名审验登记准入单。<br/><br/>
6月16日—6月17日上午9:00—11:00, 家长依据“报名审验登记准入单”的规定时间，持“准入单”来园审验相关证明。即：户口本、幼儿身份证、房产证或租赁合同（房主与幼儿的关系）。幼儿预防接种证（小绿本）。其他特殊证明（华侨、烈士、现役军人、残疾等）。<br/><br/>
3、对于符合见面条件的，幼儿园同时发放“见面会准入单”。<br/><br/>
 （三）	见面会：6月23日—6月24日上午9:00—11:00家长带幼儿依据“见面会准入单”规定的时间，持“准入单”来园与老师见面。一名幼儿由一位家长带领进入幼儿园。<br/><br/>
（四）录取通知：7月4日—12日，通过E-mail发放电子“预录取通知书”。待幼儿体检合格后，发放录取通知书（马连道幼儿园新生家长一封信）<br/><br/>
幼儿园咨询电话:52990927转8008 <br/>
招生期间咨询时间:<br/>工作日9:00-10：00      15：00-16：00<br/>
说明：未被录取的幼儿，幼儿园不再另行通知。入园名额有限，敬请谅解。<br/>
			<span style="float:right;">
			马连道幼儿园<br/>
			&nbsp;&nbsp;2016.6.3
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