<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120401);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
$o_table=new Survey($_GET['id']);
if($o_table->getTitle()==null || $o_table->getTitle()=='' || $o_table->getState()=='0')
{
	echo("<script>location='parent_survey_manage.php'</script>");
	exit(0);
}
$s_fun='ParentSurveyManageProgress';
$s_item='ClassNumber';
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
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading" style="position:static;">
                            <div class="caption" id="table_title" title="<?php echo($o_table->getTitle())?>" style="max-width:300px;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;"><?php echo($o_table->getTitle())?></div>
                            <div class="caption" id="status">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            <div class="row">
								  <div class="col-lg-6">
								    <div class="input-group" style="width:200px;" >
								      <input id="Vcl_KeyParentSurveyManageProgress" type="text" class="form-control" placeholder="幼儿姓名/证件号" value="<?php echo($s_otherkey)?>">
								      <span class="input-group-btn">
								        <button class="btn btn-primary" type="button" onclick="search_for_parent_survey_manage_progress()"><span  class="glyphicon glyphicon-search"></span></button>
								      </span>
								    </div>
								  </div>
								</div>
                            <button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;
                                margin-top: 0px; outline: medium none;margin-left:10px;" onclick="location='parent_survey_manage.php'">
                                <?php echo(Text::Key('Back'))?></button>
                                <button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none;margin-left:10px;" onclick="location='parent_survey_manage_question_modify.php?id=<?php echo($_GET['id'])?>'">
                                <span  class="glyphicon glyphicon-info-sign"></span>&nbsp;再次提醒</button>                             
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
parent_survey_manage_get_progress(<?php echo($s_key)?>)
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>