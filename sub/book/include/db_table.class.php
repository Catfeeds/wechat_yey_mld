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
class Book_Info_Stu_Comment extends CRUD
{
    protected $Id;
    protected $BookId;
    protected $TeacherId;
    protected $Comment;
    protected $Date;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'book_info_stu_comment';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'book_id' => 'BookId',
                    'teacher_id' => 'TeacherId',
                    'comment' => 'Comment',
                    'date' => 'Date'
        ));
    }
}
class Book_Info_Stu_Location extends CRUD
{
    protected $Id;
    protected $BookId;
    protected $ClassId;
    protected $Sum;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'book_info_stu_location';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'book_id' => 'BookId',
                    'class_id' => 'ClassId',
                    'sum' => 'Sum'
        ));
    }
}
class Book_Info_Comment_View extends CRUD
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
    protected $TeacherId;
    protected $Comment;
    protected $CommentDate;
    protected $TeacherName;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'book_info_comment_view';
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
                    'tag' => 'Tag',
                    'teacher_id' => 'TeacherId',
                    'comment' => 'Comment',
                    'comment_date' => 'CommentDate',
                    'teacher_name' => 'TeacherName'
        ));
    }
}
class Book_Info_Teacher extends CRUD
{
    protected $Id;
    protected $Isbn;
    protected $Location;
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
        return 'book_info_teacher';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'isbn' => 'Isbn',
                    'location' => 'Location',
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
class Book_Info_Teacher_Borrow_View extends CRUD
{
    protected $Id;
    protected $BookId;
    protected $TeacherId;
    protected $BorrowDate;
    protected $ReturnDate;
    protected $TeacherName;
    protected $Isbn;
    protected $Title;
    protected $Img;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'book_info_teacher_borrow_view';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'book_id' => 'BookId',
                    'teacher_id' => 'TeacherId',
                    'borrow_date' => 'BorrowDate',
                    'return_date' => 'ReturnDate',
                    'teacher_name' => 'TeacherName',
                    'isbn' => 'Isbn',
                    'title' => 'Title',
                    'img' => 'Img'
        ));
    }
}
class Book_Info_Teacher_Borrow extends CRUD
{
    protected $Id;
    protected $BookId;
    protected $TeacherId;
    protected $BorrowDate;
    protected $ReturnDate;

    protected function DefineKey()
    {
        return 'id';
    }
    protected function DefineTableName()
    {
        return 'book_info_teacher_borrow';
    }
    protected function DefineRelationMap()
    {
        return(array(
                    'id' => 'Id',
                    'book_id' => 'BookId',
                    'teacher_id' => 'TeacherId',
                    'borrow_date' => 'BorrowDate',
                    'return_date' => 'ReturnDate'
        ));
    }
}
?>