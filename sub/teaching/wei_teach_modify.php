<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120501);
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
                            $s_funname='WeiTeachAdd'; 
                            if($_GET[id]>0)
                            {
                            	$o_table=new Teaching_Wei_Teach($_GET['id']);
                            	$s_funname='WeiTeachModify'; 
                            	echo('修改微教学');
								if($o_table->getTitle()==null || $o_table->getTitle()=='' || $o_table->getState()==1)
								{
									echo("<script>location='wei_teach.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('修改微教学');
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
	                     	<?php 
	                     	if($_GET['id']>0)
	                     	{
	                     		?>
	                     	<div class="item">
	                     		<label>当前缩略图：</label>
	                     		<div style="width:100%">
	                     		<img style="width:414px;height:230px;border: 0px" src="<?php echo($o_dept->getPicUrl())?>" alt="" />
	                     		</div>
	                     	</div>
	                     	<div class="item">
	                     		<label> 修改缩略图：</label><br/>
	                     		<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
	                     		<fieldset disabled>
                    					<input class="form-control" placeholder="图片建议尺寸：1M以内，正方形，宽度不要大于400像素" size="16" type="text" id="Vcl_Upload" readonly="readonly"/>
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
                    					<input class="form-control" placeholder="图片建议尺寸：1M以内，正方形，宽度不要大于400像素" size="16" type="text" id="Vcl_Upload" readonly="readonly"/>
                    					</fieldset>
										<span class="input-group-addon" style="cursor:pointer;" onclick="$('#Vcl_File').click()"><span class="glyphicon glyphicon-folder-open"></span></span>
                					</div>
                					<input id="Vcl_File" name="Vcl_File" type="file" accept=".png,.jpg" style="display:none" onchange="$('#Vcl_Upload').val($('#Vcl_File').val())"/>
	                     	</div>
	                     		<?php
	                     	}
	                     	?>	                     	
	                     	<div class="item">
	                     		<label><span class="must">*</span> 视频地址：</label>
	                     		<input name="Vcl_Video" maxlength="255" id="Vcl_Video" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>
	                     	<div class="item">
	                     		<label>如何获取视频地址？</label>
	                     		在浏览器中，打开您的腾讯视频，点击左下方的分享按钮，将“通用代码”复制到文本框中即可，如下图：<br/>
	                     		<img style="border: 1px solid #ccc;margin-top:5px;" src="images/copy_video_url.jpg">
	                     	</div>
	                     	<div class="item">
	                     	<style>
	                     	#edui1,#edui1_iframeholder{
							width:100% !important;
	                     	}
	                     	</style>
	                     		<label><span class="must">*</span> 微教学内容简述：</label>
	                     		<script id="editor" type="text/plain"><?php 
	                     		if($_GET[id]>0)
	                     		{
	                     			echo(rawurldecode($o_table->getComment()));
	                     		}
	                     		?></script>
	                     	</div>
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="send_notice_multiple()">暂存</button>
							</div>                   	
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo(RELATIVITY_PATH)?>sub/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo(RELATIVITY_PATH)?>sub/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo(RELATIVITY_PATH)?>sub/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
var ue = UE.getEditor('editor',{toolbars:[
                                          [ 'bold', 'italic', 'underline', 'strikethrough', 'removeformat', '|', 'forecolor','insertunorderedlist', '|',
                                           'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify']
                                   ],iframeCssUrl: 'css/ueditor.css'});
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