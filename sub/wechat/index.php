<?php
error_reporting(0);
define ( 'RELATIVITY_PATH', '../../' );
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
if ($_COOKIE ['SESSIONID'] == null) {
	$o_date = new DateTime ( 'Asia/Chongqing' );
	$n_nowTime = $o_date->format ( 'U' );
	$S_Session_Id = md5 ( $_SERVER ['REMOTE_ADDR'] . $_SERVER ['HTTP_USER_AGENT'] . rand ( 0, 9999 ) . $n_nowTime );
	setcookie ( 'VISITER', '', 0 ,'/','',false,true );
	setcookie ( 'SESSIONID', $S_Session_Id, 0 ,'/','',false,true);
	setcookie ( 'VALIDCODE', '222', 0 ,'/','',false,true);
	setcookie ( 'PHONE', '', 0 );
	setcookie ( 'OPENID', '', 0 );
	if (isset ( $_GET ['url'] ) && $_GET ['url']!='') {
		echo ('<script type="text/javascript">location=\'' . $_GET ['url'] . '\'</script>');
		exit ( 0 );	
	}
}
//echo ('<script>location=\'signup.php\'</script>');
exit ( 0 );
?>
