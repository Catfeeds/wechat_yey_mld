<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_title='工作流程申请';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat_View();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
require_once '../header.php';
$o_main=new Dailywork_Workflow_Main($_GET['id']);
if (!($o_main->getNumber()>0))
{
	//非法ID，那么退出
	echo "<script>location.href='workflow_list.php'</script>"; 
	exit(0);
}
//设置分享图标和标题与说明
require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
$o_token = new accessToken ();
$s_token = $o_token->getRefreshToken();
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
	return $res['ticket'];
}
?>
<div class="page">
    <div class="page__hd" style="padding:20px;padding-bottom:10px;">
        <h1 class="page__title" style="font-size: 1.6em;"><?php echo($o_main->getTitle())?></h1>
    </div>
    <div class="page__bd">
    	<div class="weui-cells__title">申请人姓名</div>
		<div class="weui-cells">
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<?php 
						echo($o_temp->getName(0));
					?>
				</div>
			</div>
		</div>
    	<form action="<?php echo($RELATIVITY_PATH)?>sub/dailywork/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="WechatWorkflowNew"/>
			<input type="hidden" name="Vcl_Id" value="<?php echo($o_main->getId())?>"/>
			<script type="text/javascript">
				var a_must=[];
				var a_id=[];
				var a_name=[];
			</script>
			<?php 
			$o_main_vcl=new Dailywork_Workflow_Main_Vcl();
			$o_main_vcl->PushWhere ( array ('&&', 'MainId', '=',$o_main->getId()) ); 
			$o_main_vcl->PushOrder ( array ('Number', 'A') );
			for($i=0;$i<$o_main_vcl->getAllCount();$i++)
			{
				$s_html=str_replace('%id%', $o_main_vcl->getId($i), $o_main_vcl->getHtml($i));
				$s_html=str_replace('%token%', $s_token, $s_html);
				echo($s_html);
				//是否必填项输出数组，去掉单选控件
				if($o_main_vcl->getType($i)=='single')
				{
					continue;
				}
				echo('
				<script type="text/javascript">
					a_id.push('.$o_main_vcl->getId($i).');
					a_must.push('.$o_main_vcl->getIsMust($i).');
					a_name.push(\''.$o_main_vcl->getName($i).'\');
				</script>
				');
			}
			?>			
		</form>
    </div>
    <div style="padding:15px;">
	    <a href="javascript:;" class="weui-btn weui-btn_primary" onclick="dailywork_workflow_submit(a_id,a_must,a_name)">提交申请</a>
	    <a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
    </div>   					
</div>
<script type="text/javascript" src="js/function.js"></script>
<script src="<?php echo(RELATIVITY_PATH)?>sub/wechat/js/jweixin-1.0.0.js" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: 'wxf38509d7749bb56d', // 必填，公众号的唯一标识
        timestamp: <?php echo($timestamp)?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo($nonceStr)?>', // 必填，生成签名的随机串
        signature: '<?php echo($signature);?>',// 必填，签名，见附录1
        jsApiList: ['chooseImage','uploadImage','wx.checkJsApi'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
});
</script>
<?php
require_once '../footer.php';
?>