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
$s_file_name='幼儿信息采集列表';
$S_State=6;
$S_Filename = $s_file_name.'.xlsx';
OutputList ( $S_State,$S_Filename );
$file_name = 'ready'.$S_State.'.csv';
$file_dir = RELATIVITY_PATH . '/sub/admission/output/';
$rename = rawurlencode ( $S_Filename );
Header("Location: output/".$S_Filename); 
//echo('<script>location="output/'.$S_Filename.'"</script>');
//跳转到下载

function OutputList($S_State,$s_filename) {
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
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', '编号');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', '姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', '身份证类型');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', '身份证号码');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', '性别');
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', '出生日期');
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', '国籍');
	$objPHPExcel->getActiveSheet()->SetCellValue('H1', '民族');
	$objPHPExcel->getActiveSheet()->SetCellValue('I1', '港澳台侨');
	$objPHPExcel->getActiveSheet()->SetCellValue('J1', '是否有独生子女证');
	$objPHPExcel->getActiveSheet()->SetCellValue('K1', '独生子女证号');
	$objPHPExcel->getActiveSheet()->SetCellValue('L1', '是否头胎');
	$objPHPExcel->getActiveSheet()->SetCellValue('M1', '是否烈士子女');
	$objPHPExcel->getActiveSheet()->SetCellValue('N1', '是否孤儿');
	$objPHPExcel->getActiveSheet()->SetCellValue('O1', '是否进城务工人员随迁子女');
	$objPHPExcel->getActiveSheet()->SetCellValue('P1', '是否留守儿童');
	$objPHPExcel->getActiveSheet()->SetCellValue('Q1', '是否低保');
	$objPHPExcel->getActiveSheet()->SetCellValue('R1', '低保证号');
	$objPHPExcel->getActiveSheet()->SetCellValue('S1', '是否正在接收资助');
	$objPHPExcel->getActiveSheet()->SetCellValue('T1', '是否残疾儿童');
	$objPHPExcel->getActiveSheet()->SetCellValue('U1', '残疾幼儿类别');
	$objPHPExcel->getActiveSheet()->SetCellValue('V1', '残疾证号');
	//健康信息
	$objPHPExcel->getActiveSheet()->SetCellValue('W1', '总体健康状况');
	$objPHPExcel->getActiveSheet()->SetCellValue('X1', '预防接种医院');
	$objPHPExcel->getActiveSheet()->SetCellValue('Y1', '血型');
	$objPHPExcel->getActiveSheet()->SetCellValue('Z1', '是否有以往病史');
	$objPHPExcel->getActiveSheet()->SetCellValue('AA1', '以往病史');
	$objPHPExcel->getActiveSheet()->SetCellValue('AB1', '是否有手术史');
	$objPHPExcel->getActiveSheet()->SetCellValue('AC1', '手术名称');
	$objPHPExcel->getActiveSheet()->SetCellValue('AD1', '是否有器官移植史');
	$objPHPExcel->getActiveSheet()->SetCellValue('AE1', '是否有过敏史');
	$objPHPExcel->getActiveSheet()->SetCellValue('AF1', '过敏源');
	$objPHPExcel->getActiveSheet()->SetCellValue('AG1', '是否有族遗传病史');
	$objPHPExcel->getActiveSheet()->SetCellValue('AH1', '家族遗传病史名称');
	$objPHPExcel->getActiveSheet()->SetCellValue('AI1', '备注');	
	//户籍信息
	$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', '出生地');
	$objPHPExcel->getActiveSheet()->SetCellValue('AK1', '户口性质');
	$objPHPExcel->getActiveSheet()->SetCellValue('AL1', '非农业户口类型');
	$objPHPExcel->getActiveSheet()->SetCellValue('AM1', '户籍所在（省/市）');
	$objPHPExcel->getActiveSheet()->SetCellValue('AN1', '户籍所在（市/区）');
	$objPHPExcel->getActiveSheet()->SetCellValue('AO1', '户籍所在街道');
	$objPHPExcel->getActiveSheet()->SetCellValue('AP1', '户籍所在社区');
	$objPHPExcel->getActiveSheet()->SetCellValue('AQ1', '户籍详细地址');
	$objPHPExcel->getActiveSheet()->SetCellValue('AR1', '户主姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('AS1', '户主与幼儿关系');
	//现住址信息
	$objPHPExcel->getActiveSheet()->SetCellValue('AT1', '现住址是否与户籍为同一地址');
	$objPHPExcel->getActiveSheet()->SetCellValue('AU1', '现住址所在省市');
	$objPHPExcel->getActiveSheet()->SetCellValue('AV1', '现住址所在区');
	$objPHPExcel->getActiveSheet()->SetCellValue('AW1', '现住址所在街道');
	$objPHPExcel->getActiveSheet()->SetCellValue('AX1', '现住址所在社区');
	$objPHPExcel->getActiveSheet()->SetCellValue('AY1', '现住址详细地址');
	$objPHPExcel->getActiveSheet()->SetCellValue('AZ1', '现住址房屋属性');
	$objPHPExcel->getActiveSheet()->SetCellValue('BA1', '产权人姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('BB1', '产权人与孩子关系');
	
	//第一监护人信息
	$objPHPExcel->getActiveSheet()->SetCellValue('BC1', '第一法定监护人与幼儿关系');
	$objPHPExcel->getActiveSheet()->SetCellValue('BD1', '第一法定监护人姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('BE1', '第一法定监护人证件类型');
	$objPHPExcel->getActiveSheet()->SetCellValue('BF1', '第一法定监护人证件号码');
	$objPHPExcel->getActiveSheet()->SetCellValue('BG1', '第一法定监护人是否是直系亲属');
	$objPHPExcel->getActiveSheet()->SetCellValue('BH1', '第一法定监护人职业状况');
	$objPHPExcel->getActiveSheet()->SetCellValue('BI1', '第一法定监护人教育程度');
	$objPHPExcel->getActiveSheet()->SetCellValue('BJ1', '第一法定监护人联系电话');
	$objPHPExcel->getActiveSheet()->SetCellValue('BK1', '第一法定监护人工作单位');
	$objPHPExcel->getActiveSheet()->SetCellValue('BL1', '第一法定监护人是否残疾');
	$objPHPExcel->getActiveSheet()->SetCellValue('BM1', '第一法定监护人残疾证号');
	//第二监护人信息
	$objPHPExcel->getActiveSheet()->SetCellValue('BN1', '第二法定监护人与幼儿关系');
	$objPHPExcel->getActiveSheet()->SetCellValue('BO1', '第二法定监护人姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('BP1', '第二法定监护人证件类型');
	$objPHPExcel->getActiveSheet()->SetCellValue('BQ1', '第二法定监护人证件号码');
	$objPHPExcel->getActiveSheet()->SetCellValue('BR1', '第二法定监护人是否是直系亲属');
	$objPHPExcel->getActiveSheet()->SetCellValue('BS1', '第二法定监护人职业状况');
	$objPHPExcel->getActiveSheet()->SetCellValue('BT1', '第二法定监护人教育程度');
	$objPHPExcel->getActiveSheet()->SetCellValue('BU1', '第二法定监护人联系电话');
	$objPHPExcel->getActiveSheet()->SetCellValue('BV1', '第二法定监护人工作单位');
	$objPHPExcel->getActiveSheet()->SetCellValue('BW1', '第二法定监护人是否残疾');
	$objPHPExcel->getActiveSheet()->SetCellValue('BX1', '第二法定监护人残疾证号');
	//其他监护人
	$objPHPExcel->getActiveSheet()->SetCellValue('BY1', '其他监护人关系');
	$objPHPExcel->getActiveSheet()->SetCellValue('BZ1', '其他监护人姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('CA1', '其他监护人联系电话');
	//班级信息
	$objPHPExcel->getActiveSheet()->SetCellValue('CB1', '报名班级类型');
	$objPHPExcel->getActiveSheet()->SetCellValue('CC1', '是否服从班级类型调剂');
	//$objPHPExcel->getActiveSheet()->SetCellValue('CD1', '信息核验员');
	/*
	$a_item=array('AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI');
	//如果是3，已见面，那么要添加相应的列
	if($S_State>=3)
	{
		$objPHPExcel->getActiveSheet()->SetCellValue('AP1', '幼儿见面审核员');
		$o_item=new Student_Info_Meet_Item();
		$o_item->PushWhere ( array ('&&', 'Type', '=','幼儿见面') ); 
	    $o_item->PushOrder ( array ('Number','A') );
	    for($i=0;$i<$o_item->getAllCount();$i++)
	    {
	    	$objPHPExcel->getActiveSheet()->SetCellValue($a_item[$i].'1', $o_item->getType($i).'-'.$o_item->getName($i));
	    }
	    $objPHPExcel->getActiveSheet()->SetCellValue($a_item[$i].'1','幼儿见面-备注');
	    $objPHPExcel->getActiveSheet()->SetCellValue($a_item[($i+1)].'1', '家长见面审核员');
		$o_item=new Student_Info_Meet_Item();
		$o_item->PushWhere ( array ('&&', 'Type', '=','家长见面') ); 
	    $o_item->PushOrder ( array ('Number','A') );
	    $n_temp=$i+2;
	    for($i=0;$i<$o_item->getAllCount();$i++)
	    {
	    	$objPHPExcel->getActiveSheet()->SetCellValue($a_item[($i+$n_temp)].'1', $o_item->getType($i).'-'.$o_item->getName($i));
	    }
	    $objPHPExcel->getActiveSheet()->SetCellValue($a_item[($i+$n_temp)].'1','家长见面-备注');
	}
	*/
	$o_dept = new Student_Info ();
	$o_dept->PushWhere ( array ('&&', 'State', '=', $S_State ) );
	$o_dept->PushOrder ( array ('StudentId', 'A' ) );
	$n_count = $o_dept->getAllCount ();
	for($i = 0; $i < $n_count; $i ++) {
		$n_row=$i+2;
		//基本信息
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$n_row, $o_dept->getStudentId ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$n_row, $o_dept->getName ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$n_row, $o_dept->getIdType ( $i ));
		$objPHPExcel->getActiveSheet()->getStyle('D'.$n_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$n_row,"'".$o_dept->getId ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$n_row, $o_dept->getSex ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$n_row, $o_dept->getBirthday ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$n_row, $o_dept->getNationality( $i ));
		if ($o_dept->getNationality( $i )=="中国")
		{	
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$n_row, $o_dept->getNation( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$n_row, $o_dept->getGangao( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$n_row, $o_dept->getOnly( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$n_row, $o_dept->getOnlyCode( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$n_row, $o_dept->getIsFirst( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$n_row, $o_dept->getIsLieshi( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$n_row, $o_dept->getIsGuer( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$n_row, $o_dept->getIsWugong( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$n_row, $o_dept->getIsLiushou( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$n_row, $o_dept->getIsDibao( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$n_row, $o_dept->getDibaoCode( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$n_row, $o_dept->getIsZizhu( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$n_row, $o_dept->getIsCanji( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$n_row, $o_dept->getCanjiType( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$n_row, $o_dept->getCanjiCode( $i ));
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$n_row, $o_dept->getGangao( $i ));			
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$n_row, '');
		}
		//健康信息
		$objPHPExcel->getActiveSheet()->SetCellValue('W'.$n_row, $o_dept->getJiankang( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('X'.$n_row, $o_dept->getHospitalName( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$n_row, $o_dept->getXuexing( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$n_row, $o_dept->getIsYiwang( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$n_row, $o_dept->getIllness( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$n_row, $o_dept->getIsShoushu( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$n_row, $o_dept->getShoushu( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AD'.$n_row, $o_dept->getIsYizhi( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$n_row, $o_dept->getIsGuomin( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AF'.$n_row, $o_dept->getAllergic( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AG'.$n_row, $o_dept->getIsYichuan( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AH'.$n_row, $o_dept->getQitabingshi( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AI'.$n_row, $o_dept->getBeizhu( $i ));	

		//户籍信息
		if ($o_dept->getNationality( $i )=="中国")
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$n_row, $o_dept->getBirthplace( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AK'.$n_row, $o_dept->getIdQuality( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AL'.$n_row, $o_dept->getIdQualityType( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AM'.$n_row, $o_dept->getHCity( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AN'.$n_row, $o_dept->getHArea( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AO'.$n_row, $o_dept->getHStreet( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AP'.$n_row, $o_dept->getHShequ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$n_row, $o_dept->getHAdd( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AR'.$n_row, $o_dept->getHOwner( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AS'.$n_row, $o_dept->getHGuanxi( $i ));
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('AK'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('AL'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('AM'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('AN'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('AO'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('AP'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('AR'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('AS'.$n_row, '');
		}
		//现住址信息
		$objPHPExcel->getActiveSheet()->SetCellValue('AT'.$n_row, $o_dept->getZSame( $i ));
		if ($o_dept->getZSame( $i )=="否")
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('AU'.$n_row, $o_dept->getZCity( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AV'.$n_row, $o_dept->getZArea( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AW'.$n_row, $o_dept->getZStreet( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AX'.$n_row, $o_dept->getZShequ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AY'.$n_row, $o_dept->getZAdd( $i ));
			
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('AU'.$n_row, $o_dept->getHCity( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AV'.$n_row, $o_dept->getHArea( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AW'.$n_row, $o_dept->getHStreet( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AX'.$n_row, $o_dept->getHShequ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('AY'.$n_row, $o_dept->getHAdd( $i ));
		}
		$objPHPExcel->getActiveSheet()->SetCellValue('AZ'.$n_row, $o_dept->getZProperty( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BA'.$n_row, $o_dept->getZOwner( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BB'.$n_row, $o_dept->getZGuanxi( $i ));
		//第一监护人信息
		$objPHPExcel->getActiveSheet()->SetCellValue('BC'.$n_row, $o_dept->getJh1Connection( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BD'.$n_row, $o_dept->getJh1Name( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BE'.$n_row, $o_dept->getJh1IdType( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BF'.$n_row, $o_dept->getJh1Id( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BG'.$n_row, $o_dept->getJh1IsZhixi( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BH'.$n_row, $o_dept->getJh1Job( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BI'.$n_row, $o_dept->getJh1Jiaoyu( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BJ'.$n_row, $o_dept->getJh1Phone( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BK'.$n_row, $o_dept->getJh1Danwei( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BL'.$n_row, $o_dept->getJh1IsCanji( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BM'.$n_row, $o_dept->getJh1CanjiCode( $i ));
		//第二监护人信息
		$objPHPExcel->getActiveSheet()->SetCellValue('BN'.$n_row, $o_dept->getJh2Connection( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BO'.$n_row, $o_dept->getJh2Name( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BP'.$n_row, $o_dept->getJh2IdType( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BQ'.$n_row, $o_dept->getJh2Id( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BR'.$n_row, $o_dept->getJh2IsZhixi( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BS'.$n_row, $o_dept->getJh2Job( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BT'.$n_row, $o_dept->getJh2Jiaoyu( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BU'.$n_row, $o_dept->getJh2Phone( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BV'.$n_row, $o_dept->getJh2Danwei( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BW'.$n_row, $o_dept->getJh2IsCanji( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BX'.$n_row, $o_dept->getJh2CanjiCode( $i ));
		//其他监护人
		$objPHPExcel->getActiveSheet()->SetCellValue('BY'.$n_row, $o_dept->getJianhuConnection( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('BZ'.$n_row, $o_dept->getJianhuName( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('CA'.$n_row, $o_dept->getJianhuPhone( $i ));
		//班级信息
		$objPHPExcel->getActiveSheet()->SetCellValue('CB'.$n_row, $o_dept->getClassMode( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('CC'.$n_row, $o_dept->getCompliance( $i ));
		//$objPHPExcel->getActiveSheet()->SetCellValue('CD'.$n_row, $o_dept->getAuditorName( $i ));

		/*
		if($S_State>=3)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('AP'.$n_row,$o_dept->getMeetAuditorName( $i ));
			//读取幼儿的见面结果
			$a_result=json_decode($o_dept->getMeetItem($i));
		    for($j=0;$j<count($a_result);$j++)
		    {
		    	$a_temp=$a_result[$j];
		    	$objPHPExcel->getActiveSheet()->SetCellValue($a_item[$j].$n_row,$a_temp->value);		    	
		    }
		    $objPHPExcel->getActiveSheet()->SetCellValue($a_item[$j].$n_row,$o_dept->getMeetRemark($i));
		    $objPHPExcel->getActiveSheet()->SetCellValue($a_item[($j+1)].$n_row,$o_dept->getMeetParentAuditorName( $i ));
		    $n_temp=$j+2;
			//读取幼儿的见面结果
			$a_result=json_decode($o_dept->getMeetParentItem($i));
		    for($j=0;$j<count($a_result);$j++)
		    {
		    	$a_temp=$a_result[$j];
		    	$objPHPExcel->getActiveSheet()->SetCellValue($a_item[($j+$n_temp)].$n_row,$a_temp->value);		    	
		    }
		    $objPHPExcel->getActiveSheet()->SetCellValue($a_item[($j+$n_temp)].$n_row,$o_dept->getMeetParentRemark($i));
		}*/
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