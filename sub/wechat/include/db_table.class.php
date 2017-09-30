<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
/**
 * 活动表
 * SceneID是场景id，用来区别二维码的
 * */
class WX_Activity extends CRUD{
   protected $Id;
   protected $SceneId;
   protected $SceneName;
   protected $QrCode;
   protected $MessageType;
   protected $MessageUrl;
   protected $PicUrl;
   protected $Description;
   protected $ExpiryDate;
   protected $ActivityDate;
   protected $Title;
   protected $GroupId;
   protected $Address;
   protected $Location;
   protected $ActivityTime;
   protected $Week;
   protected $Type;
   protected $RegFirst;
   protected $RegRemark;
   protected $AuditPassFirst;
   protected $AuditPassRemark;
   protected $AuditFailFirst;
   protected $AuditFailRemark;
   protected $RemFirst;
   protected $RemRemark;
   protected $NeedAudit;
   protected $Visited;
   protected $LibraryId;

   protected function DefineKey(){
      return 'id';
   }
   protected function DefineTableName(){
      return 'wechat_wx_activity';
   }
   
   protected function DefineRelationMap(){
      return(array('id' => 'Id',
      			   'scene_id' => 'SceneId',
      			   'scene_name' => 'SceneName',
      			   'qr_code' => 'QrCode',
      			   'message_type' => 'MessageType',
            	   'message_url' => 'MessageUrl',
      			   'pic_url' => 'PicUrl',
      			   'description' => 'Description',
      			   'expiry_date' => 'ExpiryDate',
      				'activity_date' => 'ActivityDate',
     				 'group_id' => 'GroupId',
      			   'title' => 'Title',
      'location' => 'Location',
      'activity_time' => 'ActivityTime',
      'address' => 'Address',
      'week' => 'Week',
      'reg_first' => 'RegFirst',
      'reg_remark' => 'RegRemark',
      'audit_pass_first' => 'AuditPassFirst',
      'audit_pass_remark' => 'AuditPassRemark',
      'audit_fail_first' => 'AuditFailFirst',
      'audit_fail_remark' => 'AuditFailRemark',
      'rem_first' => 'RemFirst',
      'rem_remark' => 'RemRemark',
      'need_audit' => 'NeedAudit',
      'visited' => 'Visited',
      'library_id' => 'LibraryId',
      'type' => 'Type'
                   ));
   }
}

/**
 * 微信用户表
 * 
 * */
class WX_User_Activity extends CRUD{
   protected $Id;
   protected $ActivityId;
   protected $UserId;
   protected $SigninFlag;
   protected $AuditFlag;
   protected $OnsiteFlag;

   protected function DefineKey(){
      return 'id';
   }
   protected function DefineTableName(){
      return 'wechat_wx_user_activity';
   }
   
   protected function DefineRelationMap(){
      return(array('id' => 'Id',
      			   'activity_id' => 'ActivityId',
      			   'user_id' => 'UserId',
      			   'signin_flag' => 'SigninFlag',
      				'audit_flag' => 'AuditFlag',
      			   'onsite_flag' => 'OnsiteFlag'
                   ));
   }
	public function DeleteAll($n_uid)
	{
		$this->Execute ( 'DELETE FROM `wechat_wx_user_activity` WHERE `wechat_wx_user_activity`.`user_id`='.$n_uid );		
	}
}
class WX_User_Info extends CRUD{
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
	protected $Block;
	protected $Round;
	protected $SessionId;
	protected $GroupId;
	
	protected function DefineKey(){
      return 'id';
   	}
   	
   	protected function DefineTableName(){
   		return 'wechat_wx_user_info';
   	}
   	protected function DefineRelationMap(){
      	return(array('id' => 'Id',
      				'photo' => 'Photo',
		      	'nickname' => 'Nickname',
		      	'sex' => 'Sex',
      			'user_name' => 'UserName',
		      	'company' => 'Company',
		      	'dept_job' => 'DeptJob',
		      	'address' => 'Address',
		      	'openid' => 'OpenId',
		      	'phone' => 'Phone',
      	'session_id' => 'SessionId',
		      	'email' => 'Email',
      	'block' => 'Block',
		      	'register_date' => 'RegisterDate',
      	    'round' => 'Round',
      	'group_id' => 'GroupId',
		      	'del_flag' => 'DelFlag'
               ));
    }
}
class WX_User_Info_Temp extends CRUD{
	protected $Id;
	protected $UserName;
	protected $Company;
	protected $DeptJob;
	protected $Phone;
	protected $Email;
	protected $Type;
	protected $ActivityId;
	protected $SigninFlag;
	
	protected function DefineKey(){
      return 'id';
   	}
   	
   	protected function DefineTableName(){
   		return 'wechat_wx_user_info_temp';
   	}
   	protected function DefineRelationMap(){
      	return(array('id' => 'Id',
      			'user_name' => 'UserName',
      			'type' => 'Type',
      			'activity_id' => 'ActivityId',
		      	'company' => 'Company',
		      	'dept_job' => 'DeptJob',
		      	'phone' => 'Phone', 
      			'signin_flag' => 'SigninFlag',
		      	'email' => 'Email'
               ));
    }
}
class WX_User_Group extends CRUD{
	protected $Id;
	protected $GroupId;
	protected $UserId;
	
	protected function DefineKey(){
      return 'id';
   	}
   	
   	protected function DefineTableName(){
   		return 'wechat_wx_user_group';
   	}
   	protected function DefineRelationMap(){
      	return(array('id' => 'Id',
      				'group_id' => 'GroupId',
		      	'user_id' => 'UserId'
               ));
    }
	public function DelGroup($n_id)
	{
		$this->Execute ( 'DELETE FROM `wechat_wx_user_group` WHERE `wechat_wx_user_group`.`group_id`='.$n_id );		
	}
}
/**
 * 微信AccessToken表
 * 
 * */
class WX_Syscode extends CRUD{
	protected $Id;
	protected $SysToken;
	protected $CreateDate;
	protected $Date;
	
	protected function DefineKey(){
      return 'id';
   	}
   	
   	protected function DefineTableName(){
   		return 'wechat_wx_syscode';
   	}
   	
   	protected function DefineRelationMap(){
      	return(array('id' => 'Id',
      			     'sys_token' => 'SysToken',
      	'date' => 'Date',
      				 'create_date' => 'CreateDate'
               ));
    }
}

/**
 * 微信分组表
 * 
 * */
class WX_Group extends CRUD{
	protected $Id;
	protected $GroupId;
	protected $GroupName;
	
	protected function DefineKey(){
      return 'id';
   	}
   	
   	protected function DefineTableName(){
   		return 'wechat_wx_group';
   	}
   	
   	protected function DefineRelationMap(){
      	return(array('id' => 'Id',
      			     'group_id' => 'GroupId',
      				 'group_name' => 'GroupName'
               ));
    }
}
class WX_User_Blacklist extends CRUD{
	protected $Id;
	protected $OpenId;
	protected $Date;
	
	protected function DefineKey(){
      return 'id';
   	}
   	
   	protected function DefineTableName(){
   		return 'wechat_wx_user_blacklist';
   	}
   	
   	protected function DefineRelationMap(){
      	return(array('id' => 'Id',
      			     'open_id' => 'OpenId',
      				 'date' => 'Date'
               ));
    }
}
class WX_User_Activity_Join extends CRUD{
	protected $Id;
	protected $ActivityId;
	protected $UserId;
	protected $Round1;
	protected $Success1;
	protected $Answer1;
	protected $Scan1;
	protected $ScanSum1;
	protected $Round2;
	protected $Success2;
	protected $Answer2;
	protected $Round3;
	protected $Success3;
	protected $Answer3;
	protected $Round4;
	protected $Success4;
	protected $Answer4;
	protected $Round5;
	protected $Success5;
	protected $Answer5;
	
	protected function DefineKey(){
      return 'id';
   	}
   	
   	protected function DefineTableName(){
   		return 'wechat_wx_user_activity_join';
   	}
   	protected function DefineRelationMap(){
      	return(array('id' => 'Id',
      				'activity_id' => 'ActivityId',
		      	'user_id' => 'UserId',
		      	'round1' => 'Round1',
      			'success1' => 'Success1',
      	'answer1' => 'Answer1',
      	'scan1' => 'Scan1',
      	'scan_sum1' => 'ScanSum1',
		      	'round2' => 'Round2',
		      	'success2' => 'Success2',
      	'answer2' => 'Answer2',
		      	'round3' => 'Round3',
		      	'success3' => 'Success3',
      	'answer3' => 'Answer3',
		      	'round4' => 'Round4',
		      	'success4' => 'Success4',
      	'answer4' => 'Answer4',
      			'round5' => 'Round5',
		      	'success5' => 'Success5',
		      	'answer5' => 'Answer5'
               ));
    }
}
class WX_User_Activity_Join_Uploadphoto extends CRUD{
	protected $Id;
	protected $UserId;
	protected $Path;
	protected $Date;
	
	protected function DefineKey(){
      return 'id';
   	}
   	
   	protected function DefineTableName(){
   		return 'wechat_wx_user_activity_join_uploadphoto';
   	}
   	protected function DefineRelationMap(){
      	return(array('id' => 'Id',
		      	'user_id' => 'UserId',
		      	'path' => 'Path',
      			'date' => 'Date'
               ));
    }
}
class WX_Library extends CRUD{
	
   protected $Id;
   protected $MessageType;
   protected $MessageUrl;
   protected $PicUrl;
   protected $Description;
   protected $Title;
   protected $Content;
   protected $MediaId;
   
   protected function DefineKey(){
      return 'id';
   }
   protected function DefineTableName(){
      return 'wechat_wx_library';
   }
   protected function DefineRelationMap(){
      return(array('id' => 'Id',
      			   'message_type' => 'MessageType',
      			   'message_url' => 'MessageUrl',
      			   'pic_url' => 'PicUrl',
      			   'description' => 'Description',
      			   'title' => 'Title',
      			   'media_id' => 'MediaId',
      			   'content' => 'Content'
                   ));
   }
}
class WX_Keyword extends CRUD{
	
   protected $Id;
   protected $GroupId;
   protected $Key;
   protected $LibraryId;
   
   protected function DefineKey(){
      return 'id';
   }
   protected function DefineTableName(){
      return 'wechat_wx_keyword';
   }
   protected function DefineRelationMap(){
      return(array('id' => 'Id',
      			   'group_id' => 'GroupId',
      			   'key' => 'Key',
      			   'library_id' => 'LibraryId'
                   ));
   }
}
class WX_Menu extends CRUD{
	
   protected $Id;
   protected $Name;
   protected $Type;
   protected $LibraryId;
   protected $Url;
   protected $Number;
   protected $GroupId;
   protected $HaveSub;
   
   protected function DefineKey(){
      return 'id';
   }
   protected function DefineTableName(){
      return 'wechat_wx_menu';
   }
   protected function DefineRelationMap(){
      return(array('id' => 'Id',
      			   'name' => 'Name',
      			   'type' => 'Type',
      			   'library_id' => 'LibraryId',
      			   'url' => 'Url',
      			   'number' => 'Number',
      			   'group_id' => 'GroupId',
      			   'have_sub' => 'HaveSub'
                   ));
   }
}
class WX_Menu_Sub extends CRUD{
	
   protected $Id;
   protected $Name;
   protected $Type;
   protected $LibraryId;
   protected $Url;
   protected $Number;
   protected $ParentId;
   
   protected function DefineKey(){
      return 'id';
   }
   protected function DefineTableName(){
      return 'wechat_wx_menu_sub';
   }
   protected function DefineRelationMap(){
      return(array('id' => 'Id',
      			   'name' => 'Name',
      			   'type' => 'Type',
      			   'library_id' => 'LibraryId',
      			   'url' => 'Url',
      			   'number' => 'Number',
      			   'parent_id' => 'ParentId'
                   ));
   }
}
class Wechat_Wx_User_Reminder_View extends CRUD
{
    protected $Id;
    protected $UserId;
    protected $CreateDate;
    protected $SendDate;
    protected $MsgId;
    protected $OpenId;
    protected $ActivityId;
    protected $Send;
    protected $First;
    protected $Keyword1;
    protected $Keyword2;
    protected $Keyword3;
    protected $Keyword4;
    protected $Keyword5;
    protected $Remark;
    protected $Nickname;
    protected $Sex;
    protected $UserName;
    protected $Company;
    protected $DeptJob;
    protected $Address;
    protected $Phone;
    protected $SessionId;
    protected $RegisterDate;
    protected $Url;
    protected $KeywordSum; 

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_wx_user_reminder_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'user_id' => 'UserId',
                    'create_date' => 'CreateDate',
                    'send_date' => 'SendDate',
                    'msg_id' => 'MsgId',
                    'open_id' => 'OpenId',
                    'activity_id' => 'ActivityId',
                    'send' => 'Send',
                    'first' => 'First',
                    'keyword1' => 'Keyword1',
                    'keyword2' => 'Keyword2',
                    'keyword3' => 'Keyword3',
                    'keyword4' => 'Keyword4',
                    'keyword5' => 'Keyword5',
                    'remark' => 'Remark',
                    'nickname' => 'Nickname',
                    'sex' => 'Sex',
                    'user_name' => 'UserName',
                    'company' => 'Company',
                    'dept_job' => 'DeptJob',
                    'address' => 'Address',
                    'phone' => 'Phone',
                    'session_id' => 'SessionId',
                    'register_date' => 'RegisterDate',
        			'url' => 'Url',
                    'keyword_sum' => 'KeywordSum'
        ));
    }
}
class Wechat_Wx_Setup extends CRUD
{
    protected $Key;
    protected $Value;
    protected $Explain;

    protected function DefineKey()
    {
        return 'key';
    }
    protected function DefineTableName()
    {
        return 'wechat_wx_setup';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'key' => 'Key',
                    'value' => 'Value',
                    'explain' => 'Explain'
        ));
    }
}
class Wechat_Wx_User_Reminder extends CRUD
{
    protected $Id;
    protected $UserId;
    protected $CreateDate;
    protected $SendDate;
    protected $MsgId;
    protected $OpenId;
    protected $ActivityId;
    protected $Send;
    protected $First;
    protected $Keyword1;
    protected $Keyword2;
    protected $Keyword3;
    protected $Keyword4;
    protected $Keyword5;
    protected $Remark;
    protected $Url;
    protected $KeywordSum;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_wx_user_reminder';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'user_id' => 'UserId',
                    'create_date' => 'CreateDate',
                    'send_date' => 'SendDate',
                    'msg_id' => 'MsgId',
                    'open_id' => 'OpenId',
                    'activity_id' => 'ActivityId',
                    'send' => 'Send',
                    'first' => 'First',
                    'keyword1' => 'Keyword1',
                    'keyword2' => 'Keyword2',
                    'keyword3' => 'Keyword3',
                    'keyword4' => 'Keyword4',
                    'keyword5' => 'Keyword5',
                    'remark' => 'Remark',
        			'url' => 'Url',
                    'keyword_sum' => 'KeywordSum'
        ));
    }
}
class Wechat_Wx_User_Leavemsg extends CRUD
{
    protected $Id;
    protected $UserId;
    protected $Comment;
    protected $Date;
    protected $IsReply;
    protected $Type;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_wx_user_leavemsg';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'user_id' => 'UserId',
                    'comment' => 'Comment',
                    'date' => 'Date',
        			'type' => 'Type',
                    'is_reply' => 'IsReply'
        ));
    }
}
class Wechat_Wx_User_Leavemsg_View extends CRUD
{
    protected $Id;
    protected $UserId;
    protected $Photo;
    protected $Nickname;
    protected $Sex;
    protected $Openid;
    protected $SessionId;
    protected $Comment;
    protected $Date;
    protected $IsReply;
    protected $Type;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_wx_user_leavemsg_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'user_id' => 'UserId',
                    'photo' => 'Photo',
                    'nickname' => 'Nickname',
                    'sex' => 'Sex',
                    'openid' => 'Openid',
                    'session_id' => 'SessionId',
                    'comment' => 'Comment',
                    'date' => 'Date',
        			'type' => 'Type',
                    'is_reply' => 'IsReply'
        ));
    }
}
class Wechat_Wx_User_Leavemsg_Reply extends CRUD
{
    protected $Id;
    protected $MsgId;
    protected $Uid;
    protected $Date;    
    protected $Comment;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_wx_user_leavemsg_reply';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'msg_id' => 'MsgId',
                    'uid' => 'Uid',
                    'date' => 'Date',
                    'comment' => 'Comment'
        ));
    }
}
class Wechat_Wx_User_Leavemsg_Reply_View extends CRUD
{
    protected $Id;
    protected $MsgId;
    protected $Uid;
    protected $Username;
    protected $Date;
    protected $Comment;
    protected $Photo;
    protected $Name;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_wx_user_leavemsg_reply_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'msg_id' => 'MsgId',
                    'uid' => 'Uid',
                    'username' => 'Username',
                    'date' => 'Date',
                    'comment' => 'Comment',
                    'photo' => 'Photo',
                    'name' => 'Name'
        ));
    }
}
class Wechat_Wx_User_Leavemsg_Onboard_View extends CRUD
{
    protected $Id;
    protected $UserId;
    protected $StudentId;
    protected $ClassId;
    protected $StudentName;
    protected $StudentSex;
    protected $ClassName;
    protected $Comment;
    protected $Date;
    protected $Type;
    protected $IsReply;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_wx_user_leavemsg_onboard_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'user_id' => 'UserId',
                    'student_id' => 'StudentId',
                    'class_id' => 'ClassId',
                    'student_name' => 'StudentName',
                    'student_sex' => 'StudentSex',
                    'class_name' => 'ClassName',
                    'comment' => 'Comment',
                    'date' => 'Date',
        			'type' => 'Type',
                    'is_reply' => 'IsReply'
        ));
    }
}
?>