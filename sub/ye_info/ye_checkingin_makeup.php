<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120208); 
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
require_once RELATIVITY_PATH . 'sub/ye_info/include/db_table.class.php';
$o_base=new Bn_Basic();
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                         考勤补录
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="YeCheckinginMakeup"/>
						<input type="hidden" name="Vcl_Date" value="<?php echo($_GET['date'])?>"/>
						<input type="hidden" name="Vcl_ClassId" value="<?php echo($_GET['classid'])?>"/>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label><span class="must">*</span> 补录日期：</label>
	                     		<input style="width:100%" class="form-control" size="16" value="<?php echo($_GET['date'])?>" type="text" disabled="disabled">
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 补录班级：</label>
	                     		<input style="width:100%" class="form-control" size="16" value="<?php 
	                     		$o_class=new Student_Class($_GET['classid']);
	                     		if($o_class->getClassName()==null || $o_class->getClassName()=='')
	                     		{
	                     			echo("<script>location='ye_checkingin.php'</script>");
	                     			exit(0);
	                     		}
	                     		echo($o_class->getClassName())?>" type="text" disabled="disabled">
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 选择出勤幼儿：</label>
        						<div style="overflow:hidden">
	                     			<div class="main_role"> 
	                     		<?php 
        							//检查是否已经存在考勤信息
	                     			$o_checkingin=new Student_Onboard_Checkingin_Class_View();
	                     			$o_checkingin->PushWhere ( array ('&&', 'Date', '=', $_GET['date']) );
	                     			$o_checkingin->PushWhere ( array ('&&', 'ClassId', '=', $_GET['classid']) );
	                     			if ($o_checkingin->getAllCount()>0)
	                     			{
	                     				echo("<script>location='ye_checkingin.php'</script>");
	                     				exit(0);
	                     			}
	                     			$o_student=new Student_Onboard_Info();
	                     			$o_student->PushWhere ( array ('&&', 'ClassNumber', '=', $_GET['classid']) );
	                     			$o_student->PushOrder ( array ('Name','W') );
	                     			for ($i=0;$i<$o_student->getAllCount();$i++)
        							{
        								echo('
												<div class="sub_role" style="float:left;margin-right:10px;">
													<input type="checkbox" checked="checked" name="Vcl_StudentId_'.$o_student->getStudentId($i).'"/>
						            				<label class="radio_text" style="width:60px;">'.$o_student->getName($i).'</label>
					            				</div>
												<input type="hidden" name="Vcl_Type_'.$o_student->getStudentId($i).'" value="事假"/>
					            				');
        							}
        							?>
        							</div>
	                     		</div>
	                     	</div>	  	
							<div class="item">
							<button id="" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='ye_checkingin.php'"><?php echo(Text::Key('Back'))?></button>
							<button id="btn_submit" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none;margin-left:10px" data-placement="left" onclick="ye_checkingin_makeup_submit()"><span class="glyphicon glyphicon-ok"></span> 提交</button>
							</div>
                     	</div>
                     </form>
<link rel="stylesheet" type="text/css" href="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/css/bootstrap-datetimepicker.css"/>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/locales/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"></script>
<script src="js/control.fun.js" type="text/javascript"></script>
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
$(function(){});
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>