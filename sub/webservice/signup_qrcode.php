<?php
error_reporting(0);
set_time_limit(0);
define ( 'RELATIVITY_PATH', '../../' );
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
header("location:".getWechatTemporarySceneQr($_GET['id']));
//获得临时场景二维码Ticket，默认有效期30天
function getWechatTemporarySceneQr($n_id,$n_second=2592000)
{
    require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
    $o_token=new accessToken();
    $data = '{"expire_seconds": '.$n_second.',"action_name": "QR_STR_SCENE","action_info": {"scene": {"scene_str": "'.$n_id.'"}}}';
    $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$o_token->access_token;
    $res = https_request($url, $data);
    $result = json_decode($res, true);
    if ($result["errcode"]>0)
    {
        return 0;
    }else{
        return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($result["ticket"]);
    }
}
function https_request($url, $data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if(!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
?>