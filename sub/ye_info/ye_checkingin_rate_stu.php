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
$s_key=$_GET['id'];
$s_otherkey=$_GET['date'];
if ($s_key=='' || $s_otherkey=='')
{
    echo("<script>location='ye_checkingin_rate.php'</script>");
    exit(0);
}
if($_COOKIE [$s_fun.'Item'])
{
	$s_item=$_COOKIE [$s_fun.'Item'];
	$s_page=$_COOKIE [$s_fun.'Page'];
	$s_sort=$_COOKIE [$s_fun.'Sort'];
}
require_once RELATIVITY_PATH . 'sub/ye_info/include/db_table.class.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption"><?php echo($s_otherkey)?>&nbsp;<?php 
                            $o_class=new Student_Class($s_key);
                            if($o_class->getClassName()==null || $o_class->getClassName()=='')
							{
								echo("<script>location='ye_checkingin_rate.php'</script>");
								exit(0);
							}
                            echo($o_class->getClassName());
                            ?>&nbsp;幼儿缺勤天数统计
                            </div>
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
					echo("table_sort('".$s_fun."','".$s_item."','".$s_sort."','".$s_page."','".$s_key."','".$s_otherkey."')");
					?>
					</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>