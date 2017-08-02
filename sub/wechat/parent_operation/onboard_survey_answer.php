<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='入园问卷调查';
require_once '../header.php';
$o_survey=new Student_Onboard_Survey($_GET['id']);
//判断用户是否已经做过此问卷
$o_answer=new Student_Onboard_Survey_Answers();
$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$_GET['id']) ); 
$o_answer->PushWhere ( array ('&&', 'StudentId', '=',$_GET['studentid']) );
$o_answer->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
if ($o_answer->getAllCount()>0)
{
	//已经答题，跳转到完成页面
	echo "<script>location.href='survey_answer_completed.php'</script>"; 
	exit(0);
}
//检查微信用户是否有权限访问此问卷
$o_stu=new Student_Onboard_Info_Class_Wechat_View();
$o_stu->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
$o_stu->PushWhere ( array ('&&', 'StudentId', '=',$_GET['studentid']) );
$o_stu->getAllCount();
if ($o_stu->getAllCount()==0)
{
	echo "<script>window.alert('对不起，您没有权限访问此问卷！');</script>"; 
	exit(0);
} 
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
		<input type="hidden" id="Vcl_FunName" name="Vcl_FunName" value="OnboardParentSurveyAnswer"/>
		<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
		<input type="hidden" name="Vcl_StudentId" value="<?php echo($_GET['studentid'])?>"/>
		<div class="page__hd" style="padding:15px;padding-bottom:0px;">
	        <h1 class="page__title" style="font-size:28px;padding:0px;text-align:center"><?php echo($o_survey->getTitle())?></h1>
	         <p class="page__desc" style="color:#666666;font-size:16px;">
				<?php 
				require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
				$o_bn_base=new Bn_Basic();
				echo($o_bn_base->AilterTextArea($o_survey->getComment()))?>
			</p>
	    </div>
	    <?php 
	    $n_number=1;
	    $o_question=new Student_Onboard_Survey_Questions();
	    $o_question->PushWhere ( array ('&&', 'SurveyId', '=',$_GET['id']) ); 
	    $o_question->PushOrder ( array ('Number','A') );   
	    for($i=0;$i<$o_question->getAllCount();$i++)
	    {
	    	
	    	//选项
	    	if ($o_question->getType($i)==1)
	    	{
	    		echo('
		    	<div class="weui-cells__title">'.$n_number.'. '.$o_question->getQuestion($i).' （单选）</div>
		    	');
	    		//单选
	    		echo('
		    	<div class="weui-cells weui-cells_radio">
		    	');
	    		$o_option=new Student_Onboard_Survey_Options();
	    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) ); 
	    		$o_option->PushOrder ( array ('Number','A') ); 
	    		for($j=0;$j<$o_option->getAllCount();$j++)
	    		{
	    			echo('
				    	<label class="weui-cell weui-check__label" for="Vcl_Option_'.$o_option->getId($j).'">
			                <div class="weui-cell__bd">
			                    <p>&nbsp;&nbsp;&nbsp;&nbsp;'.$o_option->getOption($j).'</p>
			                </div>
			                <div class="weui-cell__ft">
			                    <input value="'.$o_option->getId($j).'" type="radio" class="weui-check" name="Vcl_Question_'.$o_question->getId($i).'" id="Vcl_Option_'.$o_option->getId($j).'">
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
		    	<div class="weui-cells__title">'.$n_number.'. '.$o_question->getQuestion($i).' （多选）</div>
		    	');
	    		//多选
	    		echo('
		    	<div class="weui-cells weui-cells_checkbox">
		    	');
	    		$o_option=new Student_Onboard_Survey_Options();
	    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) ); 
	    		$o_option->PushOrder ( array ('Number','A') ); 
	    		for($j=0;$j<$o_option->getAllCount();$j++)
	    		{
	    			echo('
		    			<label class="weui-cell weui-check__label" for="Vcl_Option_'.$o_option->getId($j).'">			                
			                <div class="weui-cell__bd">
			                    <p>&nbsp;&nbsp;&nbsp;&nbsp;'.$o_option->getOption($j).'</p>
			                </div>
			                <div class="weui-cell__hd">
			                    <input type="checkbox" class="weui-check" name="Vcl_Option_'.$o_option->getId($j).'" id="Vcl_Option_'.$o_option->getId($j).'">
			                    <i class="weui-icon-checked"></i>
			                </div>
			            </label>
	    			');
	    		}
	    		echo('
		    	</div>
		    	');
	    	}elseif ($o_question->getType($i)==3 || $o_question->getType($i)==4){
	    		//简答
	    		echo('
	    		<div class="weui-cells__title">'.$n_number.'. '.$o_question->getQuestion($i).'</div>
				<div class="weui-cells weui-cells_checkbox" style="margin-top:0px;">
			        <div class="weui-cell">
			            <div class="weui-cell__bd">
			                <input class="weui-input" type="text" name="Vcl_Question_'.$o_question->getId($i).'" placeholder="'.$o_question->getExplain($i).'"/>
			            </div>
			        </div>
		        </div>
	    		');
	    	}else{
	    		//简答
	    		echo('
	    		<div class="weui-cells__title sub_title">'.$o_question->getQuestion($i).'</div>	    		
	    		');
	    		$n_number=0;
	    	}
	    	$n_number++;
	    }
	    ?>
	    <div style="padding:15px;">
	    	<a id="next" class="weui-btn weui-btn_primary" onclick="survey_answer_submit()">提交问卷</a>
	    </div>
	</form>
<script type="text/javascript" src="js/function.js"></script>
<script>
	
</script>
<?php
require_once '../footer.php';
?>