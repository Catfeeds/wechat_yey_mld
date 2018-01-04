<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='添加获奖情况';
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
			<input type="hidden" name="Vcl_FunName" value="TeacherInfoAwardsAdd"/>
			<input type="hidden" name="Vcl_Picture" id="Vcl_Picture" value=""/>
		<div class="weui-cells__title">获奖时间</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Date" name="Vcl_Date" class="weui-input" type="date" placeholder="必填" value="">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">项目名称</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_Name" name="Vcl_Name" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">种类</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                	<select class="weui-select" id="Vcl_Category" name="Vcl_Category" onchange="category_change(this)">
                    	<option value="">请选择</option>
                    	<option value="荣誉类">荣誉类</option>
                    	<option value="评比类">评比类</option>
	                </select>
                </div>
            </div>
        </div>
        <div class="weui-cells__title">类别</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                	<select class="weui-select" id="Vcl_Type" name="Vcl_Type">
                    	<option value="">请选择</option>
                    	<option value="评优评先">评优评先</option>
                    	<option value="论文评选">论文评选</option>
                    	<option value="课件评选">课件评选</option>
                    	<option value="玩教具评选">玩教具评选</option>
                    	<option value="实操评选">实操评选</option>
                    	<option value="其他">其他</option>
	                </select>
                </div>
            </div>
        </div>
        <div class="weui-cells__title">级别</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                	<select class="weui-select" id="Vcl_Grade" name="Vcl_Grade">
                    	<option value="">请选择</option>
                    	<option value="国家级">国家级</option>
                    	<option value="省部级">省部级</option>
                    	<option value="市局级">市局级</option>
                    	<option value="区县级">区县级</option>
                    	<option value="校级">校级</option>
	                </select>
                </div>
            </div>
        </div>
        <div id="level">
	        <div class="weui-cells__title">等级</div>
			<div class="weui-cells">
	            <div class="weui-cell">
	                <div class="weui-cell__bd">
	                	<select class="weui-select" id="Vcl_Level" name="Vcl_Level">
	                    	<option value="">请选择</option>
	                    	<option value="特等奖">特等奖</option>
	                    	<option value="一等奖">一等奖</option>
	                    	<option value="二等奖">二等奖</option>
	                    	<option value="三等奖">三等奖</option>
	                    	<option value="四等奖">四等奖</option>
		                </select>
	                </div>
	            </div>
	        </div>
        </div>        
        <div class="weui-cells__title">角色排名</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_RoleLevel" name="Vcl_RoleLevel" class="weui-input" type="text" placeholder="必填">
                </div>
            </div>
        </div>
        <div class="weui-cells__title">批准部门</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <input id="Vcl_ApproveDept" name="Vcl_ApproveDept" class="weui-input" type="text" placeholder="必填">
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
		if ($('#Vcl_Date').val()=='')
		{
			Dialog_Message("[获奖时间] 不能为空！",function(){
				document.getElementById("Vcl_Date").focus()
			})		
			return
		}
		if ($('#Vcl_Name').val()=='')
		{
			Dialog_Message("[项目名称] 不能为空！",function(){
				document.getElementById("Vcl_EndDate").focus()
			})		
			return
		}
		if ($('#Vcl_Category').val()=='')
		{
			Dialog_Message("请选择 [种类] ！",function(){
				document.getElementById("Vcl_Category").focus()
			})		
			return
		}
		if ($('#Vcl_Type').val()=='')
		{
			Dialog_Message("请选择 [类别] ！",function(){
				document.getElementById("Vcl_Type").focus()
			})		
			return
		}
		if ($('#Vcl_Grade').val()=='')
		{
			Dialog_Message("请选择 [级别] ！",function(){
				document.getElementById("Vcl_Grade").focus()
			})		
			return
		}
		if ($('#Vcl_Category').val()!='荣誉类')
		{
			if ($('#Vcl_Level').val()=='')
			{
				Dialog_Message("请选择 [等级] ！",function(){
					document.getElementById("Vcl_Level").focus()
				})		
				return
			}
		}		
		if ($('#Vcl_RoleLevel').val()=='')
		{
			Dialog_Message("[角色排名] 不能为空！",function(){
				document.getElementById("Vcl_RoleLevel").focus()
			})		
			return
		}
		if ($('#Vcl_ApproveDept').val()=='')
		{
			Dialog_Message("[批准部门] 不能为空！",function(){
				document.getElementById("Vcl_ApproveDept").focus()
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
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	});
}
function category_change(obj)
{
	if (obj.value=='荣誉类')
	{
		$('#level').hide()
		$('#Vcl_Level').val('')
	}else{
		$('#level').show()
	}
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