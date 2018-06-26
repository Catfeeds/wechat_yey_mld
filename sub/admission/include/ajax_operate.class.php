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
			$s_flag='';
			if ($o_user->getReject ( $i )==1)
			{
				$s_flag=' <span class="label label-danger">不通过</span>';
			}
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ).$s_flag,
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
			$s_flag='';
			if ($o_user->getReject ( $i )==1)
			{
				$s_flag=' <span class="label label-danger">不通过</span>';
			}
			$s_remark='';
			if ($o_user->getAuditorName ( $i )!='')
			{
				$s_remark=$o_user->getAuditorName ( $i ).'<br/><span style="color:#999999">备注：'.$o_user->getAuditRemark ( $i ).'</span>';
			}
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ).$s_flag,
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
		$a_title=$this->setTableTitle($a_title,'<input style="margin-top:0px;" type="checkbox" onclick="select_all(this)"/> 全选', '', 0, 50);
		$a_title=$this->setTableTitle($a_title,'幼儿编号', 'StudentId', 0, 80);
		$a_title=$this->setTableTitle($a_title,'姓名', 'Name', 0, 80);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件信息', 'IdType', 0, 100);
		$a_title=$this->setTableTitle($a_title,'监护人', 'Jh1Name', 0, 100);
		$a_title=$this->setTableTitle($a_title,'备用电话', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,'信息核验员', '', 180, 0);
		$this->SendJsonResultForTable($n_allcount,'WaitAuditTable', 'no', $n_page, $a_title, $a_row);
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
			$s_flag='';
			if ($o_user->getReject ( $i )==1)
			{
				$s_flag=' <span class="label label-danger">不通过</span>';
			}
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ).$s_flag,
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
		$this->SendJsonResultForTable($n_allcount,'AuditPassTable', 'no', $n_page, $a_title, $a_row);
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
			$s_flag='';
			if ($o_user->getReject ( $i )==1)
			{
				$s_flag=' <span class="label label-danger">不通过</span>';
			}
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ).$s_flag,
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
		$this->SendJsonResultForTable($n_allcount,'HealthWaitTable', 'no', $n_page, $a_title, $a_row);
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
				    $o_msg->setFirst('如下幼儿初步审核已经通过，请您按时间地点携带核验资料原件、复印件以及“报名登记表”进行信息核验，如错过信息核验视为自行放弃入园资格：');
				    $o_msg->setKeyword1($o_stu->getStudentId());
				    $o_msg->setKeyword2($o_stu->getName());
				    $a_time=$this->getAuditDateAndTime($o_admission_setup->getAuditDate(),$o_admission_setup->getAuditTime());
				    $o_msg->setKeyword3($a_time[0]);
				    $o_msg->setKeyword4($a_time[1]);
				    $o_msg->setKeyword5($o_admission_setup->getAuditAddress());
				    $o_msg->setRemark('请用电脑访问：
http://wx.mldyey.com/signup/
并扫码二维码进行登录，即可打印“报名信息登记表”。

信息核验资料及注意事项请点击详情查看。');
				    $o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/my_signup_state.php?id='.$o_stu->getStudentId().'');
				    $o_msg->setKeywordSum(5);
				    $o_msg->Save();
				}				
			}
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'发送信息核验通知成功！\',function(){parent.table_refresh(\'StudentSignupTable\')})");' );
	}
	public function SendMeetNotice($n_uid)
	{	
		sleep(1);
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}		
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120102 ))return;//如果没有权限，不返回任何值
		$a_data=json_decode($_POST['Vcl_StuId']);
		$o_admission_setup=new Admission_Setup(1);
		$o_system_setup=new Base_Setup(1);
		for($i=0;$i<count($a_data);$i++)
		{
			$o_stu=new Student_Info($a_data[$i]);
			if ($o_stu->getState()==1)
			{
				$o_stu->setState(2);
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
				    $o_msg->setMsgId($this->getWechatSetup('MSGTMP_03'));
				    $o_msg->setOpenId($o_wechat_user->getOpenId($j));
				    $o_msg->setActivityId(0);
				    $o_msg->setSend(0);
				    $o_msg->setFirst('如下幼儿信息核验已经通过，请按时段地点携带幼儿参加入园互动，如错过入园互动视为自行放弃入园资格：');
				    $o_msg->setKeyword1($o_stu->getStudentId());
				    $o_msg->setKeyword2($o_stu->getName());
				    $a_time=$this->getMeetDateAndTime($o_admission_setup->getMeetDate(), $o_admission_setup->getMeetTime());
				    $o_msg->setKeyword3($a_time[0]);
				    $o_msg->setKeyword4($a_time[1]);
				    $o_msg->setKeyword5($o_admission_setup->getMeetAddress());
				    $o_msg->setRemark('
入园互动注意事项请点击详情查看。');
				    $o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/my_signup_state.php?id='.$o_stu->getStudentId().'');
				    $o_msg->setKeywordSum(5);
				    $o_msg->Save();
				}				
			}
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'发送见面通知成功！\',function(){parent.table_refresh(\'WaitAuditTable\')})");' );
	}
	private function getMeetDateAndTime($s_date,$s_time)
	{
		//读取入园互动设置
		$o_table=new Admission_Time();
		$o_table->PushWhere ( array ('&&', 'Type', '=', 'meet' ) );
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
	private function getAuditDateAndTime($s_date,$s_time)
	{
		//读取入园互动设置
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
	private function getHealthDateAndTime($s_datetime)
	{
		//读取入园互动设置
		$o_table=new Admission_Time();
		$o_table->PushWhere ( array ('&&', 'Type', '=', 'Health' ) );
		$o_table->PushOrder ( array ('Id', 'A' ) );
        for($i=0;$i<$o_table->getAllCount();$i++)
        {
        	if ($o_table->getUseSum($i)<$o_table->getSum($i))
        	{
        		$s_datetime=$o_table->getDate($i).' '.$o_table->getTime($i);
        		$o_table->SumAdd1($o_table->getId($i));
        	}
        }
        return $s_datetime;
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
				    $o_msg->setFirst('如下幼儿已经通过入园互动环节，请您按时间地点携带幼儿进行体检，如错过体检视为自行放弃入园资格：');
				    $o_msg->setKeyword1($o_stu->getStudentId());//幼儿编号
				    $o_msg->setKeyword2($o_stu->getName());//幼儿姓名
				    $o_msg->setKeyword3($this->getHealthDateAndTime($o_admission_setup->getHealthTime()));//体检时间
				    $o_msg->setKeyword4($o_admission_setup->getHealthAddress());//体检地点
				    $o_msg->setKeyword5('');//为空
				    $o_msg->setRemark('机构地址：平原里小区19号（健宫医院对面）
公交车站：自新路北（83路;133路;381路;特14路;专13路）

幼儿体检注意事项请点击详情查看。');
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
				    $o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/signup_finish_info.php?id='.$o_stu->getStudentId());
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
			$s_flag='';
			if ($o_user->getReject ( $i )==1)
			{
				$s_flag=' <span class="label label-danger">不通过</span>';
			}
			array_push ($a_row, array (
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '" checked="checked"/>',
				$o_user->getStudentId ( $i ).$s_flag,
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
		$a_title=$this->setTableTitle($a_title,'入园互动审核员', '', 0, 80);
		$this->SendJsonResultForTable($n_allcount,'MeetResultTable', 'no', $n_page, $a_title, $a_row);
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
		$this->SendJsonResultForTable($n_allcount,'InfoWaitTable', 'no', $n_page, $a_title, $a_row);
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
				'<input style="margin-top:0px;" type="checkbox" value="' . $o_user->getStudentId ( $i ) . '"/>',
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
		$this->SendJsonResultForTable($n_allcount,'AdmissionTable', 'no', $n_page, $a_title, $a_row);
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
		$o_setup->setSignupStartNumber($this->getPost('SignupStartNumber'));
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
		$this->setReturn ( 'parent.form_return("dialog_success(\'保存入园互动时段设置成功。\')");' );
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
		$o_system_setup=new Base_Setup(1);
		for($i=0;$i<count($a_data);$i++)
		{
			$o_stu=new Student_Info($a_data[$i]);
			$o_stu->setReject(1);
			$o_stu->Save();
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'操作成功！\')");' );
	}
	public function AssignClass($n_uid)
	{	
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}		
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120107 ))return;//如果没有权限，不返回任何值
		$a_data=json_decode($_POST['Vcl_StuId']);//获取选择的数据
		$s_result='';
		$o_admission_setup=new Admission_Setup(1);
		require_once RELATIVITY_PATH . 'sub/ye_info/include/ajax_operate.class.php';
		$o_operate = new Operate_YeInfo ();
		$o_system_setup=new Base_Setup(1);
		$o_survey=new Student_Onboard_Survey(1);//读取入园问卷
		for($i=0;$i<count($a_data);$i++)
		{
			//第一步，去采集系统验证是否可以添加
			$o_signup=new Student_Info($a_data[$i]);
			if ($o_signup->getState()!=6)
			{
				continue;
			}		
			$a_result=$o_operate->CheckStuCardidFromCaiji($o_signup->getIdType(),$o_signup->getId());
			if ($a_result->Flag==0)
			{
				//有重复
				$s_result.='
				<div class="item" style="line-height:18px;">
					<label style="font-size:14px;">'.($i+1).' 错误：幼儿证件与采集系统中已存在幼儿证件重复</label><br/>
					报名信息：'.$o_signup->getName().'（'.$o_signup->getIdType().' '.$o_signup->getId().'） <br/>
		        	<b>与以下幼儿信息重复：</b> <br/>
		        	幼儿园名称：'.$a_result->SchoolName.'（'.$a_result->ClassName.'）<br/>
					幼儿姓名：'.$a_result->Name.'（'.$o_signup->getIdType().' '.$o_signup->getId().'）
				</div>
				';
				continue;
			}
			$n_student_id='';
			//第二步，添加到采集系统中
			$a_result=$o_operate->UploadToAddStuInfoForAssignClass($o_signup,$this->getPost('ClassId'));
			if ($a_result->Flag==1)
			{
				$n_student_id=$a_result->StudentId;
			}else{
				$s_result.='
				<div class="item" style="line-height:18px;">
					<label style="font-size:14px;">'.($i+1).' 错误：分班失败</label><br/>
					报名信息：'.$o_signup->getName().'（'.$o_signup->getIdType().' '.$o_signup->getId().'） <br/>
		        	<b>错误代码：</b>'.$a_result->Msg.'，如有问题，请与管理员联系。
				</div>
				';
				continue;
			}
			//第三步，移动到在园信息中，1复制绑定记录，2.修改当前记录ID为返回值，3. 复制信息，3.删除报名信息
			$o_binding=new Student_Info_Wechat();
			$o_binding->PushWhere ( array ('&&', 'StudentId', '=',$o_signup->getStudentId()) );
			if ($o_binding->getAllCount()>0)
			{
				//将绑定记录复制
				$o_onboard_binding=new Student_Onboard_Info_Wechat();
				$o_onboard_binding->setUserId($o_binding->getUserId(0));
				$o_onboard_binding->setStudentId($n_student_id);
				$o_onboard_binding->Save();
				//家长进行公众号分组
				$o_wechat_user=new WX_User_Info($o_binding->getUserId(0));
				require_once RELATIVITY_PATH . 'sub/wechat/include/userGroup.class.php';
				$o_group = new userGroup();
				$o_group->updateGroup($o_wechat_user->getOpenId(), $this->getWechatSetup('PARENTGROUP'));
			}
			$o_class=new Student_Class($this->getPost('ClassId'));//获取班级信息			
			$o_signup->CutSignupToOnboard($o_signup->getStudentId());//不改变当前数据，直接移动到幼儿再园信息
			//修改在园信息，纠正ID号吗和班级信息
			$o_onboard=new Student_Onboard_Info($o_signup->getStudentId());
			$o_onboard->setStudentId($n_student_id);
			$o_onboard->setState(1);
			$o_onboard->setGradeNumber($o_class->getGrade());
			$o_onboard->setClassNumber($this->getPost('ClassId'));
			$o_onboard->Save();			
			//发送入园问卷调查			
			$o_stu=new Student_Onboard_Info_Class_Wechat_View();
			$o_stu->PushWhere ( array ('&&', 'StudentId', '=',$n_student_id) );
			$o_stu->getAllCount();
			$o_msg=new Wechat_Wx_User_Reminder();
			$o_msg->setUserId($o_stu->getUserId(0));
			$o_msg->setCreateDate($this->GetDateNow());
			$o_msg->setSendDate('0000-00-00');
			$o_msg->setMsgId($this->getWechatSetup('MSGTMP_09'));
			$o_msg->setOpenId($o_stu->getOpenid(0));
			$o_msg->setActivityId(0);
			$o_msg->setSend(0);
			$o_msg->setFirst($o_survey->getFirst().'
	
通知类型：问卷调查
幼儿姓名：'.$o_stu->getName(0));
				$o_msg->setKeyword1($o_stu->getClassName(0));
				$s_teacher_name=$o_user->getName();
				//$o_msg->setKeyword2(mb_substr($s_teacher_name,0,1,'utf-8').'老师');
				$o_msg->setKeyword2($s_teacher_name.'老师');
				$o_msg->setKeyword3($this->GetDate());
				$o_msg->setKeyword4($o_survey->getRemark());
				$o_msg->setKeyword5('');
				$o_msg->setRemark('');
				$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_operation/onboard_survey_answer.php?id='.$o_survey->getId().'&studentid='.$o_stu->getStudentId(0));
				$o_msg->setKeywordSum(10);
				$o_msg->Save();	
		}
		if($s_result=='')
		{
			$this->setReturn ( 'parent.form_return("dialog_success(\'分配班级成功，请继续操作。\')");parent.$(\'#Vcl_ClassId\').selectpicker(\'val\',\'\');parent.table_refresh(\'AdmissionTable\')' );
		}else{
			//将返回中文结果，跳转到另外一页显示。
			$this->setReturn ( 'parent.location="'.$this->getPost('Url').'admission_assign_result.php?text='.rawurlencode($s_result).'"' );
		}
	}
	public function WaitAuditSendNotice($n_uid)
	{
		sleep(1);
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120102 ))return;//如果没有权限，不返回任何值
		//获取目标人群
		$o_student = new Student_Info_Wechat_Wiew(); 
		$o_student->PushWhere ( array ('&&', 'State', '=',1) );
		//$o_student->PushWhere ( array ('&&', 'Reject', '=',0) );
		$o_student->PushWhere ( array ('&&', 'GradeNumber', '=',0) );
		$o_student->PushWhere ( array ('&&', 'ClassNumber', '=',0) );
		for($i=0;$i<$o_student->getAllCount();$i++)
		{
			$o_system_setup=new Base_Setup(1);
			//循环写入消息队列
			require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
			$o_msg=new Wechat_Wx_User_Reminder();
			$o_msg->setUserId($o_student->getUserId($i));
			$o_msg->setCreateDate($this->GetDateNow());
			$o_msg->setSendDate('0000-00-00');
			$o_msg->setMsgId($this->getWechatSetup('MSGTMP_11'));
			$o_msg->setOpenId($o_student->getOpenId($i));
			$o_msg->setActivityId(0);
			$o_msg->setSend(0);
			$o_msg->setFirst($this->getPost('First').'
					
幼儿编号：'.$o_student->getStudentId($i).'
幼儿姓名：'.$o_student->getName($i));
			$o_msg->setKeyword1('等待信息核验');
			$o_msg->setKeyword2($this->GetDateNow());
			$o_msg->setKeyword3('');
			$o_msg->setKeyword4('');
			$o_msg->setKeyword5('');
			$o_msg->setRemark('查看报名状态，请点击详情。');
			//如果Comment为空，那么就没有点击事件了
			$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/my_signup.php');
			$o_msg->setKeywordSum(2);
			$o_msg->Save();
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'发送通知成功！\',function(){\\parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
}

?>