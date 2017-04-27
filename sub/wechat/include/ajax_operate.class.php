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
	public function Signin($n_uid)
	{
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请稍后再试！\');' );
		}
		sleep(2);
		$o_setup=new Admission_Setup(1);
		$o_date = new DateTime('Asia/Chongqing');
		$s_date=$o_date->format('Y') . '-' . $o_date->format('m') . '-' . $o_date->format('d');
		if (strtotime($s_date)<strtotime($o_setup->getSigninStart()))
		{
			$this->ReturnMsg('报名开始时间为：'.$o_setup->getSigninStart().' ，请在有效日期内进行报名，谢谢合作。','Name');
		}
		$o_stu=new Base_Student_Info();
		$this->CheckId($n_uid);//验证ID是否有重复
		if ($this->getPost ( 'Name' )=='')$this->ReturnMsg('基本信息的 [幼儿姓名] 不能为空！','Name');
		$o_stu->setName($this->getPost ( 'Name' ));
	    $o_stu->setSex($this->getPost ( 'Sex' ));
	    $o_stu->setIdType($this->getPost ( 'IdType' ));
		//验证幼儿ID是否合法
		if($this->getPost ( 'IdType' )=='居民身份证')
		{
			if ($this->validation_filter_id_card($this->getPost ( 'ID' ))==false)$this->ReturnMsg('基本信息的 [幼儿证件号 ] 输入错误！','ID');//验证幼儿ID是否合法
		}
	    $o_stu->setId($this->getPost ( 'ID' ));
	    if ($this->getPost ( 'Birthday' )=='')$this->ReturnMsg('基本信息的 [出生日期] 不能为空！','Birthday');
	    $o_stu->setBirthday($this->getPost ( 'Birthday' ));
	    $o_stu=$this->setStuInfo($o_stu);
	    $o_stu->setSchoolId($o_setup->getDeptId());
	    $o_stu->setSigninDraft($this->getPost ( 'Draft' ));
	    $o_stu->Save();
	   // sleep(2);
		$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'register.php?id='.$o_stu->getId().'"' );
	}
}

?>