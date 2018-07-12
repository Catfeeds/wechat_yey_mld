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
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>西城区马连道幼儿园，家长须知在线打印</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="<?php echo(RELATIVITY_PATH)?>js/initialize.js" type="text/javascript"></script>
	<link type="text/css" rel="stylesheet" media="screen and (max-width: 767px)" href="<?php echo(RELATIVITY_PATH)?>css/mobile.css" />
	<link type="text/css" rel="stylesheet" href="css/style.css" />
</head>
<body style="background-color:#F2F4F8">
	<div class="width1000">
		<h1 style="text-align:center">
		西城区马连道幼儿园，家长须知在线打印
		</h1>
		<br/><br/><br/>
		<?php	
		require_once RELATIVITY_PATH . 'include/db_table.class.php';
		$o_wechat_signup=new Student_Info_Wechat_Wiew();
		$o_wechat_signup->PushWhere ( array ('&&', 'OpenId', '=',$s_openid) );
		for($i=0;$i<$o_wechat_signup->getAllCount();$i++)
		{
			$o_temp=new Student_Info($o_wechat_signup->getStudentId($i));
			$a_temp=explode('★', $o_temp->getAuditRemark());
			if (count($a_temp)>1)
			{
				$s_html='
				<div class="btu">
					<a target="_blank" href="signup_pdf.php?id='.$o_wechat_signup->getStudentId($i).'">打印家长须知</a>
				</div>
				';
			}
			?>
			<div class="tag">
				<b>报名编号：</b><?php echo($o_wechat_signup->getStudentId($i))?><br/>
				<b>幼儿姓名：</b><?php echo($o_wechat_signup->getName($i))?><br/>
				<b>身份证号码：</b><?php echo($o_wechat_signup->getId($i))?><br/>
				<b>性别：</b><?php echo($o_wechat_signup->getSex($i))?><br/>
				<b>出生日期：</b><?php echo($o_wechat_signup->getBirthday($i))?><br/>
				<?php echo($s_html)?>
			</div>
			<?php
		}
		if ($o_wechat_signup->getAllCount()==0)
		{
			?>
			<h3 style="text-align:center;margin-top:40px">
			系统中未找到报名信息
			</h3>
			<?php
		}
		?>
	</div>
<script>

</script>	
</body>
</html>
