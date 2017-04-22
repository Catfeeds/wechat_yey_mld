<?php
define ( 'RELATIVITY_PATH', '../../' );

header('Content-Type: text/html; charset=UTF-8');

include(dirname(__FILE__)."/include/accessToken.class.php");

$token = new accessToken();
$ACC_TOKEN= $token->access_token;
 
$data='{ 
    "button": [
        {
            "type":"view",
          	"name":"学生信息",
          	"url":"http://xchmsxx.xchjw.cn/sub/wechat/student_idcard.php"
        }, 
        {
            "type":"view",
          	"name":"家长须知",
          	"url":"http://mp.weixin.qq.com/s/yQyiyTlGHI1p6hsVl_I_Jg"
        }, 
        {
            "name": "在线报名", 
            "sub_button": [
                {
                    "type": "view", 
                    "name": "马上报名", 
                    "url": "http://xchmsxx.xchjw.cn/sub/wechat/signup.php" 
                }, 
                {
					"type": "view", 
                    "name": "等待录取", 
                    "url": "http://xchmsxx.xchjw.cn/sub/wechat/waiting_signup.php" 
                }, 
                {
                    "type": "view", 
                    "name": "等待交费", 
                    "url": "http://xchmsxx.xchjw.cn/sub/wechat/waiting_pay.php" 
                 }, 
                {
                    "type": "view", 
                    "name": "交费记录", 
                    "url": "http://xchmsxx.xchjw.cn/sub/wechat/record_pay.php" 
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