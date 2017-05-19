<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120202);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';

ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单

?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                            <?php
                            $s_funname='ClassAdd'; 
                            if($_GET[id]>0)
                            {
                            	$o_table=new Student_Class($_GET['id']);
                            	$s_funname='ClassModify'; 
                            	echo('修改班级信息');
								if($o_table->getClassName()==null || $o_table->getClassName()=='')
								{
									echo("<script>location='class.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('添加班级');
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
                    		<?php 
                    		if($_GET['id']>0)
                    		{
                    			?>
                    			<div class="item">
		                     		<label>年级：</label><br/>
		                     		<select disabled="disabled" name="Vcl_Grade" id="Vcl_Grade" class="selectpicker" data-style="btn-default">
		                     			<option value="">请选择年级</option>
		                     			<option value="1">托班</option>
	        							<option value="2">小班</option>
	        							<option value="3">中班</option>
	        							<option value="4">大班</option>
	   								</select>
		                     	</div>
                    			<?php
                    		}else{
                    			?>
                    			<div class="item">
		                     		<label><span class="must">*</span> 年级：</label><br/>
		                     		<select name="Vcl_Grade" id="Vcl_Grade" class="selectpicker" data-style="btn-default">
		                     			<option value="">请选择年级</option>
		                     			<option value="1">托班</option>
	        							<option value="2">小班</option>
	        							<option value="3">中班</option>
	        							<option value="4">大班</option>
	   								</select>
		                     	</div>
                    			<?php
                    		}
                    		?>                    		
	                     	<div class="item">
	                     		<label><span class="must">*</span> 班级名称：</label>
	                     		<input name="Vcl_ClassName" maxlength="20" id="Vcl_ClassName" type="text" style="width:100%" class="form-control"/>
	                     	</div>		                     	     	
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="class_modify()"><?php echo(Text::Key('Submit'))?></button>
							</div>
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
<?php 
if($_GET['id']>0)
{
?>
$('#Vcl_Grade').val('<?php echo($o_table->getGrade())?>');
$('#Vcl_ClassName').val('<?php echo($o_table->getClassName())?>');
<?php 
}
?>
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>