<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 100504);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='UserListSignup';
$s_item='StudentId';
$s_page=1;
$s_sort='A';
if($_COOKIE [$s_fun.'Item'])
{
	$s_item=$_COOKIE [$s_fun.'Item'];
	$s_page=$_COOKIE [$s_fun.'Page'];
	$s_sort=$_COOKIE [$s_fun.'Sort'];
	$s_key=$_COOKIE [$s_fun.'Key']; //因为Key当参数用了，所以就不要获取了
}
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption" id="table_title">报名家长微信列表</div>
                            <div class="row">
							  <div class="col-lg-6">
							    <div class="input-group">
							      <input id="Vcl_KeyUserSignup" type="text" class="form-control" placeholder="微信昵称/幼儿姓名/证件号" value="<?php echo($s_key)?>">
							      <span class="input-group-btn">
							        <button class="btn btn-primary" type="button" onclick="search_for_user_signup()"><span  class="glyphicon glyphicon-search"></span></button>
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
var table='<?php echo($s_fun)?>';
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>