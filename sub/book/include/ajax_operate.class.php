<?php
//error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/book/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 50;	
	public function WechatBookComment($n_uid)//微信端事件
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		$o_book=new Book_Info_Stu($this->getPost ( 'BookId' ));//获取总的workflow规则
		//验证Id是否合法
		if ($o_book->getTitle()=='')
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'操作错误，请与管理员联系，001！\');' );
		}
		//先检查该用户是否已经评论过了
		$o_comment=new Book_Info_Stu_Comment();
		$o_comment->PushWhere ( array ('&&', 'BookId', '=',$o_book->getId()) ); 
		$o_comment->PushWhere ( array ('&&', 'TeacherId', '=',$n_uid) );
		if ($o_comment->getAllCount()>0)
		{
			$o_comment=new Book_Info_Stu_Comment($o_comment->getId(0));
		}else{
			$o_comment=new Book_Info_Stu_Comment();
			$o_comment->setBookId($o_book->getId());
			$o_comment->setTeacherId($n_uid);
		}
		$o_comment->setComment($this->getPost ( 'Comment' ));
		$o_comment->setDate($this->GetDateNow());
		$o_comment->Save();
		$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Success(\'评论提交成功！\',function(){parent.location.reload()});' );
	}
}
?>