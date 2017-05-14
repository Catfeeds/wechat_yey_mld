<?php
set_time_limit(0); 
error_reporting(0);
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 1000 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';

require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$O_Session->ValidModuleForPage ( MODULEID );
$o_user = new Single_User ( $O_Session->getUid () );
$s_file_name='全区幼儿信息列表';
if (isset ( $_GET ['deptid'] )) {
	$S_Type = $_GET ['deptid'];
	$o_dept=new Base_Dept($S_Type);
	$s_file_name=$o_dept->getName();
} else {
	$S_Type = 0;
}
if (isset ( $_GET ['grade'] ) && $_GET ['grade']>0) {
	$S_Grade = $_GET ['grade'];
	if ($S_Grade==1)$s_file_name='托班';
	if ($S_Grade==2)$s_file_name='小班';
	if ($S_Grade==3)$s_file_name='中班';
	if ($S_Grade==4)$s_file_name='大班';
} else {
	$S_Grade = 0;
}
if (isset ( $_GET ['class'] ) && $_GET ['class']>0) {
	$S_Class = $_GET ['class'];
	$o_class=new Base_Dept_Class($S_Class);
	$s_file_name=$o_class->getClassName();
} else {
	$S_Class = 0;
}

$o_dept = new View_Student_Info ();
$dept_id = $o_user->getDeptId ();
$n_deptid=$S_Type;
if($dept_id [0]==100)
{
	if ($n_deptid > 0) {
		$o_dept->PushWhere ( array ('&&', 'DeptId', '=', $n_deptid ) );
	}
}else{
	$o_dept->PushWhere ( array ('&&', 'DeptId', '=', $dept_id [0] ) );
}
	
$o_dept->PushWhere ( array ('&&', 'State', '<>', 0 ) );
$o_dept->PushWhere ( array ('&&', 'State', '<>', 5 ) );
$o_dept->PushWhere ( array ('&&', 'ClassNameDiy', '=','') );
$o_dept->PushWhere ( array ('&&', 'ClassNumber', '<>', 0 ) );
if ($S_Grade > 0) {
	$o_dept->PushWhere ( array ('&&', 'GradeNumber', '=', $S_Grade ) );
}
if ($S_Class > 0) {
	$o_dept->PushWhere ( array ('&&', 'ClassNumber', '=', $S_Class ) );
}
$o_dept->PushWhere ( array ('&&', 'GradeNumber2', '<', 5 ) );
$o_dept->PushOrder ( array ('GradeNumber', 'A' ) );
$o_dept->PushOrder ( array ('ClassName', 'A' ) );
$o_dept->PushOrder ( array ('Name', 'A' ) );
$n_count = $o_dept->getAllCount ();


include("mpdf60/mpdf.php");

$mpdf=new mPDF('zh-CN','A4','','',32,25,27,25,16,13); 
$mpdf->AddPage('','','','','',10,10,10,10,10,10);
$mpdf->useAdobeCJK = true;
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('css/pdf.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text


for($i = 0; $i < $n_count; $i ++) {
	ob_start();
	$o_session=new Base_Student($o_dept->getStudentId($i));
	$o_stu=new Base_Student_Info($o_dept->getStudentId($i));
	if($o_stu->getJh_1_Connection()=='')
	{
		$o_stu->setJh_1_Connection('');
		$o_stu->setJh_1_IsZhixi('');
		$o_stu->setJh_1_IsCanji('');
		$o_stu->setJh_1_Name('');
		$o_stu->setJh_1_Job('');
		$o_stu->setJh_1_Danwei('');
		$o_stu->setJh_1_CanjiCode('');
		$o_stu->setJh_1_IdType('');
		$o_stu->setJh_1_Jiaoyu('');
		$o_stu->setJh_1_Id('');
		$o_stu->setJh_1_Phone('');
		
		$o_stu->setJh_2_Connection('');
		$o_stu->setJh_2_IsZhixi('');
		$o_stu->setJh_2_IsCanji('');
		$o_stu->setJh_2_Name('');
		$o_stu->setJh_2_Job('');
		$o_stu->setJh_2_Danwei('');
		$o_stu->setJh_2_CanjiCode('');
		$o_stu->setJh_2_IdType('');
		$o_stu->setJh_2_Jiaoyu('');
		$o_stu->setJh_2_Id('');
		$o_stu->setJh_2_Phone('');
		
		$o_stu->setJianhuConnection('');
		$o_stu->setJianhuName('');
		$o_stu->setJianhuPhone('');
	
		$o_janhuren=new Base_Student_Guardian();
		$o_janhuren->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getUid() ) );
		$o_janhuren->PushOrder ( array ('GuardianId', 'A' ) );
		if ($o_janhuren->getAllCount()>0)
		{
			if ($o_janhuren->getName (0)=='')
			{
				$o_stu->setJh_1_Connection('母亲');
				$o_stu->setJh_1_Name($o_janhuren->getName(1));
				$o_stu->setJh_1_Danwei($o_janhuren->getUnit(1));
				$o_stu->setJh_1_Phone($o_janhuren->getPhone(1));
			}else{
				$o_stu->setJh_1_Connection('父亲');
				$o_stu->setJh_1_Name($o_janhuren->getName(0));
				$o_stu->setJh_1_Danwei($o_janhuren->getUnit(0));
				$o_stu->setJh_1_Phone($o_janhuren->getPhone(0));
				$o_stu->setJh_2_Connection('母亲');
				$o_stu->setJh_2_Name($o_janhuren->getName(1));
				$o_stu->setJh_2_Danwei($o_janhuren->getUnit(1));
				$o_stu->setJh_2_Phone($o_janhuren->getPhone(1));
				if($o_janhuren->getName (2)!='')
				{
					$o_stu->setJianhuConnection($o_janhuren->getConnection(2));
					$o_stu->setJianhuName($o_janhuren->getName(2));
					$o_stu->setJianhuPhone($o_janhuren->getPhone(2));
				}
			}
		}
	}
?>
<div align="center" style="padding-top:30px;">
    <div class="title" style="padding-bottom:30px;">幼儿信息</div>
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
              <?php filter($o_session->getName())?>
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
          <?php filter($o_session->getYear().'-'.$o_session->getMonth().'-'.$o_session->getDay())?>
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
           是否独生子女
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
            <?php filter($o_stu->getH_City ().''.$o_stu->getH_Area ().''.$o_stu->getH_Street().''.$o_stu->getH_Shequ())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="5" style="font-weight:bold">
               户籍详细地址
            </td>
            <td colspan="15" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getH_Add ())?>
            </td>
        </tr>
        <tr style="font-weight:bold" class="layer">
            <td colspan="5" style="font-weight:bold">
               户主姓名
            </td>
            <td colspan="5" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getH_Owner ())?>
            </td>
            <td colspan="5" style="font-weight:bold">
	户主与幼儿关系
            </td>
            <td colspan="5" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getH_Guanxi ())?>
            </td>
        </tr>
		<tr style="font-weight:bold">
            <td colspan="6" style="font-weight:bold">
               现住址是否与户籍为同一地址
            </td>
            <td colspan="1" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getZ_Same())?>
            </td>
            <td colspan="3" style="font-weight:bold">
               现住址所在地
            </td>
            <td colspan="10" style="font-weight:normal;font-size:12px;">
          <?php filter($o_stu->getZ_City ().''.$o_stu->getZ_Area ().''.$o_stu->getZ_Street().''.$o_stu->getZ_Shequ())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="5" style="font-weight:bold">
               现住址详细地址
            </td>
            <td colspan="15" style="font-weight:normal;font-size:12px;">
            <?php filter($o_stu->getZ_Add ())?>
            </td>
        </tr>
        <tr style="font-weight:bold" class="layer">
            <td colspan="5" style="font-weight:bold">
               现住址房屋属性
            </td>
            <td colspan="3" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getZ_Property())?>
            </td>
            <td colspan="3" style="font-weight:bold">
	产权人姓名
            </td>
            <td colspan="3" style="font-weight:normal;font-size:12px;">
            <?php filter($o_stu->getZ_Owner())?>
            </td>
            <td colspan="4" style="font-weight:bold">
	产权人与孩子关系
            </td>
            <td colspan="2" style="font-weight:normal;font-size:12px;">
            <?php filter($o_stu->getZ_Guanxi())?>
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
              <?php filter($o_stu->getJh_1_Connection())?>
            </td>
            <td colspan="2">
           <?php filter($o_stu->getJh_1_Name())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getJh_1_IdType())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh_1_Id())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh_1_IsZhixi())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getJh_1_Job())?>
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
               <?php filter($o_stu->getJh_1_Jiaoyu())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getJh_1_Phone())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh_1_Danwei())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getJh_1_IsCanji())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh_1_CanjiCode())?>
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
              <?php filter($o_stu->getJh_2_Connection())?>
            </td>
            <td colspan="2">
           <?php filter($o_stu->getJh_2_Name())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getJh_2_IdType())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh_2_Id())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh_2_IsZhixi())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getJh_2_Job())?>
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
               <?php filter($o_stu->getJh_2_Jiaoyu())?>
            </td>
            <td colspan="3">
           <?php filter($o_stu->getJh_2_Phone())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh_2_Danwei())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getJh_2_IsCanji())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh_2_CanjiCode())?>
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

$mpdf->Output(iconv ( 'UTF-8', 'gbk','幼儿信息('.$s_file_name.').pdf'),'I');
exit;
?>
