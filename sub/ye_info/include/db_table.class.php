<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Student_Onboard_Checkingin extends CRUD
{
    protected $Id;
    protected $Active;
    protected $ClassId;
    protected $Date;
    protected $AbsenteeismStu;
    protected $AbsenteeismSum;
    protected $CheckinginSum;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'student_onboard_checkingin';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'active' => 'Active',
                    'class_id' => 'ClassId',
                    'date' => 'Date',
                    'absenteeism_stu' => 'AbsenteeismStu',
                    'absenteeism_sum' => 'AbsenteeismSum',
                    'checkingin_sum' => 'CheckinginSum'
        ));
    }
}
class Student_Onboard_Checkingin_Class_View extends CRUD
{
    protected $Id;
    protected $Active;
    protected $ClassId;
    protected $ClassName;
    protected $Date;
    protected $AbsenteeismStu;
    protected $AbsenteeismSum;
    protected $CheckinginSum;
    protected $Grade;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'student_onboard_checkingin_class_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'active' => 'Active',
                    'class_id' => 'ClassId',
                    'class_name' => 'ClassName',
                    'date' => 'Date',
                    'absenteeism_stu' => 'AbsenteeismStu',
                    'absenteeism_sum' => 'AbsenteeismSum',
                    'checkingin_sum' => 'CheckinginSum',
                    'grade' => 'Grade'
        ));
    }
}
?>