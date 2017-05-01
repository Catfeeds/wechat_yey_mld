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
          	"name":"了解马幼",
          	"sub_button": [
                {
                    "type": "view", 
                    "name": "园所简介", 
                    "url": "http://mp.weixin.qq.com/s/RKoaM3d1omY5Z4tPplITcw" 
                }
            ]
        }, 
        {
            "type":"click",
          	"name":"幼儿教育",
          	"key": "2"
        }, 
        {
            "name": "社会公众", 
            "sub_button": [
                {
                    "type": "view", 
                    "name": "在线报名", 
                    "url": "http://wx.mldyey.com/sub/wechat/parent_signup/signup_agreement.php" 
                }, 
                {
					"type": "view", 
                    "name": "我的报名", 
                    "url": "http://wx.mldyey.com/sub/wechat/parent_signup/my_signup.php" 
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