<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120108);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';

ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
$o_admission_setup=new Admission_Setup(1);
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 
                        	招生设置
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="AdmissionSetup"/>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label><span class="must">*</span> 采集系统幼儿园编号：</label>
	                     		<input name="Vcl_DeptId" maxlength="20" id="Vcl_DeptId" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 托班招生人数：</label>
	                     		<input name="Vcl_TuoSum" maxlength="20" id="Vcl_TuoSum" type="text" style="width:100%" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="必填" class="form-control"/>
	                     	</div>  
	                     	<div class="item">
	                     		<label><span class="must">*</span> 小班招生人数：</label>
	                     		<input name="Vcl_XiaoSum" maxlength="20" id="Vcl_XiaoSum" type="text" style="width:100%" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="必填" class="form-control"/>
	                     	</div>  
	                     	<div class="item">
	                     		<label><span class="must">*</span> 中班招生人数：</label>
	                     		<input name="Vcl_ZhongSum" maxlength="20" id="Vcl_ZhongSum" type="text" style="width:100%" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="必填" class="form-control"/>
	                     	</div>  
	                     	<div class="item">
	                     		<label><span class="must">*</span> 大班招生人数：</label>
	                     		<input name="Vcl_DaSum" maxlength="20" id="Vcl_DaSum" type="text" style="width:100%" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="必填" class="form-control"/>
	                     	</div>  
	                     	<div class="item">
	                     		<label><span class="must">*</span> 半日班招生人数：</label>
	                     		<input name="Vcl_BanriSum" maxlength="20" id="Vcl_BanriSum" type="text" style="width:100%" onkeyup="value=value.replace(/[^0-9]/g,'')" placeholder="必填" class="form-control"/>
	                     	</div>  
	                     	<div class="item">
	                     		<label><span class="must">*</span> 开始报名日期：</label>
		                     		<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    					<input class="form-control" size="16" type="text" id="Vcl_SignupStart" name="Vcl_SignupStart" readonly style="background-color:white">
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                					</div>
	                     	</div> 
	                     	<div class="item">
	                     		<label><span class="must">*</span> 报名截至日期：</label>
		                     		<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    					<input class="form-control" size="16" type="text" id="Vcl_SignupEnd" name="Vcl_SignupEnd" readonly style="background-color:white">
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                					</div>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 信息核验日期：</label>
		                     	<input name="Vcl_AuditDate" maxlength="20" id="Vcl_AuditDate" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 信息核验时段：</label>
	                     		<input name="Vcl_AuditTime" maxlength="20" id="Vcl_AuditTime" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div> 
	                     	<div class="item">
	                     		<label><span class="must">*</span> 信息核验地点：</label>
	                     		<input name="Vcl_AuditAddress" maxlength="20" id="Vcl_AuditAddress" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 幼儿见面日期：</label>
		                     	<input name="Vcl_MeetDate" maxlength="20" id="Vcl_MeetDate" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 幼儿见面时段：</label>
	                     		<input name="Vcl_MeetTime" maxlength="20" id="Vcl_MeetTime" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div> 
	                     	<div class="item">
	                     		<label><span class="must">*</span> 幼儿见面地点：</label>
	                     		<input name="Vcl_MeetAddress" maxlength="20" id="Vcl_MeetAddress" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>  
	                     	<div class="item">
	                     		<label><span class="must">*</span> 体检时间：</label>
	                     		<input name="Vcl_HealthTime" maxlength="20" id="Vcl_HealthTime" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div> 
	                     	<div class="item">
	                     		<label><span class="must">*</span> 体检地点：</label>
	                     		<input name="Vcl_HealthAddress" maxlength="20" id="Vcl_HealthAddress" type="text" style="width:100%" placeholder="必填" class="form-control"/>
	                     	</div>   
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="setup_modify()"><?php echo(Text::Key('Save'))?></button>
							</div>                   	
                     	</div>
                     	 
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/css/bootstrap-datetimepicker.css"/>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/locales/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"></script>
<script type="text/javascript">
$('#Vcl_DeptId').val('<?php echo($o_admission_setup->getDeptId())?>');
$('#Vcl_TuoSum').val('<?php echo($o_admission_setup->getTuoSum())?>');
$('#Vcl_XiaoSum').val('<?php echo($o_admission_setup->getXiaoSum())?>');
$('#Vcl_ZhongSum').val('<?php echo($o_admission_setup->getZhongSum())?>');
$('#Vcl_DaSum').val('<?php echo($o_admission_setup->getDaSum())?>');
$('#Vcl_BanriSum').val('<?php echo($o_admission_setup->getBanriSum())?>');
$('#Vcl_SignupStart').val('<?php echo($o_admission_setup->getSignupStart())?>');
$('#Vcl_SignupEnd').val('<?php echo($o_admission_setup->getSignupEnd())?>');
$('#Vcl_AuditDate').val('<?php echo($o_admission_setup->getAuditDate())?>');
$('#Vcl_AuditTime').val('<?php echo($o_admission_setup->getAuditTime())?>');
$('#Vcl_AuditAddress').val('<?php echo($o_admission_setup->getAuditAddress())?>');
$('#Vcl_MeetDate').val('<?php echo($o_admission_setup->getMeetDate())?>');
$('#Vcl_MeetTime').val('<?php echo($o_admission_setup->getMeetTime())?>');
$('#Vcl_MeetAddress').val('<?php echo($o_admission_setup->getMeetAddress())?>');
$('#Vcl_HealthTime').val('<?php echo($o_admission_setup->getHealthTime())?>');
$('#Vcl_HealthAddress').val('<?php echo($o_admission_setup->getHealthAddress())?>');
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