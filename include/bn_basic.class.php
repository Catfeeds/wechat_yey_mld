<?php
require_once RELATIVITY_PATH . 'include/db_table.class.php';
require_once RELATIVITY_PATH . 'include/it_systext.class.php';
require_once RELATIVITY_PATH . 'include/language_cn.php';
class Bn_Basic {
	protected $S_Root = '/';
	protected $B_Operate = false;
	protected $S_ErrorReasion; //出错提示
	protected $B_Success = true;
	protected $S_Content = '';
	protected $S_Title = '';
	protected $N_Uid;
	protected $S_UserName;
	protected $N_RoleId;
	protected $S_UserPhoto;
	protected $O_SelectItem=null;
	protected $N_SelectItemCount=0;
	protected function ImageCompress($s_from,$s_to,$n_percent)
	{
		require_once RELATIVITY_PATH . 'include/imageCompress.class.php';
		$o_image=new ImgCompress($s_from,$n_percent);
		$o_image->compressImg($s_to);
	}
	public function getWechatSetup($s_key)
	{
		require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
		$o_setup=new Wechat_Wx_Setup($s_key);
		return $o_setup->getValue();		
	}
	public function FilterUserInput($string) {
		//过滤< > />
		$string=str_replace('<', '', $string);
		$string=str_replace('>', '', $string);
		$string=str_replace('/>', '', $string);
		return $string;
	}
	public function getErrorReasion() {
		return $this->S_ErrorReasion;
	}
	private function _cny_map_unit($list,$units) { 
	    $ul=count($units); 
	    $xs=array(); 
	    foreach (array_reverse($list) as $x) { 
	        $l=count($xs); 
	        if ($x!="0" || !($l%4)) $n=($x=='0'?'':$x).($units[($l-1)%$ul]); 
	        else $n=is_numeric($xs[0][0])?$x:''; 
	        array_unshift($xs,$n); 
	    } 
	    return $xs; 
	}
	public function XmlOutValue($xml, $node1, $node2) {
		$temp = explode ( $node1, $xml );
		if (count ( $temp ) > 1) {
			$temp = explode ( $node2, $temp [1] );
			return $temp [0];
		}
		return '';
	}
	public function XmlOutType($xml) {
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
	public function setArray($a_array,$s_value)
	{
		if ($this->getPost($s_value)=='on')
		{
			array_push($a_array,$s_value);
		}
		return $a_array;
	}
	protected function getPost($s_key) {
		if ($_GET[$s_key]=='')
		{
			$s_str=$this->FilterUserInput($_POST ['Vcl_' . $s_key]);
			if ($s_key=='Name' ||$s_key=='Company' ||$s_key=='DeptJob' ||$s_key=='Phone' ||$s_key=='Email')
			{
				$s_str=str_replace('"', '', $s_str);
				$s_str=str_replace(',', '', $s_str);
				$s_str=str_replace(' ', '', $s_str);
				$s_str=$this->FilterEmoji($s_str);
			}
			return $s_str;
		}
		$s_str=$this->FilterUserInput($_GET[$s_key]);
		if ($s_key=='Name' ||$s_key=='Company' ||$s_key=='DeptJob' ||$s_key=='Phone' ||$s_key=='Email')
		{
			$s_str=str_replace('"', '', $s_str);
			$s_str=str_replace(',', '', $s_str);
			$s_str=str_replace(' ', '', $s_str);
			$s_str=$this->FilterEmoji($s_str);
		}
		return $s_str;
	}
	public function FilterEmoji($s_str)
	{
		$s_str = json_encode($s_str); //暴露出unicode
		$s_str=preg_replace("#(\\\ud[0-9a-f]{3})|(\\\ue[0-9a-f]{3})#ie","",$s_str);
		$s_str = json_decode($s_str);
		return $s_str;
	}
	protected function setEncode($s_value)
	{
		return rawurlencode($s_value);
	}
	protected function setReturn($s_script) {
		echo ('<script>' . $s_script . ';</script>');
		exit ( 0 );
	}
	protected function RemoveArrayRepeatValue($a_arr) {
		$tempArray = array ();
		foreach ( $a_arr as $one ) {
			$tempArray [$one] = true;
		
		}
		$arr = array_keys ( $tempArray );
		return $arr;
	}
	public function getSuccess() {
		return $this->B_Success;
	}
	protected function fileext($filename) {
		return strtolower ( trim ( substr ( strrchr ( $filename, '.' ), 1 ) ) );
	}
	public function FileSize($n_filesize) {
		return $this->getFilesize ( $n_filesize );
	}
	protected function getFilesize($n_filesize) {
		if ($n_filesize >= (1024 * 1024)) {
			$n_filesize = $n_filesize / (1024 * 1024);
			$n_filesize = round ( $n_filesize, 2 );
			return $n_filesize . ' G';
		} else if ($n_filesize > (1024)) {
			$n_filesize = $n_filesize / 1024;
			$n_filesize = round ( $n_filesize, 2 );
			return $n_filesize . ' MB';
		} else {
			return $n_filesize . ' KB';
		}
	
	}
	protected function TimeAccount($n_time, $s_update) {
		try {
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$n_nowTime = $o_date->format ( 'U' );
			$n_result = $n_nowTime - $n_time;
			if ($n_result < 60) {
				return $n_result . ' ' . SysText::Index ( '014' );
			}
			if ($n_result >= 60 && $n_result < 3600) {
				return ( int ) ($n_result / 60) . ' ' . SysText::Index ( '015' );
			}
			if ($n_result >= 3600 && $n_result < 86400) {
				return ( int ) ($n_result / 3600) . ' ' . SysText::Index ( '016' );
			}
			if ($n_result >= 86400 && $n_result < 961200) {
				return ( int ) ($n_result / 86400) . ' ' . SysText::Index ( '017' );
			}
			$a_temp = explode ( ' ', $s_update );
			$a_time = explode ( ':', $a_temp [1] );
			return $a_temp [0] . ' ' . $a_time [0] . ':' . $a_time [1];
		} catch ( exception $err ) {
			return '';
		}
	}
	protected function GetWeekByNumber() {
		$o_date = new DateTime ( 'Asia/Chongqing' );
		return $o_date->format ( 'w' );
	}
	protected function GetDateForText($o_date) {
		return $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' );
	}
	protected function GetTimeCut() {
		$o_date = new DateTime ( 'Asia/Chongqing' );
		return $o_date->format ( 'U' );
	}
	public function GetDateNow() {
		$o_date = new DateTime ( 'Asia/Chongqing' );
		return $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' );
	}
	public function GetDate() {
		$o_date = new DateTime ( 'Asia/Chongqing' );
		return $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) ;
	}
	protected function GetTimeNow() {
		$o_date = new DateTime ( 'Asia/Chongqing' );
		return $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' );
	}
	protected function GetWeek() {
		$unixTime=is_numeric($unixTime)?$unixTime:time(); 
		$weekarray=array('日','一','二','三','四','五','六'); 
		return '星期'.$weekarray[date('w',$unixTime)]; 
	}
	public function GetDateForChinese($s_date) {
		//先判断是不是今天
		$o_date = new DateTime ( 'Asia/Chongqing' );
		$s_temp=explode(' ', $s_date);
		if ($o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' )==$s_temp[0])
		{
			$s_temp=explode(':', $s_temp[1]);
			return $s_temp[0].':'.$s_temp[1];
		}else{
			//判断是不是昨天
			$s_today=$o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ).' 00:00:00';
			$s_yestoday=date('Y-m-d H:i:s',strtotime($o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ).' 00:00:00 -1 day'));
			if (strtotime($s_date)>=strtotime($s_yestoday) && strtotime($s_date)<strtotime($s_today))
			{
				$s_temp=explode(' ', $s_date);
				$s_temp=explode(':', $s_temp[1]);
				return '昨天 '.$s_temp[0].':'.$s_temp[1];
			}else{
				//五天内的，按照星期几显示
				$s_yestoday=date('Y-m-d H:i:s',strtotime($o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ).' 00:00:00 -5 day'));
				if (strtotime($s_date)>=strtotime($s_yestoday) && strtotime($s_date)<strtotime($s_today))
				{
					$s_temp=explode(' ', $s_date);
					$s_temp=explode(':', $s_temp[1]);
					$unixTime=is_numeric($unixTime)?$unixTime:strtotime($s_date); 
					$weekarray=array('日','一','二','三','四','五','六'); 
					return '星期'.$weekarray[date('w',$unixTime)].' '.$s_temp[0].':'.$s_temp[1];
				}else{
					//以上都不对，按中文年月日显示
					$s_temp=explode(' ', $s_date);
					$s_temp1=explode('-', $s_temp[0]);
					$s_temp2=explode(':', $s_temp[1]);
					return (int)$s_temp1[1].'月'.(int)$s_temp1[2].'日 '.$s_temp2[0].':'.$s_temp2[1];
				}
			}		
		}
	}
	protected function SendSysmsg($n_uid,$s_text) {
		$o_sysmsg = new Base_System_Msg ();
		$o_sysmsg->setText ( $s_text );
		$o_sysmsg->setUid ( $n_uid );
		$o_sysmsg->setCreateDate ( $this->GetDateNow() );
		$o_sysmsg->setIsShow (0);
		$o_sysmsg->setIsRead(0);
		$o_sysmsg->setReadDate('0000-00-00 00:00:00');
		$o_sysmsg->Save ();
	}
	protected function AddUserLog($u_id, $s_text) //添加用户操作日志
	{
		//require_once RELATIVITY_PATH . 'sub/diary/include/db_table.class.php';
		//$o_log = new Diary_Log ();
		//$o_log->setContent ( $s_text );
		//$o_log->setUid ( $u_id );
		//$o_log->setDate ( $this->GetDateNow () );
		//$o_log->Save ();
	}
	public function AilterTextArea($s_text) {
		$s_content = $s_text;
		$s_content = str_replace ( "\n", "<br/>", $s_content );
		$s_content = str_replace ( "\r", "", $s_content );
		$s_content = str_replace ( "\\", "\\\\\\\\", $s_content );
		while ( ! (strpos ( $s_content, "<br/><br/>" ) === false) ) {
			$s_content = str_replace ( "<br/><br/>", "<br/>", $s_content );
		}
		$s_content = str_replace ( '  ', '&nbsp;&nbsp;', $s_content );
		return $s_content;
	}
	public function HttpsRequest($url, $data = null) {//发送请求，同事支持https的post与get
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
		if (! empty ( $data )) {
			curl_setopt ( $curl, CURLOPT_POST, 1 );
			curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
		}
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		$output = curl_exec ( $curl );
		curl_close ( $curl );
		return $output;
	}
	public function Encrypt($string, $operation, $key = '') {//加密解密，$operation=E是加密 =D是解密
		$key = md5 ( $key );
		$key_length = strlen ( $key );
		$string = $operation == 'D' ? base64_decode ( $string ) : substr ( md5 ( $string . $key ), 0, 8 ) . $string;
		$string_length = strlen ( $string );
		$rndkey = $box = array ();
		$result = '';
		for($i = 0; $i <= 255; $i ++) {
			$rndkey [$i] = ord ( $key [$i % $key_length] );
			$box [$i] = $i;
		}
		for($j = $i = 0; $i < 256; $i ++) {
			$j = ($j + $box [$i] + $rndkey [$i]) % 256;
			$tmp = $box [$i];
			$box [$i] = $box [$j];
			$box [$j] = $tmp;
		}
		for($a = $j = $i = 0; $i < $string_length; $i ++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box [$a]) % 256;
			$tmp = $box [$a];
			$box [$a] = $box [$j];
			$box [$j] = $tmp;
			$result .= chr ( ord ( $string [$i] ) ^ ($box [($box [$a] + $box [$j]) % 256]) );
		}
		if ($operation == 'D') {
			if (substr ( $result, 0, 8 ) == substr ( md5 ( substr ( $result, 8 ) . $key ), 0, 8 )) {
				return substr ( $result, 8 );
			} else {
				return '';
			}
		} else {
			return str_replace ( '=', '', base64_encode ( $result ) );
		}
	}
	public function UnAilterTextArea($s_text) {
		$s_content = $s_text;
		$s_content = str_replace ( "<br/>", "\n", $s_content );
		$s_content = str_replace ( '&nbsp;', ' ', $s_content );
		return $s_content;
	}
	// Returns true if $string is valid UTF-8 and false otherwise. 
	protected function IsUtf8($word) {
		if (preg_match ( "/^([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){1}/", $word ) == true || preg_match ( "/([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){1}$/", $word ) == true || preg_match ( "/([" . chr ( 228 ) . "-" . chr ( 233 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}[" . chr ( 128 ) . "-" . chr ( 191 ) . "]{1}){2,}/", $word ) == true) {
			return true;
		} else {
			return false;
		}
	} // function is_utf8 
	function Is_gb2312($str) {
		for($i = 0; $i < strlen ( $str ); $i ++) {
			$oneOrd = ord ( $str [$i] );
			if ($oneOrd > 227 && $oneOrd < 234) {
				if ($i + 2 >= strlen ( $str ) - 1)
					return true;
				$twoOrd = ord ( $str [$i + 1] );
				$threeOrd = ord ( $str [$i + 2] );
				if ($twoOrd > 128 && $twoOrd < 192 && $threeOrd > 127 && $threeOrd < 192)
					return false;
				return true;
			}
		}
		return true;
	}
	protected function DeleteDir($dir) {
		//先删除目录下的文件：
		$dh = opendir ( $dir );
		while ( $file = readdir ( $dh ) ) {
			if ($file != "." && $file != "..") {
				$fullpath = $dir . "/" . $file;
				if (! is_dir ( $fullpath )) {
					unlink ( $fullpath );
				} else {
					$this->DeleteDir ( $fullpath );
				}
			}
		}
		closedir ( $dh );
		//删除当前文件夹：
		if (rmdir ( $dir )) {
			return true;
		} else {
			return false;
		}
	}

/**
 * 生成缩略图
 * @author yangzhiguo0903@163.com
 * @param string     源图绝对完整地址{带文件名及后缀名}
 * @param string     目标图绝对完整地址{带文件名及后缀名}
 * @param int        缩略图宽{0:此时目标高度不能为0，目标宽度为源图宽*(目标高度/源图高)}
 * @param int        缩略图高{0:此时目标宽度不能为0，目标高度为源图高*(目标宽度/源图宽)}
 * @param int        是否裁切{宽,高必须非0}
 * @param int/float  缩放{0:不缩放, 0<this<1:缩放到相应比例(此时宽高限制和裁切均失效)}
 * @return boolean
 */
protected function img2thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0)
{
    if(!is_file($src_img))
    {
        return false;
    }
    $ot=strtolower ( trim ( substr ( strrchr ( $dst_img, '.' ), 1 ) ) );
    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
    $srcinfo = getimagesize($src_img);
    $src_w = $srcinfo[0];
    $src_h = $srcinfo[1];
    $type  = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);

    $dst_h = $height;
    $dst_w = $width;
    $x = $y = 0;

    /**
     * 缩略图不超过源图尺寸（前提是宽或高只有一个）
     */
    if(($width> $src_w && $height> $src_h) || ($height> $src_h && $width == 0) || ($width> $src_w && $height == 0))
    {
        $proportion = 1;
    }
    if($width> $src_w)
    {
        $dst_w = $width = $src_w;
    }
    if($height> $src_h)
    {
        $dst_h = $height = $src_h;
    }

    if(!$width && !$height && !$proportion)
    {
        return false;
    }
    if(!$proportion)
    {
        if($cut == 0)
        {
            if($dst_w && $dst_h)
            {
                if($dst_w/$src_w> $dst_h/$src_h)
                {
                    $dst_w = $src_w * ($dst_h / $src_h);
                    $x = 0 - ($dst_w - $width) / 2;
                }
                else
                {
                    $dst_h = $src_h * ($dst_w / $src_w);
                    $y = 0 - ($dst_h - $height) / 2;
                }
            }
            else if($dst_w xor $dst_h)
            {
                if($dst_w && !$dst_h)  //有宽无高
                {
                    $propor = $dst_w / $src_w;
                    $height = $dst_h  = $src_h * $propor;
                }
                else if(!$dst_w && $dst_h)  //有高无宽
                {
                    $propor = $dst_h / $src_h;
                    $width  = $dst_w = $src_w * $propor;
                }
            }
        }
        else
        {
            if(!$dst_h)  //裁剪时无高
            {
                $height = $dst_h = $dst_w;
            }
            if(!$dst_w)  //裁剪时无宽
            {
                $width = $dst_w = $dst_h;
            }
            $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
            $dst_w = (int)round($src_w * $propor);
            $dst_h = (int)round($src_h * $propor);
            $x = ($width - $dst_w) / 2;
            $y = ($height - $dst_h) / 2;
        }
    }
    else
    {
        $proportion = min($proportion, 1);
        $height = $dst_h = $src_h * $proportion;
        $width  = $dst_w = $src_w * $proportion;
    }

    $src = $createfun($src_img);
    $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);

    if(function_exists('imagecopyresampled'))
    {
        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    else
    {
        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    $otfunc($dst, $dst_img);
    imagedestroy($dst);
    imagedestroy($src);
    return true;
}
	protected function setTableTitle($a_title,$s_title,$s_item,$n_width,$n_minwidth)
	{
		array_push ( $a_title, array (
								'title' => $s_title, 
								'item' => $s_item, 
								'width' => $n_width, 
								'minwidth' => $n_minwidth 
		) );
		return $a_title;
	}
	protected function SendJsonResultForTable($n_allcount,$s_fun,$s_button,$n_page,$a_title,$a_row)
	{
		$caller = debug_backtrace();
    	array_shift($caller);
    	$s_fun=$caller[0]['function'];//获取调用者的名称
		$a_general = array ('total' => $n_allcount, //总数
			'pagesize' => $this->N_PageSize, //每页记录数
			'current' => $n_page, //当前页码
			'funname' => $s_fun, //调用函数名
			'item' => $this->getPost('item'), //排序字段
			'sort' => $this->getPost('sort'), //降序还是升序
			'key' => '', //搜寻关键字
			'havebutton' => $s_button, //是否记录最后一个是按钮
			'title' => $a_title, //表格标题行
			'rows' => $a_row );//表格数据行
		echo (json_encode ( $a_general ));
	}
	public function CutStr($string, $length) {
		preg_match_all ( "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $info );
		for($i = 0; $i < count ( $info [0] ); $i ++) {
			$wordscut .= $info [0] [$i];
			$j = ord ( $info [0] [$i] ) > 127 ? $j + 2 : $j + 1;
			if ($j > $length - 3) {
				return $wordscut . "...";
			}
		}
		return join ( '', $info [0] );
	}
	//重新计算录入人数
	protected function ReCountInSum($n_subject_id)
	{
		//查找所有报名记录，状态为1的记录
		$o_course=new Course_Info($n_subject_id);
		$o_signup=new Student_Signup();
		$o_signup->PushWhere ( array ('&&', 'CourseId', '=',$n_subject_id) );
		$o_signup->PushWhere ( array ('&&', 'State', '=',1) );
		$o_course->setInSum($o_signup->getAllCount());
		$o_course->Save();
		return $o_course->getSum()-$o_signup->getAllCount();
	}
	//根据生日获取年龄
	protected function getAge($birthday)
	{
		 $age = strtotime($birthday); 
		 if($age === false){ 
		  return false; 
		 } 
		 list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age)); 
		 $now = strtotime("now"); 
		 list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now)); 
		 $age = $y2 - $y1; 
		 if((int)($m2.$d2) < (int)($m1.$d1)) 
		 $age -= 1; 
		 return $age; 
	}
}
?>