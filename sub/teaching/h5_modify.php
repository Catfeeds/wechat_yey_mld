<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120502);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
//获取子模块菜单
ExportMainTitle(MODULEID,$O_Session->getUid());
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                            <?php
                            $s_funname='H5Add'; 
                            if($_GET[id]>0)
                            {
                            	$o_table=new Teaching_H5($_GET['id']);
                            	$s_funname='H5Modify'; 
                            	echo('修改');
								if($o_table->getTitle()==null || $o_table->getTitle()=='' || $o_table->getState()==1)
								{
									echo("<script>location='h5.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('新建');
                            }
                            ?>
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame" enctype="multipart/form-data">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="<?php echo($s_funname)?>"/>
						<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
						<textarea id="Vcl_Comment" name="Vcl_Comment" cols="1" rows="1" style="width: 1px; height: 1px; visibility: hidden"></textarea>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label><span class="must">*</span> 标题：</label>
	                     		<input name="Vcl_Title" maxlength="50" id="Vcl_Title" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>                 	
	                     	<div class="item">
	                     		<label><span class="must">*</span> H5页面地址：</label>
	                     		<input name="Vcl_Video" maxlength="255" id="Vcl_Video" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="h5_add_submit()">暂存</button>
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
$('#Vcl_Video').val('<?php echo($o_table->getVideo())?>');
<?php 
}
?>
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>