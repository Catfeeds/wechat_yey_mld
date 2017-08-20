<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120303);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='NoticeCenterTeachcerTargetList';
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
}
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>

                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading" style="overflow:inherit;height:43px;">
                            <div class="caption">教职工列表</div> 
                            <div class="row">
							  <div class="col-lg-6">
							    <div class="input-group">
							      <input id="Vcl_KeyUser" type="text" class="form-control" placeholder="搜索姓名" value="<?php echo($s_key)?>">
							      <span class="input-group-btn">
							        <button class="btn btn-primary" type="button" onclick="search_for_user()"><span  class="glyphicon glyphicon-search"></span></button>
							      </span>
							    </div>
							  </div>
							</div>                            
								<button id="user_add_btn" type="button" title="按角色群发通知" class="btn btn-success" aria-hidden="true" style="float: right;margin-left:10px;outline: medium none" data-placement="left" data-toggle="tooltip" onclick="location='teacher_send_notice_multiple_by_role.php'">
                                <span class="glyphicon fa fa-send"></span>&nbsp;按角色群发</button>
                                <button id="user_add_btn" type="button" title="按部门群发通知" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" data-toggle="tooltip" onclick="location='teacher_send_notice_multiple_by_dept.php'">
                                <span class="glyphicon fa fa-send"></span>&nbsp;按部门群发</button>						 
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

</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>