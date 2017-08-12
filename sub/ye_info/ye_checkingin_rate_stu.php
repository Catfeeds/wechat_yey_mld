<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120209);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='YeCheckinginRateStuTable';
$s_item='Name';
$s_page=1;
$s_sort='A';
$o_date = new DateTime ( 'Asia/Chongqing' );
$s_key=$_GET['studentid'];
$s_otherkey=$_GET['date'];
if($_COOKIE [$s_fun.'Item'])
{
	$s_item=$_COOKIE [$s_fun.'Item'];
	$s_page=$_COOKIE [$s_fun.'Page'];
	$s_sort=$_COOKIE [$s_fun.'Sort'];
}
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption">幼儿缺勤天数统计</div>
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
					echo("table_sort('".$s_fun."','".$s_item."','".$s_sort."','".$s_page."','".$s_key."','".$s_otherkey."')");
					?>
					</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>