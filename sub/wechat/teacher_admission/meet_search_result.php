<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='搜索结果';
require_once '../header.php';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	exit(0);
}
//判断幼儿信息状态，如果不为小于1，那么提示为通知核验
$o_stu=new Student_Info_Wechat_Wiew();
$o_stu->PushWhere ( array ('&&', 'StudentId', '=',$_GET['id']) ); 
if ($o_stu->getAllCount()==0)
{
	//没有结果
	echo "<script>location.href='meet_search_failed.php?id=1'</script>"; 
	exit(0);
}
if ($o_stu->getState(0)<2)
{
	//没有通知信息核验
	echo "<script>location.href='meet_search_failed.php?id=2'</script>"; 
	exit(0);
}
if ($o_stu->getState(0)>2)
{
	//已经通过信息核验
	echo "<script>location.href='meet_search_failed.php?id=3'</script>"; 
	exit(0);
}
?>
	<form action="../include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
		<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
		<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
		<input type="hidden" name="Vcl_FunName" value="MeetSubmit"/>
		<input type="hidden" name="Vcl_StudentId" value="<?php echo($_GET['id'])?>"/>
		<div class="weui-cells__title">基本信息</div>
		<div class="weui-form-preview">
	        <div class="weui-form-preview__hd">
	            <div class="weui-form-preview__item">
	                <label class="weui-form-preview__label">幼儿编号</label>
	                <em class="weui-form-preview__value"><?php echo($o_stu->getStudentId(0))?></em>
	            </div>
	        </div>
	        <div class="weui-form-preview__bd">
	        	<div class="weui-form-preview__item">
	                <label class="weui-form-preview__label">幼儿姓名</label>
	                <span class="weui-form-preview__value"><?php echo($o_stu->getName(0))?></span>
	            </div>
		        <div class="weui-form-preview__item">
		           <label class="weui-form-preview__label">证件类型</label>
		            <span class="weui-form-preview__value"><?php echo($o_stu->getIdType(0))?></span>
		        </div>
		        <div class="weui-form-preview__item">
		            <label class="weui-form-preview__label">证件号</label>
		            <span class="weui-form-preview__value"><?php echo($o_stu->getId(0))?></span>
		        </div>
		        <div class="weui-form-preview__item">
		           <label class="weui-form-preview__label">性别</label>
		            <span class="weui-form-preview__value"><?php echo($o_stu->getSex(0))?></span>
		        </div>
		        <div class="weui-form-preview__item">
		           <label class="weui-form-preview__label">出生日期</label>
		            <span class="weui-form-preview__value"><?php echo($o_stu->getBirthday(0))?></span>
		        </div>
		    </div>
	    </div>
	    <div class="weui-cells__title">见面结果</div>
	    <div class="weui-cells weui-cells_checkbox">
	    <?php 
	    $o_item=new Student_Info_Meet_Item();
	    $o_item->PushOrder ( array ('Number','A') );
	    for($i=0;$i<$o_item->getAllCount();$i++)
	    {
	    	echo('
	    	<label class="weui-cell weui-check__label" for="Vcl_Item_'.$o_item->getId($i).'">
                <div class="weui-cell__hd">
                    <input type="checkbox" class="weui-check" name="Vcl_Item_'.$o_item->getId($i).'" id="Vcl_Item_'.$o_item->getId($i).'">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                    <p>'.$o_item->getName($i).'</p>
                </div>
            </label>
	    	');
	    }
	    ?>
	        <div class="weui-cell">
	            <div class="weui-cell__bd">
	                <input class="weui-input" type="text" name="Vcl_Remark" placeholder="备注（选填）"/>
	            </div>
	        </div>
        </div>
	    <div style="padding:15px;">
	    	<a id="next" class="weui-btn weui-btn_primary" onclick="meet_submit()">提交见面结果</a>
	    	<a id="next" class="weui-btn weui-btn_default" onclick="location='meet_search.php?'+Date.parse(new Date())">取消</a>
	    </div>
	</form>
<script type="text/javascript" src="<?php echo(RELATIVITY_PATH.'sub/wechat/parent_signup/')?>js/function.js"></script>
<script type="text/javascript" src="<?php echo(RELATIVITY_PATH.'sub/wechat/teacher_admission/')?>js/function.js"></script>
<script>

</script>
<?php
require_once '../footer.php';
?>