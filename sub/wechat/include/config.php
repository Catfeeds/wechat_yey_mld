<?php
	require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
	$o_bn_base=new Bn_Basic();
	define("APPID",$o_bn_base->getWechatSetup('APPID'));
	define("APPSECRET",$o_bn_base->getWechatSetup('APPSECRET'));
?>