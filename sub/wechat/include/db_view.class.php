<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class View_WX_User_Info extends CRUD
{
	protected $Id;
	protected $Photo;
	protected $Nickname;
	protected $UserName;
	protected $Company;
	protected $DeptJob;
	protected $Address;
	protected $OpenId;
	protected $Phone;
	protected $Email;
	protected $RegisterDate;
	protected $DelFlag;
	protected $Sex;
	protected $ActivityId;
	protected $SigninFlag;
	protected $AuditFlag;
	protected $OnsiteFlag;
	protected $Round;
	protected $UserActivityId;
	
	protected function DefineKey(){
      return 'wechat_wx_user_info.id';
   	}
   	
   	protected function DefineTableName(){
   		return 'wechat_wx_user_info` INNER JOIN `wechat_wx_user_activity` ON `wechat_wx_user_info`.`id` = `wechat_wx_user_activity`.`user_id';
   	}
   	protected function DefineRelationMap(){
      	return(array('wechat_wx_user_info.id' => 'Id',
      				'wechat_wx_user_info.photo' => 'Photo',
		      	'wechat_wx_user_info.nickname' => 'Nickname',
		      	'wechat_wx_user_info.sex' => 'Sex',
      			'wechat_wx_user_info.user_name' => 'UserName',
		      	'wechat_wx_user_info.company' => 'Company',
		      	'wechat_wx_user_info.dept_job' => 'DeptJob',
		      	'wechat_wx_user_info.address' => 'Address',
		      	'wechat_wx_user_info.openid' => 'OpenId',
		      	'wechat_wx_user_info.phone' => 'Phone',
		      	'wechat_wx_user_info.email' => 'Email',
		      	'wechat_wx_user_info.register_date' => 'RegisterDate',
		      	'wechat_wx_user_info.del_flag' => 'DelFlag',
      			'wechat_wx_user_activity.audit_flag' => 'AuditFlag',
      			'wechat_wx_user_activity.signin_flag' => 'SigninFlag',
      			'wechat_wx_user_activity.onsite_flag' => 'OnsiteFlag',
      			'wechat_wx_user_activity.id' => 'UserActivityId',
      	        'wechat_wx_user_info.round' => 'Round',
      			'wechat_wx_user_activity.activity_id' => 'ActivityId'
               ));
    }
}

//1111111111111111111111111111111111111111111111
?>