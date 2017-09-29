<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='公众号留言';
require_once '../header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有留言</p></div>';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$o_msg=new Wechat_Wx_User_Leavemsg_View();
$o_msg->PushWhere ( array ('&&', 'IsReply', '=',1) );
$o_msg->PushOrder ( array ('Date',D) );
?>
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
    width: 32px;
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
    <div class="page__bd" style="height: 100%;">
    	<div class="weui-tab">
            <div class="weui-navbar">
                <div class="weui-navbar__item" onclick="location='leavemsg.php'">
                    待回复
                </div>
                <div class="weui-navbar__item weui-bar__item_on" onclick="location='leavemsg_replied.php'">
                   已回复
                </div>
            </div>
        </div>
        <div class="weui-tab__panel" style="padding-top:50px;padding-bottom:0px;">
        <?php 
			if($o_msg->getAllCount()>0)
			{
				require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
				$o_bn_basic=new Bn_Basic();
        		$s_html='';
        		$a_msg_id=array();
        		$o_role=new Base_User_Role($o_temp->getUid(0));
	            $a_class_id=array();
	            $a_class_id=json_decode($o_role->getClassId());
	            for($i=0;$i<$o_msg->getAllCount();$i++)
	            {
	            	//先检查是否UserId在数组里，如果在，那么跳过
	            	if (in_array($o_msg->getUserId($i), $a_msg_id))
	            	{
	            		continue;
	            	}	            	
	            	//获取幼儿姓名，如果获取不到，显示昵称
	            	$n_name='';
	            	$o_student=new Student_Onboard_Info_Class_Wechat_View();
	            	$o_student->PushWhere ( array ('&&', 'UserId', '=',$o_msg->getUserId($i)) );
	            	if ($o_student->getAllCount()>0)
	            	{
	            		//说明是绑定用户，需要看教师是否有权限查看此留言	           		
	            		if (!in_array($o_student->getClassNumber(0), $a_class_id))
	            		{
	            			continue;
	            		}
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
	            		//说明不是绑定用户，那么看是不是该用户有特定角色
	            		$n_admin=1;
	            		if ($o_role->getRoleId()!=$n_admin && $o_role->getSecRoleId1()!=$n_admin && $o_role->getSecRoleId2()!=$n_admin && $o_role->getSecRoleId3()!=$n_admin && $o_role->getSecRoleId4()!=$n_admin && $o_role->getSecRoleId5()!=$n_admin)
	            		{
	            			continue;
	            		}
	            		$n_name=$o_msg->getNickname($i);
	            	}
	            	array_push($a_msg_id, $o_msg->getUserId($i));
	            	$o_msg_detail=new Wechat_Wx_User_Leavemsg_Reply_View();
	            	$o_msg_detail->PushWhere ( array ('&&', 'MsgId', '=',$o_msg->getId($i)) );
	            	$o_msg_detail->PushOrder ( array ('Date',D) );  
	            	$o_msg_detail->getAllCount();  	
	            	$s_html.='
	            	<a href="leavemsg_replied_detail.php?userid='.$o_msg->getUserId($i).'" class="weui-media-box weui-media-box_appmsg">
	                    <div class="weui-media-box__hd">
	                        <img class="weui-media-box__thumb" src="'.$o_msg->getPhoto($i).'" alt="">
	                    </div>
	                    <div class="weui-media-box__bd">
	                        <div class="weui-media-box__desc" style="float:left">'.$n_name.'</div><div class="weui-media-box__desc" style="float:right">'.$o_bn_basic->GetDateForChinese($o_msg->getDate($i)).'</div>
	                        <h4 class="weui-media-box__title">'.$o_msg->getComment($i).'</h4>
	                        <div class="weui-media-box__desc" style="float:left;padding-top:10px">'.$o_msg_detail->getName(0).'老师</div><div class="weui-media-box__desc" style="float:right;padding-top:10px">'.$o_bn_basic->GetDateForChinese($o_msg_detail->getDate(0)).'</div>
	                        <h4 class="weui-media-box__title">'.$o_msg_detail->getComment(0).'</h4>
	                    </div>
	                </a>
	            	';
	            }
	            ?>
        	<div class="weui-cells__title">共<?php echo(count($a_msg_id))?>条</div>
	        <div class="weui-panel weui-panel_access">        
	            <div class="weui-panel__bd">
	            <?php 
	            	echo($s_html);
	            ?>          
	            </div>
	        </div>
	        	<?php
				}else{
					echo($s_none);
				}
				?>
		</div>       
    </div>
</div>
<?php
require_once '../footer.php';
?>