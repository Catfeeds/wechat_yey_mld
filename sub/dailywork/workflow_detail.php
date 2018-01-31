<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120604);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
$o_case=new Dailywork_Workflow_Case_View($_GET['id']);
if (!($o_case->getState()==100))
{
	//非法ID，那么退出
	echo "<script>location.href='workflow.php'</script>"; 
	exit(0);
}
?>
<style>
.form-control
{
	width:100%;
}
.panel-heading2
{
	background-color: #EEEEEE !important;
	color: #777777 !important;
	border-color: #DDDDDD !important;
}
.panel-info
{
	border-color: #DDDDDD !important;
}
.panel-body td
{
	line-height:20px;
}
</style>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                            工作流程详情
                            </div>
                        </div>
                    </div>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label>申请人姓名：</label>
	                     		<fieldset disabled>
	                     			<div class="form-control"/>
	                     				<?php 
											echo($o_case->getName());
										?>
	                     			</div>
	                     		</fieldset>
	                     	</div>
	                     	<div class="item">
	                     		<label>申请时间：</label>
	                     		<fieldset disabled>
	                     			<div class="form-control"/>
	                     				<?php 
											echo($o_case->getDate());
										?>
	                     			</div>
	                     		</fieldset>
	                     	</div>
						    <?php 
								$o_case_data=new Dailywork_Workflow_Case_Data();
								$o_case_data->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) ); 
								$o_case_data->PushOrder ( array ('Id', 'A') );
								for($i=0;$i<$o_case_data->getAllCount();$i++)
								{
									echo('<div class="item"><label>'.$o_case_data->getName($i).'：</label><fieldset disabled>');
									//要区分控件类型
									switch ($o_case_data->getType($i))
									{
										case 'multiple':
											//多选
											$s_value=$o_case_data->getValue($i);
											$s_value=str_replace('%%', '<br/>', $s_value);
											$s_value=str_replace('%', '', $s_value);
											echo('
											<div class="form-control"/>
														'.$s_value.'
											</div>
											');
											break;
										case 'time':
											//时间
											echo('
											<div class="form-control"/>
														'.str_replace('T', ' ', $o_case_data->getValue($i)).'
											</div>
											');
											break;
										case 'img':
											//图片
											$a_img=json_decode($o_case_data->getValue($i));
											//构建图片列表
											$s_img='';
											for($j=0;$j<count($a_img);$j++)
											{
												$s_img.='<a href="'.RELATIVITY_PATH.$a_img[$j].'" target="_blank" style="float:left;margin-right:5px;margin-bottom:5px;">
										          <img class="media-object" src="'.RELATIVITY_PATH.$a_img[$j].'" data-holder-rendered="true" style="width: 64px; height: 64px;">
										        </a>';
											}
											echo('
										        '.$s_img.'
											');
											break;
										default:
											echo('
											<div class="form-control"/>
														'.$o_case_data->getValue($i).'
											</div>
											');
									}
									echo('</fieldset></div>');				
								}
								?>	       
							<div class="item">
	                     		<div class="panel panel-info">
							      <div class="panel-heading panel-heading2">
							        <h3 class="panel-title">工作流程记录</h3>
							      </div>
							      <div class="panel-body">	
							      <?php 
										$o_log=new Dailywork_Workflow_Case_Log();
										$o_log->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) ); 
										$o_log->PushOrder ( array ('Date', 'A') );
										for($i=0;$i<$o_log->getAllCount();$i++)
										{
											$s_comment='无';
											if ($o_log->getComment($i)!='审批意见：')
											{
												$s_comment=$o_log->getComment($i);
											}
											echo('
											<table>
										      	<tr>
										      		<td style="width:80px;">
										      			<b>日期</b>
										      		</td>
										      		<td>
										      			'.$o_log->getDate($i).'
										      		</td>
										      	<tr>
										      	<tr>
										      		<td>
										      			<b>操作</b>
										      		</td>
										      		<td>
										      			'.$o_log->getOperatorName($i).'
										      		</td>
										      	<tr>
										      	<tr>
										      		<td>
										      			<b>备注</b>
										      		</td>
										      		<td>
										      			'.$s_comment.'
										      		</td>
										      	<tr>
										    </table>
											');
											if (($i+1)<$o_log->getAllCount())
											{
												echo('<div style="width:96%;margin:10px;margin-left:2%;margin-right:2%;border-color:#DDDDDD;border-top: 1px solid #DDDDDD;"></div>');
											}
										}										
									?>							      		      	
							      </div>
							    </div>
							</div>              	
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Back'))?></button>
							</div>
                     	</div>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">

</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>