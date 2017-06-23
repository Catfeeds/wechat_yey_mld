<?php
error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 50;	
	public function ParentSurveyManage($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120401 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Survey(); 
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Name', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('||', 'Id', 'like','%'.$s_key.'%') );
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
			$s_state='<span class="label label-warning">未发布</span>';
			if($o_user->getState($i)==1)
			{
				$s_state='<span class="label label-success">已发布</span>';
				array_push ( $a_button, array ('查看统计', "location='parent_survey_manage_modify.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('再次提醒', "location='parent_survey_manage_modify.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('进度详情', "location='send_notice_single.php?id=".$o_user->getStudentId($i)."'" ) );
			}else{				
				array_push ( $a_button, array ('修改标题', "location='parent_survey_manage_modify.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('编辑题目', "location='parent_survey_manage_question.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('发布问卷', "location='send_notice_single.php?id=".$o_user->getStudentId($i)."'" ) );
				array_push ( $a_button, array ('删除', "location='parent_survey_manage_modify.php?id=".$o_user->getStudentId($i)."'" ) );
			}
			$s_release_date=str_replace('0000-00-00 00:00:00', '', $o_user->getReleaseDate ( $i ));
			$o_answer=new Survey_Answers();
			$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_user->getId($i)) );
			//查询问卷下的题型
			$n_single=0;
			$n_multiple=0;
			$n_text=0;
			$o_temp=new Survey_Questions();
			$o_temp->PushWhere ( array ('&&', 'SurveyId', '=',$o_user->getId($i)) );
			$o_temp->PushWhere ( array ('&&', 'Type', '=',1) );
			$s_single=$o_temp->getAllCount();
			$o_temp=new Survey_Questions();
			$o_temp->PushWhere ( array ('&&', 'SurveyId', '=',$o_user->getId($i)) );
			$o_temp->PushWhere ( array ('&&', 'Type', '=',2) );
			$s_multiple=$o_temp->getAllCount();
			$o_temp=new Survey_Questions();
			$o_temp->PushWhere ( array ('&&', 'SurveyId', '=',$o_user->getId($i)) );
			$o_temp->PushWhere ( array ('&&', 'Type', '=',3) );
			$n_text=$o_temp->getAllCount();
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				str_replace(' ', '<br/>', $o_user->getCreateDate ( $i )),
				$o_user->getTitle ( $i ).'<br/><span style="color:#999999">单选:'.$n_single.'</span> <span style="color:#999999">多选:'.$n_multiple.'</span> <span style="color:#999999">简答:'.$n_text.'</span>',
				str_replace(' ', '<br/>', $o_user->getReleaseDate ( $i )),
				$o_user->getTargetName ( $i ),
				$s_state,
				$o_answer->getAllCount(),
				$a_button
				));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'序号', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'建立日期', 'CreateDate', 0, 80);
		$a_title=$this->setTableTitle($a_title,'问卷标题', 'Title', 0, 0);
		$a_title=$this->setTableTitle($a_title,'发布日期', 'ReleaseDate', 0, 80);
		$a_title=$this->setTableTitle($a_title,'问卷对象', '', 120, 0);
		$a_title=$this->setTableTitle($a_title,'当前状态', 'State', 0, 60);
		$a_title=$this->setTableTitle($a_title,'已答人数', '', 0, 60);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'ParentSurveyManage', 'yes', $n_page, $a_title, $a_row);
	}
	public function ParentSurveyManageAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120401 ))return; //如果没有权限，不返回任何值
		$o_table = new Survey ();
		$o_table->setTitle($this->getPost('Title'));
		$o_table->setCreateDate($this->GetDateNow());
		$o_table->setState(0);
		$o_table->setOwnerId($n_uid);
		$o_table->Save ();
		$this->setReturn ( 'parent.form_return("dialog_success(\'新建问卷成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function ParentSurveyManageQuestionAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120401 ))return; //如果没有权限，不返回任何值
		
		$this->setReturn ( 'parent.form_return("dialog_success(\'添加题目成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function ParentSurveyManageModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120401 ))return; //如果没有权限，不返回任何值
		$o_table = new Survey ($this->getPost('Id'));
		if ($o_table->getState()==0)
		{
			$o_table->setTitle($this->getPost('Title'));
			$o_table->Save();
		}		
		$this->setReturn ( 'parent.form_return("dialog_success(\'修改问卷成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function ParentSurveyManageQuestion($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120401 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Survey_Questions(); 
		$s_id=$this->getPost('key');
		$o_user->PushWhere ( array ('', 'SurveyId', '=',$s_id) );
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
			$s_type='';
			if ($o_user->getState ( $i )==1)
			$s_type='单选';
			if ($o_user->getState ( $i )==1)
			$s_type='多选';
			if ($o_user->getState ( $i )==1)
			$s_type='简答';
			array_push ($a_row, array (
				$o_user->getNumber ( $i ),
				$o_user->getTitle( $i ),
				$s_type,
				'',
				$a_button
			));				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'题号', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'问题', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'类型', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'选项', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'ParentSurveyManageQuestion', 'yes', $n_page, $a_title, $a_row);
	}
}
?>