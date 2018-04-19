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
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                            <?php
                            $s_funname='AppraiseManageAdd'; 
                            if($_GET[id]>0)
                            {
                            	$o_table=new Survey_Appraise($_GET['id']);
                            	$s_funname='AppraiseManageModify'; 
                            	echo('修改评价问卷');
								if($o_table->getTitle()==null || $o_table->getTitle()=='' || $o_table->getState()==1)
								{
									echo("<script>location='appraise_manage.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('新建评价问卷');
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
	                     		<label>类型：</label>
	                     		<select name="Vcl_Type" id="Vcl_Type" class="selectpicker" data-style="btn-default">
									<?php 
									$o_item=new Survey_Appraise_Info_Item();
									$o_item->PushOrder ( array ('Type', 'A' ) );
									$o_item->getAllCount();
									$s_type='';
									for($i=0;$i<$o_item->getAllCount();$i++)
									{
										if ($s_type!=$o_item->getType($i))
										{
											echo('<option value="'.$o_item->getType($i).'">'.$o_item->getType($i).'</option>');
											$s_type=$o_item->getType($i);
										}else{
											continue;
										}
										
									}					
									?>
								</select>
	                     	</div>
	                     	<div class="item" style="display:none">
	                     		<label>是否自动推荐综合评价等级：</label>
	                     		<select name="Vcl_IsAuto" id="Vcl_IsAuto" class="selectpicker" data-style="btn-default">
									<option value="0">否</option>
									<option value="1">是</option>
								</select>
	                     	</div>                   	
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="appraise_manage_modify()"><?php echo(Text::Key('Submit'))?></button>
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
$('#Vcl_Type').val('<?php echo($o_table->getType())?>');
$('#Vcl_IsAuto').val('<?php echo($o_table->getIsAuto())?>');	
<?php 
}
?>
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>