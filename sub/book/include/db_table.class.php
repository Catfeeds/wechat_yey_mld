<?php
require_once RELATIVITY_PATH.'include/db_operate.class.php';
require_once RELATIVITY_PATH.'include/db_connect.class.php';
class Book_Info_Stu extends CRUD
{
    protected $Id;
    protected $Isbn;
    protected $ClassId;
    protected $Title;
    protected $Pages;
    protected $Author;
    protected $Publisher;
    protected $Binding;
    protected $Pubdate;
    protected $Price;
    protected $Img;
    protected $Summary;
    protected $InOpen;
    protected $Sum;
    protected $Into;
    protected $OutSum;
    protected $State;
    protected $Tag;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'book_info_stu';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'isbn' => 'Isbn',
                    'class_id' => 'ClassId',
                    'title' => 'Title',
                    'pages' => 'Pages',
                    'author' => 'Author',
                    'publisher' => 'Publisher',
                    'binding' => 'Binding',
                    'pubdate' => 'Pubdate',
                    'price' => 'Price',
                    'img' => 'Img',
                    'summary' => 'Summary',
                    'in_open' => 'InOpen',
                    'sum' => 'Sum',
                    'into' => 'Into',
                    'out_sum' => 'OutSum',
                    'state' => 'State',
                    'tag' => 'Tag'
        ));
    }
}
?>