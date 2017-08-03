<?php
exit(0);
define ( 'RELATIVITY_PATH', '../../../' );
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/userGroup.class.php';
$o_group = new userGroup();
$o_stu=new Student_Onboard_Info_Class_Wechat_View();
$o_stu->getAllCount();
for($i=0;$i<$o_stu->getAllCount();$i++)
{
	$s_result=$o_group->updateGroup($o_stu->getOpenid($i),100);
	print_r($s_result);
	echo('<br/><br/>');
}
/*
$s_title='';

//设置微信公众号标签
require_once RELATIVITY_PATH . 'sub/wechat/include/userGroup.class.php';
$o_group = new userGroup();
$s_result=$o_group->updateGroup($o_wx_user->getOpenId(),100);
echo($s_result.'<br/><br/>');
exit ( 0 );*/

echo('ok');
?>