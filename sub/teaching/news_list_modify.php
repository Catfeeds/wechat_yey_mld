<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120503);
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
                            $s_funname='NewsListAdd'; 
                            if($_GET[id]>0)
                            {
                            	$o_table=new Teaching_News_List($_GET['id']);
                            	$s_funname='NewsListModify'; 
                            	$o_news=new Teaching_News($o_table->getNewsId());
                            	echo('修改新闻');
                            	if($o_table->getComment()==null || $o_table->getComment()=='' || $o_news->getState()==1)
								{
									echo("<script>location='news_list.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('添加新闻');
                            }
                            ?>
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame" enctype="multipart/form-data">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="<?php echo($s_funname)?>"/>
						<input type="hidden" name="Vcl_NewsId" value="<?php echo($_GET['news_id'])?>"/>
						<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label><span class="must">*</span> 新闻摘要：</label>
	                     		<input name="Vcl_Comment" maxlength="255" id="Vcl_Comment" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>
	                     	<?php 
	                     	if($_GET['id']>0)
	                     	{
	                     		?>
	                     	<div class="item">
	                     		<label>当前缩略图：</label>
	                     		<div style="width:100%">
	                     		<img style="width:128px;height:128px;border: 0px" src="../../<?php echo($o_table->getIcon())?>" alt="" />
	                     		</div>
	                     	</div>
	                     	<div class="item">
	                     		<label> 修改缩略图：</label><br/>
	                     		<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
	                     		<fieldset disabled>
                    					<input class="form-control" placeholder="图片建议尺寸：1M以内，正方形，宽度不要大于200像素" size="16" type="text" id="Vcl_Upload" readonly="readonly"/>
                    					</fieldset>
										<span class="input-group-addon" style="cursor:pointer;" onclick="$('#Vcl_File').click()"><span class="glyphicon glyphicon-folder-open"></span></span>
                					</div>
                					<input id="Vcl_File" name="Vcl_File" type="file" accept=".png,.jpg" style="display:none" onchange="$('#Vcl_Upload').val($('#Vcl_File').val())"/>
	                     	</div>
	                     		<?php
	                     	}else{
	                     		?>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 缩略图：</label><br/>
	                     		<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
	                     		<fieldset disabled>
                    					<input class="form-control" placeholder="图片建议尺寸：1M以内，正方形，宽度不要大于200像素" size="16" type="text" id="Vcl_Upload" readonly="readonly"/>
                    					</fieldset>
										<span class="input-group-addon" style="cursor:pointer;" onclick="$('#Vcl_File').click()"><span class="glyphicon glyphicon-folder-open"></span></span>
                					</div>
                					<input id="Vcl_File" name="Vcl_File" type="file" accept=".png,.jpg" style="display:none" onchange="$('#Vcl_Upload').val($('#Vcl_File').val())"/>
	                     	</div>
	                     		<?php
	                     	}
	                     	?>	                	
	                     	<div class="item">
	                     		<label><span class="must">*</span> 新闻地址：</label>
	                     		<input name="Vcl_Link" maxlength="255" id="Vcl_Link" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>                    	
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="news_list_add_submit()">提交</button>
							</div>                   	
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
<?php 
if($_GET['id']>0)
{
?>
$('#Vcl_Comment').val('<?php echo($o_table->getComment())?>');
$('#Vcl_Link').val('<?php echo($o_table->getLink())?>');
<?php 
}
?>
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>