<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120602);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='RecipeTable';
$s_item='Recipename';
$s_page=1;
$s_sort='D';
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
                            <div class="caption">幼儿食谱</div>
                            <button id="user_add_btn" type="button" class="btn btn-success" style="float: right;
                                outline: medium none; margin-left:10px;" onclick="location='recipe_input.php'">
                                <span  class="glyphicon glyphicon-cloud-upload"></span>&nbsp;导入食谱</button></div>
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
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>