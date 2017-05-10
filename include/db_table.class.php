<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Admission_Setup extends CRUD
{
    protected $Id;
    protected $DeptId;
    protected $SignupStart;
    protected $SignupEnd;
    protected $TuoSum;
    protected $XiaoSum;
    protected $ZhongSum;
    protected $DaSum;
    protected $BanriSum;
    protected $AuditDate;
    protected $AuditTime;
    protected $AuditAddress;
    protected $MeetDate;
    protected $MeetTime;
    protected $MeetAddress;
    protected $HealthTime;
    protected $HealthAddress;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'admission_setup';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'dept_id' => 'DeptId',
                    'signup_start' => 'SignupStart',
                    'signup_end' => 'SignupEnd',
                    'tuo_sum' => 'TuoSum',
                    'xiao_sum' => 'XiaoSum',
                    'zhong_sum' => 'ZhongSum',
                    'da_sum' => 'DaSum',
                    'banri_sum' => 'BanriSum',
                    'audit_date' => 'AuditDate',
                    'audit_time' => 'AuditTime',
                    'audit_address' => 'AuditAddress',
                    'meet_date' => 'MeetDate',
                    'meet_time' => 'MeetTime',
                    'meet_address' => 'MeetAddress',
                    'health_time' => 'HealthTime',
                    'health_address' => 'HealthAddress'
        ));
    }
}
class Admission_Time extends CRUD
{
    protected $Id;
    protected $Time;
    protected $Sum;
    protected $UseSum;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'admission_time';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'time' => 'Time',
                    'sum' => 'Sum',
                    'use_sum' => 'UseSum'
        ));
    }
	public function SumAdd1($n_id)
	{
		$this->Execute ( 'UPDATE `admission_time` SET `use_sum` = `use_sum` + 1 where `id`='.$n_id );		
	}
}
//1111111111111111111111111111111111111111111111
class Base_Dept extends CRUD
{
   protected $DeptId;
   protected $Name;
   protected $ParentId;
   protected $Number;
   protected $Phone;
   protected $Fax;
	protected $Address;
	protected $Type;
	protected $StudentSum;
	 
   protected function DefineKey()
   {
      return 'dept_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_dept';
   }
   protected function DefineRelationMap()
   {
      return(array('dept_id' => 'DeptId',
      							'name' => 'Name',
      							'parent_id' => 'ParentId',
      							'number' => 'Number',
     								'phone' => 'Phone',
      							'fax' => 'Fax',    
      'type' => 'Type',  
      'student_sum' => 'StudentSum',  
      'precent' => 'Precent',  
      							'address' => 'Address'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Module  extends CRUD
{
   protected $ModuleId;
   protected $Name;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $WaitReadTable;
    
   protected function DefineKey()
   {
      return 'module_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_module';
   }
   protected function DefineRelationMap()
   {
      return(array('module_id' => 'ModuleId',
      				'name' => 'Name',
      				'module' => 'Module',
      				'explain' => 'Explain',
     				'icon_id' => 'IconId',
      				'path' => 'Path',
      				'parent_module_id' => 'ParentModuleId',
                   	'mini_icon_id' => 'MiniIconId',
      				'wait_read_table' => 'WaitReadTable'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Module_Icon extends CRUD
{
   protected $IconId;
   protected $Path;

   protected function DefineKey()
   {
      return 'icon_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_module_icon';
   }
   protected function DefineRelationMap()
   {
      return(array('icon_id' => 'IconId',
                   'path' => 'Path'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Module_Icon_Mini extends CRUD
{
   protected $MiniIconId;
   protected $Path;

   protected function DefineKey()
   {
      return 'mini_icon_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_module_icon_mini';
   }
   protected function DefineRelationMap()
   {
      return(array('mini_icon_id' => 'MiniIconId',
                   'path' => 'Path'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Right extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;

   protected function DefineKey()
   {
      return 'right_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_right';
   }
   protected function DefineRelationMap()
   {
      return(array('right_id' => 'RightId',
                   'role_id' => 'RoleId',
                   'module_id' => 'ModuleId'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Role extends CRUD
{
   protected $RoleId;
   protected $Name;
   protected $Explain;
   protected $WechatGroupId;

   protected function DefineKey()
   {
      return 'role_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_role';
   }
   protected function DefineRelationMap()
   {
      return(array('role_id' => 'RoleId',
                   'name' => 'Name',
      			   'wechat_group_id' => 'WechatGroupId',
                   'explain' => 'Explain'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Setup extends CRUD
{
   protected $Id;
   protected $Version;
   protected $UpdateUrl;
   protected $SystemName;
   protected $Footer;
   protected $HomeUrl;
   protected $Logo;

   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_setup';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
      'version' => 'Version',
      'logo' => 'Logo',
      'update_url' => 'UpdateUrl',
      'system_name' => 'SystemName',
      'footer' => 'Footer',
      'home_url' => 'HomeUrl'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_System_Msg extends CRUD
{
   protected $Id;               
   protected $Uid;          
   protected $Text;     
   protected $CreateDate;
   protected $IsShow;         
   protected $IsRead;
   protected $ReadDate;

   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_system_msg';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',               
                   'uid' => 'Uid',          
                   'text' => 'Text',          
                   'create_date' => 'CreateDate',
                   'is_show' => 'IsShow',         
                   'is_read' => 'IsRead',
                   'read_date' => 'ReadDate'
                   ));
   }
	public function DeleteAll($n_uid)
	{
		$this->Execute ( 'DELETE FROM `wechat_base_system_msg` WHERE `wechat_base_system_msg`.`uid`='.$n_uid );		
	}
}

//1111111111111111111111111111111111111111111111
class Base_User extends CRUD
{
   protected $UserName;
   protected $Password;
   protected $State;
   protected $Uid;
   protected $RegIp;
   protected $RegTime;
   protected $Type;
   protected $Deleted;
   protected $ActivityId;

   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'username' => 'UserName',
                   'password' => 'Password',
                   'state' => 'State',
                   'reg_ip' => 'RegIp',
                   'reg_time' => 'RegTime',
      				'deleted' => 'Deleted',
      'activity_id' => 'ActivityId',
      			   'type' => 'Type',
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Desktop extends CRUD
{
   protected $Uid;
   protected $ModuleSort;

   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_desktop';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'module_sort' => 'ModuleSort'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Info extends CRUD
{
   protected $Uid;
   protected $Name;
   protected $Email;
   protected $Sex;
   protected $Phone;
   protected $DiskSpace;
   protected $ShowNavIcon;
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_info';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'name' => 'Name',
                   'email' => 'Email',
                   'sex' => 'Sex',
      			   'phone' => 'Phone',
      				'show_nav_icon' => 'ShowNavIcon',
      			   'disk_space' => 'DiskSpace'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Info_Custom extends CRUD
{
   protected $Uid;
   protected $Birthday;
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_info_custom';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'birthday' => 'Birthday',
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Login extends CRUD
{
   protected $Uid;
   protected $LastIp;
   protected $LastTime;
   protected $Online;
   protected $LoginTime;
   protected $OnlineTime;
   protected $UserAgent;
   protected $SessionId;
   protected $PassError;
   protected $LockTime;
      
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_login';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'last_ip' => 'LastIp',
                   'last_time' => 'LastTime',
                   'online' => 'Online',
                   'login_time' => 'LoginTime',
                   'online_time' => 'OnlineTime',
                   'user_agent' => 'UserAgent',
                   'session_id' => 'SessionId',
                   'pass_error' => 'PassError',
                   'lock_time' => 'LockTime'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Photo extends CRUD
{
   protected $Uid;
   protected $Path;
      
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_photo';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'path' => 'Path'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Picture extends CRUD
{
   protected $Id;
   protected $Uid;
   protected $Path;
   protected $Timecut;
   protected $Filesize;
      
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_picture';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
                   'uid' => 'Uid',
                   'path' => 'Path',
                   'timecut' => 'Timecut',
                   'filesize' => 'Filesize'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Group extends CRUD
{
   protected $GroupId;
   protected $Name;
   protected $Explain;
      
   protected function DefineKey()
   {
      return 'group_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_group';
   }
   protected function DefineRelationMap()
   {
      return(array('group_id' => 'GroupId',
                   'name' => 'Name',
                   'explain' => 'Explain'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Role extends CRUD
{
   protected $Uid;
   protected $DeptId;
   protected $RoleId;
   protected $SecRoleId1;
   protected $SecRoleId2;
   protected $SecRoleId3;
   protected $SecRoleId4;
   protected $SecRoleId5;
      
   protected function DefineKey()
   {
      return 'uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_role';
   }
   protected function DefineRelationMap()
   {
      return(array('uid' => 'Uid',
                   'dept_id' => 'DeptId',
                   'role_id' => 'RoleId',
                   'sec_role_id_1' => 'SecRoleId1',
                   'sec_role_id_2' => 'SecRoleId2',
                   'sec_role_id_3' => 'SecRoleId3',
                   'sec_role_id_4' => 'SecRoleId4',
                   'sec_role_id_5' => 'SecRoleId5'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_Cmcc extends CRUD
{
   protected $Id;
   protected $Phone;
   protected $Content;
   protected $Sended;
   protected $SendTime;
      
   protected function DefineKey()
   {
      return 'id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_cmcc';
   }
   protected function DefineRelationMap()
   {
      return(array('id' => 'Id',
                   'phone' => 'Phone',
                   'content' => 'Content',
                   'sended' => 'Sended',
                   'sendtime' => 'SendTime'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Base_User_Files  extends CRUD
{
   protected $FileId;
   protected $Filename;
   protected $Filesize;
   protected $Date;
   protected $Suffix;
   protected $Crc;
   protected $ShareUsername;
   protected $ShareUid;
   protected $Path;
   protected $Uid;
   protected $Delete;
   protected $KeyWord;
   protected $FolderId;
   protected $DeleteDate;
   protected $OriginalPath;
   protected $OriginalFilename;
	 
   protected function DefineKey()
   {
      return 'file_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_files';
   }
   protected function DefineRelationMap()
   {
      return(array( 'file_id' => 'FileId',
      				'filename' => 'Filename',
      				'filesize' => 'Filesize',
      				'date' => 'Date',
      				'suffix' => 'Suffix',
     				'crc' => 'Crc',
      				'share_username' => 'ShareUsername',
      				'share_uid' => 'ShareUid',
      				'path' => 'Path',
      				'uid' => 'Uid',
      				'delete' => 'Delete',
      				'key_word' => 'KeyWord',
      				'folder_id' => 'FolderId',
      				'delete_date' => 'DeleteDate',
      				'original_path' => 'OriginalPath',
      				'original_filename' => 'OriginalFilename'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class Student_Info extends CRUD
{
    protected $StudentId;
    protected $State;
    protected $Name;
    protected $Sex;
    protected $Birthday;
    protected $Nation;
    protected $Only;
    protected $OnlyCode;
    protected $IsFirst;
    protected $HCode;
    protected $HCity;
    protected $HArea;
    protected $HStreet;
    protected $HAdd;
    protected $Id;
    protected $IdType;
    protected $ZCity;
    protected $ZProperty;
    protected $ZArea;
    protected $ZStreet;
    protected $ZAdd;
    protected $Illness;
    protected $Allergic;
    protected $DeptId;
    protected $GradeNumber;
    protected $ClassNumber;
    protected $ClassNameDiy;
    protected $Jiudu;
    protected $Birthplace;
    protected $BirthplaceCode;
    protected $IdQuality;
    protected $IdQualityType;
    protected $SignupDate;
    protected $InTime;
    protected $OutTime;
    protected $IsLiushou;
    protected $IsWugong;
    protected $IsCanji;
    protected $CanjiType;
    protected $IsJisu;
    protected $IsGuer;
    protected $IsDibao;
    protected $DibaoCode;
    protected $IsZizhu;
    protected $Nationality;
    protected $Gangao;
    protected $IsLieshi;
    protected $CanjiCode;
    protected $Jiankang;
    protected $Xuexing;
    protected $IsYiwang;
    protected $IsShoushu;
    protected $Shoushu;
    protected $IsYizhi;
    protected $IsYichuan;
    protected $IsXiaochuan;
    protected $IsDianxian;
    protected $IsJingjue;
    protected $IsXinzangbing;
    protected $IsGuomin;
    protected $Qitabingshi;
    protected $Beizhu;
    protected $HShequ;
    protected $ZShequ;
    protected $ZSame;
    protected $HGuanxi;
    protected $ZOwner;
    protected $HOwner;
    protected $ZGuanxi;
    protected $Jh1Connection;
    protected $Jh1IsZhixi;
    protected $Jh1IsCanji;
    protected $Jh1Name;
    protected $Jh1Job;
    protected $Jh1Danwei;
    protected $Jh1CanjiCode;
    protected $Jh1IdType;
    protected $Jh1Jiaoyu;
    protected $Jh1Id;
    protected $Jh1Phone;
    protected $Jh2Connection;
    protected $Jh2IsZhixi;
    protected $Jh2IsCanji;
    protected $Jh2Name;
    protected $Jh2Job;
    protected $Jh2Danwei;
    protected $Jh2CanjiCode;
    protected $Jh2IdType;
    protected $Jh2Jiaoyu;
    protected $Jh2Id;
    protected $Jh2Phone;
    protected $JianhuConnection;
    protected $JianhuName;
    protected $JianhuPhone;
    protected $FlagThree;
    protected $FlagXicheng;
    protected $FlagSame;
    protected $FlagOnly;
    protected $FlagFirst;
    protected $HIsGroup;
    protected $HIsYizhi;
    protected $SignupPhone;
    protected $SignupPhoneBackup;
    protected $HospitalName;
    protected $ClassMode;
    protected $Compliance;
    protected $AuditorId;
    protected $AuditorName;
    protected $AuditRemark;
    protected $MeetAuditorId;
    protected $MeetAuditorName;
    protected $MeetItem;
    protected $MeetRemark;
    protected $MeetParentAuditorId;
    protected $MeetParentAuditorName;
    protected $MeetParentItem;
    protected $MeetParentRemark;

    protected function DefineKey()
    {
        return 'student_id';
    }
    protected function DefineTableName()
    {
        return 'student_info';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'student_id' => 'StudentId',
                    'state' => 'State',
                    'name' => 'Name',
                    'sex' => 'Sex',
                    'birthday' => 'Birthday',
                    'nation' => 'Nation',
                    'only' => 'Only',
                    'only_code' => 'OnlyCode',
                    'is_first' => 'IsFirst',
                    'h_code' => 'HCode',
                    'h_city' => 'HCity',
                    'h_area' => 'HArea',
                    'h_street' => 'HStreet',
                    'h_add' => 'HAdd',
                    'id' => 'Id',
                    'id_type' => 'IdType',
                    'z_city' => 'ZCity',
                    'z_property' => 'ZProperty',
                    'z_area' => 'ZArea',
                    'z_street' => 'ZStreet',
                    'z_add' => 'ZAdd',
                    'illness' => 'Illness',
                    'allergic' => 'Allergic',
                    'dept_id' => 'DeptId',
                    'grade_number' => 'GradeNumber',
                    'class_number' => 'ClassNumber',
                    'class_name_diy' => 'ClassNameDiy',
                    'jiudu' => 'Jiudu',
                    'birthplace' => 'Birthplace',
                    'birthplace_code' => 'BirthplaceCode',
                    'id_quality' => 'IdQuality',
                    'id_quality_type' => 'IdQualityType',
                    'signup_date' => 'SignupDate',
                    'in_time' => 'InTime',
                    'out_time' => 'OutTime',
                    'is_liushou' => 'IsLiushou',
                    'is_wugong' => 'IsWugong',
                    'is_canji' => 'IsCanji',
                    'canji_type' => 'CanjiType',
                    'is_jisu' => 'IsJisu',
                    'is_guer' => 'IsGuer',
                    'is_dibao' => 'IsDibao',
                    'dibao_code' => 'DibaoCode',
                    'is_zizhu' => 'IsZizhu',
                    'nationality' => 'Nationality',
                    'gangao' => 'Gangao',
                    'is_lieshi' => 'IsLieshi',
                    'canji_code' => 'CanjiCode',
                    'jiankang' => 'Jiankang',
                    'xuexing' => 'Xuexing',
                    'is_yiwang' => 'IsYiwang',
                    'is_shoushu' => 'IsShoushu',
                    'shoushu' => 'Shoushu',
                    'is_yizhi' => 'IsYizhi',
                    'is_yichuan' => 'IsYichuan',
                    'is_xiaochuan' => 'IsXiaochuan',
                    'is_dianxian' => 'IsDianxian',
                    'is_jingjue' => 'IsJingjue',
                    'is_xinzangbing' => 'IsXinzangbing',
                    'is_guomin' => 'IsGuomin',
                    'qitabingshi' => 'Qitabingshi',
                    'beizhu' => 'Beizhu',
                    'h_shequ' => 'HShequ',
                    'z_shequ' => 'ZShequ',
                    'z_same' => 'ZSame',
                    'h_guanxi' => 'HGuanxi',
                    'z_owner' => 'ZOwner',
                    'h_owner' => 'HOwner',
                    'z_guanxi' => 'ZGuanxi',
                    'jh_1_connection' => 'Jh1Connection',
                    'jh_1_is_zhixi' => 'Jh1IsZhixi',
                    'jh_1_is_canji' => 'Jh1IsCanji',
                    'jh_1_name' => 'Jh1Name',
                    'jh_1_job' => 'Jh1Job',
                    'jh_1_danwei' => 'Jh1Danwei',
                    'jh_1_canji_code' => 'Jh1CanjiCode',
                    'jh_1_id_type' => 'Jh1IdType',
                    'jh_1_jiaoyu' => 'Jh1Jiaoyu',
                    'jh_1_id' => 'Jh1Id',
                    'jh_1_phone' => 'Jh1Phone',
                    'jh_2_connection' => 'Jh2Connection',
                    'jh_2_is_zhixi' => 'Jh2IsZhixi',
                    'jh_2_is_canji' => 'Jh2IsCanji',
                    'jh_2_name' => 'Jh2Name',
                    'jh_2_job' => 'Jh2Job',
                    'jh_2_danwei' => 'Jh2Danwei',
                    'jh_2_canji_code' => 'Jh2CanjiCode',
                    'jh_2_id_type' => 'Jh2IdType',
                    'jh_2_jiaoyu' => 'Jh2Jiaoyu',
                    'jh_2_id' => 'Jh2Id',
                    'jh_2_phone' => 'Jh2Phone',
                    'jianhu_connection' => 'JianhuConnection',
                    'jianhu_name' => 'JianhuName',
                    'jianhu_phone' => 'JianhuPhone',
                    'flag_three' => 'FlagThree',
                    'flag_xicheng' => 'FlagXicheng',
                    'flag_same' => 'FlagSame',
                    'flag_only' => 'FlagOnly',
                    'flag_first' => 'FlagFirst',
                    'h_is_group' => 'HIsGroup',
                    'h_is_yizhi' => 'HIsYizhi',
                    'signup_phone' => 'SignupPhone',
                    'signup_phone_backup' => 'SignupPhoneBackup',
                    'hospital_name' => 'HospitalName',
                    'class_mode' => 'ClassMode',
                    'compliance' => 'Compliance',
                    'auditor_id' => 'AuditorId',
                    'auditor_name' => 'AuditorName',
                    'audit_remark' => 'AuditRemark',
                    'meet_auditor_id' => 'MeetAuditorId',
                    'meet_auditor_name' => 'MeetAuditorName',
                    'meet_item' => 'MeetItem',
                    'meet_remark' => 'MeetRemark',
                    'meet_parent_auditor_id' => 'MeetParentAuditorId',
                    'meet_parent_auditor_name' => 'MeetParentAuditorName',
                    'meet_parent_item' => 'MeetParentItem',
                    'meet_parent_remark' => 'MeetParentRemark'
        ));
    }
}
//1111111111111111111111111111111111111111111111

class Student_Info_Wechat extends CRUD
{
    protected $Id;
    protected $StudentId;
    protected $UserId;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'student_info_wechat';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'student_id' => 'StudentId',
                    'user_id' => 'UserId'
        ));
    }
}
class Student_Info_Wechat_Wiew extends CRUD
{
    protected $StudentId;
    protected $State;
    protected $Name;
    protected $Sex;
    protected $Birthday;
    protected $Nation;
    protected $Only;
    protected $OnlyCode;
    protected $IsFirst;
    protected $HCode;
    protected $HCity;
    protected $HArea;
    protected $HStreet;
    protected $HAdd;
    protected $Id;
    protected $IdType;
    protected $ZCity;
    protected $ZProperty;
    protected $ZArea;
    protected $ZStreet;
    protected $ZAdd;
    protected $Illness;
    protected $Allergic;
    protected $DeptId;
    protected $GradeNumber;
    protected $ClassNumber;
    protected $ClassNameDiy;
    protected $Jiudu;
    protected $Birthplace;
    protected $BirthplaceCode;
    protected $IdQuality;
    protected $IdQualityType;
    protected $SignupDate;
    protected $InTime;
    protected $OutTime;
    protected $IsLiushou;
    protected $IsWugong;
    protected $IsCanji;
    protected $CanjiType;
    protected $IsJisu;
    protected $IsGuer;
    protected $IsDibao;
    protected $DibaoCode;
    protected $IsZizhu;
    protected $Nationality;
    protected $Gangao;
    protected $IsLieshi;
    protected $CanjiCode;
    protected $Jiankang;
    protected $Xuexing;
    protected $IsYiwang;
    protected $IsShoushu;
    protected $Shoushu;
    protected $IsYizhi;
    protected $IsYichuan;
    protected $IsXiaochuan;
    protected $IsDianxian;
    protected $IsJingjue;
    protected $IsXinzangbing;
    protected $IsGuomin;
    protected $Qitabingshi;
    protected $Beizhu;
    protected $HShequ;
    protected $ZShequ;
    protected $ZSame;
    protected $HGuanxi;
    protected $ZOwner;
    protected $HOwner;
    protected $ZGuanxi;
    protected $Jh1Connection;
    protected $Jh1IsZhixi;
    protected $Jh1IsCanji;
    protected $Jh1Name;
    protected $Jh1Job;
    protected $Jh1Danwei;
    protected $Jh1CanjiCode;
    protected $Jh1IdType;
    protected $Jh1Jiaoyu;
    protected $Jh1Id;
    protected $Jh1Phone;
    protected $Jh2Connection;
    protected $Jh2IsZhixi;
    protected $Jh2IsCanji;
    protected $Jh2Name;
    protected $Jh2Job;
    protected $Jh2Danwei;
    protected $Jh2CanjiCode;
    protected $Jh2IdType;
    protected $Jh2Jiaoyu;
    protected $Jh2Id;
    protected $Jh2Phone;
    protected $JianhuConnection;
    protected $JianhuName;
    protected $JianhuPhone;
    protected $FlagThree;
    protected $FlagXicheng;
    protected $FlagSame;
    protected $FlagOnly;
    protected $FlagFirst;
    protected $HospitalName;
    protected $ClassMode;
    protected $Compliance;
    protected $UserId;
    protected $Nickname;
    protected $OpenId;
    protected $DelFlag;
    protected $SessionId;
    protected $GroupId;
    protected $Photo;
    protected $ParentSex;
    protected $UserName;
    protected $Phone;
    protected $Email;
    protected $SignupPhone;
    protected $SignupPhoneBackup;
    protected $HIsYizhi;
    protected $HIsGroup;

    protected function DefineKey()
    {
        return 'student_id';
    }
    protected function DefineTableName()
    {
        return 'student_info_wechat_wiew';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'student_id' => 'StudentId',
                    'state' => 'State',
                    'name' => 'Name',
                    'sex' => 'Sex',
                    'birthday' => 'Birthday',
                    'nation' => 'Nation',
                    'only' => 'Only',
                    'only_code' => 'OnlyCode',
                    'is_first' => 'IsFirst',
                    'h_code' => 'HCode',
                    'h_city' => 'HCity',
                    'h_area' => 'HArea',
                    'h_street' => 'HStreet',
                    'h_add' => 'HAdd',
                    'id' => 'Id',
                    'id_type' => 'IdType',
                    'z_city' => 'ZCity',
                    'z_property' => 'ZProperty',
                    'z_area' => 'ZArea',
                    'z_street' => 'ZStreet',
                    'z_add' => 'ZAdd',
                    'illness' => 'Illness',
                    'allergic' => 'Allergic',
                    'dept_id' => 'DeptId',
                    'grade_number' => 'GradeNumber',
                    'class_number' => 'ClassNumber',
                    'class_name_diy' => 'ClassNameDiy',
                    'jiudu' => 'Jiudu',
                    'birthplace' => 'Birthplace',
                    'birthplace_code' => 'BirthplaceCode',
                    'id_quality' => 'IdQuality',
                    'id_quality_type' => 'IdQualityType',
                    'signup_date' => 'SignupDate',
                    'in_time' => 'InTime',
                    'out_time' => 'OutTime',
                    'is_liushou' => 'IsLiushou',
                    'is_wugong' => 'IsWugong',
                    'is_canji' => 'IsCanji',
                    'canji_type' => 'CanjiType',
                    'is_jisu' => 'IsJisu',
                    'is_guer' => 'IsGuer',
                    'is_dibao' => 'IsDibao',
                    'dibao_code' => 'DibaoCode',
                    'is_zizhu' => 'IsZizhu',
                    'nationality' => 'Nationality',
                    'gangao' => 'Gangao',
                    'is_lieshi' => 'IsLieshi',
                    'canji_code' => 'CanjiCode',
                    'jiankang' => 'Jiankang',
                    'xuexing' => 'Xuexing',
                    'is_yiwang' => 'IsYiwang',
                    'is_shoushu' => 'IsShoushu',
                    'shoushu' => 'Shoushu',
                    'is_yizhi' => 'IsYizhi',
                    'is_yichuan' => 'IsYichuan',
                    'is_xiaochuan' => 'IsXiaochuan',
                    'is_dianxian' => 'IsDianxian',
                    'is_jingjue' => 'IsJingjue',
                    'is_xinzangbing' => 'IsXinzangbing',
                    'is_guomin' => 'IsGuomin',
                    'qitabingshi' => 'Qitabingshi',
                    'beizhu' => 'Beizhu',
                    'h_shequ' => 'HShequ',
                    'z_shequ' => 'ZShequ',
                    'z_same' => 'ZSame',
                    'h_guanxi' => 'HGuanxi',
                    'z_owner' => 'ZOwner',
                    'h_owner' => 'HOwner',
                    'z_guanxi' => 'ZGuanxi',
                    'jh_1_connection' => 'Jh1Connection',
                    'jh_1_is_zhixi' => 'Jh1IsZhixi',
                    'jh_1_is_canji' => 'Jh1IsCanji',
                    'jh_1_name' => 'Jh1Name',
                    'jh_1_job' => 'Jh1Job',
                    'jh_1_danwei' => 'Jh1Danwei',
                    'jh_1_canji_code' => 'Jh1CanjiCode',
                    'jh_1_id_type' => 'Jh1IdType',
                    'jh_1_jiaoyu' => 'Jh1Jiaoyu',
                    'jh_1_id' => 'Jh1Id',
                    'jh_1_phone' => 'Jh1Phone',
                    'jh_2_connection' => 'Jh2Connection',
                    'jh_2_is_zhixi' => 'Jh2IsZhixi',
                    'jh_2_is_canji' => 'Jh2IsCanji',
                    'jh_2_name' => 'Jh2Name',
                    'jh_2_job' => 'Jh2Job',
                    'jh_2_danwei' => 'Jh2Danwei',
                    'jh_2_canji_code' => 'Jh2CanjiCode',
                    'jh_2_id_type' => 'Jh2IdType',
                    'jh_2_jiaoyu' => 'Jh2Jiaoyu',
                    'jh_2_id' => 'Jh2Id',
                    'jh_2_phone' => 'Jh2Phone',
                    'jianhu_connection' => 'JianhuConnection',
                    'jianhu_name' => 'JianhuName',
                    'jianhu_phone' => 'JianhuPhone',
                    'flag_three' => 'FlagThree',
                    'flag_xicheng' => 'FlagXicheng',
                    'flag_same' => 'FlagSame',
                    'flag_only' => 'FlagOnly',
                    'flag_first' => 'FlagFirst',
                    'hospital_name' => 'HospitalName',
                    'class_mode' => 'ClassMode',
                    'compliance' => 'Compliance',
                    'user_id' => 'UserId',
                    'nickname' => 'Nickname',
                    'open_id' => 'OpenId',
                    'del_flag' => 'DelFlag',
                    'session_id' => 'SessionId',
                    'group_id' => 'GroupId',
                    'photo' => 'Photo',
                    'parent_sex' => 'ParentSex',
                    'user_name' => 'UserName',
                    'phone' => 'Phone',
                    'email' => 'Email',
                    'signup_phone' => 'SignupPhone',
                    'signup_phone_backup' => 'SignupPhoneBackup',
                    'h_is_yizhi' => 'HIsYizhi',
                    'h_is_group' => 'HIsGroup'
        ));
    }
}
class Student_Info_Meet_Item extends CRUD
{
    protected $Id;
    protected $Number;
    protected $Name;
    protected $Type;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'student_info_meet_item';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'number' => 'Number',
                    'name' => 'Name',
                    'type' => 'Type'
        ));
    }
}
class Base_User_Wechat extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $WechatId;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_wechat';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'wechat_id' => 'WechatId'
        ));
    }
}
class Base_User_Wechat_View extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $Name;
    protected $Username;
    protected $State;
    protected $Deleted;
    protected $WechatId;
    protected $Nickname;
    protected $Sex;
    protected $OpenId;
    protected $SessionId;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_wechat_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'name' => 'Name',
                    'username' => 'Username',
                    'state' => 'State',
                    'deleted' => 'Deleted',
                    'wechat_id' => 'WechatId',
                    'nickname' => 'Nickname',
                    'sex' => 'Sex',
                    'open_id' => 'OpenId',
                    'session_id' => 'SessionId'
        ));
    }
}
class Student_City_Code extends CRUD
{
    protected $Id;
    protected $ParentId;
    protected $Name;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'student_city_code';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'parent_id' => 'ParentId',
                    'name' => 'Name'
        ));
    }
}
?>