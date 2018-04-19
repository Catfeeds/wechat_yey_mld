<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120403);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
$o_answer=new Survey_Appraise_Answers_View($_GET['id']);
if($o_answer->getAppraiseTitle()==null || $o_answer->getAppraiseTitle()=='')
{
	exit(0);
}
$o_survey=new Survey_Appraise($o_answer->getAppraiseId());
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
	border-top: 1px solid #dddddd;
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
                            <div class="caption" id="table_title">查看评价：<?php echo($o_answer->getTitle())?>（<?php echo($o_answer->getClassName())?>）</div>
                            <div class="caption" id="status">&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            <button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;
                                margin-top: 0px; outline: medium none;margin-left:10px;" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'">
                                <?php echo(Text::Key('Back'))?></button>                      
                            </div>
                    </div>
					<div class="answer">						
							<h4>
							提交时间：<?php echo($o_answer->getDate())?><br/>
							被评价班级：<?php echo($o_answer->getClassName())?><br/>
							<?php 
							$o_appraise=new Survey_Appraise($o_answer->getAppraiseId());
							$a_column=json_decode($o_appraise->getInfo());
							$a_val=json_decode($o_answer->getInfo());
							for($j=0;$j<count($a_column);$j++)
							{
								echo(rawurldecode($a_column[$j]).'：'.rawurldecode($a_val[$j]).'<br/>');
							}
							?>
							评价人：<?php echo($o_answer->getOwnerName())?>
							</h4>
						<h1>
							<?php echo($o_survey->getTitle())?>
							<h3 style="margin-left:20px;">
							<?php 
				require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
				$o_bn_base=new Bn_Basic();
				echo($o_bn_base->AilterTextArea($o_survey->getComment()))?>
							</h3>
						</h1>
						<?php
						$n_number=1;
						$o_question=new Survey_Appraise_Questions();
						$o_question->PushWhere ( array ('&&', 'AppraiseId', '=',$o_survey->getId()) );
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
							if ($o_question->getType ( $i )==4)
							{
								echo('
								<h2><b>'.$o_question->getQuestion($i).'</b>
								');
								$n_number--;
							}else{
								echo('
								<h2 style="margin-left:20px;border-top: 0px;">'.$n_number.'. '.$o_question->getQuestion($i).'（'.$s_type.'）
								');
							}							
							$o_option=new Survey_Appraise_Options();
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
							$n_number++;
						}
						?>
						<button id="user_add_btn" type="button" class="btn btn-primary cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'">返回</button>
					</div>


<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>