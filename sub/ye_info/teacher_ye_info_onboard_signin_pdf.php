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
$stylesheet = file_get_contents('css/onboard_signin.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text


for($i = 0; $i < $n_count; $i ++) {
	ob_start();
?>
	<h1>马连道幼儿园新入园儿童登记表</h1>
    <h2 style="text-align:right;margin-top:-32px;float:left">入园时间：2017年9月</h2>
    <table class="main" cellspacing="0" cellpadding="0">
      <tr>
        <td style="text-align:center" nowrap="nowrap"><?php echo($s_file_name)?></td>
        <td style="text-align:center" nowrap="nowrap"><?php echo($o_dept->getName($i))?></td>
        <td style="text-align:center" nowrap="nowrap"><?php echo($o_dept->getSex($i))?></td>
        <td colspan="3" style="text-align:center;" nowrap="nowrap"><?php echo($o_dept->getIdType($i))?>-<?php echo($o_dept->getId($i))?></td></tr>
      <tr>
        <td colspan="4">现住址：<?php 
        if ($o_dept->getZSame($i)=='是')
        {
        	echo($o_dept->getHAdd($i));
        }else{
        	echo($o_dept->getZAdd($i));
        }
        ?></td>
        <td style="text-align:center"><?php echo($o_dept->getNation($i))?></td>
        <td style="text-align:center"><?php echo($o_dept->getBirthday($i))?></td></tr>       
      <tr>
        <td colspan="6">户口所在地：<?php echo($o_dept->getHAdd($i))?></td></tr>
      <tr>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh1Connection($i))?></td>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh1Name($i))?></td>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh1Id($i))?></td>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh1Danwei($i))?></td>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh1Job($i))?></td>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh1Phone($i))?></td></tr>
      <tr>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh2Connection($i))?>&nbsp;</td>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh2Name($i))?>&nbsp;</td>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh2Id($i))?>&nbsp;</td>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh2Danwei($i))?>&nbsp;</td>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh2Job($i))?>&nbsp;</td>
        <td style="text-align:center;font-size:12px" nowrap="nowrap"><?php echo($o_dept->getJh2Phone($i))?>&nbsp;</td></tr>
      <tr>
        <td colspan="6">新生入园应持有：
          <br/>1.有效的入园体检表及化验单（幼儿园统一到西城妇幼保健院领取、滞后体检的自取）。
          <br/>2.北京市儿童保健记录本---（到原管理的保健科转出）。
          <br/>3.预防接种证复印件---（幼儿基本信息页、接种记录页一定要清楚完整A4纸）。</td></tr>
      <tr>
        <td colspan="6">转园生入园应持有：1个月之内的转园证明、北京市儿童保健记录本、预防接种证复印件(A4纸)</td></tr>
      <tr>
      <?php 
      //读取入园问卷
        $o_answer=new Student_Onboard_Survey_Answers();
		$o_answer->PushWhere ( array ('&&', 'StudentId', '=', $o_dept->getStudentId($i) ) );
		$o_answer->PushWhere ( array ('&&', 'SurveyId', '=', 1) );
		$s_01='';
		$s_02='';
		$s_03='';
		$s_04='';
		$s_05='';
		$s_06='';
		$s_07='';
		if ($o_answer->getAllCount()>0)
		{
			$a_answer=json_decode($o_answer->getAnswer(0));
			$a_temp=$a_answer[17];//健康状况
			$s_01=rawurldecode($a_temp[3]);
			$a_temp=$a_answer[23];//既往患传染病史
			$s_03=rawurldecode($a_temp[3]);
			$a_temp=$a_answer[21];//对什么食物过敏
			$s_04=rawurldecode($a_temp[3]);
			$a_temp=$a_answer[18];//是否有高热惊厥
			$s_05=rawurldecode($a_temp[3]);
			$a_temp=$a_answer[18];//是否有高热惊厥
			$s_05=rawurldecode($a_temp[3]);
			$a_temp=$a_answer[19];//高热惊厥体温
			$s_06=rawurldecode($a_temp[3]);
			$a_temp=$a_answer[20];//最后一次高热惊厥时间
			$s_07=rawurldecode($a_temp[3]);
		}
      ?>
        <td colspan="6">
        	儿童体质情况：(<?php echo($s_01)?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;儿童既往病史：<?php 
        	if ($o_dept->getIllness($i)=='')
        	{
        		echo('无');
        	}else{
        		echo($o_dept->getIllness($i));
        	}
        	?><br/>
        	既往患传染病史： <?php echo($s_03)?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;对什么食物过敏：<?php echo($s_04)?></td></tr>
      <tr>
        <td colspan="6" nowrap="nowrap">是否有高热惊厥：(<?php echo($s_05)?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;高热惊厥体温：<?php echo($s_06)?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最后一次高热惊厥时间：<?php echo($s_07)?></td></tr>
      <tr>
        <td colspan="6">备注：请家长在入园前，到地段保健科补齐预防接种的针次，并办理迁出。如不迁出，请在复印件上标注。</td></tr>      
      <tr>
        <td colspan="6">在街道已入医保的不用迁出，只做好银行卡费用的补足每年160元。</td></tr>
    </table>
    <h2>★为了更好的完成儿童保健工作，请认真填写此表（必填），并配合交齐幼儿保健材料。</h2>
    <h2>★预防接种证由家长自行保管，以方便带幼儿到医院保健科接种疫苗使用，并随时了解接种情况。</h2>
    <?php 
    if (($i+1)<$n_count)
    {
    	//如果还有下一页，那么显示间隔区域
    	echo('
    	<br/>
	    <br/>
	    <br/>
    	');
    }
    ?>
    
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
$mpdf->Output(iconv ( 'UTF-8', 'gbk','新入园儿童登记表('.$s_file_name.').pdf'),'I');
exit;
?>
