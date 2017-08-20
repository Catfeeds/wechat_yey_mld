<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
//1111111111111111111111111111111111111111111111
class View_User_Right extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $Name;

   protected function DefineKey()
   {
      return 'wechat_base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_right` INNER JOIN `wechat_base_module` ON `wechat_base_right`.`module_id` = `wechat_base_module`.`module_id` INNER JOIN `wechat_base_role` ON `wechat_base_role`.`role_id` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_user_role` ON `wechat_base_user_role`.`role_id` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_module_icon` ON `wechat_base_module_icon`.`icon_id` = `wechat_base_module`.`icon_id` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_role`.`uid` = `wechat_base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'wechat_base_right.right_id' => 'RightId',
                    'wechat_base_right.role_id' => 'RoleId',
                    'wechat_base_right.module_id' => 'ModuleId',
      				'wechat_base_module.name' => 'ModuleName',
      				'wechat_base_module.module' => 'Module',
      				'wechat_base_module.explain' => 'Explain',
     				'wechat_base_module.icon_id' => 'IconId',
      				'wechat_base_module.path' => 'Path',
      				'wechat_base_module.parent_module_id' => 'ParentModuleId',
      				'wechat_base_role.name' => 'RoleName',
      				'wechat_base_user_role.uid' => 'Uid',
      				'wechat_base_module_icon.path' => 'IconPathB',
      				'wechat_base_user_info.name' => 'Name',
      				'wechat_base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Right_Sec1 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $Name;

   protected function DefineKey()
   {
      return 'wechat_base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_right` INNER JOIN `wechat_base_module` ON `wechat_base_right`.`module_id` = `wechat_base_module`.`module_id` INNER JOIN `wechat_base_role` ON `wechat_base_role`.`role_id` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_user_role` ON `wechat_base_user_role`.`sec_role_id_1` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_module_icon` ON `wechat_base_module_icon`.`icon_id` = `wechat_base_module`.`icon_id` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_role`.`uid` = `wechat_base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'wechat_base_right.right_id' => 'RightId',
                    'wechat_base_right.role_id' => 'RoleId',
                    'wechat_base_right.module_id' => 'ModuleId',
      				'wechat_base_module.name' => 'ModuleName',
      				'wechat_base_module.module' => 'Module',
      				'wechat_base_module.explain' => 'Explain',
     				'wechat_base_module.icon_id' => 'IconId',
      				'wechat_base_module.path' => 'Path',
      				'wechat_base_module.parent_module_id' => 'ParentModuleId',
      				'wechat_base_role.name' => 'RoleName',
      				'wechat_base_user_role.uid' => 'Uid',
      				'wechat_base_module_icon.path' => 'IconPathB',
      				'wechat_base_user_info.name' => 'Name',
      				'wechat_base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Right_Sec2 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $Name;

   protected function DefineKey()
   {
      return 'wechat_base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_right` INNER JOIN `wechat_base_module` ON `wechat_base_right`.`module_id` = `wechat_base_module`.`module_id` INNER JOIN `wechat_base_role` ON `wechat_base_role`.`role_id` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_user_role` ON `wechat_base_user_role`.`sec_role_id_2` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_module_icon` ON `wechat_base_module_icon`.`icon_id` = `wechat_base_module`.`icon_id` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_role`.`uid` = `wechat_base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'wechat_base_right.right_id' => 'RightId',
                    'wechat_base_right.role_id' => 'RoleId',
                    'wechat_base_right.module_id' => 'ModuleId',
      				'wechat_base_module.name' => 'ModuleName',
      				'wechat_base_module.module' => 'Module',
      				'wechat_base_module.explain' => 'Explain',
     				'wechat_base_module.icon_id' => 'IconId',
      				'wechat_base_module.path' => 'Path',
      				'wechat_base_module.parent_module_id' => 'ParentModuleId',
      				'wechat_base_role.name' => 'RoleName',
      				'wechat_base_user_role.uid' => 'Uid',
      				'wechat_base_module_icon.path' => 'IconPathB',
      				'wechat_base_user_info.name' => 'Name',
      				'wechat_base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Right_Sec3 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $Name;

   protected function DefineKey()
   {
      return 'wechat_base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_right` INNER JOIN `wechat_base_module` ON `wechat_base_right`.`module_id` = `wechat_base_module`.`module_id` INNER JOIN `wechat_base_role` ON `wechat_base_role`.`role_id` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_user_role` ON `wechat_base_user_role`.`sec_role_id_3` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_module_icon` ON `wechat_base_module_icon`.`icon_id` = `wechat_base_module`.`icon_id` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_role`.`uid` = `wechat_base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'wechat_base_right.right_id' => 'RightId',
                    'wechat_base_right.role_id' => 'RoleId',
                    'wechat_base_right.module_id' => 'ModuleId',
      				'wechat_base_module.name' => 'ModuleName',
      				'wechat_base_module.module' => 'Module',
      				'wechat_base_module.explain' => 'Explain',
     				'wechat_base_module.icon_id' => 'IconId',
      				'wechat_base_module.path' => 'Path',
      				'wechat_base_module.parent_module_id' => 'ParentModuleId',
      				'wechat_base_role.name' => 'RoleName',
      				'wechat_base_user_role.uid' => 'Uid',
      				'wechat_base_module_icon.path' => 'IconPathB',
      				'wechat_base_user_info.name' => 'Name',
      				'wechat_base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Right_Sec4 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $Name;

   protected function DefineKey()
   {
      return 'wechat_base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_right` INNER JOIN `wechat_base_module` ON `wechat_base_right`.`module_id` = `wechat_base_module`.`module_id` INNER JOIN `wechat_base_role` ON `wechat_base_role`.`role_id` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_user_role` ON `wechat_base_user_role`.`sec_role_id_4` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_module_icon` ON `wechat_base_module_icon`.`icon_id` = `wechat_base_module`.`icon_id` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_role`.`uid` = `wechat_base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'wechat_base_right.right_id' => 'RightId',
                    'wechat_base_right.role_id' => 'RoleId',
                    'wechat_base_right.module_id' => 'ModuleId',
      				'wechat_base_module.name' => 'ModuleName',
      				'wechat_base_module.module' => 'Module',
      				'wechat_base_module.explain' => 'Explain',
     				'wechat_base_module.icon_id' => 'IconId',
      				'wechat_base_module.path' => 'Path',
      				'wechat_base_module.parent_module_id' => 'ParentModuleId',
      				'wechat_base_role.name' => 'RoleName',
      				'wechat_base_user_role.uid' => 'Uid',
      				'wechat_base_module_icon.path' => 'IconPathB',
      				'wechat_base_user_info.name' => 'Name',
      				'wechat_base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}
class View_User_Right_Sec5 extends CRUD
{
   protected $RightId;
   protected $RoleId;
   protected $ModuleId;
   protected $ModuleName;
   protected $Module;
   protected $Explain;
   protected $IconId;
   protected $Path;
   protected $ParentModuleId;
   protected $RoleName;
   protected $Uid;
   protected $IconPathB;
   protected $WaitReadTable;
   protected $Name;

   protected function DefineKey()
   {
      return 'wechat_base_right.right_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_right` INNER JOIN `wechat_base_module` ON `wechat_base_right`.`module_id` = `wechat_base_module`.`module_id` INNER JOIN `wechat_base_role` ON `wechat_base_role`.`role_id` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_user_role` ON `wechat_base_user_role`.`sec_role_id_5` = `wechat_base_right`.`role_id` INNER JOIN `wechat_base_module_icon` ON `wechat_base_module_icon`.`icon_id` = `wechat_base_module`.`icon_id` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_role`.`uid` = `wechat_base_user_info`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array( 'wechat_base_right.right_id' => 'RightId',
                    'wechat_base_right.role_id' => 'RoleId',
                    'wechat_base_right.module_id' => 'ModuleId',
      				'wechat_base_module.name' => 'ModuleName',
      				'wechat_base_module.module' => 'Module',
      				'wechat_base_module.explain' => 'Explain',
     				'wechat_base_module.icon_id' => 'IconId',
      				'wechat_base_module.path' => 'Path',
      				'wechat_base_module.parent_module_id' => 'ParentModuleId',
      				'wechat_base_role.name' => 'RoleName',
      				'wechat_base_user_role.uid' => 'Uid',
      				'wechat_base_module_icon.path' => 'IconPathB',
      				'wechat_base_user_info.name' => 'Name',
      				'wechat_base_module.wait_read_table' => 'WaitReadTable'
                   ));
   }
}

class View_User_Dept extends CRUD
{
   protected $DeptId;
   protected $DeptName;
   protected $ParentId;
   protected $Number;
   protected $Fax;
   protected $Address;
   protected $Uid;
   protected $Name;
   protected $RoleId;
   protected $RoleName;
   protected $Delete;
   protected $Email;
   protected $State;
   protected $Sex;
   protected $CustomEmail;
   protected $MobilePhone;
   protected $Phone;
   protected $SecRoleId1;
   protected $SecRoleId2;
   protected $SecRoleId3;
   protected $SecRoleId4;
   protected $SecRoleId5;
   
   protected function DefineKey()
   {
      return 'wechat_base_dept.dept_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_dept` INNER JOIN `wechat_base_user_role` ON `wechat_base_user_role`.`dept_id` = `wechat_base_dept`.`dept_id` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_role`.`uid` = `wechat_base_user_info`.`uid` INNER JOIN `wechat_base_user` ON `wechat_base_user_role`.`uid` = `wechat_base_user`.`uid` INNER JOIN `wechat_base_user_info_custom` ON `wechat_base_user_role`.`uid` = `wechat_base_user_info_custom`.`uid` INNER JOIN `wechat_base_role` ON `wechat_base_role`.`role_id` = `wechat_base_user_role`.`role_id';
   }
   protected function DefineRelationMap()
   {
      return(array('wechat_base_dept.dept_id' => 'DeptId',
      				'wechat_base_dept.name' => 'DeptName',
      				'wechat_base_dept.address' => 'Address',
      				'wechat_base_dept.parent_id' => 'ParentId',
      				'wechat_base_dept.number' => 'Number',
      				'wechat_base_user_info.uid' => 'Uid',
      				'wechat_base_user_info.name' => 'Name',
      				'wechat_base_user_info.sex' => 'Sex',
      				'wechat_base_user_info.email' => 'Email',
      				'wechat_base_user_info.delete' => 'Delete',
     				'wechat_base_user_role.role_id' => 'RoleId',
      				'wechat_base_role.name' => 'RoleName',
     				'wechat_base_user.state' => 'State',
     				'wechat_base_user_info_custom.email' => 'CustomEmail',
      				'wechat_base_user_info_custom.mobile_phone' => 'MobilePhone',
      				'wechat_base_user_info_custom.phone' => 'Phone',
                    'wechat_base_user_role.sec_role_id_1' => 'SecRoleId1',
                    'wechat_base_user_role.sec_role_id_2' => 'SecRoleId2',
                    'wechat_base_user_role.sec_role_id_3' => 'SecRoleId3',
                    'wechat_base_user_role.sec_role_id_4' => 'SecRoleId4',
                    'wechat_base_user_role.sec_role_id_5' => 'SecRoleId5'
                   ));
   }
}
class View_User_List extends CRUD
{
   protected $Uid;
   protected $UserName;
   protected $Name;
   protected $RoleName;
   protected $State;
   protected $Deleted;
   protected $Type;
   protected $Sex;
   protected $Phone;
   protected $DeptId;
   protected $DiskSpace;
   protected $SchoolId;
   protected $Email;
   protected $AmUsername;
   protected $ShowPassword;
   protected $SecRole1;
   protected $SecRole2;
   protected $SecRole3;
   protected $SecRole4;
   protected $SecRole5;
   protected $RoleId;
   
   protected function DefineKey()
   {
      return 'wechat_base_user.uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_info`.`uid` = `wechat_base_user`.`uid` INNER JOIN `wechat_base_user_role` ON `wechat_base_user`.`uid` = `wechat_base_user_role`.`uid` INNER JOIN `wechat_base_role` ON `wechat_base_role`.`role_id` = `wechat_base_user_role`.`role_id';
   }
   protected function DefineRelationMap()
   {
      return(array('wechat_base_user.uid' => 'Uid',
      				'wechat_base_user.username' => 'UserName',
      				'wechat_base_user.type' => 'Type',
      				'wechat_base_user.deleted' => 'Deleted',
      				'wechat_base_user.show_password' => 'ShowPassword',
      				'wechat_base_user.state' => 'State',
      				'wechat_base_user_info.name' => 'Name',
     				'wechat_base_user_info.sex' => 'Sex',
      				'wechat_base_user_info.phone' => 'Phone',
      				'wechat_base_user_info.email' => 'Email',
      				'wechat_base_user_info.disk_space' => 'DiskSpace',
      				'wechat_base_user_info.school_id' => 'SchoolId',
      				'wechat_base_user_info.am_username' => 'AmUsername',
      				'wechat_base_user_role.dept_id' => 'DeptId',
      				'wechat_base_user_role.role_id' => 'RoleId',
      				'wechat_base_role.name' => 'RoleName',
      				'wechat_base_user_role.sec_role_id_1' => 'SecRole1',
				    'wechat_base_user_role.sec_role_id_2' => 'SecRole2',
				    'wechat_base_user_role.sec_role_id_3' => 'SecRole3',
				    'wechat_base_user_role.sec_role_id_4' => 'SecRole4',
				    'wechat_base_user_role.sec_role_id_5' => 'SecRole5',
                   ));
   }
}
class View_AddRole_Module extends CRUD
{
   protected $ModuleId;
   protected $Name;
   protected $Explain;
   protected $ParentModuleId;
   protected $MiniIconId;
   protected $Path;
   protected $Module;
   protected function DefineKey()
   {
      return 'wechat_base_module.module_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_module` INNER JOIN `wechat_base_module_icon` ON `wechat_base_module_icon`.`icon_id` = `wechat_base_module`.`icon_id';
   }
   protected function DefineRelationMap()
   {
      return(array('wechat_base_module.module_id' => 'ModuleId',
      				'wechat_base_module.name' => 'Name',
      				'wechat_base_module.explain' => 'Explain',
      				'wechat_base_module.module' => 'Module',
      				'wechat_base_module.parent_module_id' => 'ParentModuleId',
                   	'wechat_base_module.icon_id' => 'MiniIconId',
      				'wechat_base_module_icon.path' => 'Path'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_User_Role extends CRUD
{
   protected $Uid;
   protected $DeptId;
   protected $RoleId;
   protected $SecRoleId1;
   protected $SecRoleId2;
   protected $SecRoleId3;
   protected $SecRoleId4;
   protected $SecRoleId5;
   protected $Name;
      
   protected function DefineKey()
   {
      return 'wechat_base_user_role.uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_role` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_info`.`uid` = `wechat_base_user_role`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array('wechat_base_user_role.uid' => 'Uid',
                   'wechat_base_user_role.dept_id' => 'DeptId',
                   'wechat_base_user_role.role_id' => 'RoleId',
                   'wechat_base_user_role.sec_role_id_1' => 'SecRoleId1',
                   'wechat_base_user_role.sec_role_id_2' => 'SecRoleId2',
                   'wechat_base_user_role.sec_role_id_3' => 'SecRoleId3',
                   'wechat_base_user_role.sec_role_id_4' => 'SecRoleId4',
                   'wechat_base_user_role.sec_role_id_5' => 'SecRoleId5',
      			   'wechat_base_user_info.name' => 'Name'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_User_Info extends CRUD
{
   protected $State;
   protected $Username;
   protected $Uid;
   protected $Name;
   protected $Email;
   protected $EmailPassword;
    
   protected function DefineKey()
   {
      return 'wechat_base_user.uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_info`.`uid` = `wechat_base_user`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array('wechat_base_user.uid' => 'Uid',
                   'wechat_base_user.state' => 'State',
      				'wechat_base_user.username' => 'Username',
                   'wechat_base_user_info.email' => 'Email',
      				'wechat_base_user_info.name' => 'Name',
      				'wechat_base_user_info.email_password' => 'EmailPassword',
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_System_Msg extends CRUD
{
   protected $Id;
   protected $Uid;
   protected $Text;
   protected $ParentModuleId;
   protected $ModuleId;
   protected $Type;
   protected $AmUsername;
   protected $Readed;
   protected $AmReaded;

   protected function DefineKey()
   {
      return 'wechat_base_system_msg.id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_system_msg` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_info`.`uid` = `wechat_base_system_msg`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array('wechat_base_system_msg.id' => 'Id',               
                   'wechat_base_system_msg.uid' => 'Uid',          
                   'wechat_base_system_msg.text' => 'Text',          
                   'wechat_base_system_msg.parent_module_id' => 'ParentModuleId',
                   'wechat_base_system_msg.module_id' => 'ModuleId',         
                   'wechat_base_system_msg.readed' => 'Readed',
      			   'wechat_base_system_msg.type' => 'Type',
      			   'wechat_base_system_msg.am_readed' => 'AmReaded',
      			   'wechat_base_user_info.am_username' => 'AmUsername'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
class View_Online_User extends CRUD
{
   protected $Uid;
   protected $Online;
   protected $Name;

   protected function DefineKey()
   {
      return 'wechat_base_user_login.uid';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_login` INNER JOIN `wechat_base_user_info` ON `wechat_base_user_info`.`uid` = `wechat_base_user_login`.`uid';
   }
   protected function DefineRelationMap()
   {
      return(array('wechat_base_user_login.uid' => 'Uid',          
                   'wechat_base_user_login.online' => 'Online',          
                   'wechat_base_user_info.name' => 'Name'
                   ));
   }
}
class View_Base_User_File extends CRUD
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
   protected $DeleteDate;
   protected $KeyWord;
   protected $ClassName;
   protected $FolderId;
   protected $OriginalPath;
   protected $OriginalFilename;
	 
   protected function DefineKey()
   {
      return 'wechat_base_user_files.file_id';
   }
   protected function DefineTableName()
   {
      return 'wechat_base_user_files` INNER JOIN `wechat_base_user_file_type` ON `wechat_base_user_files`.`suffix` = `wechat_base_user_file_type`.`suffix';
   }
   protected function DefineRelationMap()
   {
      return(array( 'wechat_base_user_files.file_id' => 'FileId',
      				'wechat_base_user_files.filename' => 'Filename',
      				'wechat_base_user_files.filesize' => 'Filesize',
      				'wechat_base_user_files.date' => 'Date',
      				'wechat_base_user_files.folder_id' => 'FolderId',
      				'wechat_base_user_files.suffix' => 'Suffix',
     				'wechat_base_user_files.crc' => 'Crc',
      				'wechat_base_user_files.share_username' => 'ShareUsername',
      				'wechat_base_user_files.share_uid' => 'ShareUid',
      				'wechat_base_user_files.path' => 'Path',
      				'wechat_base_user_files.uid' => 'Uid',
      				'wechat_base_user_files.delete' => 'Delete',
      				'wechat_base_user_files.delete_date' => 'DeleteDate',
      				'wechat_base_user_files.key_word' => 'KeyWord',
      				'wechat_base_user_files.original_path' => 'OriginalPath',
      				'wechat_base_user_files.original_filename' => 'OriginalFilename',
      				'wechat_base_user_file_type.classname' => 'ClassName'
                   ));
   }
}
//1111111111111111111111111111111111111111111111
?>