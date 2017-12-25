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
		"name":"走进马幼",
          	"sub_button": [
                {
                    "type": "click", 
                    "name": "园所简介", 
                    "key": "[1]" 
                },
                {
                	"type":"click",
		          	"name":"园所文化",
		          	"key": "[10]"
                }
            ]
	},
    {	
		"name":"育教资讯",
          	"sub_button": [
                {
                    "type":"click",
		          	"name":"师幼活动",
		          	"key": "[3,4]"
                },
                {
                	"type":"click",
		          	"name":"卫生保健",
		          	"key": "[11]"
                },
                {
                	"type":"click",
		          	"name":"家园社区",
		          	"key": "[5,6,7,8]"
                }
            ]
	},
    {	
		"name": "家园互动", 
            "sub_button": [
                { 
                    "type": "view", 
                    "name": "出勤请假", 
                    "url": "http://wx.mldyey.com/sub/wechat/parent_operation/askforleave_apply.php" 
                },
                { 
                    "type": "view", 
                    "name": "随拍随录", 
                    "url": "http://wx.mldyey.com/sub/wechat/parent_operation/snapshot.php" 
                },
                { 
                    "type": "view", 
                    "name": "幼儿读物", 
                    "url": "http://wx.mldyey.com/sub/wechat/parent_operation/book_list.php" 
                },
                {
					"type": "view", 
                    "name": "本周菜谱", 
                    "url": "http://wx.mldyey.com/sub/wechat/parent_operation/food_list.php"
                }
            ]
	}],
    "matchrule":{
      "tag_id":"100"
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