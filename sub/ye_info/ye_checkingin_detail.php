<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120208);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='YeCheckinginDetailTable';
$s_item='Name';
$s_page=1;
$s_sort='A';
$s_key=$_GET['id'];
if ($s_key=='')
{
	echo("<script>location='ye_checkingin.php'</script>");
    exit(0);
}
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
							<div class="caption">缺勤详情</div> 
							<button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;
                                margin-top: 0px; outline: medium none;margin-left:10px;" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'">
                                <?php echo(Text::Key('Back'))?></button>
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
					echo("table_sort('".$s_fun."','".$s_item."','".$s_sort."','".$s_page."','".$s_key."','')");
					?>
					</script>

<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>