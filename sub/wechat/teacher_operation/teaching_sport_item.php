<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='体能测验';
//$s_creatives='尹陆明';
require_once '../header.php';
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有测试项目</p></div>';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$o_table=new Teaching_Sport_Item();
$o_table->PushOrder ( array ('Number','A') );
?>
<?php 
if($o_table->getAllCount()>0)
{
	?>
<div class="page">
    <div class="page__bd">
    	<div class="weui-cells__title">选择要测验的体能项目</div>
        <div class="weui-cells">
        <?php 
        for($i=0;$i<$o_table->getAllCount();$i++)
        {
        	$s_url='';
        	//区分类型，跳转到相应页面
        	switch ($o_table->getType($i))
        	{
        		case 'input':
        			$s_url='teaching_sport_input_select_class.php?item_id='.$o_table->getId($i);
        			break;
        		case 'time':
        			$s_url='teaching_sport_time_select_class.php?item_id='.$o_table->getId($i);
        			break;
        	}
        	echo('
				<div class="weui-cell weui-cell_access" onclick="location=\''.$s_url.'\'">
	                <div class="weui-cell__bd">'.$o_table->getName($i).'</div>
	                <div class="weui-cell__ft" style="font-size: 0">
	                </div>
	            </div>
			');
        }
        ?>            
        </div> 
        <div class="weui-cells__title">选择要查看成绩的体能项目</div>
        <div class="weui-cells">
        <?php 
        for($i=0;$i<$o_table->getAllCount();$i++)
        {
        	$s_url='teaching_sport_view_select_class.php?item_id='.$o_table->getId($i);
        	echo('
				<div class="weui-cell weui-cell_access" onclick="location=\''.$s_url.'\'">
	                <div class="weui-cell__bd">'.$o_table->getName($i).'</div>
	                <div class="weui-cell__ft" style="font-size: 0">
	                </div>
	            </div>
			');
        }
        ?>            
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
<script type="text/javascript">
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>
<?php
require_once '../footer.php';
?>