<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_title='工作流程详情';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat_View();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
require_once '../header.php';
$o_case=new Dailywork_Workflow_Case_View($_GET['id']);
if (!($o_case->getStateSum()>0))
{
	//非法ID，那么退出
	echo "<script>location.href='workflow_my.php'</script>"; 
	exit(0);
}
?>
<div class="page">
    <div class="page__hd" style="padding:20px;padding-bottom:10px;">
        <h1 class="page__title" style="font-size: 1.6em;"><?php echo($o_case->getTitle())?></h1>
    </div>
    <div class="page__bd">
    	<div class="weui-cells__title">申请人姓名</div>
		<div class="weui-cells">
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<?php 
						echo($o_temp->getName(0));
					?>
				</div>
			</div>
		</div>
		<div class="weui-cells__title">申请时间</div>
		<div class="weui-cells">
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<?php 
						echo($o_case->getDate());
					?>
				</div>
			</div>
		</div>
    	<form action="<?php echo($RELATIVITY_PATH)?>sub/dailywork/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="WechatWorkflowAudit"/>
			<input type="hidden" name="Vcl_Id" value="<?php echo($o_case->getId())?>"/>
			<input type="hidden" name="Vcl_Type" id="Vcl_Type" value=""/>
    	<?php 
			$o_case_data=new Dailywork_Workflow_Case_Data();
			$o_case_data->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) ); 
			$o_case_data->PushOrder ( array ('Id', 'A') );
			for($i=0;$i<$o_case_data->getAllCount();$i++)
			{
				echo('<div class="weui-cells__title">'.$o_case_data->getName($i).'</div>');
				//要区分控件类型
				switch ($o_case_data->getType($i))
				{
					case 'multiple':
						//多选
						$s_value=$o_case_data->getValue($i);
						$s_value=str_replace('%%', '<br/>', $s_value);
						$s_value=str_replace('%', '', $s_value);
						echo('
						<div class="weui-cells">
							<div class="weui-cell">
								<div class="weui-cell__bd">
									'.$s_value.'
								</div>
							</div>
						</div>
						');
						break;
					case 'time':
						//时间
						echo('
						<div class="weui-cells">
							<div class="weui-cell">
								<div class="weui-cell__bd">
									'.str_replace('T', ' ', $o_case_data->getValue($i)).'
								</div>
							</div>
						</div>
						');
						break;
					case 'img':
						//图片
						$a_img=json_decode($o_case_data->getValue($i));
						//构建图片列表
						$s_img='';
						for($j=0;$j<count($a_img);$j++)
						{
							$s_img.='<li onclick="location=\''.RELATIVITY_PATH.$a_img[$j].'\'" class="weui-uploader__file" style="background-image:url('.RELATIVITY_PATH.$a_img[$j].')"></li>';
						}
						echo('
						<div class="weui-cells">
							<div class="weui-cell">
								<div class="weui-cell__bd">
									<div class="weui-uploader">
										<div class="weui-uploader__bd">
											<ul class="weui-uploader__files" id="uploaderFiles_'.$o_case_data->getId($i).'">
											'.$s_img.'
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="weui-gallery" id="gallery_'.$o_case_data->getId($i).'">
							<span class="weui-gallery__img" id="galleryImg_'.$o_case_data->getId($i).'" title=""></span>
						</div>
						');
						break;
					default:
						echo('
						<div class="weui-cells">
							<div class="weui-cell">
								<div class="weui-cell__bd">
									'.$o_case_data->getValue($i).'
								</div>
							</div>
						</div>
						');
				}				
			}
			?>
		<div class="weui-cells__title">工作流程记录</div>
		<div class="weui-cells">
		<?php 
			$o_log=new Dailywork_Workflow_Case_Log();
			$o_log->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) ); 
			$o_log->PushOrder ( array ('Date', 'A') );
			for($i=0;$i<$o_log->getAllCount();$i++)
			{
				echo('
				<div class="weui-cell">
	                <div class="weui-cell__bd">
	                	<div style="font-size:14px;">'.$o_log->getOperatorName($i).'</div>
	                    <div style="font-size:14px;">'.$o_log->getComment($i).'</div>
	                    <div style="font-size:14px;color:#999999">'.$o_log->getDate($i).'</div>
	                </div>
	            </div>
				');
			}
		?>
		</div>
		<div class="weui-cells__title">当前状态</div>
		<div class="weui-cells">
			<div class="weui-cell">
				<div class="weui-cell__bd">
		<?php 
					if($o_case->getState()==100)
        			{
        				//已完成
        				$s_state='<span style="color:#1AAD19">已完成</span>';
        				
        			}else if ($o_case->getState()==0)
        			{
        				//已被XX驳回，不予批准	
        				//获取驳回的角色
        				$o_step=new Dailywork_Workflow_Case_Step_View();
        				$o_step->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) ); 
        				$o_step->PushWhere ( array ('&&', 'OwnerId', '<>',0) );
        				$o_step->PushOrder ( array ('Number', 'D') );
        				$o_step->getAllCount();
        				$s_state='<span style="color:#d9534f">已被“'.$o_step->getRoleName(0).'”驳回，不予批准	</span>';
        			}else{
        				//查看具体角色
        				//共两种状态，1. 等待XX审核    2. XX审核退回，等待修改后提交 
        				$o_step=new Dailywork_Workflow_Case_Step_View();
        				$o_step->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) ); 
        				$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()) );
        				$o_step->getAllCount();
        				if($o_case->getReason()=='')
        				{
        					//说明当前状态是等待审批的
        					$s_state='<span style="color:#FFA200">等待“'.$o_step->getRoleName(0).'”审核</span>';
        				}else{
        					//说明被当前状态的人退回了
        					$o_step=new Dailywork_Workflow_Case_Step_View();
	        				$o_step->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) ); 
	        				$o_step->PushWhere ( array ('&&', 'OwnerId', '<>',0) );
	        				$o_step->PushOrder ( array ('Number', 'D') );
	        				$o_step->getAllCount();
        					$s_state='<span style="color:#d9534f">已被“'.$o_step->getRoleName(0).'”退回，等待修改重提</span>';
        				}
        			}
        			echo($s_state);
		?>
				</div>
			</div>
		</div>
		<?php 
		//如果看Case的人是相应的角色，并且reason等于空，那么显示控件，并显示审批意见。
		if($o_case->getReason()=='')
		{
			//获取当前用户角色编号
			$o_base_user_role=new Base_User_Role($o_temp->getUid(0));
			$o_step=new Dailywork_Workflow_Case_Step_View();
			$o_step->PushWhere ( array ('||', 'CaseId', '=',$o_case->getId()));
			$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
			$o_step->PushWhere ( array ('&&', 'OwnerId', '=',0));
			$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getRoleId()));
			$o_step->PushWhere ( array ('||', 'CaseId', '=',$o_case->getId()));
			$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
			$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId1()));
			$o_step->PushWhere ( array ('&&', 'OwnerId', '=',0));
			$o_step->PushWhere ( array ('||', 'CaseId', '=',$o_case->getId()));
			$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
			$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId2()));
			$o_step->PushWhere ( array ('&&', 'OwnerId', '=',0));
			$o_step->PushWhere ( array ('||', 'CaseId', '=',$o_case->getId()));
			$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
			$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId3()));
			$o_step->PushWhere ( array ('&&', 'OwnerId', '=',0));
			$o_step->PushWhere ( array ('||', 'CaseId', '=',$o_case->getId()));
			$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
			$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId4()));
			$o_step->PushWhere ( array ('&&', 'OwnerId', '=',0));
			$o_step->PushWhere ( array ('||', 'CaseId', '=',$o_case->getId()));
			$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
			$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId5()));
			$o_step->PushWhere ( array ('&&', 'OwnerId', '=',0));
			if ($o_step->getAllCount()>0)
			{
				?>
				<script type="text/javascript">
					var a_id=[];
					var a_must=[];
					var a_name=[];
				</script>
				<?php
				//有审批权限，显示审批控件
				$o_step_vcl=new Dailywork_Workflow_Main_Step_Vcl();
				$o_step_vcl->PushWhere ( array ('&&', 'StepId', '=',$o_step->getMainStepId(0)));
				$o_step_vcl->PushOrder ( array ('Number', 'D') );
				for($i=0;$i<$o_step_vcl->getAllCount();$i++)
				{
					echo(str_replace('%id%', $o_step_vcl->getId($i), $o_step_vcl->getHtml($i)));
					//是否必填项输出数组，去掉单选控件
					if($o_step_vcl->getType($i)=='single')
					{
						continue;
					}
					echo('
					<script type="text/javascript">
						a_id.push('.$o_step_vcl->getId($i).');
						a_must.push('.$o_step_vcl->getIsMust($i).');
						a_name.push(\''.$o_step_vcl->getName($i).'\');
					</script>
					');
				}
				?>
				
				<div id="reason">
					<div class="weui-cells__title">退回修改/不通过 原因</div>
					<div class="weui-cells">
						<div class="weui-cell">
							<div class="weui-cell__bd">
								<input class="weui-input" id="Vcl_Reason" name="Vcl_Reason" placeholder="点击“退回修改”或“不通过”时，此项必填">
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
		</form>
    </div>
    <div style="padding:15px;">
    	<?php 
    	if ($o_step->getAllCount()>0 && $o_case->getReason()=='')
    	{
    		?>
    		<a href="javascript:;" class="weui-btn weui-btn_primary" onclick="dailywork_workflow_pass_submit(a_id,a_must,a_name)">通过</a>
    		<a href="javascript:;" class="weui-btn weui-btn_warn" onclick="dailywork_workflow_return_submit()">退回修改</a>
    		<a href="javascript:;" class="weui-btn weui-btn_warn" onclick="dailywork_workflow_reject_submit()">不通过</a>
    		<?php
    	}
    	?>
	    <a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
    </div>   					
</div>
<script type="text/javascript" src="js/function.js"></script>
<?php
require_once '../footer.php';
?>