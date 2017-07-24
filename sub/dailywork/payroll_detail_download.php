<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120601 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$o_user = new Single_User ( $O_Session->getUid () );
if ($o_user->ValidModule ( MODULEID ) == false) {
	echo ('<script type="text/javascript" src="'.RELATIVITY_PATH.'js/initialize.js"></script><script type="text/javascript">goto_login()</script>');
	exit (0);
}
$file_name = $_GET['id'].'.xlsx';
$file_dir = RELATIVITY_PATH.'/userdata/dailywork/payroll/';
$rename =  $_GET['date'].'.xlsx';
if (!file_exists($file_dir . $file_name)) { //检查文件是否存在
echo "File does not exist!";
exit;
} else {
// 一下是php文件下载的重点
Header("Content-type: application/octet-stream");
Header("Accept-Ranges: bytes");
Header("Content-Type: application/force-download");//强制浏览器下载
Header("Content-Disposition: attachment; filename=" . $rename);//重命名文件
Header("Accept-Length: ".filesize($file_dir . $file_name));//文件大小
// 读取文件内容
@readfile($file_dir.$file_name);//加@不输出错误信息
} 
?>