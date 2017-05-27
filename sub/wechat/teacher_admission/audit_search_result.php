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
	echo "<script>location.href='audit_search_failed.php?id=1'</script>"; 
	exit(0);
}
if ($o_stu->getState(0)<1)
{
	//没有通知信息核验
	echo "<script>location.href='audit_search_failed.php?id=2'</script>"; 
	exit(0);
}
if ($o_stu->getState(0)>1)
{
	//已经通过信息核验
	echo "<script>location.href='audit_search_failed.php?id=3'</script>"; 
	exit(0);
}
?>
	<form action="../include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
		<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
		<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
		<input type="hidden" id="Vcl_FunName" name="Vcl_FunName" value="AuditApprove"/>
		<input type="hidden" name="Vcl_StudentId" value="<?php echo($_GET['id'])?>"/>
		<div class="page__hd" style="padding:0px;padding-top:10px;">
	        <h1 class="page__title" style="font-size:28px;padding:0px;text-align:center">幼儿信息</h1>
	    </div>
			<?php 
				require_once 'audit_search_result_detail.php';
			?>
		<div class="page__hd" style="padding:0px;padding-top:15px;">
	        <h1 class="page__title" style="font-size:28px;padding:0px;text-align:center">信息核验选项</h1>
	    </div>
	    <?php 
	    $o_question=new Student_Audit_Question();
	    $o_question->PushOrder ( array ('Number','A') );   
	    for($i=0;$i<$o_question->getAllCount();$i++)
	    {
	    	
	    	//选项
	    	if ($o_question->getType($i)==0)
	    	{
	    		echo('
		    	<div class="weui-cells__title">'.$o_question->getNumber($i).'. '.$o_question->getText($i).' （单选）</div>
		    	');
	    		//单选
	    		echo('
		    	<div class="weui-cells weui-cells_radio">
		    	');
	    		$o_option=new Student_Audit_Option();
	    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) ); 
	    		$o_option->PushOrder ( array ('Number','A') ); 
	    		for($j=0;$j<$o_option->getAllCount();$j++)
	    		{
	    			echo('
				    	<label class="weui-cell weui-check__label" for="Vcl_Option_'.$o_option->getId($j).'">
			                <div class="weui-cell__bd">
			                    <p>'.$o_option->getText($j).'</p>
			                </div>
			                <div class="weui-cell__ft">
			                    <input value="'.$o_option->getText($j).'" type="radio" class="weui-check" name="Vcl_Question_'.$o_question->getId($i).'" id="Vcl_Option_'.$o_option->getId($j).'">
			                    <span class="weui-icon-checked"></span>
			                </div>
			            </label>
			    	');
	    		}
	    	}else{
	    		echo('
		    	<div class="weui-cells__title">'.$o_question->getNumber($i).'. '.$o_question->getText($i).' （多选）</div>
		    	');
	    		//多选
	    		echo('
		    	<div class="weui-cells weui-cells_checkbox">
		    	');
	    		$o_option=new Student_Audit_Option();
	    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) ); 
	    		$o_option->PushOrder ( array ('Number','A') ); 
	    		for($j=0;$j<$o_option->getAllCount();$j++)
	    		{
	    			echo('
		    			<label class="weui-cell weui-check__label" for="Vcl_Option_'.$o_option->getId($j).'">
			                
			                <div class="weui-cell__bd">
			                    <p>'.$o_option->getText($j).'</p>
			                </div>
			                <div class="weui-cell__hd">
			                    <input type="checkbox" class="weui-check" name="Vcl_Option_'.$o_option->getId($j).'" id="Vcl_Option_'.$o_option->getId($j).'">
			                    <i class="weui-icon-checked"></i>
			                </div>
			            </label>
	    			');
	    		}
	    	}
	    	echo('
	    	</div>
	    	');
	    }
	    ?>
	    <div class="weui-cells__title">核验备注</div>
		<div class="weui-cells weui-cells_checkbox" style="margin-top:0px;">
	        <div class="weui-cell">
	            <div class="weui-cell__bd">
	                <input class="weui-input" type="text" id="Vcl_AuditRemark" name="Vcl_AuditRemark" placeholder="核验不通过时，必填"/>
	            </div>
	        </div>
        </div>
	    <div style="padding:15px;">
	    	<a id="next" class="weui-btn weui-btn_primary" onclick="audit_approve()">通过核验</a>
	    	<a id="next" class="weui-btn weui-btn_default" onclick="audit_reject()">核验不通过</a>
	    </div>
	</form>
<script type="text/javascript" src="<?php echo(RELATIVITY_PATH.'sub/wechat/parent_signup/')?>js/function.js"></script>
<script type="text/javascript" src="<?php echo(RELATIVITY_PATH.'sub/wechat/teacher_admission/')?>js/function.js"></script>
<script>
<?php 
//基本信息
	echo('document.getElementById("Vcl_Name").value="'.$o_stu->getName(0).'";
	');
	echo('document.getElementById("Vcl_ID").value="'.$o_stu->getId(0).'";
	');
	echo('document.getElementById("Vcl_HAdd").value="'.$o_stu->getHAdd(0).'";');
	if($o_stu->getZSame(0)=='否')
	{
		echo('document.getElementById("Vcl_ZAdd").value="'.$o_stu->getZAdd(0).'";
		');		
	}else{
		echo('document.getElementById("Vcl_ZAdd").value="'.$o_stu->getHAdd(0).'";
		');	
	}
?>
	for(var i = 4; i < document.getElementsByTagName("input").length; i++){
		vcl_disabled(document.getElementsByTagName("input")[i])
	}
	for(var i = 0; i < document.getElementsByTagName("select").length; i++){
		vcl_disabled(document.getElementsByTagName("select")[i])
	}
	$('#Vcl_AuditRemark').removeAttr("disabled");
	$('[type=radio]').removeAttr("disabled");
	$('[type=checkbox]').removeAttr("disabled");
	
</script>
<?php
require_once '../footer.php';
?>