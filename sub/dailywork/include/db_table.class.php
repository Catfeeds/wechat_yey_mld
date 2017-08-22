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
class Dailywork_Workflow_Case extends CRUD
{
    protected $Id;
    protected $Opener;
    protected $Date;
    protected $MainId;
    protected $State;
    protected $CloseDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_case';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'opener' => 'Opener',
                    'date' => 'Date',
                    'main_id' => 'MainId',
                    'state' => 'State',
                    'close_date' => 'CloseDate'
        ));
    }
}
class Dailywork_Workflow_Case_Data extends CRUD
{
    protected $Id;
    protected $CaseId;
    protected $Name;
    protected $Value;
    protected $IsDecode;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_case_data';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'case_id' => 'CaseId',
                    'name' => 'Name',
                    'value' => 'Value',
                    'is_decode' => 'IsDecode'
        ));
    }
}
class Dailywork_Workflow_Case_Step extends CRUD
{
    protected $Id;
    protected $CaseId;
    protected $StepId;
    protected $OwnerId;
    protected $Date;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_case_step';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'case_id' => 'CaseId',
                    'step_id' => 'StepId',
                    'owner_id' => 'OwnerId',
                    'date' => 'Date'
        ));
    }
}
class Dailywork_Workflow_Case_Step_Data extends CRUD
{
    protected $Id;
    protected $StepId;
    protected $Name;
    protected $Value;
    protected $IsDecode;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_case_step_data';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'step_id' => 'StepId',
                    'name' => 'Name',
                    'value' => 'Value',
                    'is_decode' => 'IsDecode'
        ));
    }
}
class Dailywork_Workflow_Main extends CRUD
{
    protected $Id;
    protected $Title;
    protected $StateSum;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_main';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'title' => 'Title',
                    'state_sum' => 'StateSum'
        ));
    }
}
class Dailywork_Workflow_Main_Step extends CRUD
{
    protected $Id;
    protected $MainId;
    protected $Number;
    protected $RoleId;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_main_step';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'main_id' => 'MainId',
                    'number' => 'Number',
                    'role_id' => 'RoleId'
        ));
    }
}
class Dailywork_Workflow_Main_Step_Vcl extends CRUD
{
    protected $Id;
    protected $StepId;
    protected $Number;
    protected $Name;
    protected $Html;
    protected $IsMust;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_main_step_vcl';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'step_id' => 'StepId',
                    'number' => 'Number',
                    'name' => 'Name',
                    'html' => 'Html',
                    'is_must' => 'IsMust'
        ));
    }
}
class Dailywork_Workflow_Main_Vcl extends CRUD
{
    protected $Id;
    protected $MainId;
    protected $Number;
    protected $Name;
    protected $Html;
    protected $IsMust;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_main_vcl';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'main_id' => 'MainId',
                    'number' => 'Number',
                    'name' => 'Name',
                    'html' => 'Html',
                    'is_must' => 'IsMust'
        ));
    }
}
?>