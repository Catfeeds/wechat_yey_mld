<?php
//error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 50;
	Public function AccountTable($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 100601 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_activity = new WX_Activity();
		$s_key=$this->getPost('key');
		//开始判断用户权限，只显示已有的会议
		if ($s_key!='')
		{
			$o_activity->PushWhere ( array ('||', 'Title', 'like','%'.$s_key.'%') );
			$o_activity->PushWhere ( array ('&&', 'Type', '=',3) );
			$o_activity->PushWhere ( array ('&&', 'LibraryId', '=',0) );
		}else{
			$o_activity->PushWhere ( array ('&&', 'Type', '=',3) );
			$o_activity->PushWhere ( array ('&&', 'LibraryId', '=',0) );
		}		
		$o_activity->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_activity->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_activity->setCountLine ( $this->N_PageSize );
		$n_count = $o_activity->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_activity->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_activity->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_activity->getAllCount ();//总记录数
		$n_count = $o_activity->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {
			$a_button = array ();
			array_push ( $a_button, array ('菜单', "location='meeting_audit.php?id=".$o_activity->getId($i)."'" ) );//删除
			array_push ( $a_button, array ('关键字', "location='meeting_keyagent.php?id=".$o_activity->getId($i)."'" ) );//删除
			array_push ( $a_button, array ('二维码', "window.open('output_all.php?id=".$o_activity->getId($i)."','_blank')" ) );//删除
			array_push ( $a_button, array ('修改', "window.open('output_all.php?id=".$o_activity->getId($i)."','_blank')" ) );//删除
			array_push ( $a_button, array ('删除', "window.open('output_all.php?id=".$o_activity->getId($i)."','_blank')" ) );//删除
			$o_group=new WX_Group($o_activity->getGroupId ( $i ));//获取标签
			//获取粉丝数
			$o_fans=new WX_User_Info();
			$o_fans->PushWhere ( array ('&&', 'DelFlag', '=',0) );
			$o_fans->PushWhere ( array ('&&', 'GroupId', '=',$o_activity->getGroupId ( $i )) );
			//获取关键字数
			$o_key=new WX_Keyword();
			$o_key->PushWhere ( array ('||', 'GroupId', 'like','%"'.$o_activity->getGroupId ( $i ).'"%') );
			//获取二维码数
			$o_qr=new WX_Activity();
			$o_qr->PushWhere ( array ('&&', 'Type', '=',3) );
			$o_qr->PushWhere ( array ('&&', 'LibraryId', '<>',0) );
			$o_qr->PushWhere ( array ('&&', 'SceneId', '=',$o_activity->getId ( $i )) );
			$n_sum=0;
			for($j=0;$j<$o_qr->getAllCount();$j++)
			{
				$n_sum=$n_sum+$o_qr->getVisited($j);
			}
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				$o_activity->getTitle ( $i ),
				'<span class="label label-warning">'.$o_group->getGroupName().'</span>',
				$o_fans->getAllCount(),
				$o_key->getAllCount(),
				$o_qr->getAllCount(),
				'<span class="label label-info">'.$n_sum.'</span>',
				$a_button
				));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'账号名称', 'Title', 0, 0);
		$a_title=$this->setTableTitle($a_title,'服务号标签', 'Location', 0, 0);
		$a_title=$this->setTableTitle($a_title,'粉丝数', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'关键字数', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'二维码数', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'访问量', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0, 100);
		$this->SendJsonResultForTable($n_allcount,'MeetingList', 'yes', $n_page, $a_title, $a_row);
	}
}
?>