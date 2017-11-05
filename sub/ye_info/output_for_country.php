<?php
error_reporting(0);
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120200 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$o_user = new Single_User ( $O_Session->getUid () );
if ($o_user->ValidModule ( MODULEID ) == false) {
	echo('No right.');
	exit ( 0 );//没有权限
}
require_once RELATIVITY_PATH . 'include/db_table.class.php';
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
$S_Filename = $s_file_name.'.xlsx';
OutputList ($_GET ['classid'],$S_Filename );
$file_dir = RELATIVITY_PATH . 'userdata/output/';
$rename = rawurlencode ( $S_Filename );
Header("Location: ".RELATIVITY_PATH."userdata/output/".$S_Filename); 
//跳转到下载

function OutputList($S_Class,$s_filename) {
	$s_filename=RELATIVITY_PATH . 'userdata/output/'.$s_filename;
	
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
	
	
	$o_dept = new Student_Onboard_Info();
	$o_dept->PushWhere ( array ('&&', 'State', '=', 1 ) );
	$o_dept->PushWhere ( array ('&&', 'ClassNumber', '=', $S_Class ) );
	$o_dept->PushOrder ( array ('Name', 'A' ) );
	$n_count = $o_dept->getAllCount ();
	
	for($i = 0; $i < $n_count; $i ++) {
		$n_row=$i+2;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$n_row, $o_dept->getName ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$n_row, '');
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$n_row, $o_dept->getSex ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$n_row, $o_dept->getBirthday ( $i ));
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
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$n_row, $o_dept->getHCity ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$n_row, $o_dept->getIdQuality ( $i ));
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$n_row, $o_dept->getIdQualityType  ( $i ));
			$objPHPExcel->getActiveSheet()->getStyle('O'.$n_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$n_row, "'".$o_dept->getHCode  ( $i ));
			if($o_dept->getZSame ( $i )=='是')
			{
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$n_row, $o_dept->getHAdd ( $i ));
			}else{
				$objPHPExcel->getActiveSheet()->SetCellValue('P'.$n_row, $o_dept->getZAdd ( $i ));
			}			
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
			$objPHPExcel->getActiveSheet()->SetCellValue('P'.$n_row, $o_dept->getZAdd ( $i ));
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
		$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$n_row, $o_dept->getJh1Name ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$n_row, $o_dept->getJh1IdType  ( $i ));
		$objPHPExcel->getActiveSheet()->getStyle('AB'.$n_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$n_row, "'".$o_dept->getJh1Id  ( $i ));	
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

?>