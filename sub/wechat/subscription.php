<?php
define ( 'RELATIVITY_PATH', '../../' );
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
$s_title='扫码关注';
require_once '../header.php';

?>
	<div class="page__hd">
        <h1 class="page__title" style="text-align:center;margin-top:50px;margin-top:0px;">长按二维码关注</h1>
    </div>
    <div style="margin:25%">
    <img src="images/qrcode.jpg" style="width:100%"/>
    </div>
<?php require_once '../footer.php';?>