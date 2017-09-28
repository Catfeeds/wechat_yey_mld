<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='微教学';
require_once '../header.php';
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有微教学</p></div>';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$o_role=new Teaching_Wei_Teach_View();
$o_role->PushWhere ( array ('||', 'State', '=',1) );
$o_role->PushOrder ( array ('ReleaseDate',D) );
?>
<?php 
if($o_role->getAllCount()>0)
{
	//如果用户存在，并且有微视频
	?>
<style>
.weui-media-box__desc
{
	line-height:20px;
}
.weui-media-box__thumb
{
	width:60px;
	height:60px;
}
</style>
<div class="page">
    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">微教学列表</div>
            <div class="weui-panel__bd">
            <?php 
            for($i=0;$i<$o_role->getAllCount();$i++)
            {
            	$s_release=explode(' ', $o_role->getReleaseDate($i));
            	echo('
            	<a href="wei_teach_view.php?id='.$o_role->getId($i).'" class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__hd">
                        <img class="weui-media-box__thumb" src="'.RELATIVITY_PATH.$o_role->getIcon($i).'" alt="">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">'.$o_role->getTitle($i).'</h4>
                        <p class="weui-media-box__desc" style="display:inherit;">日期：'.$s_release[0].'<br/>发布者：'.$o_role->getOwnerName($i).'老师
                        <br/>观看对象：'.$o_role->getTargetName($i).'</p>                        
                    </div>
                </a>
            	');
            }
            ?>
            </div>
        </div>        
    </div>
</div>	
	<?php
}else{
	echo($s_none);
}
?>

	<div style="padding:15px;">
		<a id="next" class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">关闭</a>
	</div>
<?php
require_once '../footer.php';
?>