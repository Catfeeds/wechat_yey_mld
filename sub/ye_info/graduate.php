<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120205);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='YeGraduateTable';
$s_item='Name';
$s_page=1;
$s_sort='A';
$s_key='';
if($_COOKIE [$s_fun.'Item'])
{
	$s_item=$_COOKIE [$s_fun.'Item'];
	$s_page=$_COOKIE [$s_fun.'Page'];
	$s_sort=$_COOKIE [$s_fun.'Sort'];
	$s_key=$_COOKIE [$s_fun.'Key'];
	$s_otherkey=$_COOKIE [$s_fun.$s_key.'OtherKey'];
}
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>

                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading" style="overflow: inherit; height: 43px;">
							<div style="width: 150px;float: left;"><select id="Vcl_Year" class="selectpicker"
								data-style="btn-default" onchange="table_sort('<?php echo($s_fun)?>','Name','A',1,this.value,'');">
								<?php 
								//获取年列表
								$a_list=array();
								for($i = 2030; $i > 2010; $i--) {
									$o_table = new Student_Graduate_Info();
									$o_table->PushWhere ( array ('&&', 'GradeNumber', '=', $i));
									$o_table->setCountLine ( 1 );
									if ($o_table->getAllCount () > 0) {
										array_push($a_list, $i);
										echo('<option value="'.$i.'">'.$i.' 年毕业</option>');
									}
								}
								?>
							</select></div>
								<div class="row">
								  <div class="col-lg-6">
								    <div class="input-group" style="width:300px;" >
								      <input id="Vcl_KeyYeGraduate" type="text" class="form-control" placeholder="幼儿姓名/证件号/园班级名称" value="">
								      <span class="input-group-btn">
								        <button class="btn btn-primary" type="button" onclick="search_for_yegraduate()"><span  class="glyphicon glyphicon-search"></span></button>
								      </span>
								    </div>
								  </div>
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
                    <div class="sss_page"></div>
					<script src="js/control.fun.js" type="text/javascript"></script>
					<script>
					<?php 
					$s_key=$a_list[0];
					echo("table_sort('".$s_fun."','".$s_item."','".$s_sort."','".$s_page."','".$s_key."','')");
					?>
					</script>
		
<script>

</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>