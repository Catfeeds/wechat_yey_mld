<?php
error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
require_once RELATIVITY_PATH . 'sub/ye_info/include/db_table.class.php';
class Operate_YeInfo extends Bn_Basic {
	protected $N_PageSize= 50;
	protected $S_Key='';//密钥
	protected $S_License='';//部门权限
	//protected $S_Url='http://192.168.0.8/xcye_collect/xcyey_admin/sub/webservice/';//本地测试接口
	//protected $S_Url='http://810717.cicp.net/xcye_collect/xcyey_admin/sub/webservice/';//花生壳接口地址
	protected $S_Url='';//接口地址
	//protected $S_Url='http://3.36.220.52/xcye_collect/xcyey_admin/sub/webservice/';//本地测试接口
	public function __construct() {
		$o_sys_setup=new Base_Setup(1);
		$this->S_Key=$o_sys_setup->getXcyeCollectKey();
		$this->S_License=$o_sys_setup->getXcyeCollectLicense();
		$this->S_Url=$o_sys_setup->getXcyeCollectUrl();
	}
	public function getWaitRead($n_uid)
	{
		//因为这个模块带提醒数字图标，所以必须有此方法
		if (! ($n_uid > 0)) {
				//直接退出系统
			return 0;
		}	
		$o_user = new Single_User ( $n_uid );
		$n_count=0;
		if ($o_user->ValidModule ( 120203 )) {
			$o_user = new Student_Onboard_Info_Class_View();
			$o_user->PushWhere ( array ('&&', 'State', '=',2) );
			$n_count=$n_count+$o_user->getAllCount();
		}
		return $n_count;
	}
	public function AuditGetWaitingNumber($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 120203 )) {
			$o_user = new Student_Onboard_Info_Class_View();
			$o_user->PushWhere ( array ('&&', 'State', '=',2) );
			$n_count=$o_user->getAllCount();
		}
		$a_result=array(
			'number'=>$n_count,
			'module_id'=>$this->getPost('id')
		);
		echo(json_encode ($a_result));
	}
	public function YeInfo($n_uid)
	{	
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120201 ))return;//如果没有权限，不返回任何值
		$b_auditor=false;//判断是否为审核员，如果是，那么不能修改幼儿信息
		if ($o_user->ValidModule ( 120203 ))$b_auditor=true;
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
			$a_button = array ();
			if ($o_user->getState($i)==2)
			{
				$s_state_flg=' <span class="label label-warning">待审</span>';
			}
			if ($o_user->getState($i)==3)
			{
				$s_state_flg=' <span class="label label-danger">未批准</span>';
				array_push ( $a_button, array ('查看原因', "dialog_message(' <b>不批准原因：</b>".$o_user->getRejectReason($i)."<br/>您可修改后再次提交进行审批。')" ) );//查看
			}
			
			array_push ( $a_button, array ('查看', "window.open('print.php?id=".$o_user->getStudentId($i)."','_blank')" ) );//查看
			if ($b_auditor==false)
			{
				array_push ( $a_button, array ('修改', "location='ye_modify.php?id=".$o_user->getStudentId($i)."'" ) );//查看
				array_push ( $a_button, array ('调班', "stu_change_class(".$o_user->getStudentId($i).",'".$o_user->getName ( $i )."','".$o_user->getClassName ( $i )."')" ) );//查看
				array_push ( $a_button, array ('离园', "stu_delete(".$o_user->getStudentId($i).")" ) );//查看
			}			
			array_push ( $a_button, array ('下载PDF', "window.open('download_pdf_single.php?id=".$o_user->getStudentId($i)."','_blank')" ) );//查看	
			//检查是否已经绑定
			$o_onboard_wechat=new Student_Onboard_Info_Wechat();
			$o_onboard_wechat->PushWhere ( array ('&&', 'StudentId', '=',$o_user->getStudentId($i)) );
			$s_binding_wx='';
			if ($o_onboard_wechat->getAllCount()>0)
			{
				array_push ( $a_button, array ('解绑', "stu_unbinding(".$o_user->getStudentId($i).")" ) );//查看
				$s_binding_wx='<span class="glyphicon fa fa-weixin" title="已绑定微信" aria-hidden="true" style="color:#2AA144" data-placement="left" data-toggle="tooltip"></span> ';
			}			
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				$s_binding_wx.$o_user->getName ( $i ).$s_state_flg,
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
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'YeInfo', 'yes', $n_page, $a_title, $a_row);
	}
	public function TeacherYeInfo($n_uid)
	{	
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120206 ))return;//如果没有权限，不返回任何值
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
			$a_button = array ();
			if ($o_user->getState($i)==2)
			{
				$s_state_flg=' <span class="label label-warning">待审</span>';
			}			
			array_push ( $a_button, array ('基本信息', "window.open('print.php?id=".$o_user->getStudentId($i)."','_blank')" ) );//查看
			//判断是否已经做过入园问卷
			$o_answer=new Student_Onboard_Survey_Answers();
			$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',1) ); 
			$o_answer->PushWhere ( array ('&&', 'StudentId', '=',$o_user->getStudentId($i)) );
			if ($o_answer->getAllCount()>0)
			{
				array_push ( $a_button, array ('入园答卷', "location='teacher_ye_info_onboard_survey.php?id=".$o_answer->getId(0)."'" ) );
			}
			//检查是否已经绑定
			$o_onboard_wechat=new Student_Onboard_Info_Wechat();
			$o_onboard_wechat->PushWhere ( array ('&&', 'StudentId', '=',$o_user->getStudentId($i)) );
			$s_binding_wx='';
			if ($o_onboard_wechat->getAllCount()>0)
			{
				$s_binding_wx='<span class="glyphicon fa fa-weixin" title="已绑定微信" aria-hidden="true" style="color:#2AA144" data-placement="left" data-toggle="tooltip"></span> ';
			}			
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				$s_binding_wx.$o_user->getName ( $i ).$s_state_flg,
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
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'TeacherYeInfo', 'yes', $n_page, $a_title, $a_row);
	}
	public function YeGraduateTable($n_uid)
	{	
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120205 ))return;//如果没有权限，不返回任何值
		$b_auditor=false;//判断是否为审核员，如果是，那么不能修改幼儿信息
		if ($o_user->ValidModule ( 120203 ))$b_auditor=true;
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Graduate_Info();
		$s_key=$this->getPost('key');
		if ($this->getPost('other_key')!='')
		{
			$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$this->getPost('other_key').'%') );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',$s_key) );
			$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$this->getPost('other_key').'%') );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',$s_key) );
			$o_user->PushWhere ( array ('||', 'ClassNameDiy', 'like','%'.$this->getPost('other_key').'%') );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',$s_key) );
		}else{
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',$s_key) );
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
			$a_button = array ();			
			array_push ( $a_button, array ('查看', "window.open('print.php?id=".$o_user->getStudentId($i)."&graduate=1','_blank')" ) );//查看
			if ($b_auditor==false)
			{
				array_push ( $a_button, array ('撤销毕业', "stu_cancel_graduate(".$o_user->getStudentId($i).",'".$o_user->getName ( $i )."','".$o_user->getClassNameDiy ( $i )."')" ) );//查看
			}		
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				$o_user->getName ( $i ),
				$o_user->getClassNameDiy ( $i ),
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
		$a_title=$this->setTableTitle($a_title,'原班级名称', 'ClassNameDiy', 0, 90);
		$a_title=$this->setTableTitle($a_title,'性别', 'Sex', 0, 40);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件号码', '', 0, 90);
		$a_title=$this->setTableTitle($a_title,'第一监护人', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'YeGraduateTable', 'yes', $n_page, $a_title, $a_row);
	}
	public function YeAuditTable($n_uid)
	{	
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120203 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Onboard_Info_Class_View();
		$o_user->PushWhere ( array ('&&', 'State', '=',2) );
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
			$a_button = array ();
			array_push ( $a_button, array ('进入审核', "location='audit_detail.php?id=".$o_user->getStudentId($i)."'") );//查看
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				$o_user->getName ( $i ),
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
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'YeAuditTable', 'yes', $n_page, $a_title, $a_row);
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
				$this->setReturn ( 'parent.form_return("dialog_error(\'采集系统服务器连接失败，请重试，如无法解决，请联系管理员。\')");' );				
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
				$this->setReturn ( 'parent.form_return("dialog_error(\'采集系统服务器连接失败，请重试，如无法解决，请联系管理员。\')");' );	
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
				LOG::CLASS_UPDATE('error,删除修改班级信息时，验证失败!ClassId：'.$this->getPost('id'));
				$a_general = array (
					'success' => 0,
					'text' =>'采集系统服务器连接失败，请重试，如无法解决，请联系管理员。'
				);
				echo (json_encode ( $a_general ));	
			}
		}
	}
	public function JijiaoGetDate($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120204 ))return; //如果没有权限，不返回任何值
		//删除班级到采集系统
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ));
		$s_result=json_decode($this->HttpsRequest($this->S_Url.'get_count_date.php',$request_data));
		if ($s_result->Flag==1)
		{
			$a_general = array (
				'success' => 1,
				'data' =>$s_result->Data
			);
			echo (json_encode ( $a_general ));
		}else{
			LOG::STU_SYNC('error,获取基教统计报表日期列表时，验证失败!');
			$a_general = array (
				'success' => 0,
				'text' =>'采集系统服务器连接失败，请重试，如无法解决，请联系管理员。'
			);
			echo (json_encode ( $a_general ));	
		}
	}
	public function JijiaoGetDateDetail($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120204 ))return; //如果没有权限，不返回任何值
		//删除班级到采集系统
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'Id'=>$this->Encrypt ($this->getPost('id'), 'E', $this->S_Key ));
		$s_result=json_decode($this->HttpsRequest($this->S_Url.'get_count_date_detail.php',$request_data));
		if ($s_result->Flag==1)
		{
			$a_general = array (
				'success' => 1,
				'data' =>$s_result->Data
			);
			echo (json_encode ( $a_general ));
		}else{
			LOG::STU_SYNC('error,获取基教统计报表日期详细信息时，验证失败!，Id：'.$this->getPost('id'));
			$a_general = array (
				'success' => 0,
				'text' =>'采集系统服务器连接失败，请重试，如无法解决，请联系管理员。'
			);
			echo (json_encode ( $a_general ));	
		}
	}
	public function StuDelete($n_uid) {
		
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120201 )|| $o_user->ValidModule ( 120203 ))return; //如果没有权限，不返回任何值
		$o_table=new Student_Onboard_Info($this->getPost('id'));
		
		//删除幼儿信息到采集系统
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'StudentId'=>$this->Encrypt ($this->getPost('id'), 'E', $this->S_Key ));
		$s_result=json_decode($this->HttpsRequest($this->S_Url.'delete_stu.php',$request_data));
		if ($s_result->Flag==1)
		{
			//成功后,保存本地数据
			$o_class = new Student_Class( $o_table->getClassNumber () );
			$o_table->setClassNameDiy($o_class->getClassName ());	
			$o_table->setOutTime($this->GetDate());
			$o_table->setGradeNumber(0);
			$o_table->setDeptId(0);
			$o_table->setClassNumber(0);
			$o_table->setState(0);
			$o_table->Save();
			//取消微信绑定，查找所有绑定记录，然后循环删除			
			require_once RELATIVITY_PATH . 'sub/wechat/include/userGroup.class.php';
			$o_group = new userGroup();
			$o_binding=new Student_Onboard_Info_Wechat();
			$o_binding->PushWhere ( array ('||', 'StudentId', '=', $this->getPost('id') ) );
			for($i=0;$i<$o_binding->getAllCount();$i++)
			{
				$o_temp=new Student_Onboard_Info_Wechat($o_binding->getId($i));
				//如果该家长没有其他绑定信息，那么删除用户分组
				$o_temp_binding=new Student_Onboard_Info_Wechat();
				$o_temp_binding->PushWhere ( array ('||', 'UserId', '=',$o_temp->getUserId()) );
				$o_temp_binding->PushWhere ( array ('&&', 'Id', '<>',$o_temp->getId()) );
				if ($o_temp_binding->getAllCount()==0)
				{
					//没有其他信息，才删除用户分组
					$o_parent=new WX_User_Info($o_temp->getUserId());
					$o_group->updateGroup($o_parent->getOpenId(),0);
				}				
				$o_temp->Deletion();
			}			
			$a_general = array (
				'success' => 1,
				'text' =>''
			);
			echo (json_encode ( $a_general ));
		}else{
			LOG::STU_SYNC('error,删除幼儿信息信息失败，StudentId：'.$this->getPost('id').'，错误提示：'.$s_result->Msg);
			$a_general = array (
				'success' => 0,
				'text' =>'采集系统幼儿离园失败，请与管理员联系。'
			);
			echo (json_encode ( $a_general ));	
		}
	}
	public function StuUnbinding($n_uid) {
		
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120201 ))return; //如果没有权限，不返回任何值
		//取消微信绑定，查找所有绑定记录，然后循环删除			
		require_once RELATIVITY_PATH . 'sub/wechat/include/userGroup.class.php';
		$o_group = new userGroup();
		$o_binding=new Student_Onboard_Info_Wechat();
		$o_binding->PushWhere ( array ('||', 'StudentId', '=', $this->getPost('id') ) );
		for($i=0;$i<$o_binding->getAllCount();$i++)
		{
			$o_temp=new Student_Onboard_Info_Wechat($o_binding->getId($i));
			//如果该家长没有其他绑定信息，那么删除用户分组
			$o_temp_binding=new Student_Onboard_Info_Wechat();
			$o_temp_binding->PushWhere ( array ('||', 'UserId', '=',$o_temp->getUserId()) );
			$o_temp_binding->PushWhere ( array ('&&', 'Id', '<>',$o_temp->getId()) );
			if ($o_temp_binding->getAllCount()==0)
			{
				//没有其他信息，才删除用户分组
				$o_parent=new WX_User_Info($o_temp->getUserId());
				$o_group->updateGroup($o_parent->getOpenId(),0);
				//清空微信用户电话与姓名信息
				$o_wechat_user=new WX_User_Info($o_temp->getUserId());
				$o_wechat_user->setUserName('');
				$o_wechat_user->setPhone('');
				$o_wechat_user->Save();				
			}				
			$o_temp->Deletion();
		}			
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function StuChangeClass($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120201 )|| $o_user->ValidModule ( 120203 ))return; //如果没有权限，不返回任何值
		$o_table=new Student_Onboard_Info($this->getPost('id'));
		if($this->getPost('classid')=='')
		{
			$a_general = array (
				'success' => 0,
				'text' =>'请选择班级后提交。'
			);
			echo (json_encode ( $a_general ));
			return;
		}
		//调班到采集系统
		$a_data=array(
			'StudentId'=>$this->getPost('id'),
			'ClassId'=>$this->getPost('classid')
		);		
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'Data'=>$this->Encrypt (json_encode($a_data), 'E', $this->S_Key ));
		$s_result=json_decode($this->HttpsRequest($this->S_Url.'stu_change_class.php',$request_data));
		if ($s_result->Flag==1)
		{
			$o_class=new Student_Class($this->getPost('classid'));
			//成功后,保存本地数据
			$o_table->setClassNumber($this->getPost('classid'));
			$o_table->setGrade($o_class->getGrade());
			if ($o_table->Save()==false)
			{
				LOG::STU_SYNC('error,采集系统调班成功后，本地调班写入失败，幼儿ID：'.$this->getPost('id').'，调班ID：'.$this->getPost('classid'));
			}else{
				$a_general = array (
					'success' => 1,
					'text' =>''
				);
				echo (json_encode ( $a_general ));
			}
		}else{
			if ($s_result->Msg=='1004')
			{
				LOG::STU_SYNC('error,调班时采集系统数据库无法写入。幼儿ID：'.$this->getPost('id').'，调班ID：'.$this->getPost('classid'));
				$a_general = array (
					'success' => 0,
					'text' =>'采集系统数据库无法写入。'
				);
				echo (json_encode ( $a_general ));		
			}elseif($s_result->Msg=='1003'||$s_result->Msg=='1002')
			{
				LOG::STU_SYNC('error,调班时无权操作本幼儿或目标班级，幼儿ID：'.$this->getPost('id').'，调班ID：'.$this->getPost('classid'));
				$a_general = array (
					'success' => 0,
					'text' =>'在采集系统中，没有找到指定幼儿或班级。'
				);
				echo (json_encode ( $a_general ));	
			}else{
				LOG::STU_SYNC('error,调班时，验证失败!');
				$a_general = array (
					'success' => 0,
					'text' =>'采集系统服务器连接失败，请重试，如无法解决，请联系管理员。'
				);
				echo (json_encode ( $a_general ));	
			}
		}
	}
	public function StuCancelGraduate($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120205 )|| $o_user->ValidModule ( 120203 ))return; //如果没有权限，不返回任何值
		$o_table=new Student_Graduate_Info($this->getPost('id'));
		if($this->getPost('classid')=='')
		{
			$a_general = array (
				'success' => 0,
				'text' =>'请选择班级后提交。'
			);
			echo (json_encode ( $a_general ));
			return;
		}
		//调班到采集系统
		$a_data=array(
			'StudentId'=>$this->getPost('id'),
			'ClassId'=>$this->getPost('classid')
		);		
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'Data'=>$this->Encrypt (json_encode($a_data), 'E', $this->S_Key ));
		$s_result=json_decode($this->HttpsRequest($this->S_Url.'cancel_graduate.php',$request_data));
		if ($s_result->Flag==1)
		{
			$o_class=new Student_Class($this->getPost('classid'));
			$o_stu = new Student_Graduate_Info ($this->getPost('id'));
			$o_stu->setGradeNumber($o_class->getGrade());
			$o_stu->setClassNumber($o_class->getClassId());
			$o_stu->setClassNameDiy ('');
			$o_stu->setOutTime ('0000-00-00');
			$o_stu->Save ();
			if ($o_stu->Save()==false)
			{
				LOG::STU_SYNC('error,采集系统撤销毕业成功后，本地写入失败，幼儿ID：'.$this->getPost('id').'，调班ID：'.$this->getPost('classid'));
			}else{
				$o_stu = new Student_Graduate_Info();//剪切基础数据
				$o_stu->CutGraduateToOnboard($this->getPost('id'));
				$a_general = array (
					'success' => 1,
					'text' =>''
				);
				echo (json_encode ( $a_general ));
			}
		}else{
			LOG::STU_SYNC('error,撤销毕业时，采集系统失败。幼儿ID：'.$this->getPost('id').'，撤销后班ID：'.$this->getPost('classid'));
				$a_general = array (
					'success' => 0,
					'text' =>'采集系统服务器连接失败，请重试，如无法解决，请联系管理员。'
				);
			echo (json_encode ( $a_general ));		
		}
	}
	public function CheckId()
	{
		$s_checkid=$this->getPost ( 'CheckId' );
		if($this->getPost ( 'CheckId' )=='')
		{
			$s_checkid='8888';
		}
		$s_id=$this->getPost ( 'ID' );
		if($this->getPost ( 'ID' )=='')
		{
			$s_id='8888';
		}
		$o_stu=new Student_Onboard_Info();
		$o_stu->PushWhere ( array ('&&', 'Id', '=', $s_checkid ) );
		$o_stu->PushWhere ( array ('||', 'Id', '=', $s_id ) );
		if ($o_stu->getAllCount()>0)
		{
			$this->setReturn ( 'parent.form_return("dialog_message(\'对不起！<br/>幼儿基本信息的 [证件号] 在您的幼儿园有重复，请更换！\')");' );	
		}
	}
	public function CheckStuCardidFromCaiji($n_id_type,$n_id)
	{
		//判断区里是否有重复的幼儿
		$a_data=array(
				'IdType'=>$n_id_type,
				'Id'=>$n_id
				);
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'Data'=>$this->Encrypt (json_encode($a_data), 'E', $this->S_Key )); 
		$s_result=json_decode($this->HttpsRequest($this->S_Url.'check_stu_cardid.php',$request_data));
		if ($s_result->Flag==1)
		{
		}else if ($s_result->SchoolName!=''){	
		}else{
			LOG::STU_SYNC('error,采集系统审核幼儿信息失败，错误代码：'.$s_result->Msg);
		}
		return $s_result;
	}
	public function StuAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120201 ) || $o_user->ValidModule ( 120203 ))return; //如果没有权限，不返回任何值
		//基本信息
		$o_stu=new Student_Onboard_Info();
		$o_stu->setIdType($this->getPost ( 'IdType' ));
		//验证幼儿ID是否合法
		if($this->getPost ( 'IdType' )=='居民身份证')
		{
			if ($this->validation_filter_id_card($this->getPost ( 'ID' ))==false)$this->ReturnMsg('基本信息的 [幼儿证件号 ] 输入错误！','ID');//验证幼儿ID是否合法
		}
		//验证是否本园重复
		$this->CheckId();
		$o_stu->setId($this->getPost ( 'ID' ));
		if ($this->getPost ( 'Birthday' )=='')$this->ReturnMsg('基本信息的 [出生日期] 不能为空！','Birthday');
		$o_stu->setBirthday($this->getPost ( 'Birthday' ));
		$o_stu=$this->setStuInfo($o_stu);
		//请求接口并接收返回的StudentId
		$o_stu->setStudentId($this->UploadToAddAndModifyStuInfo());
		$o_stu->setState(2);
		$o_stu->Save();
		$this->setReturn ( 'parent.form_return("dialog_success(\'添加幼儿信息成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );	
	}
	public function StuModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120201 )|| $o_user->ValidModule ( 120203 ))return; //如果没有权限，不返回任何值
		//基本信息
		$o_stu=new Student_Onboard_Info($this->getPost ( 'Id' ));
		if ($this->getPost ( 'Birthday' )=='')$this->ReturnMsg('基本信息的 [出生日期] 不能为空！','Birthday');
		$o_stu->setBirthday($this->getPost ( 'Birthday' ));
		$o_stu=$this->setStuInfo($o_stu);
		//请求接口并接收返回的StudentId
		$this->UploadToAddAndModifyStuInfo();
		$o_stu->setState(2);
		$o_stu->Save();
		$this->setReturn ( 'parent.form_return("dialog_success(\'修改幼儿信息成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );	
	}
	public function StuReject($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120203 ))return; //如果没有权限，不返回任何值
		//基本信息
		$o_stu=new Student_Onboard_Info($this->getPost ( 'Id' ));
		if ($o_stu->getState()==2)
		{
			$o_stu->setState ( 3 );
			$o_stu->setRejectReason ( $this->getPost ( 'RejectReason' ));
			$o_stu->Save();
		}		
		$this->setReturn ( 'parent.location=\''.$this->getPost('BackUrl').'\';' );	
	}
	public function StuApprove($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120203 ))return; //如果没有权限，不返回任何值
		//基本信息
		$o_stu=new Student_Onboard_Info($this->getPost ( 'Id' ));
		if ($o_stu->getState()==2)
		{
			if($o_stu->getInTime()=='0000-00-00')
			{
				$o_stu->setInTime ($this->GetDate());
			}
			$o_stu->setOutTime('0000-00-00');
			$o_stu->setState ( 1 );
			$o_stu->setRejectReason ('');
			//判断区里是否有重复的幼儿
			$a_data=array(
					'StudentId'=>$o_stu->getStudentId(),
					'IdType'=>$o_stu->getIdType(),
					'Id'=>$o_stu->getId()
					);
			$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'Data'=>$this->Encrypt (json_encode($a_data), 'E', $this->S_Key )); 
			$s_result=json_decode($this->HttpsRequest($this->S_Url.'audit_stu.php',$request_data));
			if ($s_result->Flag==1)
			{
				//审核通过
				$o_stu->Save();
				$this->setReturn ( 'parent.form_return("dialog_success(\'幼儿信息审核通过成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
			}else if ($s_result->SchoolName!=''){
				$this->setReturn ( 'parent.form_return("dialog_message(\'对不起，该幼儿的<b>“证件信息”</b>在西城区采集系统中有重复，不能审核通过，如有问题请与西城区学前科联系，重复信息如下：<br/><br/><b>幼儿园名称：</b>'.$s_result->SchoolName.'<br/><b>班级名称：</b>'.$s_result->ClassName.'<br/><b>幼儿姓名：</b>'.$s_result->Name.'<br/><b>证件类型：</b>'.$o_stu->getIdType().'<br/><b>证件号：</b>'.$o_stu->getId().'<br/>\')");' );	
			}else{
				LOG::STU_SYNC('error,采集系统审核幼儿信息失败，错误代码：'.$s_result->Msg);
				$this->setReturn ( 'parent.form_return("dialog_error(\'采集系统添加幼儿信息失败，请与管理员联系。\')");' );	
			}
		}
		$this->setReturn ( 'parent.location=\''.$this->getPost('BackUrl').'\';' );	
	}
	protected function UploadToAddAndModifyStuInfo()
	{
		$a_data=array(
				'StudentId'=>$this->getPost ( 'Id' ),
				'ClassId'=>$this->getPost('ClassId'),
				'Id'=>$this->getPost('ID'),
				'IdType'=>$this->getPost('IdType'),
				'Birthday'=>$this->getPost('Birthday'),
				'Name'=>$this->getPost('Name'),
				'Sex'=>$this->getPost('Sex'),
				'Nationality'=>$this->getPost('Nationality'),
				'Gangao'=>$this->getPost('Gangao'),
				'Nation'=>$this->getPost('Nation'),
				'Only'=>$this->getPost('Only'),
				'OnlyCode'=>$this->getPost('OnlyCode'),
				'IsFirst'=>$this->getPost('IsFirst'),
				'IsLieshi'=>$this->getPost('IsLieshi'),
				'IsGuer'=>$this->getPost('IsGuer'),
				'IsWugong'=>$this->getPost('IsWugong'),
				'IsLiushou'=>$this->getPost('IsLiushou'),
				'IsDibao'=>$this->getPost('IsDibao'),
				'DibaoCode'=>$this->getPost('DibaoCode'),
				'IsZizhu'=>$this->getPost('IsZizhu'),
				'IsCanji'=>$this->getPost('IsCanji'),
				'CanjiCode'=>$this->getPost('CanjiCode'),
				'CanjiType'=>$this->getPost('CanjiType'),
				'Jiankang'=>$this->getPost('Jiankang'),
				'Xuexing'=>$this->getPost('Xuexing'),
				'IsYiwang'=>$this->getPost('IsYiwang'),
				'Illness'=>$this->getPost('Illness'),
				'IsShoushu'=>$this->getPost('IsShoushu'),
				'Shoushu'=>$this->getPost('Shoushu'),
				'IsYizhi'=>$this->getPost('IsYizhi'),
				'IsGuomin'=>$this->getPost('IsGuomin'),
				'Allergic'=>$this->getPost('Allergic'),
				'IsYichuan'=>$this->getPost('IsYichuan'),
				'Qitabingshi'=>$this->getPost('Qitabingshi'),
				'Beizhu'=>$this->getPost('Beizhu'),
				'C_City'=>$this->getPost('CCity'),
				'C_Area'=>$this->getPost('CArea'),
				'C_Street'=>$this->getPost('CStreet'),
				'IdQuality'=>$this->getPost('IdQuality'),
				'IdQualityType'=>$this->getPost('IdQualityType'),
				'H_City'=>$this->getPost('HCity'),
				'H_Area'=>$this->getPost('HArea'),
				'H_Street'=>$this->getPost('HStreet'),
				'H_Shequ'=>$this->getPost('HShequ'),
				'H_Add'=>$this->getPost('HAdd'),
				'H_Owner'=>$this->getPost('HOwner'),
				'H_Guanxi'=>$this->getPost('HGuanxi'),
				'Z_Same'=>$this->getPost('ZSame'),
				'Z_City'=>$this->getPost('ZCity'),
				'Z_Area'=>$this->getPost('ZArea'),
				'Z_Street'=>$this->getPost('ZStreet'),
				'Z_Shequ'=>$this->getPost('ZShequ'),
				'Z_Add'=>$this->getPost('ZAdd'),
				'Z_Property'=>$this->getPost('ZProperty'),
				'Z_Owner'=>$this->getPost('ZOwner'),
				'Z_Guanxi'=>$this->getPost('ZGuanxi'),
				'Jh_1_Connection'=>$this->getPost('Jh1Connection'),
				'Jh_1_Name'=>$this->getPost('Jh1Name'),
				'Jh_1_IdType'=>$this->getPost('Jh1IdType'),
				'Jh_1_Id'=>$this->getPost('Jh1ID'),
				'Jh_1_Job'=>$this->getPost('Jh1Job'),
				'Jh_1_Danwei'=>$this->getPost('Jh1Danwei'),
				'Jh_1_Jiaoyu'=>$this->getPost('Jh1Jiaoyu'),
				'Jh_1_Phone'=>$this->getPost('Jh1Phone'),
				'Jh_1_IsCanji'=>$this->getPost('Jh1IsCanji'),
				'Jh_1_CanjiCode'=>$this->getPost('Jh1CanjiCode'),
				'Jh_1_IsZhixi'=>$this->getPost('Jh1IsZhixi'),
				'Jh_2_Connection'=>$this->getPost('Jh2Connection'),
				'Jh_2_Name'=>$this->getPost('Jh2Name'),
				'Jh_2_IdType'=>$this->getPost('Jh2IdType'),
				'Jh_2_Id'=>$this->getPost('Jh2ID'),
				'Jh_2_Job'=>$this->getPost('Jh2Job'),
				'Jh_2_Danwei'=>$this->getPost('Jh2Danwei'),
				'Jh_2_Jiaoyu'=>$this->getPost('Jh2Jiaoyu'),
				'Jh_2_Phone'=>$this->getPost('Jh2Phone'),
				'Jh_2_IsCanji'=>$this->getPost('Jh2IsCanji'),
				'Jh_2_CanjiCode'=>$this->getPost('Jh2CanjiCode'),
				'Jh_2_IsZhixi'=>$this->getPost('Jh2IsZhixi'),
				'JianhuName'=>$this->getPost('JianhuName'),
				'JianhuConnection'=>$this->getPost('JianhuConnection'),
				'JianhuPhone'=>$this->getPost('JianhuPhone'),
				'Jiudu'=>$this->getPost('Jiudu'),
				);	
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'Data'=>$this->Encrypt (json_encode($a_data), 'E', $this->S_Key ));
		if($this->getPost ( 'Id' )>0)
		{
			//修改
			$s_result=json_decode($this->HttpsRequest($this->S_Url.'modify_stu.php',$request_data));
			if ($s_result->Flag!=1)	
			{
				LOG::STU_SYNC('error,采集系统修改幼儿信息失败，StudentId：'.$this->getPost ( 'Id' ).'，错误代码：'.$s_result->Msg);
				$this->setReturn ( 'parent.form_return("dialog_error(\'采集系统添修改幼儿信息失败，请与管理员联系。\')");' );		
			}
		}else{
			//添加
			$s_result=json_decode($this->HttpsRequest($this->S_Url.'add_stu.php',$request_data));
			if ($s_result->Flag==1)	
			{
				return $s_result->StudentId;
			}else{
				LOG::STU_SYNC('error,采集系统添加幼儿信息失败，错误代码：'.$s_result->Msg);
				$this->setReturn ( 'parent.form_return("dialog_error(\'采集系统添加幼儿信息失败，请与管理员联系。\')");' );		
			}
		}
	}
	public function UploadToAddStuInfoForAssignClass($o_user,$n_class_id)
	{
		$a_data=array(
				'ClassId'=>$n_class_id,
				'Id'=>$o_user->getId(),
				'IdType'=>$o_user->getIdType(),
				'Birthday'=>$o_user->getBirthday(),
				'Name'=>$o_user->getName(),
				'Sex'=>$o_user->getSex(),
				'Nationality'=>$o_user->getNationality(),
				'Gangao'=>$o_user->getGangao(),
				'Nation'=>$o_user->getNation(),
				'Only'=>$o_user->getOnly(),
				'OnlyCode'=>$o_user->getOnlyCode(),
				'IsFirst'=>$o_user->getIsFirst(),
				'IsLieshi'=>$o_user->getIsLieshi(),
				'IsGuer'=>$o_user->getIsGuer(),
				'IsWugong'=>$o_user->getIsWugong(),
				'IsLiushou'=>$o_user->getIsLiushou(),
				'IsDibao'=>$o_user->getIsDibao(),
				'DibaoCode'=>$o_user->getDibaoCode(),
				'IsZizhu'=>$o_user->getIsZizhu(),
				'IsCanji'=>$o_user->getIsCanji(),
				'CanjiCode'=>$o_user->getCanjiCode(),
				'CanjiType'=>$o_user->getCanjiType(),
				'Jiankang'=>$o_user->getJiankang(),
				'Xuexing'=>$o_user->getXuexing(),
				'IsYiwang'=>$o_user->getIsYiwang(),
				'Illness'=>$o_user->getIllness(),
				'IsShoushu'=>$o_user->getIsShoushu(),
				'Shoushu'=>$o_user->getShoushu(),
				'IsYizhi'=>$o_user->getIsYizhi(),
				'IsGuomin'=>$o_user->getIsGuomin(),
				'Allergic'=>$o_user->getAllergic(),
				'IsYichuan'=>$o_user->getIsYichuan(),
				'Qitabingshi'=>$o_user->getQitabingshi(),
				'Beizhu'=>$o_user->getBeizhu(),
				'H_Code'=>$o_user->getHCode(),
				'BirthdayCode'=>$o_user->getBirthdayCode(),
				'Birthplace'=>$o_user->getBirthplace(),
				'IdQuality'=>$o_user->getIdQuality(),
				'IdQualityType'=>$o_user->getIdQualityType(),
				'H_City'=>$o_user->getHCity(),
				'H_Area'=>$o_user->getHArea(),
				'H_Street'=>$o_user->getHStreet(),
				'H_Shequ'=>$o_user->getHShequ(),
				'H_Add'=>$o_user->getHAdd(),
				'H_Owner'=>$o_user->getHOwner(),
				'H_Guanxi'=>$o_user->getHGuanxi(),
				'Z_Same'=>$o_user->getZSame(),
				'Z_City'=>$o_user->getZCity(),
				'Z_Area'=>$o_user->getZArea(),
				'Z_Street'=>$o_user->getZStreet(),
				'Z_Shequ'=>$o_user->getZShequ(),
				'Z_Add'=>$o_user->getZAdd(),
				'Z_Property'=>$o_user->getZProperty(),
				'Z_Owner'=>$o_user->getZOwner(),
				'Z_Guanxi'=>$o_user->getZGuanxi(),
				'Jh_1_Connection'=>$o_user->getJh1Connection(),
				'Jh_1_Name'=>$o_user->getJh1Name(),
				'Jh_1_IdType'=>$o_user->getJh1IdType(),
				'Jh_1_Id'=>$o_user->getJh1Id(),
				'Jh_1_Job'=>$o_user->getJh1Job(),
				'Jh_1_Danwei'=>$o_user->getJh1Danwei(),
				'Jh_1_Jiaoyu'=>$o_user->getJh1Jiaoyu(),
				'Jh_1_Phone'=>$o_user->getJh1Phone(),
				'Jh_1_IsCanji'=>$o_user->getJh1IsCanji(),
				'Jh_1_CanjiCode'=>$o_user->getJh1CanjiCode(),
				'Jh_1_IsZhixi'=>$o_user->getJh1IsZhixi(),
				'Jh_2_Connection'=>$o_user->getJh2Connection(),
				'Jh_2_Name'=>$o_user->getJh2Name(),
				'Jh_2_IdType'=>$o_user->getJh2IdType(),
				'Jh_2_Id'=>$o_user->getJh2Id(),
				'Jh_2_Job'=>$o_user->getJh2Job(),
				'Jh_2_Danwei'=>$o_user->getJh2Danwei(),
				'Jh_2_Jiaoyu'=>$o_user->getJh2Jiaoyu(),
				'Jh_2_Phone'=>$o_user->getJh2Phone(),
				'Jh_2_IsCanji'=>$o_user->getJh2IsCanji(),
				'Jh_2_CanjiCode'=>$o_user->getJh2CanjiCode(),
				'Jh_2_IsZhixi'=>$o_user->getJh2IsZhixi(),
				'JianhuName'=>$o_user->getJianhuName(),
				'JianhuConnection'=>$o_user->getJianhuConnection(),
				'JianhuPhone'=>$o_user->getJianhuPhone(),
				'Jiudu'=>$o_user->getJiudu()
				);	
		$request_data = array('License'=>$this->Encrypt ( $this->S_License, 'E', $this->S_Key ),'Data'=>$this->Encrypt (json_encode($a_data), 'E', $this->S_Key ));
		$s_result=json_decode($this->HttpsRequest($this->S_Url.'stu_assign_class.php',$request_data));
		if ($s_result->Flag==1)
		{
		}else{
			LOG::STU_SYNC('error,采集系统添加分班幼儿信息失败，错误代码：'.$s_result->Msg);	
		}
		return $s_result;
	}
	protected function ReturnMsg($s_msg,$id)
	{
		$this->setReturn ( 'parent.form_return("dialog_message(\''.$s_msg.'\')");' );	
	}
	protected function setStuInfo($o_stu)
	{
		//基本信息
		if ($this->getPost ( 'Name' )=='')$this->ReturnMsg('基本信息的 [幼儿姓名] 不能为空！','Name');
		$o_stu->setName($this->getPost ( 'Name' ));
		$o_stu->setSex($this->getPost ( 'Sex' ));
		
		//flag归零
		$o_stu->setFlagThree(0);
		$o_stu->setFlagXicheng(0);
		$o_stu->setFlagSame(0);
		$o_stu->setFlagOnly(0);
		$o_stu->setFlagFirst(0);
		$o_stu->setNationality($this->getPost ( 'Nationality' ));
		$o_stu->setGangao($this->getPost ( 'Gangao' ));
		if($this->getPost ( 'Nationality' )=='中国')
		{
			$o_stu->setNation($this->getPost ( 'Nation' ));
		    $o_stu->setOnly($this->getPost ( 'Only' ));
		    if ($this->getPost ( 'Only' )=='否')
		    {
		    	$o_stu->setIsFirst($this->getPost ( 'IsFirst' ));
		    	$o_stu->setOnlyCode('');
		    }else{
		    	$o_stu->setIsFirst('');
		    	$o_stu->setOnlyCode($this->getPost ( 'OnlyCode' ));
		    }
		    $o_stu->setIsLieshi($this->getPost ( 'IsLieshi' )); 
		    $o_stu->setIsGuer($this->getPost ( 'IsGuer' ));
		    $o_stu->setIsWugong($this->getPost ( 'IsWugong' ));
		    $o_stu->setIsLiushou($this->getPost ( 'IsLiushou' ));
		    $o_stu->setIsDibao($this->getPost ( 'IsDibao' ));
			//是否低保，要低保证号
		    if ($this->getPost ( 'IsDibao' )=='是')
		    {
		    	if ($this->getPost ( 'DibaoCode' )=='')$this->ReturnMsg('基本信息的 [低保证号]不能为空 ！','DibaoCode');
		    	$o_stu->setDibaoCode($this->getPost ( 'DibaoCode' ));
		    }else{
		    	$o_stu->setDibaoCode('');
		    }
		    $o_stu->setIsZizhu($this->getPost ( 'IsZizhu' ));
		    $o_stu->setIsCanji($this->getPost ( 'IsCanji' ));
		    //验证残疾儿童
		    if ($this->getPost ( 'IsCanji' )=='是')
		    {
		    	if ($this->getPost ( 'CanjiType' )=='')$this->ReturnMsg('请选择基本信息的 [残疾幼儿类别] ！','CanjiType');
		    	if ($this->getPost ( 'CanjiCode' )=='')$this->ReturnMsg('基本信息的 [幼儿残疾证号] 不能为空！','CanjiCode');
		    	$o_stu->setCanjiType($this->getPost ( 'CanjiType' ));
		    	$o_stu->setCanjiCode($this->getPost ( 'CanjiCode' ));
		    }else{
		    	$o_stu->setCanjiType('');
		    	$o_stu->setCanjiCode('');
		    }
		}else{
			$o_stu->setNation('');
		    $o_stu->setOnly('');
		    $o_stu->setOnlyCode('');
		    $o_stu->setIsFirst('');
		    $o_stu->setIsLieshi(''); 
		    $o_stu->setIsGuer('');
		    $o_stu->setIsWugong('');
		    $o_stu->setIsLiushou('');
		    $o_stu->setIsDibao('');
		    $o_stu->setDibaoCode('');
		    $o_stu->setIsZizhu('');
		    $o_stu->setIsCanji('');
		    $o_stu->setCanjiType('');
		    $o_stu->setCanjiCode('');
		    
		}
		$o_stu->setJiankang($this->getPost ( 'Jiankang' ));
		$o_stu->setXuexing($this->getPost ( 'Xuexing' ));
		$o_stu->setIsYiwang($this->getPost ( 'IsYiwang' ));
		//验证过敏源
	    if ($this->getPost ( 'IsYiwang' )=='是')
	    {
	    	if ($this->getPost ( 'Illness' )=='')$this->ReturnMsg('请选择基本信息的 [以往病史] ！','Illness');
	    	$o_stu->setIllness($this->getPost ( 'Illness' ));
	    }else{
	    	$o_stu->setIllness('');
	    }
		$o_stu->setIsShoushu($this->getPost ( 'IsShoushu' ));
	    //验证手术名称
	    if ($this->getPost ( 'IsShoushu' )=='是')
	    {
	    	if ($this->getPost ( 'Shoushu' )=='')$this->ReturnMsg('健康信息的 [手术名称] 不能为空！','Shoushu');
	    	$o_stu->setShoushu($this->getPost ( 'Shoushu' ));
	    }else{
	    	$o_stu->setShoushu('');
	    }
	    $o_stu->setIsYizhi($this->getPost ( 'IsYizhi' ));
	    $o_stu->setIsGuomin($this->getPost ( 'IsGuomin' ));
	    //验证过敏源
	    if ($this->getPost ( 'IsGuomin' )=='是')
	    {
	    	if ($this->getPost ( 'Allergic' )=='')$this->ReturnMsg('健康信息的 [过敏源] 不能为空！','Allergic');
	    	$o_stu->setAllergic($this->getPost ( 'Allergic' ));
	    }else{
	    	$o_stu->setAllergic('');
	    }
		$o_stu->setIsYichuan($this->getPost ( 'IsYichuan' ));
	    //验证过敏源
	    if ($this->getPost ( 'IsYichuan' )=='是')
	    {
	    	if ($this->getPost ( 'Qitabingshi' )=='')$this->ReturnMsg('健康信息的 [家族遗传病史名称] 不能为空！','Qitabingshi');
	    	$o_stu->setQitabingshi($this->getPost ( 'Qitabingshi' ));
	    }else{
	    	$o_stu->setQitabingshi('');
	    }
	    $o_stu->setBeizhu($this->getPost ( 'Beizhu' ));
	    $o_stu->setFlageXicheng(0);
	    if($this->getPost ( 'Nationality' )=='中国')
	    {
	    	$s_birthpace='';
	    	$s_birthpacecode='';
		    if ($this->getPost ( 'CCity' )=='')$this->ReturnMsg('请选择户籍信息的 [出生所在（省/市）] ！','CCity');
		    //获取城市名称
		    $o_city=new Student_City_Code($this->getPost ( 'CCity' )); 
		    $s_birthpace=$o_city->getName();
		    if (isset($_POST['Vcl_CArea']))
		    {
		    	if ($this->getPost ( 'CArea' )=='')$this->ReturnMsg('请选择户籍信息的 [出生所在（市/区）] ！','CArea');
		    	$o_city=new Student_City_Code($this->getPost ( 'CArea' )); 
		    	$s_birthpace.=$o_city->getName();
		    	$s_birthpacecode=$this->getPost ( 'CArea' );
		    }
	    	if (isset($_POST['Vcl_CStreet']))
		    {
		    	if ($this->getPost ( 'CStreet' )=='')$this->ReturnMsg('请选择户籍信息的 [出生所在（区/县）] ！','CArea');
		    	$o_city=new Student_City_Code($this->getPost ( 'CStreet' )); 
		    	$s_birthpace.=$o_city->getName();
		    	$s_birthpacecode=$this->getPost ( 'CStreet' );
		    } 
		    $o_stu->setBirthplace($s_birthpace);
		    $o_stu->setBirthplaceCode($s_birthpacecode);
		    $o_stu->setIdQuality($this->getPost ( 'IdQuality' ));
		    if ($this->getPost ( 'IdQuality' )=='非农业户口')
		    {
		    	$o_stu->setIdQualityType($this->getPost ( 'IdQualityType' ));
		    }else{
		    	$o_stu->setIdQualityType('');
		    }
		    $o_city=new Student_City_Code($this->getPost ( 'HCity' ));    
		    $o_stu->setHCity($o_city->getName());
		    //验证户籍信息
		    $o_stu->setHArea('');
		    $o_stu->setHShequ('');
		    $o_stu->setHStreet('');
		    //-----------填写户籍信息
		    $o_city=new Student_City_Code($this->getPost ( 'HArea' ));    
		    $o_stu->setHArea($o_city->getName());
		    $o_stu->setHCode($this->getPost ( 'HArea' ));
		    if ($this->getPost ( 'HCity' )=='')$this->ReturnMsg('请选择户籍信息的 [户籍所在（省/市）] ！','HCity');		    
		    if($this->getPost ( 'HCity' )=='110000000000' && $this->getPost ( 'HArea' )=='110102000000')
		    {
		    	if ($this->getPost ( 'HStreet' )=='')$this->ReturnMsg('请选择户籍信息的 [户籍所在街道]！','HStreet');
		    	if ($this->getPost ( 'HShequ' )=='')$this->ReturnMsg('请选择户籍信息的 [户籍所在社区] ！','HShequ');
		    	$o_stu->setFlageXicheng(1);//添加户籍为西城的标志
		    	$o_stu->setHShequ($this->getPost ( 'HShequ' ));
		    	$o_stu->setHStreet($this->getPost ( 'HStreet' ));
		    }else{
		    	if (isset($_POST['Vcl_HArea'])) 
		    	{
		    		if ($this->getPost ( 'HArea' )=='')$this->ReturnMsg('请选择户籍信息的 [户籍所在（市/区）] ！','HArea');
		    	}
		    	if (isset($_POST['Vcl_HStreet']))
			    {
			    	if ($this->getPost ( 'HStreet' )=='')$this->ReturnMsg('请选择户籍信息的 [户籍所在（区/县）] ！','HStreet');
			    	$o_city=new Student_City_Code($this->getPost ( 'HStreet' )); 
			    	$o_stu->setHCode($this->getPost ( 'HStreet' ));
			    	$o_stu->setHStreet($o_city->getName());
			    } 
		    }  
		    if ($this->getPost ( 'HAdd' )=='')$this->ReturnMsg('户籍信息的 [户籍详细地址] 不能为空！','HAdd');
		    $o_stu->setHAdd($this->getPost ( 'HAdd' ));
		    if ($this->getPost ( 'HOwner' )=='')$this->ReturnMsg('户籍信息的 [户主姓名] 不能为空！','HOwner');
		    $o_stu->setHOwner($this->getPost ( 'HOwner' ));
		    $o_stu->setHGuanxi($this->getPost ( 'HGuanxi' ));
	    }else{
		    $o_stu->setBirthplace('');
		    $o_stu->setIdQuality('');
		    $o_stu->setIdQualityType('');    
		    $o_stu->setHCity('');
		    $o_stu->setHCode('');
		    //验证户籍信息
		    $o_stu->setHArea('');
		    $o_stu->setHShequ('');
		    $o_stu->setHStreet('');
		    $o_stu->setHShequ('');
		    $o_stu->setHStreet('');
		    $o_stu->setHAdd('');
		    $o_stu->setHOwner('');
		    $o_stu->setHGuanxi('');
	    }
	    //验证现住址信息
	    $o_stu->setZSame($this->getPost ( 'ZSame' ));
	    $o_stu->setZCity('');
	    $o_stu->setZArea('');
	    $o_stu->setZShequ('');
		$o_stu->setZStreet('');
	    if($this->getPost ( 'ZSame' )=='是')
	    {
	    	//复制户籍信息
	    	if($this->getPost ( 'HCity' )=='北京市')
	    	{
	    		if($this->getPost ( 'HArea' )=='西城区')
	    		{
	    			$o_stu->setFlagSame(1);//添加房户一致的标志
	    		}
	    	}
	    	$o_stu->setZAdd($this->getPost ( 'HAdd' ));
	    }else{	    	
	    	$o_stu->setZCity($this->getPost ( 'ZCity' ));
	    	//继续验证现住址信息
	    	if($this->getPost ( 'ZCity' )=='北京市')
		    {
		    	$o_stu->setZArea($this->getPost ( 'ZArea' ));
		    	if($this->getPost ( 'ZArea' )=='西城区')
		    	{
		    		if ($this->getPost ( 'ZStreet' )=='')$this->ReturnMsg('请选择现住址信息的 [现住址所在街道]！','ZStreet');
		    		if ($this->getPost ( 'ZShequ' )=='')$this->ReturnMsg('请选择现住址信息的 [现住址所在社区]！','ZShequ');
		    		$o_stu->setZShequ($this->getPost ( 'ZShequ' ));
		    		$o_stu->setZStreet($this->getPost ( 'ZStreet' ));
		    	}
		    }
		    if ($this->getPost ( 'ZAdd' )=='')$this->ReturnMsg('现住址信息的 [现住址详细地址] 不能为空！','HAdd');
		    $o_stu->setZAdd($this->getPost ( 'ZAdd' ));
	    }
	    //现住址房屋属性
	    $o_stu->setZProperty($this->getPost ( 'ZProperty' ));
	    if($this->getPost ( 'ZProperty' )=='直系亲属房产')
	    {
	    	if ($this->getPost ( 'ZOwner' )=='')$this->ReturnMsg('现住址信息的 [产权人姓名] 不能为空！','ZOwner');
	    	$o_stu->setZOwner($this->getPost ( 'ZOwner' ));
	    	$o_stu->setZGuanxi($this->getPost ( 'ZGuanxi' ));
	    }else{
	    	$o_stu->setZOwner('');
	    	$o_stu->setZGuanxi('');
	    }
	    //验证第一法定监护人信息
	    $o_stu->setJh1Connection($this->getPost ( 'Jh1Connection' )); 
	    if ($this->getPost ( 'Jh1Name' )=='')$this->ReturnMsg('第一法定监护人信息的 [姓名] 不能为空！','Jh1Name');
	    $o_stu->setJh1Name($this->getPost ( 'Jh1Name' ));
		$o_stu->setJh1IdType($this->getPost ( 'Jh1IdType' ));
		if($this->getPost ( 'Jh1IdType' )=='居民身份证')
		{
			if ($this->validation_filter_id_card($this->getPost ( 'Jh1ID' ))==false)$this->ReturnMsg('第一法定监护人信息的 [身份证] 输入错误！','Jh1ID');//验证幼儿ID是否合法
		}
	    $o_stu->setJh1Id($this->getPost ( 'Jh1ID' ));
	    $o_stu->setJh1IsZhixi($this->getPost ( 'Jh1IsZhixi' ));
	    if ($this->getPost ( 'Jh1Job' )=='')$this->ReturnMsg('请选择第一法定监护人信息的 [职业状况] ！','Jh1Job');
	    $o_stu->setJh1Job($this->getPost ( 'Jh1Job' ));
	    if ($this->getPost ( 'Jh1Danwei' )=='')$this->ReturnMsg('请选择第一法定监护人信息的 [工作单位全称] ！','Jh1Danwei');
	    $o_stu->setJh1Danwei($this->getPost ( 'Jh1Danwei' ));
	    if ($this->getPost ( 'Jh1Jiaoyu' )=='')$this->ReturnMsg('请选择第一法定监护人信息的 [教育程度] ！','Jh1Jiaoyu');
	    $o_stu->setJh1Jiaoyu($this->getPost ( 'Jh1Jiaoyu' ));
	    if ($this->getPost ( 'Jh1Phone' )=='')$this->ReturnMsg('第一法定监护人信息的 [联系电话] 不能为空！','Jh1Phone');
	    $o_stu->setJh1Phone($this->getPost ( 'Jh1Phone' ));
	    $o_stu->setJh1IsCanji($this->getPost ( 'Jh1IsCanji' ));
	    if ($this->getPost ( 'Jh1IsCanji' )=='是')
	    {
	    	//if ($this->getPost ( 'Jh1CanjiCode' )=='')$this->ReturnMsg('第一法定监护人信息的 [残疾证号] 不能为空！','Jh1CanjiCode');
	    	$o_stu->setJh1CanjiCode($this->getPost ( 'Jh1CanjiCode' ));
	    }else{
	    	$o_stu->setJh1CanjiCode('');
	    }
		//验证第二法定监护人信息,如果姓名填写了，那么其他信息也要填写
		if ($this->getPost ( 'Jh2Name' )!='')
		{
		    $o_stu->setJh2Connection($this->getPost ( 'Jh2Connection' )); 
		    if ($this->getPost ( 'Jh2Name' )=='')$this->ReturnMsg('第二法定监护人信息的 [姓名] 不能为空！','Jh2Name');
		    $o_stu->setJh2Name($this->getPost ( 'Jh2Name' ));
		    if ($this->getPost ( 'Jh2IdType' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [证件类型] ！','Jh2IdType');
			$o_stu->setJh2IdType($this->getPost ( 'Jh2IdType' ));
			if($this->getPost ( 'Jh2IdType' )=='居民身份证')
			{
				if ($this->validation_filter_id_card($this->getPost ( 'Jh2ID' ))==false)$this->ReturnMsg('第二法定监护人信息的 [身份证] 输入错误！','Jh2ID');//验证幼儿ID是否合法
			}
		    $o_stu->setJh2Id($this->getPost ( 'Jh2ID' ));
		    if ($this->getPost ( 'Jh2IsZhixi' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [是否是直系亲属] ！','Jh2IsZhixi');
		    $o_stu->setJh2IsZhixi($this->getPost ( 'Jh2IsZhixi' ));
		    if ($this->getPost ( 'Jh2Job' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [职业状况] ！','Jh2Job');
		    $o_stu->setJh2Job($this->getPost ( 'Jh2Job' ));
		    if ($this->getPost ( 'Jh2Danwei' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [工作单位全称] ！','Jh2Danwei');
		    $o_stu->setJh2Danwei($this->getPost ( 'Jh2Danwei' ));
		    if ($this->getPost ( 'Jh2Jiaoyu' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [教育程度] ！','Jh2Jiaoyu');
		    $o_stu->setJh2Jiaoyu($this->getPost ( 'Jh2Jiaoyu' ));
		    if ($this->getPost ( 'Jh2Phone' )=='')$this->ReturnMsg('第二法定监护人信息的 [联系电话] 不能为空！','Jh2Phone');
		    $o_stu->setJh2Phone($this->getPost ( 'Jh2Phone' ));
		    $o_stu->setJh2IsCanji($this->getPost ( 'Jh2IsCanji' ));
		     if ($this->getPost ( 'Jh2IsCanji' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [是否残疾] ！','Jh2IsCanji');
		    if ($this->getPost ( 'Jh2IsCanji' )=='是')
		    {
		    	if ($this->getPost ( 'Jh2CanjiCode' )=='')$this->ReturnMsg('第二法定监护人信息的 [残疾证号] 不能为空！','Jh2CanjiCode');
		    	$o_stu->setJh2CanjiCode($this->getPost ( 'Jh2CanjiCode' ));
		    }else{
		    	$o_stu->setJh2CanjiCode('');
		    }
		}else{
			$o_stu->setJh2Connection(''); 
			$o_stu->setJh2Name('');
			$o_stu->setJh2IdType('');
			$o_stu->setJh2Id('');
		    $o_stu->setJh2IsZhixi('');
			$o_stu->setJh2Job('');
			$o_stu->setJh2Jiaoyu('');
			$o_stu->setJh2Phone('');
		    $o_stu->setJh2IsCanji('');
			$o_stu->setJh2CanjiCode('');
		}
		if($this->getPost ( 'JianhuName' )!='')
		{
			if ($this->getPost ( 'JianhuConnection' )=='')$this->ReturnMsg('请选择其他监护人信息的 [关系] ！','JianhuConnection');
			$o_stu->setJianhuConnection($this->getPost ( 'JianhuConnection' ));
	    	if ($this->getPost ( 'JianhuName' )=='')$this->ReturnMsg('其他监护人信息的 [姓名] 不能为空！','JianhuName');
			$o_stu->setJianhuName($this->getPost ( 'JianhuName' ));
			if ($this->getPost ( 'JianhuPhone' )=='')$this->ReturnMsg('其他监护人信息的 [联系电话] 不能为空！','JianhuPhone');
	    	$o_stu->setJianhuPhone($this->getPost ( 'JianhuPhone' ));
		}else{
			$o_stu->setJianhuConnection('');
			$o_stu->setJianhuName('');
	    	$o_stu->setJianhuPhone('');
		}
	    //设置flag
	    //是否满三岁，出生日期加3年，必须小于今年的8月31日
	    $a_year=array();
	    $a_year=explode('-', $this->getPost ( 'Birthday' ));
	    $a_year[0]=$a_year[0]+3;
	    $o_date = new DateTime('Asia/Chongqing');
		$s_now=$o_date->format('Y') . '-09-01';
	    $s_birthday=$a_year[0] . '-' . $a_year[1] . '-' . $a_year[2];
	    if (strtotime($s_birthday)<strtotime($s_now))
	    {
	    	$o_stu->setFlagThree(1);
	    }
	    //是否独生子女
	    if($this->getPost ( 'Only' )=='是')
	    {
	    	$o_stu->setFlagOnly(1);
	    }elseif ($this->getPost ( 'IsFirst' )=='是'){
	    	//是否头胎
	    	$o_stu->setFlagFirst(1);
	    }
	    $o_class=new Student_Class($this->getPost('ClassId'));
	    $o_stu->setDeptId($o_class->getSchoolId());
		$o_stu->setGradeNumber($o_class->getGrade());
		$o_stu->setClassNumber($o_class->getClassId());
		//$o_stu->setInTime($this->getPost('InTime'));取消入园日期
		$o_stu->setJiudu($this->getPost('Jiudu'));
		return $o_stu;
	}
	protected function validation_filter_id_card($id_card) {
		if (strlen ( $id_card ) == 18) {
			return $this->idcard_checksum18 ( $id_card );
		} elseif ((strlen ( $id_card ) == 15)) {
			$id_card = $this->idcard_15to18 ( $id_card );
			return $this->idcard_checksum18 ( $id_card );
		} else {
			return false;
		}
	}
	// 计算身份证校验码，根据国家标准GB 11643-1999 
	protected function idcard_verify_number($idcard_base) {
		if (strlen ( $idcard_base ) != 17) {
			return false;
		}
		//加权因子 
		$factor = array (7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 );
		//校验码对应值 
		$verify_number_list = array ('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2' );
		$checksum = 0;
		for($i = 0; $i < strlen ( $idcard_base ); $i ++) {
			$checksum += substr ( $idcard_base, $i, 1 ) * $factor [$i];
		}
		$mod = $checksum % 11;
		$verify_number = $verify_number_list [$mod];
		return $verify_number;
	}
	// 将15位身份证升级到18位 
	protected function idcard_15to18($idcard) {
		if (strlen ( $idcard ) != 15) {
			return false;
		} else {
			// 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码 
			if (array_search ( substr ( $idcard, 12, 3 ), array ('996', '997', '998', '999' ) ) !== false) {
				$idcard = substr ( $idcard, 0, 6 ) . '18' . substr ( $idcard, 6, 9 );
			} else {
				$idcard = substr ( $idcard, 0, 6 ) . '19' . substr ( $idcard, 6, 9 );
			}
		}
		$idcard = $idcard . $this->idcard_verify_number ( $idcard );
		return $idcard;
	}
	// 18位身份证校验码有效性检查 
	protected function idcard_checksum18($idcard) {
		if (strlen ( $idcard ) != 18) {
			return false;
		}
		$idcard_base = substr ( $idcard, 0, 17 );
		if ($this->idcard_verify_number ( $idcard_base ) != strtoupper ( substr ( $idcard, 17, 1 ) )) {
			return false;
		} else {
			return true;
		}
	}
	public function TeacherCheckinForm($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}		
		$o_user = new Single_User($n_uid);
		if (!$o_user->ValidModule ( 120200 ))//如果没有权限，不返回任何值
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'非法操作，请与管理员联系。！[1001]\');');
		}
		//开始记录考勤
		//1.先检查今天的考勤是否存在。
		$o_checkingin=new Student_Onboard_Checkingin();
		$o_checkingin->PushWhere ( array ('&&', 'ClassId', '=',$this->getPost('ClassId')) );
		$o_checkingin->PushWhere ( array ('&&', 'Date', '=',$this->GetDate()) );
		if ($o_checkingin->getAllCount()>0)
		{
			//更新
			$o_checkingin=new Student_Onboard_Checkingin($o_checkingin->getId(0));
		}else{
			//新建
			$o_checkingin=new Student_Onboard_Checkingin();
			$o_checkingin->setClassId($this->getPost('ClassId'));
			$o_checkingin->setDate($this->GetDate());
			$o_checkingin->setModifyDate($this->GetDateNow());
			$o_checkingin->Save();
		}		
		//2. 统计人数，所有被录取的人数
		$a_in=array();
		$a_out=array();
		$o_system_setup=new Base_Setup(1);
		$o_signup=new Student_Onboard_Info_Class_View();
        $o_signup->PushWhere ( array ('&&', 'ClassNumber', '=',$this->getPost('ClassId')) );
		$o_signup->PushWhere ( array ('&&', 'State', '=',1) );
		for($i=0;$i<$o_signup->getAllCount();$i++)
		{
			if ($this->getPost('StudentId_'.$o_signup->getStudentId($i))=='on')
			{
				array_push($a_in, $o_signup->getStudentId($i));
				//查找之前的考勤，如果有，删除
				$o_detail=new Student_Onboard_Checkingin_Detail();
				$o_detail->PushWhere ( array ('&&', 'CheckId', '=',$o_checkingin->getId()) );
				$o_detail->PushWhere ( array ('&&', 'StudentId', '=',$o_signup->getStudentId($i)) );
				for($j=0;$j<$o_detail->getAllCount();$j++)
				{
					$o_temp=new Student_Onboard_Checkingin_Detail($o_detail->getId($j));
					$o_temp->Deletion();
				}
			}else{
				array_push($a_out, $o_signup->getStudentId($i));
				//未出勤，那么查看数据库是否已经记录数据，如果记录，那么跳过
				$o_detail=new Student_Onboard_Checkingin_Detail();
				$o_detail->PushWhere ( array ('&&', 'CheckId', '=',$o_checkingin->getId()) );
				$o_detail->PushWhere ( array ('&&', 'StudentId', '=',$o_signup->getStudentId($i)) );
				if ($o_detail->getAllCount()==0)
				{
					//需要记录数据库
					$o_detail=new Student_Onboard_Checkingin_Detail();
					$o_detail->setCheckId($o_checkingin->getId());
					$o_detail->setStudentId($o_signup->getStudentId($i));
					//查找家长输入的请假申请，如果有，提取类型与原因，如果没有，那么建立一条新的，让家长补充
					$o_stu=new Student_Onboard_Info_Class_Wechat_View($o_signup->getStudentId($i));
					$o_parent=new Student_Onboard_Checkingin_Parent();
					$o_parent->PushWhere ( array ('&&', 'UserId', '=',$o_stu->getUserId()) );
					$o_parent->PushWhere ( array ('&&', 'StudentId', '=',$o_signup->getStudentId($i)) );
					$o_parent->PushWhere ( array ('&&', 'StartDate', '<=',$this->GetDate()) );
					$o_parent->PushWhere ( array ('&&', 'EndDate', '>=',$this->GetDate()) );
					$o_parent->PushOrder ( array ('Date', D) );
					if ($o_parent->getAllCount()>0)
					{
						$o_detail->setType($o_parent->getType(0));
						$o_detail->setComment($o_parent->getComment(0));
					}else{
						//新建一条记录，让家长填写
						$o_parent=new Student_Onboard_Checkingin_Parent();
						$o_parent->setUserId($o_stu->getUserId());
						$o_parent->setStudentId($o_signup->getStudentId($i));
						$o_parent->setStartDate($this->GetDate());
						$o_parent->setEndDate($this->GetDate());//开始日期加上天数
						$o_parent->setType('');
						$o_parent->setComment('');
						$o_parent->Save();
						//并且给家长发送一个班级提醒
						$o_msg=new Wechat_Wx_User_Reminder();
						$o_msg->setUserId($o_stu->getUserId());
						$o_msg->setCreateDate($this->GetDateNow());
						$o_msg->setSendDate('0000-00-00');
						$o_msg->setMsgId($this->getWechatSetup('MSGTMP_09'));
						$o_msg->setOpenId($o_stu->getOpenid());
						$o_msg->setActivityId(0);
						$o_msg->setSend(0);
						$o_msg->setFirst('
通知类型：补充缺勤信息
幼儿姓名：'.$o_stu->getName());
						$o_msg->setKeyword1($o_stu->getClassName());
						$s_teacher_name=$o_user->getName();
						//$o_msg->setKeyword2(mb_substr($s_teacher_name,0,1,'utf-8').'老师');
						$o_msg->setKeyword2($s_teacher_name.'老师');
						$o_msg->setKeyword3($this->GetDate());
						$o_msg->setKeyword4('您的幼儿今天缺勤，请点击详情尽快补充缺勤信息。');
						$o_msg->setKeyword5('');
						$o_msg->setRemark('');
						//如果Comment为空，那么就没有点击事件了
						$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_operation/askforleave_comment.php?id='.$o_parent->getId().'');
						$o_msg->setKeywordSum(10);
						$o_msg->Save();					
					}					
					$o_detail->Save();
				}
				/*
				//查找学生都有哪些微信与之关联
				$o_parent= new Student_Info_Wechat_View();
				$o_parent->PushWhere ( array ('&&', 'StudentId', '=',$o_signup->getStudentId($i)) );
				require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
				$o_sys_info=new Base_Setup(1);
				$o_token=new accessToken();
				$curlUtil = new curlUtil();
				$s_url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$o_token->access_token;
				for($j=0;$j<$o_parent->getAllCount();$j++)
				{
					$data = array(
				    	'touser' => $o_parent->getOpenId($j), // openid是发送消息的基础
						'template_id' => 'E0kCn1ioTruoYRdQfQv8WYSnRK_ra8ionJ_F7EtGg1M', // 模板id
						'url' => '', // 点击跳转地址
						'topcolor' => '#FF0000', // 顶部颜色
						'data' => array(
							'first' => array('value' =>'学生“'.$o_parent->getName($j).'”考勤异常，请您关注：
							'),
							'keyword1' => array('value' => '尚未出勤','color'=>'#FF0000'),
							'keyword2' => array('value' => $o_course->getTime(),'color'=>'#173177'),
							'keyword3' => array('value' => $o_course->getName(),'color'=>'#173177'),
							'keyword4' => array('value' => $o_course->getTeacherName(),'color'=>'#173177'),
							'remark' => array('value' => '
如有问题，请与学校核实。')
						) 
					);
					$curlUtil->https_request($s_url, json_encode($data));	
				}*/
			}
		}
		$o_checkingin->setAbsenteeismStu(json_encode($a_out));
		$o_checkingin->setAbsenteeismSum(count($a_out));
		$o_checkingin->setCheckinginSum(count($a_in));
		$o_checkingin->setOwnerId($n_uid);
		$o_checkingin->setActive(1);
		$o_checkingin->Save();
		$this->setReturn ( 'parent.location=\''.$this->getPost('Url').'stu_checkin_success.php?id='.$o_checkingin->getId().'\'');
	}
	public function getAgeByID($id){         
		//过了这年的生日才算多了1周岁 
        if(empty($id)) return ''; 
        $date=strtotime(substr($id,6,8));
		//获得出生年月日的时间戳 
        $today=strtotime('today');
		//获得今日的时间戳 
        $diff=floor(($today-$date)/86400/365);
		//得到两个日期相差的大体年数 
        
		//strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比 
        $age=strtotime(substr($id,6,8).' +'.$diff.'years')>$today?($diff+1):$diff;   
        return $age; 
    } 
	public function YeParentInfoTable($n_uid)
	{	
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120207 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Onboard_Info_Class_View();
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Jh1Danwei', 'Like','%'.$s_key.'%') );	
			$o_user->PushWhere ( array ('||', 'Jh2Danwei', 'Like','%'.$s_key.'%') );		
		}
		$o_user->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_user->PushOrder ( array ('ClassNumber',A) );
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
			//读取入园问卷最后一道题
			$s_answer='无';
			$o_survey=new Student_Onboard_Survey_Answers();
			$o_survey->PushWhere ( array ('&&', 'StudentId', '=',$o_user->getStudentId( $i )) );
			if ($o_survey->getAllCount()>0)
			{
				//读取最后一道题的答案
				$a_answer=json_decode($o_survey->getAnswer(0));
				$a_item=$a_answer[count($a_answer)-1];
				$s_answer=rawurldecode($a_item[3]);
			}else{
				$s_answer='无';
			}
			if ($s_key!='')
			{
				//如果是搜索，那么要验证这个家长的单位是否有这个关键字
				if (count(explode($s_key, $o_user->getJh1Danwei ( $i )))>1)
				{
					array_push ($a_row, array (
						$o_user->getJh1Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getJh1Connection( $i ).'</span>',
						$this->getAgeByID($o_user->getJh1Id ( $i )),
						$o_user->getJh1Jiaoyu ( $i ),
						$o_user->getJh1Danwei ( $i ).'<br/><span style="color:#999999">'.$o_user->getJh1Job( $i ).'</span>',
						$o_user->getJh1Phone ( $i ),
						$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getClassName ( $i ).'</span>',
						$s_answer,
					));
				}
			}else{
				array_push ($a_row, array (
					$o_user->getJh1Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getJh1Connection( $i ).'</span>',
					$this->getAgeByID($o_user->getJh1Id ( $i )),
					$o_user->getJh1Jiaoyu ( $i ),
					$o_user->getJh1Danwei ( $i ).'<br/><span style="color:#999999">'.$o_user->getJh1Job( $i ).'</span>',
					$o_user->getJh1Phone ( $i ),
					$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getClassName ( $i ).'</span>',
					$s_answer,
				));
			}			
			if ($o_user->getJh2Name ( $i )!='')
			{	//如果填写了第二监护人，那么要显示第二监护人信息
				if ($s_key!='')
				{
					//如果是搜索，那么要验证这个家长的单位是否有这个关键字
					if (count(explode($s_key, $o_user->getJh2Danwei ( $i )))>1)
					{
						array_push ($a_row, array (
							$o_user->getJh2Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getJh2Connection( $i ).'</span>',
							$this->getAgeByID($o_user->getJh2Id ( $i )),
							$o_user->getJh2Jiaoyu ( $i ),
							$o_user->getJh2Danwei ( $i ).'<br/><span style="color:#999999">'.$o_user->getJh2Job( $i ).'</span>',
							$o_user->getJh2Phone ( $i ),
							$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getClassName ( $i ).'</span>',
							$s_answer,
						));
					}
				}else{
					array_push ($a_row, array (
						$o_user->getJh2Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getJh2Connection( $i ).'</span>',
						$this->getAgeByID($o_user->getJh2Id ( $i )),
						$o_user->getJh2Jiaoyu ( $i ),
						$o_user->getJh2Danwei ( $i ).'<br/><span style="color:#999999">'.$o_user->getJh2Job( $i ).'</span>',
						$o_user->getJh2Phone ( $i ),
						$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getClassName ( $i ).'</span>',
						$s_answer,
					));
				}
				
			}
						
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'姓名/关系', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,'年龄', '', 0, 60);
		$a_title=$this->setTableTitle($a_title,'教育程度', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,'单位/职务', '', 0,0);
		$a_title=$this->setTableTitle($a_title,'联系电话', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,'幼儿姓名', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,'志愿服务', '', 0, 200);
		$this->SendJsonResultForTable($n_allcount,'YeParentInfoTable', 'no', $n_page, $a_title, $a_row);
	}
}

?>