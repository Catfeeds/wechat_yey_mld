<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='基本情况';
$s_creatives='吴丽娟';
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
.page__hd {
    padding: 20px;
}
.weui-label {
    width: auto;
}
-->
</style>
<div class="page">
	<div class="page__hd">
        <h1 class="page__title">基本情况</h1>
    </div>
	<div class="page__bd">
		<div class="weui-cells__title">姓名</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getName())?></label></div>
            </div>
        </div>
        <div class="weui-cells__title">身份证号码</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getCardId())?></label></div>
            </div>
        </div>
        <div class="weui-cells__title">性别</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getSex())?></label></div>
            </div>
        </div>
        <div class="weui-cells__title">出生年月</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getBirthday())?></label></div>
            </div>
        </div>
        <div class="weui-cells__title">民族</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getNation())?></label></div>
            </div>
        </div>
        <div class="weui-cells__title">政治面貌</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getPolitics())?></label></div>
            </div>
        </div>
        <div class="weui-cells__title">参加工作时间</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getJoinWorkDate())?></label></div>
            </div>
        </div>
        <div class="weui-cells__title">出生地</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getBirthplace())?></label></div>
            </div>
        </div>
        <div class="weui-cells__title">籍贯</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getative())?></label></div>
            </div>
        </div>
        <div class="weui-cells__title">人员进入形式</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getInType())?></label></div>
            </div>
        </div>
        <div class="weui-cells__title">进入本单位时间</div>
		<div class="weui-cells">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label"><?php echo($o_teacher_info_base->getInTime())?></label></div>
            </div>
        </div>
        <div style="padding:15px;">
	    	<a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
	    </div>
    </div>
</div>
<script type="text/javascript">
   
</script>
<?php
require_once '../footer.php';
?>