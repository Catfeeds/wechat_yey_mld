<?php
//exit(0);
define ( 'RELATIVITY_PATH', '../../' );

header('Content-Type: text/html; charset=UTF-8');

include(dirname(__FILE__)."/include/accessToken.class.php");

$token = new accessToken();
$ACC_TOKEN= $token->access_token;
 
$data='{ 
    "button": [
        {
          	"name":"走进马幼",
          	"sub_button": [
                {
                    "type": "view", 
                    "name": "园所简介", 
                    "url": "http://mp.weixin.qq.com/s/RKoaM3d1omY5Z4tPplITcw" 
                },
                {
                	"type":"click",
		          	"name":"办园理念",
		          	"key": "2"
                },
                {
                	"type":"click",
		          	"name":"师资力量",
		          	"key": "2"
                },
                {
                	"type":"click",
		          	"name":"电子游园",
		          	"key": "2"
                },
                {
                	"type":"click",
		          	"name":"联系方式",
		          	"key": "2"
                }
            ]
        }, 
        {
            "name":"公益活动",
          	"sub_button": [
                {
                    "type":"click",
		          	"name":"广外社区",
		          	"key": "2"
                },
                {
                	"type":"click",
		          	"name":"党员工建",
		          	"key": "2"
                },
                {
                	"type":"click",
		          	"name":"学习培养",
		          	"key": "2"
                },
                {
                	"type":"click",
		          	"name":"师生活动",
		          	"key": "2"
                },
                {
                	"type":"click",
		          	"name":"特色主题",
		          	"key": "2"
                }
            ]
        }, 
        {
            "name": "社会关注", 
            "sub_button": [
                {
                    "type": "view", 
                    "name": "招生报名", 
                    "url": "http://wx.mldyey.com/sub/wechat/parent_signup/my_signup.php" 
                },
                {
                	"type":"click",
		          	"name":"家园共育",
		          	"key": "2"
                },
                {
                	"type":"click",
		          	"name":"卫生保健",
		          	"key": "2"
                },
                {
                	"type":"click",
		          	"name":"成长发育",
		          	"key": "2"
                }
            ]
        }
    ]
}';



//var_dump($data);

$MENU_URL="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$ACC_TOKEN;

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
print_r($info);		//创建成功返回：{"errcode":0,"errmsg":"ok"}


if($menu->errcode == "0"){
	echo "菜单创建成功";
}else{
	echo "菜单创建失败";
}

?>