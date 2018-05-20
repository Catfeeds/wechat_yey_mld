<?php
define ( 'RELATIVITY_PATH', '../' );
error_reporting(E_ERROR);
require_once RELATIVITY_PATH . 'include/phpqrcode.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
$o_system=new Base_Setup(1);
$url=urldecode($o_system->getHomeUrl().'sub/wechat/parent_signup/signup_computer_login.php?id='.$_GET['id']);
QRcode::png($url,false,QR_ECLEVEL_H,10,2,false);
?>