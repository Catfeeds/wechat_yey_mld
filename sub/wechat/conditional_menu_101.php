<?php
//教职工自定义菜单
define ( 'RELATIVITY_PATH', '../../' );
ini_set("display_errors", "On");
header('Content-Type: text/html; charset=UTF-8');

include(dirname(__FILE__)."/include/accessToken.class.php");

$token = new accessToken();
$ACC_TOKEN= $token->access_token;
$data='{ 
    "button":[
 	{	
		"name":"幼儿管理",
		"sub_button": [
                {
					"type": "click", 
                    "name": "考勤记录", 
                    "key": "[2]"
                }
            ]
	},
    {	
		"name":"个人信息",
		"sub_button": [
                {
					"type": "view", 
                    "name": "工资条", 
                    "url": "http://wx.mldyey.com/sub/wechat/teacher_operation/payroll.php" 
                }
            ]
	}],
    "matchrule":{
      "tag_id":"101"
    }
}';
$MENU_URL="https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=".$ACC_TOKEN;
$curl = curl_init($MENU_URL);
curl_setopt($curl, CURLOPT_URL, $MENU_URL);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
if (!empty($data)){
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
}
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$info = curl_exec($curl);
$menu = json_decode($info);
print_r($info);
if($menu->menuid >0){
	echo "菜单创建成功";
}else{
	echo "菜单创建失败";
}

?>