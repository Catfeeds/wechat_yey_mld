<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='添加学习培训';
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
require_once '../header_upload_images.php';
?>
<link rel="stylesheet" href="css/teacher_info.css"/>
<div class="page">
	<div class="page__bd">
		<form action="<?php echo($RELATIVITY_PATH)?>sub/dailywork/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="TeacherInfoTrainingAdd"/>
			<input type="hidden" name="Vcl_Picture" id="Vcl_Picture" value=""/>
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
        <div class="weui-cells__title">培训类型</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                	<select class="weui-select" id="Vcl_Type" name="Vcl_Type">
                    	<option value="">请选择</option>
                    	<option value="异地培训">异地培训</option>
                    	<option value="领域现场">领域现场</option>
                    	<option value="讲座培训">讲座培训</option>
                    	<option value="区内观摩">区内观摩</option>
                    	<option value="市级观摩">市级观摩</option>
                    	<option value="名师工作室">名师工作室</option>
                    	<option value="教研组">教研组</option>
	                </select>
                </div>
            </div>
        </div>
        <div class="weui-cells__title">培训内容</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Content" name="Vcl_Content" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">主办单位</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Organization" name="Vcl_Organization" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
		<div class="weui-cells__title">是否取得证书</div>
		<div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <select class="weui-select" id="Vcl_IsCertificate" name="Vcl_IsCertificate" onchange="select_iscertificate(this)">
                    	<option value="是">是</option>
                    	<option value="否">否</option>
	                </select>
                </div>
            </div>            
        </div>
        <div id="upload_image">   
        <div class="weui-cells__title">上传证书</div>
        <div class="weui-cells">
            <div id="origin_level_photo" class="weui-cell">
	        	<div class="weui-cell__hd"><label class="weui-label">请横向拍摄<br/><br/>证书原件照片</label></div>
	            <div class="weui-cell__bd">
	            	<div class="upload_level_photo">
	            		<img id="level_photo" src="images/photo_example_bj.jpg"/>
	            	</div>
	            	<div class="upload_btn" onclick="choose_credential_image('<?php echo($s_token)?>')">
	            		<img src="images/photo_btn.png" style="width:160px"/>
	            	</div>
	            </div>
	        </div>
        </div>
        </div>
        <div class="weui-cells__title">思想感悟</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Feeling" name="Vcl_Feeling" class="weui-input" type="text" placeholder="必填">
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
<script src="js/function.js" charset="utf-8"></script>
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
		if ($('#Vcl_Type').val()=='')
		{
			Dialog_Message("请选择 [培训类型] ！",function(){
				document.getElementById("Vcl_Type").focus()
			})		
			return
		}
		if ($('#Vcl_Content').val()=='')
		{
			Dialog_Message("[培训内容] 不能为空！",function(){
				document.getElementById("Vcl_Content").focus()
			})		
			return
		}
		if ($('#Vcl_Organization').val()=='')
		{
			Dialog_Message("[主办单位] 不能为空！",function(){
				document.getElementById("Vcl_Organization").focus()
			})		
			return
		}
		if ($('#Vcl_IsCertificate').val()=='是')
		{
			if ($('#Vcl_Picture').val()=='')
			{
				Dialog_Message("请上传证书！")
				return
			}
		}	
		if ($('#Vcl_Feeling').val()=='')
		{
			Dialog_Message("[思想感悟] 不能为空！",function(){
				document.getElementById("Vcl_Feeling").focus()
			})		
			return
		}	
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	});
}
function select_iscertificate(obj)
{
	if (obj.value=='是')
	{
		$('#upload_image').show()
	}else{
		$('#upload_image').hide()
	}
}
</script>
<?php
require_once '../footer.php';
?>