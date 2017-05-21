<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120201);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';

ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单

?>
<style>
<!--
.sss_form div.item {
	width:23%;
	float:left;
	margin-left:1%;
	margin-right:1%;
	height:55px;
}
.sss_form
{
	overflow:hidden;
}
.sss_main
{
	padding-bottom: 0px;
}
-->
</style>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                            <?php
                            $s_funname='StuAdd'; 
                            if($_GET[id]>0)
                            {
                            	$o_table=new Student_Class($_GET['id']);
                            	$s_funname='StuModify'; 
                            	echo('修改幼儿信息');
								if($o_table->getName()==null || $o_table->getName()=='')
								{
									echo("<script>location='ye_info.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('添加幼儿信息');
                            }
                            ?>
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form_checkid" method="post" target="submit_form_frame">
				        <input type="hidden" name="Vcl_FunName" value="CheckId"/>
				        <input type="hidden" name="Vcl_CheckId" id="Vcl_CheckId" value=""/>
			        </form>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="<?php echo($s_funname)?>"/>
						<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
                    	<div class="sss_form">
                    		<?php 
                    		require_once 'ye_form.php';
                    		?>               	     	
							<div class="item" style="width:98%;margin-bottom:0px;">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="stu_modify(false)"><?php echo(Text::Key('Submit'))?></button>
							</div>
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script src="js/data.code.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/css/bootstrap-datetimepicker.css"/>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/locales/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"></script>
<script type="text/javascript">
<?php 
if($_GET['id']>0)
{
?>
$('#Vcl_Grade').val('<?php echo($o_table->getGrade())?>');
$('#Vcl_ClassName').val('<?php echo($o_table->getClassName())?>');
<?php 
}
?>
$('.form_date').datetimepicker({
    language:  'zh-CN',
    weekStart: 1,
    todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 0
});
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>