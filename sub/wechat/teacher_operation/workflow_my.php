<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_title='工作流程';
//想判断教师权限，是否为绑定用户
$o_my=new Base_User_Wechat_View();
$o_my->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_my->getAllCount()==0)
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
                    我的记录
                </div>
            </div>
        </div>
        <div class="weui-tab__panel" style="padding-top:75px;">
        	<?php 
        		$o_table=new Dailywork_Workflow_Case_View();
        		$o_table->PushWhere ( array ('&&', 'Opener', '=',$o_my->getUid(0)) ); 
        		$o_table->PushOrder ( array ('Date', 'D') );
        		for($i=0;$i<$o_table->getAllCount();$i++)
        		{
        			$s_button='<a class="weui-form-preview__btn weui-form-preview__btn_primary" href="workflow_show.php?id='.$o_table->getId($i).'">查看详情</a>';	
        			//设置状态
        			if($o_table->getState($i)==100)
        			{
        				//已完成
        				$s_state='<span class="weui-form-preview__value" style="color:#1AAD19">已完成</span>';
        				
        			}else if ($o_table->getState($i)==0)
        			{
        				//已被XX驳回，不予批准	
        				//获取驳回的角色
        				$o_step=new Dailywork_Workflow_Case_Step_View();
        				$o_step->PushWhere ( array ('&&', 'CaseId', '=',$o_table->getId($i)) ); 
        				$o_step->PushWhere ( array ('&&', 'OwnerId', '<>',0) );
        				$o_step->PushOrder ( array ('Number', 'D') );
        				$o_step->getAllCount();
        				$s_state='<span class="weui-form-preview__value" style="color:#d9534f">已被“'.$o_step->getRoleName(0).'”驳回，不予批准	</span>';
        			}else{
        				//查看具体角色
        				//共两种状态，1. 等待XX审核    2. XX审核退回，等待修改后提交 
        				$o_step=new Dailywork_Workflow_Case_Step_View();
        				$o_step->PushWhere ( array ('&&', 'CaseId', '=',$o_table->getId($i)) ); 
        				$o_step->PushWhere ( array ('&&', 'Number', '=',$o_table->getState($i)) );
        				$o_step->getAllCount();
        				if($o_table->getReason($i)=='')
        				{
        					//说明当前状态是等待审批的
        					$s_state='<span class="weui-form-preview__value" style="color:#FFA200">等待“'.$o_step->getRoleName(0).'”审核</span>';
        				}else{
        					//说明被当前状态的人退回了
        					$o_step=new Dailywork_Workflow_Case_Step_View();
	        				$o_step->PushWhere ( array ('&&', 'CaseId', '=',$o_table->getId($i)) ); 
	        				$o_step->PushWhere ( array ('&&', 'OwnerId', '<>',0) );
	        				$o_step->PushOrder ( array ('Number', 'D') );
	        				$o_step->getAllCount();
        					$s_state='<span class="weui-form-preview__value" style="color:#d9534f">已被“'.$o_step->getRoleName(0).'”退回，等待修改重提</span>';
        					$s_button.='
        						<a class="weui-form-preview__btn weui-form-preview__btn_primary" style="color:#FFA200" href="signup_form_modify.php?id='.$o_table->getId($i).'">修改</a>
        					';
        				}
        			}        					
        			echo('
        				<div class="weui-form-preview">
				            <div class="weui-form-preview__hd">
				                <label class="weui-form-preview__label">名称</label>
				                <em class="weui-form-preview__value">'.$o_table->getTitle($i).'</em>
				            </div>
				            <div class="weui-form-preview__bd">
				            	<div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">申请时间</label>
						            <span class="weui-form-preview__value">'.$o_table->getDate($i).'</span>
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
        		if ($o_table->getAllCount()==0)
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