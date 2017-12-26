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
    protected $Reason;

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
                    'close_date' => 'CloseDate',
                    'reason' => 'Reason'
        ));
    }
}
class Dailywork_Workflow_Case_View extends CRUD
{
    protected $Id;
    protected $Opener;
    protected $Name;
    protected $MainId;
    protected $Title;
    protected $StateSum;
    protected $RoleId;
    protected $Date;
    protected $State;
    protected $CloseDate;
    protected $Reason;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_case_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'opener' => 'Opener',
                    'name' => 'Name',
                    'main_id' => 'MainId',
                    'title' => 'Title',
                    'state_sum' => 'StateSum',
                    'role_id' => 'RoleId',
                    'date' => 'Date',
                    'state' => 'State',
                    'close_date' => 'CloseDate',
                    'reason' => 'Reason'
        ));
    }
}
class Dailywork_Workflow_Case_Data extends CRUD
{
    protected $Id;
    protected $CaseId;
    protected $MainVclId;
    protected $Name;
    protected $Type;
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
        			'main_vcl_id' => 'MainVclId',
                    'name' => 'Name',
                    'type' => 'Type',
                    'value' => 'Value',
                    'is_decode' => 'IsDecode'
        ));
    }
}
class Dailywork_Workflow_Case_Log extends CRUD
{
    protected $Id;
    protected $CaseId;
    protected $Date;
    protected $OperatorId;
    protected $OperatorName;
    protected $Comment;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_case_log';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'case_id' => 'CaseId',
                    'date' => 'Date',
                    'operator_id' => 'OperatorId',
                    'operator_name' => 'OperatorName',
                    'comment' => 'Comment'
        ));
    }
}
class Dailywork_Workflow_Case_Step extends CRUD
{
    protected $Id;
    protected $CaseId;
    protected $MainStepId;
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
                    'main_step_id' => 'MainStepId',
                    'owner_id' => 'OwnerId',
                    'date' => 'Date'
        ));
    }
}
class Dailywork_Workflow_Case_Step_View extends CRUD
{
    protected $Id;
    protected $CaseId;
    protected $Opener;
    protected $Name;
    protected $MainId;
    protected $Title;
    protected $StateSum;
    protected $CaseDate;
    protected $State;
    protected $CloseDate;
    protected $Reason;
    protected $MainStepId;
    protected $Number;
    protected $RoleId;
    protected $OwnerId;
    protected $StepDate;
    protected $RoleName;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_case_step_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'case_id' => 'CaseId',
                    'opener' => 'Opener',
                    'name' => 'Name',
                    'main_id' => 'MainId',
                    'title' => 'Title',
                    'state_sum' => 'StateSum',
                    'case_date' => 'CaseDate',
                    'state' => 'State',
                    'close_date' => 'CloseDate',
                    'reason' => 'Reason',
                    'main_step_id' => 'MainStepId',
                    'number' => 'Number',
                    'role_id' => 'RoleId',
                    'owner_id' => 'OwnerId',
                    'step_date' => 'StepDate',
                    'role_name' => 'RoleName'
        ));
    }
}
class Dailywork_Workflow_Case_Step_Data extends CRUD
{
    protected $Id;
    protected $CaseStepId;
    protected $Name;
    protected $Type;
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
                    'case_step_id' => 'CaseStepId',
                    'name' => 'Name',
                    'type' => 'Type',
                    'value' => 'Value',
                    'is_decode' => 'IsDecode'
        ));
    }
}
class Dailywork_Workflow_Main extends CRUD
{
    protected $Id;
    protected $Number;
    protected $Title;
    protected $StateSum;
    protected $RoleId;

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
        			'number' => 'Number',
                    'title' => 'Title',
                    'state_sum' => 'StateSum',
                    'role_id' => 'RoleId'
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
    protected $Type;
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
                    'type' => 'Type',
                    'is_must' => 'IsMust'
        ));
    }
}
class Dailywork_Workflow_Main_Step_View extends CRUD
{
    protected $Id;
    protected $MainNumber;
    protected $MainId;
    protected $Title;
    protected $StateSum;
    protected $MainRoleId;
    protected $Number;
    protected $RoleId;
    protected $RoleName;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'dailywork_workflow_main_step_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'main_number' => 'MainNumber',
                    'main_id' => 'MainId',
                    'title' => 'Title',
                    'state_sum' => 'StateSum',
                    'main_role_id' => 'MainRoleId',
                    'number' => 'Number',
                    'role_id' => 'RoleId',
                    'role_name' => 'RoleName'
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
    protected $Type;
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
                    'type' => 'Type',
                    'is_must' => 'IsMust'
        ));
    }
}
class Ek_Cuisine extends CRUD
{
    protected $Dishnum;
    protected $Treetype;
    protected $Upid;
    protected $Tsort;
    protected $Dishname;
    protected $Trait;
    protected $Made;
    protected $Picture;
    protected $Foodinfo;
    protected $Cal;
    protected $Pro;
    protected $Fat;
    protected $Ch;
    protected $Df;
    protected $Va;
    protected $Va2;
    protected $Vb1;
    protected $Vb2;
    protected $Vb3;
    protected $Vc;
    protected $Ve;
    protected $Caro;
    protected $Ca;
    protected $P;
    protected $K;
    protected $Na2;
    protected $Mg;
    protected $Fe;
    protected $Zn;
    protected $Se;
    protected $Cu;
    protected $Mn;
    protected $I;
    protected $Creationtime;
    protected $Altertime;
    protected $Creator;
    protected $Alteruser;
    protected $Delflag;

    protected function DefineKey()
    {
        return 'dishnum';
    }
    protected function DefineTableName()
    {
        return 'ek_cuisine';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'dishnum' => 'Dishnum',
                    'treetype' => 'Treetype',
                    'upid' => 'Upid',
                    'tsort' => 'Tsort',
                    'dishname' => 'Dishname',
                    'trait' => 'Trait',
                    'made' => 'Made',
                    'picture' => 'Picture',
                    'foodinfo' => 'Foodinfo',
                    'cal' => 'Cal',
                    'pro' => 'Pro',
                    'fat' => 'Fat',
                    'ch' => 'Ch',
                    'df' => 'Df',
                    'va' => 'Va',
                    'va2' => 'Va2',
                    'vb1' => 'Vb1',
                    'vb2' => 'Vb2',
                    'vb3' => 'Vb3',
                    'vc' => 'Vc',
                    've' => 'Ve',
                    'caro' => 'Caro',
                    'ca' => 'Ca',
                    'p' => 'P',
                    'k' => 'K',
                    'na2' => 'Na2',
                    'mg' => 'Mg',
                    'fe' => 'Fe',
                    'zn' => 'Zn',
                    'se' => 'Se',
                    'cu' => 'Cu',
                    'mn' => 'Mn',
                    'i' => 'I',
                    'creationtime' => 'Creationtime',
                    'altertime' => 'Altertime',
                    'creator' => 'Creator',
                    'alteruser' => 'Alteruser',
                    'delflag' => 'Delflag'
        ));
    }
}
class Ek_Recomrecipe extends CRUD
{
    protected $Id;
    protected $Recipename;
    protected $Intyear;
    protected $Intmonth;
    protected $Cycle;
    protected $Describe;
    protected $Recipe;
    protected $Avgage;
    protected $Ratio;
    protected $Islamic;
    protected $Creationtime;
    protected $Altertime;
    protected $Creator;
    protected $Alteruser;
    protected $Delflag;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'ek_recomrecipe';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'recipename' => 'Recipename',
                    'intyear' => 'Intyear',
                    'intmonth' => 'Intmonth',
                    'cycle' => 'Cycle',
                    'describe' => 'Describe',
                    'recipe' => 'Recipe',
                    'avgage' => 'Avgage',
                    'ratio' => 'Ratio',
                    'islamic' => 'Islamic',
                    'creationtime' => 'Creationtime',
                    'altertime' => 'Altertime',
                    'creator' => 'Creator',
                    'alteruser' => 'Alteruser',
                    'delflag' => 'Delflag'
        ));
    }
}
class Ek_Usefood extends CRUD
{
    protected $Foodnum;
    protected $Foodname;
    protected $Nickname;
    protected $Truename;
    protected $Usage;
    protected $Price;
    protected $Foodpart;
    protected $Kindname;
    protected $Picture;
    protected $Weigth;
    protected $Water;
    protected $Cal;
    protected $Pro;
    protected $Fat;
    protected $Ch;
    protected $Df;
    protected $Va;
    protected $Va2;
    protected $Vb1;
    protected $Vb2;
    protected $Vb3;
    protected $Vc;
    protected $Ve;
    protected $Caro;
    protected $Ca;
    protected $P;
    protected $K;
    protected $Na2;
    protected $Mg;
    protected $Fe;
    protected $Zn;
    protected $Se;
    protected $Cu;
    protected $Mn;
    protected $I;
    protected $Cglx;
    protected $Creationtime;
    protected $Altertime;
    protected $Creator;
    protected $Alteruser;
    protected $Delflag;

    protected function DefineKey()
    {
        return 'foodnum';
    }
    protected function DefineTableName()
    {
        return 'ek_usefood';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'foodnum' => 'Foodnum',
                    'foodname' => 'Foodname',
        			'nickname' => 'Nickname',
                    'truename' => 'Truename',
                    'usage' => 'Usage',
                    'price' => 'Price',
                    'foodpart' => 'Foodpart',
                    'kindname' => 'Kindname',
                    'picture' => 'Picture',
                    'weigth' => 'Weigth',
                    'water' => 'Water',
                    'cal' => 'Cal',
                    'pro' => 'Pro',
                    'fat' => 'Fat',
                    'ch' => 'Ch',
                    'df' => 'Df',
                    'va' => 'Va',
                    'va2' => 'Va2',
                    'vb1' => 'Vb1',
                    'vb2' => 'Vb2',
                    'vb3' => 'Vb3',
                    'vc' => 'Vc',
                    've' => 'Ve',
                    'caro' => 'Caro',
                    'ca' => 'Ca',
                    'p' => 'P',
                    'k' => 'K',
                    'na2' => 'Na2',
                    'mg' => 'Mg',
                    'fe' => 'Fe',
                    'zn' => 'Zn',
                    'se' => 'Se',
                    'cu' => 'Cu',
                    'mn' => 'Mn',
                    'i' => 'I',
                    'cglx' => 'Cglx',
                    'creationtime' => 'Creationtime',
                    'altertime' => 'Altertime',
                    'creator' => 'Creator',
                    'alteruser' => 'Alteruser',
                    'delflag' => 'Delflag'
        ));
    }
}
class Ek_Cuisine_Modify extends CRUD
{
    protected $Id;
    protected $Dishnum;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'ek_cuisine_modify';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'dishnum' => 'Dishnum'
        ));
    }
}
class Wechat_Base_User_Info_Awards extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $Date;
    protected $Name;
    protected $Type;
    protected $Grade;
    protected $Level;
    protected $RoleLevel;
    protected $ApproveDept;
    protected $IsCertificate;
    protected $Picture;
    protected $CreateDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_info_awards';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'date' => 'Date',
                    'name' => 'Name',
                    'type' => 'Type',
                    'grade' => 'Grade',
                    'level' => 'Level',
                    'role_level' => 'RoleLevel',
                    'approve_dept' => 'ApproveDept',
                    'is_certificate' => 'IsCertificate',
                    'picture' => 'Picture',
                    'create_date' => 'CreateDate'
        ));
    }
}
class Wechat_Base_User_Info_Base extends CRUD
{
    protected $Uid;
    protected $Name;
    protected $CardId;
    protected $Sex;
    protected $Birthday;
    protected $Nation;
    protected $Politics;
    protected $JoinWorkDate;

    protected function DefineKey()
    {
        return 'uid';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_info_base';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'uid' => 'Uid',
                    'name' => 'Name',
                    'card_id' => 'CardId',
                    'sex' => 'Sex',
                    'birthday' => 'Birthday',
                    'nation' => 'Nation',
                    'politics' => 'Politics',
                    'join_work_date' => 'JoinWorkDate'
        ));
    }
}
class Wechat_Base_User_Info_Education extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $GraduateDate;
    protected $EducationType;
    protected $Education;
    protected $School;
    protected $Profession;
    protected $Length;
    protected $ProType;
    protected $CreateDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_info_education';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'graduate_date' => 'GraduateDate',
                    'education_type' => 'EducationType',
                    'education' => 'Education',
                    'school' => 'School',
                    'profession' => 'Profession',
                    'length' => 'Length',
                    'pro_type' => 'ProType',
                    'create_date' => 'CreateDate'
        ));
    }
}
class Wechat_Base_User_Info_Jobtitle extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $Name;
    protected $Number;
    protected $Organization;
    protected $Date;
    protected $Picture;
    protected $CreateDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_info_jobtitle';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'name' => 'Name',
                    'number' => 'Number',
                    'organization' => 'Organization',
                    'date' => 'Date',
                    'picture' => 'Picture',
                    'create_date' => 'CreateDate'
        ));
    }
}
class Wechat_Base_User_Info_Thesis extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $Date;
    protected $Title;
    protected $BookName;
    protected $RoleLevel;
    protected $CreateDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_info_thesis';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'date' => 'Date',
                    'title' => 'Title',
                    'book_name' => 'BookName',
                    'role_level' => 'RoleLevel',
                    'create_date' => 'CreateDate'
        ));
    }
}
class Wechat_Base_User_Info_Training extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $StartDate;
    protected $EndDate;
    protected $Type;
    protected $Content;
    protected $Organization;
    protected $IsCertificate;
    protected $Picture;
    protected $CreateDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_info_training';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'start_date' => 'StartDate',
                    'end_date' => 'EndDate',
                    'type' => 'Type',
                    'content' => 'Content',
                    'organization' => 'Organization',
                    'is_certificate' => 'IsCertificate',
                    'picture' => 'Picture',
                    'create_date' => 'CreateDate'
        ));
    }
}
class Wechat_Base_User_Info_Work extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $StartDate;
    protected $EndDate;
    protected $Content;
    protected $Role;
    protected $Type;
    protected $CreateDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_info_work';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'start_date' => 'StartDate',
                    'end_date' => 'EndDate',
                    'content' => 'Content',
                    'role' => 'Role',
                    'type' => 'Type',
                    'create_date' => 'CreateDate'
        ));
    }
}
class Wechat_Base_User_Info_Tech extends CRUD
{
    protected $Id;
    protected $Uid;
    protected $Date;
    protected $Title;
    protected $RoleLevel;
    protected $CreateDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'wechat_base_user_info_tech';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'uid' => 'Uid',
                    'date' => 'Date',
                    'title' => 'Title',
                    'role_level' => 'RoleLevel',
                    'create_date' => 'CreateDate'
        ));
    }
}
?>