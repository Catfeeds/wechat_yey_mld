<?php
error_reporting(0);
set_time_limit(0);
define ( 'RELATIVITY_PATH', '../../' );
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
$o_sys_info=new Base_Setup(1);
$s_homepage=$o_sys_info->getHomeUrl();
$o_reminder=new Wechat_Wx_User_Reminder();
$o_reminder->PushWhere ( array ('&&', 'Send', '=',0) );
$n_count=$o_reminder->getAllCount();
if ($n_count>10)
{
	$n_count=10;
}
for($i=0;$i<$n_count;$i++)
{
	$o_temp=new Wechat_Wx_User_Reminder($o_reminder->getId($i));
	$o_temp->setSend(1);
	$o_date = new DateTime ( 'Asia/Chongqing' );
	$o_temp->setSendDate($o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ));
	sleep(1);
	//给用户发送消息
	require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
	$o_token=new accessToken();
	$curlUtil = new curlUtil();
	$s_url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$o_token->access_token;
	if ($o_temp->getKeywordSum()==4)
	{
		$data = array(
		'touser' => $o_reminder->getOpenId($i), // openid是发送消息的基础
		'template_id' => $o_reminder->getMsgId($i), // 模板id
		'url' => $o_reminder->getUrl($i), // 点击跳转地址
		'topcolor' => '#FF0000', // 顶部颜色
		'data' => array(
		'first' => array('value' => $o_reminder->getFirst($i).'
		'),
		'keyword1' => array('value' =>$o_reminder->getKeyword1($i),'color'=>'#173177'),
		'keyword2' => array('value' => $o_reminder->getKeyword2($i),'color'=>'#173177'),
		'keyword3' => array('value' => $o_reminder->getKeyword3($i),'color'=>'#173177'),
		'keyword4' => array('value' => $o_reminder->getKeyword4($i),'color'=>'#173177'),
		'remark' => array('value' =>'
'.$o_reminder->getRemark($i)) 
				)
		);
	}else if ($o_temp->getKeywordSum()==5){
		$data = array(
		'touser' => $o_reminder->getOpenId($i), // openid是发送消息的基础
		'template_id' => $o_reminder->getMsgId($i), // 模板id
		'url' => $o_reminder->getUrl($i), // 点击跳转地址
		'topcolor' => '#FF0000', // 顶部颜色
		'data' => array(
		'first' => array('value' => $o_reminder->getFirst($i).'
		'),
		'keyword1' => array('value' =>$o_reminder->getKeyword1($i),'color'=>'#173177'),
		'keyword2' => array('value' => $o_reminder->getKeyword2($i),'color'=>'#173177'),
		'keyword3' => array('value' => $o_reminder->getKeyword3($i),'color'=>'#173177'),
		'keyword4' => array('value' => $o_reminder->getKeyword4($i),'color'=>'#173177'),
		'keyword5' => array('value' => $o_reminder->getKeyword5($i),'color'=>'#173177'),
		'remark' => array('value' =>'
'.$o_reminder->getRemark($i)) 
				)
		);
	}else if ($o_temp->getKeywordSum()==3){
		$data = array(
		'touser' => $o_reminder->getOpenId($i), // openid是发送消息的基础
		'template_id' => $o_reminder->getMsgId($i), // 模板id
		'url' => $o_reminder->getUrl($i), // 点击跳转地址
		'topcolor' => '#FF0000', // 顶部颜色
		'data' => array(
		'first' => array('value' => $o_reminder->getFirst($i).'
		'),
		'keyword1' => array('value' =>$o_reminder->getKeyword1($i),'color'=>'#173177'),
		'keyword2' => array('value' => $o_reminder->getKeyword2($i),'color'=>'#173177'),
		'keyword3' => array('value' => $o_reminder->getKeyword3($i),'color'=>'#173177'),
		'remark' => array('value' =>'
'.$o_reminder->getRemark($i)) 
				)
		);
	}else{
		$data = array(
		'touser' => $o_reminder->getOpenId($i), // openid是发送消息的基础
		'template_id' => $o_reminder->getMsgId($i), // 模板id
		'url' => $o_reminder->getUrl($i), // 点击跳转地址
		'topcolor' => '#FF0000', // 顶部颜色
		'data' => array(
		'first' => array('value' => $o_reminder->getFirst($i).'
		'),
		'keyword1' => array('value' =>$o_reminder->getKeyword1($i),'color'=>'#173177'),
		'keyword2' => array('value' => $o_reminder->getKeyword2($i),'color'=>'#173177'),
		'remark' => array('value' =>'
'.$o_reminder->getRemark($i)) 
				)
		);
	}
	$a_result=json_decode($curlUtil->https_request($s_url, json_encode($data)));
	if ($a_result->errmsg=='ok')
	{
		$o_temp->Save();
	}
}
echo('Finished');
?>