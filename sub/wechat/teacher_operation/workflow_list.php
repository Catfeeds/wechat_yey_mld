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
                <div class="weui-navbar__item" onclick="location='workflow_audit.php'">
                   审核
                <?php 
                //查看本人名下是否有待审批的工作流                
                $o_base_user_role=new Base_User_Role($o_temp->getUid(0));
				$o_case_step=new Dailywork_Workflow_Case_Step_View();
				$o_case_step->PushWhere ( array ('||', 'OwnerId', '=',0));
				$o_case_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getRoleId()));
				$o_case_step->PushWhere ( array ('||', 'OwnerId', '=',0));
				$o_case_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId1()));
				$o_case_step->PushWhere ( array ('||', 'OwnerId', '=',0));
				$o_case_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId2()));
				$o_case_step->PushWhere ( array ('||', 'OwnerId', '=',0));
				$o_case_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId3()));
				$o_case_step->PushWhere ( array ('||', 'OwnerId', '=',0));
				$o_case_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId4()));
				$o_case_step->PushWhere ( array ('||', 'OwnerId', '=',0));
				$o_case_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId5())); 
				$n_number=0;
				for($i=0;$i<$o_case_step->getAllCount();$i++)
				{
					if ($o_case_step->getState($i)==$o_case_step->getNumber($i))
					{
						$n_number++;//只有当前需要我审核的记录才会累加
					}					
				}
				if ($n_number>0)
				{
					echo('<span class="weui-badge">'.$n_number.'</span>');
				}
                ?>             
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