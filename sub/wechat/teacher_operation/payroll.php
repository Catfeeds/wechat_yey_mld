<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_title='我的工资条';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
require_once '../header.php';
?>
    <div class="page__bd">
        <div class="weui-cells__title">我的工资条</div>
        <div class="weui-cells">
        <?php 
        $o_list=new Dailywork_Payroll_Object_Detail_View();
        $o_list->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
        $o_list->PushOrder ( array ('Date', 'D') );
        for($i=0;$i<$o_list->getAllCount();$i++)
        {
        	?>        	
	            <div class="weui-cell weui-cell_access" onclick="location='payroll_detail.php?id=<?php echo($o_list->getId($i))?>'">
	                <div class="weui-cell__bd">
	                    <span style="vertical-align: middle"><?php 
	                    //只显示年月
	                    $a_temp=explode('-', $o_list->getDate($i));
	                    echo($a_temp[0].'年'.(int)$a_temp[1].'月')?></span>
	                </div>
	                <div class="weui-cell__ft"></div>
	            </div>              
        	<?php
        }
        ?> 
        </div>       
    </div>
	<div style="padding:15px;">
		<a id="next" class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">关闭</a>
	</div>
<?php
require_once '../footer.php';
?>