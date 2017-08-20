<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Notice_Center_Record extends CRUD
{
    protected $Id;
    protected $CreateDate;
    protected $DeptId;
    protected $Uid;
    protected $Target;
    protected $First;
    protected $Remark;
    protected $Comment;
    protected $SendDate;
    protected $IsSend;
    protected $TargetName;
    protected $Type;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'notice_center_record';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'create_date' => 'CreateDate',
                    'dept_id' => 'DeptId',
                    'uid' => 'Uid',
                    'target' => 'Target',
                    'first' => 'First',
                    'remark' => 'Remark',
                    'comment' => 'Comment',
                    'send_date' => 'SendDate',
                    'is_send' => 'IsSend',
        			'type' => 'Type',
                    'target_name' => 'TargetName'
        ));
    }
}
class Notice_Center_Record_View extends CRUD
{
    protected $Id;
    protected $CreateDate;
    protected $SendDate;
    protected $IsSend;
    protected $DeptId;
    protected $DeptName;
    protected $Uid;
    protected $UserName;
    protected $First;
    protected $Remark;
    protected $Comment;
    protected $Target;
    protected $TargetName;
    protected $Type;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'notice_center_record_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'create_date' => 'CreateDate',
                    'send_date' => 'SendDate',
                    'is_send' => 'IsSend',
                    'dept_id' => 'DeptId',
                    'dept_name' => 'DeptName',
                    'uid' => 'Uid',
                    'user_name' => 'UserName',
                    'first' => 'First',
                    'remark' => 'Remark',
                    'comment' => 'Comment',
                    'target' => 'Target',
        			'type' => 'Type',
                    'target_name' => 'TargetName'
        ));
    }
}
class Notice_Center_Teacher_Record extends CRUD
{
    protected $Id;
    protected $CreateDate;
    protected $Type;
    protected $DeptId;
    protected $Uid;
    protected $Target;
    protected $First;
    protected $Remark;
    protected $Comment;
    protected $SendDate;
    protected $IsSend;
    protected $TargetName;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'notice_center_teacher_record';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'create_date' => 'CreateDate',
                    'type' => 'Type',
                    'dept_id' => 'DeptId',
                    'uid' => 'Uid',
                    'target' => 'Target',
                    'first' => 'First',
                    'remark' => 'Remark',
                    'comment' => 'Comment',
                    'send_date' => 'SendDate',
                    'is_send' => 'IsSend',
                    'target_name' => 'TargetName'
        ));
    }
}
class Notice_Center_Teacher_Record_View extends CRUD
{
    protected $Id;
    protected $CreateDate;
    protected $SendDate;
    protected $IsSend;
    protected $DeptId;
    protected $DeptName;
    protected $Uid;
    protected $UserName;
    protected $First;
    protected $Remark;
    protected $Comment;
    protected $Target;
    protected $TargetName;
    protected $Type;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'notice_center_teacher_record_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'create_date' => 'CreateDate',
                    'send_date' => 'SendDate',
                    'is_send' => 'IsSend',
                    'dept_id' => 'DeptId',
                    'dept_name' => 'DeptName',
                    'uid' => 'Uid',
                    'user_name' => 'UserName',
                    'first' => 'First',
                    'remark' => 'Remark',
                    'comment' => 'Comment',
                    'target' => 'Target',
        			'type' => 'Type',
                    'target_name' => 'TargetName'
        ));
    }
}
?>