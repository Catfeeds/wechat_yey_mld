<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120401 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';

require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
$o_answer=new Survey_Answers($_GET['id']);
if($o_answer->getName()==null || $o_answer->getName()=='')
{
	exit(0);
}
$o_survey=new Survey($o_answer->getSurveyId());
ob_start();
?>
					<div class="answer">
						<h1><?php echo($o_survey->getTitle())?>
							<h4>
							姓名：<?php echo($o_answer->getName())?><br/>班级：<?php echo($o_answer->getClassName())?><br/>提交时间：<?php echo($o_answer->getDate())?>
							</h4>
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
										$s_flag='● ';
									}else{
										$s_flag='&nbsp;&nbsp;&nbsp;';
									}
									echo('
									<h3>
									'.$s_flag.$o_option->getNumber($j).'. '.$o_option->getOption($j).'
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
										$s_flag='● ';
									}else{
										$s_flag='&nbsp;&nbsp;&nbsp;';
									}
									echo('
									<h3>
									'.$s_flag.$o_option->getNumber($j).'. '.$o_option->getOption($j).'
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
$stylesheet = file_get_contents('css/pdf.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($content,2);

$mpdf->Output(iconv ( 'UTF-8', 'gbk','幼儿信息.pdf'),'I');
exit;
?>