<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Dailywork_Payroll_Item extends CRUD
{
    protected $Id;
    protected $Number;
    protected $Name;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_payroll_item';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'number' => 'Number',
                    'name' => 'Name'
        ));
    }
}
class Dailywork_Payroll_Object extends CRUD
{
    protected $Id;
    protected $OperatorId;
    protected $OperatorDate;
    protected $Date;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_payroll_object';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'operator_id' => 'OperatorId',
                    'operator_date' => 'OperatorDate',
                    'date' => 'Date'
        ));
    }
}
class Dailywork_Payroll_Object_Detail extends CRUD
{
    protected $Id;
    protected $TeacherId;
    protected $Detail;
    protected $ObjectId;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_payroll_object_detail';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'teacher_id' => 'TeacherId',
                    'detail' => 'Detail',
                    'object_id' => 'ObjectId'
        ));
    }
}
class Dailywork_Payroll_Object_Detail_View extends CRUD
{
    protected $Id;
    protected $TeacherId;
    protected $TeacherName;
    protected $WechatId;
    protected $ObjectId;
    protected $OperatorId;
    protected $OperatorName;
    protected $OperatorDate;
    protected $Date;
    protected $Detail;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_payroll_object_detail_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'teacher_id' => 'TeacherId',
                    'teacher_name' => 'TeacherName',
                    'wechat_id' => 'WechatId',
                    'object_id' => 'ObjectId',
                    'operator_id' => 'OperatorId',
                    'operator_name' => 'OperatorName',
                    'operator_date' => 'OperatorDate',
                    'date' => 'Date',
                    'detail' => 'Detail'
        ));
    }
}
class Dailywork_Payroll_Object_View extends CRUD
{
    protected $Id;
    protected $OperatorId;
    protected $OperatorName;
    protected $OperatorDate;
    protected $Date;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_payroll_object_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'operator_id' => 'OperatorId',
                    'operator_name' => 'OperatorName',
                    'operator_date' => 'OperatorDate',
                    'date' => 'Date'
        ));
    }
}
?>