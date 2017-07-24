<?php
//error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 50;	
	public function PayrollTable($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120601 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Dailywork_Payroll_Object_View(); 
		$o_user->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_user->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();//总记录数
		$n_count = $o_user->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {
			$a_button = array ();			
			array_push ( $a_button, array ('下载', "window.open('payroll_detail_download.php?id=".$o_user->getId($i)."&date=".$o_user->getDate($i)."','_blank')" ) );
			$o_detail=new Dailywork_Payroll_Object_Detail();
			$o_detail->PushWhere ( array ('&&', 'ObjectId', '=',$o_user->getId($i)) );			
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				$o_user->getDate ( $i ),
				$o_user->getOperatorName ( $i ),
				$o_detail->getAllCount(),
				$a_button
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'序号', '', 50, 0);
		$a_title=$this->setTableTitle($a_title,'发布日期', 'Date', 0, 0);
		$a_title=$this->setTableTitle($a_title,'发布人', 'OperatorName', 0, 0);
		$a_title=$this->setTableTitle($a_title,'工资人数', '', 0, 0);		
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 90,0);
		$this->SendJsonResultForTable($n_allcount,'PayrollTable', 'yes', $n_page, $a_title, $a_row);
	}
	public function PayrollRelease($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		require_once RELATIVITY_PATH . 'include/PHPExcel.php';
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120601 ))return; //如果没有权限，不返回任何值
		if ($_FILES ['Vcl_File'] ['size'] > 0) {
			mkdir ( RELATIVITY_PATH . 'userdata/dailywork', 0777 );
			mkdir ( RELATIVITY_PATH . 'userdata/dailywork/payroll', 0777 );
			$allowpictype = array ('xlsx');
			$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
			if (! in_array ( $fileext, $allowpictype )) {
				$this->setReturn ( 'parent.form_return("dialog_error(\'上传文件类型为.xlsx！\')");' );
			}
			//新建一个object
			$o_object=new Dailywork_Payroll_Object();
			$o_object->setOperatorId($n_uid);
			$o_object->setOperatorDate($this->GetDateNow());
			$o_object->setDate($this->getPost('Date'));
			$o_object->Save();
			$filePath= RELATIVITY_PATH . 'userdata/dailywork/payroll/'.$o_object->getId().'.' . $fileext;
			copy ( $_FILES ['Vcl_File'] ['tmp_name'],$filePath);
			
			//开始导入到数据库
			//1.先验证上传文件是否符合列的要求		
			$PHPReader = new PHPExcel_Reader_Excel2007 ();
			if (! $PHPReader->canRead ( $filePath )) {
				$PHPReader = new PHPExcel_Reader_Excel2007 ();
				if (! $PHPReader->canRead ( $filePath )) {
					$this->setReturn ( 'parent.form_return("dialog_error(\'对不起，上传失败，请与管理员联系！[001]\')");' );
					return;
				}
			}
			$PHPExcel = $PHPReader->load ( $filePath );
			$currentSheet = $PHPExcel->getSheet ( 0 );
			$allColumn = $currentSheet->getHighestColumn ();
			$allRow = $currentSheet->getHighestRow ();
			$all = array ();
			//先验证列
			$o_item=new Dailywork_Payroll_Item();
			$o_item->PushOrder ( array ('Number',A) );
			$n_counter=1;
			for($i=0;$i<$o_item->getAllCount();$i++)
			{
				if ($n_counter==1)
				{
					if ($currentSheet->getCell ( $this->get_column_number($n_counter,1) )->getValue ()!='系统编号')
					{
						$o_object->Deletion();
						$this->setReturn ( 'parent.form_return("dialog_error(\'上传文件错误：'.$this->get_column_number($n_counter,1).'单元格必须为“系统编号”！\')");' );			
					}
					$i=-1;
				}elseif ($n_counter==2)
				{
					if ($currentSheet->getCell ( $this->get_column_number($n_counter,1) )->getValue ()!='教师姓名')
					{
						$o_object->Deletion();
						$this->setReturn ( 'parent.form_return("dialog_error(\'上传文件错误：'.$this->get_column_number($n_counter,1).'单元格必须为“教师姓名”！\')");' );			
					}
					$i=-1;
				}else{
					if ($currentSheet->getCell ( $this->get_column_number($n_counter,1) )->getValue ()!=$o_item->getName($i))
					{
						$o_object->Deletion();
						$this->setReturn ( 'parent.form_return("dialog_error(\'上传文件错误：'.$this->get_column_number($n_counter,1).'单元格必须为“'.$o_item->getName($i).'”！\')");' );			
					}
				}				
				$n_counter++;
			}			
			for($currentRow = 2; $currentRow <= $allRow; $currentRow ++) {
				//处理每条数据
				$n_teacher_id=$currentSheet->getCell ($this->get_column_number(1,$currentRow))->getValue ();
				//查找用户是否存在
				$o_user_info=new Base_User_Info();
				$o_user_info->PushWhere ( array ('&&', 'Uid', '=',$n_teacher_id) );
				if ($o_user_info->getAllCount()==0)
				{
					$o_object->Deletion();
					$this->setReturn ( 'parent.form_return("dialog_error(\'上传文件错误：第'.$currentRow.'行，系统编号有误，用户不存在。\')");' );		
					break;
				}
				//循环制作数据结构
				$a_data=array();
				$n_counter=3;
				for($i=0;$i<$o_item->getAllCount();$i++)
				{
					//检测数值是否为数字，如果为数字，那么保留两位小数
					$s_value=$currentSheet->getCell ( $this->get_column_number($n_counter,$currentRow) )->getValue ();
					if(is_numeric($s_value))
					{
						$s_value=sprintf("%.2f",$s_value);
					}elseif($s_value=='')
					{
						$s_value=sprintf("%.2f",0);
					}				
					$a_temp=array(rawurlencode($o_item->getName($i)),rawurlencode($s_value));
					array_push($a_data,$a_temp);
					$n_counter++;
				}
				$o_detail=new Dailywork_Payroll_Object_Detail();
				$o_detail->setTeacherId($n_teacher_id);	
				$o_detail->setObjectId($o_object->getId());
				$o_detail->setDetail(json_encode($a_data));	
				$o_detail->Save();
			}
			$this->setReturn ( 'parent.form_return("dialog_success(\'工资发布成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
		}else{
			$this->setReturn ( 'parent.form_return("dialog_message(\'对不起，请上传工资条文件！\')");' );
		}
	}
	public function get_column_number($column,$row)
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
}
?>