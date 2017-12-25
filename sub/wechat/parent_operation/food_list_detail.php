<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='食谱';
$s_creatives='王倩';
require_once '../header.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$o_bn_basic=new Bn_Basic();
$o_book=new Ek_Cuisine($_GET['id']);
if ($o_book->getDishname()=='')
{
	exit(0);
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
    	<div class="weui-cells__title">菜肴图片</div>
    	<h1 class="page__title" style="text-align:center"><img id="picture" src="<?php
		$s_picture='images/food_default.jpg';
		if ($o_book->getPicture()!='')
		{
			$s_picture=$RELATIVITY_PATH.$o_book->getPicture();
		}        
        echo($s_picture);?>" style="width:100%;" alt=""></h1>
    </div>   
	<div class="page__bd">		
		<div class="weui-cells__title">含量明细</div>
		<div class="weui-cells weui-cells_form">
		<?php 
		//获取带量
		$a_dailing=json_decode($o_book->getFoodinfo());
		$i=0;
		foreach ( $a_dailing as $key => $s_member ) {
			//获取代理名称
			$o_temp=new Ek_Usefood($key);
			if ($o_temp->getKindname()=='油脂类' || $o_temp->getKindname()=='调味品类' || $o_temp->getKindname()=='糖类' || $o_temp->getKindname()=='蜜饯类')
			{
				continue;
			}
			?>
			<div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php 
                if ($o_temp->getNickname()=='')
                {
                	echo($o_temp->getFoodname());
                }else{
                	echo($o_temp->getNickname());
                }
                ?></label></div>
            </div>
			<?php
			$i++;
		}
		?>
        </div>		
        <div style="padding:15px;">  
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