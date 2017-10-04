<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='公众号留言';
require_once '../header.php';
require_once 'leavemsg_fun.php';
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有可回复消息</p></div>';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$o_msg=new Wechat_Wx_User_Leavemsg_View();
$o_msg->PushWhere ( array ('&&', 'UserId', '=',$_GET['userid']) );
$o_msg->PushOrder ( array ('Date',D) );
?>
<?php 
if($o_msg->getAllCount()>0)
{
	require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
	$o_bn_basic=new Bn_Basic();
	?>
<link href="../css/emoji.css" rel="stylesheet" type="text/css" />
<style>
.weui-media-box__desc
{
	line-height:20px;
}
.weui-media-box__thumb
{
	width:36px;
	height:36px;
}
.weui-media-box_appmsg .weui-media-box__thumb {
   width:36px;
}
.weui-media-box_appmsg .weui-media-box__hd {
    margin-right: .8em;
    width: 36px;
    height: 36px;
    line-height: 36px;
}
.weui-media-box_appmsg {
    display: -webkit-box;
    -webkit-box-align: inherit;
}
.weui-media-box__desc div{
    color: #999999;
    font-size: 13px;
    line-height: 1.2;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}
.weui-media-box__title{
	width:100%;
	display:inherit;
    white-space: inherit;
	font-size: 13px;
    line-height: 1.6;
	padding-top:5px;
}
</style>
<div class="page">
	<form action="../include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="LeavemsgReply"/>
			<input type="hidden" name="Vcl_Id" value="<?php echo($o_msg->getId(0))?>"/>
	<div class="weui-cells" style="">
	    <div class="weui-cell">
	        <div class="weui-cell__bd">
	            <textarea id="Vcl_Comment" name="Vcl_Comment" class="weui-textarea" placeholder="输入回复内容" rows="3"></textarea>
	        </div>
	        <div class="weui-cell__ft">
                    <button class="weui-vcode-btn" onclick="submit_comment()">回复</button>
                </div>
	   	</div>
	</div>
	</form>
			<?php
				//获取幼儿姓名，如果获取不到，显示昵称
	            $n_name='';
	            $o_student=new Student_Onboard_Info_Class_Wechat_View();
	            $o_student->PushWhere ( array ('&&', 'UserId', '=',$o_msg->getUserId(0)) );
	            if ($o_student->getAllCount()>0)
	            {
	            	$s_stu_name='';
	            	for ($j=0;$j<$o_student->getAllCount();$j++)
	            	{
	            		//为了多个孩子名
	            		if ($j==0)
	            		{
	            			$s_stu_name=$o_student->getName($j);
	            		}else{
	            			$s_stu_name.='、'.$o_student->getName($j);
	            		}
	            	}
	            	$n_name=$o_student->getClassName(0).$s_stu_name.'家长('.$o_student->getParentSex(0).')';
	           	}else{
	           		$n_name=$o_msg->getNickname(0);
	           	}
        		$s_html='';
        		$n_sum=0;
	            for($i=0;$i<$o_msg->getAllCount();$i++)
	            {
	            	$n_sum++;	            	
	            	//获取回复记录	            	
	            	$o_detail=new Wechat_Wx_User_Leavemsg_Reply_View();
	            	$o_detail->PushWhere ( array ('&&', 'MsgId', '=',$o_msg->getId($i)) );
	            	$o_detail->PushOrder ( array ('Date',D) );
	            	for ($j=0;$j<$o_detail->getAllCount();$j++)
	            	{
	            		$n_sum++;
	            		$s_html.='
	            		<div class="weui-media-box weui-media-box_appmsg">
		                    <div class="weui-media-box__hd">
		                        <img class="weui-media-box__thumb" src="'.$RELATIVITY_PATH.'userdata/logo/chat_logo.jpg" alt="">
		                    </div>
		                    <div class="weui-media-box__bd">                        
		                        <div class="weui-media-box__desc" style="float:left">'.$o_detail->getName($j).'老师</div><div class="weui-media-box__desc" style="float:right">'.$o_bn_basic->GetDateForChinese($o_detail->getDate($j)).'</div>
		                        <h4 class="weui-media-box__title">'.$o_detail->getComment($j).'</h4>                      
		                    </div>
		                </div>
	            		';
	            	}            	
	            	$s_html.='
	            		<div class="weui-media-box weui-media-box_appmsg">
		                    <div class="weui-media-box__hd">
		                        <img class="weui-media-box__thumb" src="'.$o_msg->getPhoto($i).'" alt="">
		                    </div>
		                    <div class="weui-media-box__bd">                        
		                        <div class="weui-media-box__desc" style="float:left">'.$n_name.'</div><div class="weui-media-box__desc" style="float:right">'.$o_bn_basic->GetDateForChinese($o_msg->getDate($i)).'</div>
		                        <h4 class="weui-media-box__title">'.comment_type_switch($o_msg->getComment($i),$o_msg->getType($i)).'</h4>                      
		                    </div>
		                </div>
	            		';
	            }
	        ?>
	        <div style="padding:15px;padding-bottom:0px;">
	    		<a class="weui-btn weui-btn_default" onclick="location='leavemsg_replied.php?'+Date.parse(new Date())">返回</a>
    		</div>
	<div class="weui-cells__title">共<?php echo($n_sum)?>条</div>
    <div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__bd">
            	<?php echo($s_html)?>
            </div>
        </div>        
    </div>
</div>
	<?php
}else{
	echo($s_none);
}
?>
	<script type="text/javascript">
	function submit_comment()
	{
		if ($('#Vcl_Comment').val()=='')
		{
			Dialog_Message("[回复内容] 不能为空！",function(){
			})		
			return
		}
		Common_OpenLoading();
		document.getElementById("submit_form").submit();
	}
	</script>
<?php
require_once '../footer.php';
?>