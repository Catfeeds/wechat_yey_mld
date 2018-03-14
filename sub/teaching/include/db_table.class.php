<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Teaching_Wei_Teach extends CRUD
{
    protected $Id;
    protected $OwnerId;
    protected $CreateDate;
    protected $ReleaseDate;
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
        return 'teaching_wei_teach';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'owner_id' => 'OwnerId',
                    'create_date' => 'CreateDate',
                    'release_date' => 'ReleaseDate',
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
class Teaching_Wei_Teach_View extends CRUD
{
    protected $Id;
    protected $OwnerId;
    protected $OwnerName;
    protected $CreateDate;
    protected $ReleaseDate;
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
        return 'teaching_wei_teach_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'owner_id' => 'OwnerId',
                    'owner_name' => 'OwnerName',
                    'create_date' => 'CreateDate',
                    'release_date' => 'ReleaseDate',
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
class Teaching_H5_View extends CRUD
{
    protected $Id;
    protected $OwnerId;
    protected $OwnerName;
    protected $CreateDate;
    protected $ReleaseDate;
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
        return 'teaching_h5_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'owner_id' => 'OwnerId',
                    'owner_name' => 'OwnerName',
                    'create_date' => 'CreateDate',
                    'release_date' => 'ReleaseDate',
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
class Teaching_H5 extends CRUD
{
    protected $Id;
    protected $OwnerId;
    protected $CreateDate;
    protected $ReleaseDate;
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
        return 'teaching_h5';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'owner_id' => 'OwnerId',
                    'create_date' => 'CreateDate',
                    'release_date' => 'ReleaseDate',
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
class Teaching_News_View extends CRUD
{
	protected $Id;
	protected $OwnerId;
	protected $OwnerName;
	protected $CreateDate;
	protected $ReleaseDate;
	protected $State;
	protected $Title;
	protected $Comment;
	protected $Target;
	protected $TargetName;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'teaching_news_view';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'owner_id' => 'OwnerId',
				'owner_name' => 'OwnerName',
				'create_date' => 'CreateDate',
				'release_date' => 'ReleaseDate',
				'state' => 'State',
				'title' => 'Title',
				'comment' => 'Comment',
				'target' => 'Target',
				'target_name' => 'TargetName'
		));
	}
}
class Teaching_News extends CRUD
{
	protected $Id;
	protected $OwnerId;
	protected $CreateDate;
	protected $ReleaseDate;
	protected $State;
	protected $Title;
	protected $Comment;
	protected $Target;
	protected $TargetName;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'teaching_news';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'owner_id' => 'OwnerId',
				'create_date' => 'CreateDate',
				'release_date' => 'ReleaseDate',
				'state' => 'State',
				'title' => 'Title',
				'comment' => 'Comment',
				'target' => 'Target',
				'target_name' => 'TargetName'
		));
	}
}
class Teaching_News_List extends CRUD
{
	protected $Id;
	protected $NewsId;
	protected $Comment;
	protected $Icon;
	protected $Link;
	protected $Number;
	protected $VisitorNum;
	
	protected function DefineKey()
	{
		return 'id';
	}
	protected function DefineTableName()
	{
		return 'teaching_news_list';
	}
	protected function DefineRelationMap()
	{
		return(array(
				'id' => 'Id',
				'news_id' => 'NewsId',
				'comment' => 'Comment',
				'icon' => 'Icon',
				'link' => 'Link',
				'number' => 'Number',
				'visitor_num' => 'VisitorNum'
		));
	}
}
?>