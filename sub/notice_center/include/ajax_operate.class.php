<?php
error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/notice_center/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 50;	
	public function NoticeCenterTargetList($n_uid)
	{	
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120301 ))return;//如果没有权限，不返回任何值
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
			$a_button = array ();
			
			//检查是否已经绑定
			$o_onboard_wechat=new Student_Onboard_Info_Wechat();
			$o_onboard_wechat->PushWhere ( array ('&&', 'StudentId', '=',$o_user->getStudentId($i)) );
			$s_binding_wx='';
			if ($o_onboard_wechat->getAllCount()>0)
			{
				array_push ( $a_button, array ('发通知', "location='send_notice_single.php?id=".$o_user->getStudentId($i)."'" ) );//查看
				$s_binding_wx='<span class="glyphicon fa fa-weixin" title="已绑定微信" aria-hidden="true" style="color:#2AA144" data-placement="left" data-toggle="tooltip"></span> ';
			}		
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				$s_binding_wx.$o_user->getName ( $i ),
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
		$this->SendJsonResultForTable($n_allcount,'NoticeCenterTargetList', 'yes', $n_page, $a_title, $a_row);
	}
	public function SendNoticeMultiple($n_uid)
	{
		sleep(1);
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120301 ))return;//如果没有权限，不返回任何值
		//获取目标人群
		$o_stu=new Student_Onboard_Info_Class_Wechat_View();
		if ($this->getPost('Target')>0)
		{
			$o_stu->PushWhere ( array ('&&', 'ClassNumber', '=',$this->getPost('Target')) );
		}
		$a_target=array();
		for($i=0;$i<$o_stu->getAllCount();$i++)
		{
			array_push($a_target, array($o_stu->getName($i),$o_stu->getClassName($i),$o_stu->getUserId($i),$o_stu->getOpenid($i)));
		}
		//获得目标人群名称
		$s_target='所有在园幼儿';
		if($this->getPost('Target')>0)
		{
			$s_grade_name='';
			$o_class=new Student_Class($this->getPost('Target'));
			//区分年级
			switch ($o_class->getGrade())
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
			$s_target=$s_grade_name.'('.$o_class->getClassName().')';
		}
		//写入消息记录
		$o_notice=new Notice_Center_Record();
		$o_notice->setCreateDate($this->GetDateNow());
		$a_deptid=$o_user->getDeptId();
		$o_notice->setDeptId($a_deptid[0]);
		$o_notice->setUid($n_uid);
		$o_notice->setTarget(json_encode($a_target));		
		$o_notice->setTargetName($s_target);
		$o_notice->setFirst($this->getPost('First'));
		$o_notice->setRemark($this->getPost('Remark'));
		$o_notice->setComment($this->getPost('Comment'));
		$o_notice->setType($this->getPost('Type'));
		$o_notice->setSendDate($this->GetDateNow());
		$o_notice->setIsSend(1);
		$o_notice->Save();
		$o_system_setup=new Base_Setup(1);
		//循环写入消息队列
		require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
		for($i=0;$i<count($a_target);$i++)
		{
			$a_temp=$a_target[$i];
			//添加消息队列
			$o_msg=new Wechat_Wx_User_Reminder();
			$o_msg->setUserId($a_temp[2]);
			$o_msg->setCreateDate($this->GetDateNow());
			$o_msg->setSendDate('0000-00-00');
			$o_msg->setMsgId($this->getWechatSetup('MSGTMP_09'));
			$o_msg->setOpenId($a_temp[3]);
			$o_msg->setActivityId(0);
			$o_msg->setSend(0);
			$o_msg->setFirst($this->getPost('First').'

通知类型：'.$this->getPost('Type').'
幼儿姓名：'.$a_temp[0]);
			$o_msg->setKeyword1($a_temp[1]);
			$s_teacher_name=$o_user->getName();
			//$o_msg->setKeyword2(mb_substr($s_teacher_name,0,1,'utf-8').'老师');
			$o_msg->setKeyword2($s_teacher_name.'老师');
			$o_msg->setKeyword3($this->GetDate());
			$o_msg->setKeyword4($this->getPost('Remark'));
			$o_msg->setKeyword5('');
			$o_msg->setRemark('');
			//如果Comment为空，那么就没有点击事件了
			$o_msg->setUrl('');
			if($this->getPost('Comment')!='')
			{
				$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_operation/notice_review.php?id='.$o_notice->getId().'');
			}
			$o_msg->setKeywordSum(10);
			$o_msg->Save();
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'发送通知成功！\',function(){\\parent.location=\''.$this->getPost('BackUrl').'\'})");' );	
	}
	public function SendNoticeSingle($n_uid)
	{
		sleep(1);
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120301 ))return;//如果没有权限，不返回任何值
		//获取目标人群
		$o_stu=new Student_Onboard_Info_Class_Wechat_View($this->getPost('Target'));
		$a_target=array();
		array_push($a_target, array($o_stu->getName(),$o_stu->getClassName(),$o_stu->getUserId(),$o_stu->getOpenid()));
		//获得目标人群名称
		$s_target=$o_stu->getName().'('.$o_stu->getClassName().')';
		//写入消息记录
		$o_notice=new Notice_Center_Record();
		$o_notice->setCreateDate($this->GetDateNow());
		$a_deptid=$o_user->getDeptId();
		$o_notice->setDeptId($a_deptid[0]);
		$o_notice->setUid($n_uid);
		$o_notice->setTarget($this->getPost('Target'));		
		$o_notice->setTargetName($s_target);
		$o_notice->setFirst($this->getPost('First'));
		$o_notice->setRemark($this->getPost('Remark'));
		$o_notice->setComment($this->getPost('Comment'));
		$o_notice->setType($this->getPost('Type'));
		$o_notice->setSendDate($this->GetDateNow());
		$o_notice->setIsSend(1);
		$o_notice->Save();
		$o_system_setup=new Base_Setup(1);
		//循环写入消息队列
		require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
		for($i=0;$i<count($a_target);$i++)
		{
			$a_temp=$a_target[$i];
			//添加消息队列
			$o_msg=new Wechat_Wx_User_Reminder();
			$o_msg->setUserId($a_temp[2]);
			$o_msg->setCreateDate($this->GetDateNow());
			$o_msg->setSendDate('0000-00-00');
			$o_msg->setMsgId($this->getWechatSetup('MSGTMP_09'));
			$o_msg->setOpenId($a_temp[3]);
			$o_msg->setActivityId(0);
			$o_msg->setSend(0);
			$o_msg->setFirst($this->getPost('First').'

通知类型：'.$this->getPost('Type').'
幼儿姓名：'.$a_temp[0]);
			$o_msg->setKeyword1($a_temp[1]);
			$s_teacher_name=$o_user->getName();
			$o_msg->setKeyword2($s_teacher_name.'老师');
			$o_msg->setKeyword3($this->GetDate());
			$o_msg->setKeyword4($this->getPost('Remark'));
			$o_msg->setKeyword5('');
			$o_msg->setRemark('');
			//如果Comment为空，那么就没有点击事件了
			$o_msg->setUrl('');
			if($this->getPost('Comment')!='')
			{
				$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_operation/notice_review.php?id='.$o_notice->getId().'');
			}
			$o_msg->setKeywordSum(10);
			$o_msg->Save();
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'发送通知成功！\',function(){\\parent.location=\''.$this->getPost('BackUrl').'\'})");' );	
	}
	public function NoticeRecordTable($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120302 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Notice_Center_Record_View(); 
		$o_user->PushWhere ( array ('&&', 'Uid', '=',$n_uid) );		
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
			if($o_user->getComment($i)!='')
			{
				array_push ( $a_button, array ('详情', "location='record_detail.php?id=".$o_user->getId($i)."'" ) );//查看
			}
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				str_replace(' ', '<br/>', $o_user->getSendDate ( $i )),
				str_replace('(', '<br/>(', $o_user->getTargetName ( $i )),
				$o_user->getFirst ( $i ),
				$o_user->getType ( $i ),
				$o_user->getRemark ( $i ),
				$a_button
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'序号', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'发送时间', 'SendDate', 0, 90);
		$a_title=$this->setTableTitle($a_title,'发送对象', '', 0, 90);
		$a_title=$this->setTableTitle($a_title,'通知标题', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'通知类型', 'Type', 0, 80);
		$a_title=$this->setTableTitle($a_title,'通知内容', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'NoticeRecordTable', 'yes', $n_page, $a_title, $a_row);
	}
}
?>