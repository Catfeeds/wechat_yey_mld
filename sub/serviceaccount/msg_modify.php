<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 100701);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';

ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                            <?php
                            $s_funname='MsgAdd'; 
                            if($_GET[id]>0)
                            {
                            	$o_dept=new WX_Library($_GET['id']);
                            	$s_funname='MsgModify'; 
                            	echo('修改文字消息');
								if($o_dept->getContent()==null || $o_dept->getContent()=='')
								{
									echo("<script>location='msg_list.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('添加文字消息');
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
	                     		<label><span class="must">*</span> 文字消息内容：</label>
	                     		<textarea class="form-control" rows="9" name="Vcl_Content" id="Vcl_Content" style="width:100%"><?php 
									if($_GET['id']>0)
									{
										echo($o_dept->getContent());
									}
								?></textarea>
	                     	</div>	                 	
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="msg_modify()"><?php echo(Text::Key('Submit'))?></button>
							</div>
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>