<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120303);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
//获取子模块菜单
ExportMainTitle(MODULEID,$O_Session->getUid());

//获取刚刚发的通知
require_once RELATIVITY_PATH . 'sub/notice_center/include/db_table.class.php';
$o_table=new Notice_Center_Teacher_Record();
$o_table->PushWhere ( array ('&&', 'Uid', '=',$O_Session->getUid()) );
$o_table->PushOrder ( array ('Id','D') );
$o_table->setStartLine ( 0 );
$o_table->setCountLine ( 1);
$o_table->getAllCount();
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        	<span  class="glyphicon fa fa-users"></span>&nbsp;群发通知
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="TeacherSendNoticeMultipleByDept"/>
						<textarea id="Vcl_Comment" name="Vcl_Comment" cols="1" rows="1" style="width: 1px; height: 1px; visibility: hidden"></textarea>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label><span class="must">*</span> 标题：</label>
	                     		<input name="Vcl_First" maxlength="50" id="Vcl_First" type="text" style="width:100%" placeholder="必填" class="form-control" value="<?php echo($o_table->getFirst(0))?>"/>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 类型：</label>
	                     		<select id="Vcl_Type" name="Vcl_Type" class="selectpicker" data-style="btn-default" >
									<option value="">请选择</option>
									<?php 
									$o_type=new Notice_Center_Type();
									$o_type->PushWhere ( array ('&&', 'Type', '=','教职工') );
									$o_type->PushOrder ( array ('Number','A') );
									for($i=0;$i<$o_type->getAllCount();$i++)
									{
										echo('<option value="'.$o_type->getName($i).'">'.$o_type->getName($i).'</option>');
									}
									?>									
								</select>	                     		
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 内容：</label>
	                     		<textarea  name="Vcl_Remark" maxlength="80" id="Vcl_Remark" type="text" style="width:100%" placeholder="必填，不能超过80字" class="form-control" rows="5"/><?php echo($o_table->getRemark(0))?></textarea>
	                     	</div>
	                     	<div class="item">
	                     		<label><span class="must">*</span> 发送对象：</label>
	                     		<select id="Vcl_Target" name="Vcl_Target" class="selectpicker" data-style="btn-default" >
	                     			<option value="">请选择</option>
									<option value="0">全体教职工</option>
									<?php 
										$o_dept=new Base_Dept();
										$o_dept->PushOrder ( array ('Name','A') );
										$n_count=$o_dept->getAllCount();
										$a_address=array();
										for($i=0;$i<$n_count;$i++)
										{		
											echo('<option value="'.$o_dept->getDeptId($i).'">'.$o_dept->getName($i).'</option>');
											if ($o_dept->getAddress($i)!='')
											{
												array_push($a_address, $o_dept->getAddress($i));
											}
										}
										$a_address=array_unique($a_address);
										$a_address=array_merge($a_address);//修改数组键值
										for($i=0;$i<count($a_address);$i++)
										{
											echo('<option value="'.$a_address[$i].'">'.$a_address[$i].'</option>');
										}	                    	
									?>
								</select>	
								<label style="margin-top:3px;"><span class="must">
								特别注意：<br/>
								1. 发送“分部”的时候请再单独发送个人“张金波”。<br/>
								2. 发送“本部”的时候个人“张金波”也可以收到信息。<br/>
								3. 如需“前勤部门”则需要按部门发送：保教主任+大班组+中班组+小班组，另需按角色发送“园长岗”。</span></label>                     		
	                     	</div>
	                     	<div class="item">
	                     	<style>
	                     	#edui1,#edui1_iframeholder{
							width:100% !important;
	                     	}
	                     	</style>
	                     		<label>点击详情内容（注：如果不需要此功能，此处可为空。）：</label>
	                     		<script id="editor" type="text/plain"><?php echo(rawurldecode($o_table->getComment(0)))?></script>
	                     	</div>
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="teacher_send_notice_multiple()"><span class="glyphicon fa fa-send"></span>&nbsp;发送</button>
							</div>                   	
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo(RELATIVITY_PATH)?>sub/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo(RELATIVITY_PATH)?>sub/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="<?php echo(RELATIVITY_PATH)?>sub/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
var ue = UE.getEditor('editor',{toolbars:[
                                          [ 'bold', 'italic', 'underline', 'strikethrough', 'removeformat','forecolor',
                                            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify']
                                   ],iframeCssUrl: 'css/ueditor.css'});
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>