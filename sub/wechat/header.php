<?php
function date_format_for_chinese($s_date)
{
	function getWeek($unixTime=''){ 
	    $unixTime=is_numeric($unixTime)?$unixTime:time(); 
	    $weekarray=array('日','一','二','三','四','五','六'); 
	    return '星期'.$weekarray[date('w',$unixTime)]; 
	} 
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
				return getWeek(strtotime($s_date)).' '.$s_temp[0].':'.$s_temp[1];
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
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title><?php echo($s_title)?></title>
    <link rel="stylesheet" href="<?php echo(RELATIVITY_PATH . 'sub/wechat/')?>css/weui.css"/>
    <link rel="stylesheet" href="<?php echo(RELATIVITY_PATH . 'sub/wechat/')?>css/weui_custom.css"/>
    
    <script type="text/javascript" src="<?php echo(RELATIVITY_PATH . 'sub/wechat/')?>js/jquery-2.1.0.min.js"></script>
    <script type="text/javascript" src="<?php echo(RELATIVITY_PATH . 'sub/wechat/')?>js/dialog.fun.js"></script>
</head>
<body ontouchstart>