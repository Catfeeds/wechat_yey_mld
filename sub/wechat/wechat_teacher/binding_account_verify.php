<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='';
//开始将微信绑定
//先查看参数中的id是否已经绑定微信了
$o_table=new Base_User_Wechat();
$o_table->PushWhere ( array ('&&', 'Uid', '=', $_GET['id'] ) );
if($o_table->getAllCount()>0)
{
	echo ('<script type="text/javascript">location=\'binding_account_failed.php\'</script>');
	exit ( 0 );
}
//第二步，获取用户的微信标签ID
$o_role=new Base_User_Role();
$o_role->PushWhere ( array ('&&', 'Uid', '=',$_GET['id']) );
if ($o_role->getAllCount()==0)
{
	echo ('<script type="text/javascript">location=\'binding_account_failed.php\'</script>');
	exit ( 0 );
}
$o_role=new Base_Role($o_role->getRoleId(0));
//绑定用户
$o_table=new Base_User_Wechat();
$o_table->setUid($_GET['id']);
$o_table->setWechatId($o_wx_user->getId());
$o_table->Save();
//设置用户数据组
$o_wx_user->setGroupId($o_role->getWechatGroupId());
$o_wx_user->Save();
//设置微信公众号标签
require_once RELATIVITY_PATH . 'sub/wechat/include/userGroup.class.php';
$o_group = new userGroup();
$o_group->updateGroup($o_wx_user->getOpenId(), $o_role->getWechatGroupId());
//给微信服务号，推送一个消息模板
require_once RELATIVITY_PATH . 'include/db_view.class.php';
$o_user=new View_User_Info($_GET['id']);
require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
$o_sys_info=new Base_Setup(1);
$o_token=new accessToken();
$curlUtil = new curlUtil();
$s_url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$o_token->access_token;
$o_date = new DateTime ( 'Asia/Chongqing' );
$data = array(
		'touser' => $o_wx_user->getOpenId(), // openid是发送消息的基础
		'template_id' => 'b-5B29byygnekop6K-ZdIAgTTuoLFCyRDqEyHHfqdd4', // 模板id
		'url' => $o_sys_info->getHomeUrl().'sub/wechat/wechat_teacher/binding_account_successful.php', // 点击跳转地址
		'topcolor' => '#FF0000', // 顶部颜色
		'data' => array(
			'first' => array('value' =>'您的微信已经成功绑定系统后台账号。
			'),
			'keyword1' => array('value' => $o_user->getName(),'color'=>'#173177'),
			'keyword2' => array('value' => $o_user->getUsername(),'color'=>'#173177'),
			'keyword3' => array('value' => $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ),'color'=>'#173177'),
			'remark' => array('value' => '') 
		)
	);
$curlUtil->https_request($s_url, json_encode($data));
echo ('<script type="text/javascript">location=\'binding_account_successful.php\'</script>');
exit ( 0 );
?>