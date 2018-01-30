<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120604);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_fun='WorkflowTable';
$s_item='Date';
$s_page=1;
$s_sort='D';
$s_key='1';
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
                        <div class="panel-heading" style="overflow:inherit;height:43px;">
                            <div class="caption">工作流程列表</div>
                        </div>                            
						<div class="table_nav">
							<script type="text/javascript">
							//将班级列表压入js数组
							var a_class_list=[];
							</script>
							<?php 
							 $o_table = new Dailywork_Workflow_Main();
							 $o_table->PushOrder ( array ('Number','A') );
							 for($i=0;$i<$o_table->getAllCount();$i++)
							 {
							 	$s_class='';
							 	if ($s_key==$o_table->getId($i))
							 	{
							 		$s_class='on';
							 	}
							 	?>
							 	<script type="text/javascript">
							 	a_class_list.push(new Array("<?php echo($o_table->getId($i))?>","<?php echo($o_table->getTitle($i));?>"));
							 	</script>
							 	<div class="<?php echo($s_class)?>" onclick="change_table_nav('<?php echo($s_fun)?>','<?php echo($o_table->getId($i))?>')">
							 	<?php echo($o_table->getTitle($i));?>
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
function change_table_nav(fun,id)
{
	table_sort(fun,'Date','D',1,id,'');
	$('#Vcl_KeyWorkflow').val('');
}
var table='<?php echo($s_fun)?>';
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>