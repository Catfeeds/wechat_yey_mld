<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='添加课题立项';
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
			<input type="hidden" name="Vcl_FunName" value="TeacherInfoProjectAdd"/>
		<div class="weui-cells__title">课题名称</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Name" name="Vcl_Name" class="weui-input" type="text" placeholder="必填" value="">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">课题级别</div>
        <div class="weui-cells">
            <div class="weui-cell">
            	<div class="weui-cell__bd">
					<select class="weui-select" id="Vcl_Level" name="Vcl_Level">
						<option value="">请选择</option>
	                    <option value="国家级">国家级</option>
	                    <option value="省市级">省市级</option>
	                    <option value="区县级">区县级</option>
	                    <option value="校级">校级</option>
	                </select>
		        </div>
            </div>
        </div>
        <div class="weui-cells__title">参与角色</div>
        <div class="weui-cells">
            <div class="weui-cell">
            	<div class="weui-cell__bd">
					<select class="weui-select" id="Vcl_Role" name="Vcl_Role">
						<option value="">请选择</option>
	                    <option value="负责人">负责人</option>
	                    <option value="执行人">执行人</option>
	                    <option value="参与者">参与者</option>
	                </select>
		        </div>
            </div>
        </div>
        <div class="weui-cells__title">开题时间（可以完成后填写）</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_StartDate" name="Vcl_StartDate" class="weui-input" type="date" placeholder="必填" value="">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">结题时间（可以完成后填写）</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_EndDate" name="Vcl_EndDate" class="weui-input" type="date" placeholder="必填" value="">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">课题成果</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Result" name="Vcl_Result" class="weui-input" type="text" placeholder="可以完成后填写">
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
		if ($('#Vcl_Name').val()=='')
		{
			Dialog_Message("[课题名称] 不能为空！",function(){
				document.getElementById("Vcl_Name").focus()
			})		
			return
		}
		if ($('#Vcl_Level').val()=='')
		{
			Dialog_Message("请选择 [课题级别] ！",function(){
				document.getElementById("Vcl_Level").focus()
			})		
			return
		}
		if ($('#Vcl_Role').val()=='')
		{
			Dialog_Message("请选择 [参与角色] ！",function(){
				document.getElementById("Vcl_Role").focus()
			})		
			return
		}
		if ($('#Vcl_StartDate').val()=='')
		{
			Dialog_Message("[开题时间] 不能为空！",function(){
				document.getElementById("Vcl_StartDate").focus()
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