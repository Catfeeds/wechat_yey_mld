<?php
error_reporting(0);
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120100 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$o_user = new Single_User ( $O_Session->getUid () );
if ($o_user->ValidModule ( MODULEID ) == false) {
	exit ( 0 );
}
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$s_file_name='幼儿报名信息列表';
$S_State=1;
if (isset ( $_GET ['state'] )) {
	$S_State=$_GET ['state'];
}
$S_Filename = $s_file_name.'.xlsx';
OutputList ( $S_State,$S_Filename );
$file_name = 'ready'.$S_State.'.csv';
$file_dir = RELATIVITY_PATH . '/sub/admission/output/';
$rename = rawurlencode ( $S_Filename );
Header("Location: output/".$S_Filename); 
//echo('<script>location="output/'.$S_Filename.'"</script>');
//跳转到下载  http://wx.mldyey.com/sub/admission/output_all_temp.php?state=5
function get_column_number($column,$row)
{
	$a_number=array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	//先除以24，然后取整
	//echo(floor($column/24));
	if ($column>26)
	{
		if ($column%26==0)
		{
			return $a_number[floor($column/26)-1].$a_number[26].$row;
		}else{
			return $a_number[floor($column/26)].$a_number[$column%26].$row;
		}
	}else{
		return $a_number[$column].$row;
	}
}
function OutputList($S_State,$s_filename) {
	require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
	$o_setup_audit=new Wechat_Wx_Setup('MSGTMP_02');
	$o_setup_meet=new Wechat_Wx_Setup('MSGTMP_03');
	$o_setup_health=new Wechat_Wx_Setup('MSGTMP_04');
	$n_counter=1;
	$s_filename='output/'.$s_filename;
	
	/** Include path **/
	ini_set('include_path', ini_get('include_path').'../Classes/');
	
	/** PHPExcel */
	require_once RELATIVITY_PATH .'include/PHPExcel.php';
	
	/** PHPExcel_Writer_Excel2007 */
	require_once RELATIVITY_PATH .'include/PHPExcel/Writer/Excel2007.php';
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
	$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
	$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
	
	
	// Add some data
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '编号');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '姓名');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '身份证类型');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '身份证号码');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '性别');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '出生日期');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '国籍');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '民族');$n_counter++;
	//健康信息
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '总体健康状况');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '预防接种医院');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '是否有以往病史');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '以往病史');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '是否有过敏史');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '过敏源');$n_counter++;
	//户籍信息
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '户籍所在（省/市）');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '户籍所在（市/区）');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '户籍所在街道');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '户籍所在社区');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '户籍是否为集体户');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '户主与幼儿关系');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '幼儿与父母户籍一致');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '幼儿落户时间');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '户籍详细地址');$n_counter++;
	//现住址信息
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '现住址是否与户籍为同一地址');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '现住址所在省市');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '现住址所在区');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '现住址所在街道');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '现住址所在社区');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '现住址详细地址');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '现住址房屋属性');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '产权人姓名');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '产权人与孩子关系');$n_counter++;
	
	//第一监护人信息
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '第一法定监护人与幼儿关系');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '第一法定监护人姓名');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '第一法定监护人职业状况');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '第一法定监护人教育程度');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '第一法定监护人工作单位');$n_counter++;
	//第二监护人信息
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '第二法定监护人与幼儿关系');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '第二法定监护人姓名');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '第二法定监护人职业状况');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '第二法定监护人教育程度');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '第二法定监护人工作单位');$n_counter++;
	//联系信息
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '监护人手机号');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '家庭固定电话');$n_counter++;
	//班级信息
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '报名班级类型');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '是否服从班级类型调剂');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '信息核验时段');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '信息核验员');$n_counter++;
	$o_question=new Student_Audit_Question();
	$o_question->PushOrder ( array ('Number','A') );   
	for($i=0;$i<$o_question->getAllCount();$i++)
	{
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), $o_question->getText($i));$n_counter++;
	}
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '核验备注');$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '见面时段');$n_counter++;
	//如果是3，已见面，那么要添加相应的列
	if($S_State>=3)
	{
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '幼儿见面审核员');$n_counter++;
		$o_item=new Student_Info_Meet_Item();
		$o_item->PushWhere ( array ('&&', 'Type', '=','幼儿见面') ); 
	    $o_item->PushOrder ( array ('Number','A') );
	    for($i=0;$i<$o_item->getAllCount();$i++)
	    {
	    	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), $o_item->getType($i).'-'.$o_item->getName($i));$n_counter++;
	    }
	    $objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1),'幼儿见面-备注');$n_counter++;
	    $objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '家长见面审核员');$n_counter++;
		$o_item=new Student_Info_Meet_Item();
		$o_item->PushWhere ( array ('&&', 'Type', '=','家长见面') ); 
	    $o_item->PushOrder ( array ('Number','A') );
	    $n_temp=$i+2;
	    for($i=0;$i<$o_item->getAllCount();$i++)
	    {
	    	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), $o_item->getType($i).'-'.$o_item->getName($i));$n_counter++;
	    }
	    $objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1),'家长见面-备注');$n_counter++;
	}
	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,1), '体检时段');$n_counter++;
	$o_dept = new Student_Info ();
	$o_dept->PushWhere ( array ('&&', 'State', '=', $S_State ) );
	$o_dept->PushOrder ( array ('StudentId', 'A' ) );
	$n_count = $o_dept->getAllCount ();
	for($i = 0; $i < $n_count; $i ++) {
		$n_counter=1;
		$n_row=$i+2;
		//基本信息
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getStudentId ( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getName ( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getIdType ( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->getStyle(get_column_number($n_counter,$n_row))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->setCellValue(get_column_number($n_counter,$n_row),"'".$o_dept->getId ( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getSex ( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getBirthday ( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getNationality( $i ));$n_counter++;
		if ($o_dept->getNationality( $i )=="中国")
		{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getNation( $i ));$n_counter++;
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '');$n_counter++;
		}
		//健康信息
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJiankang ( $i ) );$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHospitalName( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getIsYiwang ( $i ) );$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getIllness ( $i ) );$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getIsGuomin ( $i ) );$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getAllergic ( $i ) );$n_counter++;
		//户籍信息
		if ($o_dept->getNationality( $i )=="中国")
		{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHCity( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHArea( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHStreet( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHShequ( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHIsGroup( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHGuanxi( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHIsYizhi( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHInTime( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHAdd( $i ));$n_counter++;
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '');$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '');$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '');$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '');$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '');$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '');$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '');$n_counter++;
		}
		//现住址信息
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getZSame( $i ));$n_counter++;
		if ($o_dept->getZSame( $i )=="否")
		{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getZCity( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getZArea( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getZStreet( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getZShequ( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getZAdd( $i ));$n_counter++;
			
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHCity( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHArea( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHStreet( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHShequ( $i ));$n_counter++;
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getHAdd( $i ));$n_counter++;
		}
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getZProperty( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getZOwner( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getZGuanxi( $i ));$n_counter++;
		//第一监护人信息
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJh1Connection( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJh1Name( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJh1Job( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJh1Jiaoyu( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJh1Danwei( $i ));$n_counter++;
		//第二监护人信息
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJh2Connection( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJh2Name( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJh2Job( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJh2Jiaoyu( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getJh2Danwei( $i ));$n_counter++;
		//联系信息
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getSignupPhone( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getSignupPhoneBackup( $i ));$n_counter++;
		//附加信息信息		
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getClassMode( $i ));$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getCompliance( $i ));$n_counter++;
		//查找消息提醒的信息核验提醒
		$o_reminder=new Wechat_Wx_User_Reminder();
		$o_reminder->PushWhere ( array ('&&', 'Keyword1', '=', $o_dept->getStudentId( $i ) ) );
		$o_reminder->PushWhere ( array ('&&', 'MsgId', '=',$o_setup_audit->getValue()) );
		$o_reminder->PushOrder ( array ('Id', 'D' ) );
		if ($o_reminder->getAllCount()>0)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_reminder->getKeyword3(0).' '.$o_reminder->getKeyword4(0));$n_counter++;
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '无');$n_counter++;
		}	
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getAuditorName( $i ));$n_counter++;
		$a_option=json_decode($o_dept->getAuditOption( $i ));
		if (count($a_option)>0)
		{
			for($j=0;$j<count($a_option);$j++)
			{
				$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row),rawurldecode($a_option[$j]));$n_counter++;
			}
		}else{
			for($j=0;$j<$o_question->getAllCount();$j++)
			{
				$n_counter++;
			}
		}	
		$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_dept->getAuditRemark( $i ));$n_counter++;
		//查找见面提醒的信息核验提醒
		$o_reminder=new Wechat_Wx_User_Reminder();
		$o_reminder->PushWhere ( array ('&&', 'Keyword1', '=', $o_dept->getStudentId( $i ) ) );
		$o_reminder->PushWhere ( array ('&&', 'MsgId', '=',$o_setup_meet->getValue()) );
		$o_reminder->PushOrder ( array ('Id', 'D' ) );
		if ($o_reminder->getAllCount()>0)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_reminder->getKeyword3(0).' '.$o_reminder->getKeyword4(0));$n_counter++;
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '无');$n_counter++;
		}
		if($S_State>=3)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row),$o_dept->getMeetAuditorName( $i ));$n_counter++;
			//读取幼儿的见面结果
			$a_result=json_decode($o_dept->getMeetItem($i));
		    for($j=0;$j<count($a_result);$j++)
		    {
		    	$a_temp=$a_result[$j];
		    	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row),$a_temp->value);$n_counter++;	
		    }
		    $objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row),$o_dept->getMeetRemark($i));$n_counter++;
		    $objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row),$o_dept->getMeetParentAuditorName( $i ));$n_counter++;
			//读取幼儿的见面结果
			$a_result=json_decode($o_dept->getMeetParentItem($i));
		    for($j=0;$j<count($a_result);$j++)
		    {
		    	$a_temp=$a_result[$j];
		    	$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row),$a_temp->value);$n_counter++;	    	
		    }
		    $objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row),$o_dept->getMeetParentRemark($i));$n_counter++;
		}
		//查找体检提醒的信息核验提醒
		$o_reminder=new Wechat_Wx_User_Reminder();
		$o_reminder->PushWhere ( array ('&&', 'Keyword1', '=', $o_dept->getStudentId( $i ) ) );
		$o_reminder->PushWhere ( array ('&&', 'MsgId', '=',$o_setup_health->getValue()) );
		$o_reminder->PushOrder ( array ('Id', 'D' ) );
		if ($o_reminder->getAllCount()>0)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), $o_reminder->getKeyword3(0).' '.$o_reminder->getKeyword4(0));$n_counter++;
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue(get_column_number($n_counter,$n_row), '无');$n_counter++;
		}
	}	
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save(iconv ( 'UTF-8',getEncode(),$s_filename));
	return;


}
	function getEncode()
	{
		if (strtoupper(substr(PHP_OS, 0,3)) === 'WIN') {
			$config['system_os']='windows';
			//return $this->getEncode();//user set your server system charset
		} else {
			//$config['system_os']='linux';
			return 'utf-8';
		}
	}
function SetTotalInfo($var1, $var2, $var3, $var4, $file) {
	$a_item = array ();
	array_push ( $a_item, iconv ( 'UTF-8', 'gbk', $var1 ) );
	array_push ( $a_item, iconv ( 'UTF-8', 'gbk', $var2 ) );
	array_push ( $a_item, iconv ( 'UTF-8', 'gbk', $var3 ) );
	array_push ( $a_item, iconv ( 'UTF-8', 'gbk', $var4 ) );
	fputcsv ( $file, $a_item );
}
?>