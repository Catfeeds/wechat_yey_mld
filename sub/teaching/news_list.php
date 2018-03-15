<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120503);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
$s_fun='NewsListTable';
$s_item='Id';
$s_page=1;
$s_sort='A';
$s_key=$_GET['id'];
if($_COOKIE [$s_fun.'Item'])
{
	$s_item=$_COOKIE [$s_fun.'Item'];
	$s_page=$_COOKIE [$s_fun.'Page'];
	$s_sort=$_COOKIE [$s_fun.'Sort'];
	$s_otherkey=$_COOKIE [$s_fun.$s_key.'OtherKey']; //因为Key当参数用了，所以就不要获取了
}
$o_table=new Teaching_News($s_key);
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption"><?php echo($o_table->getTitle());?>——新闻列表</div>
                            <button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;
                                margin-top: 0px; outline: medium none;margin-left:10px;" onclick="location='news.php'">
                                <?php echo(Text::Key('Back'))?></button>
                            <?php 
                            if ($o_table->getState()==0)
                            {
                            	?>
                            	<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none;margin-left:10px;" onclick="location='news_list_modify.php?news_id=<?php echo($o_table->getId())?>'">
                                <span  class="glyphicon glyphicon-plus"></span>&nbsp;添加新闻</button>
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
					table_sort('<?php echo($s_fun)?>','<?php echo($s_item)?>','<?php echo($s_sort)?>',<?php echo($s_page)?>,'<?php echo($s_key)?>','<?php echo($s_otherkey)?>')
					</script>
		
<script>
var table='<?php echo($s_fun)?>';
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>