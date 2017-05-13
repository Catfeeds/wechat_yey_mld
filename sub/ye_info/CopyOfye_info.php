<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120201);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='YeInfo';
$s_item='Grade';
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

                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption">所有班级列表</div>                            
                            <div class="row">
								  <div class="col-lg-6">
								    <div class="input-group" style="width:300px;" >
								      <input id="Vcl_KeyYe" type="text" class="form-control" placeholder="幼儿姓名/证件号" value="">
								      <span class="input-group-btn">
								        <button class="btn btn-primary" type="button" onclick="search_for_wait_audit()"><span  class="glyphicon glyphicon-search"></span></button>
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
					table_sort('<?php echo($s_fun)?>','<?php echo($s_item)?>','<?php echo($s_sort)?>',<?php echo($s_page)?>,'<?php echo($s_key)?>')
					</script>
		
<script>
clear_cookie('YeInfoList');//清除cookie为了让每次点击进去都显示新的，而不是待缓存的。
var table='<?php echo($s_fun)?>';
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>