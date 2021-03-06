<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='添加工作经历';
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
			<input type="hidden" name="Vcl_FunName" value="TeacherInfoWorkAdd"/>
		<div class="weui-cells__title">开始时间</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_StartDate" name="Vcl_StartDate" class="weui-input" type="date" placeholder="必填" value="">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">结束时间</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_EndDate" name="Vcl_EndDate" class="weui-input" type="date" placeholder="必填" value="">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">工作岗位</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Job" name="Vcl_Job" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">工作内容</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Content" name="Vcl_Content" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
		<div class="weui-cells__title">工作类别</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                	<select class="weui-select" id="Vcl_Type" name="Vcl_Type">
                    	<option value="">请选择</option>
                    	<option value="管理">管理</option>
                    	<option value="专技">专技</option>
                    	<option value="工勤">工勤</option>
                    	<option value="其他">其他</option>
	                </select>
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
	
	Dialog_Confirm('真的要提交信息吗？<br/>提交后不能修改，请谨慎操作。',function(){
		if ($('#Vcl_StartDate').val()=='')
		{
			Dialog_Message("[开始时间] 不能为空！",function(){
				document.getElementById("Vcl_StartDate").focus()
			})		
			return
		}
		if ($('#Vcl_EndDate').val()=='')
		{
			Dialog_Message("[结束时间] 不能为空！",function(){
				document.getElementById("Vcl_EndDate").focus()
			})		
			return
		}
		if ($('#Vcl_Job').val()=='')
		{
			Dialog_Message("[工作岗位] 不能为空！",function(){
				document.getElementById("Vcl_Contant").focus()
			})		
			return
		}
		if ($('#Vcl_Contant').val()=='')
		{
			Dialog_Message("[工作内容] 不能为空！",function(){
				document.getElementById("Vcl_Contant").focus()
			})		
			return
		}
		if ($('#Vcl_Type').val()=='')
		{
			Dialog_Message("请选择 [业绩类型] ！",function(){
				document.getElementById("Vcl_Type").focus()
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