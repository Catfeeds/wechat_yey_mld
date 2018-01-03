<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120402);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
//获取子模块菜单
ExportMainTitle(MODULEID,$O_Session->getUid());

//获取刚刚发的通知
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
$o_table=new Survey_Teacher($_GET['id']);
if($o_table->getState()!='0')
{
	//如果已经不是未发布，那么返回
	echo("<script>location='teacher_survey_manage.php'</script>");
	exit(0);
}
?>
<style>
.sub_role {
	padding-left:30px;
}
.radio_text
{

}
.sub_role .radio_text{
	font-size:12px;
}
.main_role{
	padding-right:25px;
}
</style>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        	<span  class="glyphicon fa fa-users"></span>&nbsp;发布问卷
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="TeacherSurveyManageRelease"/>
						<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label><span class="must">*</span> 微信提醒标题：</label>
	                     		<input name="Vcl_First" maxlength="50" id="Vcl_First" type="text" style="width:100%" placeholder="必填" class="form-control" value=""/>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 微信提醒内容：</label>
	                     		<textarea  name="Vcl_Remark" maxlength="80" id="Vcl_Remark" type="text" style="width:100%" placeholder="必填，不能超过80字" class="form-control" rows="5"/></textarea>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 问卷对象：</label>
	                     		<div style="overflow:hidden">
	                     			<div class="main_role">
										<input type="checkbox"/>	                     		
				            			<label class="radio_text"> 全体教职工</label>
				            			<?php 
											//根据学校，动态读取年级与班级
											$o_class=new Base_Role();
											$o_class->PushOrder ( array ('Name','A') );
											$n_count=$o_class->getAllCount();
											for($i=0;$i<$n_count;$i++)
											{
												$s_grade_name='';
												echo('
												<div class="sub_role">
													<input type="checkbox" name="Vcl_Target_'.$o_class->getRoleId($i).'"/>	                     		
						            				<label class="radio_text">'.$o_class->getName($i).'</label>
					            				</div>
					            				');
											}		                    	
										?>
				            		</div>
	                     		</div>
	                     	</div>	                     	
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="teacher_survey_manage_release()">发布</button>
							</div>                   	
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>

<script type="text/javascript">

</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>