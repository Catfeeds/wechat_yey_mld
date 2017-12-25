<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='个人信息';
require_once '../header.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$o_bn_basic=new Bn_Basic();
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$o_teacher_info_base=new Wechat_Base_User_Info_Base($o_temp->getUid(0));
?>
<style>
<!--

-->
</style>
<div class="page">
	<div class="page__bd">
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                    <img src="<?php
			if ($o_wx_user->getPhoto()=='')
			{
				echo(RELATIVITY_PATH.'images/photo_default.png');
			}else{
				if(count(explode('http', $o_wx_user->getPhoto()))>1)
				{
					echo($o_wx_user->getPhoto());
				}
				else{
					echo(RELATIVITY_PATH.$o_wx_user->getPhoto());
				}				
			}?>" style="width: 50px;display: block">
                </div>
                <div class="weui-cell__bd">
                    <p><?php echo($o_teacher_info_base->getName())?></p>
                    <p style="font-size: 13px;color: #888888;">&nbsp;</p>
                </div>
            </div>            
        </div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_access" onclick="location='teacher_info_base.php'">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">基本情况</span>
                </div>
                <div class="weui-cell__ft"></div>
            </div>
        </div>
        <div class="weui-cells">
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">学历学位</span>
                </div>
                <div class="weui-cell__ft"><?php 
                $o_temp2=new Wechat_Base_User_Info_Education();
                $o_temp2->PushWhere ( array ('&&', 'Uid', '=',$o_temp->getUid(0)) ); 
                echo($o_temp2->getAllCount());
                ?></div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">资格职称</span>
                </div>
                <div class="weui-cell__ft"><?php 
                $o_temp2=new Wechat_Base_User_Info_Jobtitle();
                $o_temp2->PushWhere ( array ('&&', 'Uid', '=',$o_temp->getUid(0)) ); 
                echo($o_temp2->getAllCount());
                ?></div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">学习培训</span>
                </div>
                <div class="weui-cell__ft"><?php 
                $o_temp2=new Wechat_Base_User_Info_Training();
                $o_temp2->PushWhere ( array ('&&', 'Uid', '=',$o_temp->getUid(0)) ); 
                echo($o_temp2->getAllCount());
                ?></div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">工作业绩</span>
                </div>
                <div class="weui-cell__ft"><?php 
                $o_temp2=new Wechat_Base_User_Info_Work();
                $o_temp2->PushWhere ( array ('&&', 'Uid', '=',$o_temp->getUid(0)) ); 
                echo($o_temp2->getAllCount());
                ?></div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">获奖情况</span>
                </div>
                <div class="weui-cell__ft"><?php 
                $o_temp2=new Wechat_Base_User_Info_Awards();
                $o_temp2->PushWhere ( array ('&&', 'Uid', '=',$o_temp->getUid(0)) ); 
                echo($o_temp2->getAllCount());
                ?></div>
            </div>
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">论文著作</span>
                </div>
                <div class="weui-cell__ft"><?php 
                $o_temp2=new Wechat_Base_User_Info_Thesis();
                $o_temp2->PushWhere ( array ('&&', 'Uid', '=',$o_temp->getUid(0)) ); 
                echo($o_temp2->getAllCount());
                ?></div>
            </div>
            <div class="weui-cell weui-cell_access" onclick="location='teacher_info_tech.php'">
                <div class="weui-cell__bd">
                    <span style="vertical-align: middle">技术报告</span>
                </div>
                <div class="weui-cell__ft"><?php 
                $o_temp2=new Wechat_Base_User_Info_Tech();
                $o_temp2->PushWhere ( array ('&&', 'Uid', '=',$o_temp->getUid(0)) ); 
                echo($o_temp2->getAllCount());
                ?></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
   
</script>
<?php
require_once '../footer.php';
?>