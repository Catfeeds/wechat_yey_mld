<?php
error_reporting ( 0 );
define('KEY', 'www.bjsql.com'); //同步信息所使用的秘钥
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 25;
	public function SyncClass($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		sleep(1);
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 120203 ))return; //如果没有权限，不返回任何值
		//获取当前系统DeptId编号
		$o_setup=new Admission_Setup(1);
		$s_deptid=$o_setup->getDeptId();
		$s_data = $this->Encrypt ( $s_deptid, 'E', KEY );
		$request_data = array('deptid'=>$s_data);
		$a_result_data=json_decode($this->HttpsRequest('http://yeygl.xchjw.cn/sub/webservice/download_class.php',$request_data));
		if($a_result_data->Flag==1)
		{
			$a_data=$a_result_data->Data;
			if (count($a_data)>0)
			{
				//先清空班				
				$o_class=new Student_Class();
				$o_class->DeleteAll();
			}
			//开始同步本地班级数据
			for($i=0;$i<count($a_data);$i++)
			{
				$a_temp=$a_data[$i];	
				$o_class=new Student_Class();
				$o_class->setClassId($a_temp->ClassId);
				$o_class->setSchoolId($s_deptid);
				$o_class->setClassNumber(0);
				$o_class->setClassName($a_temp->ClassName);
				$o_class->setGrade($a_temp->Grade);
				$o_class->Save();		
			}			
			$a_result = array (
	        	'flag'=>1,
	        ); 
		}else{
			if ($a_result_data=='')
			{
				$a_result = array (
	        		'flag'=>0,
	        		'msg'=>'信息采集系统服务器未响应，请重试！'
        		);
			}else{
				$a_result = array (
	        		'flag'=>0,
	        		'msg'=>'错误代码：'.$a_result_data->Msg
        		);
			}
		}           
		echo(json_encode ($a_result));
	}
}

?>