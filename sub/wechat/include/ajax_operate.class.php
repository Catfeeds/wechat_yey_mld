<?php
error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once 'db_table.class.php';
class Operate extends Bn_Basic {	
	public function getUserUploadPhoto()
	{
		$o_round=new WX_User_Activity_Join($this->getPost('id'));
		$o_photo=new WX_User_Activity_Join_Uploadphoto();
		$o_photo->PushWhere(array("&&", "UserId", "=", $o_round->getUserId()));
		$o_photo->PushOrder ( array ('Id', 'D') );
		$o_photo->getAllCount();
		if ($o_photo->getAllCount()>0)
		{
			$a_result = array ('photo'=>'../../'.$o_photo->getPath(0));
		}else{
			$a_result = array ('photo'=>'');
		}
		echo(json_encode ($a_result));
	}
	public function CheckId($n_uid)
	{
		$s_checkid=$this->getPost ( 'CheckId' );
		if($this->getPost ( 'CheckId' )=='')
		{
			$s_checkid='8888';
		}
		$s_id=$this->getPost ( 'ID' );
		if($this->getPost ( 'ID' )=='')
		{
			$s_id='8888';
		}
		$o_stu=new Student_Info();
		$o_stu->PushWhere ( array ('&&', 'Id', '=', $s_checkid) );
		//$o_stu->PushWhere ( array ('&&', 'IsLieshi', '<>','') );
		$o_stu->PushWhere ( array ('||', 'Id', '=', $s_id) );
		//$o_stu->PushWhere ( array ('&&', 'IsLieshi', '<>','') );
		if ($o_stu->getAllCount()>0)
		{
			$this->setReturn ( 'parent.Dialog_Message("对不起！幼儿基本信息的 [证件号码] 已经被注册，请更换！",function(){parent.document.getElementById("Vcl_ID").focus();});' );
		}
	}
}

?>