<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='添加资格职称';
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
			<input type="hidden" name="Vcl_FunName" value="TeacherInfoJobtitleAdd"/>
			<input type="hidden" name="Vcl_Picture" id="Vcl_Picture" value=""/>
        <div class="weui-cells__title">资格证名称</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Name" name="Vcl_Name" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">类型</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                	<select class="weui-select" id="Vcl_Type" name="Vcl_Type">
                    	<option value="">请选择</option>
                    	<option value="从业资格">从业资格</option>
                    	<option value="专业职称">专业职称</option>
	                </select>
                </div>
            </div>
        </div>
        <div class="weui-cells__title">证书编号</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Number" name="Vcl_Number" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">发证机关</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Organization" name="Vcl_Organization" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
		<div class="weui-cells__title">发证时间</div>
		<div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label for="" class="weui-label">年份</label></div>
                <div class="weui-cell__bd">
                    <select class="weui-select" id="Vcl_Year" name="Vcl_Year">
                    	<?php
                    	$o_date = new DateTime ( 'Asia/Chongqing' );
                    	for($i=1980;$i<=$o_date->format ('Y');$i++)
                    	{
                    		echo('<option value="'.$i.'年">'.$i.'</option>');
                    	}
                    	?>
	                </select>
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label for="" class="weui-label">月份</label></div>
                <div class="weui-cell__bd">
                    <select class="weui-select" id="Vcl_Month" name="Vcl_Month">
                    	<?php
                    	$o_date = new DateTime ( 'Asia/Chongqing' );
                    	for($i=1;$i<=12;$i++)
                    	{
                    		echo('<option value="'.$i.'月">'.$i.'</option>');
                    	}
                    	?>
	                </select>
                </div>
            </div>
        </div>        
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
		if ($('#Vcl_Name').val()=='')
		{
			Dialog_Message("[资格证名称] 不能为空！",function(){
				document.getElementById("Vcl_Name").focus()
			})		
			return
		}
		if ($('#Vcl_Type').val()=='')
		{
			Dialog_Message("请选择 [类型] ！",function(){
				document.getElementById("Vcl_Type").focus()
			})		
			return
		}
		if ($('#Vcl_Number').val()=='')
		{
			Dialog_Message("[证书编号] 不能为空！",function(){
				document.getElementById("Vcl_Number").focus()
			})		
			return
		}
		if ($('#Vcl_Organization').val()=='')
		{
			Dialog_Message("[发证机关] 不能为空！",function(){
				document.getElementById("Vcl_Organization").focus()
			})		
			return
		}
		if ($('#Vcl_Picture').val()=='')
		{
			Dialog_Message("请上传证书！")		
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