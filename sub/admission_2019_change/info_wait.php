<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120106);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='InfoWaitTable';
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
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption">等待完善信息列表</div>
                            <div class="row">
								  <div class="col-lg-6">
								    <div class="input-group" style="width:300px;" >
								      <input id="Vcl_KeyInfoWait" type="text" class="form-control" placeholder="幼儿编号/姓名/证件号" value="<?php echo($s_key)?>">
								      <span class="input-group-btn">
								        <button class="btn btn-primary" type="button" onclick="search_for_info_wait()"><span  class="glyphicon glyphicon-search"></span></button>
								      </span>
								    </div>
								  </div>
								</div>
								<button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;outline: medium none;margin-left:10px;" onclick="window.open('output_all.php?state=5','_blank')">
                                <span  class="glyphicon glyphicon-floppy-save"></span>&nbsp;导出全部</button>
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
var table='<?php echo($s_fun)?>';
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>