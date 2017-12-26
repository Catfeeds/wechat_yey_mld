<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='添加学历学位';
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
			<input type="hidden" name="Vcl_FunName" value="TeacherInfoEducationAdd"/>
		<div class="weui-cells__title">毕业时间</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_GraduateDate" name="Vcl_GraduateDate" class="weui-input" type="date" placeholder="必填" value="">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">学历类别</div>
        <div class="weui-cells">
            <div class="weui-cell">
            	<div class="weui-cell__bd">
					<select class="weui-select" id="Vcl_EducationType" name="Vcl_EducationType">
	                    <option value="就业学历">就业学历</option>
	                    <option value="第二学历">第二学历</option>
	                </select>
		        </div>
            </div>
        </div>
        <div class="weui-cells__title">学历与学位</div>
        <div class="weui-cells">
            <div class="weui-cell">
            	<div class="weui-cell__bd">
					<select class="weui-select" id="Vcl_Education" name="Vcl_Education">
						<option value="">请选择</option>
	                    <option value="高中">高中</option>
	                    <option value="中专">中专</option>
	                    <option value="大专">大专</option>
	                    <option value="本科">本科</option>
	                    <option value="硕士研究生">硕士研究生</option>
	                    <option value="博士研究生">博士研究生</option>
	                </select>
		        </div>
            </div>
        </div>
        <div class="weui-cells__title">毕业学校</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_School" name="Vcl_School" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">所学专业</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Profession" name="Vcl_Profession" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">学制</div>
        <div class="weui-cells">
            <div class="weui-cell">
            	<div class="weui-cell__bd">
					<select class="weui-select" id="Vcl_Length" name="Vcl_Length">
						<option value="">请选择</option>
	                    <option value="2年制">2年制</option>
	                    <option value="3年制">3年制</option>
	                    <option value="4年制">4年制</option>
	                    <option value="5年制">5年制</option>
	                </select>
		        </div>
            </div>
        </div>
        <div class="weui-cells__title">专业类别</div>
        <div class="weui-cells">
            <div class="weui-cell">
            	<div class="weui-cell__bd">
					<select class="weui-select" id="Vcl_ProType" name="Vcl_ProType">
						<option value="">请选择</option>
	                    <option value="哲学">哲学</option>
	                    <option value="经济学">经济学</option>
	                    <option value="法学">法学</option>
	                    <option value="教育学">教育学</option>
	                    <option value="文学">文学</option>
	                    <option value="历史学">历史学</option>
	                    <option value="理学">理学</option>
	                    <option value="工学">工学</option>
	                    <option value="农学">农学</option>
	                    <option value="医学">医学</option>
	                    <option value="军事学">军事学</option>
	                    <option value="管理学">管理学</option>
	                    <option value="艺术学">艺术学</option>
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
		if ($('#Vcl_GraduateDate').val()=='')
		{
			Dialog_Message("[毕业时间] 不能为空！",function(){
				document.getElementById("Vcl_GraduateDate").focus()
			})		
			return
		}
		if ($('#Vcl_Education').val()=='')
		{
			Dialog_Message("请选择 [学历与学位] ！",function(){
				document.getElementById("Vcl_Education").focus()
			})		
			return
		}
		if ($('#Vcl_School').val()=='')
		{
			Dialog_Message("[毕业学校] 不能为空！",function(){
				document.getElementById("Vcl_School").focus()
			})		
			return
		}
		if ($('#Vcl_Profession').val()=='')
		{
			Dialog_Message("[所学专业] 不能为空！",function(){
				document.getElementById("Vcl_Profession").focus()
			})		
			return
		}
		if ($('#Vcl_Length').val()=='')
		{
			Dialog_Message("请选择 [学制] ！",function(){
				document.getElementById("Vcl_Length").focus()
			})		
			return
		}
		if ($('#Vcl_ProType').val()=='')
		{
			Dialog_Message("请选择 [专业类别] ！",function(){
				document.getElementById("Vcl_ProType").focus()
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