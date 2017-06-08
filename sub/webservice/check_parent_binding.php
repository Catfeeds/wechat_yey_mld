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
require_once RELATIVITY_PATH . 'sub/wechat/include/userGroup.class.php';
$o_group = new userGroup();
/*
 * 读取绑定的所有信息，然后循环检查StudentId是否在园，如果不在园，解除绑定同时移出分组
 * 
 */
$o_binding=new Student_Onboard_Info_Wechat();
for($i=0;$i<$o_binding->getAllCount();$i++)
{
	$o_stu=new Student_Onboard_Info_Class_View();
	$o_stu->PushWhere ( array ('&&', 'StudentId', '=',$o_binding->getStudentId($i)) ); 
	if ($o_stu->getAllCount()==0)
	{
		//删除本记录，并移出分组
		$o_temp=new Student_Onboard_Info_Wechat($o_binding->getId($i));
		//如果该家长没有其他绑定信息，那么删除用户分组
		$o_temp_binding=new Student_Onboard_Info_Wechat();
		$o_temp_binding->PushWhere ( array ('||', 'UserId', '=',$o_temp->getUserId()) );
		$o_temp_binding->PushWhere ( array ('&&', 'Id', '<>',$o_temp->getId()) );
		if ($o_temp_binding->getAllCount()==0)
		{
			//没有其他信息，才删除用户分组
			$o_parent=new WX_User_Info($o_temp->getUserId());
			$o_group->updateGroup($o_parent->getOpenId(),0);
		}
		$o_temp->Deletion();
	}
}
echo('Finished');
?>