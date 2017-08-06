<?php
//error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 50;
	public function WeiTeachTable($n_uid)
	{	
		$this->N_PageSize= 50;
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120501 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new Teaching_Wei_Teach_View(); 		
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Title', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('||', 'OwnerName', 'like','%'.$s_key.'%') );
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
				array_push ( $a_button, array ('预览', "wei_teach_review(".$o_user->getId($i).")" ) );
			}else{
				array_push ( $a_button, array ('预览', "wei_teach_review(".$o_user->getId($i).")" ) );
				array_push ( $a_button, array ('修改', "location='wei_teach_modify.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('发布', "location='wei_teach_release.php?id=".$o_user->getId($i)."'" ) );				
				array_push ( $a_button, array ('删除', "wei_teach_delete(".$o_user->getId($i).")" ) );
			}			
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				'<img style="width:32px;height:32px;" src="../../'.$o_user->getIcon ( $i ).'?'.time().'">',
				str_replace(' ', '<br/>', $o_user->getCreateDate ( $i )),				
				$o_user->getTitle ( $i ).'<br/><span style="color:#999999">观看次数: '.$o_user->getVisitorNum ( $i ).'</span>',
				$o_user->getOwnerName ( $i ),
				str_replace(' ', '<br/>', str_replace('0000-00-00 00:00:00','',$o_user->getReleaseDate ( $i ))),	
				$o_user->getTargetName ( $i ),
				$s_state,
				$a_button
				));	
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,'序号', '', 0, 40);
		$a_title=$this->setTableTitle($a_title,'缩略图', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,'建立日期', 'CreateDate', 0, 80);
		$a_title=$this->setTableTitle($a_title,'微教学标题', 'Title', 0, 0);
		$a_title=$this->setTableTitle($a_title,'创建人', 'OwnerName', 0, 60);
		$a_title=$this->setTableTitle($a_title,'发布日期', '', 0, 90);
		$a_title=$this->setTableTitle($a_title,'发布对象', '', 150, 0);
		$a_title=$this->setTableTitle($a_title,'当前状态', 'State', 0, 60);		
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'WeiTeachTable', 'yes', $n_page, $a_title, $a_row);
	}
	public function WeiTeachAdd($n_uid)
	{
		sleep(1);
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120501 ))return;//如果没有权限，不返回任何值
		$o_table=new Teaching_Wei_Teach();
		if ($_FILES ['Vcl_File'] ['size'] > 0) {
			if ($_FILES ['Vcl_File'] ['size']>(1024*1024))
			{
				$this->setReturn ( 'parent.form_return("dialog_error(\'缩略图文件大小不能超过1MB！\')");' );
			}
			mkdir ( RELATIVITY_PATH . 'userdata/teaching', 0777 );
			mkdir ( RELATIVITY_PATH . 'userdata/teaching/wei_teach', 0777 );
			$allowpictype = array ('jpg', 'jpeg', 'gif', 'png' );
			$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
			if (! in_array ( $fileext, $allowpictype )) {
				$this->setReturn ( 'parent.form_return("dialog_error(\''.Text::Key('PhotoUploadError').'\')");' );
			}
			//保存其他数据
			$o_table->setOwnerId($n_uid);
			$o_table->setCreateDate($this->GetDateNow());
			$o_table->setState(0);
			$o_table->setTitle($this->getPost('Title'));
			$o_table->setComment($this->getPost('Comment'));
			$o_table->setVideo($this->getVideoUrl($this->getPost('Video')));
			$o_table->Save();
			//保存Icon
			$s_filename=$o_table->getId().'.'.$fileext;
			$o_table->setIcon ( 'userdata/teaching/wei_teach/' . $s_filename );
			$o_table->Save();
			copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'userdata/teaching/wei_teach/' . $s_filename );
			
		}else{
			$this->setReturn ( 'parent.form_return("dialog_error(\'请选择“封面”文件！\')");' );
		}
		$this->setReturn ( 'parent.form_return("dialog_success(\'新建微教学成功！\',function(){\\parent.location=\''.$this->getPost('BackUrl').'\'})");' );	
	}
	public function getVideoUrl($s_html)
	{
		$s_html=str_replace('\'', '"', $s_html);
		$a_temp=explode('src="',$s_html);
		$a_temp=explode('"', $a_temp[1]);
		return $a_temp[0];
	}
	public function WeiTeachModify($n_uid)
	{
		sleep(1);
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120501 ))return;//如果没有权限，不返回任何值
		$o_table=new Teaching_Wei_Teach($this->getPost('Id'));
		if ($_FILES ['Vcl_File'] ['size'] > 0) {
			if ($_FILES ['Vcl_File'] ['size']>(1024*1024))
			{
				$this->setReturn ( 'parent.form_return("dialog_error(\'缩略图文件大小不能超过1MB！\')");' );
			}
			mkdir ( RELATIVITY_PATH . 'userdata/teaching', 0777 );
			mkdir ( RELATIVITY_PATH . 'userdata/teaching/wei_teach', 0777 );
			$allowpictype = array ('jpg', 'jpeg', 'gif', 'png' );
			$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
			if (! in_array ( $fileext, $allowpictype )) {
				$this->setReturn ( 'parent.form_return("dialog_error(\''.Text::Key('PhotoUploadError').'\')");' );
			}
			//保存Icon
			$s_filename=$o_table->getId().'.'.$fileext;
			copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'userdata/teaching/wei_teach/' . $s_filename );
		}
		//保存其他数据
		$o_table->setTitle($this->getPost('Title'));
		$o_table->setComment($this->getPost('Comment'));
		$o_table->setVideo($this->getVideoUrl($this->getPost('Video')));
		$o_table->Save();		
		$this->setReturn ( 'parent.form_return("dialog_success(\'修改微教学成功！\',function(){\\parent.location=\''.$this->getPost('BackUrl').'\'})");' );	
	}	
	public function WeiTeachDelete($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 120501 ))return; //如果没有权限，不返回任何值
		$o_table = new Teaching_Wei_Teach ($this->getPost('id'));
		if ($o_table->getState()=='0')
		{
			unlink(RELATIVITY_PATH.$o_table->getIcon());
			$o_table->Deletion();
		}
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function WeiTeachRelease($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120501 ))return;//如果没有权限，不返回任何值
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
			$this->setReturn ( 'parent.form_return("dialog_message(\'对不起，请选择可观看对象！\')");' );
		}
		//修正文字发送对象
		if($n_count==count($a_target))
		{
			$s_target_name='所有在园幼儿;';
		}
		//保存数据到问卷信息
		$o_survey=new Teaching_Wei_Teach($this->getPost('Id'));
		if($o_survey->getState()=='0')
		{
			//只有未发布的问卷才能往下进行
			$o_survey->setReleaseDate($this->GetDateNow());
			$o_survey->setTargetName(substr($s_target_name,0,strlen($s_target_name)-1));
			$o_survey->setTarget(json_encode($a_target));
			$o_survey->setState(1);
			$o_survey->Save();			
		}	
		$this->setReturn ( 'parent.form_return("dialog_success(\'发布微教学成功！\',function(){\\parent.location=\''.$this->getPost('BackUrl').'\'})");' );	
	}
}

?>