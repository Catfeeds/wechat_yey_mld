<?php
$n_admin=1;
$n_signup_admin=1;	
function comment_type_switch($s_comment,$s_type)
{
	if ($s_type=='img')
	{
		return '<div style="
				width:170px;
				height:150px;
				background-image:url(\''.RELATIVITY_PATH.$s_comment.'\');
				background-position:center center;
				background-repeat:no-repeat;
				background-size:100%; 
				" onclick="location=\''.RELATIVITY_PATH.$s_comment.'\'"></div>';
	}else{
		return $s_comment;
	}
}
?>