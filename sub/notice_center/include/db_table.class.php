<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Notice_Center_Record extends CRUD
{
    protected $Id;
    protected $CreatDate;
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
        return 'notice_center_record';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'creat_date' => 'CreatDate',
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
class Notice_Center_Record_View extends CRUD
{
    protected $Id;
    protected $CreatDate;
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
                    'creat_date' => 'CreatDate',
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
                    'target_name' => 'TargetName'
        ));
    }
}
?>