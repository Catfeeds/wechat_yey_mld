<?php
//设置分享图标和标题与说明
require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
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
?>
<script src="<?php echo(RELATIVITY_PATH)?>sub/wechat/js/jweixin-1.0.0.js" charset="utf-8"></script>
<script type="text/javascript">
//分享连接
wx.config({
    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: 'wxf38509d7749bb56d', // 必填，公众号的唯一标识
    timestamp: <?php echo($timestamp)?>, // 必填，生成签名的时间戳
    nonceStr: '<?php echo($nonceStr)?>', // 必填，生成签名的随机串
    signature: '<?php echo($signature);?>',// 必填，签名，见附录1
    jsApiList: ['chooseImage','uploadImage','wx.checkJsApi'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});
wx.ready(function(){
	wx.checkJsApi({
	    jsApiList: ['uploadImage'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
	    success: function(res) {
		    //window.alert(res.errMsg)
	        // 以键值对的形式返回，可用的api值true，不可用为false
	        // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
	    }
	});
});
</script>