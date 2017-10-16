<?php
define ( 'RELATIVITY_PATH', '../../' );
error_reporting ( 0 );
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );

require_once 'include/db_table.class.php';
function XmlOutValue($xml, $node1, $node2) {
	$temp = explode ( $node1, $xml );
	if (count ( $temp ) > 1) {
		$temp = explode ( $node2, $temp [1] );
		return $temp [0];
	}
	return '';
}
function XmlOutType($xml) {
	$s_html = '';
	$temp = explode ( 'db:tag', $xml );
	if (count ( $temp ) > 1) {
		for($i = 1; $i < count ( $temp ); $i ++) {
			$temp2 = explode ( 'name="', $temp [$i] );
			for($j = 1; $j < count ( $temp2 ); $j ++) {
				$temp3 = explode ( '"', $temp2 [$j] );
				$s_html .= $temp3 [0] . ';';
			}
		}
	}
	return $s_html;
}
$o_temp = new Book_Info_Stu ();
$o_temp->PushWhere ( array ('&&', 'Title', '=', '' ) );
$o_temp->setStartLine ( 0 );
$o_temp->setCountLine ( 1 );
$n_allcount = $o_temp->getAllCount ();
$n_count = $o_temp->getCount ();
if ($n_count > 0) {
	//开始读取
	//读取图书信息
	$s_xml = file_get_contents ( 'http://api.douban.com/book/subject/isbn/' . $o_temp->getIsbn ( 0 ) . '?apikey=0d0c6bd8d5d61a0d2725438a81824e27' );
	if (XmlOutValue ( $s_xml, '<db:attribute name="title">', '</db:attribute>' ) == '') {
		//没读出来，跳过
		$o_temp2 = new Book_Info_Stu ($o_temp->getId(0));
		$o_temp2->setTitle('未知');
		$o_temp2->Save();
	} else {
		//写入数据库
		//先查找有没有这个本书
		$o_book2 = new Book_Info_Stu ($o_temp->getId(0));
		$o_book2->setIsbn ( $o_temp->getIsbn ( 0 ) );
		$o_book2->setTitle ( XmlOutValue ( $s_xml, '<db:attribute name="title">', '</db:attribute>' ) );
		$o_book2->setPages ( XmlOutValue ( $s_xml, '<db:attribute name="pages">', '</db:attribute>' ) );
		$o_book2->setAuthor ( XmlOutValue ( $s_xml, '<db:attribute name="author">', '</db:attribute>' ) );
		$o_book2->setPublisher ( XmlOutValue ( $s_xml, '<db:attribute name="publisher">', '</db:attribute>' ) );
		$o_book2->setBinding ( XmlOutValue ( $s_xml, '<db:attribute name="binding">', '</db:attribute>' ) );
		$o_book2->setPubdate ( XmlOutValue ( $s_xml, '<db:attribute name="pubdate">', '</db:attribute>' ) . '-1' );
		$o_book2->setPrice ( XmlOutValue ( $s_xml, '<db:attribute name="price">', '</db:attribute>' ) );
		mkdir ( RELATIVITY_PATH . 'userdata/book', 0777 );
		$s_image='http://img' . str_replace ( "spic", "mpic", XmlOutValue ( $s_xml, 'http://img', '"' ) ) ;
		copy($s_image,RELATIVITY_PATH.'userdata/book/'.$o_temp->getIsbn ( 0 ).'.jpg');
		$o_book2->setImg ('userdata/book/'.$o_temp->getIsbn ( 0 ).'.jpg');
		$o_book2->setSummary ( XmlOutValue ( $s_xml, '<summary>', '</summary>' ) );
		$s_tag=XmlOutType ( $s_xml );
		$o_book2->setTag ( $s_tag );
		$o_book2->setSum ( 1 );
		$o_date = new DateTime ( 'Asia/Chongqing' );
		$o_book2->setInOpen ( $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' ) );
		$o_book2->Save ();
	}
	echo ('正在导入 ' . $o_temp->getId ( 0 ));
	echo ('<script type="text/javascript">setTimeout(\'location.reload()\',3000);parent.refresh()</script>');
} else {
	echo ('已经全部完成<script type="text/javascript">setTimeout(\'location.reload()\',5000);parent.refresh()</script>');
}

?>