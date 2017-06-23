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
			$o_user->PushWhere ( array ('||', 'Title', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('||', 'TargetName', 'like','%'.$s_key.'%') );
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
				array_push ( $a_button, array ('删除', "parent_survey_manage_delete(".$o_user->getId($i).")" ) );
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
			$n_single=$o_temp->getAllCount();
			$o_temp=new Survey_Questions();
			$o_temp->PushWhere ( array ('&&', 'SurveyId', '=',$o_user->getId($i)) );
			$o_temp->PushWhere ( array ('&&', 'Type', '=',2) );
			$n_multiple=$o_temp->getAllCount();
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
		//判断是否大于50题
		$o_table=new Survey_Questions();
		$o_table->PushWhere ( array ('&&', 'SurveyId', '=',$this->getPost('Id')) );
		if ($o_table->getAllCount()>=50)
		{
			$this->setReturn ( 'parent.form_return("dialog_message(\'对不起，问卷最大题目数为50，已经达到上限！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
		}
		$o_table = new Survey ($this->getPost('Id'));
		if ($o_table->getState()=='0')
		{
			//如果为未发布，才可以更改
			$o_question=new Survey_Questions();
			$o_question->setQuestion($this->getPost('Question'));
			$o_question->setType($this->getPost('Type'));
			$o_question->setNumber($this->getPost('Number'));
			$o_question->setSurveyId($this->getPost('Id'));
			$o_question->Save();
			$this->QuestionSort($o_question->getId(), $this->getPost('Number'), $this->getPost('Id'));
			//循环添加选项
			$a_number=array('','A','B','C','D','E','F','G','H','I','J');
			for($i=1;$i<=10;$i++)
			{
				if ($this->getPost('Option_'.$i)=='')
				{
					break;
				}
				$o_option=new Survey_Options();
				$o_option->setQuestionId($o_question->getId());
				$o_option->setNumber($a_number[$i]);
				$o_option->setOption($this->getPost('Option_'.$i));
				$o_option->Save();				
			}
		}		
		$this->setReturn ( 'parent.form_return("dialog_success(\'添加题目成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function ParentSurveyManageQuestionModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120401 ))return; //如果没有权限，不返回任何值
		$o_question=new Survey_Questions($this->getPost('QuestionId'));
		$o_survey = new Survey ($o_question->getSurveyId());
		if ($o_survey->getState()=='0')
		{
			//如果为未发布，才可以更改			
			$o_question->setQuestion($this->getPost('Question'));
			$o_question->setType($this->getPost('Type'));
			$o_question->setNumber($this->getPost('Number'));
			$o_question->Save();
			$this->QuestionSort($o_question->getId(), $this->getPost('Number'), $o_question->getSurveyId());
			//循环添加选项
			$o_option=new Survey_Options();
			$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId()) );
			$o_option->DeletionWhere();
			$a_number=array('','A','B','C','D','E','F','G','H','I','J');
			for($i=1;$i<=10;$i++)
			{
				if ($this->getPost('Option_'.$i)=='')
				{
					break;
				}
				$o_option=new Survey_Options();
				$o_option->setQuestionId($o_question->getId());
				$o_option->setNumber($a_number[$i]);
				$o_option->setOption($this->getPost('Option_'.$i));
				$o_option->Save();				
			}
		}		
		$this->setReturn ( 'parent.form_return("dialog_success(\'修改题目成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function ParentSurveyManageQuestionDelete($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120401 ))return; //如果没有权限，不返回任何值
		$o_question=new Survey_Questions($this->getPost('id'));
		$o_survey = new Survey ($o_question->getSurveyId());
		if ($o_survey->getState()=='0')
		{
			$o_question->Deletion();
			$o_option=new Survey_Options();
			$o_option->PushWhere ( array ('&&', 'QuestionId', '=', $this->getPost('id') ) );
			$o_option->DeletionWhere();
			$this->QuestionSort($this->getPost('id'),100, $o_survey->getId());
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}	
	private function QuestionSort($n_questionid, $n_number, $n_surveyid) {
		$o_all = new Survey_Questions ();
		$o_all->PushWhere ( array ('&&', 'Id', '<>', $n_questionid ) );
		$o_all->PushWhere ( array ('&&', 'SurveyId', '=', $n_surveyid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Survey_Questions ( $o_all->getId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function ParentSurveyManageModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120401 ))return; //如果没有权限，不返回任何值
		$o_table = new Survey ($this->getPost('Id'));
		if ($o_table->getState()=='0')
		{
			$o_table->setTitle($this->getPost('Title'));
			$o_table->Save();
		}		
		$this->setReturn ( 'parent.form_return("dialog_success(\'修改问卷成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function ParentSurveyManageDelete($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120401 ))return; //如果没有权限，不返回任何值
		$o_survey = new Survey ($this->getPost('id'));
		if ($o_survey->getState()=='0')
		{
			$o_survey->Deletion();
			//循环删除问题
			$o_question=new Survey_Questions();
			$o_question->PushWhere ( array ('&&', 'SurveyId', '=', $this->getPost('id') ) );
			for($i=0;$i<$o_question->getAllCount();$i++)
			{
				$o_option=new Survey_Options();
				$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) );
				$o_option->DeletionWhere();
			}
			$o_question->DeletionWhere();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
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
		$o_user->PushWhere ( array ('&&', 'SurveyId', '=',$s_id) );
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
			array_push ( $a_button, array ('修改', "location='parent_survey_manage_question_modify.php?questionid=".$o_user->getId($i)."'") );
			array_push ( $a_button, array ('删除', "parent_survey_manage_question_delete(".$o_user->getId($i).")"));
			$s_type='';
			$s_option='<span class="glyphicon glyphicon-chevron-down"></span>';
			if ($o_user->getType ( $i )==1)
			$s_type='单选';
			if ($o_user->getType ( $i )==2)
			$s_type='多选';
			if ($o_user->getType ( $i )==3)
			{
				$s_type='简答';
				$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
			}			
			array_push ($a_row, array (
				'<span class="label label-success">'.$o_user->getNumber ( $i ).'</span>',
				$o_user->getQuestion( $i ),
				$s_type,
				$s_option,
				$a_button
			));
			//循环读取选项
			$o_option=new Survey_Options();
			$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_user->getId ( $i )) );
			$o_option->PushOrder ( array ('Id','A') );
			for($j=0;$j<$o_option->getAllCount();$j++)
			{
				array_push ($a_row, array (
					'',
					'',
					'',
					$o_option->getNumber($j).'. '.$o_option->getOption($j),
					array ()
				));
			}					
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'题号', 'Number', 70, 0);
		$a_title=$this->setTableTitle($a_title,'问题', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'类型', '', 80, 0);
		$a_title=$this->setTableTitle($a_title,'选项', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 80,0);
		$this->SendJsonResultForTable($n_allcount,'ParentSurveyManageQuestion', 'yes', $n_page, $a_title, $a_row);
	}
}
?>