<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Survey extends CRUD
{
    protected $Id;
    protected $Title;
    protected $Comment;
    protected $CreateDate;
    protected $State;
    protected $OwnerId;
    protected $ReleaseDate;
    protected $EndDate;
    protected $TargetName;
    protected $TargetList;
    protected $First;
    protected $Remark;
    protected $CompletedSum;
    protected $PendingSum;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'survey';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'title' => 'Title',
        			'comment' => 'Comment',
                    'create_date' => 'CreateDate',
                    'state' => 'State',
                    'owner_id' => 'OwnerId',
                    'release_date' => 'ReleaseDate',
                    'end_date' => 'EndDate',
                    'target_name' => 'TargetName',
                    'target_list' => 'TargetList',
                    'first' => 'First',
                    'remark' => 'Remark',
                    'completed_sum' => 'CompletedSum',
                    'pending_sum' => 'PendingSum'
        ));
    }
}
class Survey_Answers extends CRUD
{
    protected $Id;
    protected $SurveyId;
    protected $UserId;
    protected $StudentId;
    protected $Name;
    protected $Sex;
    protected $IdType;
    protected $CardId;
    protected $ClassName;
    protected $UserName;
    protected $Date;
    protected $Answer1;
    protected $Answer2;
    protected $Answer3;
    protected $Answer4;
    protected $Answer5;
    protected $Answer6;
    protected $Answer7;
    protected $Answer8;
    protected $Answer9;
    protected $Answer10;
    protected $Answer11;
    protected $Answer12;
    protected $Answer13;
    protected $Answer14;
    protected $Answer15;
    protected $Answer16;
    protected $Answer17;
    protected $Answer18;
    protected $Answer19;
    protected $Answer20;
    protected $Answer21;
    protected $Answer22;
    protected $Answer23;
    protected $Answer24;
    protected $Answer25;
    protected $Answer26;
    protected $Answer27;
    protected $Answer28;
    protected $Answer29;
    protected $Answer30;
    protected $Answer31;
    protected $Answer32;
    protected $Answer33;
    protected $Answer34;
    protected $Answer35;
    protected $Answer36;
    protected $Answer37;
    protected $Answer38;
    protected $Answer39;
    protected $Answer40;
    protected $Answer41;
    protected $Answer42;
    protected $Answer43;
    protected $Answer44;
    protected $Answer45;
    protected $Answer46;
    protected $Answer47;
    protected $Answer48;
    protected $Answer49;
    protected $Answer50;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'survey_answers';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'survey_id' => 'SurveyId',
                    'user_id' => 'UserId',
        			'student_id' => 'StudentId',
                    'name' => 'Name',
                    'sex' => 'Sex',
                    'id_type' => 'IdType',
                    'card_id' => 'CardId',
                    'class_name' => 'ClassName',
                    'user_name' => 'UserName',
                    'date' => 'Date',
                    'answer_1' => 'Answer1',
                    'answer_2' => 'Answer2',
                    'answer_3' => 'Answer3',
                    'answer_4' => 'Answer4',
                    'answer_5' => 'Answer5',
                    'answer_6' => 'Answer6',
                    'answer_7' => 'Answer7',
                    'answer_8' => 'Answer8',
                    'answer_9' => 'Answer9',
                    'answer_10' => 'Answer10',
                    'answer_11' => 'Answer11',
                    'answer_12' => 'Answer12',
                    'answer_13' => 'Answer13',
                    'answer_14' => 'Answer14',
                    'answer_15' => 'Answer15',
                    'answer_16' => 'Answer16',
                    'answer_17' => 'Answer17',
                    'answer_18' => 'Answer18',
                    'answer_19' => 'Answer19',
                    'answer_20' => 'Answer20',
                    'answer_21' => 'Answer21',
                    'answer_22' => 'Answer22',
                    'answer_23' => 'Answer23',
                    'answer_24' => 'Answer24',
                    'answer_25' => 'Answer25',
                    'answer_26' => 'Answer26',
                    'answer_27' => 'Answer27',
                    'answer_28' => 'Answer28',
                    'answer_29' => 'Answer29',
                    'answer_30' => 'Answer30',
                    'answer_31' => 'Answer31',
                    'answer_32' => 'Answer32',
                    'answer_33' => 'Answer33',
                    'answer_34' => 'Answer34',
                    'answer_35' => 'Answer35',
                    'answer_36' => 'Answer36',
                    'answer_37' => 'Answer37',
                    'answer_38' => 'Answer38',
                    'answer_39' => 'Answer39',
                    'answer_40' => 'Answer40',
                    'answer_41' => 'Answer41',
                    'answer_42' => 'Answer42',
                    'answer_43' => 'Answer43',
                    'answer_44' => 'Answer44',
                    'answer_45' => 'Answer45',
                    'answer_46' => 'Answer46',
                    'answer_47' => 'Answer47',
                    'answer_48' => 'Answer48',
                    'answer_49' => 'Answer49',
                    'answer_50' => 'Answer50'
        ));
    }
}
class Survey_Options extends CRUD
{
    protected $Id;
    protected $QuestionId;
    protected $Option;
    protected $Number;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'survey_options';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'question_id' => 'QuestionId',
        			'number' => 'Number',
                    'option' => 'Option'
        ));
    }
}
class Survey_Questions extends CRUD
{
    protected $Id;
    protected $SurveyId;
    protected $Question;
    protected $Type;
    protected $Number;
    protected $IsMust;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'survey_questions';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'survey_id' => 'SurveyId',
                    'question' => 'Question',
                    'type' => 'Type',
        			'is_must' => 'IsMust',
                    'number' => 'Number'
        ));
    }
}
class Survey_Teacher extends CRUD
{
    protected $Id;
    protected $Title;
    protected $Comment;
    protected $CreateDate;
    protected $State;
    protected $IsAnonymity;
    protected $OwnerId;
    protected $ReleaseDate;
    protected $EndDate;
    protected $TargetName;
    protected $TargetList;
    protected $First;
    protected $Remark;
    protected $CompletedSum;
    protected $PendingSum;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'survey_teacher';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'title' => 'Title',
                    'comment' => 'Comment',
                    'create_date' => 'CreateDate',
                    'state' => 'State',
                    'is_anonymity' => 'IsAnonymity',
                    'owner_id' => 'OwnerId',
                    'release_date' => 'ReleaseDate',
                    'end_date' => 'EndDate',
                    'target_name' => 'TargetName',
                    'target_list' => 'TargetList',
                    'first' => 'First',
                    'remark' => 'Remark',
                    'completed_sum' => 'CompletedSum',
                    'pending_sum' => 'PendingSum'
        ));
    }
}
class Survey_Teacher_Answers extends CRUD
{
    protected $Id;
    protected $SurveyId;
    protected $UserId;
    protected $Uid;
    protected $Name;
    protected $Sex;
    protected $IdType;
    protected $CardId;
    protected $ClassName;
    protected $UserName;
    protected $Date;
    protected $Answer1;
    protected $Answer2;
    protected $Answer3;
    protected $Answer4;
    protected $Answer5;
    protected $Answer6;
    protected $Answer7;
    protected $Answer8;
    protected $Answer9;
    protected $Answer10;
    protected $Answer11;
    protected $Answer12;
    protected $Answer13;
    protected $Answer14;
    protected $Answer15;
    protected $Answer16;
    protected $Answer17;
    protected $Answer18;
    protected $Answer19;
    protected $Answer20;
    protected $Answer21;
    protected $Answer22;
    protected $Answer23;
    protected $Answer24;
    protected $Answer25;
    protected $Answer26;
    protected $Answer27;
    protected $Answer28;
    protected $Answer29;
    protected $Answer30;
    protected $Answer31;
    protected $Answer32;
    protected $Answer33;
    protected $Answer34;
    protected $Answer35;
    protected $Answer36;
    protected $Answer37;
    protected $Answer38;
    protected $Answer39;
    protected $Answer40;
    protected $Answer41;
    protected $Answer42;
    protected $Answer43;
    protected $Answer44;
    protected $Answer45;
    protected $Answer46;
    protected $Answer47;
    protected $Answer48;
    protected $Answer49;
    protected $Answer50;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'survey_teacher_answers';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'survey_id' => 'SurveyId',
                    'user_id' => 'UserId',
                    'uid' => 'Uid',
                    'name' => 'Name',
                    'sex' => 'Sex',
                    'id_type' => 'IdType',
                    'card_id' => 'CardId',
                    'class_name' => 'ClassName',
                    'user_name' => 'UserName',
                    'date' => 'Date',
                    'answer_1' => 'Answer1',
                    'answer_2' => 'Answer2',
                    'answer_3' => 'Answer3',
                    'answer_4' => 'Answer4',
                    'answer_5' => 'Answer5',
                    'answer_6' => 'Answer6',
                    'answer_7' => 'Answer7',
                    'answer_8' => 'Answer8',
                    'answer_9' => 'Answer9',
                    'answer_10' => 'Answer10',
                    'answer_11' => 'Answer11',
                    'answer_12' => 'Answer12',
                    'answer_13' => 'Answer13',
                    'answer_14' => 'Answer14',
                    'answer_15' => 'Answer15',
                    'answer_16' => 'Answer16',
                    'answer_17' => 'Answer17',
                    'answer_18' => 'Answer18',
                    'answer_19' => 'Answer19',
                    'answer_20' => 'Answer20',
                    'answer_21' => 'Answer21',
                    'answer_22' => 'Answer22',
                    'answer_23' => 'Answer23',
                    'answer_24' => 'Answer24',
                    'answer_25' => 'Answer25',
                    'answer_26' => 'Answer26',
                    'answer_27' => 'Answer27',
                    'answer_28' => 'Answer28',
                    'answer_29' => 'Answer29',
                    'answer_30' => 'Answer30',
                    'answer_31' => 'Answer31',
                    'answer_32' => 'Answer32',
                    'answer_33' => 'Answer33',
                    'answer_34' => 'Answer34',
                    'answer_35' => 'Answer35',
                    'answer_36' => 'Answer36',
                    'answer_37' => 'Answer37',
                    'answer_38' => 'Answer38',
                    'answer_39' => 'Answer39',
                    'answer_40' => 'Answer40',
                    'answer_41' => 'Answer41',
                    'answer_42' => 'Answer42',
                    'answer_43' => 'Answer43',
                    'answer_44' => 'Answer44',
                    'answer_45' => 'Answer45',
                    'answer_46' => 'Answer46',
                    'answer_47' => 'Answer47',
                    'answer_48' => 'Answer48',
                    'answer_49' => 'Answer49',
                    'answer_50' => 'Answer50'
        ));
    }
}
class Survey_Teacher_Options extends CRUD
{
    protected $Id;
    protected $QuestionId;
    protected $Option;
    protected $Number;
    protected $IsMust;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'survey_teacher_options';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'question_id' => 'QuestionId',
                    'option' => 'Option',
                    'number' => 'Number',
        			'is_must' => 'IsMust'
        ));
    }
}
class Survey_Teacher_Questions extends CRUD
{
    protected $Id;
    protected $SurveyId;
    protected $Question;
    protected $Type;
    protected $IsMust;
    protected $Number;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'survey_teacher_questions';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'survey_id' => 'SurveyId',
                    'question' => 'Question',
                    'type' => 'Type',
        			'is_must' => 'IsMust',
                    'number' => 'Number'
        ));
    }
}
class Survey_Appraise extends CRUD
{
	protected $Id;
	protected $Title;
	protected $State;
	protected $Type;
	protected $Info;
	protected $CreateDate;
	protected $ReleaseDate;
	protected $EndDate;
	protected $Comment;
	protected $IsDeleted;
	protected $IsAuto;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'survey_appraise';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'title' => 'Title',
				'state' => 'State',
				'info' => 'Info',
				'type' => 'Type',
				'create_date' => 'CreateDate',
				'release_date' => 'ReleaseDate',
				'end_date' => 'EndDate',
				'is_deleted' => 'IsDeleted',
				'is_auto' => 'IsAuto',
				'comment' => 'Comment'
		));
	}
}
class Survey_Appraise_Answers extends CRUD
{
	protected $Id;
	protected $AppraiseId;
	protected $Uid;
	protected $OwnerClassId;
	protected $Info;
	protected $ClassId;
	protected $Date;
	protected $Parameter;
	protected $Suggest;
	protected $Answer1;
	protected $Answer2;
	protected $Answer3;
	protected $Answer4;
	protected $Answer5;
	protected $Answer6;
	protected $Answer7;
	protected $Answer8;
	protected $Answer9;
	protected $Answer10;
	protected $Answer11;
	protected $Answer12;
	protected $Answer13;
	protected $Answer14;
	protected $Answer15;
	protected $Answer16;
	protected $Answer17;
	protected $Answer18;
	protected $Answer19;
	protected $Answer20;
	protected $Answer21;
	protected $Answer22;
	protected $Answer23;
	protected $Answer24;
	protected $Answer25;
	protected $Answer26;
	protected $Answer27;
	protected $Answer28;
	protected $Answer29;
	protected $Answer30;
	protected $Answer31;
	protected $Answer32;
	protected $Answer33;
	protected $Answer34;
	protected $Answer35;
	protected $Answer36;
	protected $Answer37;
	protected $Answer38;
	protected $Answer39;
	protected $Answer40;
	protected $Answer41;
	protected $Answer42;
	protected $Answer43;
	protected $Answer44;
	protected $Answer45;
	protected $Answer46;
	protected $Answer47;
	protected $Answer48;
	protected $Answer49;
	protected $Answer50;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'survey_appraise_answers';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'appraise_id' => 'AppraiseId',
				'uid' => 'Uid',
				'owner_class_id' => 'OwnerClassId',
				'info' => 'Info',
				'class_id' => 'ClassId',
				'parameter' => 'Parameter',
				'suggest' => 'Suggest',
				'date' => 'Date',
				'answer_1' => 'Answer1',
				'answer_2' => 'Answer2',
				'answer_3' => 'Answer3',
				'answer_4' => 'Answer4',
				'answer_5' => 'Answer5',
				'answer_6' => 'Answer6',
				'answer_7' => 'Answer7',
				'answer_8' => 'Answer8',
				'answer_9' => 'Answer9',
				'answer_10' => 'Answer10',
				'answer_11' => 'Answer11',
				'answer_12' => 'Answer12',
				'answer_13' => 'Answer13',
				'answer_14' => 'Answer14',
				'answer_15' => 'Answer15',
				'answer_16' => 'Answer16',
				'answer_17' => 'Answer17',
				'answer_18' => 'Answer18',
				'answer_19' => 'Answer19',
				'answer_20' => 'Answer20',
				'answer_21' => 'Answer21',
				'answer_22' => 'Answer22',
				'answer_23' => 'Answer23',
				'answer_24' => 'Answer24',
				'answer_25' => 'Answer25',
				'answer_26' => 'Answer26',
				'answer_27' => 'Answer27',
				'answer_28' => 'Answer28',
				'answer_29' => 'Answer29',
				'answer_30' => 'Answer30',
				'answer_31' => 'Answer31',
				'answer_32' => 'Answer32',
				'answer_33' => 'Answer33',
				'answer_34' => 'Answer34',
				'answer_35' => 'Answer35',
				'answer_36' => 'Answer36',
				'answer_37' => 'Answer37',
				'answer_38' => 'Answer38',
				'answer_39' => 'Answer39',
				'answer_40' => 'Answer40',
				'answer_41' => 'Answer41',
				'answer_42' => 'Answer42',
				'answer_43' => 'Answer43',
				'answer_44' => 'Answer44',
				'answer_45' => 'Answer45',
				'answer_46' => 'Answer46',
				'answer_47' => 'Answer47',
				'answer_48' => 'Answer48',
				'answer_49' => 'Answer49',
				'answer_50' => 'Answer50'
		));
	}
}
class Survey_Appraise_Info_Item extends CRUD
{
	protected $Id;
	protected $Name;
	protected $Type;
	protected $Number;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'survey_appraise_info_item';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'name' => 'Name',
				'type' => 'Type',
				'number' => 'Number'
		));
	}
}
class Survey_Appraise_Options extends CRUD
{
	protected $Id;
	protected $QuestionId;
	protected $Option;
	protected $Number;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'survey_appraise_options';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'question_id' => 'QuestionId',
				'option' => 'Option',
				'number' => 'Number'
		));
	}
}
class Survey_Appraise_Questions extends CRUD
{
	protected $Id;
	protected $AppraiseId;
	protected $Question;
	protected $Type;
	protected $Number;
	protected $IsMust;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'survey_appraise_questions';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'appraise_id' => 'AppraiseId',
				'question' => 'Question',
				'type' => 'Type',
				'is_must' => 'IsMust',
				'number' => 'Number'
		));
	}
}
class Survey_Appraise_Answers_View extends CRUD
{
	protected $Id;
	protected $AppraiseId;
	protected $Suggest;
	protected $Parameter;
	protected $IsAuto;
	protected $Uid;
	protected $OwnerClassId;
	protected $ClassId;
	protected $ClassName;
	protected $OwnerName;
	protected $AppraiseTitle;
	protected $AppraiseState;
	protected $AppraiseType;
	protected $AppraiseInfo;
	protected $Info;
	protected $Date;
	protected $Answer1;
	protected $Answer2;
	protected $Answer3;
	protected $Answer4;
	protected $Answer5;
	protected $Answer6;
	protected $Answer7;
	protected $Answer8;
	protected $Answer9;
	protected $Answer10;
	protected $Answer11;
	protected $Answer12;
	protected $Answer13;
	protected $Answer14;
	protected $Answer15;
	protected $Answer16;
	protected $Answer17;
	protected $Answer18;
	protected $Answer19;
	protected $Answer20;
	protected $Answer21;
	protected $Answer22;
	protected $Answer23;
	protected $Answer24;
	protected $Answer25;
	protected $Answer26;
	protected $Answer27;
	protected $Answer28;
	protected $Answer29;
	protected $Answer30;
	protected $Answer31;
	protected $Answer32;
	protected $Answer33;
	protected $Answer34;
	protected $Answer35;
	protected $Answer36;
	protected $Answer37;
	protected $Answer38;
	protected $Answer39;
	protected $Answer40;
	protected $Answer41;
	protected $Answer42;
	protected $Answer43;
	protected $Answer44;
	protected $Answer45;
	protected $Answer46;
	protected $Answer47;
	protected $Answer48;
	protected $Answer49;
	protected $Answer50;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'survey_appraise_answers_view';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'appraise_id' => 'AppraiseId',
				'suggest' => 'Suggest',
				'parameter' => 'Parameter',
				'is_auto' => 'IsAuto',
				'uid' => 'Uid',
				'owner_class_id' => 'OwnerClassId',
				'class_id' => 'ClassId',
				'class_name' => 'ClassName',
				'owner_name' => 'OwnerName',
				'appraise_title' => 'AppraiseTitle',
				'appraise_state' => 'AppraiseState',
				'appraise_type' => 'AppraiseType',
				'appraise_info' => 'AppraiseInfo',
				'info' => 'Info',
				'date' => 'Date',
				'answer_1' => 'Answer1',
				'answer_2' => 'Answer2',
				'answer_3' => 'Answer3',
				'answer_4' => 'Answer4',
				'answer_5' => 'Answer5',
				'answer_6' => 'Answer6',
				'answer_7' => 'Answer7',
				'answer_8' => 'Answer8',
				'answer_9' => 'Answer9',
				'answer_10' => 'Answer10',
				'answer_11' => 'Answer11',
				'answer_12' => 'Answer12',
				'answer_13' => 'Answer13',
				'answer_14' => 'Answer14',
				'answer_15' => 'Answer15',
				'answer_16' => 'Answer16',
				'answer_17' => 'Answer17',
				'answer_18' => 'Answer18',
				'answer_19' => 'Answer19',
				'answer_20' => 'Answer20',
				'answer_21' => 'Answer21',
				'answer_22' => 'Answer22',
				'answer_23' => 'Answer23',
				'answer_24' => 'Answer24',
				'answer_25' => 'Answer25',
				'answer_26' => 'Answer26',
				'answer_27' => 'Answer27',
				'answer_28' => 'Answer28',
				'answer_29' => 'Answer29',
				'answer_30' => 'Answer30',
				'answer_31' => 'Answer31',
				'answer_32' => 'Answer32',
				'answer_33' => 'Answer33',
				'answer_34' => 'Answer34',
				'answer_35' => 'Answer35',
				'answer_36' => 'Answer36',
				'answer_37' => 'Answer37',
				'answer_38' => 'Answer38',
				'answer_39' => 'Answer39',
				'answer_40' => 'Answer40',
				'answer_41' => 'Answer41',
				'answer_42' => 'Answer42',
				'answer_43' => 'Answer43',
				'answer_44' => 'Answer44',
				'answer_45' => 'Answer45',
				'answer_46' => 'Answer46',
				'answer_47' => 'Answer47',
				'answer_48' => 'Answer48',
				'answer_49' => 'Answer49',
				'answer_50' => 'Answer50'
		));
	}
}
?>