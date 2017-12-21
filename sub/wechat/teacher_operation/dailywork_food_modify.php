<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='菜肴管理';
require_once '../header.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$o_bn_basic=new Bn_Basic();
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有留言</p></div>';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$o_base_user_role=new Base_User_Role($o_temp->getUid(0));
//判断权限是否为厨房岗和保健岗位
$b_admin=false;
if($o_base_user_role->getRoleId()==68 || $o_base_user_role->getRoleId()==67)
{
	$b_admin=true;
}
if($o_base_user_role->getSecRoleId1()==68 || $o_base_user_role->getSecRoleId1()==67)
{
	$b_admin=true;
}
if($o_base_user_role->getSecRoleId2()==68 || $o_base_user_role->getSecRoleId2()==67)
{
	$b_admin=true;
}
if($o_base_user_role->getSecRoleId3()==68 || $o_base_user_role->getSecRoleId3()==67)
{
	$b_admin=true;
}
if($o_base_user_role->getSecRoleId4()==68 || $o_base_user_role->getSecRoleId4()==67)
{
	$b_admin=true;
}
if($o_base_user_role->getSecRoleId5()==68 || $o_base_user_role->getSecRoleId5()==67)
{
	$b_admin=true;
}


$o_book=new Ek_Cuisine($_GET['id']);
if ($o_book->getDishname()=='')
{
	exit(0);
}
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
<style>
.weui-media-box__desc
{
	margin-top:5px;
}
.page__hd {
    padding: 40px;
	padding-top:30px;
	padding-bottom:10px;
}
.weui-label {
    width: 230px;
}
</style>
<div class="page">
	<div class="page__hd">
        <h1 class="page__title"><?php echo($o_book->getDishname())?></h1>
    </div>
    <div class="page__bd">
    	<div class="weui-cells__title">系统编号</div>
    	<div class="weui-cells">
	    	<div class="weui-cell">
	            <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_book->getDishnum())?></label></div>
	        </div>
        </div>
    	<div class="weui-cells__title">菜肴图片</div>
    	<h1 class="page__title" style="text-align:center"><img id="picture" src="<?php
		$s_picture='images/food_default.jpg';
		if ($o_book->getPicture()!='')
		{
			$s_picture=$RELATIVITY_PATH.$o_book->getPicture();
		}        
        echo($s_picture);?>" style="width:100%;" alt=""></h1>
        <?php 
        if ($b_admin)
        {
        	?>
        	<div class="upload_btn" onclick="choose_image('<?php echo($s_token)?>')" style="width:100%">
		    	<img src="images/photo_btn.png" style="width:50%;padding-bottom:20px;margin-left:25%;margin-right:25%"/>
		    </div>	
	        <div style="padding:15px;padding-top:0px">  
		    	<a class="weui-btn weui-btn_primary" onclick="cuisine_picture_update('<?php echo($_GET['id'])?>')">更新图片</a>
		    </div>
		    <input type="hidden" id="Vcl_Picture" name="Vcl_Picture" value=""/>
        	<?php
        }
        ?>        
    </div>   
	<div class="page__bd">		
        <form action="<?php echo($RELATIVITY_PATH)?>sub/dailywork/include/bn_submit.switch.php" id="submit_form_dailiang" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="CuisineDetailUpdate"/>
			<input type="hidden" name="Vcl_CuisineId" value="<?php echo($_GET['id'])?>"/>
		<div class="weui-cells__title">带量明细</div>
		<div class="weui-cells weui-cells_form">
		<?php 
		//获取带量
		$a_dailing=json_decode($o_book->getFoodinfo());
		$i=0;
		foreach ( $a_dailing as $key => $s_member ) {
			//获取代理名称
			$o_temp=new Ek_Usefood($key);
			?>
			<div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_temp->getFoodname())?></label></div>
                <div class="weui-cell__bd">
                    <input <?php 
                    if ($b_admin==false)
                    {
                    	echo('disabled="disabled"');
                    }
                    ?> name="Vcl_Dailiang_<?php echo($i)?>" value="<?php echo($s_member)?>" class="weui-input" type="number" pattern="[0-9.]*" placeholder="必填">
                </div>
                <div class="weui-cell__hd"><label class="weui-label" style="width:40px;text-align:right">克</label></div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd" style="width:125px"><label class="weui-label">&nbsp;&nbsp;&nbsp;&nbsp;别名</label></div>
                <div class="weui-cell__bd">
                    <input <?php 
                    if ($b_admin==false)
                    {
                    	echo('disabled="disabled"');
                    }
                    ?> name="Vcl_Nickname_<?php echo($i)?>" value="<?php 
                    if ($o_temp->getNickname()=='')
                    {
                    	echo($o_temp->getFoodname());
                    }else{
                    	echo($o_temp->getNickname());
                    }
                    ?>" class="weui-input" placeholder="必填">
                </div>
            </div>
			<?php
			$i++;
		}
		?>
        </div>		
		</form>
        <div style="padding:15px;">
        <?php 
        if ($b_admin)
        {
        	?>
        	<a class="weui-btn weui-btn_primary" onclick="cuisine_detail_update()">更新带量</a>
        	<?php
        }
        ?>	    	
	    	<a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
	    </div>
    </div>
</div>
<script src="<?php echo(RELATIVITY_PATH)?>sub/wechat/js/jweixin-1.0.0.js" charset="utf-8"></script>
<script type="text/javascript">
function cuisine_detail_update()
{
	Dialog_Confirm('真的要更新带量吗？',function(){
		Common_OpenLoading();
		document.getElementById("submit_form_dailiang").submit();	
	});
}
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
function cuisine_picture_update(id) {
    Dialog_Confirm('真的要更新菜肴照片吗？',function(){
    	Common_OpenLoading();
    	var data = 'Ajax_FunName=CuisinePictureUpdate'; //后台方法
        data = data + '&id=' + id;
        data =data + '&picture=' + encodeURIComponent($('#Vcl_Picture').val());
        $.getJSON("<?php echo($RELATIVITY_PATH)?>sub/dailywork/include/bn_submit.switch.php", data, function (json) {
        	Common_CloseDialog();
        	Dialog_Success('菜肴照片更新成功！');
        })
    })
}
function choose_image(token)
{
	wx.chooseImage({
	    count: 1, // 默认9
	    sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
	    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
	    success: function (res) {
	    	var localids=res.localIds;
	    	wx.uploadImage({
	    	    localId:localids.toString(), // 需要上传的图片的本地ID，由chooseImage接口获得
	    	    isShowProgressTips: 1, // 默认为1，显示进度提示
	    	    success: function (res) {
	    	        var serverId = res.serverId; // 返回图片的服务器端ID
	    	        $('#picture').attr('src','http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId)	    	        
	    	        $('#Vcl_Picture').val('http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId)
	    	    },
	    	    fail:function(res){
	    	    	Dialog_Message('上传失败，请重试！');
			   }
	    	});
	    }
	});
}
</script>
<?php
require_once '../footer.php';
?>