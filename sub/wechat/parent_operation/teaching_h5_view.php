<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
$o_stu=new Student_Onboard_Info_Class_Wechat_View();
$o_stu->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
$o_stu->getAllCount();
$o_table=new Teaching_H5_View($_GET['id']);
$o_tabel_count_visitor=new Teaching_H5($_GET['id']);
$a_target=json_decode($o_table->getTarget());
//判断用户是否有权限观看
if (!in_array($o_stu->getClassNumber(0), $a_target))
{
	//echo "<script>location.href='wei_teach.php'</script>"; 
	exit(0);
}
$s_title=$o_table->getTitle();
//计算观看次数
$o_tabel_count_visitor->setVisitorNum($o_tabel_count_visitor->getVisitorNum()+1);
$o_tabel_count_visitor->Save();
echo "<script>location.href='".$o_table->getVideo()."'</script>";
?>