<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120401);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单

?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                            <?php
                            $s_funname='ParentSurveyManageAdd'; 
                            if($_GET[id]>0)
                            {
                            	$o_table=new Survey($_GET['id']);
                            	$s_funname='ParentSurveyManageModify'; 
                            	echo('修改问卷');
								if($o_table->getTitle()==null || $o_table->getTitle()=='' || $o_table->getState()==1)
								{
									echo("<script>location='parent_survey_manage.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('新建问卷');
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
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label><span class="must">*</span> 问卷标题：</label>
	                     		<input name="Vcl_Title" maxlength="50" id="Vcl_Title" type="text" style="width:100%" placeholder="必填" class="form-control" aria-describedby="basic-addon1" />
	                     	</div>	
	                     	<div class="item">
	                     		<label>问卷说明简述：</label>
	                     		<textarea  name="Vcl_Comment" maxlength="500" id="Vcl_Comment" type="text" style="width:100%" placeholder="选填，不能超过500字" class="form-control" rows="10"/><?php echo($o_table->getComment())?></textarea>
	                     	</div>                     	
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="parent_survey_manage_modify()"><?php echo(Text::Key('Submit'))?></button>
							</div>
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
<?php 
if($_GET['id']>0)
{
?>
$('#Vcl_Title').val('<?php echo($o_table->getTitle())?>');
<?php 
}
?>
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>