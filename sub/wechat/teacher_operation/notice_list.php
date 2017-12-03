<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='家长通知';
require_once '../header.php';
require_once RELATIVITY_PATH . 'sub/notice_center/include/db_table.class.php';
require_once RELATIVITY_PATH.'include/bn_basic.class.php';
$o_bn_base=new Bn_Basic();
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">30内没有家长通知</p></div>';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}

$o_role=new Notice_Center_Record_View();
$o_role->PushWhere ( array ('&&', 'CreateDate', '>=',date('Y-m-d',strtotime($o_bn_base->GetDate()." -30 day"))) ); //30天内的
$o_role->PushOrder ( array ('CreateDate',D) );
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
            <div class="weui-panel__hd">所有家长通知列表（30天内）</div>
            <div class="weui-panel__bd">
            <?php 
            for($i=0;$i<$o_role->getAllCount();$i++)
            {
            	echo('
            	<a href="notice_list_view.php?id='.$o_role->getId($i).'" class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">'.$o_role->getFirst($i).'</h4>
                        <p class="weui-media-box__desc" style="display:inherit;">通知时间：'.$o_role->getCreateDate($i).'
                        <br/>通知类型：'.$o_role->getType($i).'
                        <br/>发送教师：'.$o_role->getUserName($i).'老师
                        <br/>接收对象：'.$o_role->getTargetName($i).'</p>                        
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