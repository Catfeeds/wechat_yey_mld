<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
$key = 'www.bjsql.com';
$license = 'MNJIHKI6525489';
$s_data = encrypt ( $license, 'E', $key );

//$a_result=json_decode(https_request('http://3.36.220.52/xcye_collect/xcyey_admin/sub/webservice/download_class.php',$request_data));
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

/*
 * 修改班级接口示例
 */
/*
$a_data=array(
		'ClassId'=>661,
		'Grade'=>3,
		'ClassName'=>'中一班1'
		);
$request_data = array('License'=>$s_data,'Data'=>encrypt (json_encode($a_data), 'E', $key ));
$s_result=https_request('http://3.36.220.52/xcye_collect/xcyey_admin/sub/webservice/modify_class.php',$request_data);
echo($s_result);
*/
/*
 * 演示结束，错误码如果为1005：未找到指定班级，1004：数据库写入错误
 */


/*
 * 添加班级接口示例
 */
/*
$a_data=array(
		'Grade'=>3,
		'ClassName'=>'中一班1'
		);
$request_data = array('License'=>$s_data,'Data'=>encrypt (json_encode($a_data), 'E', $key ));
$s_result=https_request('http://3.36.220.52/xcye_collect/xcyey_admin/sub/webservice/add_class.php',$request_data);
echo($s_result);
*/
/*
 * 演示结束，如果成功，会返回{"Flag":"1","ClassId":1843}，如果错误代码1004：数据库写入错误
 */

/*
 * 删除班级接口示例
 */
/*
$request_data = array('License'=>$s_data,'ClassId'=>encrypt ('1685', 'E', $key ));
$s_result=https_request('http://3.36.220.52/xcye_collect/xcyey_admin/sub/webservice/delete_class.php',$request_data);
echo($s_result);
*/
/*
 * 演示结束，如果成功，会返回{"Flag":"1"}，如果错误代码1006:班级下面有幼儿，不能删除
 */


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