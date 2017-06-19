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
			}else{
				array_push ( $a_button, array ('发通知', "dialog_message('对不起，该幼儿家长没有绑定微信，不能发生通知。')" ) );//查看
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
			array_push($a_target, array($o_stu->getName($i),$o_stu->getOpenid($i)));
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
		$o_notice->setSendDate($this->GetDateNow());
		$o_notice->setIsSend(1);
		$o_notice->Save();
		//循环写入消息队列
		
		$this->setReturn ( 'parent.form_return("dialog_success(\'发送通知成功！\',function(){\\parent.location=\''.$this->getPost('BackUrl').'\'})");' );	
	}
}

?>