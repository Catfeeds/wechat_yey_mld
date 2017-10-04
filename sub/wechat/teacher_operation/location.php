<?php
define ( 'RELATIVITY_PATH', '../../../' );
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
require_once RELATIVITY_PATH.'sub/wechat/include/db_table.class.php';
include RELATIVITY_PATH.'sub/wechat/include/accessToken.class.php';
//报名页面需要验证是否已经关注微信号，如果没有关注，需要跳转到邀请函，进行二维码扫描。
$o_token = new accessToken ();
$s_token = $o_token->access_token;
$jsapiTicket =getJsApiTicket($s_token);
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$timestamp = time();
$nonceStr =createNonceStr();

$string = 'jsapi_ticket='.$jsapiTicket.'&noncestr='.$nonceStr.'&timestamp='.$timestamp.'&url='.$url;
$signature = sha1($string);
function createNonceStr($length = 16) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$str = "";
	for($i = 0; $i < $length; $i ++) {
		$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
	}
	return $str;
}
function getJsApiTicket($s_token) {
	$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$s_token;
	$o_util=new curlUtil();
	$s_return=$o_util->https_request($url);
	$res=json_decode($s_return, true);
	//var_dump($res);
	return $res['ticket'];
}
$s_title=" ";
$s_link= "";
$s_imgUrl= "";
$s_desc='';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>测试位置</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
	<meta name="description" id="metaDescription" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <style type="text/css">
			body{
				font-family: 微软雅黑, Microsoft Yahei, Hiragino Sans GB, tahoma, arial, 宋体;
				line-height:30px;
				font-size:18px;
			}
	</style>
</head>
<body>
<b>经度：</b><span id="latitude">0</span><br/>
<b>纬度：</b><span id="longitude">0</span><br/>
<b>位置精度：</b><span id="accuracy">0</span><br/>
<br/>
<button style="width:100%;font-size:20px;" onclick="get_location()">获取当前坐标</button><br/><br/>
<img style="width:100%" src="images/check_location_example.jpg"/>
<button style="width:100%;font-size:20px;" onclick="check_location()">验证坐标是否在绿色区域内</button><br/><br/>
<button style="width:100%;font-size:20px;" onclick="open_location()">查看坐标在地图中的位置</button>
	<script>
	var latitude = 0; // 纬度，浮点数，范围为90 ~ -90
    var longitude = 0; // 经度，浮点数，范围为180 ~ -180。
    var speed = 0; // 速度，以米/每秒计
    var accuracy = 0; // 位置精度
	//本园  39.884170 116.332383   39.881585  116.335614
	function check_location()
	{
		if (latitude>39.881585 && latitude<39.884170 && longitude>116.332383 && longitude<116.335614)
		{
			alert("恭喜你，你的位置再绿色区域内。");
		}else{
			alert("对不起，你出圈了。");
		}
	}
	function open_location(){
		wx.openLocation({
		      latitude: latitude,
		      longitude: longitude,
		      name: '',
		      address: '',
		      scale: 16,
		      infoUrl: ''
		    });
	}
	function get_location()
	{
		wx.getLocation({
		    type: 'gcj02', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
		    success: function (res) {
		        latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
		        longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
		        speed = res.speed; // 速度，以米/每秒计
		        accuracy = res.accuracy; // 位置精度
		        document.getElementById('latitude').innerHTML=latitude
		        document.getElementById('longitude').innerHTML=longitude
			    document.getElementById('accuracy').innerHTML=accuracy
		    },
		    cancel: function (res) {
		        alert('用户拒绝授权获取地理位置');
		    }
		});
	}
	</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
<script>
	wx.config({
	    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	    appId: 'wxf38509d7749bb56d', // 必填，公众号的唯一标识
	    timestamp: <?php echo($timestamp)?>, // 必填，生成签名的时间戳
	    nonceStr: '<?php echo($nonceStr)?>', // 必填，生成签名的随机串
	    signature: '<?php echo($signature);?>',// 必填，签名，见附录1
	    jsApiList: ['wx.checkJsApi','getLocation','openLocation'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});
</script>
</body>

</html>