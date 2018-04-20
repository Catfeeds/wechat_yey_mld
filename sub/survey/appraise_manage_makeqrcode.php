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
                            $s_funname='AppraiseMakeQrcode'; 
                            if($_GET[id]>0)
                            {
                            	$o_table=new Survey_Appraise($_GET['id']);
                            	$s_funname='AppraiseMakeQrcode'; 
                            	echo('制作调查问卷二维码');
								if($o_table->getTitle()==null || $o_table->getTitle()=='' || $o_table->getState()!=1)
								{
									echo("<script>location='appraise_manage.php'</script>");
									exit(0);
								}
                            }else{
                            	echo("<script>location='appraise_manage.php'</script>");
                            	exit(0);
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
	                     		<label><span class="must">*</span> 班级名称：</label>
	                     		<select name="Vcl_ClassId" id="Vcl_ClassId" class="selectpicker" data-style="btn-default">
									<option value="">请选择评价对象</option>
									<?php 
									$o_dept=new Student_Class();
									$o_dept->PushOrder ( array ('Grade', 'A' ) );
									$o_dept->PushOrder ( array ('ClassNumber', 'A' ) );
									for($i=0;$i<$o_dept->getAllCount();$i++)
									{
										echo('<option value="'.$o_dept->getClassId($i).'">'.$o_dept->getClassName($i).'</option>');
									}
									?>
								</select>
	                     	</div> 
	                     	<?php 
	                     	$a_vcl=json_decode($o_table->getInfo());
						    for($i=0;$i<count($a_vcl);$i++)
						    {
						    	?>
						    	<div class="item">
		                     		<label><?php echo(rawurldecode($a_vcl[$i]))?>：</label>
		                     		<input name="Vcl_Info_<?php echo($i)?>" maxlength="50" type="text" style="width:100%" placeholder="选填" class="form-control" aria-describedby="basic-addon1" />
		                     	</div>
						    	<?php
						    }
							?>   	
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="appraise_manage_makeqrcode()">生成二维码</button>
							</div>
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">

</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>