<?php
error_reporting ( 0 );
define('KEY', 'www.bjsql.com'); //同步信息所使用的秘钥
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 50;
	public function YeInfo($n_uid)
	{	
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120201 ))return;//如果没有权限，不返回任何值
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
			if ($o_user->getState($i)==2)
			{
				$s_state_flg=' <span class="label label-warning">待审</span>';
			}
			$a_button = array ();
			array_push ( $a_button, array ('查看', "window.open('print.php?id=".$o_user->getStudentId($i)."','_blank')" ) );//查看
			array_push ( $a_button, array ('下载PDF', "window.open('download_pdf_single.php?id=".$o_user->getStudentId($i)."','_blank')" ) );//查看
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				$o_user->getName ( $i ).$s_state_flg,
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
		$a_title=$this->setTableTitle($a_title,'班级名称', 'ClassId', 0, 90);
		$a_title=$this->setTableTitle($a_title,'性别', 'Sex', 0, 40);
		$a_title=$this->setTableTitle($a_title,'出生日期', 'Birthday', 0, 80);
		$a_title=$this->setTableTitle($a_title,'证件号码', '', 0, 90);
		$a_title=$this->setTableTitle($a_title,'第一监护人', '', 0, 80);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0,75);
		$this->SendJsonResultForTable($n_allcount,'YeInfo', 'yes', $n_page, $a_title, $a_row);
	}
}

?>