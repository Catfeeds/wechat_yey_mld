<?php
define ( 'RELATIVITY_PATH', '../../' );
error_reporting(E_ERROR);
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/phpqrcode.php';

$s_url=str_replace($_SERVER["PHP_SELF"], '', $_SERVER["REQUEST_URI"]);

$o_system=new Base_Setup(1);
$url=urldecode($o_system->getHomeUrl().'sub/wechat/teacher_operation/appraise_answer.php'.$s_url);
QRcode::png($url,false,QR_ECLEVEL_H,5,2,false); 
break;
?>