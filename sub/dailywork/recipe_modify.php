<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120602);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                           更换菜肴
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="RecipeModify"/>
						<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
						<input type="hidden" name="Vcl_Dishnum" value="<?php echo($_GET['dishnum'])?>"/>
						<input type="hidden" name="Vcl_Dishname" value="<?php echo($_GET['dishname'])?>"/>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label>原菜肴：</label>
	                     		<fieldset disabled>
	                     		<input maxlength="20" type="text" style="width:100%" class="form-control" value="<?php echo($_GET['dishname'].'  '.$_GET['dishnum'])?>"/>
	                     		</fieldset>
	                     	</div>	
	                     	<div class="item">
	                     		<label><span class="must">*</span> 更换为：</label><br/>
	                     		<select name="Vcl_ChangeId" id="Vcl_ChangeId" class="selectpicker" data-style="btn-default">
	                     			<option value="">请选择</option>
	                     			<?php 
	                     			$o_temp = new Ek_Cuisine();
	                     			$o_temp->PushOrder ( array ('Dishname', 'A') );
	                     			for($i=0;$i<$o_temp->getAllCount();$i++)
	                     			{
	                     				echo('<option value="'.$o_temp->getDishnum($i).'">'.$o_temp->getDishname($i).'  '.$o_temp->getDishnum($i).'</option>');
	                     			}
	                     			?>	                     			
   								</select>
	                     	</div>	
	                     		                     	
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="recipe_modify()"><?php echo(Text::Key('Submit'))?></button>
							</div>
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>

<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>