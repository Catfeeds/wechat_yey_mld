<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_title='工作流程申请';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
require_once '../header.php';
$o_main=new Dailywork_Workflow_Main($_GET['id']);
if (!($o_main->getNumber()>0))
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
			<input type="hidden" name="Vcl_FunName" value="WorkflowNew"/>
			<input type="hidden" name="Vcl_Id" value="<?php echo($o_main->getId())?>"/>
			<script type="text/javascript">
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
					a_must.push('.$o_main_vcl->getIsMust($i).');
					a_name.push(\''.$o_main_vcl->getName($i).'\');
				</script>
				');
			}
			?>			
		</form>
    </div>
    <div style="padding:15px;">
	    <a href="javascript:;" class="weui-btn weui-btn_primary" onclick="dailywork_workflow_submit(a_must,a_name)">提交申请</a>
	    <a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
    </div>   					
</div>
<script type="text/javascript" src="js/function.js"></script>
<?php
require_once '../footer.php';
?>