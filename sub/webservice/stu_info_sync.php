<?php
/*
 * 幼儿信息与教委信息采集系统同步
 */
ignore_user_abort(true);//在关闭连接后，继续运行php脚本
set_time_limit(0);
define('RELATIVITY_PATH', '../../'); //定义相对路径
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
/*
 * 设置同步所需验证信息
 */
$key = 'www.bjsql.com';
$license = 'MNJIHKI6525489';
$s_url = 'http://yeygl.xchjw.cn/sub/webservice/';
$license = encrypt ( $license, 'E', $key );
/*
 * 获取系统配置
 */
require_once RELATIVITY_PATH . 'include/db_table.class.php';
//获取当前系统DeptId编号
$o_setup=new Admission_Setup(1);
$s_deptid=$o_setup->getDeptId();
/*
 * 下载班级信息
 */
$request_data = array ('License' => $license );
$a_result_data = json_decode ( https_request ( $s_url . 'download_class.php', $request_data ) );
if ($a_result_data->Flag == 1) {
	$a_data = $a_result_data->Data;
	//开始同步本地班级数据
	for($i = 0; $i < count ( $a_data ); $i ++) {
		$a_temp = $a_data [$i];
		//如果班级ID存在，那么跳过，否则新建
		$o_class = new Student_Class ();
		$o_class->PushWhere ( array ('&&', 'ClassId', '=', $a_temp->ClassId ) );
		if ($o_class->getAllCount()>0)
		{
			continue;
		}
		$o_class = new Student_Class ();
		$o_class->setClassId ( $a_temp->ClassId );
		$o_class->setSchoolId ( $s_deptid );
		$o_class->setClassNumber ( 0 );
		$o_class->setClassName ( $a_temp->ClassName );
		$o_class->setGrade ( $a_temp->Grade );
		$o_class->Save ();
	}
	LOG::STU_SYNC('success,下载班级信息成功');
} else {
	if ($a_result_data == '') {
		LOG::STU_SYNC('error,下载班级信息：信息采集系统服务器未响应');
	} else {
		LOG::STU_SYNC('error,下载班级信息： 错误代码：' . $a_result_data->Msg);
	}
	LOG::STU_SYNC('error,下载班级信息错误，终止同');
	exit();
}
/*
 * 获取已毕业幼儿信息 
 */
echo ('finish');

//$a_result=json_decode(https_request('http://3.36.220.52/xcye_collect/xcyey_admin/sub/webservice/get_stu_id.php',$request_data));
//$a_result=json_decode(https_request('http://3.36.220.52/xcye_collect/xcyey_admin/sub/webservice/get_single_stu_info.php',$request_data));
/*
$a_result=json_decode(https_request('http://3.36.220.52/xcye_collect/xcyey_admin/sub/webservice/get_graduate_id.php',$request_data));
$a_result=json_decode(https_request('http://yeygl.xchjw.cn/sub/webservice/get_single_graduate_info.php',$request_data));
if($a_result->Flag==1)
{
	$a_data=$a_result->Data;
	echo(count($a_data));
	//echo($a_data);
}else{
	echo($a_result->Msg);
}
*/
//echo(https_request('http://yeygl.xchjw.cn/sub/webservice/download_class.php',$request_data));
function https_request($url, $data = null) {
	$curl = curl_init ();
	curl_setopt ( $curl, CURLOPT_URL, $url );
	curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
	curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
	if (! empty ( $data )) {
		curl_setopt ( $curl, CURLOPT_POST, 1 );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
	}
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
	$output = curl_exec ( $curl );
	curl_close ( $curl );
	return $output;
}
function encrypt($string, $operation, $key = '') {
	$key = md5 ( $key );
	$key_length = strlen ( $key );
	$string = $operation == 'D' ? base64_decode ( $string ) : substr ( md5 ( $string . $key ), 0, 8 ) . $string;
	$string_length = strlen ( $string );
	$rndkey = $box = array ();
	$result = '';
	for($i = 0; $i <= 255; $i ++) {
		$rndkey [$i] = ord ( $key [$i % $key_length] );
		$box [$i] = $i;
	}
	for($j = $i = 0; $i < 256; $i ++) {
		$j = ($j + $box [$i] + $rndkey [$i]) % 256;
		$tmp = $box [$i];
		$box [$i] = $box [$j];
		$box [$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i ++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box [$a]) % 256;
		$tmp = $box [$a];
		$box [$a] = $box [$j];
		$box [$j] = $tmp;
		$result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
	}
	if ($operation == 'D') {
		if (substr ( $result, 0, 8 ) == substr ( md5 ( substr ( $result, 8 ) . $key ), 0, 8 )) {
			return substr ( $result, 8 );
		} else {
			return '';
		}
	} else {
		return str_replace ( '=', '', base64_encode ( $result ) );
	}
}
//file_put_contents('photo.jpg',file_get_contents("http://wx.mldyey.com/userdata/logo/logo.png"));
//echo(file_get_contents("http://wx.mldyey.com/userdata/logo/logo.png"));
exit ();
$s_date = '2017-05-06 09:00:00';
$result = array ();
function read_all_dir($dir) {
	global $result;
	global $s_date;
	$handle = opendir ( $dir );
	if ($handle) {
		while ( ($file = readdir ( $handle )) !== false ) {
			if ($file != '.' && $file != '..') {
				$cur_path = $dir . DIRECTORY_SEPARATOR . $file;
				if (is_dir ( $cur_path )) {
					read_all_dir ( $cur_path );
				} else {
					if (strtotime ( date ( "Y-m-d H:i:s", filemtime ( $cur_path ) ) ) > strtotime ( $s_date )) {
						array_push ( $result, $cur_path );
					}
				}
			}
		}
		closedir ( $handle );
	}
	return $result;
}
echo (json_encode ( read_all_dir ( 'sub' ) ));

?>