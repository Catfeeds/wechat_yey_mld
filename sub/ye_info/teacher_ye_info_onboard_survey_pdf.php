<?php
set_time_limit(0); 
error_reporting(0);
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120206 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
$o_bn_base=new Bn_Basic();
$o_user = new Single_User ( $O_Session->getUid () );
if ($o_user->ValidModule ( MODULEID ) == false) {
	echo('No right.');
	exit ( 0 );//没有权限
}
if (isset ( $_GET ['classid'] ) && $_GET ['classid']>0) {
	$o_class=new Student_Class();
	$o_class->PushWhere ( array ('&&', 'ClassId', '=',$_GET ['classid']) );
	if ($o_class->getAllCount()>0){
		$s_file_name=$o_class->getClassName(0);
	}else{
		echo('ID error.');
		echo(0);//Id不合法
	}
} else {
	echo('Parameter error.');
	echo(0);//参数错误
}

$o_dept = new Student_Onboard_Info();
$o_dept->PushWhere ( array ('&&', 'State', '=', 1 ) );
$o_dept->PushWhere ( array ('&&', 'ClassNumber', '=', $_GET ['classid'] ) );
$o_dept->PushOrder ( array ('Name', 'A' ) );
$n_count = $o_dept->getAllCount ();

require_once RELATIVITY_PATH . 'include/mpdf60/mpdf.php';

$mpdf=new mPDF('zh-CN','A4','','',32,25,27,25,16,13); 
$mpdf->AddPage('','','','','',10,10,10,10,10,10);
$mpdf->useAdobeCJK = true;
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('css/onboard_survey.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text


for($i = 0; $i < $n_count; $i ++) {
	ob_start();
	$o_answer=new Student_Onboard_Survey_Answers();
	$o_answer->PushWhere ( array ('&&', 'StudentId', '=', $o_dept->getStudentId($i) ) );
	$o_answer->PushWhere ( array ('&&', 'SurveyId', '=', 1) );
	if ($o_answer->getAllCount()==0)
	{
		continue;//如果没找到入园问卷，那么跳过
	}
	$a_answer=json_decode($o_answer->getAnswer(0));
	$o_stu=new Student_Onboard_Info_Class_View($o_answer->getStudentId(0));
?>
				<div class="answer">
							<h4>							
							班级：<?php echo($o_stu->getClassName())?>&nbsp;&nbsp;&nbsp;&nbsp;
							幼儿姓名：<?php echo($o_stu->getName())?>&nbsp;&nbsp;&nbsp;&nbsp;
							性别：<?php echo($o_stu->getSex())?>&nbsp;&nbsp;&nbsp;&nbsp;
							家庭住址：<?php echo($o_stu->getHAdd())?>&nbsp;&nbsp;&nbsp;&nbsp;<br/>
							第一监护人：<?php echo($o_stu->getJh1Name())?>&nbsp;&nbsp;
							<?php echo($o_stu->getJh1Phone())?>&nbsp;&nbsp;
							<?php echo($o_stu->getJh1Danwei())?>&nbsp;&nbsp;
							<?php echo($o_stu->getJh1Jiaoyu())?>&nbsp;&nbsp;
							<?php echo($o_stu->getJh1Job())?><br/>
							<?php 
							if($o_stu->getJh1Name()!='')
							{
								?>
								第二监护人：<?php echo($o_stu->getJh2Name())?>&nbsp;&nbsp;
								<?php echo($o_stu->getJh2Phone())?>&nbsp;&nbsp;
								<?php echo($o_stu->getJh2Danwei())?>&nbsp;&nbsp;
								<?php echo($o_stu->getJh2Jiaoyu())?>&nbsp;&nbsp;
								<?php echo($o_stu->getJh2Job())?>
								<?php
							}else{
								?>
								&nbsp;&nbsp;
								<?php
							}
							?>
							</h4>
						<h1>
							<?php echo(rawurldecode($a_answer[0]))?>
							<h3>
							<?php
				echo($o_bn_base->AilterTextArea(rawurldecode($a_answer[1])))?></h3>
						</h1>
						<?php
						for($j=2;$j<count($a_answer);$j++)
						{
							$a_temp=$a_answer[$j];
							if ($a_temp[1]==0)
							{
								echo('
								<h2><strong>'.rawurldecode($a_temp[2]).'</strong></h2>
								');
							}else{
									echo('
								<h2 style="border-top:0px; margin-left:20px;">'.$a_temp[0].'. '.rawurldecode($a_temp[2]).'
								');
								if ($a_temp[1]==2)
								{
									//多选，需要循环操作
									$a_option=$a_temp[3];
									for($k=0;$k<count($a_option);$k++)
									{
										echo('
											
											'.rawurldecode($a_option[$k]).'
											
										');
									}
								}else{
									//单选或问答
									if ($j>=31)
									{
										echo('<br/>&nbsp;&nbsp;');
									}
									echo('									
									'.rawurldecode($a_temp[3]).'
									
								');
								}
								echo('</h2>');
							}	
						}
						?>
						
					</div>
<?php

	$content = ob_get_clean();

	if ($i==0)
	{
		$mpdf->WriteHTML($content,2);
	}else{
		$mpdf->WriteHTML($content,($i+4));
	}

}
function filter($str)
{
	if ($str=='')
	{
		echo('—');
	}else{
		echo($str);
	}
}

$mpdf->Output(iconv ( 'UTF-8', 'gbk','幼儿入园调查问卷('.$s_file_name.').pdf'),'I');
exit;
?>
