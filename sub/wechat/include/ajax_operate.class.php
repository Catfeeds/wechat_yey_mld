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
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message("对不起！幼儿基本信息的 [证件号码] 已经被注册，请更换！");' );
		}
	}
	public function Signup($n_uid)
	{
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		sleep(0);
		$o_setup=new Admission_Setup(1); 
		$o_date = new DateTime('Asia/Chongqing');
		$s_date=$o_date->format('Y') . '-' . $o_date->format('m') . '-' . $o_date->format('d'). ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' );
		if (strtotime($s_date)<strtotime($o_setup->getSignupStart()))
		{
			$this->ReturnMsg('报名开始时间为：'.$o_setup->getSignupStart().' ，请在有效日期内进行报名，谢谢合作。','Name');
		}
		if (strtotime($s_date)>strtotime($o_setup->getSignupEnd()))
		{
			$this->ReturnMsg('对不起，报名截止时间为：'.$o_setup->getSignupStart().' ，谢谢合作。','Name');
		}
		$o_stu=new Student_Info();
		$this->CheckId($n_uid);//验证ID是否有重复
		if ($this->getPost ( 'Name' )=='')$this->ReturnMsg('基本信息的 [幼儿姓名] 不能为空！','Name');
		$o_stu->setName($this->getPost ( 'Name' ));
		$o_stu->setSignupDate($this->GetDate());
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
	    //查看当前报名幼儿信息的数据库，有没有数据，如果没有数据，需要制定编号
	    $o_temp=new Student_Info();
	    if ($o_temp->getAllCount()==0)
	    {
	    	$o_stu->setStudentId($o_setup->getSignupStartNumber());
	    }
	    $o_stu->Save();
	    //关联微信用户
	    $o_info_wechat=new Student_Info_Wechat();
	    $o_info_wechat->setStudentId($o_stu->getStudentId());
	    $o_info_wechat->setUserId($n_uid);
	    $o_info_wechat->Save();
	    //发送信息提交成功提醒
	    require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
	    $o_sysinfo=new Base_Setup(1);
		$o_token=new accessToken();
		$curlUtil = new curlUtil();
	    $o_parent=new WX_User_Info($n_uid);
		$s_url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$o_token->access_token;
		$data = array(
	    	'touser' => $o_parent->getOpenId(), // openid是发送消息的基础
			'template_id' =>$this->getWechatSetup('MSGTMP_01'), // 模板id
			'url' => $o_sysinfo->getHomeUrl().'sub/wechat/parent_signup/my_signup.php', // 点击跳转地址
			'topcolor' => '#FF0000', // 顶部颜色
			'data' => array(
				'first' => array('value' => '尊敬的家长您好，您所报名的如下信息：
'),
				'keyword1' => array('value' => $o_stu->getStudentId(),'color'=>'#173177'),
				'keyword2' => array('value' => $o_stu->getName(),'color'=>'#173177'),
				'keyword3' => array('value' => $o_stu->getIdType(),'color'=>'#173177'),
				'keyword4' => array('value' => $o_stu->getId(),'color'=>'#173177'),
				'keyword5' => array('value' => $o_stu->getSignupDate(),'color'=>'#173177'),
				'remark' => array('value' => '
请您于2017年6月14日17:00前关注报名状态。谢谢。
				
如需修改幼儿报名信息，请点击详情。')
			)
			);
		$curlUtil->https_request($s_url, json_encode($data));
	   	//$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Success(\'提交成功！\')');
		$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'signup_success.php?id='.$o_stu->getStudentId().'"' );
	}
	public function SignupModify($n_uid)
	{
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		//验证是否为本微信用户
		$o_stu_wechat=new Student_Info_Wechat();
		$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$n_uid) ); 
		$o_stu_wechat->PushWhere ( array ('&&', 'StudentId', '=',$this->getPost ( 'StudentId' )) ); 
		if($o_stu_wechat->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1002]\');' );
		}
		$o_stu=new Student_Info($this->getPost ( 'StudentId' ));
		$o_setup=new Admission_Setup(1); 
		//验证是否可以修改
		$s_date=$this->GetDate();
		if (strtotime($s_date)>strtotime($o_setup->getSignupEnd()) || $o_stu->getState()!=0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，报名已经截止，不能修改幼儿信息！\');' );
		}
		sleep(2);	
		$o_stu->setName($this->getPost ( 'Name' ));
	    $o_stu->setSex($this->getPost ( 'Sex' ));
	    if ($this->getPost ( 'Birthday' )=='')$this->ReturnMsg('基本信息的 [出生日期] 不能为空！','Birthday');
	    $o_stu->setBirthday($this->getPost ( 'Birthday' ));
	    $o_stu=$this->setStuInfo($o_stu);
	    $o_stu->Save();	    
	   	$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Success(\'修改报名信息成功！\',function(){parent.location="'.$this->getPost ( 'Url' ).'my_signup.php?"+Date.parse(new Date())})');
	}
	public function SignupFinishInfo($n_uid)
	{
		sleep(2);
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		//验证是否为本微信用户
		$o_stu_wechat=new Student_Info_Wechat();
		$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$n_uid) ); 
		$o_stu_wechat->PushWhere ( array ('&&', 'StudentId', '=',$this->getPost ( 'StudentId' )) ); 
		if($o_stu_wechat->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1002]\');' );
		}
		$o_stu=new Student_Info($this->getPost ( 'StudentId' ));		
		//验证是否可以修改
		if ($o_stu->getState()!=5)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1005]\');' );
		}			
		$s_country=$o_stu->getNationality();
		$s_jh2name=$o_stu->getJh2Name();
		$s_zProperty=$o_stu->getZProperty();
		if ($s_zProperty!='直系亲属房产')//修正住址房产属性
		{
			$o_stu->getZProperty('租借借用房产');
		}
		if ($this->getPost ( 'Draft' )==0)$o_stu->setState(6);
		$o_stu->setGangao($this->getPost ( 'Gangao' ));
		if($s_country=='中国')
		{
			$o_stu->setOnly($this->getPost ( 'Only' ));
		    if ($this->getPost ( 'Only' )=='否')
		    {
		    	$o_stu->setIsFirst($this->getPost ( 'IsFirst' ));
		    	$o_stu->setOnlyCode('');
		    }else{
		    	$o_stu->setOnlyCode($this->getPost ( 'OnlyCode' ));
		    	$o_stu->setIsFirst('');
		    }
		    $o_stu->setIsLieshi($this->getPost ( 'IsLieshi' )); 
		    $o_stu->setIsGuer($this->getPost ( 'IsGuer' ));
		    $o_stu->setIsWugong($this->getPost ( 'IsWugong' ));
		    $o_stu->setIsLiushou($this->getPost ( 'IsLiushou' ));
		    $o_stu->setIsDibao($this->getPost ( 'IsDibao' ));
			//是否低保，要低保证号
		    if ($this->getPost ( 'IsDibao' )=='是')
		    {
		    	if ($this->getPost ( 'DibaoCode' )=='')$this->ReturnMsg('基本信息的 [低保证号]不能为空 ！','DibaoCode');
		    	$o_stu->setDibaoCode($this->getPost ( 'DibaoCode' ));
		    }else{
		    	$o_stu->setDibaoCode('');
		    }
		    $o_stu->setIsZizhu($this->getPost ( 'IsZizhu' ));
		    $o_stu->setIsCanji($this->getPost ( 'IsCanji' ));
		    //验证残疾儿童
		    if ($this->getPost ( 'IsCanji' )=='是')
		    {
		    	if ($this->getPost ( 'CanjiType' )=='')$this->ReturnMsg('请选择基本信息的 [残疾幼儿类别] ！','CanjiType');
		    	if ($this->getPost ( 'CanjiCode' )=='')$this->ReturnMsg('基本信息的 [幼儿残疾证号] 不能为空！','CanjiCode');
		    	$o_stu->setCanjiType($this->getPost ( 'CanjiType' ));
		    	$o_stu->setCanjiCode($this->getPost ( 'CanjiCode' ));
		    }else{
		    	$o_stu->setCanjiType('');
		    	$o_stu->setCanjiCode('');
		    }
		}else{
		    $o_stu->setOnly('');
		    $o_stu->setOnlyCode('');
		    $o_stu->setIsFirst('');
		    $o_stu->setIsLieshi(''); 
		    $o_stu->setIsGuer('');
		    $o_stu->setIsWugong('');
		    $o_stu->setIsLiushou('');
		    $o_stu->setIsDibao('');
		    $o_stu->setDibaoCode('');
		    $o_stu->setIsZizhu('');
		    $o_stu->setIsCanji('');
		    $o_stu->setCanjiType('');
		    $o_stu->setCanjiCode('');
		}
		$o_stu->setXuexing($this->getPost ( 'Xuexing' ));
		$o_stu->setIsShoushu($this->getPost ( 'IsShoushu' ));
	    //验证手术名称
	    if ($this->getPost ( 'IsShoushu' )=='是')
	    {
	    	if ($this->getPost ( 'Shoushu' )=='')$this->ReturnMsg('健康信息的 [手术名称] 不能为空！','Shoushu');
	    	$o_stu->setShoushu($this->getPost ( 'Shoushu' ));
	    }else{
	    	$o_stu->setShoushu('');
	    }
	    $o_stu->setIsYizhi($this->getPost ( 'IsYizhi' ));
	    $o_stu->setIsYichuan($this->getPost ( 'IsYichuan' ));
	    //验证遗传
	    if ($this->getPost ( 'IsYichuan' )=='是')
	    {
	    	if ($this->getPost ( 'Qitabingshi' )=='')$this->ReturnMsg('健康信息的 [家族遗传病史名称] 不能为空！','Qitabingshi');
	    	$o_stu->setQitabingshi($this->getPost ( 'Qitabingshi' ));
	    }else{
	    	$o_stu->setQitabingshi('');
	    }
	    $o_stu->setBeizhu($this->getPost ( 'Beizhu' ));
	    if($s_country=='中国')
	    {
	    	$s_birthpace='';
	    	$s_birthpacecode='';
		    if ($this->getPost ( 'CCity' )=='')$this->ReturnMsg('请选择户籍信息的 [出生所在（省/市）] ！','CCity');
		    //获取城市名称
		    $o_city=new Student_City_Code($this->getPost ( 'CCity' )); 
		    $s_birthpace=$o_city->getName();
		    if (isset($_POST['Vcl_CArea']))
		    {
		    	if ($this->getPost ( 'CArea' )=='')$this->ReturnMsg('请选择户籍信息的 [出生所在（市/区）] ！','CArea');
		    	$o_city=new Student_City_Code($this->getPost ( 'CArea' )); 
		    	$s_birthpace.=$o_city->getName();
		    	$s_birthpacecode=$this->getPost ( 'CArea' );
		    }
	    	if (isset($_POST['Vcl_CStreet']))
		    {
		    	if ($this->getPost ( 'CStreet' )=='')$this->ReturnMsg('请选择户籍信息的 [出生所在（区/县）] ！','CArea');
		    	$o_city=new Student_City_Code($this->getPost ( 'CStreet' )); 
		    	$s_birthpace.=$o_city->getName();
		    	$s_birthpacecode=$this->getPost ( 'CStreet' );
		    } 
		    $o_stu->setBirthplace($s_birthpace);
		    $o_stu->setBirthplaceCode($s_birthpacecode);
		    $o_stu->setIdQuality($this->getPost ( 'IdQuality' ));
		    if ($this->getPost ( 'IdQuality' )=='非农业户口')
		    {
		    	$o_stu->setIdQualityType($this->getPost ( 'IdQualityType' ));
		    }else{
		    	$o_stu->setIdQualityType('');
		    }
		    if ($this->getPost ( 'HOwner' )=='')$this->ReturnMsg('户籍信息的 [户主姓名] 不能为空！','H_Owner');
		    $o_stu->setHOwner($this->getPost ( 'HOwner' ));
		    $o_stu->setHGuanxi($this->getPost ( 'HGuanxi' ));
	    }else{
	    	$o_stu->setBirthplace('');
		    $o_stu->setIdQuality('');
		    $o_stu->setIdQualityType(''); 
		    $o_stu->setHOwner('');
		    $o_stu->setHGuanxi('');   
	    }
		//验证第一法定监护人信息
		$o_stu->setJh1IdType($this->getPost ( 'Jh1IdType' ));
		if($this->getPost ( 'Jh1IdType' )=='居民身份证')
		{
			if ($this->validation_filter_id_card($this->getPost ( 'Jh1ID' ))==false)$this->ReturnMsg('第一法定监护人信息的 [身份证] 输入错误！','Jh1ID');//验证幼儿ID是否合法
		}
	    $o_stu->setJh1Id($this->getPost ( 'Jh1ID' ));
	    $o_stu->setJh1IsZhixi($this->getPost ( 'Jh1IsZhixi' ));
	    if ($this->getPost ( 'Jh1Phone' )=='')$this->ReturnMsg('第一法定监护人信息的 [联系电话] 不能为空！','Jh1Phone');
	    $o_stu->setJh1Phone($this->getPost ( 'Jh1Phone' ));
	    $o_stu->setJh1IsCanji($this->getPost ( 'Jh1IsCanji' ));
	    if ($this->getPost ( 'Jh1IsCanji' )=='是')
	    {
	    	$o_stu->setJh1CanjiCode($this->getPost ( 'Jh1CanjiCode' ));
	    }else{
	    	$o_stu->setJh1CanjiCode('');
	    }
	    //验证第二法定监护人信息,如果姓名填写了，那么其他信息也要填写
		if ($s_jh2name!='' || $this->getPost ( 'Jh2Name' )!='')
		{
		    if ($this->getPost ( 'Jh2IdType' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [证件类型] ！','Jh2IdType');
			$o_stu->setJh2IdType($this->getPost ( 'Jh2IdType' ));
			if($this->getPost ( 'Jh2IdType' )=='居民身份证')
			{
				if ($this->validation_filter_id_card($this->getPost ( 'Jh2ID' ))==false)$this->ReturnMsg('第二法定监护人信息的 [身份证] 输入错误！','Jh2ID');//验证幼儿ID是否合法
			}
		    $o_stu->setJh2Id($this->getPost ( 'Jh2ID' ));
		    if ($this->getPost ( 'Jh2IsZhixi' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [是否是直系亲属] ！','Jh2IsZhixi');
		    $o_stu->setJh2IsZhixi($this->getPost ( 'Jh2IsZhixi' ));
		    if ($this->getPost ( 'Jh2Job' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [职业状况] ！','Jh2Job');
		    $o_stu->setJh2Job($this->getPost ( 'Jh2Job' ));
		    if ($this->getPost ( 'Jh2Phone' )=='')$this->ReturnMsg('第二法定监护人信息的 [联系电话] 不能为空！','Jh2Phone');
		    $o_stu->setJh2Phone($this->getPost ( 'Jh2Phone' ));
		    $o_stu->setJh2IsCanji($this->getPost ( 'Jh2IsCanji' ));
		    if ($this->getPost ( 'Jh2IsCanji' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [是否残疾] ！','Jh2IsCanji');
		    if ($this->getPost ( 'Jh2IsCanji' )=='是')
		    {
		    	$o_stu->setJh2CanjiCode($this->getPost ( 'Jh2CanjiCode' ));
		    }else{
		    	$o_stu->setJh2CanjiCode('');
		    }
		    if ($this->getPost ( 'Jh2Name' )!='')
		    {
		    	$o_stu->setJh2Connection($this->getPost ( 'Jh2Connection' )); 
			    if ($this->getPost ( 'Jh2Name' )=='')$this->ReturnMsg('第二法定监护人信息的 [姓名] 不能为空！','Jh2Name');
			    $o_stu->setJh2Name($this->getPost ( 'Jh2Name' ));				
			    if ($this->getPost ( 'Jh2Jiaoyu' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [教育程度] ！','Jh2Jiaoyu');
			    $o_stu->setJh2Jiaoyu($this->getPost ( 'Jh2Jiaoyu' ));
			    if ($this->getPost ( 'Jh2Danwei' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [工作单位全称] ！','Jh2Danwei');
			    $o_stu->setJh2Danwei($this->getPost ( 'Jh2Danwei' ));
		    }
		}else{
			$o_stu->setJh2Connection(''); 
			$o_stu->setJh2Name('');
			$o_stu->setJh2IdType('');
			$o_stu->setJh2Id('');
		    $o_stu->setJh2IsZhixi('');
			$o_stu->setJh2Job('');
			$o_stu->setJh2Jiaoyu('');
		    $o_stu->setJh2IsCanji('');
		    $o_stu->setJh2IsDanwei('');
		    $o_stu->setJh2Phone('');
			$o_stu->setJh2CanjiCode('');
		}
		if($this->getPost ( 'JianhuName' )!='')
		{
			if ($this->getPost ( 'JianhuConnection' )=='')$this->ReturnMsg('请选择其他监护人信息的 [关系] ！','JianhuConnection');
			$o_stu->setJianhuConnection($this->getPost ( 'JianhuConnection' ));
	    	if ($this->getPost ( 'JianhuName' )=='')$this->ReturnMsg('其他监护人信息的 [姓名] 不能为空！','JianhuName');
			$o_stu->setJianhuName($this->getPost ( 'JianhuName' ));
			if ($this->getPost ( 'JianhuPhone' )=='')$this->ReturnMsg('其他监护人信息的 [联系电话] 不能为空！','JianhuPhone');
	    	$o_stu->setJianhuPhone($this->getPost ( 'JianhuPhone' ));
		}else{
			$o_stu->setJianhuConnection('');
			$o_stu->setJianhuName('');
	    	$o_stu->setJianhuPhone('');
		}
	    $o_stu->Save();
	    if ($this->getPost ( 'Draft' )==0)
	    {
	    	//发送消息模板
	    	//发送信息提交成功提醒
	    	$o_admission_setup=new Admission_Setup(1);
	    	$o_sysinfo=new Base_Setup(1);
		    require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
			$o_token=new accessToken();
			$curlUtil = new curlUtil();
		    $o_parent=new WX_User_Info($n_uid);
			$s_url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$o_token->access_token;
			$data = array(
		    	'touser' => $o_parent->getOpenId(), // openid是发送消息的基础
				'template_id' => $this->getWechatSetup('MSGTMP_06'), // 模板id
				'url' => $o_sysinfo->getHomeUrl().'sub/wechat/parent_signup/my_signup_state.php?id='.$o_stu->getStudentId(), // 点击跳转地址
				'topcolor' => '#FF0000', // 顶部颜色
				'data' => array(
					'first' => array('value' => '您所报名的如下幼儿已经被我园录取，请按时带幼儿进行注册，未能按时注册视为自动放弃入园资格。
'),
					'keyword1' => array('value' => $o_stu->getStudentId(),'color'=>'#173177'),
					'keyword2' => array('value' => $o_stu->getName(),'color'=>'#173177'),
					'keyword3' => array('value' => $o_stu->getIdType(),'color'=>'#173177'),
					'keyword4' => array('value' => $o_stu->getId(),'color'=>'#173177'),
					'keyword5' => array('value' => $o_stu->getClassMode(),'color'=>'#173177'),
					'remark' => array('value' => '注册时间：2017年8月25日 08：30
注册地点：北京市西城区红莲中里10号。
				
报到注意事项请点击详情查看。')
				)
				);
			$curlUtil->https_request($s_url, json_encode($data));
			//保存到消息提醒，共用户可查阅
			$o_msg=new Wechat_Wx_User_Reminder();
			$o_msg->setUserId($n_uid);
			$o_msg->setCreateDate($this->GetDateNow());
			$o_msg->setSendDate($this->GetDate());
			$o_msg->setMsgId($this->getWechatSetup('MSGTMP_06'));
			$o_msg->setOpenId($o_parent->getOpenId());
			$o_msg->setActivityId(0);
			$o_msg->setSend(1);
			$o_msg->setFirst('您所报名的如下幼儿已经被我园录取，请按时带幼儿进行注册，未能按时注册视为自动放弃入园资格。');
			$o_msg->setKeyword1($o_stu->getStudentId());
			$o_msg->setKeyword2($o_stu->getName());
			$o_msg->setKeyword3($o_stu->getIdType());
			$o_msg->setKeyword4($o_stu->getId());
			$o_msg->setKeyword5($o_stu->getClassMode());
			$o_msg->setRemark('');
			$o_msg->setUrl('');
			$o_msg->setKeywordSum(5);
			$o_msg->Save();
	    	$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Success(\'提交正式信息成功！\',function(){parent.location="'.$this->getPost ( 'Url' ).'my_signup.php?"+Date.parse(new Date())})');
	    }else{
	    	$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Success(\'保存草稿成功！\',function(){parent.location="'.$this->getPost ( 'Url' ).'my_signup.php?"+Date.parse(new Date())})');
	    }	   	
	}
	public function SignupCancel($n_uid)
	{
		$a_result=array();
		if ($n_uid>0)
		{
			
		}else{
			echo(json_encode ( $a_result ));
			exit(0);
		}
		sleep(1);
		//先删除关联信息，验证是否有这个信息
		$o_stu_wechat=new Student_Info_Wechat();
		$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$n_uid) ); 
		$o_stu_wechat->PushWhere ( array ('&&', 'StudentId', '=',$this->getPost ( 'id' )) ); 
		if($o_stu_wechat->getAllCount()>0)
		{
			$o_sut_info=new Student_Info($this->getPost ( 'id' ));
			//信息删除必须是状态等于零
			if($o_sut_info->getState()!=0)
			{
				echo(json_encode ( $a_result ));
				exit(0);
			}
			$o_stu_wechat=new Student_Info_Wechat($o_stu_wechat->getId(0));
			$o_stu_wechat->Deletion();
			//再删除幼儿信息			
			//发送删除信息模板消息
		    require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
		    $o_sysinfo=new Base_Setup(1);
			$o_token=new accessToken();
			$curlUtil = new curlUtil();
		    $o_parent=new WX_User_Info($n_uid);
			$s_url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$o_token->access_token;
			$data = array(
		    	'touser' => $o_parent->getOpenId(), // openid是发送消息的基础
				'template_id' =>$this->getWechatSetup('MSGTMP_07'), // 模板id
				'url' => '', // 点击跳转地址
				'topcolor' => '#FF0000', // 顶部颜色
				'data' => array(
					'first' => array('value' => '您好，您已经成功将下面信息删除：
'),
					'keyword1' => array('value' => $o_sut_info->getStudentId(),'color'=>'#173177'),
					'keyword2' => array('value' => $o_sut_info->getName(),'color'=>'#173177'),
					'keyword3' => array('value' => $o_sut_info->getIdType(),'color'=>'#173177'),
					'keyword4' => array('value' => $o_sut_info->getId(),'color'=>'#173177'),
					'keyword5' => array('value' => $this->GetDateNow(),'color'=>'#173177'),
					'remark' => array('value' => '
感谢您的参与，谢谢！')
				)
				);
			$curlUtil->https_request($s_url, json_encode($data));
			$o_sut_info->Deletion();
		}
		echo(json_encode ( $a_result ));
		exit(0);		
	}
	protected function setStuInfo($o_stu)
	{
		//flag归零
		$o_stu->setFlagThree(0);
		$o_stu->setFlagXicheng(0);
		$o_stu->setClassNameDiy('');
		$o_stu->setFlagSame(0);
		$o_stu->setFlagOnly(0);
		$o_stu->setFlagFirst(0);
		$o_stu->setNationality($this->getPost ( 'Nationality' ));
		$o_stu->setGangao('非港澳台侨');
		if($this->getPost ( 'Nationality' )=='中国')
		{
			$o_stu->setNation($this->getPost ( 'Nation' ));
		    $o_stu->setOnly('否');
		    $o_stu->setOnlyCode('');
		    $o_stu->setIsFirst('是');
		    $o_stu->setIsLieshi('否'); 
		    $o_stu->setIsGuer('否');
		    $o_stu->setIsWugong('否');
		    $o_stu->setIsLiushou('非留守儿童');
		    $o_stu->setIsDibao('否');
		    $o_stu->setDibaoCode('');			
		    $o_stu->setIsZizhu('否');
		    $o_stu->setIsCanji('否');
		    $o_stu->setCanjiType('');
		    $o_stu->setCanjiCode('');
		}else{
			$o_stu->setNation('');
		    $o_stu->setOnly('');
		    $o_stu->setOnlyCode('');
		    $o_stu->setIsFirst('');
		    $o_stu->setIsLieshi(''); 
		    $o_stu->setIsGuer('');
		    $o_stu->setIsWugong('');
		    $o_stu->setIsLiushou('');
		    $o_stu->setIsDibao('');
		    $o_stu->setDibaoCode('');
		    $o_stu->setIsZizhu('');
		    $o_stu->setIsCanji('');
		    $o_stu->setCanjiType('');
		    $o_stu->setCanjiCode('');
		}
		$o_stu->setJiankang($this->getPost ( 'Jiankang' ));
		$o_stu->setXuexing('未知血型');
		$o_stu->setIsYiwang($this->getPost ( 'IsYiwang' ));
		if ($this->getPost ( 'HospitalName' )=='')$this->ReturnMsg('健康信息的 [预防接种医院] 不能为空！','HospitalName');
	    $o_stu->setHospitalName($this->getPost ( 'HospitalName' ));
		//验证过敏源
	    if ($this->getPost ( 'IsYiwang' )!='否')
	    {
	    	if ($this->getPost ( 'Illness' )=='')$this->ReturnMsg('请选择健康信息的 [以往病史] ！','Illness');
	    	$o_stu->setIllness($this->getPost ( 'Illness' ));
	    }else{
	    	$o_stu->setIllness('');
	    }
		$o_stu->setIsShoushu('否');
		$o_stu->setShoushu('');	    
	    $o_stu->setIsYizhi('否');
	    $o_stu->setIsGuomin($this->getPost ( 'IsGuomin' ));
	    //验证过敏源
	    if ($this->getPost ( 'IsGuomin' )!='否')
	    {
	    	if ($this->getPost ( 'Allergic' )=='')$this->ReturnMsg('健康信息的 [过敏源] 不能为空！','Allergic');
	    	$o_stu->setAllergic($this->getPost ( 'Allergic' ));
	    }else{
	    	$o_stu->setAllergic('');
	    }	    
		$o_stu->setIsYichuan('否');
		$o_stu->setQitabingshi('');	    
	    $o_stu->setBeizhu('');
	    //户籍
	    $o_stu->setFlagXicheng(0);
	    if($this->getPost ( 'Nationality' )=='中国')
	    {	    	
		    $o_stu->setBirthplace('');
		    $o_stu->setBirthplaceCode('');
		    $o_stu->setIdQuality('非农业户口');		 
		    $o_stu->setIdQualityType('城市');		    	    
		    $o_city=new Student_City_Code($this->getPost ( 'HCity' ));    
		    $o_stu->setHCity($o_city->getName());
		    //验证户籍信息
		    $o_stu->setHArea('');
		    $o_stu->setHShequ('');
		    $o_stu->setHStreet('');
		    //-----------填写户籍信息
		    $o_city=new Student_City_Code($this->getPost ( 'HArea' ));    
		    $o_stu->setHArea($o_city->getName());
		    $o_stu->setHCode($this->getPost ( 'HArea' ));
		    if ($this->getPost ( 'HCity' )=='')$this->ReturnMsg('请选择户籍信息的 [户籍所在（省/市）] ！','HCity');		    
		    if($this->getPost ( 'HCity' )=='110000000000' && $this->getPost ( 'HArea' )=='110102000000')
		    {
		    	if ($this->getPost ( 'HStreet' )=='')$this->ReturnMsg('请选择户籍信息的 [户籍所在街道]！','HStreet');
		    	if ($this->getPost ( 'HShequ' )=='')$this->ReturnMsg('请选择户籍信息的 [户籍所在社区] ！','HShequ');
		    	$o_stu->setFlagXicheng(1);//添加户籍为西城的标志
		    	$o_stu->setHShequ($this->getPost ( 'HShequ' ));
		    	$o_stu->setHStreet($this->getPost ( 'HStreet' ));
		    }else{
		    	if (isset($_POST['Vcl_HArea'])) 
		    	{
		    		if ($this->getPost ( 'HArea' )=='')$this->ReturnMsg('请选择户籍信息的 [户籍所在（市/区）] ！','HArea');
		    	}
		    	if (isset($_POST['Vcl_HStreet']))
			    {
			    	if ($this->getPost ( 'HStreet' )=='')$this->ReturnMsg('请选择户籍信息的 [户籍所在（区/县）] ！','HStreet');
			    	$o_city=new Student_City_Code($this->getPost ( 'HStreet' )); 
			    	$o_stu->setHCode($this->getPost ( 'HStreet' ));
			    	$o_stu->setHStreet($o_city->getName());
			    } 
		    }  
		    $o_stu->setHIsGroup($this->getPost ( 'HIsGroup' ));
		    $o_stu->setHIsYizhi($this->getPost ( 'HIsYizhi' ));
		    if ($this->getPost ( 'HAdd' )=='')$this->ReturnMsg('户籍信息的 [户籍详细地址] 不能为空！','HAdd');
		    $o_stu->setHAdd($this->getPost ( 'HAdd' ));
		    $o_stu->setHOwner('');
		    $o_stu->setHGuanxi('父母');
	    }else{
		    $o_stu->setBirthplace('');
		    $o_stu->setIdQuality('');
		    $o_stu->setIdQualityType('');    
		    $o_stu->setHCity('');
		    $o_stu->setHCode('');
		    //验证户籍信息
		    $o_stu->setHArea('');
		    $o_stu->setHShequ('');
		    $o_stu->setHStreet('');
		    $o_stu->setHShequ('');
		    $o_stu->setHStreet('');
		    $o_stu->setHIsGroup('');
		    $o_stu->setHIsYizhi('');
		    $o_stu->setHAdd('');
		    $o_stu->setHOwner('');
		    $o_stu->setHGuanxi('');
	    }
	    //验证现住址信息
	    $o_stu->setZSame($this->getPost ( 'ZSame' ));
	    $o_stu->setZCity('');
	    $o_stu->setZArea('');
	    $o_stu->setZShequ('');
		$o_stu->setZStreet('');
		$o_stu->setZAdd('');
	    if($this->getPost ( 'ZSame' )!='否')
	    {
	    	//复制户籍信息
	    	if($this->getPost ( 'HCity' )=='110000000000')
	    	{
	    		if($this->getPost ( 'HArea' )=='110102000000')
	    		{
	    			$o_stu->setFlagSame(1);//添加房户一致的标志
	    		}
	    	}
	    }else{	    	
	    	$o_stu->setZCity($this->getPost ( 'ZCity' ));
	    	//继续验证现住址信息
	    	if($this->getPost ( 'ZCity' )=='北京市')
		    {
		    	$o_stu->setZArea($this->getPost ( 'ZArea' ));
		    	if($this->getPost ( 'ZArea' )=='西城区')
		    	{
		    		if ($this->getPost ( 'ZStreet' )=='')$this->ReturnMsg('请选择现住址信息的 [现住址所在街道]！','ZStreet');
		    		if ($this->getPost ( 'ZShequ' )=='')$this->ReturnMsg('请选择现住址信息的 [现住址所在社区]！','ZShequ');
		    		$o_stu->setZShequ($this->getPost ( 'ZShequ' ));
		    		$o_stu->setZStreet($this->getPost ( 'ZStreet' ));
		    	}
		    }
		    if ($this->getPost ( 'ZAdd' )=='')$this->ReturnMsg('现住址信息的 [现住址详细地址] 不能为空！','HAdd');
		    $o_stu->setZAdd($this->getPost ( 'ZAdd' ));
	    }
		//现住址房屋属性
	    $o_stu->setZProperty($this->getPost ( 'ZProperty' ));
	    if($this->getPost ( 'ZProperty' )=='直系亲属房产')
	    {
	    	if ($this->getPost ( 'ZOwner' )=='')$this->ReturnMsg('现住址信息的 [产权人姓名] 不能为空！','ZOwner');
	    	$o_stu->setZOwner($this->getPost ( 'ZOwner' ));
	    	$o_stu->setZGuanxi($this->getPost ( 'ZGuanxi' ));
	    }else{
	    	$o_stu->setZOwner('');
	    	$o_stu->setZGuanxi('');
	    }
	    //验证第一法定监护人信息
	    $o_stu->setJh1Connection($this->getPost ( 'Jh1Connection' )); 
	    if ($this->getPost ( 'Jh1Name' )=='')$this->ReturnMsg('第一法定监护人信息的 [姓名] 不能为空！','Jh1Name');
	    $o_stu->setJh1Name($this->getPost ( 'Jh1Name' ));
		$o_stu->setJh1IdType('居民身份证');		
	    $o_stu->setJh1Id('');
	    $o_stu->setJh1IsZhixi('是');
	    if ($this->getPost ( 'Jh1Job' )=='')$this->ReturnMsg('请选择第一法定监护人信息的 [职业状况] ！','Jh1Job');
	    $o_stu->setJh1Job($this->getPost ( 'Jh1Job' ));	
	    if ($this->getPost ( 'Jh1Jiaoyu' )=='')$this->ReturnMsg('请选择第一法定监护人信息的 [教育程度] ！','Jh1Jiaoyu');
	    $o_stu->setJh1Jiaoyu($this->getPost ( 'Jh1Jiaoyu' ));	
	     if ($this->getPost ( 'Jh1Danwei' )=='')$this->ReturnMsg('请选择第一法定监护人信息的 [工作单位全称] ！','Jh1Danwei');
	    $o_stu->setJh1Danwei($this->getPost ( 'Jh1Danwei' ));   
	    $o_stu->setJh1IsCanji('否');
	    $o_stu->setJh1CanjiCode('');
		//验证第二法定监护人信息,如果姓名填写了，那么其他信息也要填写
		if ($this->getPost ( 'Jh2Name' )!='')
		{
		    $o_stu->setJh2Connection($this->getPost ( 'Jh2Connection' )); 
		    if ($this->getPost ( 'Jh2Name' )=='')$this->ReturnMsg('第二法定监护人信息的 [姓名] 不能为空！','Jh2Name');
		    $o_stu->setJh2Name($this->getPost ( 'Jh2Name' ));
			$o_stu->setJh2IdType('');
		    $o_stu->setJh2Id('');
		    $o_stu->setJh2IsZhixi('');	 
		    if ($this->getPost ( 'Jh2Job' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [职业状况] ！','Jh2Job');
	    	$o_stu->setJh2Job($this->getPost ( 'Jh2Job' ));	   
		    if ($this->getPost ( 'Jh2Jiaoyu' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [教育程度] ！','Jh2Jiaoyu');
		    $o_stu->setJh2Jiaoyu($this->getPost ( 'Jh2Jiaoyu' ));
		    if ($this->getPost ( 'Jh2Danwei' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [工作单位全称] ！','Jh2Danwei');
		    $o_stu->setJh2Danwei($this->getPost ( 'Jh2Danwei' ));
		    $o_stu->setJh2IsCanji('');
		    $o_stu->setJh2CanjiCode('');
		}else{
			$o_stu->setJh2Connection(''); 
			$o_stu->setJh2Name('');
			$o_stu->setJh2IdType('');
			$o_stu->setJh2Id('');
		    $o_stu->setJh2IsZhixi('');
			$o_stu->setJh2Job('');
			$o_stu->setJh2Jiaoyu('');
		    $o_stu->setJh2IsCanji('');
		    $o_stu->setJh2Danwei('');
			$o_stu->setJh2CanjiCode('');
		}
		$o_stu->setJianhuConnection('');
		$o_stu->setJianhuName('');
	    $o_stu->setJianhuPhone('');
	    if ($this->getPost ( 'SignupPhone' )=='')$this->ReturnMsg('报名联系方式的 [监护人手机号] 不能为空！','Jh1Phone');
	    $o_stu->setSignupPhone($this->getPost ( 'SignupPhone' ));
	    if ($this->getPost ( 'SignupPhoneBackup' )=='')$this->ReturnMsg('报名联系方式的 [备用联系电话] 不能为空！','Jh1Phone');
	    $o_stu->setSignupPhoneBackup($this->getPost ( 'SignupPhoneBackup' ));
	    //设置flag
	    //是否满三岁，出生日期加3年，必须小于今年的8月31日
	    $a_year=array();
	    $a_year=explode('-', $this->getPost ( 'Birthday' ));
	    $a_year[0]=$a_year[0]+3;
	    $o_date = new DateTime('Asia/Chongqing');
		$s_now=$o_date->format('Y') . '-09-01';
	    $s_birthday=$a_year[0] . '-' . $a_year[1] . '-' . $a_year[2];
	    if (strtotime($s_birthday)<strtotime($s_now))
	    {
	    	$o_stu->setFlagThree(1);
	    }
	    //是否独生子女
	    if($this->getPost ( 'Only' )=='是')
	    {
	    	$o_stu->setFlagOnly(1);
	    }elseif ($this->getPost ( 'IsFirst' )=='是'){
	    	//是否头胎
	    	$o_stu->setFlagFirst(1);
	    }
	    $o_setup=new Admission_Setup(1);
	    $o_stu->setDeptId($o_setup->getDeptId());
	    //附加信息
	    $o_stu->setClassMode($this->getPost ( 'ClassMode' ));
	    $o_stu->setCompliance($this->getPost ( 'Compliance' ));
	    $o_stu->setSignup($this->GetDate());
		return $o_stu;
	}
	protected function ReturnMsg($s_msg,$id)
	{
		echo ('<script>parent.Common_CloseDialog();parent.Dialog_Message("'.$s_msg.'");parent.document.getElementById("Vcl_'.$id.'").focus();</script>');
		exit ( 0 );
	}
	protected function validation_filter_id_card($id_card) {
		if (strlen ( $id_card ) == 18) {
			return $this->idcard_checksum18 ( $id_card );
		} elseif ((strlen ( $id_card ) == 15)) {
			$id_card = $this->idcard_15to18 ( $id_card );
			return $this->idcard_checksum18 ( $id_card );
		} else {
			return false;
		}
	}
	// 计算身份证校验码，根据国家标准GB 11643-1999 
	protected function idcard_verify_number($idcard_base) {
		if (strlen ( $idcard_base ) != 17) {
			return false;
		}
		//加权因子 
		$factor = array (7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 );
		//校验码对应值 
		$verify_number_list = array ('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2' );
		$checksum = 0;
		for($i = 0; $i < strlen ( $idcard_base ); $i ++) {
			$checksum += substr ( $idcard_base, $i, 1 ) * $factor [$i];
		}
		$mod = $checksum % 11;
		$verify_number = $verify_number_list [$mod];
		return $verify_number;
	}
	// 将15位身份证升级到18位 
	protected function idcard_15to18($idcard) {
		if (strlen ( $idcard ) != 15) {
			return false;
		} else {
			// 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码 
			if (array_search ( substr ( $idcard, 12, 3 ), array ('996', '997', '998', '999' ) ) !== false) {
				$idcard = substr ( $idcard, 0, 6 ) . '18' . substr ( $idcard, 6, 9 );
			} else {
				$idcard = substr ( $idcard, 0, 6 ) . '19' . substr ( $idcard, 6, 9 );
			}
		}
		$idcard = $idcard . $this->idcard_verify_number ( $idcard );
		return $idcard;
	}
	// 18位身份证校验码有效性检查 
	protected function idcard_checksum18($idcard) {
		if (strlen ( $idcard ) != 18) {
			return false;
		}
		$idcard_base = substr ( $idcard, 0, 17 );
		if ($this->idcard_verify_number ( $idcard_base ) != strtoupper ( substr ( $idcard, 17, 1 ) )) {
			return false;
		} else {
			return true;
		}
	}
	public function AuditApprove($n_uid)
	{
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		//验证是否为绑定用户
		$o_stu_wechat=new Base_User_Wechat_View();
		$o_stu_wechat->PushWhere ( array ('&&', 'WechatId', '=',$n_uid) ); 
		if($o_stu_wechat->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1003]\');' );
		}
		$o_stu=new Student_Info($this->getPost ( 'StudentId' ));
		if ($o_stu->getState()!=1)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1004]\');' );
		}
		$o_stu->setAuditorId($o_stu_wechat->getUid(0));
	    $o_stu->setAuditorName($o_stu_wechat->getName(0));
	    //开始记录核验选项
	    $o_question=new Student_Audit_Question();
	    $o_question->PushOrder ( array ('Number','A') );   
	    $a_question_result=array();
	    for($i=0;$i<$o_question->getAllCount();$i++)
	    {
	    	if ($o_question->getType($i)==0)
	    	{
	    		//单选
	    		if ($this->getPost('Question_'.$o_question->getId($i))=='')
	    		{
	    			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'请选择“'.$o_question->getText($i).'”\');' );
	    		}
	    		array_push($a_question_result, rawurlencode($this->getPost('Question_'.$o_question->getId($i))));
	    	}else{
	    		//多选
	    		$s_temp='';
	    		$o_option=new Student_Audit_Option();
	    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) ); 
	    		$o_option->PushOrder ( array ('Number','A') ); 
	    		for($j=0;$j<$o_option->getAllCount();$j++)
	    		{
	    			if ($this->getPost('Option_'.$o_option->getId($j))=='on')
	    			{
	    				$s_temp.=$o_option->getText($j).';';
	    			}
	    		}
	    		if ($s_temp=='')
	    		{
	    			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'请选择“'.$o_question->getText($i).'”\');' );
	    		}else{
	    			$s_temp=substr($s_temp,0,strlen($s_temp)-1); //去掉最后一个分号
	    		}
	    		array_push($a_question_result,rawurlencode($s_temp));
	    	}
	    }
	    $o_stu->setAuditOption(json_encode($a_question_result));
	    $o_stu->setAuditRemark($this->getPost ( 'AuditRemark' ));
		$o_stu->setState(2);
		$o_stu->setReject(0);
		$o_stu->Save();	
		//发送模板消息
		$o_admission_setup=new Admission_Setup(1);
		$o_sysinfo=new Base_Setup(1);
		require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';		    
		$o_token=new accessToken();
		//获取幼儿关联的微信
		$o_wechat_user=new Student_Info_Wechat_Wiew();
		$o_wechat_user->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getStudentId()) );
		for($j=0;$j<$o_wechat_user->getAllCount();$j++)
		{
			//立即发送见面信息模板消息$this->getMeetTime($o_admission_setup->getMeetTime());
			$a_time=$this->getMeetDateAndTime($o_admission_setup->getMeetDate(), $o_admission_setup->getMeetTime());
			$s_meet_date=$a_time[0];
			$s_meet_time=$a_time[1];
			$curlUtil = new curlUtil();
		    $o_parent=new WX_User_Info($o_wechat_user->getUserId($j));
			$s_url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$o_token->access_token;
			$data = array(
		    	'touser' => $o_parent->getOpenId(), // openid是发送消息的基础
				'template_id' => $this->getWechatSetup('MSGTMP_03'), // 模板id
				'url' => $o_sysinfo->getHomeUrl().'sub/wechat/parent_signup/my_signup_state.php?id='.$o_stu->getStudentId(), // 点击跳转地址
				'topcolor' => '#FF0000', // 顶部颜色
				'data' => array(
					'first' => array('value' => '如下幼儿信息核验已经通过，请按时段地点携带幼儿参加见面，如错过见面视为自行放弃入园资格：
'),
					'keyword1' => array('value' => $o_stu->getStudentId(),'color'=>'#173177'),
					'keyword2' => array('value' => $o_stu->getName(),'color'=>'#173177'),
					'keyword3' => array('value' => $s_meet_date,'color'=>'#173177'),
					'keyword4' => array('value' => $s_meet_time,'color'=>'#173177'),
					'keyword5' => array('value' => $o_admission_setup->getMeetAddress(),'color'=>'#173177'),
					'remark' => array('value' => '
见面会注意事项请点击详情查看。')
				)
				);
			$curlUtil->https_request($s_url, json_encode($data));
			//保存到消息提醒，共用户可查阅
			$o_msg=new Wechat_Wx_User_Reminder();
			$o_msg->setUserId($o_wechat_user->getUserId($j));
			$o_msg->setCreateDate($this->GetDateNow());
			$o_msg->setSendDate($this->GetDate());
			$o_msg->setMsgId($this->getWechatSetup('MSGTMP_03'));
			$o_msg->setOpenId($o_parent->getOpenId());
			$o_msg->setActivityId(0);
			$o_msg->setSend(1);
			$o_msg->setFirst('如下幼儿信息核验已经通过，请按时段地点携带幼儿参加见面，如错过见面视为自行放弃入园资格：');
			$o_msg->setKeyword1($o_stu->getStudentId());
			$o_msg->setKeyword2($o_stu->getName());
			$o_msg->setKeyword3($s_meet_date);
			$o_msg->setKeyword4($s_meet_time);
			$o_msg->setKeyword5($o_admission_setup->getMeetAddress());
			$o_msg->setRemark('');
			$o_msg->setUrl('');
			$o_msg->setKeywordSum(5);
			$o_msg->Save();
		}	    
	   	$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'audit_search_success.php"');
	}
	private function getMeetDateAndTime($s_date,$s_time)
	{
		//读取见面设置
		$o_table=new Admission_Time();
		$o_table->PushWhere ( array ('&&', 'Type', '=', 'meet' ) );
		$o_table->PushOrder ( array ('Id', 'A' ) );
        for($i=0;$i<$o_table->getAllCount();$i++)
        {
        	if ($o_table->getUseSum($i)<$o_table->getSum($i))
        	{
        		$s_time=$o_table->getTime($i);
        		$s_date=$o_table->getDate($i);
        		$o_table->SumAdd1($o_table->getId($i));
        	}
        }
        return array($s_date,$s_time);
	}
	public function AuditReject($n_uid)
	{
		sleep(1);
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		//验证是否为绑定用户
		$o_stu_wechat=new Base_User_Wechat_View();
		$o_stu_wechat->PushWhere ( array ('&&', 'WechatId', '=',$n_uid) ); 
		if($o_stu_wechat->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1003]\');' );
		}
		$o_stu=new Student_Info($this->getPost ( 'StudentId' ));
		if ($o_stu->getState()!=1)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1004]\');' );
		}
		$o_stu->setAuditorId($o_stu_wechat->getUid(0));
	    $o_stu->setAuditorName($o_stu_wechat->getName(0));
	    //开始记录核验选项
	    $o_question=new Student_Audit_Question();
	    $o_question->PushOrder ( array ('Number','A') );   
	    $a_question_result=array();
	    for($i=0;$i<$o_question->getAllCount();$i++)
	    {
	    	if ($o_question->getType($i)==0)
	    	{
	    		//单选
	    		if ($this->getPost('Question_'.$o_question->getId($i))=='')
	    		{
	    			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'请选择“'.$o_question->getText($i).'”\');' );
	    		}
	    		array_push($a_question_result, rawurlencode($this->getPost('Question_'.$o_question->getId($i))));
	    	}else{
	    		//多选
	    		$s_temp='';
	    		$o_option=new Student_Audit_Option();
	    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) ); 
	    		$o_option->PushOrder ( array ('Number','A') ); 
	    		for($j=0;$j<$o_option->getAllCount();$j++)
	    		{
	    			if ($this->getPost('Option_'.$o_option->getId($j))=='on')
	    			{
	    				$s_temp.=$o_option->getText($j).';';
	    			}
	    		}
	    		if ($s_temp=='')
	    		{
	    			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'请选择“'.$o_question->getText($i).'”\');' );
	    		}else{
	    			$s_temp=substr($s_temp,0,strlen($s_temp)-1); //去掉最后一个分号
	    		}
	    		array_push($a_question_result,rawurlencode($s_temp));
	    	}
	    }
	    $o_stu->setAuditOption(json_encode($a_question_result));	    
	    if ($this->getPost ( 'AuditRemark' )=='')
	    {
	    	$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，核验不通过时，核验备注不能为空！\');' );
	    }else{
	    	$o_stu->setAuditRemark($this->getPost ( 'AuditRemark' ));
	    }   
		$o_stu->Save();	
	   	$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'audit_search.php?"+Date.parse(new Date())');
	}
	public function MeetSubmit($n_uid)
	{
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		//验证是否为绑定用户
		$o_stu_wechat=new Base_User_Wechat_View(); 
		$o_stu_wechat->PushWhere ( array ('&&', 'WechatId', '=',$n_uid) ); 
		if($o_stu_wechat->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1003]\');' );
		}
		$o_stu=new Student_Info($this->getPost ( 'StudentId' ));
		if ($o_stu->getState()!=2)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1004]\');' );
		}
		$o_stu->setState(3);
		$o_stu->setReject(0);
		//填写见面结果
		$a_result=array();
		$o_item=new Student_Info_Meet_Item();
		$o_item->PushWhere ( array ('&&', 'Type', '=','幼儿见面') ); 
	    $o_item->PushOrder ( array ('Number','A') );
	    for($i=0;$i<$o_item->getAllCount();$i++)
	    {
	    	array_push($a_result, array('id'=>$o_item->getId($i),'value'=>$this->getPost ( 'Item_'.$o_item->getId($i))));   	
	    }
	    if (count($a_result)==0)
	    {
	    	$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'对不起，请选择见面结果！\');' );
	    }
	    $o_stu->setMeetAuditorId($o_stu_wechat->getUid(0));
	    $o_stu->setMeetAuditorName($o_stu_wechat->getName(0));
	    $o_stu->setMeetItem(json_encode($a_result));
	    $o_stu->setMeetRemark($this->getPost ( 'Remark' ));
		$o_stu->Save();  
	   	$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'meet_search_success.php"');
	}
	public function MeetParentSubmit($n_uid)
	{
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		//验证是否为绑定用户
		$o_stu_wechat=new Base_User_Wechat_View(); 
		$o_stu_wechat->PushWhere ( array ('&&', 'WechatId', '=',$n_uid) ); 
		if($o_stu_wechat->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1003]\');' );
		}
		$o_stu=new Student_Info($this->getPost ( 'StudentId' ));
		if ($o_stu->getState()!=2 && $o_stu->getState()!=3)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1004]\');' );
		}
		//填写见面结果
		$a_result=array();
		$o_item=new Student_Info_Meet_Item();
		$o_item->PushWhere ( array ('&&', 'Type', '=','家长见面') ); 
	    $o_item->PushOrder ( array ('Number','A') );
	    for($i=0;$i<$o_item->getAllCount();$i++)
	    {
	    	array_push($a_result, array('id'=>$o_item->getId($i),'value'=>$this->getPost ( 'Item_'.$o_item->getId($i))));   	
	    }
	    if (count($a_result)==0)
	    {
	    	$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'对不起，请选择见面结果！\');' );
	    }
	    $o_stu->setMeetParentAuditorId($o_stu_wechat->getUid(0));
	    $o_stu->setMeetParentAuditorName($o_stu_wechat->getName(0));
	    $o_stu->setMeetParentItem(json_encode($a_result));
	    $o_stu->setMeetParentRemark($this->getPost ( 'Remark' ));
		$o_stu->Save();
		//发送模板消息
		$o_admission_setup=new Admission_Setup(1);
		$o_system_setup=new Base_Setup(1);
		//获取幼儿关联的微信
		$o_wechat_user=new Student_Info_Wechat_Wiew();
		$o_wechat_user->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getStudentId()) );
		for($j=0;$j<$o_wechat_user->getAllCount();$j++)
		{
			//立即发送模板消息
		}	    
	   	$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'meet_parent_search_success.php"');
	}
	public function OnboardBinding($n_uid)
	{
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		//验证输入的信息是否合法
		if ($this->getPost ( 'Name' )=='')$this->ReturnMsg('幼儿信息的 [幼儿姓名] 不能为空！','Name');
		if ($this->getPost ( 'ID' )=='')$this->ReturnMsg('幼儿信息的 [证件号码] 不能为空！','ID');
		if ($this->getPost ( 'JhName' )=='')$this->ReturnMsg('家长信息的 [姓名] 不能为空！','JhName');
		if ($this->getPost ( 'JhPhone' )=='')$this->ReturnMsg('家长信息的 [手机号] 不能为空！','JhPhone');
		//验证幼儿信息是否正确
		$o_stu=new Student_Onboard_Info();
		$o_stu->PushWhere ( array ('&&', 'Name', '=',$this->getPost ( 'Name' )) ); 
		$o_stu->PushWhere ( array ('&&', 'IdType', '=',$this->getPost ( 'IdType' )) ); 
		$o_stu->PushWhere ( array ('&&', 'Id', '=',$this->getPost ( 'ID' )) ); 
		if ($o_stu->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'对不起，幼儿信息不存在，请修改后重新输入！\');' );
		}
		//验证家长信息
		if($o_stu->getJh1Name(0)!=$this->getPost ( 'JhName' ) || $o_stu->getJh1Phone(0)!=$this->getPost ( 'JhPhone' ))
		{
			if($o_stu->getJh2Name(0)!=$this->getPost ( 'JhName' ) || $o_stu->getJh2Phone(0)!=$this->getPost ( 'JhPhone' ))
			{
				$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'对不起，家长姓名或手机不匹配，请核实后重新输入！\');' );
			}			
		}
		//开始绑定
		$o_user_wechat=new WX_User_Info($n_uid);
		$o_user_wechat->setUserName($this->getPost ( 'JhName' ));
		$o_user_wechat->setPhone($this->getPost ( 'JhPhone' ));
		$o_user_wechat->Save();
		//开始写入绑定数据库
		//先查找是否已经绑定过
		$o_onboard_wechat=new Student_Onboard_Info_Wechat();
		$o_onboard_wechat->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getStudentId(0)) ); 
		$o_onboard_wechat->PushWhere ( array ('&&', 'UserId', '=',$n_uid) ); 
		if ($o_onboard_wechat->getAllCount()>0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Message(\'对不起，此微信已经绑定过该幼儿，请更换！\');' );
		}
		//写入绑定
		$o_onboard_wechat=new Student_Onboard_Info_Wechat();
		$o_onboard_wechat->setStudentId($o_stu->getStudentId(0));
		$o_onboard_wechat->setUserId($n_uid);
		$o_onboard_wechat->Save();
		//修改用户分组
		require_once RELATIVITY_PATH . 'sub/wechat/include/userGroup.class.php';
		$o_group = new userGroup();
		$o_group->updateGroup($o_user_wechat->getOpenId(), $this->getWechatSetup('PARENTGROUP'));
		//发送绑定成功通知
		require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';		    
		$o_token=new accessToken();
		$curlUtil = new curlUtil();
		$s_url='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$o_token->access_token;
		$data = array(
		    	'touser' => $o_user_wechat->getOpenId(), // openid是发送消息的基础
				'template_id' => $this->getWechatSetup('MSGTMP_08'), // 模板id
				'url' => '', // 点击跳转地址
				'topcolor' => '#FF0000', // 顶部颜色
				'data' => array(
					'first' => array('value' => '您的微信已经绑定在园幼儿“'.$o_stu->getName(0).'”。
'),
					'keyword1' => array('value' => $o_user_wechat->getUserName(),'color'=>'#173177'),
					'keyword2' => array('value' => $o_user_wechat->getNickname(),'color'=>'#173177'),
					'keyword3' => array('value' => $this->GetDateNow(),'color'=>'#173177'),
					'remark' => array('value' => '')
				)
				);
		$curlUtil->https_request($s_url, json_encode($data));
	   	$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'onboard_binding_success.php"');
	}
	public function ParentSurveyAnswer($n_uid)
	{
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
		$o_survey=new Survey($this->getPost ( 'Id' ));
		//判断用户是否已经做过此问卷
		$o_answer=new Survey_Answers();
		$o_answer->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) ); 
		$o_answer->PushWhere ( array ('&&', 'UserId', '=',$n_uid) );
		$o_answer->PushWhere ( array ('&&', 'StudentId', '=',$this->getPost ( 'StudentId' )) );
		if ($o_answer->getAllCount()>0)
		{
			//已经答题，跳转到完成页面
			$this->setReturn ( "parent.location.href='".$this->getPost ( 'Url' )."survey_answer_completed.php';" );
		}
		//检查问卷状态
		if($o_survey->getState()=='2')
		{
			//跳转到结束页面
			$this->setReturn ( "parent.location.href='".$this->getPost ( 'Url' )."survey_answer_end.php';" );
		}
		if($o_survey->getState()!='1')
		{
			//非法访问
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1001]\');' );
		}
		//检查微信用户是否有权限访问此问卷
		$o_stu=new Student_Onboard_Info_Class_Wechat_View();
		$o_stu->PushWhere ( array ('&&', 'UserId', '=',$n_uid) ); 
		$o_stu->getAllCount();
		$o_role=new Survey();
		$o_role->PushWhere ( array ('&&', 'Id', '=',$o_survey->getId()) ); 
		$o_role->PushWhere ( array ('&&', 'TargetList', 'like','%"'.$o_stu->getClassNumber(0).'"%') );
		if ($o_stu->getAllCount()==0 || $o_role->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！错误代码：[1002]\');' );
			exit(0);
		}
		//开始记录核验选项
	    $o_question=new Survey_Questions();
	    $o_question->PushWhere ( array ('&&', 'SurveyId', '=',$o_survey->getId()) ); 
	    $o_question->PushOrder ( array ('Number','A') );   
	    $a_question_result=array();
	    for($i=0;$i<$o_question->getAllCount();$i++)
	    {
	    	if ($o_question->getType($i)==1)
	    	{
	    		//单选
	    		if ($this->getPost('Question_'.$o_question->getId($i))=='')
	    		{
	    			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'“第'.$o_question->getNumber($i).'题”未作答！\');' );
	    		}
	    		array_push($a_question_result,$o_question->getId($i));
	    	}elseif ($o_question->getType($i)==2){
	    		//多选
	    		$a_temp=array();
	    		$o_option=new Survey_Options();
	    		$o_option->PushWhere ( array ('&&', 'QuestionId', '=',$o_question->getId($i)) ); 
	    		$o_option->PushOrder ( array ('Number','A') ); 
	    		for($j=0;$j<$o_option->getAllCount();$j++)
	    		{
	    			if ($this->getPost('Option_'.$o_option->getId($j))=='on')
	    			{
	    				array_push($a_temp, $o_option->getId($j));
	    			}
	    		}
	    		if (count($a_temp)==0)
	    		{
	    			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'“第'.$o_question->getNumber($i).'题”未作答！\');' );
	    		}
	    		array_push($a_question_result,$a_temp);
	    	}else{
	    		//简述
	    		if ($this->getPost('Question_'.$o_question->getId($i))=='')
	    		{
	    			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'“第'.$o_question->getNumber($i).'题”未作答！\');' );
	    		}
	    		array_push($a_question_result,rawurlencode($this->getPost('Question_'.$o_question->getId($i))));
	    	}
	    }
		//开始保存至答案。
		$o_answer=new Survey_Answers();
		$o_answer->setSurveyId($o_survey->getId());
		$o_answer->setUserId($n_uid);
		$o_answer->setStudentId($o_stu->getStudentId(0));
		$o_answer->setName($o_stu->getName(0));
		$o_answer->setSex($o_stu->getSex(0));
		$o_answer->setIdType($o_stu->getIdType(0));
		$o_answer->setCardId($o_stu->getId(0));
		$o_answer->setClassName($o_stu->getClassName(0));
		$o_answer->setUserName($o_stu->getUserName(0));
		$o_answer->setDate($this->GetDateNow());
		//根据循环结果，保存答案
		$n_column=1;
		for($i=0;$i<count($a_question_result);$i++)
		{
			eval('$o_answer->setAnswer'.$n_column.'(json_encode($a_question_result[$i]));');
			$n_column++;
		}
		if ($o_answer->Save()==false)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，服务器忙，请重试！\');' );
		}
		$this->setReturn ( "parent.location.href='".$this->getPost ( 'Url' )."survey_answer_completed.php';" );
	}
}
?>