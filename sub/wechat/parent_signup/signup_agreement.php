<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='报名须知';
require_once '../header.php';
?>
 	<div class="page__hd" style="padding:15px;">
        <h1 class="page__title" style="font-size:25px;text-align:center;padding-top:20px;padding-bottom:15px;">报名须知</h1>
        <p class="page__desc" style="color:#666666;font-size:16px;">
根据北京市西城区有关幼儿园招生工作的精神，现对我园2018年招生工作公告如下：<br/><br/>
一、招生年龄范围：<br/>
2012年9月1日-2015年8月31日间出生的西城户籍适龄幼儿。<br/><br/>
二、招生名额：<br/>
小班：100名 ；中班：10名；大班：10名。<br/><br/>
三、报名流程：<br/>
（一）报名时间：2018年6月11日8:00—2018年6月16日17:00。2018年6月16日17:00起报名平台不再接收新报名申请。<br/><br/>
（二）报名形式：关注“马连道幼儿园”微信公众号，利用“社会关注”栏目下的“招生报名”功能如实填报幼儿信息并提交，提交成功后获得幼儿编号并请牢记。<br/><br/>
（三）证件资格审验：幼儿园对微信公众号上的报名信息进行审验后，于2018年6月20日17:00前对登记信息清晰、符合报名条件的报名信息进行初审通过。请家长点击“我的幼儿报名”中“状态详情”查看信息核验时段、地点、所携带物品及注意事项，并在规定的时段、地点，有序进行信息核验。<br/><br/>
（四）入园互动：信息核验通过后，于2018年6月27日17:00前，请符合信息初审条件的家长点击“我的幼儿报名”中“状态详情”获取“入园互动”时段、地点及注意事项。在规定的时段、地点，有序入园，参与互动。 <br/><br/>
（五）审核预录取：“入园互动”结束后，区教育纪检监察人员和幼儿园招生工作小组对预录取名单共同进行审核。<br/><br/>
（六）预录取体检：预录取名单审核通过后，于2018年7月25日17：00前，家长应按照“我的幼儿报名”“状态详情”中的体检时间、地点及注意事项带领幼儿参加体检。<br/><br/>
（七）正式录取：体检合格后，家长及时配合幼儿园进行信息采集。“信息采集”工作完成后家长需点击“状态详情”查看报到注册时间地点，并按要求完成报到注册手续。<br/><br/>
（八）未录取幼儿信息处置：招生结束后，对于2018年通过关注微信公众号报名未录取的所有报名信息，幼儿园按教委要求进行留存，存储期限过后会统一进行个人信息清除操作，届时我的幼儿报名下的报名信息将取消，以保护个人信息不因报名而泄露。<br/><br/>
特殊说明：小班部地址为红莲路茶马南街69号院（人民大会堂宿舍底商）。<br/><br/>
幼儿园报名咨询电话：52990927转8088<br/>
招生报名咨询时间：<br/>2018年6月11日-2018年6月29日期间工作日<br/>8:00-9:00、13:30-14:30<br/><br/>
<span style="text-decoration:underline">友情提示：因幼儿园招生名额有限，不能保证所报幼儿均被录取，家长根据自身情况可帮助幼儿选择其他幼儿园。</span><br/><br/>
<span style="float:right;text-align:right">
			感谢您的理解与参与
			</span><br/><br/><br/>
			<span style="float:right;text-align:right">
			北京市西城区马连道幼儿园<br/>
			2018年6月8日
			</span><br/><br/><br/><br/>
      	</p>
    </div>
    <div style="padding:15px;">
    	<?php 
    	//判断是否为合法报名时段
		$o_setup=new Admission_Setup(1); 
		$o_date = new DateTime('Asia/Chongqing');
		$s_date=$o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' );
		if (strtotime($s_date)>=strtotime($o_setup->getSignupStart()) && strtotime($s_date)<=strtotime($o_setup->getSignupEnd()))
		{
    	?>
		 <a class="weui-btn weui-btn_disabled weui-btn_primary"><span>20</span> 已阅读并同意</a>
		 <a id="next" href="signup_form.php" class="weui-btn weui-btn_primary" style="display:none">已阅读并同意</a>
		 <a onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));" class="weui-btn weui-btn_default">不同意</a>
		 <?php 
		}
		 ?>
	</div>
<script>
$(function(){
<?php 
if (strtotime($s_date)<strtotime($o_setup->getSignupStart()))
{
	echo('Dialog_Message("报名开始时间为：<br/>'.$o_setup->getSignupStart().' <br/>请在有效日期内进行报名。",function(){location=\'my_signup.php\'});
	');
}
if (strtotime($s_date)>strtotime($o_setup->getSignupEnd()))
{
	echo('Dialog_Message("报名已截止，截止时间：<br/>'.$o_setup->getSignupEnd().' ",function(){location=\'my_signup.php\'});');
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