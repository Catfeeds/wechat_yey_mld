<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120601);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
//获取子模块菜单
ExportMainTitle(MODULEID,$O_Session->getUid());
?>

					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        	<span  class="glyphicon fa fa-rmb"></span>&nbsp;发布工资
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame" enctype="multipart/form-data">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="PayrollRelease"/>
						<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label>工资条模版下载：</label><a style="color:#3498DB" href="payroll_template.php" target="_blank">工资条模版.xlsx</a>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 工资日期：</label>
		                     		<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    					<input class="form-control" size="16" type="text" id="Vcl_Date" name="Vcl_Date" readonly style="background-color:white">
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                					</div>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 上传工资条：</label>
	                     		<div class="input-group col-md-5" data-date="" data-link-field="dtp_input2">
	                     		<fieldset disabled>
                    					<input class="form-control" placeholder="请上传.xlsx文件" size="16" type="text" id="Vcl_Upload" readonly="readonly"/>
                    					</fieldset>
										<span class="input-group-addon" style="cursor:pointer;" onclick="$('#Vcl_File').click()"><span class="glyphicon glyphicon-folder-open"></span></span>
                					</div>
                					<input id="Vcl_File" name="Vcl_File" type="file" accept=".xlsx" style="display:none" onchange="$('#Vcl_Upload').val($('#Vcl_File').val())"/>
	                     	</div>	                     	                     	
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="payroll_release()">发布</button>
							</div>                   	
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/css/bootstrap-datetimepicker.css"/>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/locales/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"></script>

<script type="text/javascript">
$('.form_date').datetimepicker({
    language:  'zh-CN',
    weekStart: 1,
    todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 0
});
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>