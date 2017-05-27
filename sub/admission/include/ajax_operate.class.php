<?php
error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 25;
	
	public function StudentSignupTable($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120101 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Info(); 
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',0) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',0) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'StudentId', 'like',$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',0) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
		}else{
			$o_user->PushWhere ( array ('&&', 'State', '=',0) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
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
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ),
				$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getSex ( $i ).'</span>',
				$o_user->getBirthday ( $i ),
				$o_user->getId ( $i ).'<br/><span style="color:#999999">'.$o_user->getIdType ( $i ).'</span>',
				$o_user->getJh1Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getSignupPhone ( $i ).'</span>',
				$o_user->getSignupPhoneBackup ( $i )
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'<input style="margin-top:0px;" type="checkbox" onclick="select_all(this)"/> 全选', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'幼儿编号', 'StudentId', 0, 0);
		$a_title=$this->setTableTitle($a_title,'姓名', 'Name', 0, 80);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件信息', 'IdType', 0, 100);
		$a_title=$this->setTableTitle($a_title,'监护人', 'Jh1Name', 0, 100);
		$a_title=$this->setTableTitle($a_title,'备用电话', '', 0, 80);
		$this->SendJsonResultForTable($n_allcount,'StudentSignupTable', 'no', $n_page, $a_title, $a_row);
	}
	public function WaitAuditTable($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120102 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Info(); 
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',1) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',1) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'StudentId', 'like',$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',1) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
		}else{
			$o_user->PushWhere ( array ('&&', 'State', '=',1) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
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
			$s_remark='';
			if ($o_user->getAuditorName ( $i )!='')
			{
				$s_remark=$o_user->getAuditorName ( $i ).'<br/><span style="color:#999999">备注：'.$o_user->getAuditorRemark ( $i ).'</span>';
			}
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ),
				$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getSex ( $i ).'</span>',
				$o_user->getBirthday ( $i ),
				$o_user->getId ( $i ).'<br/><span style="color:#999999">'.$o_user->getIdType ( $i ).'</span>',
				$o_user->getJh1Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getSignupPhone ( $i ).'</span>',
				$o_user->getSignupPhoneBackup ( $i ),
				$s_remark
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'<input style="margin-top:0px;" type="checkbox" onclick="select_all(this)"/> 全选', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'幼儿编号', 'StudentId', 0, 0);
		$a_title=$this->setTableTitle($a_title,'姓名', 'Name', 0, 80);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件信息', 'IdType', 0, 100);
		$a_title=$this->setTableTitle($a_title,'监护人', 'Jh1Name', 0, 100);
		$a_title=$this->setTableTitle($a_title,'备用电话', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,'信息核验员', '', 0, 80);
		$this->SendJsonResultForTable($n_allcount,'StudentSignupTable', 'no', $n_page, $a_title, $a_row);
	}
	public function AuditPassTable($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120103 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Info(); 
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',2) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',2) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'StudentId', 'like',$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',2) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
		}else{
			$o_user->PushWhere ( array ('&&', 'State', '=',2) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
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
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ),
				$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getSex ( $i ).'</span>',
				$o_user->getBirthday ( $i ),
				$o_user->getId ( $i ).'<br/><span style="color:#999999">'.$o_user->getIdType ( $i ).'</span>',
				$o_user->getJh1Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getSignupPhone ( $i ).'</span>',
				$o_user->getSignupPhoneBackup ( $i ),
				$o_user->getAuditorName ( $i )
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'<input style="margin-top:0px;" type="checkbox" onclick="select_all(this)"/> 全选', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'幼儿编号', 'StudentId', 0, 0);
		$a_title=$this->setTableTitle($a_title,'姓名', 'Name', 0, 80);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件信息', 'IdType', 0, 100);
		$a_title=$this->setTableTitle($a_title,'监护人', 'Jh1Name', 0, 100);
		$a_title=$this->setTableTitle($a_title,'备用电话', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,'信息核验员', '', 0, 80);
		$this->SendJsonResultForTable($n_allcount,'StudentSignupTable', 'no', $n_page, $a_title, $a_row);
	}
	public function HealthWaitTable($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120105 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Info(); 
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',4) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',4) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'StudentId', 'like',$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',4) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
		}else{
			$o_user->PushWhere ( array ('&&', 'State', '=',4) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
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
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ),
				$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getSex ( $i ).'</span>',
				$o_user->getBirthday ( $i ),
				$o_user->getId ( $i ).'<br/><span style="color:#999999">'.$o_user->getIdType ( $i ).'</span>',
				$o_user->getJh1Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getSignupPhone ( $i ).'</span>',
				$o_user->getSignupPhoneBackup ( $i )
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'<input style="margin-top:0px;" type="checkbox" onclick="select_all(this)"/> 全选', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'幼儿编号', 'StudentId', 0, 0);
		$a_title=$this->setTableTitle($a_title,'姓名', 'Name', 0, 80);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件信息', 'IdType', 0, 100);
		$a_title=$this->setTableTitle($a_title,'监护人', 'Jh1Name', 0, 100);
		$a_title=$this->setTableTitle($a_title,'备用电话', '', 0, 80);
		$this->SendJsonResultForTable($n_allcount,'StudentSignupTable', 'no', $n_page, $a_title, $a_row);
	}
	public function SendAuditNotice($n_uid)
	{	
		sleep(1);
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}		
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120101 ))return;//如果没有权限，不返回任何值
		$a_data=json_decode($_POST['Vcl_StuId']);
		$o_admission_setup=new Admission_Setup(1);
		$o_system_setup=new Base_Setup(1);
		for($i=0;$i<count($a_data);$i++)
		{
			$o_stu=new Student_Info($a_data[$i]);
			if ($o_stu->getState()==0)
			{
				$o_stu->setState(1);
				$o_stu->setReject(0);
				$o_stu->Save();
				//获取幼儿关联的微信
				$o_wechat_user=new Student_Info_Wechat_Wiew();
				$o_wechat_user->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getStudentId()) );
				for($j=0;$j<$o_wechat_user->getAllCount();$j++)
				{
					//添加消息队列
					$o_msg=new Wechat_Wx_User_Reminder();
				    $o_msg->setUserId($o_wechat_user->getUserId($j));
				    $o_msg->setCreateDate($this->GetDateNow());
				    $o_msg->setSendDate('0000-00-00');
				    $o_msg->setMsgId($this->getWechatSetup('MSGTMP_02'));
				    $o_msg->setOpenId($o_wechat_user->getOpenId($j));
				    $o_msg->setActivityId(0);
				    $o_msg->setSend(0);
				    $o_msg->setFirst('如下幼儿初步审核已经通过，请您按时间地点携带核验资料进行信息核验，错过视为自行放弃报名资格。');
				    $o_msg->setKeyword1($o_stu->getStudentId());
				    $o_msg->setKeyword2($o_stu->getName());
				    $a_time=$this->getAuditDateAndTime($o_admission_setup->getAuditDate(),$o_admission_setup->getAuditTime());
				    $o_msg->setKeyword3($a_time[0]);
				    $o_msg->setKeyword4($a_time[1]);
				    $o_msg->setKeyword5($o_admission_setup->getAuditAddress());
				    $o_msg->setRemark('注意事项：家长持报名手机及幼儿编号，在规定的时段、地点，有序扫码入园，进行信息核验。家长请务必携带相关证件原件，即:户口本、幼儿身份证、房产证或租赁合同（能证明房主与幼儿的关系）、幼儿预防接种证（小绿本）、其他特殊证明（如烈士子女等）。

如需查看幼儿报名信息，请点击详情');
				    $o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/my_signup.php');
				    $o_msg->setKeywordSum(5);
				    $o_msg->Save();
				}				
			}
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'发送信息核验通知成功！\',function(){parent.table_refresh(\'StudentSignupTable\')})");' );
	}
	private function getAuditDateAndTime($s_date,$s_time)
	{
		//读取见面设置
		$o_table=new Admission_Time();
		$o_table->PushWhere ( array ('&&', 'Type', '=', 'Audit' ) );
		$o_table->PushOrder ( array ('Id', 'A' ) );
        for($i=0;$i<$o_table->getAllCount();$i++)
        {
        	if ($o_table->getUseSum($i)<$o_table->getSum($i))
        	{
        		$s_time=$o_table->getTime($i);
        		$s_date=$o_table->getDate($i);
        		$o_table->SumAdd1($o_table->getId($i));
        	}
        }
        return array($s_date,$s_time);
	}
	public function SendHealthNotice($n_uid)
	{	
		sleep(1);
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}		
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120104 ))return;//如果没有权限，不返回任何值
		$a_data=json_decode($_POST['Vcl_StuId']);
		$o_admission_setup=new Admission_Setup(1);
		$o_system_setup=new Base_Setup(1);
		for($i=0;$i<count($a_data);$i++)
		{
			$o_stu=new Student_Info($a_data[$i]);
			if ($o_stu->getState()==3)
			{
				$o_stu->setState(4);
				$o_stu->setReject(0);
				$o_stu->Save();
				//获取幼儿关联的微信
				$o_wechat_user=new Student_Info_Wechat_Wiew();
				$o_wechat_user->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getStudentId()) );
				for($j=0;$j<$o_wechat_user->getAllCount();$j++)
				{
					//添加消息队列
					$o_msg=new Wechat_Wx_User_Reminder();
				    $o_msg->setUserId($o_wechat_user->getUserId($j));
				    $o_msg->setCreateDate($this->GetDateNow());
				    $o_msg->setSendDate('0000-00-00');
				    $o_msg->setMsgId($this->getWechatSetup('MSGTMP_04'));
				    $o_msg->setOpenId($o_wechat_user->getOpenId($j));
				    $o_msg->setActivityId(0);
				    $o_msg->setSend(0);
				    $o_msg->setFirst('如下幼儿已经通过幼儿见面，请您按时间地点携带幼儿进行体检，如错过体检视为自行放弃报名资格。');
				    $o_msg->setKeyword1($o_stu->getStudentId());//幼儿编号
				    $o_msg->setKeyword2($o_stu->getName());//幼儿姓名
				    $o_msg->setKeyword3($o_admission_setup->getHealthTime());//体检时间
				    $o_msg->setKeyword4($o_admission_setup->getHealthAddress());//体检地点
				    $o_msg->setKeyword5('');//为空
				    $o_msg->setRemark('机构地址：平原里小区19号（健宫医院对面）<br/>
公交车站：自新路北（83路;133路;381路;特14路;专13路）
				    
如需查看幼儿报名信息，请点击详情');
				    $o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/my_signup_state.php?id='.$o_stu->getStudentId().'');
				    $o_msg->setKeywordSum(4);
				    $o_msg->Save();
				}				
			}
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'发送体检通知成功！\',function(){parent.table_refresh(\'MeetResultTable\')})");' );
	}
	public function SendFinishInfoNotice($n_uid)
	{	
		sleep(1);
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}		
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120105 ))return;//如果没有权限，不返回任何值
		$a_data=json_decode($_POST['Vcl_StuId']);
		$o_admission_setup=new Admission_Setup(1);
		$o_system_setup=new Base_Setup(1);
		for($i=0;$i<count($a_data);$i++)
		{
			$o_stu=new Student_Info($a_data[$i]);
			if ($o_stu->getState()==4)
			{
				$o_stu->setState(5);
				$o_stu->setReject(0);
				$o_stu->Save();
				//获取幼儿关联的微信
				$o_wechat_user=new Student_Info_Wechat_Wiew();
				$o_wechat_user->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getStudentId()) );
				for($j=0;$j<$o_wechat_user->getAllCount();$j++)
				{
					//添加消息队列
					$o_msg=new Wechat_Wx_User_Reminder();
				    $o_msg->setUserId($o_wechat_user->getUserId($j));
				    $o_msg->setCreateDate($this->GetDateNow());
				    $o_msg->setSendDate('0000-00-00');
				    $o_msg->setMsgId($this->getWechatSetup('MSGTMP_05'));
				    $o_msg->setOpenId($o_wechat_user->getOpenId($j));
				    $o_msg->setActivityId(0);
				    $o_msg->setSend(0);
				    $o_msg->setFirst('尊敬的幼儿家长您好，您的幼儿体检已经通过，请完善幼儿信息：');
				    $o_msg->setKeyword1($o_stu->getStudentId());//幼儿编号
				    $o_msg->setKeyword2($o_stu->getName());//幼儿姓名
				    $o_msg->setKeyword3($o_stu->getIdType());//证件类型
				    $o_msg->setKeyword4($o_stu->getId());//体检地点
				    $o_msg->setKeyword5('');//体检地点
				    $o_msg->setRemark('完善信息后，您将会收到录取通知。
				    
请点击详情，完善幼儿信息。');
				    $o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/my_signup.php');
				    $o_msg->setKeywordSum(4);
				    $o_msg->Save();
				    
				}				
			}
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'发送完善信息通知成功！\',function(){parent.table_refresh(\'HealthWaitTable\')})");' );
	}
	public function MeetResultTable($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120104 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Info(); 
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',3) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',3) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'StudentId', 'like',$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',3) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
		}else{
			$o_user->PushWhere ( array ('&&', 'State', '=',3) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
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
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ),
				$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getSex ( $i ).'</span>',
				$o_user->getBirthday ( $i ),
				$o_user->getId ( $i ).'<br/><span style="color:#999999">'.$o_user->getIdType ( $i ).'</span>',
				$o_user->getJh1Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getSignupPhone ( $i ).'</span>',
				$o_user->getSignupPhoneBackup ( $i ),
				$o_user->getMeetAuditorName ( $i )
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'<input style="margin-top:0px;" type="checkbox" onclick="select_all(this)"/> 全选', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'幼儿编号', 'StudentId', 0, 0);
		$a_title=$this->setTableTitle($a_title,'姓名', 'Name', 0, 80);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件信息', 'IdType', 0, 100);
		$a_title=$this->setTableTitle($a_title,'监护人', 'Jh1Name', 0, 100);
		$a_title=$this->setTableTitle($a_title,'备用电话', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,'见面审核员', '', 0, 80);
		$this->SendJsonResultForTable($n_allcount,'StudentSignupTable', 'no', $n_page, $a_title, $a_row);
	}
	public function InfoWaitTable($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120106 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Info(); 
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',5) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',5) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'StudentId', 'like',$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',5) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
		}else{
			$o_user->PushWhere ( array ('&&', 'State', '=',5) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
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
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ),
				$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getSex ( $i ).'</span>',
				$o_user->getBirthday ( $i ),
				$o_user->getId ( $i ).'<br/><span style="color:#999999">'.$o_user->getIdType ( $i ).'</span>',
				$o_user->getJh1Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getSignupPhone ( $i ).'</span>',
				$o_user->getSignupPhoneBackup ( $i )
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'<input style="margin-top:0px;" type="checkbox" onclick="select_all(this)"/> 全选', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'幼儿编号', 'StudentId', 0, 0);
		$a_title=$this->setTableTitle($a_title,'姓名', 'Name', 0, 80);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件信息', 'IdType', 0, 100);
		$a_title=$this->setTableTitle($a_title,'监护人', 'Jh1Name', 0, 100);
		$a_title=$this->setTableTitle($a_title,'备用电话', '', 0, 80);
		$this->SendJsonResultForTable($n_allcount,'StudentSignupTable', 'no', $n_page, $a_title, $a_row);
	}
	public function AdmissionTable($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120107 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Student_Info(); 
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',6) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',6) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
			$o_user->PushWhere ( array ('||', 'StudentId', 'like',$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'State', '=',6) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
		}else{
			$o_user->PushWhere ( array ('&&', 'State', '=',6) );
			$o_user->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
			$o_user->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
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
			array_push ( $a_button, array ('查看', "window.open('print.php?student_id=".$o_user->getStudentId($i)."','_blank')" ) );//查看
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ),
				$o_user->getName ( $i ).'<br/><span style="color:#999999">'.$o_user->getSex ( $i ).'</span>',
				$o_user->getBirthday ( $i ),
				$o_user->getId ( $i ).'<br/><span style="color:#999999">'.$o_user->getIdType ( $i ).'</span>',
				$o_user->getJh1Name ( $i ).'<br/><span style="color:#999999">'.$o_user->getSignupPhone ( $i ).'</span>',
				$o_user->getSignupPhoneBackup ( $i )
				));			
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'<input style="margin-top:0px;" type="checkbox" onclick="select_all(this)"/> 全选', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'幼儿编号', 'StudentId', 0, 0);
		$a_title=$this->setTableTitle($a_title,'姓名', 'Name', 0, 80);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件信息', 'IdType', 0, 100);
		$a_title=$this->setTableTitle($a_title,'监护人', 'Jh1Name', 0, 100);
		$a_title=$this->setTableTitle($a_title,'备用电话', '', 0, 80);
		$this->SendJsonResultForTable($n_allcount,'StudentSignupTable', 'no', $n_page, $a_title, $a_row);
	}	
	public function AdmissionSetup($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120108 ))return; //如果没有权限，不返回任何值
		$o_setup=new Admission_Setup(1);
		$o_setup->setDeptId($this->getPost('DeptId'));
		$o_setup->setTuoSum($this->getPost('TuoSum'));
		$o_setup->setXiaoSum($this->getPost('XiaoSum'));
		$o_setup->setDaSum($this->getPost('DaSum'));
		$o_setup->setZhongSum($this->getPost('ZhongSum'));
		$o_setup->setBanriSum($this->getPost('BanriSum'));
		$o_setup->setSignupStart($this->getPost('SignupStart'));
		$o_setup->setSignupEnd($this->getPost('SignupEnd'));
		$o_setup->setAuditDate($this->getPost('AuditDate'));
		$o_setup->setAuditTime($this->getPost('AuditTime'));
		$o_setup->setAuditAddress($this->getPost('AuditAddress'));
		$o_setup->setMeetDate($this->getPost('MeetDate'));
		$o_setup->setMeetTime($this->getPost('MeetTime'));
		$o_setup->setMeetAddress($this->getPost('MeetAddress'));
		$o_setup->setHealthTime($this->getPost('HealthTime'));
		$o_setup->setHealthAddress($this->getPost('HealthAddress'));
		$o_setup->Save();
		
		$this->setReturn ( 'parent.form_return("dialog_success(\'保存招生设置成功。\')");' );
	}
	public function AdmissionSetupMeetTime($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120109 ))return; //如果没有权限，不返回任何值
		$o_table=new Admission_Time();
        for($i=0;$i<$o_table->getAllCount();$i++)
        {
        	$o_temp=new Admission_Time($o_table->getId($i));
        	$o_temp->setTime($this->getPost('Time_'.$o_table->getId($i)));
        	$o_temp->setDate($this->getPost('Date_'.$o_table->getId($i)));
        	$o_temp->setSum($this->getPost('Sum_'.$o_table->getId($i)));
        	$o_temp->Save();
        }
		$this->setReturn ( 'parent.form_return("dialog_success(\'保存见面时段设置成功。\')");' );
	}
	public function SignupReject($n_uid)
	{	
		sleep(1);
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}		
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120100 ))return;//如果没有权限，不返回任何值
		$a_data=json_decode($_POST['Vcl_StuId']);
		$o_admission_setup=new Admission_Setup(1);
		$o_system_setup=new Base_Setup(1);
		for($i=0;$i<count($a_data);$i++)
		{
			$o_stu=new Student_Info($a_data[$i]);
			$o_stu->setReject(1);
			$o_stu->Save();
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'操作成功！\')");' );
	}
}

?>