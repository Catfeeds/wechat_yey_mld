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
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！\');' );
		}
		sleep(2);
		$o_setup=new Admission_Setup(1); 
		$o_date = new DateTime('Asia/Chongqing');
		$s_date=$o_date->format('Y') . '-' . $o_date->format('m') . '-' . $o_date->format('d');
		if (strtotime($s_date)<strtotime($o_setup->getSignupStart()))
		{
			$this->ReturnMsg('报名开始时间为：'.$o_setup->getSignupStart().' ，请在有效日期内进行报名，谢谢合作。','Name');
		}
		if (strtotime($s_date)>strtotime($o_setup->getSignupEnd()))
		{
			$this->ReturnMsg('对不起，报名结束时间为：'.$o_setup->getSignupStart().' ，谢谢合作。','Name');
		}
		$o_stu=new Student_Info();
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
	    	'touser' => $o_parent->getOpenId, // openid是发送消息的基础
			'template_id' => 'L8T0fmVRo37YWdRIm1oUNbD_Fb2fNZAEIdI6iPDQdKA', // 模板id
			'url' => $o_sysinfo->getHomeUrl().'sub/wechat/parent_signup/signup_list.php', // 点击跳转地址
			'topcolor' => '#FF0000', // 顶部颜色
			'data' => array(
				'first' => array('value' => '尊敬的家长您好，您所报名的如下信息：'),
				'keyword1' => array('value' => $o_stu->getStudentId(),'color'=>'#173177'),
				'keyword2' => array('value' => $o_stu->getName(),'color'=>'#173177'),
				'keyword3' => array('value' => $o_stu->getIdType(),'color'=>'#173177'),
				'keyword4' => array('value' => $o_stu->getId(),'color'=>'#173177'),
				'keyword5' => array('value' => $o_stu->getSignupDate(),'color'=>'#173177'),
				'remark' => array('value' => '我们已收到，请您耐心等待下一步提示，谢谢。
				
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
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！\');' );
		}
		//验证是否为本微信用户
		$o_stu_wechat=new Student_Info_Wechat();
		$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$n_uid) ); 
		$o_stu_wechat->PushWhere ( array ('&&', 'StudentId', '=',$this->getPost ( 'id' )) ); 
		if($o_stu_wechat->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！\');' );
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
	   	$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Success(\'修改报名信息成功！\',function(){parent.location="'.$this->getPost ( 'Url' ).'my_signup.php"})');
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
			$o_stu_wechat=new Student_Info_Wechat($o_stu_wechat->getId(0));
			$o_stu_wechat->Deletion();
			//再删除幼儿信息
			$o_sut_info=new Student_Info($this->getPost ( 'id' ));
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
		    $o_stu->setOnly('是');
		    $o_stu->setOnlyCode('');
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
	    $o_stu->setJh1Job('');
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
		    $o_stu->setJh2Job('');		    
		    if ($this->getPost ( 'Jh2Jiaoyu' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [教育程度] ！','Jh2Jiaoyu');
		    $o_stu->setJh2Jiaoyu($this->getPost ( 'Jh2Jiaoyu' ));
		    if ($this->getPost ( 'Jh2Danwei' )=='')$this->ReturnMsg('请选择第二法定监护人信息的 [工作单位全称] ！','Jh2Danwei');
		    $o_stu->setJh2Danwei($this->getPost ( 'Jh2Danwei' ));
		    $o_stu->setJh2Phone($this->getPost ( 'Jh2Phone' ));
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
			$o_stu->setJh2Phone('');
		    $o_stu->setJh2IsCanji('');
			$o_stu->setJh2CanjiCode('');
		}
		$o_stu->setJianhuConnection('');
		$o_stu->setJianhuName('');
	    $o_stu->setJianhuPhone('');
	    if ($this->getPost ( 'Jh1Phone' )=='')$this->ReturnMsg('报名联系方式的 [监护人手机号] 不能为空！','Jh1Phone');
	    $o_stu->setJh1Phone($this->getPost ( 'Jh1Phone' ));
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
		sleep(1);
		if ($n_uid>0)
		{
			
		}else{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！\');' );
		}
		//验证是否为绑定用户
		$o_stu_wechat=new Base_User_Wechat();
		$o_stu_wechat->PushWhere ( array ('&&', 'WechatId', '=',$n_uid) ); 
		if($o_stu_wechat->getAllCount()==0)
		{
			$this->setReturn ( 'parent.Common_CloseDialog();parent.Dialog_Error(\'对不起，操作错误，请与管理员联系！\');' );
		}
		$o_stu=new Student_Info($this->getPost ( 'StudentId' ));
		$o_stu->setState(2);
		$o_stu->Save();	
		//发送模板消息
		$o_admission_setup=new Admission_Setup(1);
		$o_system_setup=new Base_Setup(1);
		//获取幼儿关联的微信
		$o_wechat_user=new Student_Info_Wechat_Wiew();
		$o_wechat_user->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getStudentId()) );
		for($j=0;$j<$o_wechat_user->getAllCount();$j++)
		{
			/*
			//添加消息队列
			$o_msg=new Wechat_Wx_User_Reminder();
			$o_msg->setUserId($o_wechat_user->getUserId($j));
			$o_msg->setCreateDate($this->GetDateNow());
			$o_msg->setSendDate('0000-00-00');
			$o_msg->setMsgId('zyiBHFGE22XBtt4cmhaV7abYy9vOpUTNv_yvJr2U-ic');
			$o_msg->setOpenId('');
			$o_msg->setActivityId(0);
			$o_msg->setSend(0);
			$o_msg->setFirst('尊敬的幼儿家长您好，您所报名的幼儿：');
			$o_msg->setKeyword1($o_stu->getStudentId());
			$o_msg->setKeyword2($o_stu->getName());
			$o_msg->setKeyword3($o_admission_setup->getAuditDate());
			$o_msg->setKeyword4($o_admission_setup->getAuditTime());
			$o_msg->setKeyword5($o_admission_setup->getAuditAddress());
			$o_msg->setRemark('请您按照如上时段、地址进行信息核验，感谢您的配合。

如需查看您的幼儿报名信息，请点击详情
			');
			$o_msg->setKeywordSum(5);
			$o_msg->setUrl($o_system_setup->getHomeUrl().'sub/wechat/parent_signup/my_signup/php');
			$o_msg->Save();
			*/
		}	    
	   	$this->setReturn ( 'parent.location="'.$this->getPost ( 'Url' ).'audit_search_success.php"');
	}
	
}

?>