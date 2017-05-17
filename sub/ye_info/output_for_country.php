<?php
error_reporting(0);
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120200 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';

$o_user = new Single_User ( $O_Session->getUid () );
if ($o_user->ValidModule ( MODULEID ) == false) {
	exit ( 0 );
}
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
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
$S_Filename = $s_file_name.'.xlsx';
OutputList ( $S_Type, $S_Grade, $S_Class, $o_user,$S_Filename );
$file_name = 'ready'.$S_Type.'.csv';
$file_dir = RELATIVITY_PATH . '/sub/yeinfo/output/';
$rename = rawurlencode ( $S_Filename );
Header("Location: output/".$S_Filename); 
//echo('<script>location="output/'.$S_Filename.'"</script>');
//跳转到下载

function OutputList($n_deptid, $S_Grade, $S_Class, $o_user,$s_filename) {
	$s_filename='output/'.$s_filename;
	
	/** Include path **/
	ini_set('include_path', ini_get('include_path').';../Classes/');
	
	/** PHPExcel */
	include 'Classes/PHPExcel.php';
	
	/** PHPExcel_Writer_Excel2007 */
	include 'Classes/PHPExcel/Writer/Excel2007.php';
	
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
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', '姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', '班级编码');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', '性别');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', '出生日期');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', '身份证类型');
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', '身份证号码');
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', '血型');
	$objPHPExcel->getActiveSheet()->SetCellValue('H1', '国籍/地区');
	$objPHPExcel->getActiveSheet()->SetCellValue('I1', '民族');
	$objPHPExcel->getActiveSheet()->SetCellValue('J1', '港澳台侨外');
	$objPHPExcel->getActiveSheet()->SetCellValue('K1', '出生所在地');
	$objPHPExcel->getActiveSheet()->SetCellValue('L1', '籍贯');
	$objPHPExcel->getActiveSheet()->SetCellValue('M1', '户口性质');
	$objPHPExcel->getActiveSheet()->SetCellValue('N1', '非农业户口类型');
	$objPHPExcel->getActiveSheet()->SetCellValue('O1', '户口所在地');
	$objPHPExcel->getActiveSheet()->SetCellValue('P1', '现住址');
	$objPHPExcel->getActiveSheet()->SetCellValue('Q1', '入园日期');
	$objPHPExcel->getActiveSheet()->SetCellValue('R1', '就读方式');
	$objPHPExcel->getActiveSheet()->SetCellValue('S1', '是否独生子女');
	$objPHPExcel->getActiveSheet()->SetCellValue('T1', '是否留守儿童');
	$objPHPExcel->getActiveSheet()->SetCellValue('U1', '是否进城务工人员子女');
	$objPHPExcel->getActiveSheet()->SetCellValue('V1', '健康状况');
	$objPHPExcel->getActiveSheet()->SetCellValue('W1', '是否残疾幼儿');
	$objPHPExcel->getActiveSheet()->SetCellValue('X1', '残疾幼儿类别');
	$objPHPExcel->getActiveSheet()->SetCellValue('Y1', '是否孤儿');
	$objPHPExcel->getActiveSheet()->SetCellValue('Z1', '监护人姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('AA1', '监护人身份证件类型');
	$objPHPExcel->getActiveSheet()->SetCellValue('AB1', '监护人身份证件号码');
	
	
	$o_dept = new View_Student_Info ();
	$dept_id = $o_user->getDeptId ();
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
	
	for($i = 0; $i < $n_count; $i ++) {
		$n_row=$i+2;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$n_row, $o_dept->getName ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$n_row, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$n_row, $o_dept->getSex ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$n_row, $o_dept->getYear ( $i ) . '-' . $o_dept->getMonth ( $i ) . '-' . $o_dept->getDay ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$n_row, $o_dept->getIdType ( $i ));
		$objPHPExcel->getActiveSheet()->getStyle('F'.$n_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$n_row,"'".$o_dept->getId ( $i ));
		
		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$n_row, $o_dept->getXuexing( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$n_row, $o_dept->getNationality( $i ));
		if ($o_dept->getNationality( $i )=="中国")
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$n_row, $o_dept->getNation ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$n_row, $o_dept->getGangao ( $i ) );
			$objPHPExcel->getActiveSheet()->getStyle('K'.$n_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$n_row, "'".$o_dept->getBirthplaceCode($i));
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$n_row, $o_dept->getH_City ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$n_row, $o_dept->getIdQuality ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$n_row, $o_dept->getIdQualityType  ( $i ));
			$objPHPExcel->getActiveSheet()->getStyle('O'.$n_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$n_row, "'".$o_dept->getH_Code  ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$n_row, $o_dept->getZ_Add ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$n_row, $o_dept->getInTime ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$n_row, $o_dept->getJiudu ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$n_row, $o_dept->getOnly ( $i ) );
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$n_row, $o_dept->getIsLiushou  ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$n_row, $o_dept->getIsWugong ( $i ));
		}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$n_row, $o_dept->getGangao ( $i ) );
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$n_row, $o_dept->getZ_Add ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$n_row, $o_dept->getInTime ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$n_row, $o_dept->getJiudu ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$n_row, '' );
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$n_row, '');
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$n_row, '');
		}	
		$objPHPExcel->getActiveSheet()->SetCellValue('V'.$n_row, $o_dept->getJiankang ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('W'.$n_row, $o_dept->getIsCanji ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('X'.$n_row, $o_dept->getCanjiType ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$n_row, $o_dept->getIsGuer ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$n_row, $o_dept->getJh_1_Name ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$n_row, $o_dept->getJh_1_IdType  ( $i ));
		$objPHPExcel->getActiveSheet()->getStyle('AB'.$n_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$n_row, "'".$o_dept->getJh_1_Id  ( $i ));	
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