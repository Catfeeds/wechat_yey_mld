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
				array_push ( $a_button, array ('预览', "location='parent_survey_manage_summary.php?id=".$o_user->getId($i)."'" ) );
			}else{
				array_push ( $a_button, array ('预览', "location='parent_survey_manage_modify.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('修改', "location='parent_survey_manage_modify.php?id=".$o_user->getId($i)."'" ) );
				array_push ( $a_button, array ('发布', "location='parent_survey_manage_release.php?id=".$o_user->getId($i)."'" ) );				
				//array_push ( $a_button, array ('删除', "parent_survey_manage_delete(".$o_user->getId($i).")" ) );
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
		$a_title=$this->setTableTitle($a_title,'发布对象', '', 120, 0);
		$a_title=$this->setTableTitle($a_title,'当前状态', 'State', 0, 60);		
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,70);
		$this->SendJsonResultForTable($n_allcount,'WeiTeachTable', 'yes', $n_page, $a_title, $a_row);
	}
}

?>