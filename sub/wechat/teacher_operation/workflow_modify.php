<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_title='工作流程修改';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
require_once '../header.php';
$o_case=new Dailywork_Workflow_Case_View($_GET['id']);
$o_main=new Dailywork_Workflow_Main($o_case->getMainId());
//判断是否有修改的权限
if (!($o_case->getOpener()==$o_temp->getUid(0) && $o_case->getReason()!='' && $o_case->getState()>0))
{
	//非法ID，那么退出
	echo "<script>location.href='workflow_list.php'</script>"; 
	exit(0);
}
?>
<div class="page">
    <div class="page__hd" style="padding:20px;padding-bottom:10px;">
        <h1 class="page__title" style="font-size: 1.6em;"><?php echo($o_main->getTitle())?></h1>
    </div>
    <div class="page__bd">
    	<form action="<?php echo($RELATIVITY_PATH)?>sub/dailywork/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="WechatWorkflowModify"/>
			<input type="hidden" name="Vcl_Id" value="<?php echo($o_case->getId())?>"/>
			<script type="text/javascript">
				var a_id=[];
				var a_must=[];
				var a_name=[];
			</script>
			<?php 
			$o_main_vcl=new Dailywork_Workflow_Main_Vcl();
			$o_main_vcl->PushWhere ( array ('&&', 'MainId', '=',$o_main->getId()) ); 
			$o_main_vcl->PushOrder ( array ('Number', 'A') );
			for($i=0;$i<$o_main_vcl->getAllCount();$i++)
			{
				echo(str_replace('%id%', $o_main_vcl->getId($i), $o_main_vcl->getHtml($i)));
				//是否必填项输出数组，去掉单选控件
				if($o_main_vcl->getType($i)=='single')
				{
					continue;
				}
				echo('
				<script type="text/javascript">
					a_id.push('.$o_main_vcl->getId($i).');
					a_must.push('.$o_main_vcl->getIsMust($i).');
					a_name.push(\''.$o_main_vcl->getName($i).'\');
				</script>
				');
			}
			?>
			<script type="text/javascript">
			<?php 
			//设置控件值
			//读取提交的数据。
			$o_case_data=new Dailywork_Workflow_Case_Data();
			$o_case_data->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) );
			for($i=0;$i<$o_case_data->getAllCount();$i++)
			{
				if ($o_case_data->getType($i)=='multiple')
				{
					//多选控件
					echo('
						$("#Vcl_'.$o_case_data->getMainVclId($i).'").val("'.$o_case_data->getValue($i).'");
					');
					//设置控件
					?>
					var checkbox=$(".weui-switch")
					for(var i=0;i<checkbox.length;i++)
					{
						var commend=$(checkbox[i]).attr("onchange");//获取控件的js命令
						var a_str= new Array(); //定义一数组 
						a_str=commend.split("'"); //字符分割 
						if (a_str[1]==<?php echo($o_case_data->getMainVclId($i))?>)
						{
							//等于当前控件ID
							//判断值是否在Value中
							var s_temp=" %<?php echo($o_case_data->getValue($i))?>";
							if(s_temp.indexOf("%"+a_str[3]+"%")>0)
							{
								$(checkbox[i]).attr("checked","true");
							}
						}
					}					
					<?php
					
				}else if($o_case_data->getType($i)=='single'){
					//单选控件
					for($j=1;$j<20;$j++)
					{
						//循环单独选项
						echo('
						if ($("#Vcl_'.$o_case_data->getMainVclId($i).'_'.$j.'").val()=="'.$o_case_data->getValue($i).'")
						{
							$("#Vcl_'.$o_case_data->getMainVclId($i).'_'.$j.'").attr("checked","true"); 
						}
						');
					}
					
				}else if($o_case_data->getType($i)=='img')
				{
					//图片控件
				}else{
					//其他可赋值控件
					echo('
						$("#Vcl_'.$o_case_data->getMainVclId($i).'").val("'.$o_case_data->getValue($i).'");
					');
				}
			} 
			?>	
			</script>
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
		</form>
    </div>
    <div style="padding:15px;">
	    <a href="javascript:;" class="weui-btn weui-btn_primary" onclick="dailywork_workflow_submit(a_id,a_must,a_name)">提交申请</a>
	    <a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
    </div>   					
</div>
<script type="text/javascript" src="js/function.js"></script>
<?php
require_once '../footer.php';
?>