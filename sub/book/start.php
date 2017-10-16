<?php
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../../css/common.css" />
<script type="text/javascript" src="../../js/ajax.class.js"></script>
<script type="text/javascript" src="../../js/jquery.min.js"></script>
</head>
<body style="background-image:none">
<iframe id="xwfyfz" style="overflow:hidden" width="100%" height="100" marginwidth="0" border="0" frameborder="0" scrolling="no" src="start_sub.php"></iframe>
<script type="text/javascript">
var n_holland_handle1=0
function refresh()
{
	window.clearInterval(n_holland_handle1);    
    n_holland_handle1=setInterval(reloadpage,20000)
	}
function reloadpage()
{
	document.getElementById('xwfyfz').src="start_sub.php"
	}
n_holland_handle1=setInterval(refresh,20000)

</script>
</body>
</html>
