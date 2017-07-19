<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Teaching extends CRUD
{
    protected $Id;
    protected $OwnerId;
    protected $OwnerName;
    protected $CreateDate;
    protected $UpdateDate;
    protected $State;
    protected $Title;
    protected $Comment;
    protected $Video;
    protected $Icon;
    protected $Target;
    protected $TargetName;
    protected $VisitorNum;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'teaching';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'owner_id' => 'OwnerId',
                    'owner_name' => 'OwnerName',
                    'create_date' => 'CreateDate',
                    'update_date' => 'UpdateDate',
                    'state' => 'State',
                    'title' => 'Title',
                    'comment' => 'Comment',
                    'video' => 'Video',
                    'icon' => 'Icon',
                    'target' => 'Target',
                    'target_name' => 'TargetName',
                    'visitor_num' => 'VisitorNum'
        ));
    }
}
?>