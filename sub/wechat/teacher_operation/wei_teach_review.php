<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
$s_title='微视频';
$s_creatives='尹陆明';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$o_table=new Teaching_Wei_Teach_View($_GET['id']);
require_once '../header.php';
?>
<style>
.weui-media-box_text p{
	margin-top:10px !important;
	padding-top:0px !important;
	padding-bottom:0px !important;
	font-size:18px !important;
	line-height:150% !important;;
}
.weui-media-box_text b{
	font-size:20px !important;
}
.weui-media-box_text strong{
	font-size:20px !important;
}
</style>
 	<div class="page__hd" style="padding:15px;padding-top:0px;">
        <h1 class="page__title" style="font-size:25px;text-align:center;padding-top:20px;padding-bottom:10px;"><?php echo($o_table->getTitle())?></h1>
        <div style="color:#999999">
			日期：<?php 
			$s_release=explode(' ', $o_table->getReleaseDate());
			echo($s_release[0])?><br/>
			发布人：<?php echo($o_table->getOwnerName())?>老师
			</div>
        <div class="weui-media-box_text">
			<?php echo(rawurldecode($o_table->getComment()))?>
      	</div>
      	<iframe style="margin-top:15px;" frameborder="0" width="100%" src="<?php echo($o_table->getVideo())?>" allowfullscreen></iframe>
    </div>

	<div style="padding:15px;">
		<a id="next" class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">关闭</a>
	</div>
<script type="text/javascript">
$('iframe').height(Math.floor($('iframe').width()*9/16));
</script>
<?php
require_once '../footer.php';
?>