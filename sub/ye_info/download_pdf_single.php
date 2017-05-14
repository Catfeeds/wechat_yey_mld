<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120200 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';

require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
if (is_numeric ( $_GET ['id'] )) {
	$n_uid = $_GET ['id'];
} else {
	$n_uid = 0;
}
$o_stu=new Student_Onboard_Info($n_uid);

function filter($str)
{
	if ($str=='')
	{
		echo('—');
	}else{
		echo($str);
	}
}
if($o_stu->getJh1Connection()=='')
{
	$o_stu->setJh1Connection('');
	$o_stu->setJh1IsZhixi('');
	$o_stu->setJh1IsCanji('');
	$o_stu->setJh1Name('');
	$o_stu->setJh1Job('');
	$o_stu->setJh1Danwei('');
	$o_stu->setJh1CanjiCode('');
	$o_stu->setJh1IdType('');
	$o_stu->setJh1Jiaoyu('');
	$o_stu->setJh1Id('');
	$o_stu->setJh1Phone('');
	
	$o_stu->setJh2Connection('');
	$o_stu->setJh2IsZhixi('');
	$o_stu->setJh2IsCanji('');
	$o_stu->setJh2Name('');
	$o_stu->setJh2Job('');
	$o_stu->setJh2Danwei('');
	$o_stu->setJh2CanjiCode('');
	$o_stu->setJh2IdType('');
	$o_stu->setJh2Jiaoyu('');
	$o_stu->setJh2Id('');
	$o_stu->setJh2Phone('');
	
	$o_stu->setJianhuConnection('');
	$o_stu->setJianhuName('');
	$o_stu->setJianhuPhone('');
}
ob_start();
?>
<div align="center" style="padding-top:30px;">
    <div class="title">幼儿信息</div>
    <br/>
    <table align="center" border="0" cellpadding="0" cellspacing="0">
<!--
        <tr style="font-weight:bold;font-size:16px;">
            <td colspan="20" style="padding:15px">
               基本信息
            </td>
        </tr>
        --><tr style="font-weight:bold">
            <td colspan="2" style="font-weight:bold;border-top: solid 1px black;">
               姓名
            </td>
            <td colspan="2" style="font-weight:bold;border-top: solid 1px black;">
           性别
            </td>
            <td colspan="3" style="font-weight:bold;border-top: solid 1px black;">
           证件类型
            </td>
            <td colspan="4" style="font-weight:bold;border-top: solid 1px black;">
           证件号码
            </td>
            <td colspan="3" style="font-weight:bold;border-top: solid 1px black;">
           出生日期
            </td>
            <td colspan="3" style="font-weight:bold;border-top: solid 1px black;">
           国籍
            </td>
            <td colspan="3" style="font-weight:bold;border-top: solid 1px black;">
          民族
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="2">
              <?php filter($o_stu->getName())?>
            </td>
            <td colspan="2">
          <?php filter($o_stu->getSex())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getIdType())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getId())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getBirthday())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getNationality())?>
            </td>
            <td colspan="3">
          <?php filter($o_stu->getNation())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="3" style="font-weight:bold">
               港澳台侨
            </td>
            <td colspan="4" style="font-weight:bold">
          是否有独生子女证
            </td>
            <td colspan="4" style="font-weight:bold">
           是否烈士子女
            </td>
            <td colspan="3" style="font-weight:bold">
           是否孤儿
            </td>
            <td colspan="6" style="font-weight:bold">
          是否进城务工随迁子女
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="3">
             <?php filter($o_stu->getGangao())?>
            </td>
            <td colspan="4">
         <?php filter($o_stu->getOnly())?> <?php 
          if ($o_stu->getOnly()=='是' && $o_stu->getOnlyCode()!='')
          {
          	echo('('.$o_stu->getOnlyCode().')');
          }
          ?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getIsLieshi())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getIsGuer())?>
            </td>
            <td colspan="6">
         <?php filter($o_stu->getIsWugong())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="4" style="font-weight:bold">
               是否留守儿童
            </td>
            <td colspan="3" style="font-weight:bold">
           是否头胎
            </td>
            <td colspan="3" style="font-weight:bold">
          是否低保
            </td>
            <td colspan="4" style="font-weight:bold">
          低保证号
            </td>
            <td colspan="6" style="font-weight:bold">
          是否正在接收资助
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="4">
              <?php filter($o_stu->getIsLiushou())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getIsFirst())?>
            </td>
            <td colspan="3">
          <?php filter($o_stu->getIsDibao())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getDibaoCode())?>
            </td>
            <td colspan="6">
          <?php filter($o_stu->getIsZizhu())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="7" style="font-weight:bold">
               是否残疾儿童
            </td>
            <td colspan="7" style="font-weight:bold">
           残疾儿童类别
            </td>
            <td colspan="6" style="font-weight:bold">
          残疾证号
            </td>
        </tr>
        <tr style="font-size:12px;" class="layer">
            <td colspan="7">
               <?php filter($o_stu->getIsCanji())?>
            </td>
            <td colspan="7">
          <?php filter($o_stu->getCanjiType())?>
            </td>
            <td colspan="6">
          <?php filter($o_stu->getCanjiCode())?>
            </td>
        </tr><!--
        <tr style="font-weight:bold;font-size:16px;">
            <td colspan="20" style="padding:15px">
              健康信息
            </td>
        </tr>
        --><tr style="font-weight:bold">
            <td colspan="4" style="font-weight:bold">
               总体健康状况
            </td>
            <td colspan="2" style="font-weight:bold">
           血型
            </td>
            <td colspan="4" style="font-weight:bold">
         是否有以往病史
            </td>
            <td colspan="3" style="font-weight:bold">
         以往病史
            </td>
            <td colspan="4" style="font-weight:bold">
        是否有手术史
            </td>
            <td colspan="3" style="font-weight:bold">
        手术名称
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="4">
                <?php filter($o_stu->getJiankang())?>
            </td>
            <td colspan="2">
            <?php filter($o_stu->getXuexing())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getIsYiwang())?>
            </td>
            <td colspan="3">
          <?php filter($o_stu->getIllness())?>
            </td>
            <td colspan="4">
         <?php filter($o_stu->getIsShoushu())?>
            </td>
            <td colspan="3">
         <?php filter($o_stu->getShoushu())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="4" style="font-weight:bold">
               是否有器官移植史
            </td>
            <td colspan="4" style="font-weight:bold">
           是否有过敏史
            </td>
            <td colspan="3" style="font-weight:bold">
         过敏源
            </td>
            <td colspan="5" style="font-weight:bold">
         是否有族遗传病史
            </td>
            <td colspan="4" style="font-weight:bold">
        家族遗传病史名称
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="4">
                <?php filter($o_stu->getIsYizhi())?>
            </td>
            <td colspan="4">
            <?php filter($o_stu->getIsGuomin())?>
            </td>
            <td colspan="3">
          <?php filter($o_stu->getAllergic())?>
            </td>
            <td colspan="5">
         <?php filter($o_stu->getIsYichuan())?>
            </td>
            <td colspan="4">
         <?php filter($o_stu->getQitabingshi())?>
            </td>
        </tr>
        <tr style="font-weight:bold" class="layer">
            <td colspan="4" style="font-weight:bold">
               备注
            </td>
            <td colspan="16" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getBeizhu())?>
            </td>
        </tr>
        <!--<tr style="font-weight:bold;font-size:16px;">
            <td colspan="20" style="padding:15px">
              户籍信息
            </td>
        </tr>
        --><tr style="font-weight:bold">
            <td colspan="10" style="font-weight:bold">
               出生所在地
            </td>
            <td colspan="5" style="font-weight:bold">
           户口性质
            </td>
            <td colspan="5" style="font-weight:bold">
         非农业户口类型
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="10">
              <?php filter($o_stu->getBirthplace ())?>
            </td>
            <td colspan="5">
            <?php filter($o_stu->getIdQuality ())?>
            </td>
            <td colspan="5">
          <?php filter($o_stu->getIdQualityType ())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="5" style="font-weight:bold">
               户籍所在地
            </td>
            <td colspan="15" style="font-weight:normal;font-size:12px;">
            <?php filter($o_stu->getHCity ().''.$o_stu->getHArea ().''.$o_stu->getHStreet().''.$o_stu->getHShequ())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="5" style="font-weight:bold">
               户籍详细地址
            </td>
            <td colspan="15" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getHAdd ())?>
            </td>
        </tr>
        <tr style="font-weight:bold" class="layer">
            <td colspan="5" style="font-weight:bold">
               户主姓名
            </td>
            <td colspan="5" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getHOwner ())?>
            </td>
            <td colspan="5" style="font-weight:bold">
	户主与幼儿关系
            </td>
            <td colspan="5" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getHGuanxi ())?>
            </td>
        </tr>
		<tr style="font-weight:bold">
            <td colspan="6" style="font-weight:bold">
               现住址是否与户籍为同一地址
            </td>
            <td colspan="1" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getZSame())?>
            </td>
            <td colspan="3" style="font-weight:bold">
               现住址所在地
            </td>
            <td colspan="10" style="font-weight:normal;font-size:12px;">
          <?php filter($o_stu->getZCity ().''.$o_stu->getZArea ().''.$o_stu->getZStreet().''.$o_stu->getZShequ())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="5" style="font-weight:bold">
               现住址详细地址
            </td>
            <td colspan="15" style="font-weight:normal;font-size:12px;">
            <?php filter($o_stu->getZAdd ())?>
            </td>
        </tr>
        <tr style="font-weight:bold" class="layer">
            <td colspan="5" style="font-weight:bold">
               现住址房屋属性
            </td>
            <td colspan="3" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getZProperty())?>
            </td>
            <td colspan="3" style="font-weight:bold">
	产权人姓名
            </td>
            <td colspan="3" style="font-weight:normal;font-size:12px;">
            <?php filter($o_stu->getZOwner())?>
            </td>
            <td colspan="4" style="font-weight:bold">
	产权人与孩子关系
            </td>
            <td colspan="2" style="font-weight:normal;font-size:12px;">
            <?php filter($o_stu->getZGuanxi())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td rowspan="4" colspan="1" style="border-bottom: solid 3px black;font-weight:bold">
           第一法定监护人
            </td>
            <td colspan="2" style="font-weight:bold">
               关系
            </td>
            <td colspan="2" style="font-weight:bold">
           姓名
            </td>
            <td colspan="3" style="font-weight:bold">
           证件类型
            </td>
            <td colspan="4" style="font-weight:bold">
           证件号码
            </td>
            <td colspan="4" style="font-weight:bold">
           是否是直系亲属
            </td>
            <td colspan="4" style="font-weight:bold">
           职业状况
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="2">
              <?php filter($o_stu->getJh1Connection())?>
            </td>
            <td colspan="2">
           <?php filter($o_stu->getJh1Name())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getJh1IdType())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh1Id())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh1IsZhixi())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getJh1Job())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="4" style="font-weight:bold">
               教育程度
            </td>
            <td colspan="3" style="font-weight:bold">
           联系电话
            </td>
            <td colspan="4" style="font-weight:bold">
           工作单位
            </td>
            <td colspan="4" style="font-weight:bold">
           是否残疾
            </td>
            <td colspan="4" style="font-weight:bold">
           残疾证号
            </td>
        </tr>
        <tr style="font-size:12px;" class="layer">
            <td colspan="4">
               <?php filter($o_stu->getJh1Jiaoyu())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getJh1Phone())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh1Danwei())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getJh1IsCanji())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh1CanjiCode())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td rowspan="4" colspan="1" style="border-bottom: solid 3px black;font-weight:bold">
           第二法定监护人
            </td>
            <td colspan="2" style="font-weight:bold">
               关系
            </td>
            <td colspan="2" style="font-weight:bold">
           姓名
            </td>
            <td colspan="3" style="font-weight:bold">
           证件类型
            </td>
            <td colspan="4" style="font-weight:bold">
           证件号码
            </td>
            <td colspan="4" style="font-weight:bold">
           是否是直系亲属
            </td>
            <td colspan="4" style="font-weight:bold">
           职业状况
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="2">
              <?php filter($o_stu->getJh2Connection())?>
            </td>
            <td colspan="2">
           <?php filter($o_stu->getJh2Name())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getJh2IdType())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh2Id())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh2IsZhixi())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getJh2Job())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="4" style="font-weight:bold">
               教育程度
            </td>
            <td colspan="3" style="font-weight:bold">
           联系电话
            </td>
            <td colspan="4" style="font-weight:bold">
           工作单位
            </td>
            <td colspan="4" style="font-weight:bold">
           是否残疾
            </td>
            <td colspan="4" style="font-weight:bold">
           残疾证号
            </td>
        </tr>
        <tr style="font-size:12px;" class="layer">
            <td colspan="4">
               <?php filter($o_stu->getJh2Jiaoyu())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getJh2Phone())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh2Danwei())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getJh2IsCanji())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh2CanjiCode())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="4" style="font-weight:bold">
              其他监护人关系
            </td>
            <td colspan="2" style="font-weight:normal;font-size:12px;">
          <?php filter($o_stu->getJianhuConnection())?>
            </td>
            <td colspan="3" style="font-weight:bold">
	其他监护人姓名
            </td>
            <td colspan="3" style="font-weight:normal;font-size:12px;">
          <?php filter($o_stu->getJianhuName())?>
            </td>
            <td colspan="4" style="font-weight:bold">
	其他监护人电话
            </td>
            <td colspan="4" style="font-weight:normal;font-size:12px;">
            <?php filter($o_stu->getJianhuPhone())?>
            </td>
        </tr>
    </table>
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

$mpdf->Output(iconv ( 'UTF-8', 'gbk','幼儿信息('.$o_stu->getName().').pdf'),'I');
exit;
?>
