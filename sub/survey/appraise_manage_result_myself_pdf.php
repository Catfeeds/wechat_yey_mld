<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120403 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';

require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
$o_survey=new Survey_Appraise($_GET['appraise_id']);
if($o_survey->getTitle()==null || $o_survey->getTitle()=='' || $o_survey->getState()=='0')
{
	exit(0);
}
$o_dept=new Student_Class($_GET['class_id']);
ob_start();
?>
					<div class="answer">
						<h1>
							<h4>
							答题人数：<?php
							$o_answer=new Survey_Appraise_Answers_View();
							$o_answer->PushWhere ( array ('&&', 'AppraiseId', '=',$_GET['appraise_id']) );
							$o_answer->PushWhere ( array ('&&', 'ClassId', '=',$_GET['class_id']) );
							$n_answer_sum=$o_answer->getAllCount();
							echo($o_answer->getAllCount());
							?> 人&nbsp;&nbsp;&nbsp;&nbsp;班级名称：<?php echo($o_dept->geClasstName())?>
							</h4>
							<?php echo($o_survey->getTitle())?>							
						</h1>
						<?php
						$n_number=1;
						$b_start=false;
						$o_question=new Survey_Appraise_Questions();
						$o_question->PushWhere ( array ('&&', 'AppraiseId', '=',$o_survey->getId()) );
						$o_question->PushOrder ( array ('Number', 'A') );
						for($i=0;$i<$o_question->getAllCount();$i++)
						{
							if ($o_question->getType ( $i )==1)
							{
								$b_start=true;
								$s_type='单选';
							}							
							if ($o_question->getType ( $i )==2)
							{
								$b_start=true;
								$s_type='多选';
							}							
							if ($o_question->getType ( $i )==3)
							{
								$s_type='简述';
								$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
							}
							echo('
								<h2 style="margin-left:20px;border-top: 0px;">'.$n_number.'. '.$o_question->getQuestion($i).'（'.$s_type.'）
								');
							$o_option=new Survey_Appraise_Options();
							$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId ( $i )) );
							$o_option->PushOrder ( array ('Number','A') );
							if($o_question->getType ( $i )==1 ||$o_question->getType ( $i )==2)
							{
								//如果是单选题
								for($j=0;$j<$o_option->getAllCount();$j++)
								{
									$o_answer=new Survey_Appraise_Answers_View();
									$o_answer->PushWhere ( array ('&&', 'AppraiseId', '=',$o_survey->getId()) );
									$o_answer->PushWhere ( array ('&&', 'ClassId', '=',$_GET['class_id']) );
									$o_answer->PushWhere ( array ('&&', 'Answer'.$o_question->getNumber($i), 'like','%"'.$o_option->getId($j).'"%') );
									$n_people=$o_answer->getAllCount();
									$n_rate=round(($n_people/$n_answer_sum)*1000)/10;//结果*1000取整再除以10
									echo('
									<h3>
									'.$o_option->getNumber($j).'. '.$o_option->getOption($j).'&nbsp;&nbsp;&nbsp;&nbsp;
									'.$n_people.'人 ('.$n_rate.'%)
									</h3>
									');
								}
							}
							if($o_question->getType ( $i )==3)
							{
								if ($b_start)
								{
									$o_answer=new Survey_Appraise_Answers_View();
									$o_answer->PushWhere ( array ('&&', 'AppraiseId', '=',$o_survey->getId()) );
									$o_answer->PushWhere ( array ('&&', 'ClassId', '=',$_GET['class_id']) );
									$o_answer->PushWhere ( array ('&&', 'Answer'.$o_question->getNumber($i), '<>','') );
									$n_people=$o_answer->getAllCount();
									for($j=0;$j<$n_people;$j++)
									{
										eval('$s_value=$o_answer->getAnswer'.$o_question->getNumber($i).'($j);');//获取用户答案
										$s_value=str_replace('"', '', $s_value);//去掉多余的双引号
										if (rawurldecode($s_value)=='无')
										{
											continue;
										}
										echo('
									<h3>
									答：'.rawurldecode($s_value).'
									</h3>
									');
									}
								}							
							}
							echo('</h2>');
							$n_number++;
						}
						?>
					</div>
<?php 
$content = ob_get_clean();
require_once RELATIVITY_PATH . 'include/mpdf60/mpdf.php';

$mpdf=new mPDF('zh-CN','A4','','',32,25,27,25,16,13); 
$mpdf->AddPage('','','','','',10,10,10,10,10,10);
$mpdf->useAdobeCJK = true;
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('css/appraise_total_pdf.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($content,2);

$mpdf->Output(iconv ( 'UTF-8', 'gbk',$o_dept->getClassName().'-自评.pdf'),'I');
exit;
?>