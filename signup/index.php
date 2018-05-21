<?php
define ( 'RELATIVITY_PATH', '../' );
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
if (isset ( $_COOKIE ['SESSIONID'] )) {//检查是否保存了Session
	$o_date = new DateTime ( 'Asia/Chongqing' );
	$n_nowTime = $o_date->format ( 'U' );
	$S_Session_Id = md5 ( $_SERVER ['REMOTE_ADDR'] . $_SERVER ['HTTP_USER_AGENT'] . rand ( 0, 9999 ) . $n_nowTime );
	setcookie ( 'SESSIONID', $S_Session_Id, 0 ,'/','',false,true);
} else {
	//如果Sessionid不存在，说明第一次打开，跳转到index页面去获得Sessionid
	$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	echo ('<script>location=\''.RELATIVITY_PATH.'index.php?url='.$url.'\'</script>');
	exit ( 0 );
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>西城区马连道幼儿园，报名信息登记表在线打印登陆</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="<?php echo(RELATIVITY_PATH)?>js/initialize.js" type="text/javascript"></script>
	<link type="text/css" rel="stylesheet" media="screen and (max-width: 767px)" href="<?php echo(RELATIVITY_PATH)?>css/mobile.css" />
	<link type="text/css" rel="stylesheet" href="css/style.css" />
</head>
<body style="background-color:#F2F4F8">
	<div class="width1000">
		<h1 style="text-align:center">
		西城区马连道幼儿园，报名信息登记表在线打印登陆
		</h1>
		<img style="margin-top:100px;width:30%;margin-left:35%;margin-right:35%" src="login_qrcode.php?id=<?php echo($S_Session_Id)?>">
		<h3 style="text-align:center;margin-top:40px">
		微信扫码成功后页面将自动登陆
		</h3>
		<h4 style="text-align:center">
		注：请使用报名时的微信才可看到报名信息登记表
		</h4>
	</div>
<script>
var N_Timer=window.setInterval(wechat_get_lgoin_status,3000)
function wechat_get_lgoin_status() {
    var data = 'Ajax_FunName=WechatLogin'; //后台方法
    try {
    $.getJSON("include/bn_submit.switch.php?id=<?php echo($S_Session_Id)?>", data, function (json) {
    	if(json.flag==1)
		{
			location='signup_info.php';
		}
    })
    }catch(e){
    	window.clearInterval(N_Timer)
    	location="../browser_error.html"
    }
}
wechat_get_lgoin_status()
</script>	
</body>
</html>
