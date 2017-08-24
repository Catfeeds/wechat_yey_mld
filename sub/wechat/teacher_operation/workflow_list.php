<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_title='工作流程';
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
<div class="page">
    <div class="page__bd" style="height: 100%;">
        <div class="weui-tab">
            <div class="weui-navbar">
                <div class="weui-navbar__item weui-bar__item_on">
                    新申请
                </div>
                <div class="weui-navbar__item" onclick="location='workflow_my.php'">
                    我的记录
                </div>
            </div>
        </div>
        <div class="weui-tab__panel" style="padding-top:52px;">
        	<?php 
        		$o_table=new Dailywork_Workflow_Main();
        		$o_table->PushOrder ( array ('Number', 'A') );
        		for($i=0;$i<$o_table->getAllCount();$i++)
        		{        			
        			echo('
        			<div class="weui-cells">
			            <div class="weui-cell weui-cell_access" onclick="location=\'workflow_new.php?id='.$o_table->getId($i).'\'">
			                <div class="weui-cell__bd">'.$o_table->getTitle($i).'</div>
			                <div class="weui-cell__ft" style="font-size: 0">
			                </div>
			            </div>
			        </div>
        			');
        		}        		
        	?>
        </div>
    </div>    					
</div>
<script type="text/javascript">

</script>
<?php
require_once '../footer.php';
?>