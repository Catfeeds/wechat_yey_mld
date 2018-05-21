<?php
define ( 'RELATIVITY_PATH', '../' );
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
if (isset ( $_COOKIE ['SESSIONID'] )) {//检查是否保存了Session
	//setcookie ( 'SESSIONID', '377be4f48492037e4815e5fe5774cf44',0 ,'/','',false,true);
	$S_Session_Id= $_COOKIE ['SESSIONID'];
} else {
	//如果Sessionid不存在，说明第一次打开，跳转到index页面去获得Sessionid
	$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
	echo ('<script>location=\''.RELATIVITY_PATH.'index.php?url='.$url.'\'</script>');
	exit ( 0 );
}
$s_openid=$_COOKIE ['VISITER'];
ob_start();
require_once RELATIVITY_PATH . 'include/db_table.class.php';
$o_wechat_signup=new Student_Info_Wechat_Wiew();
$o_wechat_signup->PushWhere ( array ('&&', 'OpenId', '=',$s_openid) );
$o_wechat_signup->PushWhere ( array ('&&', 'StudentId', '=',$_GET['id']) );
if ($o_wechat_signup->getAllCount()==0)
{
	echo('Error:Can not find record.');
	exit(0);
}
$o_stu=new Student_Info($_GET['id']);

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
    <div class="title">西城区马连道幼儿园报名信息登记表</div>
    <br/>
    <div style="padding-bottom:5px;"><strong>报名编号：</strong><?php filter($o_stu->getStudentId())?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>所报班别：</strong><?php filter($o_stu->getClassMode())?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>服从班级类型调剂：</strong><?php filter($o_stu->getCompliance())?></div>
    <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-left: solid 0px black;margin-top:-20px;">
<!--
        <tr style="font-weight:bold;font-size:16px;">
            <td colspan="20" style="padding:15px">
               基本信息
            </td>
        </tr>
        -->
        <tr style="font-weight:bold">
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
            <td style="width:5%;border-right: solid 0px black;border-left: solid 0px black;">
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="10" style="font-weight:bold;border-left: solid 1px black;">
               姓名
            </td>
            <td colspan="5" style="font-weight:bold;">
           性别
            </td>
            <td colspan="5" style="font-weight:bold;">
           出生日期
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="10" style="border-left: solid 1px black;">
              <?php filter($o_stu->getName())?>
            </td>
            <td colspan="5">
          <?php filter($o_stu->getSex())?>
            </td>
            <td colspan="5">
           <?php filter($o_stu->getBirthday())?>
            </td>
        </tr>        
        <tr style="font-weight:bold">
            <td colspan="4" style="font-weight:bold;border-left: solid 1px black;">
           证件类型
            </td>
            <td colspan="8" style="font-weight:bold;">
           证件号码
            </td>
            <td colspan="8" style="font-weight:bold;">
         接种医院
            </td>
        </tr>
        <tr style="font-size:12px;" class="layer">
            <td colspan="4" style="border-left: solid 1px black;">
           <?php filter($o_stu->getIdType())?>
            </td>
            <td colspan="8">
           <?php filter($o_stu->getId())?>
            </td>
            <td colspan="8">
           <?php filter($o_stu->getHospitalName())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="4" style="font-weight:bold;border-left: solid 1px black;">
               总体健康状况
            </td>
            <td colspan="4" style="font-weight:bold">
         是否有以往病史
            </td>
            <td colspan="4" style="font-weight:bold">
         以往病史
            </td>
            <td colspan="4" style="font-weight:bold">
          是否有过敏史
            </td>
            <td colspan="4" style="font-weight:bold">
        过敏源
            </td>
        </tr>
        <tr style="font-size:12px;" class="layer">
            <td colspan="4" style="border-left: solid 1px black;">
                <?php filter($o_stu->getJiankang())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getIsYiwang())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getIllness())?>
            </td>
            <td colspan="4">
         <?php filter($o_stu->getIsGuomin())?>
            </td>
            <td colspan="4">
         <?php filter($o_stu->getAllergic())?>
            </td>
        </tr>        
        <tr style="font-weight:bold">
            <td colspan="5" style="font-weight:bold;border-left: solid 1px black;">
               户籍
            </td>
            <td colspan="15" style="font-weight:normal;font-size:12px;">
            <?php filter($o_stu->getHCity ().''.$o_stu->getHArea ().''.$o_stu->getHStreet().''.$o_stu->getHShequ())?>
            </td>
        </tr>        
        <tr style="font-weight:bold">
        	<td colspan="5" style="font-weight:bold;border-left: solid 1px black;">
             是否集体户
            </td>
            <td colspan="5" style="font-weight:bold">
              户主与幼儿关系
            </td>
            <td colspan="4" style="font-weight:bold">
               幼儿与父母户籍一致
            </td>
            <td colspan="6" style="font-weight:bold">
               幼儿落户时间
            </td>
       </tr>
       <tr style="font-size:12px;">
            <td colspan="5" style="border-left: solid 1px black;">
              <?php filter($o_stu->getHIsGroup())?>
            </td>
            <td colspan="5">
           <?php filter($o_stu->getHGuanxi ())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getHIsYizhi ())?>
            </td>
            <td colspan="6">
           <?php filter($o_stu->getHInTime())?>
            </td>
        </tr>
        <tr style="font-weight:bold" class="layer">
            <td colspan="5" style="font-weight:bold;border-left: solid 1px black;">
              户籍地址
            </td>
            <td colspan="15" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getHAdd ());?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="5" style="font-weight:bold;border-left: solid 1px black;">
              现住址
            </td>
            <td colspan="15" style="font-weight:normal;font-size:12px;">
            <?php 
            if ($o_stu->getZSame()=='是')
            {
				filter($o_stu->getHCity ().''.$o_stu->getHArea ().''.$o_stu->getHStreet().''.$o_stu->getHShequ());
            }else{
            	filter($o_stu->getHCity ().''.$o_stu->getHArea ().''.$o_stu->getHStreet().''.$o_stu->getHShequ());
            }?>            
            </td>
        </tr>        
        <tr style="font-weight:bold">
        	<td colspan="7" style="font-weight:bold;border-left: solid 1px black;">
          现住址与户籍是否一致
            </td>
        	<td colspan="5" style="font-weight:bold;">
           现住址房屋属性
            </td>
            <td colspan="4" style="font-weight:bold">
              产权人
            </td>
            <td colspan="4" style="font-weight:bold">
               产权人与幼儿关系
            </td>
       </tr>
       <tr style="font-size:12px;">
            <td colspan="7" style="border-left: solid 1px black;">
              <?php filter($o_stu->getZSame())?>
            </td>
            <td colspan="5">
          <?php filter($o_stu->getZProperty())?>
            </td>
            <td colspan="4">
          <?php filter($o_stu->getZOwner())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getZGuanxi())?>
            </td>
        </tr>
       <tr style="font-weight:bold" class="layer">
            <td colspan="5" style="font-weight:bold;border-left: solid 1px black;">
               现住址地址
            </td>
            <td colspan="15" style="font-weight:normal;font-size:12px;">
           <?php 
           if ($o_stu->getZSame()=='是')
           {
           		filter($o_stu->getHAdd ());
           }else{
           		filter($o_stu->getZAdd ());
           }
           ?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td rowspan="4" colspan="4" style="border-bottom: solid 3px black;font-weight:bold;border-left: solid 1px black;">
           第一法定监护人
            </td>
            <td colspan="2" style="font-weight:bold">
               关系
            </td>
            <td colspan="4" style="font-weight:bold">
           姓名
            </td>
            <td colspan="10" style="font-weight:bold">
           职业状况
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="2" style="">
              <?php filter($o_stu->getJh1Connection())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh1Name())?>
            </td>           
            <td colspan="10">
          <?php filter($o_stu->getJh1Job())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="6" style="font-weight:bold;">
               教育程度
            </td>
            <td colspan="12" style="font-weight:bold">
           工作单位
            </td>
        </tr>
        <tr style="font-size:12px;" class="layer">
            <td colspan="6" style="">
               <?php filter($o_stu->getJh1Jiaoyu())?>
            </td>
            <td colspan="12">
           <?php filter($o_stu->getJh1Danwei())?>
            </td>
        </tr>    
        <tr style="font-weight:bold">
            <td rowspan="4" colspan="4" style="border-bottom: solid 3px black;font-weight:bold;border-left: solid 1px black;">
           第二法定监护人
            </td>
            <td colspan="2" style="font-weight:bold">
               关系
            </td>
            <td colspan="4" style="font-weight:bold">
           姓名
            </td>
            <td colspan="10" style="font-weight:bold">
           职业状况
            </td>
        </tr>
        <tr style="font-size:12px;">
            <td colspan="2" style="">
              <?php filter($o_stu->getJh2Connection())?>
            </td>
            <td colspan="4">
           <?php filter($o_stu->getJh2Name())?>
            </td>           
            <td colspan="10">
          <?php filter($o_stu->getJh2Job())?>
            </td>
        </tr>
        <tr style="font-weight:bold">
            <td colspan="6" style="font-weight:bold;">
               教育程度
            </td>
            <td colspan="12" style="font-weight:bold">
           工作单位
            </td>
        </tr>
        <tr style="font-size:12px;" class="layer">
            <td colspan="6" style="">
               <?php filter($o_stu->getJh2Jiaoyu())?>
            </td>
            <td colspan="12">
           <?php filter($o_stu->getJh2Danwei())?>
            </td>
        </tr>  
        <tr style="font-weight:bold" class="layer">
            <td colspan="4" style="font-weight:bold;border-left: solid 1px black;">
              移动电话
            </td>
            <td colspan="6" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getSignupPhone ());?>
            </td>
            <td colspan="4" style="font-weight:bold;">
              固定电话
            </td>
            <td colspan="6" style="font-weight:normal;font-size:12px;">
           <?php filter($o_stu->getSignupPhoneBackup());?>
            </td>
        </tr> 
        <tr style="font-weight:bold">
            <td colspan="20" style="height:200px;border-left: solid 1px black;text-align:right;padding-right:120px;vertical-align:bottom;padding-bottom:20px;">
          		 家长签字:
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

$mpdf->Output(iconv ( 'UTF-8', 'gbk','报名信息登记表('.$o_stu->getName().').pdf'),'I');
exit;
?>
