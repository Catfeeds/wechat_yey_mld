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
		$o_operator = new Single_User ( $n_uid );
		if (!$o_operator->ValidModule ( 120401 ))return;//如果没有权限，不返回任何值
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
				array_push ( $a_button, array ('查看统计', "location='parent_survey_manage_summary.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('再次提醒', "parent_survey_manage_remember(".$o_user->getId($i).")" ) );
				array_push ( $a_button, array ('进度详情', "location='parent_survey_manage_progress.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('结束问卷', "parent_survey_manage_end(".$o_user->getId($i).")" ) );
				array_push ( $a_button, array ('复制问卷', "parent_survey_manage_copy(".$o_user->getId($i).")" ) );
				if ($o_operator->getRoleId()==1)
				{
					//如果是超级管理员，那么可以删除
					array_push ( $a_button, array ('删除', "parent_survey_manage_delete(".$o_user->getId($i).")" ) );
				}
			}elseif ($o_user->getState($i)==2){		
				$s_state='<span class="label label-danger">已结束</span>';		
				array_push ( $a_button, array ('查看统计', "location='parent_survey_manage_summary.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('查看答卷', "location='parent_survey_manage_answered.php?id=".$o_user->getId($i)."'" ) );//删除
				array_push ( $a_button, array ('复制问卷', "parent_survey_manage_copy(".$o_user->getId($i).")" ) );
				if ($o_operator->getRoleId()==1)
				{
					//如果是超级管理员，那么可以删除
					array_push ( $a_button, array ('删除', "parent_survey_manage_delete(".$o_user->getId($i).")" ) );
				}
			}else{
				array_push ( $a_button, array ('修改问卷', "location='parent_survey_manage_modify.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('编辑题目', "location='parent_survey_manage_question.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('复制问卷', "parent_survey_manage_copy(".$o_user->getId($i).")" ) );
				array_push ( $a_button, array ('发布问卷', "location='parent_survey_manage_release.php?id=".$o_user->getId($i)."'" ) );				
				array_push ( $a_button, array ('删除', "parent_survey_manage_delete(".$o_user->getId($i).")" ) );
			}
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
			$a_release=explode(' ', str_replace('0000-00-00 00:00:00', '', $o_user->getReleaseDate ( $i )));
			$a_end=explode(' ', str_replace('0000-00-00 00:00:00', '', $o_user->getEndDate ( $i )));
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				str_replace(' ', '<br/>', $o_user->getCreateDate ( $i )),
				$o_user->getTitle ( $i ).'<br/><span style="color:#999999">单选:'.$n_single.'</span> <span style="color:#999999">多选:'.$n_multiple.'</span> <span style="color:#999999">简述:'.$n_text.'</span>',
				'发布:'.$a_release[0].'<br/>结束:'.$a_end[0],
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
		$a_title=$this->setTableTitle($a_title,'发布、结束日期', '', 0, 90);
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
		$o_table->setComment($this->FilterUserInput($this->getPost('Comment')));
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
	private function QuestionSortForTeacher($n_questionid, $n_number, $n_surveyid) {
		$o_all = new Survey_Teacher_Questions ();
		$o_all->PushWhere ( array ('&&', 'Id', '<>', $n_questionid ) );
		$o_all->PushWhere ( array ('&&', 'SurveyId', '=', $n_surveyid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Survey_Teacher_Questions ( $o_all->getId ( $i ) );
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
			$o_table->setComment($this->getPost('Comment'));
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
		if ($o_survey->getState()=='0' || $o_user->getRoleId()==1)
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
			//删除说有答案
			$o_answer=new Survey_Answers();
			$o_answer->PushWhere ( array ('&&', 'SurveyId', '=', $this->getPost('id') ) );
			$o_answer->DeletionWhere();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function ParentSurveyManageEnd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120401 ))return; //如果没有权限，不返回任何值
		$o_survey = new Survey ($this->getPost('id'));
		if ($o_survey->getState()=='1')
		{
			//计算已答人数
			$o_answer=new Survey_Answers();
			$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
			$o_survey->setCompletedSum($o_answer->getAllCount());
			//计算未答人数
			$a_target=json_decode($o_survey->getTargetList());
			$o_table=new Student_Onboard_Info_Class_Wechat_View();
			for($i=0;$i<count($a_target);$i++)
			{
				$o_table->PushWhere ( array ('||', 'ClassNumber', '=',$a_target[$i]) );
			}
			$n_count = $o_table->getAllCount ();
			$n_pending=0;
			for($i = 0; $i < $n_count; $i ++) {
				//判断是否完成问卷
				$o_answer=new Survey_Answers();
				$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
				$o_answer->PushWhere ( array ('&&', 'UserId', '=',$o_table->getUserId($i)) );
				$o_answer->PushWhere ( array ('&&', 'StudentId', '=',$o_table->getStudentId($i)) );
				if ($o_answer->getAllCount()==0)
				{
					$n_pending++;
				}
			}
			$o_survey->setPendingSum($n_pending);
			$o_survey->setState(2);
			$o_survey->setEndDate($this->GetDateNow());
			$o_survey->Save();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function ParentSurveyManageCopy($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120401 ))return; //如果没有权限，不返回任何值
		$o_survey = new Survey ($this->getPost('id'));
		//创建问卷
		$o_survey_new=new Survey();
		$o_survey_new->setCreateDate($this->GetDateNow());
		$o_survey_new->setTitle('（副本）'.$o_survey->getTitle());
		$o_survey_new->setComment($o_survey->getComment());
	    $o_survey_new->setState(0);
	    $o_survey_new->setOwnerId($n_uid);
	    $o_survey_new->Save();
	    //循环创建题
	    $o_question=new Survey_Questions();
	    $o_question->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
	    for($i=0;$i<$o_question->getAllCount();$i++)
	    {
	    	$o_temp=new Survey_Questions();
	    	$o_temp->setSurveyId($o_survey_new->getId());
    		$o_temp->setQuestion($o_question->getQuestion($i));
    		$o_temp->setType($o_question->getType($i));
    		$o_temp->setNumber($o_question->getNumber($i));
    		$o_temp->Save();
    		//循环选项
    		$o_option=new Survey_Options();
    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) );
    		for($j=0;$j<$o_option->getAllCount();$j++)
    		{
    			$o_temp2=new Survey_Options();
    			$o_temp2->setQuestionId($o_temp->getId());
    			$o_temp2->setOption($o_option->getOption($j));
    			$o_temp2->setNumber($o_option->getNumber($j));
    			$o_temp2->Save();    			
    		}
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
		$n_number=1;
		for($i = 0; $i < $n_count; $i ++) {
			$a_button = array ();
			array_push ( $a_button, array ('修改', "location='parent_survey_manage_question_modify.php?questionid=".$o_user->getId($i)."'") );
			array_push ( $a_button, array ('删除', "parent_survey_manage_question_delete(".$o_user->getId($i).")"));
			$s_type='';
			$s_number='<span class="label label-success">'.$n_number.'</span>';
			$s_question='&nbsp;&nbsp;&nbsp;&nbsp;'.$o_user->getQuestion( $i );
			$s_option='<span class="glyphicon glyphicon-chevron-down"></span>';
			if ($o_user->getType ( $i )==1)
			$s_type='单选';
			if ($o_user->getType ( $i )==2)
			$s_type='多选';
			if ($o_user->getType ( $i )==3)
			{
				$s_type='简述';
				$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
			}
			if ($o_user->getType ( $i )==4)			
			{
				$s_type='子标题';
				$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$s_question='<b style="font-size:14px;">'.$o_user->getQuestion( $i ).'</b>';
				$s_number='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$n_number--;	
			}			
			array_push ($a_row, array (
				$s_number,
				$s_question,
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
			$n_number++;				
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
	public function ParentSurveyManageRelease($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120401 ))return;//如果没有权限，不返回任何值
		//检查问卷对象是否被选择
		$a_target=array();
		$s_target_name='';
		$o_class=new Student_Class();
		$o_class->PushOrder ( array ('Grade','A') );
		$o_class->PushOrder ( array ('ClassId','A') );
		$n_count=$o_class->getAllCount();
		for($i=0;$i<$n_count;$i++)
		{
			if ($this->getPost('Target_'.$o_class->getClassId($i))=='on')
			{
				array_push($a_target, $o_class->getClassId($i));
				//区分年级
				switch ($o_class->getGrade($i))
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
				$s_target_name.=$o_class->getClassName($i).';';
			}			
		}
		if ($s_target_name=='')
		{
			$this->setReturn ( 'parent.form_return("dialog_message(\'对不起，请选择问卷对象！\')");' );
		}
		//修正文字发送对象
		if($n_count==count($a_target))
		{
			$s_target_name='所有在园幼儿;';
		}
		//保存数据到问卷信息
		$o_survey=new Survey($this->getPost('Id'));
		if($o_survey->getState()=='0')
		{
			//只有未发布的问卷才能往下进行
			$o_survey->setReleaseDate($this->GetDateNow());
			$o_survey->setTargetName(substr($s_target_name,0,strlen($s_target_name)-1));
			$o_survey->setTargetList(json_encode($a_target));
			$o_survey->setFirst($this->getPost('First'));
			$o_survey->setRemark($this->getPost('Remark'));
			$o_survey->setState(1);
			$o_survey->Save();
			//根据问卷对象循环发送通知
			$o_system_setup=new Base_Setup(1);
			require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
			for($i=0;$i<count($a_target);$i++)
			{
				//获取用户列表
				$o_stu=new Student_Onboard_Info_Class_Wechat_View();
				$o_stu->PushWhere ( array ('&&', 'ClassNumber', '=',$a_target[$i]) );
				for($j=0;$j<$o_stu->getAllCount();$j++)
				{
					//添加消息队列
					$o_msg=new Wechat_Wx_User_Reminder();
					$o_msg->setUserId($o_stu->getUserId($j));
					$o_msg->setCreateDate($this->GetDateNow());
					$o_msg->setSendDate('0000-00-00');
					$o_msg->setMsgId($this->getWechatSetup('MSGTMP_09'));
					$o_msg->setOpenId($o_stu->getOpenid($j));
					$o_msg->setActivityId(0);
					$o_msg->setSend(0);
					$o_msg->setFirst($this->getPost('First').'
		
通知类型：问卷调查
幼儿姓名：'.$o_stu->getName($j));
					$o_msg->setKeyword1($o_stu->getClassName($j));
					$s_teacher_name=$o_user->getName();
					$o_msg->setKeyword2($s_teacher_name.'老师');
					$o_msg->setKeyword3($this->GetDate());
					$o_msg->setKeyword4($this->getPost('Remark'));
					$o_msg->setKeyword5('');
					$o_msg->setRemark('');
					$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_operation/survey_answer.php?id='.$this->getPost('Id').'&studentid='.$o_stu->getStudentId($j));
					$o_msg->setKeywordSum(10);
					$o_msg->Save();	
				}			
			}
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'发布问卷成功！\',function(){\\parent.location=\''.$this->getPost('BackUrl').'\'})");' );	
	}
	public function ParentSurveyManageProgress($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120401 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_survey = new Survey($this->getPost('key'));
		//获得target的班级list
		$a_target=json_decode($o_survey->getTargetList());
		$o_table=new Student_Onboard_Info_Class_Wechat_View();
		for($i=0;$i<count($a_target);$i++)
		{
			$o_table->PushWhere ( array ('||', 'ClassNumber', '=',$a_target[$i]) );
			if ($this->getPost('other_key')!='')
			{
				$o_table->PushWhere ( array ('&&', 'Name', 'like','%'.$this->getPost('other_key').'%') );
				$o_table->PushWhere ( array ('||', 'ClassNumber', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('&&', 'Id', 'like','%'.$this->getPost('other_key').'%') );
			}
		}
		$o_table->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_table->setCountLine ( $this->N_PageSize );
		$n_count = $o_table->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_table->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_table->getAllCount ();//总记录数
		$n_count = $o_table->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_grade_name='';			
			//区分年级
			switch ($o_table->getGrade($i))
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
			$s_sign_name='';
			if ($o_table->getDelFlag ( $i )==1)
			{
				$s_sign_name=' <span class="label label-danger">取消关注</span>';
			}
			$a_button = array ();
			//判断是否完成问卷
			$o_answer=new Survey_Answers();
			$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
			$o_answer->PushWhere ( array ('&&', 'UserId', '=',$o_table->getUserId($i)) );
			$o_answer->PushWhere ( array ('&&', 'StudentId', '=',$o_table->getStudentId($i)) );
			if ($o_answer->getAllCount()>0)
			{
				$s_sign_name.=' <span class="label label-success"><span class="glyphicon glyphicon-ok"></span></span>';
				array_push ( $a_button, array ('查看答卷', "location='parent_survey_manage_progress_sheet.php?id=".$o_answer->getId(0)."'" ) );//删除
				array_push ( $a_button, array ('打印', "window.open('parent_survey_manage_progress_pdf.php?id=".$o_answer->getId(0)."','_blank')" ) );//删除
			}	
			$o_student=new Student_Onboard_Info($o_table->getStudentId($i));		
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				'<img style="width:32px;height:32px;" src="'.$o_table->getPhoto ( $i ).'">',
				$o_table->getNickname ( $i ).$s_sign_name,
				$o_table->getName ( $i ),
				$s_grade_name.'('.$o_table->getClassName ( $i ).')',
				$o_table->getSex ( $i ),
				$o_table->getId ( $i ).'<br/><span style="color:#999999">'.$o_table->getIdType( $i ).'</span>',
				$o_student->getJh1Name().'-<span style="color:#999999">'.$o_student->getJh1Phone().'</span><br/>'.$o_student->getJh2Name().'-<span style="color:#999999">'.$o_student->getJh2Phone().'</span>',
				$a_button
				));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'头像', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'微信昵称', 'Nickname', 150, 0);	
		$a_title=$this->setTableTitle($a_title,'幼儿姓名', 'Name', 0, 0);	
		$a_title=$this->setTableTitle($a_title,'班级名称', 'ClassNumber', 0, 0);
		$a_title=$this->setTableTitle($a_title,'性别', 'Sex', 0, 0);		
		$a_title=$this->setTableTitle($a_title,'证件号', 'Id', 0, 0);
		$a_title=$this->setTableTitle($a_title,'监护人', 'UserName', 0, 60);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 90,0);
		$this->SendJsonResultForTable($n_allcount,'ParentSurveyManageProgress', 'yes', $n_page, $a_title, $a_row);
	}
	public function ParentSurveyManageGetProgress($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User($n_uid);
		if (!$o_user->ValidModule ( 120401 ))return;//如果没有权限，不返回任何值
		$o_survey = new Survey($this->getPost('id'));
		//获得target的班级list
		//如果是已结束问卷，那么直接读取结果
		if($o_survey->getState()==2)
		{
			$n_count=$o_survey->getCompletedSum()+$o_survey->getPendingSum();
			$n_completed=$o_survey->getCompletedSum();
		}else{
			$a_target=json_decode($o_survey->getTargetList());
			$o_table=new Student_Onboard_Info_Class_Wechat_View();
			for($i=0;$i<count($a_target);$i++)
			{
				$o_table->PushWhere ( array ('||', 'ClassNumber', '=',$a_target[$i]) );
			}
			$n_count = $o_table->getAllCount ();
			$n_completed=0;
			for($i = 0; $i < $n_count; $i ++) {
				//判断是否完成问卷
				$o_answer=new Survey_Answers();
				$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
				$o_answer->PushWhere ( array ('&&', 'UserId', '=',$o_table->getUserId($i)) );
				$o_answer->PushWhere ( array ('&&', 'StudentId', '=',$o_table->getStudentId($i)) );
				if ($o_answer->getAllCount()>0)
				{
					$n_completed++;
				}
			}
		}		
		$a_result = array (
					'status' =>'<span class="label label-success">完成 '.$n_completed.'</span>&nbsp;&nbsp;<span class="label label-warning">未完 '.($n_count-$n_completed).'</span>&nbsp;&nbsp;<span class="label label-primary">完成率 '.sprintf("%.0f", ($n_completed/$n_count)*100).'%</span>'
				);
		echo(json_encode ($a_result));
	}
	public function ParentSurveyManageSummary($n_uid)
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
		//计算答题总人数
		$o_answer=new Survey_Answers();
		$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$s_id) );
		$n_answer_sum=$o_answer->getAllCount();
		$n_number=1;
		for($i = 0; $i < $n_count; $i ++) {
			$a_button = array ();
			$s_type='';
			$s_number='<span class="label label-success">'.$n_number.'</span>';
			$s_question='&nbsp;&nbsp;&nbsp;&nbsp;'.$o_user->getQuestion( $i );
			$s_option='<span class="glyphicon glyphicon-chevron-down"></span>';
			if ($o_user->getType ( $i )==1)
			$s_type='单选';
			if ($o_user->getType ( $i )==2)
			$s_type='多选';
			if ($o_user->getType ( $i )==3)
			{
				$s_type='简述';
				//统计简述的答题人数
				$o_answer=new Survey_Answers();
				$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$s_id) );
				$o_answer->PushWhere ( array ('&&', 'Answer'.$o_user->getNumber($i), '<>','') );
				$s_option=$o_answer->getAllCount().' 人';
				array_push ( $a_button, array ('详情', "location='parent_survey_manage_summary_detail.php?id=".$o_user->getId($i)."'") );
			}
			if ($o_user->getType ( $i )==4)			
			{
				$s_type='子标题';
				$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$s_question='<b style="font-size:14px;">'.$o_user->getQuestion( $i ).'</b>';
				$s_number='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$n_number--;	
			}		
			array_push ($a_row, array (
				$s_number,
				$s_question,
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
				$a_button = array ();
				$o_answer=new Survey_Answers();
				$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$s_id) );
				$o_answer->PushWhere ( array ('&&', 'Answer'.$o_user->getNumber($i), 'like','%"'.$o_option->getId($j).'"%') );
				$n_people=$o_answer->getAllCount();
				$n_rate=round(($n_people/$n_answer_sum)*1000)/10;//结果*1000取整再除以10
				if($n_rate>0)
				{
					array_push ( $a_button, array ('人群', "location='parent_survey_manage_summary_people.php?id=".$o_option->getId($j)."'") );
				}
				array_push ($a_row, array (
					'',
					'',
					$n_people.'人 ('.$n_rate.'%)',
					$o_option->getNumber($j).'. '.$o_option->getOption($j),
					$a_button
				));
			}
			$n_number++;
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'题号', 'Number', 70, 0);
		$a_title=$this->setTableTitle($a_title,'问题', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'类型', '', 120, 0);
		$a_title=$this->setTableTitle($a_title,'选项', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 80,0);
		$this->SendJsonResultForTable($n_allcount,'ParentSurveyManageSummary', 'yes', $n_page, $a_title, $a_row);
	}
	public function ParentSurveyManageSummaryPeople($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120401 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_option=new Survey_Options($this->getPost('key'));
		$o_question=new Survey_Questions($o_option->getQuestionId());
		$o_table = new Survey_Answers();
		//获得target的班级list
		$o_table->PushWhere ( array ('&&', 'Answer'.$o_question->getNumber(), 'like','%"'.$o_option->getId().'"%') );
		$o_table->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_table->setCountLine ( $this->N_PageSize );
		$n_count = $o_table->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_table->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_table->getAllCount ();//总记录数
		$n_count = $o_table->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_student=new Student_Onboard_Info($o_table->getStudentId($i));
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),				
				$o_table->getName ( $i ),
				$o_table->getClassName ( $i ),
				$o_table->getSex ( $i ),
				$o_table->getCardId ( $i ),
				$o_student->getJh1Name().'-<span style="color:#999999">'.$o_student->getJh1Phone().'</span><br/>'.$o_student->getJh2Name().'-<span style="color:#999999">'.$o_student->getJh2Phone().'</span>'
				));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'幼儿姓名', 'Name', 0, 80);	
		$a_title=$this->setTableTitle($a_title,'班级名称', 'ClassName', 0, 0);
		$a_title=$this->setTableTitle($a_title,'性别', '', 0, 0);		
		$a_title=$this->setTableTitle($a_title,'证件号', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'监护人', '', 0, 80);
		$this->SendJsonResultForTable($n_allcount,'ParentSurveyManageSummaryPeople', 'no', $n_page, $a_title, $a_row);
	}
	public function ParentSurveyManageSummaryDetail($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120401 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_question=new Survey_Questions($this->getPost('key'));
		$o_table = new Survey_Answers();
		//获得target的班级list
		$o_table->PushWhere ( array ('&&', 'Answer'.$o_question->getNumber(), '<>','') );
		$o_table->PushWhere ( array ('&&', 'SurveyId', '=',$o_question->getSurveyId()) );
		$o_table->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_table->setCountLine ( $this->N_PageSize );
		$n_count = $o_table->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_table->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_table->getAllCount ();//总记录数
		$n_count = $o_table->getCount ();
		$a_row = array ();		
		for($i = 0; $i < $n_count; $i ++) {	
			eval('$s_answer=$o_table->getAnswer'.$o_question->getNumber().'($i);');
			$s_answer=rawurldecode(str_replace('"', '', $s_answer));
			$o_student=new Student_Onboard_Info($o_table->getStudentId($i));	
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),				
				$o_table->getName ( $i ),
				$o_table->getClassName ( $i ),
				$o_table->getSex ( $i ),
				$o_student->getJh1Name().'-<span style="color:#999999">'.$o_student->getJh1Phone().'</span><br/>'.$o_student->getJh2Name().'-<span style="color:#999999">'.$o_student->getJh2Phone().'</span>',
				$s_answer
				));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 60, 0);
		$a_title=$this->setTableTitle($a_title,'幼儿姓名', 'Name', 0, 0);	
		$a_title=$this->setTableTitle($a_title,'班级名称', 'ClassName', 0, 0);
		$a_title=$this->setTableTitle($a_title,'性别', '', 0, 0);		
		$a_title=$this->setTableTitle($a_title,'监护人', 'UserName', 0, 0);
		$a_title=$this->setTableTitle($a_title,'简述', '', 0, 0);
		$this->SendJsonResultForTable($n_allcount,'ParentSurveyManageSummaryDetail', 'no', $n_page, $a_title, $a_row);
	}
	public function ParentSurveyManageRemember($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120402 ))return;//如果没有权限，不返回任何值
		$o_survey=new Survey_Teacher($this->getPost('id'));
		$a_target=json_decode($o_survey->getTargetList());
		if ($o_survey->getState()=='1')
		{
			//根据问卷对象循环发送通知
			$o_system_setup=new Base_Setup(1);
			require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
			for($i=0;$i<count($a_target);$i++)
			{
				//获取用户列表
				$o_stu=new Student_Onboard_Info_Class_Wechat_View();
				$o_stu->PushWhere ( array ('&&', 'ClassNumber', '=',$a_target[$i]) );
				for($j=0;$j<$o_stu->getAllCount();$j++)
				{
					//判断是否已经答题，如果答题那么跳过
					$o_answer=new Survey_Answers();
					$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
					$o_answer->PushWhere ( array ('&&', 'UserId', '=',$o_stu->getUserId($j)) );
					$o_answer->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getStudentId($j)) );
					if ($o_answer->getAllCount()>0)
					{
						continue;
					}
					//添加消息队列
					$o_msg=new Wechat_Wx_User_Reminder();
					$o_msg->setUserId($o_stu->getUserId($j));
					$o_msg->setCreateDate($this->GetDateNow());
					$o_msg->setSendDate('0000-00-00');
					$o_msg->setMsgId($this->getWechatSetup('MSGTMP_09'));
					$o_msg->setOpenId($o_stu->getOpenid($j));
					$o_msg->setActivityId(0);
					$o_msg->setSend(0);
					$o_msg->setFirst($o_survey->getFirst().'
		
通知类型：问卷调查
幼儿姓名：'.$o_stu->getName($j));
					$o_msg->setKeyword1($o_stu->getClassName($j));
					$s_teacher_name=$o_user->getName();
					$o_msg->setKeyword2($s_teacher_name.'老师');
					$o_msg->setKeyword3($this->GetDate());
					$o_msg->setKeyword4($o_survey->getRemark());
					$o_msg->setKeyword5('');
					$o_msg->setRemark('');
					$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_operation/survey_answer.php?id='.$o_survey->getId().'&studentid='.$o_stu->getStudentId($j));
					$o_msg->setKeywordSum(10);
					$o_msg->Save();	
				}			
			}
		}	
		$a_general = array (
			'success' => 1,
			'text' =>'再次发送提醒成功！'
		);
		echo (json_encode ( $a_general ));
	}
	public function ParentSurveyManageAnswered($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120401 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_table = new Survey_Answers();		
		if ($this->getPost('other_key')!='')
		{
			$o_table->PushWhere ( array ('||', 'Name', 'like','%'.$this->getPost('other_key').'%') );
			$o_table->PushWhere ( array ('&&', 'SurveyId', '=',$this->getPost('key')) );
			$o_table->PushWhere ( array ('||', 'CardId', 'like','%'.$this->getPost('other_key').'%') );
			$o_table->PushWhere ( array ('&&', 'SurveyId', '=',$this->getPost('key')) );
		}else{
			$o_table->PushWhere ( array ('&&', 'SurveyId', '=',$this->getPost('key')) );
		}
		$o_table->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_table->setCountLine ( $this->N_PageSize );
		$n_count = $o_table->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_table->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_table->getAllCount ();//总记录数
		$n_count = $o_table->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {	
			$o_student=new Student_Onboard_Info($o_table->getStudentId($i));
			$a_button = array ();
			array_push ( $a_button, array ('查看答卷', "location='parent_survey_manage_progress_sheet.php?id=".$o_table->getId($i)."'" ) );//删除
			array_push ( $a_button, array ('打印', "window.open('parent_survey_manage_progress_pdf.php?id=".$o_table->getId($i)."','_blank')" ) );//删除					
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),				
				$o_table->getName ( $i ),
				$o_table->getClassName ( $i ),
				$o_table->getSex ( $i ),
				$o_table->getCardId ( $i ),
				$o_student->getJh1Name().'-<span style="color:#999999">'.$o_student->getJh1Phone().'</span><br/>'.$o_student->getJh2Name().'-<span style="color:#999999">'.$o_student->getJh2Phone().'</span>',
				$a_button
				));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'幼儿姓名', 'Name', 0, 80);	
		$a_title=$this->setTableTitle($a_title,'班级名称', 'ClassName', 0, 0);
		$a_title=$this->setTableTitle($a_title,'性别', '', 0, 0);		
		$a_title=$this->setTableTitle($a_title,'证件号', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'监护人', 'UserName', 0, 80);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 90,0);
		$this->SendJsonResultForTable($n_allcount,'ParentSurveyManageAnswered', 'yes', $n_page, $a_title, $a_row);
	}
	public function TeacherSurveyManage($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_operator = new Single_User ( $n_uid );
		if (!$o_operator->ValidModule ( 120402 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Survey_Teacher(); 
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
				array_push ( $a_button, array ('查看统计', "location='teacher_survey_manage_summary.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('再次提醒', "teacher_survey_manage_remember(".$o_user->getId($i).")" ) );
				array_push ( $a_button, array ('进度详情', "location='teacher_survey_manage_progress.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('结束问卷', "teacher_survey_manage_end(".$o_user->getId($i).")" ) );
				array_push ( $a_button, array ('复制问卷', "teacher_survey_manage_copy(".$o_user->getId($i).")" ) );
				if ($o_operator->getRoleId()==1)
				{
					//如果是超级管理员，那么可以删除
					array_push ( $a_button, array ('删除', "teacher_survey_manage_delete(".$o_user->getId($i).")" ) );
				}
			}elseif ($o_user->getState($i)==2){		
				$s_state='<span class="label label-danger">已结束</span>';		
				array_push ( $a_button, array ('查看统计', "location='teacher_survey_manage_summary.php?id=".$o_user->getId($i)."'" ) );
				//如果是匿名，那么不能查看问卷
				if ($o_user->getIsAnonymity($i)==0)
				{
					array_push ( $a_button, array ('查看答卷', "location='teacher_survey_manage_answered.php?id=".$o_user->getId($i)."'" ) );//删除
				}
				array_push ( $a_button, array ('复制问卷', "teacher_survey_manage_copy(".$o_user->getId($i).")" ) );
				if ($o_operator->getRoleId()==1)
				{
					//如果是超级管理员，那么可以删除
					array_push ( $a_button, array ('删除', "teacher_survey_manage_delete(".$o_user->getId($i).")" ) );
				}
			}else{
				array_push ( $a_button, array ('修改问卷', "location='teacher_survey_manage_modify.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('编辑题目', "location='teacher_survey_manage_question.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('复制问卷', "teacher_survey_manage_copy(".$o_user->getId($i).")" ) );
				array_push ( $a_button, array ('发布问卷', "location='teacher_survey_manage_release.php?id=".$o_user->getId($i)."'" ) );				
				array_push ( $a_button, array ('删除', "teacher_survey_manage_delete(".$o_user->getId($i).")" ) );
			}
			$o_answer=new Survey_Teacher_Answers();
			$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_user->getId($i)) );
			//查询问卷下的题型
			$n_single=0;
			$n_multiple=0;
			$n_text=0;
			$o_temp=new Survey_Teacher_Questions();
			$o_temp->PushWhere ( array ('&&', 'SurveyId', '=',$o_user->getId($i)) );
			$o_temp->PushWhere ( array ('&&', 'Type', '=',1) );
			$n_single=$o_temp->getAllCount();
			$o_temp=new Survey_Teacher_Questions();
			$o_temp->PushWhere ( array ('&&', 'SurveyId', '=',$o_user->getId($i)) );
			$o_temp->PushWhere ( array ('&&', 'Type', '=',2) );
			$n_multiple=$o_temp->getAllCount();
			$o_temp=new Survey_Teacher_Questions();
			$o_temp->PushWhere ( array ('&&', 'SurveyId', '=',$o_user->getId($i)) );
			$o_temp->PushWhere ( array ('&&', 'Type', '=',3) );
			$n_text=$o_temp->getAllCount();
			$a_release=explode(' ', str_replace('0000-00-00 00:00:00', '', $o_user->getReleaseDate ( $i )));
			$a_end=explode(' ', str_replace('0000-00-00 00:00:00', '', $o_user->getEndDate ( $i )));
			//标题增加是否匿名
			$s_anonymity='';
			if ($o_user->getIsAnonymity($i)==1)
			{
				$s_anonymity='<span class="label label-warning">匿名</span> ';
			}
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				str_replace(' ', '<br/>', $o_user->getCreateDate ( $i )),
				$s_anonymity.$o_user->getTitle ( $i ).'<br/><span style="color:#999999">单选:'.$n_single.'</span> <span style="color:#999999">多选:'.$n_multiple.'</span> <span style="color:#999999">简述:'.$n_text.'</span>',
				'发布:'.$a_release[0].'<br/>结束:'.$a_end[0],
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
		$a_title=$this->setTableTitle($a_title,'发布、结束日期', '', 0, 90);
		$a_title=$this->setTableTitle($a_title,'问卷对象', '', 120, 0);
		$a_title=$this->setTableTitle($a_title,'当前状态', 'State', 0, 60);
		$a_title=$this->setTableTitle($a_title,'已答人数', '', 0, 60);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'TeacherSurveyManage', 'yes', $n_page, $a_title, $a_row);
	}
	public function TeacherSurveyManageAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120402 ))return; //如果没有权限，不返回任何值
		$o_table = new Survey_Teacher ();
		$o_table->setTitle($this->getPost('Title'));
		$o_table->setIsAnonymity($this->getPost('IsAnonymity'));
		$o_table->setCreateDate($this->GetDateNow());
		$o_table->setState(0);
		$o_table->setComment($this->FilterUserInput($this->getPost('Comment')));
		$o_table->setOwnerId($n_uid);
		$o_table->Save ();
		$this->setReturn ( 'parent.form_return("dialog_success(\'新建问卷成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function TeacherSurveyManageModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120402 ))return; //如果没有权限，不返回任何值
		$o_table = new Survey_Teacher ($this->getPost('Id'));
		if ($o_table->getState()=='0')
		{
			$o_table->setTitle($this->getPost('Title'));
			$o_table->setIsAnonymity($this->getPost('IsAnonymity'));
			$o_table->setComment($this->getPost('Comment'));
			$o_table->Save();
		}		
		$this->setReturn ( 'parent.form_return("dialog_success(\'修改问卷成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function TeacherSurveyManageQuestion($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120402 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Survey_Teacher_Questions(); 
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
		$n_number=1;
		for($i = 0; $i < $n_count; $i ++) {
			$a_button = array ();
			array_push ( $a_button, array ('修改', "location='teacher_survey_manage_question_modify.php?questionid=".$o_user->getId($i)."'") );
			array_push ( $a_button, array ('删除', "teacher_survey_manage_question_delete(".$o_user->getId($i).")"));
			$s_type='';
			$s_number='<span class="label label-success">'.$n_number.'</span>';
			$s_question='&nbsp;&nbsp;&nbsp;&nbsp;'.$o_user->getQuestion( $i );
			$s_option='<span class="glyphicon glyphicon-chevron-down"></span>';
			if ($o_user->getType ( $i )==1)
			$s_type='单选';
			if ($o_user->getType ( $i )==2)
			$s_type='多选';
			if ($o_user->getType ( $i )==3)
			{
				$s_type='简述';
				$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
			}
			if ($o_user->getType ( $i )==4)			
			{
				$s_type='子标题';
				$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$s_question='<b style="font-size:14px;">'.$o_user->getQuestion( $i ).'</b>';
				$s_number='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$n_number--;	
			}			
			array_push ($a_row, array (
				$s_number,
				$s_question,
				$s_type,
				$s_option,
				$a_button
			));
			//循环读取选项
			$o_option=new Survey_Teacher_Options();
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
			$n_number++;				
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'题号', 'Number', 70, 0);
		$a_title=$this->setTableTitle($a_title,'问题', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'类型', '', 80, 0);
		$a_title=$this->setTableTitle($a_title,'选项', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 80,0);
		$this->SendJsonResultForTable($n_allcount,'TeacherSurveyManageQuestion', 'yes', $n_page, $a_title, $a_row);
	}
	public function TeacherSurveyManageQuestionAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120402 ))return; //如果没有权限，不返回任何值
		//判断是否大于50题
		$o_table=new Survey_Teacher_Questions();
		$o_table->PushWhere ( array ('&&', 'SurveyId', '=',$this->getPost('Id')) );
		if ($o_table->getAllCount()>=50)
		{
			$this->setReturn ( 'parent.form_return("dialog_message(\'对不起，问卷最大题目数为50，已经达到上限！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
		}
		$o_table = new Survey_Teacher ($this->getPost('Id'));
		if ($o_table->getState()=='0')
		{
			//如果为未发布，才可以更改
			$o_question=new Survey_Teacher_Questions();
			$o_question->setQuestion($this->getPost('Question'));
			$o_question->setType($this->getPost('Type'));
			$o_question->setNumber($this->getPost('Number'));
			$o_question->setSurveyId($this->getPost('Id'));
			$o_question->Save();
			$this->QuestionSortForTeacher($o_question->getId(), $this->getPost('Number'), $this->getPost('Id'));
			//循环添加选项
			$a_number=array('','A','B','C','D','E','F','G','H','I','J');
			for($i=1;$i<=10;$i++)
			{
				if ($this->getPost('Option_'.$i)=='')
				{
					break;
				}
				$o_option=new Survey_Teacher_Options();
				$o_option->setQuestionId($o_question->getId());
				$o_option->setNumber($a_number[$i]);
				$o_option->setOption($this->getPost('Option_'.$i));
				$o_option->Save();				
			}
		}		
		$this->setReturn ( 'parent.form_return("dialog_success(\'添加题目成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function TeacherSurveyManageQuestionModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120402 ))return; //如果没有权限，不返回任何值
		$o_question=new Survey_Teacher_Questions($this->getPost('QuestionId'));
		$o_survey = new Survey_Teacher ($o_question->getSurveyId());
		if ($o_survey->getState()=='0')
		{
			//如果为未发布，才可以更改			
			$o_question->setQuestion($this->getPost('Question'));
			$o_question->setType($this->getPost('Type'));
			$o_question->setNumber($this->getPost('Number'));
			$o_question->Save();
			$this->QuestionSortForTeacher($o_question->getId(), $this->getPost('Number'), $o_question->getSurveyId());
			//循环添加选项
			$o_option=new Survey_Teacher_Options();
			$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId()) );
			$o_option->DeletionWhere();
			$a_number=array('','A','B','C','D','E','F','G','H','I','J');
			for($i=1;$i<=10;$i++)
			{
				if ($this->getPost('Option_'.$i)=='')
				{
					break;
				}
				$o_option=new Survey_Teacher_Options();
				$o_option->setQuestionId($o_question->getId());
				$o_option->setNumber($a_number[$i]);
				$o_option->setOption($this->getPost('Option_'.$i));
				$o_option->Save();				
			}
		}		
		$this->setReturn ( 'parent.form_return("dialog_success(\'修改题目成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function TeacherSurveyManageQuestionDelete($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120401 ))return; //如果没有权限，不返回任何值
		$o_question=new Survey_Teacher_Questions($this->getPost('id'));
		$o_survey = new Survey_Teacher ($o_question->getSurveyId());
		if ($o_survey->getState()=='0')
		{
			$o_question->Deletion();
			$o_option=new Survey_Teacher_Options();
			$o_option->PushWhere ( array ('&&', 'QuestionId', '=', $this->getPost('id') ) );
			$o_option->DeletionWhere();
			$this->QuestionSortForTeacher($this->getPost('id'),100, $o_survey->getId());
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function TeacherSurveyManageCopy($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120402 ))return; //如果没有权限，不返回任何值
		$o_survey = new Survey_Teacher ($this->getPost('id'));
		//创建问卷
		$o_survey_new=new Survey_Teacher();
		$o_survey_new->setCreateDate($this->GetDateNow());
		$o_survey_new->setTitle('（副本）'.$o_survey->getTitle());
		$o_survey_new->setComment($o_survey->getComment());
		$o_survey_new->setIsAnonymity($o_survey->getIsAnonymity());
	    $o_survey_new->setState(0);
	    $o_survey_new->setOwnerId($n_uid);
	    $o_survey_new->Save();
	    //循环创建题
	    $o_question=new Survey_Teacher_Questions();
	    $o_question->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
	    for($i=0;$i<$o_question->getAllCount();$i++)
	    {
	    	$o_temp=new Survey_Teacher_Questions();
	    	$o_temp->setSurveyId($o_survey_new->getId());
    		$o_temp->setQuestion($o_question->getQuestion($i));
    		$o_temp->setType($o_question->getType($i));
    		$o_temp->setNumber($o_question->getNumber($i));
    		$o_temp->Save();
    		//循环选项
    		$o_option=new Survey_Teacher_Options();
    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) );
    		for($j=0;$j<$o_option->getAllCount();$j++)
    		{
    			$o_temp2=new Survey_Teacher_Options();
    			$o_temp2->setQuestionId($o_temp->getId());
    			$o_temp2->setOption($o_option->getOption($j));
    			$o_temp2->setNumber($o_option->getNumber($j));
    			$o_temp2->Save();    			
    		}
	    }
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function TeacherSurveyManageDelete($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120402 ))return; //如果没有权限，不返回任何值
		$o_survey = new Survey_Teacher ($this->getPost('id'));
		if ($o_survey->getState()=='0' || $o_user->getRoleId()==1)
		{
			$o_survey->Deletion();
			//循环删除问题
			$o_question=new Survey_Teacher_Questions();
			$o_question->PushWhere ( array ('&&', 'SurveyId', '=', $this->getPost('id') ) );
			for($i=0;$i<$o_question->getAllCount();$i++)
			{
				$o_option=new Survey_Teacher_Options();
				$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) );
				$o_option->DeletionWhere();
			}
			$o_question->DeletionWhere();
			//删除说有答案
			$o_answer=new Survey_Teacher_Answers();
			$o_answer->PushWhere ( array ('&&', 'SurveyId', '=', $this->getPost('id') ) );
			$o_answer->DeletionWhere();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function TeacherSurveyManageRelease($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120402 ))return;//如果没有权限，不返回任何值
		//检查问卷对象是否被选择
		$a_target=array();
		$s_target_name='';
		$o_class=new Base_Role();
		$o_class->PushOrder ( array ('Name','A') );
		$n_count=$o_class->getAllCount();
		for($i=0;$i<$n_count;$i++)
		{
			if ($this->getPost('Target_'.$o_class->getRoleId($i))=='on')
			{
				array_push($a_target, $o_class->getRoleId($i));
				$s_target_name.=$o_class->getName($i).';';
			}			
		}
		if ($s_target_name=='')
		{
			$this->setReturn ( 'parent.form_return("dialog_message(\'对不起，请选择问卷对象！\')");' );
		}
		//修正文字发送对象
		if($n_count==count($a_target))
		{
			$s_target_name='全体教职工;';
		}
		//保存数据到问卷信息
		$o_survey=new Survey_Teacher($this->getPost('Id'));
		if($o_survey->getState()=='0')
		{
			//只有未发布的问卷才能往下进行
			$o_survey->setReleaseDate($this->GetDateNow());
			$o_survey->setTargetName(substr($s_target_name,0,strlen($s_target_name)-1));
			$o_survey->setTargetList(json_encode($a_target));
			$o_survey->setFirst($this->getPost('First'));
			$o_survey->setRemark($this->getPost('Remark'));
			$o_survey->setState(1);
			$o_survey->Save();
			//根据问卷对象循环发送通知
			$o_system_setup=new Base_Setup(1);
			require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
			for($i=0;$i<count($a_target);$i++)
			{
				//获取用户列表
				$o_stu=new Base_User_Role_Wechat_View();
				$o_stu->PushWhere ( array ('||', 'RoleId', '=',$a_target[$i]) );
				$o_stu->PushWhere ( array ('||', 'SecRoleId1', '=',$a_target[$i]) );
				$o_stu->PushWhere ( array ('||', 'SecRoleId2', '=',$a_target[$i]) );
				$o_stu->PushWhere ( array ('||', 'SecRoleId3', '=',$a_target[$i]) );
				$o_stu->PushWhere ( array ('||', 'SecRoleId4', '=',$a_target[$i]) );
				$o_stu->PushWhere ( array ('||', 'SecRoleId5', '=',$a_target[$i]) );
				for($j=0;$j<$o_stu->getAllCount();$j++)
				{
					//添加消息队列
					$o_msg=new Wechat_Wx_User_Reminder();
					$o_msg->setUserId($o_stu->getUserId($j));
					$o_msg->setCreateDate($this->GetDateNow());
					$o_msg->setSendDate('0000-00-00');
					$o_msg->setMsgId($this->getWechatSetup('MSGTMP_10'));
					$o_msg->setOpenId($o_stu->getOpenid($j));
					$o_msg->setActivityId(0);
					$o_msg->setSend(0);
					$o_msg->setFirst($this->getPost('First').'

姓名：'.$o_stu->getName($j).'
通知时间：'.$this->GetDate().'
通知人：'.$o_user->getName()	);
					$o_msg->setKeyword1('教师问卷');		
					$o_msg->setKeyword2($this->getPost('Remark'));
					$o_msg->setKeyword3('');
					$o_msg->setKeyword4('');
					$o_msg->setKeyword5('');
					$o_msg->setRemark('');
					$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/teacher_operation/survey_answer.php?id='.$this->getPost('Id').'&uid='.$o_stu->getUid($j));
					$o_msg->setKeywordSum(11);
					$o_msg->Save();	
				}			
			}
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'发布问卷成功！\',function(){\\parent.location=\''.$this->getPost('BackUrl').'\'})");' );	
	}
	public function TeacherSurveyManageEnd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120402 ))return; //如果没有权限，不返回任何值
		$o_survey = new Survey_Teacher ($this->getPost('id'));
		if ($o_survey->getState()=='1')
		{
			//计算已答人数
			$o_answer=new Survey_Teacher_Answers();
			$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
			$o_survey->setCompletedSum($o_answer->getAllCount());
			//计算未答人数
			$a_target=json_decode($o_survey->getTargetList());
			$o_table=new Base_User_Role_Wechat_View();
			for($i=0;$i<count($a_target);$i++)
			{
				$o_table->PushWhere ( array ('||', 'RoleId', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('||', 'SecRoleId1', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('||', 'SecRoleId2', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('||', 'SecRoleId3', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('||', 'SecRoleId4', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('||', 'SecRoleId5', '=',$a_target[$i]) );
			}
			$n_count = $o_table->getAllCount ();
			$n_pending=0;
			for($i = 0; $i < $n_count; $i ++) {
				//判断是否完成问卷
				$o_answer=new Survey_Teacher_Answers();
				$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
				$o_answer->PushWhere ( array ('&&', 'UserId', '=',$o_table->getUserId($i)) );
				$o_answer->PushWhere ( array ('&&', 'Uid', '=',$o_table->getUid($i)) );
				if ($o_answer->getAllCount()==0)
				{
					$n_pending++;
				}
			}
			$o_survey->setPendingSum($n_pending);
			$o_survey->setState(2);
			$o_survey->setEndDate($this->GetDateNow());
			$o_survey->Save();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function TeacherSurveyManageSummary($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120402 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Survey_Teacher_Questions(); 		
		$s_id=$this->getPost('key');
		$o_survey=new Survey_Teacher($s_id);
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
		//计算答题总人数
		$o_answer=new Survey_Teacher_Answers();
		$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$s_id) );
		$n_answer_sum=$o_answer->getAllCount();
		$n_number=1;
		for($i = 0; $i < $n_count; $i ++) {
			$a_button = array ();
			$s_type='';
			$s_number='<span class="label label-success">'.$n_number.'</span>';
			$s_question='&nbsp;&nbsp;&nbsp;&nbsp;'.$o_user->getQuestion( $i );
			$s_option='<span class="glyphicon glyphicon-chevron-down"></span>';
			if ($o_user->getType ( $i )==1)
			$s_type='单选';
			if ($o_user->getType ( $i )==2)
			$s_type='多选';
			if ($o_user->getType ( $i )==3)
			{
				$s_type='简述';
				//统计简述的答题人数
				$o_answer=new Survey_Teacher_Answers();
				$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$s_id) );
				$o_answer->PushWhere ( array ('&&', 'Answer'.$o_user->getNumber($i), '<>','') );
				$s_option=$o_answer->getAllCount().' 人';
				array_push ( $a_button, array ('详情', "location='teacher_survey_manage_summary_detail.php?id=".$o_user->getId($i)."'") );
			}
			if ($o_user->getType ( $i )==4)			
			{
				$s_type='子标题';
				$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$s_question='<b style="font-size:14px;">'.$o_user->getQuestion( $i ).'</b>';
				$s_number='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$n_number--;	
			}		
			array_push ($a_row, array (
				$s_number,
				$s_question,
				$s_type,
				$s_option,
				$a_button
			));
			//循环读取选项
			$o_option=new Survey_Teacher_Options();
			$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_user->getId ( $i )) );
			$o_option->PushOrder ( array ('Id','A') );
			for($j=0;$j<$o_option->getAllCount();$j++)
			{
				$a_button = array ();
				$o_answer=new Survey_Teacher_Answers();
				$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$s_id) );
				$o_answer->PushWhere ( array ('&&', 'Answer'.$o_user->getNumber($i), 'like','%"'.$o_option->getId($j).'"%') );
				$n_people=$o_answer->getAllCount();
				$n_rate=round(($n_people/$n_answer_sum)*1000)/10;//结果*1000取整再除以10
				if($n_rate>0 && $o_survey->getIsAnonymity()==0)
				{
					//如果不是匿名，那么显示人群
					array_push ( $a_button, array ('人群', "location='teacher_survey_manage_summary_people.php?id=".$o_option->getId($j)."'") );
				}
				array_push ($a_row, array (
					'',
					'',
					$n_people.'人 ('.$n_rate.'%)',
					$o_option->getNumber($j).'. '.$o_option->getOption($j),
					$a_button
				));
			}
			$n_number++;
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'题号', 'Number', 70, 0);
		$a_title=$this->setTableTitle($a_title,'问题', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'类型', '', 120, 0);
		$a_title=$this->setTableTitle($a_title,'选项', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 80,0);
		$this->SendJsonResultForTable($n_allcount,'TeacherSurveyManageSummary', 'yes', $n_page, $a_title, $a_row);
	}
	public function TeacherSurveyManageGetProgress($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User($n_uid);
		if (!$o_user->ValidModule ( 120402 ))return;//如果没有权限，不返回任何值
		$o_survey = new Survey_Teacher($this->getPost('id'));
		//获得target的班级list
		//如果是已结束问卷，那么直接读取结果
		if($o_survey->getState()==2)
		{
			$n_count=$o_survey->getCompletedSum()+$o_survey->getPendingSum();
			$n_completed=$o_survey->getCompletedSum();
		}else{
			$a_target=json_decode($o_survey->getTargetList());
			$o_table=new Base_User_Role_Wechat_View();
			for($i=0;$i<count($a_target);$i++)
			{
				$o_table->PushWhere ( array ('||', 'RoleId', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('||', 'SecRoleId1', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('||', 'SecRoleId2', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('||', 'SecRoleId3', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('||', 'SecRoleId4', '=',$a_target[$i]) );
				$o_table->PushWhere ( array ('||', 'SecRoleId5', '=',$a_target[$i]) );
			}
			$n_count = $o_table->getAllCount ();
			$n_completed=0;
			for($i = 0; $i < $n_count; $i ++) {
				//判断是否完成问卷
				$o_answer=new Survey_Teacher_Answers();
				$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
				$o_answer->PushWhere ( array ('&&', 'UserId', '=',$o_table->getUserId($i)) );
				$o_answer->PushWhere ( array ('&&', 'Uid', '=',$o_table->getUid($i)) );
				if ($o_answer->getAllCount()>0)
				{
					$n_completed++;
				}
			}
		}		
		$a_result = array (
					'status' =>'<span class="label label-success">完成 '.$n_completed.'</span>&nbsp;&nbsp;<span class="label label-warning">未完 '.($n_count-$n_completed).'</span>&nbsp;&nbsp;<span class="label label-primary">完成率 '.sprintf("%.0f", ($n_completed/$n_count)*100).'%</span>'
				);
		echo(json_encode ($a_result));
	}
	public function TeacherSurveyManageSummaryPeople($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120402 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_option=new Survey_Teacher_Options($this->getPost('key'));
		$o_question=new Survey_Teacher_Questions($o_option->getQuestionId());
		$o_table = new Survey_Teacher_Answers();
		//获得target的班级list
		$o_table->PushWhere ( array ('&&', 'Answer'.$o_question->getNumber(), 'like','%"'.$o_option->getId().'"%') );
		$o_table->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_table->setCountLine ( $this->N_PageSize );
		$n_count = $o_table->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_table->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_table->getAllCount ();//总记录数
		$n_count = $o_table->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_student=new Base_User_Role_Wechat_View($o_table->getUid($i));
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),				
				$o_table->getName ( $i )
				));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'教师姓名', 'Name', 0, 80);	
		$this->SendJsonResultForTable($n_allcount,'TeacherSurveyManageSummaryPeople', 'no', $n_page, $a_title, $a_row);
	}
	public function TeacherSurveyManageProgress($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120402 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_survey = new Survey_Teacher($this->getPost('key'));
		//获得target的班级list
		$a_target=json_decode($o_survey->getTargetList());
		$o_table=new Base_User_Role_Wechat_View();
		for($i=0;$i<count($a_target);$i++)
		{
			$o_table->PushWhere ( array ('||', 'RoleId', '=',$a_target[$i]) );
			if ($this->getPost('other_key')!='')
			{
				$o_table->PushWhere ( array ('&&', 'Name', 'like','%'.$this->getPost('other_key').'%') );
			}
			$o_table->PushWhere ( array ('||', 'SecRoleId1', '=',$a_target[$i]) );
			if ($this->getPost('other_key')!='')
			{
				$o_table->PushWhere ( array ('&&', 'Name', 'like','%'.$this->getPost('other_key').'%') );
			}
			$o_table->PushWhere ( array ('||', 'SecRoleId2', '=',$a_target[$i]) );
			if ($this->getPost('other_key')!='')
			{
				$o_table->PushWhere ( array ('&&', 'Name', 'like','%'.$this->getPost('other_key').'%') );
			}
			$o_table->PushWhere ( array ('||', 'SecRoleId3', '=',$a_target[$i]) );
			if ($this->getPost('other_key')!='')
			{
				$o_table->PushWhere ( array ('&&', 'Name', 'like','%'.$this->getPost('other_key').'%') );
			}
			$o_table->PushWhere ( array ('||', 'SecRoleId4', '=',$a_target[$i]) );
			if ($this->getPost('other_key')!='')
			{
				$o_table->PushWhere ( array ('&&', 'Name', 'like','%'.$this->getPost('other_key').'%') );
			}
			$o_table->PushWhere ( array ('||', 'SecRoleId5', '=',$a_target[$i]) );
			if ($this->getPost('other_key')!='')
			{
				$o_table->PushWhere ( array ('&&', 'Name', 'like','%'.$this->getPost('other_key').'%') );
			}
		}
		$o_table->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_table->setCountLine ( $this->N_PageSize );
		$n_count = $o_table->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_table->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_table->getAllCount ();//总记录数
		$n_count = $o_table->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_sign_name='';
			if ($o_table->getDelFlag ( $i )==1)
			{
				$s_sign_name=' <span class="label label-danger">取消关注</span>';
			}
			$a_button = array ();
			//判断是否完成问卷
			$o_answer=new Survey_Teacher_Answers();
			$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
			$o_answer->PushWhere ( array ('&&', 'UserId', '=',$o_table->getUserId($i)) );
			$o_answer->PushWhere ( array ('&&', 'Uid', '=',$o_table->getUid($i)) );
			if ($o_answer->getAllCount()>0)
			{
				$s_sign_name.=' <span class="label label-success"><span class="glyphicon glyphicon-ok"></span></span>';
				if ($o_survey->getIsAnonymity()==0)
				{
					array_push ( $a_button, array ('查看答卷', "location='teacher_survey_manage_progress_sheet.php?id=".$o_answer->getId(0)."'" ) );//删除
					array_push ( $a_button, array ('打印', "window.open('teacher_survey_manage_progress_pdf.php?id=".$o_answer->getId(0)."','_blank')" ) );//删除
				}				
			}	
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				'<img style="width:32px;height:32px;" src="'.$o_table->getPhoto ( $i ).'">',
				$o_table->getNickname ( $i ).$s_sign_name,
				$o_table->getName ( $i ),
				$a_button
				));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'头像', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'微信昵称', 'Nickname', 0, 0);	
		$a_title=$this->setTableTitle($a_title,'教师姓名', 'Name', 0, 0);	
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 90,0);
		$this->SendJsonResultForTable($n_allcount,'TeacherSurveyManageProgress', 'yes', $n_page, $a_title, $a_row);
	}
	public function TeacherSurveyManageRemember($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120401 ))return;//如果没有权限，不返回任何值
		$o_survey=new Survey_Teacher($this->getPost('id'));
		$a_target=json_decode($o_survey->getTargetList());
		if ($o_survey->getState()=='1')
		{
			//根据问卷对象循环发送通知
			$o_system_setup=new Base_Setup(1);
			require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
			for($i=0;$i<count($a_target);$i++)
			{
				//获取用户列表
				$o_stu=new Base_User_Role_Wechat_View();
				$o_stu->PushWhere ( array ('||', 'RoleId', '=',$a_target[$i]) );
				$o_stu->PushWhere ( array ('||', 'SecRoleId1', '=',$a_target[$i]) );
				$o_stu->PushWhere ( array ('||', 'SecRoleId2', '=',$a_target[$i]) );
				$o_stu->PushWhere ( array ('||', 'SecRoleId3', '=',$a_target[$i]) );
				$o_stu->PushWhere ( array ('||', 'SecRoleId4', '=',$a_target[$i]) );
				$o_stu->PushWhere ( array ('||', 'SecRoleId5', '=',$a_target[$i]) );
				for($j=0;$j<$o_stu->getAllCount();$j++)
				{
					//判断是否已经答题，如果答题那么跳过
					$o_answer=new Survey_Teacher_Answers();
					$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) );
					$o_answer->PushWhere ( array ('&&', 'UserId', '=',$o_stu->getUserId($j)) );
					$o_answer->PushWhere ( array ('&&', 'Uid', '=',$o_stu->getUid($j)) );
					if ($o_answer->getAllCount()>0)
					{
						continue;
					}
					//添加消息队列
					$o_msg=new Wechat_Wx_User_Reminder();
					$o_msg->setUserId($o_stu->getUserId($j));
					$o_msg->setCreateDate($this->GetDateNow());
					$o_msg->setSendDate('0000-00-00');
					$o_msg->setMsgId($this->getWechatSetup('MSGTMP_10'));
					$o_msg->setOpenId($o_stu->getOpenid($j));
					$o_msg->setActivityId(0);
					$o_msg->setSend(0);
					$o_msg->setFirst($o_survey->getFirst().'
		
姓名：'.$o_stu->getName($j).'
通知时间：'.$this->GetDate().'
通知人：'.$o_user->getName()	);
					$o_msg->setKeyword1('教师问卷');		
					$o_msg->setKeyword2($this->getPost('Remark'));
					$o_msg->setKeyword3('');
					$o_msg->setKeyword4('');
					$o_msg->setKeyword5('');
					$o_msg->setRemark('');
					$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/teacher_operation/survey_answer.php?id='.$this->getPost('id').'&uid='.$o_stu->getUid($j));
					$o_msg->setKeywordSum(11);
					$o_msg->Save();	
				}			
			}
		}	
		$a_general = array (
			'success' => 1,
			'text' =>'再次发送提醒成功！'
		);
		echo (json_encode ( $a_general ));
	}
	public function TeacherSurveyManageSummaryDetail($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120402 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_question=new Survey_Teacher_Questions($this->getPost('key'));
		$o_table = new Survey_Teacher_Answers();
		//获得target的班级list
		$o_table->PushWhere ( array ('&&', 'Answer'.$o_question->getNumber(), '<>','') );
		$o_table->PushWhere ( array ('&&', 'SurveyId', '=',$o_question->getSurveyId()) );
		$o_table->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_table->setCountLine ( $this->N_PageSize );
		$n_count = $o_table->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_table->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_table->getAllCount ();//总记录数
		$n_count = $o_table->getCount ();
		$a_row = array ();		
		//分为匿名和不匿名
		$o_survey=new Survey_Teacher($o_table->getSurveyId(0));
		if ($o_survey->getIsAnonymity()==1)
		{
			//匿名
			for($i = 0; $i < $n_count; $i ++) {	
				eval('$s_answer=$o_table->getAnswer'.$o_question->getNumber().'($i);');
				$s_answer=rawurldecode(str_replace('"', '', $s_answer));
				$o_student=new Base_User_Role_Wechat_View($o_table->getUid($i));	
				array_push ($a_row, array (
					($i+1+$this->N_PageSize*($n_page-1)),				
					$s_answer
					));
			}
			//标题行,列名，排序名称，宽度，最小宽度
			$a_title = array ();
			$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 60, 0);
			$a_title=$this->setTableTitle($a_title,'简述', '', 0, 0);
		}else{
			//不匿名
			for($i = 0; $i < $n_count; $i ++) {	
				eval('$s_answer=$o_table->getAnswer'.$o_question->getNumber().'($i);');
				$s_answer=rawurldecode(str_replace('"', '', $s_answer));
				$o_student=new Base_User_Role_Wechat_View($o_table->getUid($i));	
				array_push ($a_row, array (
					($i+1+$this->N_PageSize*($n_page-1)),				
					$o_table->getName ( $i ),
					$s_answer
					));
			}
			//标题行,列名，排序名称，宽度，最小宽度
			$a_title = array ();
			$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 60, 0);
			$a_title=$this->setTableTitle($a_title,'教师姓名', 'Name', 0, 0);	
			$a_title=$this->setTableTitle($a_title,'简述', '', 0, 0);
		}
		$this->SendJsonResultForTable($n_allcount,'TeacherSurveyManageSummaryDetail', 'no', $n_page, $a_title, $a_row);		
	}
	public function AppraiseManage($n_uid)
	{
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_operator = new Single_User ( $n_uid );
		if (!$o_operator->ValidModule ( 120403 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Survey_Appraise();
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Title', 'like','%'.$s_key.'%') );
		}
		$o_user->PushWhere ( array ('&&', 'IsDeleted', '=','0') );
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
				$s_state='<span class="label label-success">已开放</span>';
				array_push ( $a_button, array ('查看原题', "location='appraise_manage_view.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('评价结果', "location='appraise_manage_result.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('评价统计', "location='appraise_manage_total.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('关闭', "appraise_manage_close(".$o_user->getId($i).")" ) );
				if ($o_operator->getRoleId()==1)
				{
					//如果是超级管理员，那么可以删除
					//array_push ( $a_button, array ('删除', "parent_survey_manage_delete(".$o_user->getId($i).")" ) );
				}
			}elseif ($o_user->getState($i)==2){
				$s_state='<span class="label label-danger">已关闭</span>';
				array_push ( $a_button, array ('查看原题', "location='appraise_manage_view.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('评价结果', "location='appraise_manage_result.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('评价统计', "location='appraise_manage_total.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('开放', "appraise_manage_open(".$o_user->getId($i).")" ) );
			}else{
				array_push ( $a_button, array ('修改问卷', "location='appraise_manage_modify.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('编辑题目', "location='appraise_manage_question.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('发布问卷', "appraise_manage_release(".$o_user->getId($i).")" ) );
				array_push ( $a_button, array ('删除', "appraise_manage_delete(".$o_user->getId($i).")" ) );
			}			
			array_push ($a_row, array (
					($i+1+$this->N_PageSize*($n_page-1)),
					$o_user->getCreateDate ( $i ),
					$o_user->getTitle ( $i ),
					$s_state,
					$a_button
			));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'序号', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'建立日期', 'CreateDate', 0, 100);
		$a_title=$this->setTableTitle($a_title,'问卷标题', 'Title', 0, 0);
		$a_title=$this->setTableTitle($a_title,'当前状态', 'State', 0, 60);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'AppraiseManage', 'yes', $n_page, $a_title, $a_row);
	}
	public function AppraiseManageAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120403 ))return; //如果没有权限，不返回任何值
		$o_table=new Survey_Appraise();
		$o_table->setTitle($this->getPost('Title'));
		$o_table->setIsDeleted(0);
		$o_table->setState(0);
		$o_table->setType($this->getPost('Type'));
		$o_table->setCreateDate($this->GetDateNow());
		$o_table->setComment('');
		$o_table->setIsAuto($this->getPost('IsAuto'));
		$a_type=array();
		$o_info=new Survey_Appraise_Info_Item();
		$o_info->PushWhere ( array ('&&', 'Type', '=', $this->getPost('Type')) );
		$o_info->PushOrder ( array ('Number', 'A' ) );
		for($i=0;$i<$o_info->getAllCount();$i++)
		{
			array_push ( $a_type, rawurlencode($o_info->getName($i)));
		}
		$o_table->setInfo ( json_encode ( $a_type) );
		$o_table->Save();
		$this->setReturn ( 'parent.form_return("dialog_success(\'新建问卷成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function AppraiseManageModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120403 ))return; //如果没有权限，不返回任何值
		$o_table=new Survey_Appraise($this->getPost('Id'));
		$o_table->setTitle($this->getPost('Title'));
		$o_table->setType($this->getPost('Type'));
		$o_table->setCreateDate($this->GetDateNow());
		$a_type=array();
		$o_info=new Survey_Appraise_Info_Item();
		$o_info->PushWhere ( array ('&&', 'Type', '=', $this->getPost('Type')) );
		$o_info->PushOrder ( array ('Number', 'A' ) );
		for($i=0;$i<$o_info->getAllCount();$i++)
		{
			array_push ( $a_type, rawurlencode($o_info->getName($i)));
		}
		$o_table->setInfo ( json_encode ( $a_type) );
		$o_table->setIsAuto($this->getPost('IsAuto'));
		$o_table->Save();
		$this->setReturn ( 'parent.form_return("dialog_success(\'新建问卷成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function AppraiseManageDelete($n_uid)
	{
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 120403 )) {
			$o_table=new Survey_Appraise($this->getPost('id'));
			$o_table->setIsDeleted(1);
			$o_table->Save();
		}
		$a_general = array (
				'success' => 1,
				'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function AppraiseManageClose($n_uid)
	{
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 120403 )) {
			$o_table=new Survey_Appraise($this->getPost('id'));
			$o_table->setState(2);
			$o_table->Save();
		}
		$a_general = array (
				'success' => 1,
				'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function AppraiseManageOpen($n_uid)
	{
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 120403 )) {
			$o_table=new Survey_Appraise($this->getPost('id'));
			$o_table->setState(1);
			$o_table->Save();
		}
		$a_general = array (
				'success' => 1,
				'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function AppraiseManageRelease($n_uid)
	{
		if (! ($n_uid > 0)) {
			//直接退出系统
			$this->setReturn('parent.goLoginPage()');
		}
		
		$o_user = new Single_User ( $n_uid );
		if ($o_user->ValidModule ( 120403 )) {
			$o_table=new Survey_Appraise($this->getPost('id'));
			$o_table->setReleaseDate($this->GetDate());
			$o_table->setState(1);
			$o_table->Save();
		}
		$a_general = array (
				'success' => 1,
				'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function AppraiseManageQuestion($n_uid)
	{
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120403 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Survey_Appraise_Questions();
		$s_id=$this->getPost('key');
		$o_user->PushWhere ( array ('&&', 'AppraiseId', '=',$s_id) );
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
		$n_number=1;
		for($i = 0; $i < $n_count; $i ++) {
			$a_button = array ();
			array_push ( $a_button, array ('修改', "location='appraise_manage_question_modify.php?questionid=".$o_user->getId($i)."'") );
			array_push ( $a_button, array ('删除', "appraise_manage_question_delete(".$o_user->getId($i).")"));
			$s_type='';
			$s_number='<span class="label label-success">'.$n_number.'</span>';
			$s_question='&nbsp;&nbsp;'.$o_user->getQuestion( $i );
			$s_option='<span class="glyphicon glyphicon-chevron-down"></span>';
			if ($o_user->getType ( $i )==1)
			$s_type='单选';
			if ($o_user->getType ( $i )==2)
			$s_type='多选';
			if ($o_user->getType ( $i )==3)
			{
				$s_type='简述';
				$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
			}
			if ($o_user->getType ( $i )==4)
			{
				$s_type='子标题';
				$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$s_question='<b style="font-size:14px;">'.$o_user->getQuestion( $i ).'</b>';
				$s_number='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$n_number--;
			}
			$s_ismust='';
			if ($o_user->getIsMust ( $i )==1)
			{
				$s_ismust='<span style="color:red">*</span>';
			}
			array_push ($a_row, array (
					$s_number,
					$s_ismust.$s_question,
					$s_type,
					$s_option,
					$a_button
			));
			//循环读取选项
			$o_option=new Survey_Appraise_Options();
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
			$n_number++;
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'题号', 'Number', 70, 0);
		$a_title=$this->setTableTitle($a_title,'问题', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'类型', '', 80, 0);
		$a_title=$this->setTableTitle($a_title,'选项', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 80,0);
		$this->SendJsonResultForTable($n_allcount,'TeacherSurveyManageQuestion', 'yes', $n_page, $a_title, $a_row);
	}
	public function AppraiseManageQuestionAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120403 ))return; //如果没有权限，不返回任何值
		//判断是否大于50题
		$o_table=new Survey_Appraise_Questions();
		$o_table->PushWhere ( array ('&&', 'AppraiseId', '=',$this->getPost('Id')) );
		if ($o_table->getAllCount()>=50)
		{
			$this->setReturn ( 'parent.form_return("dialog_message(\'对不起，问卷最大题目数为50，已经达到上限！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
		}
		$o_table = new Survey_Appraise($this->getPost('Id'));
		if ($o_table->getState()=='0')
		{
			//如果为未发布，才可以更改
			$o_question=new Survey_Appraise_Questions();
			$o_question->setQuestion($this->getPost('Question'));
			$o_question->setType($this->getPost('Type'));
			$o_question->setIsMust($this->getPost('IsMust'));
			$o_question->setNumber($this->getPost('Number'));
			$o_question->setAppraiseId($this->getPost('Id'));
			$o_question->Save();
			$this->QuestionSortForAppraise($o_question->getId(), $this->getPost('Number'), $this->getPost('Id'));
			//循环添加选项
			$a_number=array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T');
			for($i=1;$i<=10;$i++)
			{
				if ($this->getPost('Option_'.$i)=='')
				{
					break;
				}
				$o_option=new Survey_Appraise_Options();
				$o_option->setQuestionId($o_question->getId());
				$o_option->setNumber($a_number[$i]);
				$o_option->setOption($this->getPost('Option_'.$i));
				$o_option->Save();
			}
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'添加题目成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	private function QuestionSortForAppraise($n_questionid, $n_number, $n_surveyid) {
		$o_all = new Survey_Appraise_Questions ();
		$o_all->PushWhere ( array ('&&', 'Id', '<>', $n_questionid ) );
		$o_all->PushWhere ( array ('&&', 'AppraiseId', '=', $n_surveyid ) );
		$o_all->PushOrder ( array ('Number', 'A' ) );
		$n_count = $o_all->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$o_focus = new Survey_Appraise_Questions ( $o_all->getId ( $i ) );
			if (($i + 1) >= $n_number) {
				$o_focus->setNumber ( $i + 2 );
			} else {
				$o_focus->setNumber ( $i + 1 );
			}
			$o_focus->Save ();
		}
	}
	public function AppraiseManageQuestionModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120403 ))return; //如果没有权限，不返回任何值
		$o_question=new Survey_Appraise_Questions($this->getPost('QuestionId'));
		$o_survey = new Survey_Appraise ($o_question->getAppraiseId());
		if ($o_survey->getState()=='0')
		{
			//如果为未发布，才可以更改
			$o_question->setQuestion($this->getPost('Question'));
			$o_question->setType($this->getPost('Type'));
			$o_question->setNumber($this->getPost('Number'));
			$o_question->setIsMust($this->getPost('IsMust'));
			$o_question->Save();
			$this->QuestionSortForAppraise($o_question->getId(), $this->getPost('Number'), $o_question->getAppraiseId());
			//循环添加选项
			$o_option=new Survey_Appraise_Options();
			$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId()) );
			$o_option->DeletionWhere();
			$a_number=array('','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T');
			for($i=1;$i<=10;$i++)
			{
				if ($this->getPost('Option_'.$i)=='')
				{
					break;
				}
				$o_option=new Survey_Appraise_Options();
				$o_option->setQuestionId($o_question->getId());
				$o_option->setNumber($a_number[$i]);
				$o_option->setOption($this->getPost('Option_'.$i));
				$o_option->Save();
			}
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'修改题目成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function AppraiseManageQuestionDelete($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120403 ))return; //如果没有权限，不返回任何值
		$o_question=new Survey_Appraise_Questions($this->getPost('id'));
		$o_survey = new Survey_Appraise ($o_question->getAppraiseId());
		if ($o_survey->getState()=='0')
		{
			$o_question->Deletion();
			$o_option=new Survey_Appraise_Options();
			$o_option->PushWhere ( array ('&&', 'QuestionId', '=', $this->getPost('id') ) );
			$o_option->DeletionWhere();
			$this->QuestionSortForAppraise($this->getPost('id'),100, $o_survey->getId());
		}
		$a_general = array (
				'success' => 1,
				'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function AppraiseManageView($n_uid)
	{
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120403 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Survey_Appraise_Questions();
		$s_id=$this->getPost('key');
		$o_survey=new Survey_Appraise($s_id);
		$o_user->PushWhere ( array ('&&', 'AppraiseId', '=',$s_id) );
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
		$n_number=1;
		for($i = 0; $i < $n_count; $i ++) {
			$a_button = array ();
			$s_type='';
			$s_number='<span class="label label-success">'.$n_number.'</span>';
			$s_question='&nbsp;&nbsp;'.$o_user->getQuestion( $i );
			$s_option='<span class="glyphicon glyphicon-chevron-down"></span>';
			if ($o_user->getType ( $i )==1)
			$s_type='单选';
			if ($o_user->getType ( $i )==2)
			$s_type='多选';
			if ($o_user->getType ( $i )==3)
			{
				$s_type='简述';						
			}
			if ($o_user->getType ( $i )==4)
			{
				$s_type='子标题';
				$s_option='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$s_question='<b style="font-size:14px;">'.$o_user->getQuestion( $i ).'</b>';
				$s_number='<span class="glyphicon glyphicon glyphicon-minus"></span>';
				$n_number--;
			}
			$s_ismust='';
			if ($o_user->getIsMust ( $i )==1)
			{
				$s_ismust='<span style="color:red">*</span>';
			}
			array_push ($a_row, array (
					$s_number,
					$s_ismust.$s_question,
					$s_type,
					$s_option,
			));
			//循环读取选项
			$o_option=new Survey_Appraise_Options();
			$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_user->getId ( $i )) );
			$o_option->PushOrder ( array ('Id','A') );
			for($j=0;$j<$o_option->getAllCount();$j++)
			{
				$a_button = array ();						
				array_push ($a_row, array (
						'',
						'',
						'',
						$o_option->getNumber($j).'. '.$o_option->getOption($j),
				));
			}
			$n_number++;
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'题号', '', 70, 0);
		$a_title=$this->setTableTitle($a_title,'问题', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'类型', '', 120, 0);
		$a_title=$this->setTableTitle($a_title,'选项', '', 0, 0);
		$this->SendJsonResultForTable($n_allcount,'AppraiseManageView', 'no', $n_page, $a_title, $a_row);
	}
	public function AppraiseManageResult($n_uid)
	{
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120403 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_table = new Survey_Appraise_Answers_View();
		if ($this->getPost('other_key')!='')
		{
			$o_table->PushWhere ( array ('||', 'ClassName', 'like','%'.$this->getPost('other_key').'%') );
			$o_table->PushWhere ( array ('&&', 'AppraiseId', '=',$this->getPost('key')) );
		}else{
			$o_table->PushWhere ( array ('&&', 'AppraiseId', '=',$this->getPost('key')) );
		}
		$o_table->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_table->setCountLine ( $this->N_PageSize );
		$n_count = $o_table->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_table->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_table->getAllCount ();//总记录数
		$n_count = $o_table->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {
			$a_button = array ();
			array_push ( $a_button, array ('查看评价', "location='appraise_manage_result_view.php?id=".$o_table->getId($i)."'" ) );//删除
			array_push ($a_row, array (
					($i+1+$this->N_PageSize*($n_page-1)),
					$o_table->getDate ( $i ),
					$o_table->getClassName ( $i ),
					$o_table->getOwnerName ( $i ),
					$a_button
			));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'评价日期', '', 0, 100);
		$a_title=$this->setTableTitle($a_title,'班级名称', 'ClassName', 0, 0);
		$a_title=$this->setTableTitle($a_title,'评价人', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 90,0);
		$this->SendJsonResultForTable($n_allcount,'AppraiseManageResult', 'yes', $n_page, $a_title, $a_row);
	}
	public function AppraiseManageTotal($n_uid)
	{
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120403 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_table = new Survey_Appraise_Answers_View();
		$o_table->PushWhere ( array ('&&', 'AppraiseId', '=',$this->getPost('key')) );
		$o_table->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_table->setCountLine ( $this->N_PageSize );
		$n_count = $o_table->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_table->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_table->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_table->getAllCount ();//总记录数
		$n_count = $o_table->getCount ();
		$a_row = array ();
		$n_class_id='';
		for($i = 0; $i < $n_count; $i ++) {
			if ($n_class_id==$o_table->getClassId ( $i ))
			{
				continue;
			}else{
				$n_class_id=$o_table->getClassId ( $i );
			}
			$a_button = array ();
			array_push ( $a_button, array ('自评PDF', "location='appraise_manage_result_myself_pdf.php?appraise_id=".$o_table->getAppraiseId($i)."&class_id=".$o_table->getClassId($i)."'" ) );//删除
			array_push ( $a_button, array ('互评PDF', "location='appraise_manage_result_pdf.php?appraise_id=".$o_table->getAppraiseId($i)."&class_id=".$o_table->getClassId($i)."'" ) );//删除
			array_push ($a_row, array (
					($i+1+$this->N_PageSize*($n_page-1)),
					$o_table->getClassName ( $i ),
					$a_button
			));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 80, 0);
		$a_title=$this->setTableTitle($a_title,'班级名称', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 120,0);
		$this->SendJsonResultForTable($n_allcount,'AppraiseManageTotal', 'yes', $n_page, $a_title, $a_row);
	}
}
?>