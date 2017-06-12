<?php
//exit();
/*
 * 幼儿信息与教委信息采集系统同步
 */
ignore_user_abort(true);//在关闭连接后，继续运行php脚本
ini_set("max_execution_time",1800);
set_time_limit(300);
define('RELATIVITY_PATH', '../../'); //定义相对路径
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
$o_sys_setup=new Base_Setup(1);
/*
 * 设置同步所需验证信息
 */
$key=$o_sys_setup->getXcyeCollectKey();
$license=$o_sys_setup->getXcyeCollectLicense();
$s_url=$o_sys_setup->getXcyeCollectUrl();

//$s_url = 'http://192.168.0.8/xcye_collect/xcyey_admin/sub/webservice/';
//$s_url = 'http://yeygl.xchjw.cn/sub/webservice/';//接口地址
//$s_url = 'http://810717.cicp.net/xcye_collect/xcyey_admin/sub/webservice/';//花生壳接口地址
$license = encrypt ( $license, 'E', $key );
/*
 * 获取系统配置
 */

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
	//清空所有数据
	$o_class = new Student_Class ();
	$o_class->DeleteAll();
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
	LOG::STU_SYNC('error,下载班级信息错误，终止同步');
	exit();
}
/*
 * 获取已毕业幼儿的ID信息
 */
$a_collect_graduate_id=array();
$request_data = array ('License' => $license );
$a_result_data = json_decode ( https_request ( $s_url . 'get_graduate_id.php', $request_data ) );
if ($a_result_data->Flag == 1) {
	$a_collect_graduate_id = $a_result_data->Data;
	LOG::STU_SYNC('success,获取已毕业幼儿ID信息成功，共'.count($a_collect_graduate_id).'个记录');
} else {
	if ($a_result_data == '') {
		LOG::STU_SYNC('error,获取已毕业幼儿ID信息：信息采集系统服务器未响应');
	} else {
		LOG::STU_SYNC('error,获取已毕业幼儿ID信息：错误代码：' . $a_result_data->Msg);
	}
	LOG::STU_SYNC('error,获取已毕业幼儿ID信息错误，终止同步');
	exit();
}
/*
 * 读取本地已毕业幼儿信息，将ID放入一个数组
 */
$a_graduate_id=array();
$o_stu_graduate=new Student_Graduate_Info();
for($i=0;$i<$o_stu_graduate->getAllCount();$i++)
{
	array_push($a_graduate_id, $o_stu_graduate->getStudentId($i));
}
LOG::STU_SYNC('success,将本地'.count($a_graduate_id).'个已毕业幼儿信息Push到数组成功');
/*
 * 根据已毕业幼儿ID信息，计算需要同步的幼儿ID
 */
$n_same=0;
$a_graduate_need_insert=array();
for($i=0;$i<count($a_collect_graduate_id);$i++)
{
	//如果系统内存在，那么跳过
	$a_temp=$a_collect_graduate_id[$i];
	if (in_array($a_temp->StudentId, $a_graduate_id))
	{
		$n_same++;
		continue;
	}
	//将需要插入的已毕业幼儿信息，想记录下来
	array_push($a_graduate_need_insert, $a_temp->StudentId);
}
LOG::STU_SYNC('success,将采集系统已毕业幼儿信息同步到本地，共'.count($a_collect_graduate_id).'个信息，个'.$n_same.'相同，'.count($a_graduate_need_insert).'个新增');
/*
 * 根据需要插入的已毕业信息的ID，循环读取采集系统的已毕业幼儿信息的详细数据
 */
for($i=0;$i<count($a_graduate_need_insert);$i++)
{
	$a_collect_graduate_info=array();
	$request_data = array ('License' => $license,'StudentId'=>encrypt ( $a_graduate_need_insert[$i], 'E', $key ));
	$a_result_data = json_decode ( https_request ( $s_url . 'get_single_graduate_info.php', $request_data ));
	if ($a_result_data->Flag == 1) {
		$a_collect_graduate_info = $a_result_data->Data;
		//echo(print_r($a_collect_graduate_info));
		//保存到本地数据库
		$o_graduate=new Student_Graduate_Info();
		$a_keys=array_keys(get_object_vars($a_collect_graduate_info));
		for($j=0;$j<count($a_keys);$j++)
		{
			$s_from_key=$a_keys[$j];
			$s_to_key=str_replace('_', '', $a_keys[$j]);
			eval('$o_graduate->set'.$s_to_key.'($a_collect_graduate_info->'.$s_from_key.');');
		}
		$o_graduate->setDeptId($s_deptid);
		$o_graduate->setGradeNumber($a_collect_graduate_info->Grade);
		$o_graduate->setClassNumber($a_collect_graduate_info->Class);
		$o_graduate->setStudentId($a_collect_graduate_info->Uid);
		if($o_graduate->Save()==false)
		{
			LOG::STU_SYNC('error,获取编号为'.$a_graduate_need_insert[$i].'的已毕业幼儿信息：插入数据库不成功');
		}
	} else {
		if ($a_result_data == '') {
			LOG::STU_SYNC('error,获取编号为'.$a_graduate_need_insert[$i].'的已毕业幼儿信息：信息采集系统服务器未响应');
		} else {
			LOG::STU_SYNC('error,获取编号为'.$a_graduate_need_insert[$i].'的已毕业幼儿信息：错误代码：' . $a_result_data->Msg);
		}
	}
}
/*
 * 获取在园幼儿信息ID
 */
$a_collect_stu_id=array();
$request_data = array ('License' => $license );
$a_result_data = json_decode ( https_request ( $s_url . 'get_stu_id.php', $request_data ) );
if ($a_result_data->Flag == 1) {
	$a_collect_stu_id = $a_result_data->Data;
	LOG::STU_SYNC('success,获取在园幼儿ID信息成功，共'.count($a_collect_stu_id).'个记录');
} else {
	if ($a_result_data == '') {
		LOG::STU_SYNC('error,获取在园幼儿ID信息：信息采集系统服务器未响应');
	} else {
		LOG::STU_SYNC('error,获取在园幼儿ID信息：错误代码：' . $a_result_data->Msg);
	}
	LOG::STU_SYNC('error,获取在园幼儿ID信息错误，终止同步');
	exit();
}
/*
 * 读取本地在园幼儿信息，将ID放入一个数组
 */
$a_stu_id=array();
//清空所有数据
$o_stu=new Student_Onboard_Info();
$o_stu->DeleteAll();
$o_stu=new Student_Onboard_Info();
for($i=0;$i<$o_stu->getAllCount();$i++)
{
	array_push($a_stu_id, $o_stu->getStudentId($i));
}
LOG::STU_SYNC('success,将本地'.count($a_stu_id).'个在园幼儿信息Push到数组成功');
/*
 * 根据在园幼儿ID信息，计算需要同步的幼儿ID
 */
$n_same=0;
$a_stu_need_insert=array();
for($i=0;$i<count($a_collect_stu_id);$i++)
{
	//如果系统内存在，那么跳过
	$a_temp=$a_collect_stu_id[$i];
	if (in_array($a_temp->StudentId, $a_stu_id))
	{
		$n_same++;
		continue;
	}
	//将需要插入的已毕业幼儿信息，想记录下来
	array_push($a_stu_need_insert, $a_temp->StudentId);
}
LOG::STU_SYNC('success,将采集系统已毕业幼儿信息同步到本地，共'.count($a_collect_stu_id).'个信息，个'.$n_same.'相同，'.count($a_stu_need_insert).'个新增');
/*
 * 根据需要插入的在园信息的ID，循环读取采集系统的在园幼儿信息的详细数据
 */
for($i=0;$i<count($a_stu_need_insert);$i++)
{
	$a_collect_stu_info=array();
	$request_data = array ('License' => $license,'StudentId'=>encrypt ( $a_stu_need_insert[$i], 'E', $key ));
	$a_result_data = json_decode ( https_request ( $s_url . 'get_single_stu_info.php', $request_data ));
	if ($a_result_data->Flag == 1) {
		$a_collect_stu_info = $a_result_data->Data;
		//保存到本地数据库
		$o_graduate=new Student_Onboard_Info();
		$a_keys=array_keys(get_object_vars($a_collect_stu_info));
		for($j=0;$j<count($a_keys);$j++)
		{
			$s_from_key=$a_keys[$j];
			$s_to_key=str_replace('_', '', $a_keys[$j]);
			eval('$o_graduate->set'.$s_to_key.'($a_collect_stu_info->'.$s_from_key.');');
		}
		$o_graduate->setDeptId($s_deptid);
		$o_graduate->setGradeNumber($a_collect_stu_info->Grade);
		$o_graduate->setClassNumber($a_collect_stu_info->Class);
		$o_graduate->setStudentId($a_collect_stu_info->Uid);
		if($o_graduate->Save()==false)
		{
			LOG::STU_SYNC('error,获取编号为'.$a_stu_need_insert[$i].'的已毕业幼儿信息：插入数据库不成功');
		}
	} else {
		if ($a_result_data == '') {
			LOG::STU_SYNC('error,获取编号为'.$a_stu_need_insert[$i].'的已毕业幼儿信息：信息采集系统服务器未响应');
		} else {
			LOG::STU_SYNC('error,获取编号为'.$a_stu_need_insert[$i].'的已毕业幼儿信息：错误代码：' . $a_result_data->Msg);
		}
	}
}
echo ('finish');

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