<?php
//error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
class Operate extends Bn_Basic {
	public function Login()
	{
		sleep(1);
		$o_user = new Single_User();
		$o_user->LoginIn($this->getPost('UserName'), $this->getPost('Password'));
	}
	public function GetSysInfo($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User($n_uid);
		$o_setup=new Base_Setup(1);
		$a_result = array (
					'title' =>$o_setup->getSystemName(), 
					'username' => $o_user->getUserName(),
		   			'name' => $o_user->getName(),
					'photo' => $o_user->getPhoto(),
					'footer' => $o_setup->getFooter()
				);
		echo(json_encode ($a_result));
	}
	public function GetSysMsgNum($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_msg=new Base_System_Msg();
		$o_msg->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
		$o_msg->PushWhere ( array ('&&', 'IsRead', '=', 0 ) );
		$n_count = $o_msg->getAllCount ();
		$a_result = array (
					'number' =>$n_count
				);
		echo(json_encode ($a_result));
	}
	public function SetShowNavIcon($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_setup=new Base_User_Info($n_uid);
		$o_setup->setShowNavIcon($this->getPost('val'));
		$o_setup->Save();
	}
	public function GetSysMsg($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_msg=new Base_System_Msg();
		$o_msg->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
		$o_msg->PushOrder ( array ('CreateDate', 'D' ) );
		$n_count = $o_msg->getAllCount ();
		$a_result=array();
		for($i=0;$i<$n_count;$i++)
		{
			if ($o_msg->getIsRead($i)==0)
			{
				//设置成已读
				$o_temp=new Base_System_Msg($o_msg->getId($i));
				$o_temp->setIsRead(1);
				$o_temp->setReadDate($this->GetDateNow());
				$o_temp->Save();
			}
			$a_temp = array (
					'date' =>$o_msg->getCreateDate($i),
					'text' =>$o_msg->getText($i),
					'isread' =>$o_msg->getIsRead($i),
					'id' =>$o_msg->getId($i)
				);
			array_push($a_result,$a_temp);
		}
		echo(json_encode ($a_result));
	}
	
	public function SysMsgDelete($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_msg=new Base_System_Msg($this->getPost('id'));
		if ($o_msg->getUid()==$n_uid)
		{
			//验证是否是本人的消息
			$o_msg->Deletion();
		}
	}
	public function SysMsgDeleteAll($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_msg=new Base_System_Msg();
		$o_msg->DeleteAll($n_uid);
	}
	public function GetNav($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$a_data=array();
		$n_modelid=$this->getPost('id');
		$a_model=array();
		$n_parentid=0;
		//计算当前模块的根模块ID
		if($n_modelid>0)
		{
			$o_current=new Base_Module($n_modelid);
			if ($o_current->getParentModuleId()>0)
			{
				$o_current2=new Base_Module($o_current->getParentModuleId());
				if($o_current2->getParentModuleId()>0)
				{
					$n_parentid=$o_current2->getParentModuleId();
				}else{
					$n_parentid=$o_current->getParentModuleId();
				}
			}else{
				$n_parentid=$n_modelid;
			}
		}
		//获取所有根模块
		$o_model = new View_User_Right ();
		$o_model->PushWhere ( array ('&&', 'Uid', '=',$n_uid ) );
		$o_model->PushWhere ( array ('&&', 'ParentModuleId', '=', 0 ) );
		$o_model->PushOrder ( array ('Module', 'A' ) );
		$n_count=$o_model->getAllCount();
		for($i=0;$i<$n_count;$i++)
		{
			$n_wait='';
			array_push($a_model, $o_model->getModuleId ( $i ));
			$n_active=0;
			if($n_parentid==$o_model->getModuleId ( $i ))
			{
				$n_active=1;//设置一个高亮值，javascript
			}
			//显示提醒数字图标
			if ($o_model->getWaitReadTable ( $i ) != '') {
				eval ( 'require_once RELATIVITY_PATH . \'' . str_replace('index.php', '', $o_model->getPath ( $i )) . 'include/ajax_operate.class.php\';' );
				eval ( '$o_operate=new Operate_'.$o_model->getWaitReadTable ( $i ).'();' );
				$n_wait=$o_operate->getWaitRead($n_uid);
				if ($n_wait==0)
				{
					$n_wait='';
				}
			}
			//循环模块信息
			$a_temp = array (
					'name' =>$o_model->getModuleName ( $i ).'<div class="badge sss_nav_number" >'.$n_wait.'</div>',
					'path' =>$o_model->getPath( $i ),
					'active' =>$n_active,
					'icon' =>$o_model->getIconPathB ( $i )
				);
			array_push($a_data,$a_temp);
		}
		for($k = 1; $k <= 5; $k ++) {
			eval ( '$o_model = new View_User_Right_Sec' . $k . ' ();' );
			$o_model->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
			$o_model->PushWhere ( array ('&&', 'ParentModuleId', '=', 0 ) );
			$o_model->PushOrder ( array ('Module', 'A' ) );
			$n_count = $o_model->getAllCount ();
			for($i = 0; $i < $n_count; $i ++) {				
				if (in_array($o_model->getModuleId ( $i ), $a_model))
				{
					continue;
				}
				$n_wait='';
				array_push($a_model, $o_model->getModuleId ( $i ));
				$n_active=0;
				if($n_parentid==$o_model->getModuleId ( $i ))
				{
					$n_active=1;//设置一个高亮值，javascript
				}
				//显示提醒数字图标
				if ($o_model->getWaitReadTable ( $i ) != '') {
					eval ( 'require_once RELATIVITY_PATH . \'' . str_replace('index.php', '', $o_model->getPath ( $i )) . 'include/ajax_operate.class.php\';' );
					eval ( '$o_operate=new Operate_'.$o_model->getWaitReadTable ( $i ).'();' );
					$n_wait=$o_operate->getWaitRead($n_uid);
					if ($n_wait==0)
					{
						$n_wait='';
					}
				}
				//循环模块信息
				$a_temp = array (
						'name' =>$o_model->getModuleName ( $i ).' <div class="badge sss_nav_number">'.$n_wait.'</div>',
						'path' =>$o_model->getPath( $i ),
						'active' =>$n_active,
						'icon' =>$o_model->getIconPathB ( $i )
					);
				array_push($a_data,$a_temp);
			}
		}
		echo(json_encode ($a_data));
	}
	public function getSubPage($n_uid,$n_module_id){
		//如果用户ID=0，那么退出
		if ($n_uid==0)
		{
			echo ('<script type="text/javascript" src="'.RELATIVITY_PATH.'js/initialize.js"></script><script type="text/javascript">goto_login()</script>');
			exit (0);
		}
		$s_url='';
		//获得本模块下第一个子模块的链接地址
		$o_module = new Base_Module ( $n_module_id);
		$o_userModule = new View_User_Right ();
		$o_userModule->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
		$o_userModule->PushWhere ( array ('&&', 'ParentModuleId', '=', $n_module_id ) );
		$o_userModule->PushOrder ( array ('Module', 'A' ) );
		$n_count = $o_userModule->getAllCount ();
		for($i = 0; $i < $n_count; $i ++) {
			$s_url=$o_userModule->getPath ( $i );
			break;
		}
		if($s_url!='')
		{
			return $s_url;
		}
		for($k = 1; $k <= 5; $k ++) {
			eval ( '$o_userModule = new View_User_Right_Sec' . $k . ' ();' );
			$o_userModule->PushWhere ( array ('&&', 'Uid', '=', $n_uid ) );
			$o_userModule->PushWhere ( array ('&&', 'ParentModuleId', '=', $n_module_id ) );
			$o_userModule->PushOrder ( array ('Module', 'A' ) );
			$n_count = $o_userModule->getAllCount ();
			for($i = 0; $i < $n_count; $i ++) {
				$s_url=$o_userModule->getPath ( $i );
				break;
			}
			if($s_url!='')
			{
				return $s_url;
			}
		}
		return $o_module->getPath();
	}
}

?>