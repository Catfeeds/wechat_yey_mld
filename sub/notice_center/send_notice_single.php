<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120301);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
//获取子模块菜单
ExportMainTitle(MODULEID,$O_Session->getUid());

//获取刚刚发的通知
require_once RELATIVITY_PATH . 'sub/notice_center/include/db_table.class.php';
$o_table=new Notice_Center_Record();
$o_table->PushWhere ( array ('&&', 'Uid', '=',$O_Session->getUid()) );
$o_table->PushOrder ( array ('Id','D') );
$o_table->setStartLine ( 0 );
$o_table->setCountLine ( 1);
$o_table->getAllCount();
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        	<span  class="glyphicon fa fa-user"></span>&nbsp;单发通知
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_Target" value="<?php echo($_GET['id'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="SendNoticeSingle"/>
						<textarea id="Vcl_Comment" name="Vcl_Comment" cols="1" rows="1" style="width: 1px; height: 1px; visibility: hidden"></textarea>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label><span class="must">*</span> 标题：</label>
	                     		<input name="Vcl_First" maxlength="50" id="Vcl_First" type="text" style="width:100%" placeholder="必填" class="form-control" value="<?php echo($o_table->getFirst(0))?>"/>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 类型：</label>
	                     		<select id="Vcl_Type" name="Vcl_Type" class="selectpicker" data-style="btn-default" >
									<option value="">请选择</option>
									<option value="园所通知">园所通知</option>
									<option value="办公室通知">办公室通知</option>
									<option value="开园通知">开园通知</option>
									<option value="缴费通知">缴费通知</option>
									<option value="体检通知">体检通知</option>
									<option value="安全通知">安全通知</option>
									<option value="放假通知">放假通知</option>
									<option value="活动通知">活动通知</option>									
								</select>	                     		
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 内容：</label>
	                     		<textarea  name="Vcl_Remark" maxlength="80" id="Vcl_Remark" type="text" style="width:100%" placeholder="必填，不能超过80字" class="form-control" rows="5"/><?php echo($o_table->getRemark(0))?></textarea>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 发送对象：</label>
	                     		<input disabled="disabled" type="text" style="width: 100%" class="form-control" value="<?php 
	                     		$o_stu=new Student_Onboard_Info_Class_Wechat_View($_GET['id']);
	                     		echo($o_stu->getName().'（'.$o_stu->getClassName().'）');
	                     		?>"/>                     		
	                     	</div>
	                     	<div class="item">
	                     	<style>
	                     	#edui1,#edui1_iframeholder{
							width:100% !important;
	                     	}
	                     	</style>
	                     		<label>点击详情内容（注：如果不需要此功能，此处可为空。）：</label>
	                     		<script id="editor" type="text/plain"><?php echo(rawurldecode($o_table->getComment(0)))?></script>
	                     	</div>
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="send_notice_single()"><span class="glyphicon fa fa-send"></span>&nbsp;发送</button>
							</div>                   	
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo(RELATIVITY_PATH)?>sub/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo(RELATIVITY_PATH)?>sub/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo(RELATIVITY_PATH)?>sub/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
var ue = UE.getEditor('editor',{toolbars:[
                                          [ 'bold', 'italic', 'underline', 'strikethrough', 'removeformat','forecolor',
                                            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify']
                                   ],iframeCssUrl: 'css/ueditor.css'});
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>