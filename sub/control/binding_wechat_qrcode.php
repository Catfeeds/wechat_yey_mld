<?php
define ( 'RELATIVITY_PATH', '../../' );
error_reporting(E_ERROR);
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/phpqrcode.php';
//根据用户角色所在的组，跳转到相应的绑定页面
$o_role=new Base_User_Role();
$o_role->PushWhere ( array ('&&', 'Uid', '=',$_GET['id']) );

if ($o_role->getAllCount()>0)
{
	$o_system=new Base_Setup(1);
	$o_role=new Base_Role($o_role->getRoleId(0));
	switch ($o_role->getWechatGroupId())
	{
		case '100':
		  $url=urldecode($o_system->getHomeUrl().'sub/wechat/wechat_teacher/binding_account.php?id='.$_GET['id']);
		  QRcode::png($url,false,QR_ECLEVEL_H,10,2,false);
		  break; 
		case '101':
		  $url=urldecode($o_system->getHomeUrl().'sub/wechat/wechat_teacher/binding_account.php?id='.$_GET['id']);
		  QRcode::png($url,false,QR_ECLEVEL_H,10,2,false);
		  break;  
	}
}else{
	exit(0);
}
?>