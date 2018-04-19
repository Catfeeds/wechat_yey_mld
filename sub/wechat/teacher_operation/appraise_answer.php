<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='评价问卷';
require_once '../header.php';
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
$o_bn_basic=new Bn_Basic();
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat_View();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$o_survey=new Survey_Appraise($_GET['appraise_id']);
/*
//判断用户是否已经做过此问卷
$o_answer=new Survey_Appraise_Answers();
$o_answer->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) ); 
$o_answer->PushWhere ( array ('&&', 'Uid', '=',$o_temp->getUid(0)) );
$o_answer->PushWhere ( array ('&&', 'School', '=',$o_temp->getUid(0)) );
if ($o_answer->getAllCount()>0)
{
	//已经答题，跳转到完成页面
	echo "<script>location.href='survey_answer_completed.php?id=".$o_survey->getId()."'</script>"; 
	exit(0);
}
*/
if($o_survey->getState()!='1')
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
if((int)$_GET['class_id']>0)
{

}else{
	echo "<script>location.href='loading_failed.php'</script>";
	exit(0);
}
//查看这个督学是否已经评价过该项目
$o_answer=new Survey_Appraise_Answers();
$o_answer->PushWhere ( array ('&&', 'Uid', '=',$o_temp->getUid(0)) ); 
$o_answer->PushWhere ( array ('&&', 'ClassId', '=',$_GET['class_id']) ); 
$o_answer->getAllCount();



//http://10.189.240.42/xchdds/sub/wechat/Survey/appraise_answer.php?id=11&school_id=141&info_0=%E5%88%9D%E4%B8%80%E7%8F%AD&info_1=%E8%AF%AD%E6%96%87&info_2=2014-12-12&info_3=%E4%BD%9C%E6%96%87&info_4=%E6%9D%8E%E5%B0%8F%E7%92%90
//echo('http://10.189.240.42/xchdds/sub/wechat/Survey/appraise_answer.php?id=11&school_id=141&info_0='.rawurlencode('初一班').'&info_0='.rawurlencode('语文').'&info_0='.rawurlencode('2014-12-12').'&info_0='.rawurlencode('作文').'&info_0='.rawurlencode('李小璐'));
/*
//检查微信用户是否有权限访问此问卷
$o_stu=new Base_User_Role_Wechat_View();
$o_stu->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
$o_stu->PushWhere ( array ('&&', 'Uid', '=',$_GET['uid']) );
$o_stu->getAllCount();
$o_role=new Survey_Teacher();
$o_role->PushWhere ( array ('||', 'Id', '=',$_GET['id']) ); 
$o_role->PushWhere ( array ('&&', 'TargetList', 'like','%"'.$o_stu->getRoleId(0).'"%') );
$o_role->PushWhere ( array ('||', 'Id', '=',$_GET['id']) ); 
$o_role->PushWhere ( array ('&&', 'TargetList', 'like','%"'.$o_stu->getSecRoleId1(0).'"%') );
$o_role->PushWhere ( array ('||', 'Id', '=',$_GET['id']) ); 
$o_role->PushWhere ( array ('&&', 'TargetList', 'like','%"'.$o_stu->getSecRoleId2(0).'"%') );
$o_role->PushWhere ( array ('||', 'Id', '=',$_GET['id']) ); 
$o_role->PushWhere ( array ('&&', 'TargetList', 'like','%"'.$o_stu->getSecRoleId3(0).'"%') );
$o_role->PushWhere ( array ('||', 'Id', '=',$_GET['id']) ); 
$o_role->PushWhere ( array ('&&', 'TargetList', 'like','%"'.$o_stu->getSecRoleId4(0).'"%') );
$o_role->PushWhere ( array ('||', 'Id', '=',$_GET['id']) ); 
$o_role->PushWhere ( array ('&&', 'TargetList', 'like','%"'.$o_stu->getSecRoleId5(0).'"%') );
if ($o_stu->getAllCount()==0 || $o_role->getAllCount()==0)
{
	echo "<script>window.alert('对不起，您没有权限访问此问卷！');</script>"; 
	exit(0);
} */
?>
<style>
.weui-cells__title
{
	font-size:16px;	
	color:#000000;
}
.sub_title{
	font-weight: bold;
	font-size:20px;
}
.weui-cell__bd p
{
	color:#666666;
}
</style>
	<form action="../include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
		<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
		<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
		<input type="hidden" id="Vcl_FunName" name="Vcl_FunName" value="AppraiseAnswer"/>
		<input type="hidden" name="Vcl_ClassId" value="<?php echo($_GET['class_id'])?>"/>
		<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['appraise_id'])?>"/>
		<input type="hidden" name="Vcl_AnswerId" value="<?php 
		if ($o_answer->getAllCount()>0)
		{
			echo($o_answer->getId(0));
		}
		?>"/>
		<input type="hidden" name="Vcl_IsAuto" id="Vcl_IsAuto" value="<?php echo($o_survey->getIsAuto())?>"/>
		<div class="page__hd" style="padding:15px;padding-bottom:0px;">
	        <h1 class="page__title" style="font-size:28px;padding:0px;text-align:center"><?php echo($o_survey->getTitle())?></h1>
	    </div>
	    <div class="weui-cells__title">评价表基本信息</div>
	    <div class="weui-cells weui-cells_form">
	    	<?php 
	    		$a_vcl=json_decode($o_survey->getInfo());
	    		for($i=0;$i<count($a_vcl);$i++)
	    		{
	    			?>
	    		<div class="weui-cell">
	                <div class="weui-cell__hd"><label class="weui-label"><?php echo(rawurldecode($a_vcl[$i]))?></label></div>
	                <div class="weui-cell__bd">
	                    <input class="weui-input" value="<?php echo(rawurldecode($_GET['info_'.$i]))?>" name="Vcl_Info_<?php echo($i)?>" type="text" placeholder="必填">
	                </div>
	            </div>	
	    			<?php
	    		}
	    	?>  
	    	<div class="weui-cell">
	            <div class="weui-cell__hd"><label class="weui-label">评价人</label></div>
	            <div class="weui-cell__bd">
	                <input readonly="readonly" class="weui-input" value="<?php echo($o_temp->getName(0))?>" name="" type="text" placeholder="必填">
	            </div>
	        </div>                      
        </div>
	    <?php
	    $n_number=1;
	    $o_question=new Survey_Appraise_Questions();
	    $o_question->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['appraise_id']) ); 
	    $o_question->PushOrder ( array ('Number','A') );   
	    for($i=0;$i<$o_question->getAllCount();$i++)
	    {
	    	//是否我必答题
	    	$s_must='';
	    	if ($o_question->getIsMust($i)==1)
	    	{
	    		$s_must='<span style="color:red">*</span> ';
	    	}
	    	//选项
	    	if ($o_question->getType($i)==1)
	    	{
	    		echo('
		    	<div class="weui-cells__title">'.$s_must.$n_number.'. '.$o_question->getQuestion($i).' （单选）</div>
		    	');
	    		//单选
	    		echo('
		    	<div class="weui-cells weui-cells_radio">
		    	');
	    		$s_answer='';
	    		if ($o_answer->getAllCount())
	    		{
	    			eval('$s_answer=$o_answer->getAnswer'.$o_question->getNumber($i).'(0);');//获取用户答案
	    			$s_answer=str_replace('"', '', $s_answer);//去掉多余的双引号
	    		}
	    		$o_option=new Survey_Appraise_Options();
	    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) ); 
	    		$o_option->PushOrder ( array ('Number','A') ); 
	    		for($j=0;$j<$o_option->getAllCount();$j++)
	    		{
	    			$s_checked='';
	    			if ($s_answer==$o_option->getId($j))
	    			{
	    				$s_checked=' checked="checked"';
	    			}
	    			echo('
				    	<label class="weui-cell weui-check__label" for="Vcl_Option_'.$o_option->getId($j).'">
			                <div class="weui-cell__bd">
			                    <p>&nbsp;&nbsp;&nbsp;&nbsp;'.$o_option->getNumber($j).'. '.$o_option->getOption($j).'</p>
			                </div>
			                <div class="weui-cell__ft">
			                    <input value="'.$o_option->getId($j).'" type="radio" class="weui-check"'.$s_checked.' name="Vcl_Question_'.$o_question->getId($i).'" id="Vcl_Option_'.$o_option->getId($j).'">
			                    <span class="weui-icon-checked"></span>
			                </div>
			            </label>
			    	');
	    		}
	    		echo('
		    	</div>
		    	');
	    	}else if ($o_question->getType($i)==2){
	    		echo('
		    	<div class="weui-cells__title">'.$s_must.$n_number.'. '.$o_question->getQuestion($i).' （多选）</div>
		    	');
	    		//多选
	    		echo('
		    	<div class="weui-cells weui-cells_checkbox">
		    	');
	    		$s_answer='';
	    		if ($o_answer->getAllCount())
	    		{
	    			eval('$s_answer=$o_answer->getAnswer'.$o_question->getNumber($i).'(0);');//获取用户答案
	    			$s_answer=str_replace('"', '', $s_answer);//去掉多余的双引号
	    			$s_answer=json_decode($s_answer);
	    		}
	    		$o_option=new Survey_Appraise_Options();
	    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) ); 
	    		$o_option->PushOrder ( array ('Number','A') ); 
	    		for($j=0;$j<$o_option->getAllCount();$j++)
	    		{
	    			$s_checked='';
	    			if (in_array($o_option->getId($j),$s_answer))
	    			{
	    				$s_checked=' checked="checked"';
	    			}
	    			echo('
		    			<label class="weui-cell weui-check__label" for="Vcl_Option_'.$o_option->getId($j).'">			                
			                <div class="weui-cell__bd">
			                    <p>&nbsp;&nbsp;&nbsp;&nbsp;'.$o_option->getNumber($j).'. '.$o_option->getOption($j).'</p>
			                </div>
			                <div class="weui-cell__hd">
			                    <input type="checkbox" class="weui-check"'.$s_checked.' name="Vcl_Option_'.$o_option->getId($j).'" id="Vcl_Option_'.$o_option->getId($j).'">
			                    <i class="weui-icon-checked"></i>
			                </div>
			            </label>
	    			');
	    		}
	    		echo('
		    	</div>
		    	');
	    	}else if ($o_question->getType($i)==3){
	    		$s_answer='';
	    		if ($o_answer->getAllCount())
	    		{
	    			eval('$s_answer=$o_answer->getAnswer'.$o_question->getNumber($i).'(0);');//获取用户答案
	    			$s_answer=str_replace('"', '', $s_answer);//去掉多余的双引号
	    		}
	    		//简答
	    		echo('
	    		<div class="weui-cells__title">'.$s_must.$n_number.'. '.$o_question->getQuestion($i).' （简述）</div>
	    		<div class="weui-cells weui-cells_form">
		            <div class="weui-cell">
		                <div class="weui-cell__bd">
		                    <textarea class="weui-textarea" placeholder="" rows="3" name="Vcl_Question_'.$o_question->getId($i).'">'.rawurldecode($s_answer).'</textarea>
		                </div>
		            </div>
		        </div>				
	    		');
	    	}
	    	$n_number++;
	    }
	    ?>
	    <div style="padding:15px;">
	    	<a id="next" class="weui-btn weui-btn_primary" onclick="survey_answer_submit()">提交问卷</a>
	    	<a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
	    </div>
	</form>
<script>
	function survey_answer_submit()
	{
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	}
	function message_is_auto(str)
	{
		Dialog_Confirm(str,function(){message_is_auto_yes()});		
	}
	function message_is_auto_yes()
	{
		document.getElementById("Vcl_IsAuto").value="0";
		Common_OpenLoading();
		document.getElementById("submit_form").submit();			
	}
</script>
<?php
require_once '../footer.php';
?>