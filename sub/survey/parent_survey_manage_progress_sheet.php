<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120401);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
$o_answer=new Survey_Answers($_GET['id']);
if($o_answer->getName()==null || $o_answer->getName()=='')
{
	exit(0);
}
$o_survey=new Survey($o_answer->getSurveyId());
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
	margin-left:20px;
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
                            <div class="caption" id="table_title">查看问卷：<?php echo($o_answer->getName())?>（<?php echo($o_answer->getClassName())?>）</div>
                            <div class="caption" id="status">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            <button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;
                                margin-top: 0px; outline: medium none;margin-left:10px;" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'">
                                <?php echo(Text::Key('Back'))?></button> 
                                <button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;
                                margin-top: 0px; outline: medium none;margin-left:10px;" onclick="window.open('parent_survey_manage_progress_pdf.php?id=<?php echo($o_answer->getId())?>','_blank')">
                                <span class="glyphicon glyphicon-print"></span>&nbsp;打印</button>                         
                            </div>
                    </div>
					<div class="answer">
						
							<h4>
							姓名：<?php echo($o_answer->getName())?>&nbsp;&nbsp;&nbsp;&nbsp;班级：<?php echo($o_answer->getClassName())?>&nbsp;&nbsp;&nbsp;&nbsp;提交时间：<?php echo($o_answer->getDate())?>
							</h4>
						<h1>
							<?php echo($o_survey->getTitle())?>
							<h3>
							<?php 
				require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
				$o_bn_base=new Bn_Basic();
				echo($o_bn_base->AilterTextArea($o_survey->getComment()))?>
							</h3>
						</h1>
						<?php 
						$o_question=new Survey_Questions();
						$o_question->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
						$o_question->PushOrder ( array ('Number', 'A') );
						for($i=0;$i<$o_question->getAllCount();$i++)
						{
							if ($o_question->getType ( $i )==1)
							$s_type='单选';
							if ($o_question->getType ( $i )==2)
							$s_type='多选';
							if ($o_question->getType ( $i )==3)
							{
								$s_type='简述';
								$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
							}
							echo('
							<h2><b>'.$o_question->getNumber($i).'. '.$o_question->getQuestion($i).'</b>（'.$s_type.'）
							');
							$o_option=new Survey_Options();
							$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId ( $i )) );
							$o_option->PushOrder ( array ('Id','A') );
							if($o_question->getType ( $i )==1)
							{
								//如果是单选题
								for($j=0;$j<$o_option->getAllCount();$j++)
								{
									$s_flag='';
									eval('$s_value=$o_answer->getAnswer'.$o_question->getNumber($i).'();');//获取用户答案
									$s_value=str_replace('"', '', $s_value);//去掉多余的双引号
									if ($o_option->getId($j)==$s_value)
									{
										//被选中
										$s_flag='<span class="label label-success">'.$o_option->getNumber($j).'</span> ';
									}else{
										$s_flag=$o_option->getNumber($j).'. ';
									}
									echo('
									<h3>
									'.$s_flag.$o_option->getOption($j).'
									</h3>
									');
								}
							}
							if($o_question->getType ( $i )==2)
							{
								//如果是单选题
								for($j=0;$j<$o_option->getAllCount();$j++)
								{
									$s_flag='';
									eval('$s_value=$o_answer->getAnswer'.$o_question->getNumber($i).'();');//获取用户答案
									$s_value=str_replace('"', '', $s_value);//去掉多余的双引号
									$a_value=json_decode($s_value);
									if (in_array($o_option->getId($j),$a_value))
									{
										//被选中
										$s_flag='<span class="label label-success">'.$o_option->getNumber($j).'</span> ';
									}else{
										$s_flag=$o_option->getNumber($j).'. ';
									}
									echo('
									<h3>
									'.$s_flag.$o_option->getOption($j).'
									</h3>
									');
								}
							}
							if($o_question->getType ( $i )==3)
							{
								eval('$s_value=$o_answer->getAnswer'.$o_question->getNumber($i).'();');//获取用户答案
								$s_value=str_replace('"', '', $s_value);//去掉多余的双引号
								echo('
								<h3>
								答：'.rawurldecode($s_value).'
								</h3>
								');
							}
							echo('</h2>');
						}
						?>
						<button id="user_add_btn" type="button" class="btn btn-primary cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'">返回</button>
						<button id="user_add_btn" type="button" class="btn btn-primary cancel" aria-hidden="true" style="float: right;outline: medium none;margin-right:10px;" data-placement="left" onclick="window.open('parent_survey_manage_progress_pdf.php?id=<?php echo($o_answer->getId())?>','_blank')"><span class="glyphicon glyphicon-print"></span>&nbsp;打印</button>
					</div>


<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>