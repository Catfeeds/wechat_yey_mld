<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120109);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 
                        	见面时段设置
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="AdmissionSetupMeetTime"/>
                    	<div class="sss_form">
                    	<?php 
                    		$o_table=new Admission_Time();
                    		$o_table->PushOrder ( array ('Id', 'A' ) );
                    		for($i=0;$i<$o_table->getAllCount();$i++)
                    		{
                    			?>
	                    	<div class="item">
		                    	<div class="input-group">
		                    		<span class="input-group-addon" id="basic-addon1"><?php echo(($i+1))?></span>
								  <span class="input-group-addon" id="basic-addon1" style="border-right:0px;">时段</span>
								  <input name="Vcl_Time_<?php echo($o_table->getId($i))?>" type="text" class="form-control" value="<?php echo($o_table->getTime($i))?>" placeholder="例如：08:30-09:00" aria-describedby="basic-addon1">
								  <span class="input-group-addon" id="basic-addon1" style="border-left:0px;border-right:0px;">见面人数上限</span>
								  <input name="Vcl_Sum_<?php echo($o_table->getId($i))?>" type="text" class="form-control" value="<?php echo($o_table->getSum($i))?>" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="数字" aria-describedby="basic-addon1">
								</div>
							</div>
                    			<?php
                    		}
                    	?>
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="setup_modify()"><?php echo(Text::Key('Save'))?></button>
							</div>                   	
                     	</div>
                     	 
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>