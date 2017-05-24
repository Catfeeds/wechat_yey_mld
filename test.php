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

/*
 * 添加班级接口示例
 */
/*
$a_data=array(
		'StudentId'=>41480,
		'ClassId'=>1686
		);
$request_data = array('License'=>$s_data,'Data'=>encrypt (json_encode($a_data), 'E', $key ));
$s_result=https_request('http://192.168.0.8/xcye_collect/xcyey_admin/sub/webservice/stu_change_class.php',$request_data);
echo($s_result);
/*
/*
 * 演示结束，如果成功，会返回{"Flag":"1"}，错误代码1004：数据库写入错误，错误代码1003：未找到要去的班，错误代码1002：不是本校学生，无权操作
 */

/*
 * 添加幼儿信息接口示例
 */
/*
$a_data=array(
		'ClassId'=>1686,
		'Id'=>'110107201310170037',
		'IdType'=>'居民身份证',
		'Birthday'=>'2014-02-23',
		'Name'=>'吴思远',
		'Sex'=>'男',
		'Nationality'=>'中国',
		'Gangao'=>'非港澳台侨',
		'Nation'=>'汉族',
		'Only'=>'是',
		'OnlyCode'=>'123456',
		'IsFirst'=>'',
		'IsLieshi'=>'否',
		'IsGuer'=>'否',
		'IsWugong'=>'否',
		'IsLiushou'=>'非留守儿童',
		'IsDibao'=>'否',
		'DibaoCode'=>'',
		'IsZizhu'=>'否',
		'IsCanji'=>'否',
		'CanjiCode'=>'',
		'CanjiType'=>'',
		'Jiankang'=>'健康或良好',
		'Xuexing'=>'未知血型',
		'IsYiwang'=>'否',
		'Illness'=>'',
		'IsShoushu'=>'否',
		'Shoushu'=>'',
		'IsYizhi'=>'否',
		'IsGuomin'=>'否',
		'Allergic'=>'',
		'IsYichuan'=>'否',
		'Qitabingshi'=>'',
		'Beizhu'=>'备注',
		'C_City'=>'110000000000',
		'C_Area'=>'110102000000',
		'C_Street'=>'',
		'IdQuality'=>'非农业户口',
		'IdQuality'=>'城市',
		'H_City'=>'110000000000',
		'H_Area'=>'110102000000',
		'H_Street'=>'广外街道',
		'H_Shequ'=>'红莲北里社区',
		'H_Add'=>'宣武区红莲北里9号楼2单元405号',
		'H_Owner'=>'吴江',
		'H_Guanxi'=>'父母',
		'Z_Same'=>'否',
		'Z_City'=>'北京市',
		'Z_Area'=>'西城区',
		'Z_Street'=>'广外街道',
		'Z_Shequ'=>'红莲北里社区',
		'Z_Add'=>'宣武区红莲北里9号楼2单元405号',
		'Z_Property'=>'直系亲属房产',
		'Z_Owner'=>'吴江',
		'Z_Guanxi'=>'父亲',
		'Jh_1_Connection'=>'父亲',
		'Jh_1_Name'=>'吴江',
		'Jh_1_IdType'=>'居民身份证',
		'Jh_1_Id'=>'13068319860123761X',
		'Jh_1_Job'=>'企业管理人员',
		'Jh_1_Danwei'=>'中国移动通信集团有限公司',
		'Jh_1_Jiaoyu'=>'硕士研究生',
		'Jh_1_Phone'=>'13910220512',
		'Jh_1_IsCanji'=>'否',
		'Jh_1_CanjiCode'=>'',
		'Jh_1_IsZhixi'=>'是',
		'Jh_2_Connection'=>'母亲',
		'Jh_2_Name'=>'吴静',
		'Jh_2_IdType'=>'居民身份证',
		'Jh_2_Id'=>'43090219851217904X',
		'Jh_2_Job'=>'机关或事业单位干部职工',
		'Jh_2_Danwei'=>'北京市教育委员会',
		'Jh_2_Jiaoyu'=>'硕士研究生',
		'Jh_2_Phone'=>'13810016186',
		'Jh_2_IsCanji'=>'否',
		'Jh_2_CanjiCode'=>'',
		'Jh_2_IsZhixi'=>'是',
		'JianhuName'=>'祖母',
		'JianhuConnection'=>'王志敏',
		'JianhuPhone'=>'13693205820',
		'Jiudu'=>'走读',
		);
$request_data = array('License'=>$s_data,'Data'=>encrypt (json_encode($a_data), 'E', $key ));
$s_result=https_request('http://192.168.0.8/xcye_collect/xcyey_admin/sub/webservice/add_stu.php',$request_data);
echo($s_result);
*/
/*
 * 演示结束，如果成功，会返回{"Flag":"1"}，错误代码1004：数据库写入错误，错误代码1003：未找到要去的班，错误代码1002：不是本校学生，无权操作
 */


/*
 * 添加幼儿信息接口示例
 */
/*
$a_data=array(
		'StudentId'=>'47315',
		'ClassId'=>'1685',
		'Id'=>'110101198110061538',
		'IdType'=>'居民身份证',
		'Birthday'=>'2014-02-23',
		'Name'=>'吴思远',
		'Sex'=>'男',
		'Nationality'=>'中国',
		'Gangao'=>'非港澳台侨',
		'Nation'=>'汉族',
		'Only'=>'是',
		'OnlyCode'=>'123456',
		'IsFirst'=>'',
		'IsLieshi'=>'否',
		'IsGuer'=>'否',
		'IsWugong'=>'否',
		'IsLiushou'=>'非留守儿童',
		'IsDibao'=>'否',
		'DibaoCode'=>'',
		'IsZizhu'=>'否',
		'IsCanji'=>'否',
		'CanjiCode'=>'',
		'CanjiType'=>'',
		'Jiankang'=>'健康或良好',
		'Xuexing'=>'未知血型',
		'IsYiwang'=>'否',
		'Illness'=>'',
		'IsShoushu'=>'否',
		'Shoushu'=>'',
		'IsYizhi'=>'否',
		'IsGuomin'=>'否',
		'Allergic'=>'',
		'IsYichuan'=>'否',
		'Qitabingshi'=>'',
		'Beizhu'=>'备注',
		'C_City'=>'110000000000',
		'C_Area'=>'110102000000',
		'C_Street'=>'',
		'IdQuality'=>'非农业户口',
		'IdQuality'=>'城市',
		'H_City'=>'110000000000',
		'H_Area'=>'110102000000',
		'H_Street'=>'广外街道',
		'H_Shequ'=>'红莲北里社区',
		'H_Add'=>'宣武区红莲北里9号楼2单元405号',
		'H_Owner'=>'吴江',
		'H_Guanxi'=>'父母',
		'Z_Same'=>'否',
		'Z_City'=>'北京市',
		'Z_Area'=>'西城区',
		'Z_Street'=>'广外街道',
		'Z_Shequ'=>'红莲北里社区',
		'Z_Add'=>'宣武区红莲北里9号楼2单元405号',
		'Z_Property'=>'直系亲属房产',
		'Z_Owner'=>'吴江',
		'Z_Guanxi'=>'父亲',
		'Jh_1_Connection'=>'父亲',
		'Jh_1_Name'=>'吴江',
		'Jh_1_IdType'=>'居民身份证',
		'Jh_1_Id'=>'13068319860123761X',
		'Jh_1_Job'=>'企业管理人员',
		'Jh_1_Danwei'=>'中国移动通信集团有限公司',
		'Jh_1_Jiaoyu'=>'硕士研究生',
		'Jh_1_Phone'=>'13910220512',
		'Jh_1_IsCanji'=>'否',
		'Jh_1_CanjiCode'=>'',
		'Jh_1_IsZhixi'=>'是',
		'Jh_2_Connection'=>'母亲',
		'Jh_2_Name'=>'吴静',
		'Jh_2_IdType'=>'居民身份证',
		'Jh_2_Id'=>'43090219851217904X',
		'Jh_2_Job'=>'机关或事业单位干部职工',
		'Jh_2_Danwei'=>'北京市教育委员会',
		'Jh_2_Jiaoyu'=>'硕士研究生',
		'Jh_2_Phone'=>'13810016186',
		'Jh_2_IsCanji'=>'否',
		'Jh_2_CanjiCode'=>'',
		'Jh_2_IsZhixi'=>'是',
		'JianhuName'=>'祖母',
		'JianhuConnection'=>'王志敏',
		'JianhuPhone'=>'13693205820',
		'Jiudu'=>'走读', 
		);
$request_data = array('License'=>$s_data,'Data'=>encrypt (json_encode($a_data), 'E', $key ));
$s_result=https_request('http://192.168.0.8/xcye_collect/xcyey_admin/sub/webservice/modify_stu.php',$request_data);
echo($s_result);
*/
/*
 * 演示结束，如果成功，会返回{"Flag":"1"}，错误代码1004：数据库写入错误，错误代码1003：未找到要去的班，错误代码1002：不是本校学生，无权操作
 */


/*
 * 删除幼儿信息接口示例
 */
/*
$request_data = array('License'=>$s_data,'StudentId'=>encrypt ('0', 'E', $key )); 
$s_result=https_request('http://192.168.0.8/xcye_collect/xcyey_admin/sub/webservice/delete_stu.php',$request_data); 
echo($s_result); 
*/
/*
 * 演示结束，如果成功，会返回{"Flag":"1"}
 */


/*
 * 检查幼儿ID是否有重复，如果有重复，返回0和重复的幼儿园，班级，没有重复返回1
 */
$a_data=array(
		'IdType'=>'居民身份证',
		'Id'=>'110104201201312025'
		);
$request_data = array('License'=>$s_data,'Data'=>encrypt (json_encode($a_data), 'E', $key )); 
$s_result=https_request('http://810717.cicp.net/xcye_collect/xcyey_admin/sub/webservice/check_stu_id.php',$request_data); 
echo($s_result); 
/*
 * 演示结束，如果成功，会返回{"Flag":"1"}
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