<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Student_Onboard_Checkingin extends CRUD
{
    protected $Id;
    protected $Active;
    protected $OwnerId;
    protected $GradeNumber;
    protected $GradeName;
    protected $ClassId;
    protected $ClassName;
    protected $Date;
    protected $ModifyDate;
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
            'owner_id' => 'OwnerId',
            'grade_number' => 'GradeNumber',
            'grade_name' => 'GradeName',
            'class_id' => 'ClassId',
            'class_name' => 'ClassName',
            'date' => 'Date',
            'modify_date' => 'ModifyDate',
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
    protected $OwnerId;
    protected $OwnerName;
    protected $ModifyDate;
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
                    'owner_id' => 'OwnerId',
                    'owner_name' => 'OwnerName',
                    'modify_date' => 'ModifyDate',
                    'absenteeism_stu' => 'AbsenteeismStu',
                    'absenteeism_sum' => 'AbsenteeismSum',
                    'checkingin_sum' => 'CheckinginSum',
                    'grade' => 'Grade'
        ));
    }
}
class Student_Onboard_Checkingin_Detail extends CRUD
{
    protected $Id;
    protected $CheckId;
    protected $StudentId;
    protected $Name;
    protected $Type;
    protected $Comment;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'student_onboard_checkingin_detail';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'check_id' => 'CheckId',
                    'student_id' => 'StudentId',
                    'name' => 'Name',
                    'type' => 'Type',
                    'comment' => 'Comment'
        ));
    }
}
class Student_Onboard_Checkingin_Parent extends CRUD
{
    protected $Id;
    protected $UserId;
    protected $StudentId;
    protected $Date;
    protected $Type;
    protected $Comment;
    protected $StartDate;
    protected $EndDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'student_onboard_checkingin_parent';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'user_id' => 'UserId',
                    'student_id' => 'StudentId',
                    'date' => 'Date',
                    'type' => 'Type',
                    'comment' => 'Comment',
                    'start_date' => 'StartDate',
                    'end_date' => 'EndDate'
        ));
    }
}
class Student_Onboard_Checkingin_Parent_View extends CRUD
{
    protected $Id;
    protected $UserId;
    protected $ParentName;
    protected $StudentId;
    protected $Name;
    protected $ClassNumber;
    protected $Date;
    protected $Type;
    protected $Comment;
    protected $StartDate;
    protected $EndDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'student_onboard_checkingin_parent_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'user_id' => 'UserId',
                    'parent_name' => 'ParentName',
                    'student_id' => 'StudentId',
                    'name' => 'Name',
                    'class_number' => 'ClassNumber',
                    'date' => 'Date',
                    'type' => 'Type',
                    'comment' => 'Comment',
                    'start_date' => 'StartDate',
                    'end_date' => 'EndDate'
        ));
    }
}
class Student_Onboard_Checkingin_Detail_View extends CRUD
{
    protected $Id;
    protected $CheckId;
    protected $Date;
    protected $Active;
    protected $ClassId;
    protected $ClassName;
    protected $StudentId;
    protected $Name;
    protected $Type;
    protected $Comment;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'student_onboard_checkingin_detail_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'check_id' => 'CheckId',
                    'date' => 'Date',
                    'active' => 'Active',
                    'class_id' => 'ClassId',
                    'class_name' => 'ClassName',
                    'student_id' => 'StudentId',
                    'name' => 'Name',
                    'type' => 'Type',
                    'comment' => 'Comment'
        ));
    }
}
?>