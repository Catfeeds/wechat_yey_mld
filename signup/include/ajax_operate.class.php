<?php
error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
class Operate extends Bn_Basic {
	public function WechatLogin($n_uid) {
		setcookie ( 'VISITER', '', 0 );//保存为OpenId
		$o_signup_login=new Student_Info_Print_Login();
		$o_signup_login->PushWhere ( array ('&&', 'SessionId', '=',$_COOKIE ['SESSIONID']) );
		if ($o_signup_login->getAllCount()>0)
		{
			setcookie ( 'VISITER',$o_signup_login->getOpenId(0), 0 ,'/','',false,true );
			$a_general = array (
				'flag' => 1
			);
		}else{
			$a_general = array (
				'flag' => 0
			);
		}
		echo (json_encode ( $a_general ));
	}
}
?>