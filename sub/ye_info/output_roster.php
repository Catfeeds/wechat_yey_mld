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
	$o_class=new Student_Class($S_Class);
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
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', $o_class->getClassName());
	$objPHPExcel->getActiveSheet()->SetCellValue('A2', '序号');
	$objPHPExcel->getActiveSheet()->SetCellValue('B2', '姓名');
	$objPHPExcel->getActiveSheet()->SetCellValue('C2', '性别');
	$objPHPExcel->getActiveSheet()->SetCellValue('D2', '出生日期');
	$objPHPExcel->getActiveSheet()->SetCellValue('E2', '民族');
	$objPHPExcel->getActiveSheet()->SetCellValue('F2', '户籍所在地');
	
	$o_dept = new Student_Onboard_Info();
	$o_dept->PushWhere ( array ('&&', 'State', '=', 1 ) );
	$o_dept->PushWhere ( array ('&&', 'ClassNumber', '=', $S_Class ) );
	$o_dept->PushOrder ( array ('Name', 'A' ) );
	$n_count = $o_dept->getAllCount ();
	
	for($i = 0; $i < $n_count; $i ++) {
		$n_row=$i+3;
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$n_row, ($i+1));
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$n_row, $o_dept->getName ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$n_row, $o_dept->getSex ( $i ));
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$n_row, $o_dept->getBirthday($i));
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$n_row, $o_dept->getNation ( $i ));
		$s_hj=$o_dept->getHCity ( $i );
		if ($o_dept->getHCity ( $i )=='北京市')
		{
			$s_hj=$o_dept->getHCity ( $i ).$o_dept->getHArea ( $i );
		}
		$s_hj=$o_dept->getHCity ( $i ).$o_dept->getHArea ( $i );
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$n_row, $s_hj);
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