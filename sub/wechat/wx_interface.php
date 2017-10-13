<?php
define ( 'RELATIVITY_PATH', '../../' );
include(dirname(__FILE__)."/include/db_table.class.php");
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';
$o_bn_base=new Bn_Basic();
define("TOKEN",$o_bn_base->getWechatSetup('TOKEN'));
date_default_timezone_set("Asia/Shanghai");

$wechatObj = new wechat();
if (!isset($_GET['echostr'])) {
    $wechatObj->responseMsg();
}else{
    $wechatObj->valid();
}

class wechat
{
    //验证签名
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
			header('content-type:text');
            echo $echoStr;
            exit;
        }
    }

    //响应消息
    public function responseMsg()
    {
    	//收到用户发送的信息处理
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $this->logger("R ".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            //消息类型分离
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "location":
                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $result = $this->receiveLink($postObj);
                    break;
                default:
                    $result = "unknown msg type: ".$RX_TYPE;
                    break;
            }
            $this->logger("T ".$result);
            echo $result;
        }else {
            echo "";
            exit;
        }
    }
    //接收事件消息
    private function receiveEvent($object)
    {
    	$eventkey = "";
        $content = "";
        switch ($object->Event)
        {
            case "subscribe":
                //关注 ;
            	$eventkey = $object->EventKey;
            	if(isset($eventkey) && !empty($eventkey)){
            		//如果二维码带参数，Sceneid存在，且不等于空，那么进入跳转分配流程
            		$eventkey = str_replace("qrscene_","",$object->EventKey);
            		$result = $this->getMessageFromQr($object, $eventkey);
            	}
            	break;
            case "unsubscribe":
            	//取消关注;
            	$openId = $object->FromUserName;
            	$this->setDelFlag($openId);
                break;
            case "SCAN":
                //扫描带参数的二维码
                $eventkey = $object->EventKey;
       	 		if(isset($eventkey) && !empty($eventkey)){
        			$result = $this->getMessageFromQr($object, $eventkey);
				}
                break;
            case "CLICK":
            	//点击菜单事件
            	$result= $this->getLibrary($object->EventKey,$object);
                break;
            case "LOCATION":
                //$content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
                break;
            case "VIEW":
                //$content = "跳转链接 ".$object->EventKey;
                break;
            case "MASSSENDJOBFINISH":
               // $content = "消息ID：".$object->MsgID."，结果：".$object->Status."，粉丝数：".$object->TotalCount."，过滤：".$object->FilterCount."，发送成功：".$object->SentCount."，发送失败：".$object->ErrorCount;
                break;
            default:            	
                $content = "receive a new event: ".$object->Event;
                break;
        }
        return $result;
    }
    //接收文本消息
    private function receiveText($object)
    {
    	$keyword = trim($object->Content);
    	$n_group=0;
    	$o_user = new WX_User_Info();
		$o_user->PushWhere(array("&&", "OpenId", "=", $object->FromUserName));
		if($o_user->getAllCount()>0)
		{
			$n_group=$o_user->getGroupId(0);
		}
		$content = array();
		$activity = new WX_Keyword();
		$activity->PushWhere(array("&&", "GroupId", "Like", '%"'.$n_group.'"%'));
		$activity->PushWhere(array("&&", "Key", "=", $keyword));
		if ($activity->getAllCount()>0)
		{
			return $this->getLibrary($activity->getLibraryId(0), $object); //推送消息
		}
		//如果没有比对成功的关键字，那么将留言保存到数据库的留言中
		$n_user_id='';	
		require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
		require_once 'include/accessToken.class.php';
		$o_bn_basic=new Bn_Basic();	
    	if($o_user->getAllCount()>0)
		{
			$n_user_id=$o_user->getId(0);
		}else{
			//新建用户
			$o_user = new WX_User_Info();
			$o_user->setOpenId($postObj->FromUserName);
			$o_user->setUserName('');
			$o_user->setCompany('');
			$o_user->setAddress('');
			$o_user->setDeptJob('');
			$o_user->setPhone('');
			$o_user->setEmail('');
			//获取用户头像			
			$o_token=new accessToken();
			$curlUtil = new curlUtil();					
			$o_token=new accessToken();
			$s_token=$o_token->access_token;
			//通过接口获取用户OpenId
			$s_url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$s_token.'&openid='.$object->FromUserName.'&lang=zh_CN';
			$o_util=new curlUtil();
			$s_return=$o_util->https_request($s_url);
			$a_user_info=json_decode($s_return, true);
			$o_user->setPhoto($a_user_info['headimgurl']);
			$o_user->setNickname($o_bn_basic->FilterEmoji($a_user_info['nickname']));
			if ($a_user_info['sex']==2)
			{
				$o_user->setSex('女');
			}else{
				$o_user->setSex('男');
			}
			$o_user->setDelFlag(0);
			$o_user->Save();
			$n_user_id=$o_user->getId();					
		}
		//将用户发送的内容保存到数据库中
		$o_msg=new Wechat_Wx_User_Leavemsg();
		$o_msg->setUserId($n_user_id);
		require_once 'include/emoji.php';
		$s_comment=emoji_unified_to_html(emoji_softbank_to_unified($o_bn_basic->FilterUserInput($keyword)));
		$o_msg->setComment($s_comment);
		$o_msg->setDate($o_bn_basic->GetDateNow());
		$o_msg->Save();
		return ''; 		
    }
    //接收图片消息
    private function receiveImage($object)
    {
    	/*
        $content = array("MediaId"=>$object->PicUrl);
        $result = $this->transmitImage($object, $content);
        return $result;
        */
    	//接收图片信息
    	$o_user = new WX_User_Info();
		$o_user->PushWhere(array("&&", "OpenId", "=", $object->FromUserName));
		$n_user_id='';	
		require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
		require_once 'include/accessToken.class.php';
		$o_bn_basic=new Bn_Basic();	
    	if($o_user->getAllCount()>0)
		{
			$n_user_id=$o_user->getId(0);
		}else{
			//新建用户
			$o_user = new WX_User_Info();
			$o_user->setOpenId($postObj->FromUserName);
			$o_user->setUserName('');
			$o_user->setCompany('');
			$o_user->setAddress('');
			$o_user->setDeptJob('');
			$o_user->setPhone('');
			$o_user->setEmail('');
			//获取用户头像			
			$o_token=new accessToken();
			$curlUtil = new curlUtil();					
			$o_token=new accessToken();
			$s_token=$o_token->access_token;
			//通过接口获取用户OpenId
			$s_url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$s_token.'&openid='.$object->FromUserName.'&lang=zh_CN';
			$o_util=new curlUtil();
			$s_return=$o_util->https_request($s_url);
			$a_user_info=json_decode($s_return, true);
			$o_user->setPhoto($a_user_info['headimgurl']);
			$o_user->setNickname($o_bn_basic->FilterEmoji($a_user_info['nickname']));
			if ($a_user_info['sex']==2)
			{
				$o_user->setSex('女');
			}else{
				$o_user->setSex('男');
			}
			$o_user->setDelFlag(0);
			$o_user->Save();
			$n_user_id=$o_user->getId();					
		}
		$o_date = new DateTime ( 'Asia/Chongqing' );
		//判断图片是否为随拍图片
		$b_insert_to_leavemsg=true;
	    $o_user=new Base_User_Wechat();
		$o_user->PushWhere ( array ('&&', 'WechatId', '=',$n_user_id) ); 		
		if ($o_user->getAllCount()>0)
		{
			//根据用户Uid，找到最新的一条随拍记录，并且时间小于十分钟
			$o_snap=new Student_Onboard_Snapshot();
			$o_snap->PushWhere ( array ('&&', 'TeacherId', '=',$o_user->getUid(0)) );
			$o_snap->PushWhere ( array ('&&', 'Date', '>=',date('Y-m-d H:i:s',strtotime('-10 minute',strtotime($o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' )))))); 
			$o_snap->PushOrder ( array ('Date', D) );
			if ($o_snap->getAllCount()>0)
			{				
				if($o_snap->getUrl(0)=='')
				{
					//第一条记录如果为空，那么记录，否则不记录，目的是，只记录最后一个人。
					$b_insert_to_leavemsg=false;
					$ch = curl_init($object->PicUrl);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$str = curl_exec($ch);
					mkdir ( RELATIVITY_PATH . 'userdata/stu_snapshot', 0777 );
					mkdir ( RELATIVITY_PATH . 'userdata/stu_snapshot/photo', 0777 );			
					$s_filename=$o_date->format ( 'U' ).'.jpg';
					file_put_contents(RELATIVITY_PATH.'userdata/stu_snapshot/photo/'.$s_filename,$str);
					$o_snap=new Student_Onboard_Snapshot($o_snap->getId(0));
					$o_snap->setUrl('userdata/stu_snapshot/photo/'.$s_filename);
					$o_snap->setType('img');
					$o_snap->Save();
					return $this->transmitText($object,'恭喜您，完成随拍。');
				}				
			}
		}
		if ($b_insert_to_leavemsg)
		{
			//将用户发送的内容保存到数据库中		
			$ch = curl_init($object->PicUrl);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$str = curl_exec($ch);
			mkdir ( RELATIVITY_PATH . 'userdata/mp_comment', 0777 );
			mkdir ( RELATIVITY_PATH . 'userdata/mp_comment/photo', 0777 );			
			$s_filename=$o_date->format ( 'U' ).'.jpg';
			file_put_contents(RELATIVITY_PATH.'userdata/mp_comment/photo/'.$s_filename,$str);
			$o_msg=new Wechat_Wx_User_Leavemsg();
			$o_msg->setUserId($n_user_id);
			$o_msg->setComment('userdata/mp_comment/photo/'.$s_filename);
			$o_msg->setDate($o_bn_basic->GetDateNow());
			$o_msg->setType('img');
			$o_msg->Save();
		}
    	return '';    	
    }

    //接收位置消息
    private function receiveLocation($object)
    {
    	/*
        $content = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
        */
    	return $this->transmitText($object, "十分抱歉，本公众号暂不支持此类消息！");
    }

    //接收语音消息
    private function receiveVoice($object)
    {
    	/*
        if (isset($object->Recognition) && !empty($object->Recognition)){
            $content = "你刚才说的是：".$object->Recognition;
            $result = $this->transmitText($object, $content);
        }else{
            $content = array("MediaId"=>$object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }

        return $result;
        */  
    	return $this->transmitText($object, "十分抱歉，本公众号暂不支持此类消息！");
    	return $this->transmitText($object,$object->Format);  	
    	//接收图片信息
    	$o_user = new WX_User_Info();
		$o_user->PushWhere(array("&&", "OpenId", "=", $object->FromUserName));
		$n_user_id='';	
		require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
		require_once 'include/accessToken.class.php';
		$o_bn_basic=new Bn_Basic();	
    	if($o_user->getAllCount()>0)
		{
			$n_user_id=$o_user->getId(0);
		}else{
			//新建用户
			$o_user = new WX_User_Info();
			$o_user->setOpenId($postObj->FromUserName);
			$o_user->setUserName('');
			$o_user->setCompany('');
			$o_user->setAddress('');
			$o_user->setDeptJob('');
			$o_user->setPhone('');
			$o_user->setEmail('');
			//获取用户头像			
			$o_token=new accessToken();
			$curlUtil = new curlUtil();					
			$o_token=new accessToken();
			$s_token=$o_token->access_token;
			//通过接口获取用户OpenId
			$s_url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$s_token.'&openid='.$object->FromUserName.'&lang=zh_CN';
			$o_util=new curlUtil();
			$s_return=$o_util->https_request($s_url);
			$a_user_info=json_decode($s_return, true);
			$o_user->setPhoto($a_user_info['headimgurl']);
			$o_user->setNickname($o_bn_basic->FilterEmoji($a_user_info['nickname']));
			if ($a_user_info['sex']==2)
			{
				$o_user->setSex('女');
			}else{
				$o_user->setSex('男');
			}
			$o_user->setDelFlag(0);
			$o_user->Save();
			$n_user_id=$o_user->getId();					
		}
		//将用户发送的内容保存到数据库中	
		$o_token=new accessToken();
		$s_token=$o_token->access_token;	
		$ch = curl_init('http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$s_token.'&media_id='.$object->MediaId);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$str = curl_exec($ch);
		mkdir ( RELATIVITY_PATH . 'userdata/mp_comment', 0777 );
		mkdir ( RELATIVITY_PATH . 'userdata/mp_comment/voice', 0777 );
		$o_date = new DateTime ( 'Asia/Chongqing' );
		$s_filename=$o_date->format ( 'U' ).'.mp3';
		file_put_contents(RELATIVITY_PATH.'userdata/mp_comment/voice/'.$s_filename,$str);
		$o_msg=new Wechat_Wx_User_Leavemsg();
		$o_msg->setUserId($n_user_id);
		$o_msg->setComment('userdata/mp_comment/voice/'.$s_filename);
		$o_msg->setDate($o_bn_basic->GetDateNow());
		$o_msg->setType('voice');
		$o_msg->Save();
    	return '';
    }

    //接收视频消息
    private function receiveVideo($object)
    {
    	/*
        $content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
        $result = $this->transmitVideo($object, $content);
        return $result;
        */
    	$o_user = new WX_User_Info();
		$o_user->PushWhere(array("&&", "OpenId", "=", $object->FromUserName));
		$n_user_id='';	
		require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
		require_once 'include/accessToken.class.php';
		$o_bn_basic=new Bn_Basic();	
    	if($o_user->getAllCount()>0)
		{
			$n_user_id=$o_user->getId(0);
		}else{
			//新建用户
			$o_user = new WX_User_Info();
			$o_user->setOpenId($postObj->FromUserName);
			$o_user->setUserName('');
			$o_user->setCompany('');
			$o_user->setAddress('');
			$o_user->setDeptJob('');
			$o_user->setPhone('');
			$o_user->setEmail('');
			//获取用户头像			
			$o_token=new accessToken();
			$curlUtil = new curlUtil();					
			$o_token=new accessToken();
			$s_token=$o_token->access_token;
			//通过接口获取用户OpenId
			$s_url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$s_token.'&openid='.$object->FromUserName.'&lang=zh_CN';
			$o_util=new curlUtil();
			$s_return=$o_util->https_request($s_url);
			$a_user_info=json_decode($s_return, true);
			$o_user->setPhoto($a_user_info['headimgurl']);
			$o_user->setNickname($o_bn_basic->FilterEmoji($a_user_info['nickname']));
			if ($a_user_info['sex']==2)
			{
				$o_user->setSex('女');
			}else{
				$o_user->setSex('男');
			}
			$o_user->setDelFlag(0);
			$o_user->Save();
			$n_user_id=$o_user->getId();					
		}
    	$o_date = new DateTime ( 'Asia/Chongqing' );
		//判断视频是否为随拍小视频
		$b_insert_to_leavemsg=true;
	    $o_user=new Base_User_Wechat();
		$o_user->PushWhere ( array ('&&', 'WechatId', '=',$n_user_id) ); 		
		if ($o_user->getAllCount()>0)
		{
			//根据用户Uid，找到最新的一条随拍记录，并且时间小于十分钟
			$o_snap=new Student_Onboard_Snapshot();
			$o_snap->PushWhere ( array ('&&', 'TeacherId', '=',$o_user->getUid(0)) );
			$o_snap->PushWhere ( array ('&&', 'Date', '>=',date('Y-m-d H:i:s',strtotime('-10 minute',strtotime($o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' )))))); 
			$o_snap->PushWhere ( array ('&&', 'Url', '=','') );
			$o_snap->PushOrder ( array ('Date', D) );
			//return $this->transmitText($object, $o_snap->getAllCount());
			if ($o_snap->getAllCount()>0)
			{
				//根据用户Uid，找到最新的一条随拍记录，并且时间小于十分钟
				$o_snap=new Student_Onboard_Snapshot();
				$o_snap->PushWhere ( array ('&&', 'TeacherId', '=',$o_user->getUid(0)) );
				$o_snap->PushWhere ( array ('&&', 'Date', '>=',date('Y-m-d H:i:s',strtotime('-10 minute',strtotime($o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) . ' ' . $o_date->format ( 'H' ) . ':' . $o_date->format ( 'i' ) . ':' . $o_date->format ( 's' )))))); 
				$o_snap->PushOrder ( array ('Date', D) );
				if ($o_snap->getAllCount()>0)
				{				
					if($o_snap->getUrl(0)=='')
					{
						//第一条记录如果为空，那么记录，否则不记录，目的是，只记录最后一个人。
						
						$b_insert_to_leavemsg=false;
						$o_token=new accessToken();
						$s_token=$o_token->access_token;
						$ch = curl_init('http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='.$s_token.'&media_id='.$object->MediaId);
						curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						$str = curl_exec($ch);
						mkdir ( RELATIVITY_PATH . 'userdata/stu_snapshot', 0777 );
						mkdir ( RELATIVITY_PATH . 'userdata/stu_snapshot/video', 0777 );			
						$s_filename=$o_date->format ( 'U' ).'.mp4';
						file_put_contents(RELATIVITY_PATH.'userdata/stu_snapshot/video/'.$s_filename,$str);
						$o_snap=new Student_Onboard_Snapshot($o_snap->getId(0));
						$o_snap->setUrl('userdata/stu_snapshot/video/'.$s_filename);
						$o_snap->setType('video'); 
						$o_snap->Save();
						return $this->transmitText($object,'恭喜您，完成随拍。');
					}				
				}
			}
		}
		if ($b_insert_to_leavemsg)
		{
			return $this->transmitText($object, "十分抱歉，本公众号暂不支持此类消息！");
		}    	
    }
    //接收链接消息
    private function receiveLink($object)
    {
    	/*
        $content = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $result = $this->transmitText($object, $content);
        return $result;*/
    	return $this->transmitText($object, "十分抱歉，本公众号暂不支持此类消息！");
    }
    //回复文本消息
    private function transmitText($object, $content)
    {
        $xmlTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[%s]]></Content>
					</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }
	public function saveMediaFile($fileName, $fileContent){
		$localFile = fopen($fileName, 'w');
		if(false !== $localFile){
			if(false !== fwrite($localFile, $fileContent)){
				fclose($localFile);
			}
		}
	}
    //回复图片消息
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
    					<MediaId><![CDATA[%s]]></MediaId>
					</Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[image]]></MsgType>
						$item_str
					</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
       	return $result;
    }
    //回复语音消息
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
    					<MediaId><![CDATA[%s]]></MediaId>
					</Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);

        $xmlTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[voice]]></MsgType>
						$item_str
					</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
    //回复视频消息
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
					    <MediaId><![CDATA[%s]]></MediaId>
					    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
					    <Title><![CDATA[%s]]></Title>
					    <Description><![CDATA[%s]]></Description>
					</Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[video]]></MsgType>
						$item_str
					</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
					        <Title><![CDATA[%s]]></Title>
					        <Description><![CDATA[%s]]></Description>
					        <PicUrl><![CDATA[%s]]></PicUrl>
					        <Url><![CDATA[%s]]></Url>
					    </item>";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>%s</ArticleCount>
						<Articles>
						$item_str</Articles>
					</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }
    //回复音乐消息
    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
					    <Title><![CDATA[%s]]></Title>
					    <Description><![CDATA[%s]]></Description>
					    <MusicUrl><![CDATA[%s]]></MusicUrl>
					    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
					</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[music]]></MsgType>
						$item_str
					</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
    //回复多客服消息
    private function transmitService($object)
    {
        $xmlTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[transfer_customer_service]]></MsgType>
					</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
    //日志记录
    private function logger($log_content)
    {
    	/*
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }*/
    }
    
    //报名截止时间
	function isExpiry($sceneId){
		//判断超时不需要比对Sceneid，随便找个活动的截止日期即可，因为所有活动的报名截止日期都一样
		$o_select = new WX_Activity();
		$o_select->PushWhere(array('&&','Id','=',$sceneId));
		$count = $o_select->getAllCount();
		$expiryDate = $o_select->getExpiryDate(0);
		$today = date('Y-m-d', time());
		if(strtotime($today) > strtotime($expiryDate)){ //超时
			return true;
		}else{
			return false;
		}
	}
	
	//获取参数二维码信息
    function getMessageFromQr($postObj,$sceneId){    	
    	//为了个性化菜单能够马上刷新，需要立刻将用户设置标签
    	if($sceneId>1000)
    	{
    		$activity = new WX_Activity();
			$activity->PushWhere(array("&&", "Id", "=", $sceneId));
			if ($activity->getAllCount()>0)
			{
				require_once 'include/userGroup.class.php';
				$o_group = new userGroup();
				$o_group->updateGroup($postObj->FromUserName, $activity->getGroupId(0));
			}
    	}   	
		$content = array();
		//判断Type是否是1，如果是1，说明是报名，否则是图文消息
		//判断OpenId是否在数据库，如果在，那么标记已关注
		$b_block=false;
		$o_user = new WX_User_Info();
		$o_user->PushWhere(array("&&", "OpenId", "=", $postObj->FromUserName));
		$n_count_user=$o_user->getAllCount();
		if($n_count_user>0)
		{
			if ($o_user->getBlock(0)==1)
			{
				//检查是否加入了黑名单
				$b_block=true;
			}
			if ($o_user->getDelFlag(0)==1)
			{
				$o_user = new WX_User_Info($o_user->getId(0));
				//如果之前去掉关注了，那么需要恢复关注标志
				$o_user->setDelFlag(0);
				$o_user->setGroupId(0);
				$o_user->Save();
			}else{
				$o_user = new WX_User_Info($o_user->getId(0));
			}			
		}else{
			//新建一个用户
			$o_user = new WX_User_Info();
			$o_user->setOpenId($postObj->FromUserName);
			$o_user->setUserName('');
			$o_user->setCompany('');
			$o_user->setAddress('');
			$o_user->setDeptJob('');
			$o_user->setPhone('');
			$o_user->setEmail('');
		}
		if($sceneId>1000 && $b_block==false){
			if($activity->getAllCount()==0)
			{
				$resultStr='';
			}else{
				//累计二维码使用次数
				$activity_visited=new WX_Activity($activity->getId(0));
				$activity_visited->setVisited($activity->getVisited(0)+1);
				$activity_visited->Save();
			}			
			switch ($activity->getType(0))
            {
                case 1://会议活动
	            	if($this->isExpiry($sceneId)){
						//如果超过报名截止日期，已报名的可以看到报名信息
						if($n_count_user==0){
							//如果不存在，弹出截止报名
			        		$resultStr = $this->transmitText($postObj, "十分抱歉，本次活动报名已经截止");
						}else{
							//如果存在，搜索是否已经在本次活动中报名，
							$user_activity = new WX_User_Activity();
							$user_activity->PushWhere(array("&&", "UserId", "=", $o_user->getId(0)));
							$user_activity->PushWhere(array("&&", "ActivityId", "=", $activity->getId(0)));
							if ($user_activity->getAllCount()==0)
							{
								//如果没有在本次活动中报名，那么弹出过期
								$resultStr = $this->transmitText($postObj, "十分抱歉，本次活动报名已经截止");
							}else{
								//如果已经报名，弹出报名图文，应该是修改用户信息
								$resultStr =$this->getLibrary($activity->getLibraryId(0), $postObj); //推送消息	
							}		
						}
			        }else{
			        	//弹出消息
            			$resultStr =$this->getLibrary($activity->getLibraryId(0), $postObj); //推送消息	
			        }
                    break;
                case 2://是图文消息
					//弹出消息
            		$this->getLibrary($activity->getLibraryId(0), $postObj); //推送消息	
                    break;
                case 3://子账号      
                	$o_user->setGroupId($activity->getGroupId(0));
                	$openId = $postObj->FromUserName;
                	//将用户添加到相应组中
                	require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
					require_once 'include/accessToken.class.php';
                	//获取用户信息                	
                	$o_bn_basic=new Bn_Basic();
					$o_token=new accessToken();
					$curlUtil = new curlUtil();					
					$o_token=new accessToken();
					$s_token=$o_token->access_token;
					//通过接口获取用户OpenId
					$s_url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$s_token.'&openid='.$openId.'&lang=zh_CN';
					$o_util=new curlUtil();
					$s_return=$o_util->https_request($s_url);
					$a_user_info=json_decode($s_return, true);
					//
                    $o_user->setPhoto($a_user_info['headimgurl']);
					$o_user->setNickname($o_bn_basic->FilterEmoji($a_user_info['nickname']));
					if ($a_user_info['sex']==2)
					{
						$o_user->setSex('女');
					}else{
						$o_user->setSex('男');
					}
					$o_user->setDelFlag(0);
					$o_user->Save();					
					//弹出消息
            		$resultStr = $this->getLibrary($activity->getLibraryId(0), $postObj); //推送消息	
                    break;
            }            
		}else{
			//把第一次关注的人，全部加入默认分组中
			$resultStr = $this->getLibrary('[1]', $postObj); 
			//$resultStr = $this->transmitText($postObj,'感谢关注北京市西城区美术培训学校！');
		}
        echo $resultStr;
    }
	function getLibrary($n_id,$object){ //获取资源库中的资源
		$a_id=json_decode($n_id);
		$content = array();
		$activity = new WX_Library();
		$activity->PushWhere(array("&&", "Id", "=", $a_id[0]));
		$count = $activity->getAllCount();
		if ($count>0)
		{
			if("1" == $activity->getMessageType(0)){ //文字回复
				$content = $activity->getContent(0);
				return $this->transmitText($object, $content); 
			}elseif("2" == $activity->getMessageType(0)){  //图文回复
				$content[] = array(
					'Title' => $activity->getTitle(0),
					'Description' => $activity->getDescription(0),
					'PicUrl' => $activity->getPicUrl(0),
					'Url' => $activity->getMessageUrl(0)
					);
				if (count($a_id)>1)
				{
					for($i=1;$i<count($a_id);$i++)
					{
						$activity = new WX_Library();
						$activity->PushWhere(array("&&", "Id", "=", $a_id[$i]));
						$count = $activity->getAllCount();
						$a_temp=array(
							'Title' => $activity->getTitle(0),
							'Description' => $activity->getDescription(0),
							'PicUrl' => $activity->getPicUrl(0),
							'Url' => $activity->getMessageUrl(0)
							);
						array_push($content, $a_temp);
					}
					//说明是组合图文消息
				}
				return $this->transmitNews($object, $content);
			}elseif("3" == $activity->getMessageType(0)){  //图片回复
				$content= array(
					'MediaId' => $activity->getMediaId(0)
				);
				return $this->transmitImage($object, $content);
			}elseif("4" == $activity->getMessageType(0)){  //视频回复
				$content= array(
					'MediaId' => $activity->getMediaId(0)
				);
				return $this->transmitVoice($object, $content);
			}
		}
		return '';
	}
	//将用户删除标志置1
	function setDelFlag($openId){
		$o_selectUser = new WX_User_Info();
		$o_selectUser->PushWhere(array("&&", "OpenId", "=", $openId));
		$n_count = $o_selectUser->getAllCount();
		for($i=0;$i<$n_count;$i++){
			$userId = $o_selectUser->getId($i);
			$o_updateUser = new WX_User_Info($userId);
			//$o_updateUser->Deletion();//直接删除
			$o_updateUser->setDelFlag(1);//标记为取消关注
			$o_updateUser->setGroupId(0);
			$o_updateUser->Save();
		}
	}
}
?> 