<?php
error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 50;
	protected $S_Key='www.bjsql.com';//密钥
	protected $S_License='MNJIHKI6525489';//部门权限
	protected $S_Url='http://yeygl.xchjw.cn/sub/webservice/';//接口地址
	//protected $S_Url='http://3.36.220.52/xcye_collect/xcyey_admin/sub/webservice/';//本地测试接口
	public function YeInfo($n_uid)
	{	
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120201 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Onboard_Info_Class_View();
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			if ($this->getPost('other_key')!='')
			{
				$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$this->getPost('other_key').'%') );
				$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$this->getPost('other_key').'%') );
			}else{
				$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',$s_key) );
			}				
		}else{
			if ($this->getPost('other_key')!='')
			{
				$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$this->getPost('other_key').'%') );
				$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$this->getPost('other_key').'%') );
			}			
		}
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
			//区分年级
			switch ($o_user->getGrade($i))
			{
				case 0:
					$s_grade_name='半日班';
						break;
				case 1:
					$s_grade_name='托班';
						break;
				case 2:
					$s_grade_name='小班';
					break;
				case 3:
					$s_grade_name='中班';
					break;
				case 4:
					$s_grade_name='大班';
					break;
			}
			$s_state_flg='';
			if ($o_user->getState($i)==2)
			{
				$s_state_flg=' <span class="label label-warning">待审</span>';
			}
			$a_button = array ();
			array_push ( $a_button, array ('查看', "window.open('print.php?id=".$o_user->getStudentId($i)."','_blank')" ) );//查看
			array_push ( $a_button, array ('下载PDF', "window.open('download_pdf_single.php?id=".$o_user->getStudentId($i)."','_blank')" ) );//查看
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				$o_user->getName ( $i ).$s_state_flg,
				$s_grade_name.'('.$o_user->getClassName ( $i ).')',
				$o_user->getSex ( $i ),
				$o_user->getBirthday ( $i ),
				$o_user->getId ( $i ).'<br/><span style="color:#999999">'.$o_user->getIdType( $i ).'</span>',
				$o_user->getJh1Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getJh1Phone ( $i ).'</span>',
				$a_button
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'序号', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'姓名', 'Name', 0, 80);
		$a_title=$this->setTableTitle($a_title,'班级名称', 'ClassNumber', 0, 90);
		$a_title=$this->setTableTitle($a_title,'性别', 'Sex', 0, 40);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件号码', '', 0, 90);
		$a_title=$this->setTableTitle($a_title,'第一监护人', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,75);
		$this->SendJsonResultForTable($n_allcount,'YeInfo', 'yes', $n_page, $a_title, $a_row);
	}
	public function YeClassTable($n_uid)
	{	
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120202 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Class();		
		$o_user->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_user->PushOrder ( array ('ClassId','A') );
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
			//区分年级
			switch ($o_user->getGrade($i))
			{
				case 0:
					$s_grade_name='半日班';
						break;
				case 1:
					$s_grade_name='托班';
						break;
				case 2:
					$s_grade_name='小班';
					break;
				case 3:
					$s_grade_name='中班';
					break;
				case 4:
					$s_grade_name='大班';
					break;
			}
			$a_button = array ();
			/*
			 * 计算班级人数
			 */
			$o_dept = new Student_Onboard_Info();
			$o_dept->PushWhere ( array ('&&', 'Sex', '=', '女') );
			$o_dept->PushWhere ( array ('&&', 'ClassNumber', '=', $o_user->getClassId($i) ) );
			$n_count_girl = $o_dept->getAllCount ();
			$o_dept = new Student_Onboard_Info();
			$o_dept->PushWhere ( array ('&&', 'Sex', '=', '男') );
			$o_dept->PushWhere ( array ('&&', 'ClassNumber', '=', $o_user->getClassId($i) ) );
			$n_count_boy = $o_dept->getAllCount ();
			
			array_push ( $a_button, array ('修改', "location='class_modify.php?id=".$o_user->getClassId($i)."'" ) );//查看
			array_push ( $a_button, array ('删除', "class_delete('".$o_user->getClassId($i)."')" ) );//查看
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				$s_grade_name,
				$o_user->getClassName ( $i ),
				$n_count_girl,
				$n_count_boy,
				($n_count_girl+$n_count_boy),
				$a_button
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'序号', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'年级', 'Grade', 0, 80);
		$a_title=$this->setTableTitle($a_title,'班级名称', '', 0, 90);
		$a_title=$this->setTableTitle($a_title,'女生人数', 'Sex', 0, 80);
		$a_title=$this->setTableTitle($a_title,'男生人数', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'总人数', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,75);
		$this->SendJsonResultForTable($n_allcount,'YeClassTable', 'yes', $n_page, $a_title, $a_row);
	}
	public function ClassAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120202 ))return; //如果没有权限，不返回任何值
		//添加班级到采集系统
		$a_data=array(
			'Grade'=>$this->getPost('Grade'),
			'ClassName'=>$this->getPost('ClassName')
			);
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'Data'=>$this->Encrypt (json_encode($a_data), 'E', $this->S_Key ));
		$s_result=json_decode($this->HttpsRequest($this->S_Url.'add_class.php',$request_data));
		if ($s_result->Flag==1)
		{
			//新建成功后，获取返回的ClassId
			$o_admission_setup=new Admission_Setup(1);
			$o_table=new Student_Class();
			$o_table->setClassId($s_result->ClassId);
			$o_table->setGrade($this->getPost('Grade'));
			$o_table->setClassName($this->getPost('ClassName'));
			$o_table->setSchoolId($o_admission_setup->getDeptId());
			if ($o_table->Save()==false)
			{
				LOG::CLASS_UPDATE('error,采集系统新建班级成功后，本地班级写入失败，班级ID：'.$s_result->ClassId);
			}else{
				$this->setReturn ( 'parent.form_return("dialog_success(\'添加班级成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
			}
		}else{
			if ($s_result->Msg=='1001')
			{
				LOG::CLASS_UPDATE('error,提交新建班级时，验证失败!');
				$this->setReturn ( 'parent.form_return("dialog_error(\'采集系统服务器连接失败，请重试。\')");' );				
			}else{
				LOG::CLASS_UPDATE('error,提交新建班级时，采集系统添加班级新建数据不成功，年级：'.$this->getPost('Grade').'，班级名称：'.$this->getPost('ClassName'));
				$this->setReturn ( 'parent.form_return("dialog_error(\'采集系统添加班级错误，请重试。\')");' );				
			}
		}
	}
	public function ClassModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120202 ))return; //如果没有权限，不返回任何值
		$o_table=new Student_Class($this->getPost('Id'));
		//修改班级到采集系统
		$a_data=array(
			'ClassId'=>$this->getPost('Id'),
			'Grade'=>$o_table->getGrade(),
			'ClassName'=>$this->getPost('ClassName')
		);
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'Data'=>$this->Encrypt (json_encode($a_data), 'E', $this->S_Key ));
		$s_result=json_decode($this->HttpsRequest($this->S_Url.'modify_class.php',$request_data));
		if ($s_result->Flag==1)
		{
			//成功后,保存本地数据
			$o_table->setClassName($this->getPost('ClassName'));
			if ($o_table->Save()==false)
			{
				LOG::CLASS_UPDATE('error,采集系统修改班级成功后，本地班级写入失败，班级ID：'.$this->getPost('Id'));
			}else{
				$this->setReturn ( 'parent.form_return("dialog_success(\'修改班级信息成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
			}
		}else{
			if ($s_result->Msg=='1005')
			{
				LOG::CLASS_UPDATE('error,提交修改班级信息时，未找到指定ID，班级ID：'.$this->getPost('Id'));
				$this->setReturn ( 'parent.form_return("dialog_error(\'修改班级信息失败，请重试。\')");' );				
			}elseif ($s_result->Msg=='1004'){
				LOG::CLASS_UPDATE('error,提交修改班级信息时，采集系统修改班级信息不成功，班级ID:'.$this->getPost('Id'));
				$this->setReturn ( 'parent.form_return("dialog_error(\'修改班级信息失败，请重试。\')");' );
			}else{
				LOG::CLASS_UPDATE('error,提交修改班级信息时，验证失败!');
				$this->setReturn ( 'parent.form_return("dialog_error(\'采集系统服务器连接失败，请重试。\')");' );	
			}
		}
	}
	public function ClassDelete($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120202 ))return; //如果没有权限，不返回任何值
		$o_table=new Student_Class($this->getPost('id'));
		//删除班级到采集系统
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'ClassId'=>$this->Encrypt ($this->getPost('id'), 'E', $this->S_Key ));
		$s_result=json_decode($this->HttpsRequest($this->S_Url.'delete_class.php',$request_data));
		if ($s_result->Flag==1)
		{
			//成功后,保存本地数据
			$o_table->Deletion();
			$a_general = array (
				'success' => 1,
				'text' =>''
			);
			echo (json_encode ( $a_general ));
		}else{
			if ($s_result->Msg=='1006')
			{
				$a_general = array (
					'success' => 0,
					'text' =>'此班下不能有幼儿信息！'
				);
				echo (json_encode ( $a_general ));		
			}else{
				LOG::CLASS_UPDATE('error,删除修改班级信息时，验证失败!');
				$a_general = array (
					'success' => 0,
					'text' =>'采集系统服务器连接失败，请重试。'
				);
				echo (json_encode ( $a_general ));	
			}
		}
	}
}

?>