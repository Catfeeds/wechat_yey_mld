<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='添加论文著作';
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
			<input type="hidden" name="Vcl_FunName" value="TeacherInfoThesisAdd"/>
		<div class="weui-cells__title">时间</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Date" name="Vcl_Date" class="weui-input" type="date" placeholder="必填" value="">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">标题</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Title" name="Vcl_Title" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">刊物名称（出版单位）</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_BookName" name="Vcl_BookName" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">本人角色或排名</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_RoleLevel" name="Vcl_RoleLevel" class="weui-input" type="text" placeholder="必填">
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
		if ($('#Vcl_Date').val()=='')
		{
			Dialog_Message("[时间] 不能为空！",function(){
				document.getElementById("Vcl_Date").focus()
			})		
			return
		}
		if ($('#Vcl_Title').val()=='')
		{
			Dialog_Message("[标题] 不能为空！",function(){
				document.getElementById("Vcl_Title").focus()
			})		
			return
		}
		if ($('#Vcl_BookName').val()=='')
		{
			Dialog_Message("[刊物名称（出版单位）] 不能为空！",function(){
				document.getElementById("Vcl_BookName").focus()
			})		
			return
		}
		if ($('#Vcl_RoleLevel').val()=='')
		{
			Dialog_Message("[本人角色或排名] 不能为空！",function(){
				document.getElementById("Vcl_RoleLevel").focus()
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