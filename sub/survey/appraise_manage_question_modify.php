<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120403);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单

?>
<style>
.sss_form div.item {
	width:80%;
	margin-left:10%;
}
.sss_form div.option a{
	background-color: #d9534f;
    border-color: #d9534f;
	color:white;
    transition-duration: 0.3s;
}
.sss_form div.option a:hover{
	color:white;
	background-color: #c9302c;
}
</style>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                            <?php
                            $s_funname='AppraiseManageQuestionAdd'; 
                            if($_GET['questionid']>0)
                            {
                            	$o_table=new Survey_Appraise_Questions($_GET['questionid']);
                            	$o_parent=new Survey_Appraise($o_table->getSurveyId());
                            	$s_funname='AppraiseManageQuestionModify'; 
                            	echo('修改题目');
								if($o_parent->getState()!='0')
								{
									echo("<script>location='appraise_manage.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('添加题目');
                            }
                            ?>
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="<?php echo($s_funname)?>"/>
						<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
						<input type="hidden" name="Vcl_QuestionId" value="<?php echo($_GET['questionid'])?>"/>
                    	<div class="sss_form">
                    		<div class="item">
	                     		<label>顺序：</label>
	                     		<select name="Vcl_Number" id="Vcl_Number" class="selectpicker" data-style="btn-default">
	                     		<?php
	                     		if($_GET['questionid']>0)
	                     		{
		                     		$o_temp=new Survey_Appraise_Questions();
		                     		$o_temp->PushWhere ( array ('&&', 'AppraiseId', '=',$o_table->getId()) );
		                     		$n_count=$o_temp->getAllCount();
		                     		for($i=0;$i<$n_count;$i++)
		                     		{
		                     			echo('<option value="'.($i+1).'">'.($i+1).'</option>');	                     			
		                     		}
	                     		}else{
	                     			//说明是新建
	                     			$o_temp=new Survey_Appraise_Questions();
		                     		$o_temp->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
		                     		$n_count=$o_temp->getAllCount();
		                     		for($i=0;$i<$n_count;$i++)
		                     		{
		                     			echo('<option value="'.($i+1).'">'.($i+1).'</option>');	                     			
		                     		}
		                     		echo('<option value="'.($n_count+1).'" selected="selected">'.($n_count+1).'</option>');
	                     		}
	                     		?>
   								</select>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 题目名称：</label>
	                     		<input name="Vcl_Question" maxlength="50" id="Vcl_Question" type="text" style="width:100%" placeholder="必填" class="form-control" aria-describedby="basic-addon1" />
	                     	</div>	
	                     	<div class="item">
	                     		<label>题型：</label><br/>
	                     		<select name="Vcl_Type" id="Vcl_Type" class="selectpicker" data-style="btn-default" onchange="change_type(this)">
	                     			<option value="1" selected="selected">单选</option>
        							<option value="2">多选</option>
        							<option value="3">简述</option>
   								</select>
	                     	</div>
	                     	<div class="item">
	                     		<label>是否必答：</label><br/>
	                     		<select name="Vcl_IsMust" id="Vcl_IsMust" class="selectpicker" data-style="btn-default">
	                     			<option value="1" selected="selected">必答</option>
									<option value="0">选答</option>
   								</select>
	                     	</div>
	                     	<div class="item option" style="display:none">
	                     		<label><span class="must">*</span> 选项（请按照顺序填写选项，如果中间有空行，系统将自动舍弃之后的内容）：</label>
	                     		<div class="input-group">
									<span class="input-group-addon">A</span>
									<input id="Vcl_Option_1" name="Vcl_Option_1" type="text" placeholder="必填" class="form-control" aria-label="Amount (to the nearest dollar)">
								</div>
								<div class="input-group" style="margin-top:10px;">
									<span class="input-group-addon">B</span>
									<input id="Vcl_Option_2" name="Vcl_Option_2" type="text" placeholder="必填" class="form-control" aria-label="Amount (to the nearest dollar)">
								</div>
								<?php 
								$a_number=array('C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T');
								for($i=0;$i<18;$i++)
								{
									?>
								<div id="<?php echo('option_'.($i+1))?>" class="input-group" style="margin-top:10px;">
									<span class="input-group-addon"><?php echo($a_number[$i])?></span>
									<input placeholder="选填" id="Vcl_Option_<?php echo($i+3)?>" name="Vcl_Option_<?php echo($i+3)?>" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
									<!--<a class="input-group-addon" href="javascript:;">
											<span class="glyphicon glyphicon-minus"></span>
										</a>
									--></div>	
									<?php
								}
								?>								
								<!--<button type="button" class="btn btn-primary" aria-hidden="true" style="margin-top:10px;margin-left:50%;outline: medium none" data-placement="left" onclick="plus_option()"><span class="glyphicon glyphicon-plus"></span></button>
	                     	--></div>                    	
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="appraise_manage_question_modify()"><?php echo(Text::Key('Submit'))?></button>
							</div>
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
function change_type(obj)
{
	if (obj.value>=3)
	{
		$('.option').hide();
	}else{
		$('.option').show();
	}
}
<?php 
if($_GET['questionid']>0)
{
	$o_option=new Survey_Appraise_Options();
	$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$_GET['questionid']) );
	$o_option->PushOrder ( array ('Id','A') );
	for($i=0;$i<$o_option->getAllCount();$i++)
	{
		//循环设置选项内容
		echo("$('#Vcl_Option_".($i+1)."').val('".$o_option->getOption($i)."');");
	}
?>
$('#Vcl_Question').val('<?php echo($o_table->getQuestion())?>');
$('#Vcl_Type').val('<?php echo($o_table->getType())?>');
$('#Vcl_IsMust').val('<?php echo($o_table->getIsMust())?>');
$('#Vcl_Number').val('<?php echo($o_table->getNumber())?>');
<?php 
}else{
	//如果超过50题，给出提示
	$o_table=new Survey_Appraise_Questions();
	$o_table->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['id']) );
	if ($o_table->getAllCount()>=50)
	{
		echo("dialog_message('对不起，问卷最大题目数为50，已经达到上限！',function(){parent.location='".$_SERVER['HTTP_REFERER']."'});");
	}
}
?>
change_type(document.getElementById('Vcl_Type'))
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>