<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120307);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/notice_center/include/db_table.class.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单

?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                            <?php
                            $s_funname='NoticeTypeAdd'; 
                            if($_GET[id]>0)
                            {
                            	$o_dept=new Notice_Center_Type($_GET['id']);
                            	$s_funname='NoticeTypeModify'; 
                            	echo('修改通知类型');
								if($o_dept->getName()==null || $o_dept->getName()=='')
								{
									echo("<script>location='notice_type.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('添加通知类型');
                            }
                            ?>
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="<?php echo($s_funname)?>"/>
						<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label><span class="must">*</span> 通知对象：</label>
	                     		<select name="Vcl_Type" id="Vcl_Type" class="selectpicker" data-style="btn-default">
	                     			<option value="幼儿家长">幼儿家长</option>
        							<option value="教职工">教职工</option>
   								</select>
	                     	</div>	
	                     	<div class="item">
	                     		<label><span class="must">*</span> 显示顺序：</label>
	                     		<input name="Vcl_Number" maxlength="20" id="Vcl_Number" type="text" style="width:100%" class="form-control"/>
	                     	</div>	
	                     	<div class="item">
	                     		<label><span class="must">*</span> 类型名称：</label>
	                     		<input name="Vcl_Name" maxlength="20" id="Vcl_Name" type="text" style="width:100%" class="form-control"/>
	                     	</div>	                     	
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="notice_type_modify()"><?php echo(Text::Key('Submit'))?></button>
							</div>
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
<?php 
if($_GET['id']>0)
{
?>
$('#Vcl_Name').val('<?php echo($o_dept->getName())?>');
$('#Vcl_Number').val('<?php echo($o_dept->getNumber())?>');
$('#Vcl_Type').val('<?php echo($o_dept->getType())?>');
<?php 
}
?>
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>