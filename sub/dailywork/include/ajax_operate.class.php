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
	public function WechatWorkflowNew($n_uid)//微信端事件
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		$o_main=new Dailywork_Workflow_Main($this->getPost ( 'Id' ));//获取总的workflow规则
		//验证Id是否合法
		if (!($o_main->getNumber()>0))
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'操作错误，请与管理员联系，001！\');' );
		}
		//验证所有控件提交的合法性
		$o_main_vcl=new Dailywork_Workflow_Main_Vcl();
		$o_main_vcl->PushWhere ( array ('&&', 'MainId', '=',$o_main->getId()) ); 
		$o_main_vcl->PushOrder ( array ('Number', 'A') );
		for($i=0;$i<$o_main_vcl->getAllCount();$i++)
		{
			if ($o_main_vcl->getIsMust($i)==1 && $this->getPost($o_main_vcl->getId($i))=='')
			{
				$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'['.$o_main_vcl->getName($i).'] 不能为空！\');' );
			}
		}
		//新建用户的workflow
		$o_case=new Dailywork_Workflow_Case();
		$o_case->setOpener($n_uid);
		$o_case->setDate($this->GetDateNow());
		$o_case->setMainId($o_main->getId());
		//计算工作流程的状态标志，因为有些用户是属于工作流程的中间部分，所以可以免去之前的审批。
		$n_state=1;
		$o_base_user_role=new Base_User_Role($n_uid);//获取用户的角色
		$o_step=new Dailywork_Workflow_Main_Step();
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_main->getId()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getRoleId()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_main->getId()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId1()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_main->getId()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId2()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_main->getId()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId3()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_main->getId()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId4()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_main->getId()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId5()));
		$o_step->PushOrder ( array ('Number', 'D') );
		if ($o_step->getAllCount()>0)
		{
			$n_state=$o_step->getNumber(0)+1;
		}
		$o_case->setState($n_state);
		$o_case->Save();
		//保存用户提交的数据项
		for($i=0;$i<$o_main_vcl->getAllCount();$i++)
		{
			//要区分控件类型
			switch ($o_main_vcl->getType($i))
			{
				case 'img':
					//分析控件
					$s_value=$this->getPost($o_main_vcl->getId($i));
					$a_img=array();
					$a_url=array();
					$a_url=explode(',', $s_value);
					for($j=0;$j<count($a_url);$j++)
					{
						if (count(explode('file.api.weixin.qq.com', $a_url[$j]))>1)
						{
							//说明地址合法那么开始下载
							$ch = curl_init($a_url[$j]);
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							$str = curl_exec($ch);
							mkdir ( RELATIVITY_PATH . 'userdata/dailywork', 0777 );
							mkdir ( RELATIVITY_PATH . 'userdata/dailywork/workflow', 0777 );
							mkdir ( RELATIVITY_PATH . 'userdata/dailywork/workflow/'.$o_case->getId().'_'.$o_main_vcl->getId($i), 0777 );
							$s_file_name='userdata/dailywork/workflow/'.$o_case->getId().'_'.$o_main_vcl->getId($i).'/'.time().rand('10000', '99999').'.jpg';
							file_put_contents(RELATIVITY_PATH.$s_file_name,$str);
							array_push($a_img, $s_file_name);
						}
					}
					$o_case_data=new Dailywork_Workflow_Case_Data();
					$o_case_data->setCaseId($o_case->getId());
					$o_case_data->setMainVclId($o_main_vcl->getId($i));
					$o_case_data->setName($o_main_vcl->getName($i));
					$o_case_data->setType($o_main_vcl->getType($i));
					$o_case_data->setValue(json_encode($a_img));					
					$o_case_data->Save();
					break;
				default:
					$o_case_data=new Dailywork_Workflow_Case_Data();
					$o_case_data->setCaseId($o_case->getId());
					$o_case_data->setMainVclId($o_main_vcl->getId($i));
					$o_case_data->setName($o_main_vcl->getName($i));
					$o_case_data->setType($o_main_vcl->getType($i));
					$o_case_data->setValue($this->getPost($o_main_vcl->getId($i)));
					$o_case_data->Save();
			}			
		}		
		//给第一步审批人发送消息提醒，同时新建所有审批流程
		$o_main_step=new Dailywork_Workflow_Main_Step();
		$o_main_step->PushWhere ( array ('&&', 'MainId', '=',$o_main->getId()) );
		$o_main_step->PushWhere ( array ('&&', 'Number', '>=',$n_state) );
		$o_main_step->PushOrder ( array ('Number', 'A') );
		for($i=0;$i<$o_main_step->getAllCount();$i++)
		{
			$o_case_step=new Dailywork_Workflow_Case_Step();
			$o_case_step->setCaseId($o_case->getId());
			$o_case_step->setMainStepId($o_main_step->getId($i));
			$o_case_step->Save();
			if ($o_main_step->getNumber($i)==$n_state)
			{				
				$this->WorkflowSendAuditNotice($o_main_step->getRoleId($i),$o_case->getId());
			}
		}
		//记录case日志		
		$o_case_log=new Dailywork_Workflow_Case_Log();
		$o_case_log->setCaseId($o_case->getId());
		$o_case_log->setDate($this->GetDateNow());
		$o_case_log->setOperatorId($n_uid);
		$o_case_log->setOperatorName($o_user->getName().' <i class="weui-icon-success-no-circle"></i>');
		$o_case_log->setComment('提交申请，等待相关部门审批。');
		$o_case_log->Save();
		$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'workflow_new_success.php"');
	}
	public function WechatWorkflowModify($n_uid)//微信端事件
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		$o_case=new Dailywork_Workflow_Case($this->getPost ( 'Id' ));
		//验证Id是否合法
		if (!($o_case->getState()>0 && $o_case->getState()!=0 && $o_case->getState()!=100 && $o_case->getReason()!=''))
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'操作错误，请与管理员联系，001！\');' );
		}
		//验证控件合法性
		$o_main_vcl=new Dailywork_Workflow_Main_Vcl();
		$o_main_vcl->PushWhere ( array ('&&', 'MainId', '=',$o_case->getMainId()) ); 
		$o_main_vcl->PushOrder ( array ('Number', 'A') );
		for($i=0;$i<$o_main_vcl->getAllCount();$i++)
		{
			if ($o_main_vcl->getIsMust($i)==1 && $this->getPost($o_main_vcl->getId($i))=='')
			{
				$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'['.$o_main_vcl->getName($i).'] 不能为空！\');' );
			}
		}
		//获取Case步骤中，最小的Number，作为这个Case的State
		$o_case_step=new Dailywork_Workflow_Case_Step_View();
		$o_case_step->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId())); 
		$o_case_step->PushOrder ( array ('Number', 'A') );
		$o_case_step->getAllCount();
		$n_state=$o_case_step->getNumber(0);
		$o_case->setState($o_case_step->getNumber(0));
		$o_case->setReason('');
		$o_case->Save();
		//删除原用户提交的数据项
		$o_case_data=new Dailywork_Workflow_Case_Data();
		$o_case_data->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()));
		$o_case_data->DeletionWhere();
		//保存用户提交的数据项
		for($i=0;$i<$o_main_vcl->getAllCount();$i++)
		{
			switch ($o_main_vcl->getType($i))
			{
				case 'img':
					//分析控件
					$s_value=$this->getPost($o_main_vcl->getId($i));
					$a_img=array();
					$a_url=array();
					$a_url=explode(',', $s_value);
					for($j=0;$j<count($a_url);$j++)
					{
						if (count(explode('file.api.weixin.qq.com', $a_url[$j]))>1)
						{
							//说明地址合法那么开始下载
							$ch = curl_init($a_url[$j]);
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							$str = curl_exec($ch);
							mkdir ( RELATIVITY_PATH . 'userdata/dailywork', 0777 );
							mkdir ( RELATIVITY_PATH . 'userdata/dailywork/workflow', 0777 );
							mkdir ( RELATIVITY_PATH . 'userdata/dailywork/workflow/'.$o_case->getId().'_'.$o_main_vcl->getId($i), 0777 );
							$s_file_name='userdata/dailywork/workflow/'.$o_case->getId().'_'.$o_main_vcl->getId($i).'/'.time().rand('10000', '99999').'.jpg';
							file_put_contents(RELATIVITY_PATH.$s_file_name,$str);
							array_push($a_img, $s_file_name);
						}else if (count(explode('userdata/dailywork/workflow', $a_url[$j]))>1)
						{
							//说明是以前有的图片，不用下载
							array_push($a_img, $a_url[$j]);
						}
					}
					$o_case_data=new Dailywork_Workflow_Case_Data();
					$o_case_data->setCaseId($o_case->getId());
					$o_case_data->setMainVclId($o_main_vcl->getId($i));
					$o_case_data->setName($o_main_vcl->getName($i));
					$o_case_data->setType($o_main_vcl->getType($i));
					$o_case_data->setValue(json_encode($a_img));					
					$o_case_data->Save();
					break;
				default:
					$o_case_data=new Dailywork_Workflow_Case_Data();
					$o_case_data->setCaseId($o_case->getId());
					$o_case_data->setMainVclId($o_main_vcl->getId($i));
					$o_case_data->setName($o_main_vcl->getName($i));
					$o_case_data->setType($o_main_vcl->getType($i));
					$o_case_data->setValue($this->getPost($o_main_vcl->getId($i)));
					$o_case_data->Save();
			}			
		}		
		//给第一步审批人发送消息提醒，同时新建所有审批流程
		$o_main_step=new Dailywork_Workflow_Main_Step();
		$o_main_step->PushWhere ( array ('&&', 'MainId', '=',$o_case->getMainId()) );
		$o_main_step->PushWhere ( array ('&&', 'Number', '>=',$n_state) );
		$o_main_step->PushOrder ( array ('Number', 'A') );
		for($i=0;$i<$o_main_step->getAllCount();$i++)
		{
			$o_case_step=new Dailywork_Workflow_Case_Step();
			$o_case_step->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) );
			$o_case_step->PushWhere ( array ('&&', 'MainStepId', '=',$o_main_step->getId($i)) );
			if ($o_case_step->getAllCount()>0)
			{
				$o_case_step=new Dailywork_Workflow_Case_Step($o_case_step->getId(0));
				$o_case_step->setOwnerId(0);
			}else{
				$o_case_step=new Dailywork_Workflow_Case_Step();
			}		
			$o_case_step->setCaseId($o_case->getId());
			$o_case_step->setMainStepId($o_main_step->getId($i));
			$o_case_step->Save();
			if ($o_main_step->getNumber($i)==$n_state)
			{				
				//$this->WorkflowSendAuditNotice($o_main_step->getRoleId($i),$o_case->getId());
			}
		}
		//记录case日志		
		$o_case_log=new Dailywork_Workflow_Case_Log();
		$o_case_log->setCaseId($o_case->getId());
		$o_case_log->setDate($this->GetDateNow());
		$o_case_log->setOperatorId($n_uid);
		$o_case_log->setOperatorName($o_user->getName().' <i class="weui-icon-success-no-circle"></i>');
		$o_case_log->setComment('提交修改，等待相关部门审批。');
		$o_case_log->Save();
		$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'workflow_new_success.php"');
	}
	private function WorkflowSendAuditNotice($n_role_id,$n_case_id)
	{
		return;
		$o_case_view=new Dailywork_Workflow_Case_View($n_case_id);	
		require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
		$o_system_setup=new Base_Setup(1);
		//收集所以这个角色的Uid
		$o_role=new Base_User_Role();
		$o_role->PushWhere ( array ('||', 'RoleId', '=',$n_role_id) );
		$o_role->PushWhere ( array ('||', 'SecRoleId1', '=',$n_role_id) );
		$o_role->PushWhere ( array ('||', 'SecRoleId2', '=',$n_role_id) );
		$o_role->PushWhere ( array ('||', 'SecRoleId3', '=',$n_role_id) );
		$o_role->PushWhere ( array ('||', 'SecRoleId4', '=',$n_role_id) );
		$o_role->PushWhere ( array ('||', 'SecRoleId5', '=',$n_role_id) );
		for($i=0;$i<$o_role->getAllCount();$i++)
		{
			//读取用户微信信息
			$o_wechat_user=new Base_User_Wechat_View();
			$o_wechat_user->PushWhere ( array ('&&', 'Uid', '=',$o_role->getUid($i)) );
			if ($o_wechat_user->getAllCount()==0)
			{
				continue;
			}
			//添加消息队列
			$o_msg=new Wechat_Wx_User_Reminder();
			$o_msg->setUserId($o_role->getUid($i));
			$o_msg->setCreateDate($this->GetDateNow());
			$o_msg->setSendDate('0000-00-00');
			$o_msg->setMsgId($this->getWechatSetup('MSGTMP_10'));
			$o_msg->setOpenId($o_wechat_user->getOpenId(0));
			$o_msg->setActivityId(0);
			$o_msg->setSend(0);
			$o_msg->setFirst('你有一个标题为“'.$o_case_view->getTitle().'”的工作流程需要审批！

申请人：'.$o_case_view->getName().'
申请时间：'.$o_case_view->getDate());
			$o_msg->setKeyword1('审批通知');
			$o_msg->setKeyword2('点击下方的查看详情，进入审批或查看。');
			$o_msg->setKeyword3('');
			$o_msg->setKeyword4('');
			$o_msg->setKeyword5('');
			$o_msg->setRemark('');
			//如果Comment为空，那么就没有点击事件了
			$o_msg->setUrl('');
			if($this->getPost('Comment')!='')
			{
				$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/teacher_operation/workflow_audit.php?id='.$o_case_view->getId().'');
			}
			$o_msg->setKeywordSum(11);
			$o_msg->Save();
		}
	}
	private function WorkflowSendRejectNotice($n_case_id)
	{
		require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
		$o_system_setup=new Base_Setup(1);
		$o_case_view=new Dailywork_Workflow_Case_View($n_case_id);	
		$o_case_step_view=new Dailywork_Workflow_Case_Step_View();
		$o_case_step_view->PushWhere ( array ('&&', 'OwnerId', '>',0) );
		$o_case_step_view->PushWhere ( array ('&&', 'CaseId', '=',$n_case_id) );
		$o_case_step_view->PushOrder ( array ('Number', 'A') );
		$a_target=array();
		array_push($a_target, $o_case_view->getOpener());//通知申请人
		for($i=0;$i<($o_case_step_view->getAllCount()-1);$i++)
		{
			//总数减一，为了就是不给刚刚操作的人发送模板消息。
			array_push($a_target, $o_case_step_view->getOwnerId($i));
		}
		for($i=0;$i<count($a_target);$i++)
		{			
			//读取用户微信信息
			$o_wechat_user=new Base_User_Wechat_View();
			$o_wechat_user->PushWhere ( array ('&&', 'Uid', '=',$a_target[$i]) );
			if ($o_wechat_user->getAllCount()==0)
			{
				continue;
			}
			//添加消息队列
			$o_msg=new Wechat_Wx_User_Reminder();
			$o_msg->setUserId($a_target[$i]);
			$o_msg->setCreateDate($this->GetDateNow());
			$o_msg->setSendDate('0000-00-00');
			$o_msg->setMsgId($this->getWechatSetup('MSGTMP_10'));
			$o_msg->setOpenId($o_wechat_user->getOpenId(0));
			$o_msg->setActivityId(0);
			$o_msg->setSend(0);
			$o_msg->setFirst('你有一个标题为“'.$o_case_view->getTitle().'”的工作流程审批不通过！

审批时间：'.$this->GetDateNow());
			$o_msg->setKeyword1('工作流程审批不通过');
			$o_msg->setKeyword2('点击下方的查看详情，进行查看。');
			$o_msg->setKeyword3('');
			$o_msg->setKeyword4('');
			$o_msg->setKeyword5('');
			$o_msg->setRemark('');
			//如果Comment为空，那么就没有点击事件了
			$o_msg->setUrl('');
			$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/teacher_operation/workflow_my.php');
			$o_msg->setKeywordSum(11);
			$o_msg->Save();
		}
	}
	private function WorkflowSendReturnNotice($n_case_id)
	{
		require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
		$o_system_setup=new Base_Setup(1);
		$o_case_view=new Dailywork_Workflow_Case_View($n_case_id);	
		$o_case_step_view=new Dailywork_Workflow_Case_Step_View();
		$o_case_step_view->PushWhere ( array ('&&', 'OwnerId', '>',0) );
		$o_case_step_view->PushWhere ( array ('&&', 'CaseId', '=',$n_case_id) );
		$o_case_step_view->PushOrder ( array ('Number', 'A') );
		$a_target=array();
		array_push($a_target, $o_case_view->getOpener());//通知申请人
		for($i=0;$i<($o_case_step_view->getAllCount()-1);$i++)
		{
			//总数减一，为了就是不给刚刚操作的人发送模板消息。
			array_push($a_target, $o_case_step_view->getOwnerId($i));
		}
		for($i=0;$i<count($a_target);$i++)
		{
			//从第一个开始，而不是从第零个开始，为了就是不给刚刚操作的人发送模板消息。
			//读取用户微信信息
			$o_wechat_user=new Base_User_Wechat_View();
			$o_wechat_user->PushWhere ( array ('&&', 'Uid', '=',$a_target[$i]) );
			if ($o_wechat_user->getAllCount()==0)
			{
				continue;
			}
			//添加消息队列
			$o_msg=new Wechat_Wx_User_Reminder();
			$o_msg->setUserId($a_target[$i]);
			$o_msg->setCreateDate($this->GetDateNow());
			$o_msg->setSendDate('0000-00-00');
			$o_msg->setMsgId($this->getWechatSetup('MSGTMP_10'));
			$o_msg->setOpenId($o_wechat_user->getOpenId(0));
			$o_msg->setActivityId(0);
			$o_msg->setSend(0);
			$o_msg->setFirst('你有一个标题为“'.$o_case_step_view->getAllCount().'”的工作流程被退回！

退回时间：'.$this->GetDateNow());
			$o_msg->setKeyword1('工作流程退回修改');
			$o_msg->setKeyword2('点击下方的查看详情，进行查看。');
			$o_msg->setKeyword3('');
			$o_msg->setKeyword4('');
			$o_msg->setKeyword5('');
			$o_msg->setRemark('');
			$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/teacher_operation/workflow_my.php');
			$o_msg->setKeywordSum(11);
			//$o_msg->Save();
		}
	}
	public function WechatWorkflowAudit($n_uid)//微信端事件
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		//检查是不通过，还是退回，如果都不是，那就是审核通过
		if($this->getPost ( 'Type' )=='Reject')
		{
			$this->WechatWorkflowReject($n_uid);
			return;
		}
		if($this->getPost ( 'Type' )=='Return')
		{
			$this->WechatWorkflowReturn($n_uid);
			return;
		}
		$o_case=new Dailywork_Workflow_Case($this->getPost ( 'Id' ));	
		$o_case_view=new Dailywork_Workflow_Case_View($this->getPost ( 'Id' ));		
		//判断用户是否有审批权限
		$o_base_user_role=new Base_User_Role($n_uid);
		$o_step=new Dailywork_Workflow_Main_Step();
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getRoleId()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId1()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId2()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId3()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId4()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId5()));
		if ($o_step->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'此工作流程已被其他人员审批！\',function(){parent.location.reload()});' );
		}	
		//验证所有控件提交的合法性
		$o_main_vcl=new Dailywork_Workflow_Main_Step_Vcl();
		$o_main_vcl->PushWhere ( array ('&&', 'StepId', '=',$o_step->getId(0)) ); 
		$o_main_vcl->PushOrder ( array ('Number', 'A') );
		for($i=0;$i<$o_main_vcl->getAllCount();$i++)
		{
			if ($o_main_vcl->getIsMust($i)==1 && $this->getPost($o_main_vcl->getId($i))=='')
			{
				$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'['.$o_main_vcl->getName($i).'] 不能为空！\');' );
			}
		}
		//记录审核人和控件信息
		$o_case_step=new Dailywork_Workflow_Case_Step_View();
        $o_case_step->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) ); 
        $o_case_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()) );
        $o_case_step->PushWhere ( array ('&&', 'OwnerId', '=',0) );
        if ($o_case_step->getAllCount()==0)
        {
        	$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'此工作流程已被其他人员审批！\',function(){parent.location.reload()});' );
        }
        $o_case_step_temp=new Dailywork_Workflow_Case_Step($o_case_step->getId(0));
        $o_case_step_temp->setOwnerId($n_uid);
        $o_case_step_temp->setDate($this->GetDateNow());
        $o_case_step_temp->Save();
        //记录审核人的控件值
		for($i=0;$i<$o_main_vcl->getAllCount();$i++)
		{
			//查看数据项是否已经存在，如果存在，那么直接修改
			$o_case_data=new Dailywork_Workflow_Case_Step_Data();
			$o_case_data->PushWhere ( array ('&&', 'CaseStepId', '=',$o_case_step->getId(0)) );
			if($o_case_data->getAllCount()>0)
			{
				$o_case_data=new Dailywork_Workflow_Case_Step_Data($o_case_data->getId(0));
			}else{
				$o_case_data=new Dailywork_Workflow_Case_Step_Data();
			}			
			$o_case_data->setCaseStepId($o_case_step->getId(0));
			$o_case_data->setName($o_main_vcl->getName($i));
			$o_case_data->setType($o_main_vcl->getType($i));
			$o_case_data->setValue($this->getPost($o_main_vcl->getId($i)));
			$o_case_data->Save();
		}
        //工作流程状态+1
        if (($o_case->getState()+1)>$o_case_view->getStateSum())
        {
        	$o_case->setState(100);
        	$o_case->setCloseDate($this->GetDateNow());
        }else{
        	$o_case->setState($o_case->getState()+1);
        }		
		$o_case->Save();
		//给所有下一步审批的人发送模板消息提醒
		$o_main_step=new Dailywork_Workflow_Main_Step();
		$o_main_step->PushWhere ( array ('&&', 'MainId', '=',$o_case->getMainId()) );
		$o_main_step->PushWhere ( array ('&&', 'Number', '>=',$o_case->getState()) );
		$o_main_step->PushOrder ( array ('Number', 'A') );
		for($i=0;$i<$o_main_step->getAllCount();$i++)
		{
			if ($o_main_step->getNumber($i)==$o_case->getState())
			{				
				$this->WorkflowSendAuditNotice($o_main_step->getRoleId($i),$o_case->getId());
			}
		}
		//记录case日志
		$o_user = new Single_User ( $n_uid );
		$o_case_log=new Dailywork_Workflow_Case_Log();
		$o_case_log->setCaseId($o_case->getId());
		$o_case_log->setDate($this->GetDateNow());
		$o_case_log->setOperatorId($n_uid);
		$o_case_log->setOperatorName($o_user->getName().'（'.$o_case_step->getRoleName(0).'） <i class="weui-icon-success-no-circle"></i>');
		$o_case_log->setComment($o_main_vcl->getName(0).'：'.$this->getPost($o_main_vcl->getId(0)));
		$o_case_log->Save();
		$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'workflow_audit_success.php"');
	}
	Private function WechatWorkflowReject($n_uid)//微信端事件
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_case=new Dailywork_Workflow_Case($this->getPost ( 'Id' ));	
		$o_case_view=new Dailywork_Workflow_Case_View($this->getPost ( 'Id' ));		
		//判断用户是否有审批权限
		$o_base_user_role=new Base_User_Role($n_uid);
		$o_step=new Dailywork_Workflow_Main_Step();
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getRoleId()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId1()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId2()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId3()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId4()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId5()));
		if ($o_step->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'此工作流程已被其他人员审批！\',function(){parent.location.reload()});' );
		}	
		//验证所有控件提交的合法性
		if ($this->getPost('Reason')=='')
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'[退回修改/不通过 原因] 不能为空！\');' );
		}
		//记录审核人和控件信息
		$o_case_step=new Dailywork_Workflow_Case_Step_View();
        $o_case_step->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) ); 
        $o_case_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()) );
        $o_case_step->PushWhere ( array ('&&', 'OwnerId', '=',0) );
        if ($o_case_step->getAllCount()==0)
        {
        	$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'此工作流程已被其他人员审批！\',function(){parent.location.reload()});' );
        }
        $o_case_step_temp=new Dailywork_Workflow_Case_Step($o_case_step->getId(0));
        $o_case_step_temp->setOwnerId($n_uid);
        $o_case_step_temp->setDate($this->GetDateNow());
        $o_case_step_temp->Save();
        //工作流程状态+1
        $o_case->setState(0);
        $o_case->setReason($this->getPost('Reason'));		
		$o_case->Save();
		//给所有参与过的人员发送模板消息
		$this->WorkflowSendRejectNotice($o_case->getId());
		//记录case日志
		$o_user = new Single_User ( $n_uid );
		$o_case_log=new Dailywork_Workflow_Case_Log();
		$o_case_log->setCaseId($o_case->getId());
		$o_case_log->setDate($this->GetDateNow());
		$o_case_log->setOperatorId($n_uid);
		$o_case_log->setOperatorName($o_user->getName().'（'.$o_case_step->getRoleName(0).'） <i class="weui-icon-cancel"></i>');
		$o_case_log->setComment('不通过原因：'.$this->getPost('Reason'));
		$o_case_log->Save();
		$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'workflow_audit_success.php"');
	}
	Private function WechatWorkflowReturn($n_uid)//微信端事件
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_case=new Dailywork_Workflow_Case($this->getPost ( 'Id' ));	
		$o_case_view=new Dailywork_Workflow_Case_View($this->getPost ( 'Id' ));		
		//判断用户是否有审批权限
		$o_base_user_role=new Base_User_Role($n_uid);
		$o_step=new Dailywork_Workflow_Main_Step();
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getRoleId()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId1()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId2()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId3()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId4()));
		$o_step->PushWhere ( array ('||', 'MainId', '=',$o_case->getMainId()));
		$o_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()));
		$o_step->PushWhere ( array ('&&', 'RoleId', '=',$o_base_user_role->getSecRoleId5()));
		if ($o_step->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'此工作流程已被其他人员审批！\',function(){parent.location.reload()});' );
		}	
		//验证所有控件提交的合法性
		if ($this->getPost('Reason')=='')
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'[退回修改/不通过 原因] 不能为空！\');' );
		}
		//记录审核人和控件信息
		$o_case_step=new Dailywork_Workflow_Case_Step_View();
        $o_case_step->PushWhere ( array ('&&', 'CaseId', '=',$o_case->getId()) ); 
        $o_case_step->PushWhere ( array ('&&', 'Number', '=',$o_case->getState()) );
        $o_case_step->PushWhere ( array ('&&', 'OwnerId', '=',0) );
        if ($o_case_step->getAllCount()==0)
        {
        	$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'此工作流程已被其他人员审批！\',function(){parent.location.reload()});' );
        }
        $o_case_step_temp=new Dailywork_Workflow_Case_Step($o_case_step->getId(0));
        $o_case_step_temp->setOwnerId($n_uid);
        $o_case_step_temp->setDate($this->GetDateNow());
        $o_case_step_temp->Save();
        //工作流程状态+1
        $o_case->setReason($this->getPost('Reason'));	
		$o_case->Save();
		//给所有参与过的人员发送模板消息
		$this->WorkflowSendReturnNotice($o_case->getId());
		//记录case日志
		$o_user = new Single_User ( $n_uid );
		$o_case_log=new Dailywork_Workflow_Case_Log();
		$o_case_log->setCaseId($o_case->getId());
		$o_case_log->setDate($this->GetDateNow());
		$o_case_log->setOperatorId($n_uid);
		$o_case_log->setOperatorName($o_user->getName().'（'.$o_case_step->getRoleName(0).'） <i class="weui-icon-cancel"></i>');
		$o_case_log->setComment('退回修改原因：'.$this->getPost('Reason'));
		$o_case_log->Save();
		$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'workflow_audit_success.php"');
	}
}
?>