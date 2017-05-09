<?php
//error_reporting ( 0 );
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/db_view.class.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
require_once RELATIVITY_PATH . 'include/bn_user.class.php';
require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
class Operate extends Bn_Basic {
	protected $N_PageSize= 50;
	
	public function MsgTable($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 100701 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new WX_Library ();
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Content', 'like','%'.$s_key.'%') );
		}
		$o_user->PushWhere ( array ('&&', 'MessageType', '=',1) );//只显示图文消息
		$o_user->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_user->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();//总记录数
		$n_count = $o_user->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {
			//数据行
			$a_button = array ();
			array_push ( $a_button, array (Text::Key('Modify'), "location='msg_modify.php?id=".$o_user->getId($i)."'" ) );//修改
			array_push ( $a_button, array (Text::Key('Delete'), "msg_delete('".$o_user->getId($i)."')" ) );//删除
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				'<span class="label label-primary">'.$o_user->getId ( $i ).'</span>',
				$this->AilterTextArea($o_user->getContent ( $i )),
				$a_button
				));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 50, 50);
		$a_title=$this->setTableTitle($a_title,'资源编号', 'Id', 0, 0);
		$a_title=$this->setTableTitle($a_title,'消息内容', 'Content', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 65, 65);
		$this->SendJsonResultForTable($n_allcount, 'MsgTable', 'yes', $n_page, $a_title, $a_row);
	}
	public function ImgmsgTable($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 100702 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new WX_Library ();
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Title', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'MessageType', '=',2) );//只显示图文消息
			$o_user->PushWhere ( array ('||', 'Description', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'MessageType', '=',2) );//只显示图文消息
		}else{
			$o_user->PushWhere ( array ('&&', 'MessageType', '=',2) );//只显示图文消息		
		}
		
		$o_user->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_user->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();//总记录数
		$n_count = $o_user->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {
			//数据行
			$a_button = array ();
			array_push ( $a_button, array (Text::Key('Modify'), "location='imgmsg_modify.php?id=".$o_user->getId($i)."'" ) );//修改
			array_push ( $a_button, array (Text::Key('Delete'), "imgmsg_delete(".$o_user->getId($i).")" ) );//删除
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				'<span class="label label-primary">'.$o_user->getId ( $i ).'</span>',
				$o_user->getTitle ( $i ),
				'<img style="width:58px;height:32px;cursor:pointer;" src="'.$o_user->getPicUrl ( $i ).'" onclick="open_photo(\''.$o_user->getPicUrl ( $i ).'\')">',
				$o_user->getDescription ( $i ),
				$a_button
				));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 0, 50);
		$a_title=$this->setTableTitle($a_title,'资源编号', 'Id', 0, 80);
		$a_title=$this->setTableTitle($a_title,'标题', 'Title', 0, 0);
		$a_title=$this->setTableTitle($a_title,'封面', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'摘要', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0, 65);
		$this->SendJsonResultForTable($n_allcount, 'ImgmsgTable', 'yes', $n_page, $a_title, $a_row);
	}
	public function ImgTable($n_uid)
	{
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (!$o_user->ValidModule ( 100703 ))return;//如果没有权限，不返回任何值
		$n_page=$this->getPost('page');
		if ($n_page<=0)$n_page=1;
		$o_user = new WX_Library ();
		$s_key=$this->getPost('key');
		if ($s_key!='')
		{
			$o_user->PushWhere ( array ('||', 'Description', 'like','%'.$s_key.'%') );
			$o_user->PushWhere ( array ('&&', 'MessageType', '=',3) );//只显示图文消息
		}else{
			$o_user->PushWhere ( array ('&&', 'MessageType', '=',3) );//只显示图文消息		
		}		
		$o_user->PushOrder ( array ($this->getPost('item'), $this->getPost('sort') ) );
		$o_user->setStartLine ( ($n_page - 1) * $this->N_PageSize ); //起始记录
		$o_user->setCountLine ( $this->N_PageSize );
		$n_count = $o_user->getAllCount ();
		if (($this->N_PageSize * ($n_page - 1)) >= $n_count) {
			$n_page = ceil ( $n_count / $this->N_PageSize );
			$o_user->setStartLine ( ($n_page - 1) * $this->N_PageSize );
			$o_user->setCountLine ( $this->N_PageSize );
		}
		$n_allcount = $o_user->getAllCount ();//总记录数
		$n_count = $o_user->getCount ();
		$a_row = array ();
		for($i = 0; $i < $n_count; $i ++) {
			//数据行
			$a_button = array ();
			array_push ( $a_button, array (Text::Key('Delete'), "img_delete('".$o_user->getId($i)."')" ) );//删除
			array_push ($a_row, array (
				($i+1+$this->N_PageSize*($n_page-1)),
				'<span class="label label-primary">'.$o_user->getId ( $i ).'</span>',
				'<img style="width:32px;height:32px;cursor:pointer;" src="'.$o_user->getPicUrl ( $i ).'" onclick="window.open(\''.$o_user->getPicUrl ( $i ).'\',\'_blank\')">',
				$o_user->getDescription ( $i ),
				$a_button
				));
		}
		//标题行,列名，排序名称，宽度，最小宽度
		$a_title = array ();
		$a_title=$this->setTableTitle($a_title,Text::Key('Number'), '', 0, 50);
		$a_title=$this->setTableTitle($a_title,'资源编号', 'Id', 0, 80);
		$a_title=$this->setTableTitle($a_title,'图片', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,'说明', '', 0, 0);
		$a_title=$this->setTableTitle($a_title,Text::Key('Operation'), '', 0, 65);
		$this->SendJsonResultForTable($n_allcount, 'ImgTable', 'yes', $n_page, $a_title, $a_row);
	}
	public function MsgAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 100701 ))return; //如果没有权限，不返回任何值
		$o_dept = new WX_Library ();
		sleep(1);
		$o_dept->setContent ($this->getPost('Content'));
		$o_dept->setMessageType(1);
		$o_dept->Save ();
		$this->setReturn ( 'parent.form_return("dialog_success(\'添加文字消息成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function MsgModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 100701 ))return; //如果没有权限，不返回任何值
		$o_dept = new WX_Library ($this->getPost('Id'));
		sleep(1);
		$o_dept->setContent ($this->getPost('Content'));
		$o_dept->setMessageType(1);
		$o_dept->Save ();
		$this->setReturn ( 'parent.form_return("dialog_success(\'修改文字消息成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function ImgmsgAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 100702 ))return; //如果没有权限，不返回任何值
		$o_dept = new WX_Library ();
		sleep(1);
		$o_dept->setTitle ($this->getPost('Title'));
		$o_dept->setMessageUrl ($this->getPost('MessageUrl'));
		$o_dept->setDescription ($this->getPost('Description'));
		$o_dept->setMessageType(2);
		if ($_FILES ['Vcl_File'] ['size'] > 0) {
			$o_sys = new Base_Setup (1);
			if ($_FILES ['Vcl_File'] ['size']>(1024*1024))
			{
				$this->setReturn ( 'parent.form_return("dialog_error(\''.Text::Key('PhotoUploadError02').'\')");' );
			}
			mkdir ( RELATIVITY_PATH . 'userdata/library', 0777 );
			$allowpictype = array ('jpg', 'jpeg', 'gif', 'png' );
			$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
			if (! in_array ( $fileext, $allowpictype )) {
				$this->setReturn ( 'parent.form_return("dialog_error(\''.Text::Key('PhotoUploadError').'\')");' );
			}
			//生成文件名=用户编号+当前时间戳
			$s_filename=$n_uid.'_'.$this->GetTimeCut().'.'.$fileext;
			$o_dept->setPicUrl ( $o_sys->getHomeUrl().'userdata/library/' . $s_filename );
			copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'userdata/library/' . $s_filename );
		}else{
			$this->setReturn ( 'parent.form_return("dialog_error(\'请选择“封面”文件！\')");' );
		}
		$o_dept->Save ();
		$this->setReturn ( 'parent.form_return("dialog_success(\'添加图文消息成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function ImgmsgModify($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 100702 ))return; //如果没有权限，不返回任何值
		$o_dept = new WX_Library ($this->getPost('Id'));
		sleep(1);
		$s_picurl=$o_dept->getPicUrl();
		$o_dept->setTitle ($this->getPost('Title'));
		$o_dept->setMessageUrl ($this->getPost('MessageUrl'));
		$o_dept->setDescription ($this->getPost('Description'));
		$o_dept->setMessageType(2);
		if ($_FILES ['Vcl_File'] ['size'] > 0) {
			$o_sys = new Base_Setup (1);
			if ($_FILES ['Vcl_File'] ['size']>(1024*1024))
			{
				$this->setReturn ( 'parent.form_return("dialog_error(\''.Text::Key('PhotoUploadError02').'\')");' );
			}
			mkdir ( RELATIVITY_PATH . 'userdata/library', 0777 );
			$allowpictype = array ('jpg', 'jpeg', 'gif', 'png' );
			$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
			if (! in_array ( $fileext, $allowpictype )) {
				$this->setReturn ( 'parent.form_return("dialog_error(\''.Text::Key('PhotoUploadError').'\')");' );
			}
			//生成文件名=用户编号+当前时间戳
			$s_filename=$n_uid.'_'.$this->GetTimeCut().'.'.$fileext;
			//先删除旧的图片
			$a_url = explode('/' ,$s_picurl); 
			unlink(RELATIVITY_PATH . 'userdata/library/' . $a_url[count($a_url)-1]);
			//保存新文件
			$o_dept->setPicUrl ( $o_sys->getHomeUrl().'userdata/library/' . $s_filename );
			copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'userdata/library/' . $s_filename );
		}
		$o_dept->Save ();
		$this->setReturn ( 'parent.form_return("dialog_success(\'修改图文消息成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function ImgmsgDelete($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 100702 ))return; //如果没有权限，不返回任何值
		$o_dept = new WX_Library ($this->getPost('id'));
		
		sleep(1);
		if ($this->LibraryCheckDelete($this->getPost('id'))==false)//检查是否可以删除
		{
			return;
		}
		//先删除图片
		$s_picurl=$o_dept->getPicUrl();
		$a_url = explode('/' ,$s_picurl); 
		unlink(RELATIVITY_PATH . 'userdata/library/' . $a_url[count($a_url)-1]);
		$o_dept->Deletion();
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function ImgAdd($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 100703 ))return; //如果没有权限，不返回任何值
		$o_dept = new WX_Library ();
		//sleep(1);
		$o_dept->setDescription ($this->getPost('Description'));
		$o_dept->setMessageType(3);
		if ($_FILES ['Vcl_File'] ['size'] > 0) {
			$o_sys = new Base_Setup (1);
			if ($_FILES ['Vcl_File'] ['size']>(1024*1024*2))
			{
				$this->setReturn ( 'parent.form_return("dialog_error(\''.Text::Key('PhotoUploadError03').'\')");' );
			}
			mkdir ( RELATIVITY_PATH . 'userdata/library', 0777 );
			$allowpictype = array ('jpg', 'jpeg', 'gif', 'png' );
			$fileext = strtolower ( trim ( substr ( strrchr ( $_FILES ['Vcl_File'] ['name'], '.' ), 1 ) ) );
			if (! in_array ( $fileext, $allowpictype )) {
				$this->setReturn ( 'parent.form_return("dialog_error(\''.Text::Key('PhotoUploadError').'\')");' );
			}
			//生成文件名=用户编号+当前时间戳
			$s_filename=$n_uid.'_'.$this->GetTimeCut().'.'.$fileext;
			$o_dept->setPicUrl ( $o_sys->getHomeUrl().'userdata/library/' . $s_filename );
			copy ( $_FILES ['Vcl_File'] ['tmp_name'], RELATIVITY_PATH . 'userdata/library/' . $s_filename );
			//上传至微信服务号图片库。
			$s_upload_result=$this->UploadImageToWechat($s_filename);
			if ($s_upload_result)
			{
				$o_dept->setMediaId ($s_upload_result['media_id']);
			}else{
				$this->setReturn ( 'parent.form_return("dialog_error(\'上传失败！\')");' );
			}
		}else{
			$this->setReturn ( 'parent.form_return("dialog_error(\'请选择“封面”文件！\')");' );
		}
		$o_dept->Save ();
		$this->setReturn ( 'parent.form_return("dialog_success(\'添加图片消息成功！\',function(){parent.location=\''.$this->getPost('BackUrl').'\'})");' );
	}
	public function UploadImageToWechat($s_filename){
		$file_info = array(
            'filename' => $_FILES['image']['name'],
            'content-type' => $_FILES['image']['type'],
            'filelength' => $_FILES['image']['size']
        );
		require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
	    $token = new accessToken();
	    $ACC_TOKEN= $token->access_token;
	    $URL = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=".$ACC_TOKEN."&type=image";
	    $ch1 = curl_init ();
	    $timeout = 5;
	    $real_path = dirname(__FILE__)."/userdata/library/{$s_filename}";
	    $real_path=str_replace("\\sub\\library\\include", "", $real_path);
	    $real_path=str_replace("/", "\\", $real_path);
	    $data = array("media"=>"@{$real_path}",'form-data'=>$file_info);
	    curl_setopt ( $ch1, CURLOPT_URL, $URL );
	    curl_setopt ( $ch1, CURLOPT_POST, 1 );
	    curl_setopt ( $ch1, CURLOPT_RETURNTRANSFER, 1 );
	    curl_setopt ( $ch1, CURLOPT_CONNECTTIMEOUT, $timeout );
	    curl_setopt ( $ch1, CURLOPT_SSL_VERIFYPEER, false );
	    curl_setopt ( $ch1, CURLOPT_SSL_VERIFYHOST, false );
	    curl_setopt ( $ch1, CURLOPT_POSTFIELDS, $data );
	//    var_dump($ch1);
	    $result = curl_exec ( $ch1 );
	    curl_close ( $ch1 );
	    if(curl_errno()==0){
	        $result  = json_decode($result,true);
	        return $result;
	    }else {
	        return false;
	    }
	}
	public function ImgDelete($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 100703 ))return; //如果没有权限，不返回任何值
		$o_dept = new WX_Library ($this->getPost('id'));
		sleep(1);
		if ($this->LibraryCheckDelete($this->getPost('id'))==false)//检查是否可以删除
		{
			return;
		}
		//先删除图片
		$s_picurl=$o_dept->getPicUrl();
		$a_url = explode('/' ,$s_picurl); 
		unlink(RELATIVITY_PATH . 'userdata/library/' . $a_url[count($a_url)-1]);
		$o_dept->Deletion();
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function MsgDelete($n_uid) {
		if (! ($n_uid > 0)) {
			$this->setReturn('parent.goto_login()');
		}
		$o_user = new Single_User ( $n_uid );
		if (! $o_user->ValidModule ( 100701 ))return; //如果没有权限，不返回任何值
		$o_dept = new WX_Library ($this->getPost('id'));
		sleep(1);
		if ($this->LibraryCheckDelete($this->getPost('id'))==false)//检查是否可以删除
		{
			return;
		}
		$o_dept->Deletion();
		$a_general = array (
			'success' => 1,
			'text' =>''
		);
		echo (json_encode ( $a_general ));
	}
	public function LibraryCheckDelete($id)
	{
		//检查是否有关键字正在使用这个资源
		$o_temp=new WX_Keyword();
		$o_temp->PushWhere ( array ('||', 'LibraryId', '=',$id) );
		if ($o_temp->getAllCount()>0)
		{
			$a_general = array (
				'success' => 0,
				'text' => '对不起，有关键字回复正在使用此资源，不能被删除！'
			);
			echo (json_encode ( $a_general ));
			return false;
		}
		//检查是否有菜单正在使用这个资源
		$o_temp=new WX_Menu();
		$o_temp->PushWhere ( array ('||', 'LibraryId', '=',$id) );
		if ($o_temp->getAllCount()>0)
		{
			$a_general = array (
				'success' => 0,
				'text' => '对不起，有自定义菜单正在使用此资源，不能被删除！'
			);
			echo (json_encode ( $a_general ));
			return false;
		}
		$o_temp=new WX_Menu_Sub();
		$o_temp->PushWhere ( array ('||', 'LibraryId', '=',$id) );
		if ($o_temp->getAllCount()>0)
		{
			$a_general = array (
				'success' => 0,
				'text' => '对不起，有自定义菜单正在使用此资源，不能被删除！'
			);
			echo (json_encode ( $a_general ));
			return false;
		}
		//检查是否有二维码正在使用这个资源
		$o_temp=new WX_Activity();
		$o_temp->PushWhere ( array ('||', 'LibraryId', '=',$id) );
		if ($o_temp->getAllCount()>0)
		{
			$a_general = array (
				'success' => 0,
				'text' => '对不起，有二维码正在使用此资源，不能被删除！'
			);
			echo (json_encode ( $a_general ));
			return false;
		}
		return true;
	}
}

?>