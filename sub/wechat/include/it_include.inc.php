<?php
if(isset($RELATIVITY_PATH))
{
	//如果相对路径设置过，那么相对路径改为设置的值，否则用默认值
	define ( 'RELATIVITY_PATH',$RELATIVITY_PATH);
}else{	define ( 'RELATIVITY_PATH', '../../' );
}
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
$b_login=false;
$n_uid=0;
$S_Session_Id= $_COOKIE ['SESSIONID'];
if (isset ( $_COOKIE ['SESSIONID'] )) {//检查是否保存了Session
	setcookie ( 'SESSIONID', 'b2d59a268d676e7bf7498dd2acb18d01',0 ,'/','',false,true);
	$S_Session_Id= $_COOKIE ['SESSIONID'];
	$o_user = new WX_User_Info ();
	$o_user->PushWhere ( array ('&&', 'SessionId', '=',$S_Session_Id) );	if ($o_user->getAllCount () > 0) {
		$b_login=true;
		$n_uid=$o_user->getId ( 0 );
	} else {
		$n_uid=0;
	}
} else {
	//如果Sessionid不存在，说明第一次打开，跳转到index页面去获得Sessionid
	$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	echo ('<script>location=\''.RELATIVITY_PATH.'sub/wechat/index.php?url='.$url.'\'</script>');
	exit ( 0 );
}
if ($b_login == false) //如果登陆信息，验证用户是否已经注册
{
	require_once RELATIVITY_PATH . 'sub/wechat/include/userUtil.php';
	require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
	$o_userUtil = new userUtil();
	$openId = $o_userUtil->open_id;
	//判断用户是否已经关注，如果未关注，弹出扫描二维码关注页面。
	$o_token=new accessToken();
	$s_token=$o_token->access_token;
	$s_url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$s_token.'&openid='.$openId.'&lang=zh_CN';
	$o_util=new curlUtil();
	$s_return=$o_util->https_request($s_url);
	$a_user_info=json_decode($s_return, true);
	if ($a_user_info['subscribe']!=1)
	{
		//说明没有关注微信,退出
		echo "<script>location.href='".RELATIVITY_PATH."'sub/wechat/subscription.php'</script>"; 
		exit(0);
	}
	//	
	$o_user = new WX_User_Info ();
	$o_user->PushWhere ( array ('&&', 'OpenId', '=', $openId ) );
	if ($o_user->getAllCount()>0)
	{		$n_uid=$o_user->getId ( 0 );
		$o_user = new WX_User_Info ($o_user->getId(0));
		$o_user->setSessionId($S_Session_Id);
		//更新用户微信信息----------------
		require_once RELATIVITY_PATH . 'include/bn_basic.class.php';		$o_bn_basic=new Bn_Basic();
	    $o_user->setPhoto($a_user_info['headimgurl']);
		$o_user->setNickname($o_bn_basic->FilterEmoji($a_user_info['nickname']));
		if ($a_user_info['sex']==2)
		{
			$o_user->setSex('女');
		}else{
			$o_user->setSex('男');
		}
		//----------------------------------
		$o_user->Save();
		$b_login=true;
	}else{		//如果不在用户数据内，需要添加数据
		$o_user = new WX_User_Info ();
		$o_user->PushWhere ( array ('&&', 'OpenId', '=', $openId ) );
		if ($o_user->getAllCount()==0)
		{
			//如果不在用户数据内，需要添加数据，并将用户归到荷兰旅游专家的子账号里。
			$o_user = new WX_User_Info();
			$o_user->setOpenId($openId);
	        require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
	        $o_bn_basic=new Bn_Basic();
	        $o_user->setPhoto($a_user_info['headimgurl']);
			$o_user->setNickname($o_bn_basic->FilterEmoji($a_user_info['nickname']));
			if ($a_user_info['sex']==2)
			{
				$o_user->setSex('女');
			}else{
				$o_user->setSex('男');
			}
			$o_user->setDelFlag(0);
			$o_user->setUserName('');
			$o_user->setCompany('');
			$o_user->setAddress('');
			$o_user->setDeptJob('');
			$o_user->setPhone('');
			$o_user->setEmail('');
			$o_user->Save();
		}
		$n_uid=0;
	}
}
if ($b_login == false)
{
	echo ('<script type="text/javascript">location=\''.$_SERVER['PHP_SELF'].'\'</script>');
	exit ( 0 );
}	
$o_wx_user=new WX_User_Info($n_uid);
?>