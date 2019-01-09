<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120107);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='AdmissionTable';
$s_item='StudentId';
$s_page=1;
$s_sort='A';
$s_key='';
if($_COOKIE [$s_fun.'Item'])
{
	$s_item=$_COOKIE [$s_fun.'Item'];
	$s_page=$_COOKIE [$s_fun.'Page'];
	$s_sort=$_COOKIE [$s_fun.'Sort'];
	$s_key=$_COOKIE [$s_fun.'Key'];
}
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
					<form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" id="Vcl_FunName" name="Vcl_FunName" value="AssignClass"/>
						<input type="hidden" name="Vcl_StuId" id="Vcl_StuId"/>
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading" style="overflow: inherit; height: 43px;">
                            <div class="caption">已完善信息并录取列表</div>                            
                            	<div class="row">
								  <div class="col-lg-6">
								    <div class="input-group" style="width:300px;" >
								      <input id="Vcl_KeyAdmission" type="text" class="form-control" placeholder="幼儿编号/姓名/证件号" value="<?php echo($s_key)?>">
								      <span class="input-group-btn">
								        <button class="btn btn-primary" type="button" onclick="search_for_admission()"><span  class="glyphicon glyphicon-search"></span></button>
								      </span>
								    </div>
								  </div>
								</div>
								<button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;outline: medium none;margin-left:10px;" onclick="window.open('output_admission_all.php','_blank')">
                                <span  class="glyphicon glyphicon-floppy-save"></span>&nbsp;导出全部</button>
                                <div id="assign" style="width: 180px;float:right">
                            	<select id="Vcl_ClassId"  name="Vcl_ClassId" class="selectpicker" data-style="btn-default" onchange="select_submit_assign_class(this)">
									<option value="">选择分配的班级</option>
									<?php 
									$o_table = new Student_Class();
									$o_table->PushOrder ( array ('Grade', A ) );
									$o_table->PushOrder ( array ('ClassId','A') );
									for($i = 0; $i < $o_table->getAllCount(); $i ++) {
										$s_grade_name='';
										switch ($o_table->getGrade($i))
										{
											case 0:
												$s_grade_name='半日班';
													break;
											case 1:
												$s_grade_name='托班';
													break;
											case 2:
												$s_grade_name='小班';
												break;
											case 3:
												$s_grade_name='中班';
												break;
											case 4:
												$s_grade_name='大班';
												break;
										}
										$o_temp = new Student_Onboard_Info();
										$o_temp->PushWhere ( array ('&&', 'Sex', '=', '女') );
										$o_temp->PushWhere ( array ('&&', 'ClassNumber', '=', $o_table->getClassId($i) ) );
										$n_count_girl = $o_temp->getAllCount ();
										$o_temp = new Student_Onboard_Info();
										$o_temp->PushWhere ( array ('&&', 'Sex', '=', '男') );
										$o_temp->PushWhere ( array ('&&', 'ClassNumber', '=', $o_table->getClassId($i) ) );
										$n_count_boy = $o_temp->getAllCount ();
										echo('<option value="'.$o_table->getClassId($i).'">'.$s_grade_name.'-'.$o_table->getClassName($i).'(女:'.$n_count_girl.' 男:'.$n_count_boy.')</option>');
									}
									?>
								</select>
							</div>
                            </div>
                        <table class="table table-striped">
                            <thead>
                                <tr></tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>    
                    </form>                
                    <div class="sss_page"></div>
					<script src="js/control.fun.js" type="text/javascript"></script>
					<script>
					table_sort('<?php echo($s_fun)?>','<?php echo($s_item)?>','<?php echo($s_sort)?>',<?php echo($s_page)?>,'<?php echo($s_key)?>')
					</script>
		
<script>
var table='<?php echo($s_fun)?>';
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>