<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120206);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$o_answer=new Student_Onboard_Survey_Answers($_GET['id']);
if($o_answer->getStudentId()>0)
{
	
}else{
	exit(0);
}
$o_student=new Student_Onboard_Info_Class_View($o_answer->getStudentId());
$a_answer=json_decode($o_answer->getAnswer());
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
<style>
.answer
{
	padding-top:20px;
	width:60%;
	margin-left:20%;
}
.answer h1
{
	text-align:center;
	font-size:18px;
	font-weight:bold;
}
.answer h2
{
	font-size:16px;
	border-top: 1px solid #EFEFEF;
	padding-top:10px;
}
.answer h3
{
	font-size:14px;
	margin-left:40px;
	margin-top:15px;
}
.answer h4
{
	font-size:12px;
	text-align:left;
	line-height:18px;
}
.answer h3 span
{
	margin-left:-6px;
}
</style>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading" style="position:static;">
                            <div class="caption" id="table_title">查看问卷：<?php echo($o_student->getName())?>（<?php echo($o_student->getClassName())?>）</div>
                            <div class="caption" id="status">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            <button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;
                                margin-top: 0px; outline: medium none;margin-left:10px;" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'">
                                <?php echo(Text::Key('Back'))?></button> 
                                <button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;
                                margin-top: 0px; outline: medium none;margin-left:10px;display:none" onclick="window.open('parent_survey_manage_progress_pdf.php?id=<?php echo($o_answer->getId())?>','_blank')">
                                <span class="glyphicon glyphicon-print"></span>&nbsp;打印</button>                         
                            </div>
                    </div>
					<div class="answer">
							<h4>
							姓名：<?php echo($o_student->getName())?>&nbsp;&nbsp;&nbsp;&nbsp;班级：<?php echo($o_student->getClassName())?>
							</h4>
						<h1>
							<?php echo(rawurldecode($a_answer[0]))?>
							<h3 style="margin-left:20px;">
							<?php 
				require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
				$o_bn_base=new Bn_Basic();
				echo($o_bn_base->AilterTextArea(rawurldecode($a_answer[1])))?></h3>
						</h1>
						<?php
						for($i=2;$i<count($a_answer);$i++)
						{
							$a_temp=$a_answer[$i];
							if ($a_temp[1]==0)
							{
								echo('
								<h2><b>'.rawurldecode($a_temp[2]).'</b>
								');
							}else{
									echo('
								<h2 style="margin-left:20px;border-top: 0px;">'.$a_temp[0].'. '.rawurldecode($a_temp[2]).'
								');
								if ($a_temp[1]==2)
								{
									//多选，需要循环操作
									$a_option=$a_temp[3];
									for($j=0;$j<count($a_option);$j++)
									{
										echo('
											<h3>
											'.rawurldecode($a_option[$j]).'
											</h3>
										');
									}
								}else{
									//单选或问答
									echo('
									<h3>
									'.rawurldecode($a_temp[3]).'
									</h3>
								');
								}
								
							}	
						}
						?>
						<button id="user_add_btn" type="button" class="btn btn-primary cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'">返回</button>
						<button id="user_add_btn" type="button" class="btn btn-primary cancel" aria-hidden="true" style="float: right;outline: medium none;margin-right:10px;;display:none" data-placement="left" onclick="window.open('parent_survey_manage_progress_pdf.php?id=<?php echo($o_answer->getId())?>','_blank')"><span class="glyphicon glyphicon-print"></span>&nbsp;打印</button>
					</div>


<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>