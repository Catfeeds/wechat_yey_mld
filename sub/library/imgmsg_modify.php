<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 100702);
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
                            $s_funname='ImgmsgAdd'; 
                            if($_GET[id]>0)
                            {
                            	$o_dept=new WX_Library($_GET['id']);
                            	$s_funname='ImgmsgModify'; 
                            	echo('修改图文消息');
								if($o_dept->getTitle()==null || $o_dept->getTitle()=='')
								{
									echo("<script>location='ingmsg_list.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('添加图文消息');
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
                    	<div class="sss_form">
                    		<div class="item">
	                     		<label><span class="must">*</span> 标题：</label>
	                     		<input name="Vcl_Title" maxlength="50" id="Vcl_Title" type="text" style="width:100%" class="form-control"/>
	                     	</div>	
	                     	<?php 
	                     	if($_GET['id']>0)
	                     	{
	                     		?>
	                     	<div class="item">
	                     		<label>当前封面：</label>
	                     		<div style="width:100%">
	                     		<img style="width:414px;height:230px;border: 0px" src="<?php echo($o_dept->getPicUrl())?>" alt="" />
	                     		</div>
	                     	</div>
	                     	<div class="item">
	                     		<label> 修改封面：</label><br/>
	                     		<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
	                     		<fieldset disabled>
                    					<input class="form-control" placeholder="大图片建议尺寸：2M以内，900像素 * 500像素" size="16" type="text" id="Vcl_Upload" readonly="readonly"/>
                    					</fieldset>
										<span class="input-group-addon" style="cursor:pointer;" onclick="$('#Vcl_File').click()"><span class="glyphicon glyphicon-folder-open"></span></span>
                					</div>
                					<input id="Vcl_File" name="Vcl_File" type="file" accept=".png,.jpg" style="display:none" onchange="$('#Vcl_Upload').val($('#Vcl_File').val())"/>
	                     	</div>
	                     		<?php
	                     	}else{
	                     		?>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 封面：</label><br/>
	                     		<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
	                     		<fieldset disabled>
                    					<input class="form-control" placeholder="大图片建议尺寸：2M以内，900像素 * 500像素" size="16" type="text" id="Vcl_Upload" readonly="readonly"/>
                    					</fieldset>
										<span class="input-group-addon" style="cursor:pointer;" onclick="$('#Vcl_File').click()"><span class="glyphicon glyphicon-folder-open"></span></span>
                					</div>
                					<input id="Vcl_File" name="Vcl_File" type="file" accept=".png,.jpg" style="display:none" onchange="$('#Vcl_Upload').val($('#Vcl_File').val())"/>
	                     	</div>
	                     		<?php
	                     	}
	                     	?>
	                     	<div class="item">
	                     		<label>摘要：</label>
	                     		<textarea class="form-control" rows="9" name="Vcl_Description" id="Vcl_Description" style="width:100%"><?php 
									if($_GET['id']>0)
									{
										echo($o_dept->getDescription());
									}
								?></textarea>
	                     	</div>	  
	                     	<div class="item">
	                     		<label><span class="must">*</span> 跳转链接：</label>
	                     		<input name="Vcl_MessageUrl" placeholder="http 或者 https 开头的连接" maxlength="255" id="Vcl_MessageUrl" type="text" style="width:100%" class="form-control"/>
	                     	</div>	               	
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="imgmsg_modify()"><?php echo(Text::Key('Submit'))?></button>
							</div>
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
		<?php 
		if($_GET['id']>0)
		{
		?>
		$('#Vcl_Title').val('<?php echo($o_dept->getTitle())?>');
		$('#Vcl_MessageUrl').val('<?php echo($o_dept->getMessageUrl())?>');
		<?php 
		}
		?>
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>