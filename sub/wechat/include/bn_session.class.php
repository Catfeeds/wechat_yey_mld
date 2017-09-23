<?php
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
class Session extends Bn_Basic {
	private $O_User;
	private $S_UserIp;
	private $S_Agent;
	private $S_Session_Id;
	private $B_Login;
	
	public function __construct() {
		if (isset ( $_COOKIE ['SESSIONID'] )) {
			$this->S_Session_Id = $_COOKIE ['SESSIONID'];
			$uid = $this->FindUserName ( $this->S_Session_Id );
			if ($uid > 0) {
				$this->B_Login = true;
				$this->N_Uid = $uid;
			} else {
				$this->B_Login = false;
				$this->N_Uid = 0;
			}
		} else {
			$this->B_Login = false;
		}
	
	}
	public function Login() {
		return $this->B_Login;
	}
	private function FindUserName($s_sessionid) {
		$s_sessionid = str_replace ( '\'', '`', $s_sessionid );
		$o_user = new WX_User_Info ();
		$o_user->PushWhere ( array ('&&', 'SessionId', '=', $s_sessionid ) );
		//两个session都可以.只要满足一个
		$o_user->setItem ( array ('Id' ) );
		if ($o_user->getAllCount () > 0) {
			return $o_user->getId ( 0 );
		} else {
			return 0;
		}
	}
	public function getUid() {
		return $this->N_Uid;
	}
}
?>