<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='完善课题立项';
$s_creatives='吴丽娟';
require_once '../header.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$o_bn_basic=new Bn_Basic();
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$o_teacher_info_base=new Wechat_Base_User_Info_Base($o_temp->getUid(0));
$o_teacher_info_project=new Wechat_Base_User_Info_Project($_GET['id']);
?>
<style>
<!--

-->
</style>
<div class="page">
	<div class="page__bd">
		<form action="<?php echo($RELATIVITY_PATH)?>sub/dailywork/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="TeacherInfoProjectModify"/>
			<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
		<div class="weui-cells__title">课题名称</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                	<?php echo($o_teacher_info_project->getName())?>
                </div>
            </div>
        </div>
        <div class="weui-cells__title">课题级别</div>
        <div class="weui-cells">
            <div class="weui-cell">
            	<div class="weui-cell__bd">
                	<?php echo($o_teacher_info_project->getLevel())?>
                </div>
            </div>
        </div>
        <div class="weui-cells__title">参与角色</div>
        <div class="weui-cells">
            <div class="weui-cell">
            	<div class="weui-cell__bd">
                	<?php echo($o_teacher_info_project->getRole())?>
                </div>
            </div>
        </div>
        <div class="weui-cells__title">开题时间</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                	<?php echo($o_teacher_info_project->getStartDate())?>
                </div>
            </div>
        </div>
        <div class="weui-cells__title">结题时间</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_EndDate" name="Vcl_EndDate" class="weui-input" type="date" placeholder="必填" value="<?php 
                    if ($o_teacher_info_project->getEndDate()!='0000-00-00')
                    echo($o_teacher_info_project->getEndDate())?>">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">课题成果</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Result" name="Vcl_Result" class="weui-input" value="<?php echo($o_teacher_info_project->getResult())?>" type="text" placeholder="必填">
                </div>
            </div>
        </div>        
		</form>
        <div style="padding:15px;">
        	<a class="weui-btn weui-btn_primary" onclick="add_submit()">提交</a>
	    	<a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
	    </div>
    </div>
</div>
<script type="text/javascript">
function add_submit()
{
	
	Dialog_Confirm('真的要提交信息吗？<br/>提交完整信息后不能修改，<br/>请谨慎操作。',function(){
		if ($('#Vcl_EndDate').val()=='')
		{
			Dialog_Message("[结题时间] 不能为空！",function(){
				document.getElementById("Vcl_EndDate").focus()
			})		
			return
		}
		if ($('#Vcl_Result').val()=='')
		{
			Dialog_Message("[课题成果] 不能为空！",function(){
				document.getElementById("Vcl_Result").focus()
			})		
			return
		}
		Common_OpenLoading();
		document.getElementById("submit_form").submit();
	});
}
</script>
<?php
require_once '../footer.php';
?>