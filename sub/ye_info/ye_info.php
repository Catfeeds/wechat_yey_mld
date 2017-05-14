<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120201);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='YeInfo';
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
	$s_otherkey=$_COOKIE [$s_fun.$s_key.'OtherKey']; //因为Key当参数用了，所以就不要获取了
}
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>

                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption">在园幼儿信息列表</div>                            
                            <div class="row">
								  <div class="col-lg-6">
								    <div class="input-group" style="width:300px;" >
								      <input id="Vcl_KeyYeInfo" type="text" class="form-control" placeholder="幼儿姓名/证件号" value="">
								      <span class="input-group-btn">
								        <button class="btn btn-primary" type="button" onclick="search_for_yeinfo()"><span  class="glyphicon glyphicon-search"></span></button>
								      </span>
								    </div>
								  </div>
								</div>
						</div>
						<div class="table_nav">
							<div class="<?php if($s_key=='')echo('on')?>" onclick="table_sort('<?php echo($s_fun)?>','Name','A',1,'','')">
								全部幼儿
							</div>
							<?php 
							 $o_table = new Student_Class();
							 $o_table->PushOrder ( array ('Grade','A') );
							 $o_table->PushOrder ( array ('ClassId','A') );
							 for($i=0;$i<$o_table->getAllCount();$i++)
							 {
							 	$s_class='';
							 	if ($s_key==$o_table->getClassId($i))
							 	{
							 		$s_class='on';
							 	}
							 	$s_grade_name='';
							 	//区分年级
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
							 	?>
							 	<div class="<?php echo($s_class)?>" onclick="table_sort('<?php echo($s_fun)?>','Name','A',1,'<?php echo($o_table->getClassId($i))?>','')">
							 	<?php echo($s_grade_name.'('.$o_table->getClassName($i).')');?>
							 	</div>
							 	<?php
							 }
							?>
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
					table_sort('<?php echo($s_fun)?>','<?php echo($s_item)?>','<?php echo($s_sort)?>',<?php echo($s_page)?>,'<?php echo($s_key)?>','')
					</script>
		
<script>
//clear_cookie('YeInfoList');//清除cookie为了让每次点击进去都显示新的，而不是待缓存的。
var table='<?php echo($s_fun)?>';
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>