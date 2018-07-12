<?php
define ( 'RELATIVITY_PATH', '../' );
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
if (isset ( $_COOKIE ['SESSIONID'] )) {//检查是否保存了Session
	//setcookie ( 'SESSIONID', '377be4f48492037e4815e5fe5774cf44',0 ,'/','',false,true);
	$S_Session_Id= $_COOKIE ['SESSIONID'];
} else {
	//如果Sessionid不存在，说明第一次打开，跳转到index页面去获得Sessionid
	$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	echo ('<script>location=\''.RELATIVITY_PATH.'index.php?url='.$url.'\'</script>');
	exit ( 0 );
}
$s_openid=$_COOKIE ['VISITER'];
ob_start();
require_once RELATIVITY_PATH . 'include/db_table.class.php';
$o_wechat_signup=new Student_Info_Wechat_Wiew();
$o_wechat_signup->PushWhere ( array ('&&', 'OpenId', '=',$s_openid) );
$o_wechat_signup->PushWhere ( array ('&&', 'StudentId', '=',$_GET['id']) );
if ($o_wechat_signup->getAllCount()==0)
{
	echo('Error:Can not find record.');
	exit(0);
}
$o_stu=new Student_Info($_GET['id']);

function filter($str)
{
	if ($str=='')
	{
		echo('—');
	}else{
		echo($str);
	}
}
ob_start();
?>
<div align="center" style="padding-top:30px;">
    <div class="title">西城区马连道幼儿园2018年新生入园家长须知</div>
    <br/>
    <div style="font-size:20px;line-height:44px;">
为了解决当前入托难问题，我园利用有限条件进行了扩招，以下是2018年新生入园的相关要求，请您仔细阅读。<br>
1、幼儿入园时间：每天早8:00—8:30，离园时间：晚16:00—16:30（9月份入园适应时间另行通知）<br>
2、幼儿园伙食：幼儿园每日提供一餐、两点，包括午餐及早间点、午点。<br>
3、小班幼儿收费标准：保育费：900元/月。餐费：20元/天<br>
4、我园没有特殊教育的教师资源，如幼儿存在特殊情况（如自闭症、感统失调、攻击性行为、社会适应能力弱等问题或是严重食物过敏）不能适应集体生活，幼儿园有权劝其暂缓入园，待情况好转后送幼儿入园参与集体活动。<br>
5、幼儿每天早来园首先要接受保健医晨间健康检查，如发现疑似传染病病症，从幼儿健康角度出发，家长要积极配合保健医的要求及时到地段医院进行筛查，确诊无恙并开具证明后方可来园。<br>
6、由于幼儿园学位紧张，如您的孩子除寒暑假假期外，长期无故请假超过1个月，幼儿园有权向您发放《退园通知书》同时增补学位。如孩子因特殊原因需长时间请假，请您提前递交申请，经幼儿园批准后方可休假。<br/>
<b><i>请您仔细阅读以上内容并签名</i></b><br/>
以上内容本人已阅读并了解，_________（同意或不同意）以上要求，特此说明。<br/><br/>
幼儿编号：<u>&nbsp;<?php filter($o_stu->getStudentId())?>&nbsp;</u>&nbsp;&nbsp;幼儿姓名：  <u>&nbsp;<?php filter($o_stu->getName())?>&nbsp;</u>&nbsp;&nbsp;家长签字：___________<br/><br/>
<div style="text-align:right">2018年____月____日</div>
</div>
</div>
<?php 
$content = ob_get_clean();
require_once RELATIVITY_PATH . 'include/mpdf60/mpdf.php';

$mpdf=new mPDF('zh-CN','A4','','',32,25,27,25,16,13); 
$mpdf->AddPage('','','','','',10,10,10,10,10,10);
$mpdf->useAdobeCJK = true;
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('css/pdf.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($content,2);

$mpdf->Output(iconv ( 'UTF-8', 'gbk','西城区马连道幼儿园2018年新生入园家长须知.pdf'),'I');
exit;
?>
