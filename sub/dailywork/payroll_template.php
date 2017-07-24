<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120601 );
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
$o_user = new Single_User ( $O_Session->getUid () );
if ($o_user->ValidModule ( MODULEID ) == false) {
	exit ( 0 );
}
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
$s_file_name='工资条模版';
$S_State=1;
if (isset ( $_GET ['state'] )) {
	$S_State=$_GET ['state'];
}
mkdir ( RELATIVITY_PATH . 'userdata/dailywork', 0777 );
mkdir ( RELATIVITY_PATH . 'userdata/dailywork/payroll', 0777 );
$S_Filename = $s_file_name.'.xlsx';
OutputList ( $S_State,$S_Filename );
$rename = rawurlencode ( $S_Filename );
Header("Location: ".RELATIVITY_PATH . "userdata/dailywork/payroll/".$S_Filename); 
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
	$n_counter=1;
	require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
	$s_filename=RELATIVITY_PATH . 'userdata/dailywork/payroll/'.$s_filename;
	
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
	//输出标题
	$objPHPExcel->getActiveSheet()->SetCellValueExplicit(get_column_number($n_counter,1), '系统编号', PHPExcel_Cell_DataType::TYPE_STRING);$n_counter++;
	$objPHPExcel->getActiveSheet()->SetCellValueExplicit(get_column_number($n_counter,1), '教师姓名', PHPExcel_Cell_DataType::TYPE_STRING);$n_counter++;
	$o_item=new Dailywork_Payroll_Item();
	$o_item->PushOrder ( array ('Number',A) );
	for($i=0;$i<$o_item->getAllCount();$i++)
	{
		$objPHPExcel->getActiveSheet()->SetCellValueExplicit(get_column_number($n_counter,1), $o_item->getName($i), PHPExcel_Cell_DataType::TYPE_STRING);$n_counter++;
	}
	//输出人名，除了刘奇与初涛
	$o_user=new Base_User_Info();
	$n_row=2;
	for($i=0;$i<$o_user->getAllCount();$i++)
	{
		if ($o_user->getUid($i)==1 || $o_user->getUid($i)==655)
		{
			continue;
		}
		$n_counter=1;
		$objPHPExcel->getActiveSheet()->SetCellValueExplicit(get_column_number($n_counter,$n_row), $o_user->getUid($i), PHPExcel_Cell_DataType::TYPE_STRING);$n_counter++;
		$objPHPExcel->getActiveSheet()->SetCellValueExplicit(get_column_number($n_counter,$n_row), $o_user->getName($i), PHPExcel_Cell_DataType::TYPE_STRING);$n_counter++;
		$n_row++;
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