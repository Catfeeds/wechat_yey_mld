<?php

include(dirname(dirname(__FILE__))."/include/accessToken.class.php");
require_once 'db_table.class.php';

//$userGroup = new userGroup();

//$userGroup->update_group('oJgavt4gWZzTqa6IefA_ea1dMk4w','100');
//echo 'ok';
class userGroup
{
	//创建用户分组
	public function createGroup($name){
    	$token = new accessToken();
    	$curlUtil = new curlUtil();
    	$data = '{"group":{"name":"'.$name.'"}';
		$url = "https://api.weixin.qq.com/cgi-bin/groups/create?access_token=".$token->access_token;
		$res = $curlUtil->https_request($url, $data);
		return json_decode($res, true);
	}
	
    //设置用户分组，一单设置了，那么这个用户，就只有这个标签
    public function updateGroup($openid, $to_groupid)
    {
    	$token = new accessToken();
    	$curlUtil = new curlUtil();
        $data = '{"openid":"'.$openid.'",
        		  "to_groupid":'.$to_groupid.'}';
        $url = "https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=".$token->access_token;
        $res = $curlUtil->https_request($url, $data);
        return json_decode($res, true);
    }
    //追加用户标标签，只是增加一个标签到用户身上
	public function updateGroupAdd($openid, $to_groupid)
    {
    	$token = new accessToken();
    	$curlUtil = new curlUtil();
        $data = '{"openid_list":["'.$openid.'"],
        		  "tagid":'.$to_groupid.'}';
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=".$token->access_token;
        $res = $curlUtil->https_request($url, $data);
        return json_decode($res, true);
    }
}


?>