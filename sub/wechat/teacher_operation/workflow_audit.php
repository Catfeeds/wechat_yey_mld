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
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有记录</p></div>';
require_once '../header.php';
?>
<div class="page">
    <div class="page__bd" style="height: 100%;">
        <div class="weui-tab">
            <div class="weui-navbar">
                <div class="weui-navbar__item" onclick="location='workflow_list.php'">
                    新申请
                </div>
                <div class="weui-navbar__item weui-bar__item_on">
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
        <div class="weui-tab__panel" style="padding-top:75px;">
        	<?php
        		$n_record=0;
        		$n_record=$n_record+$o_case_step->getAllCount();
        		//先显示所有待审核的
        		for($i=0;$i<$o_case_step->getAllCount();$i++)
        		{
        			if ($o_case_step->getState($i)!=$o_case_step->getNumber($i))
        			{
        				continue;
        			}
        			$o_case=new Dailywork_Workflow_Case_View($o_case_step->getCaseId($i));
        			$s_button='<a class="weui-form-preview__btn weui-form-preview__btn_primary" href="workflow_show.php?id='.$o_case_step->getCaseId($i).'">审核</a>';
        			$s_state='<span class="weui-form-preview__value" style="color:#FFA200">等待审核</span>';	        					
        			echo('
        				<div class="weui-form-preview">
				            <div class="weui-form-preview__hd">
				                <label class="weui-form-preview__label">名称</label>
				                <em class="weui-form-preview__value">'.$o_case->getTitle().'</em>
				            </div>
				            <div class="weui-form-preview__bd">
				            	<div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">申请人</label>
						            <span class="weui-form-preview__value">'.$o_case->getName().'</span>
						        </div>
				            	<div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">申请时间</label>
						            <span class="weui-form-preview__value">'.$o_case->getDate().'</span>
						        </div>
						        <div class="weui-form-preview__item">
						           <label class="weui-form-preview__label">当前状态</label>
						            <span class="weui-form-preview__value">'.$s_state.'</span>
						        </div>			       
				            </div>
				            <div class="weui-form-preview__ft">				            	
				            	'.$s_button.'				            	
				            </div>
				        </div>
				        <br/>
        			');
        		}
        		if ($n_record==0)
        		{
        			echo($s_none);
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