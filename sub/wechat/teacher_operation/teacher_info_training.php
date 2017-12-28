<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='学习培训';
require_once '../header.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有记录</p></div>';
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
.weui-cell__bd
{
	min-width:100px;
}
.weui-cell__ft
{
	text-align:left;
}
-->
</style>
<div class="page">
	<div class="page__bd">
		<?php 
		$o_temp2=new Wechat_Base_User_Info_Training();
		$o_temp2->PushWhere ( array ('&&', 'Uid', '=',$o_temp->getUid(0)) ); 
		$o_temp2->PushOrder ( array ('CreateDate', 'D') );
        for($i=0;$i<$o_temp2->getAllCount();$i++)
        {
        	?>
        	<div class="weui-cells__title">添加日期：<?php echo($o_temp2->getCreateDate($i))?></div>
			<div class="weui-cells">
				<div class="weui-cell">
	                <div class="weui-cell__bd">
	                    <p>开始时间</p>
	                </div>
	                <div class="weui-cell__ft"><?php echo($o_temp2->getStartDate($i))?></div>
	            </div>
	            <div class="weui-cell">
	                <div class="weui-cell__bd">
	                    <p>结束时间</p>
	                </div>
	                <div class="weui-cell__ft"><?php echo($o_temp2->getEndDate($i))?></div>
	            </div>
	            <div class="weui-cell">
	                <div class="weui-cell__bd">
	                    <p>培训类型</p>
	                </div>
	                <div class="weui-cell__ft"><?php echo($o_temp2->getType($i))?></div>
	            </div>
	            <div class="weui-cell">
	                <div class="weui-cell__bd">
	                    <p>培训内容</p>
	                </div>
	                <div class="weui-cell__ft"><?php echo($o_temp2->getContent($i))?></div>
	            </div>
	            <div class="weui-cell">
	                <div class="weui-cell__bd">
	                    <p>主办单位</p>
	                </div>
	                <div class="weui-cell__ft"><?php echo($o_temp2->getOrganization($i))?></div>
	            </div>
	            <div class="weui-cell">
	                <div class="weui-cell__bd">
	                    <p>是否取得证书</p>
	                </div>
	                <div class="weui-cell__ft"><?php echo($o_temp2->getIsCertificate($i))?></div>
	            </div>
	            <?php 
	            if ($o_temp2->getIsCertificate($i)=='是')
	            {
	            	?>
	            <div class="weui-cell" onclick="location='<?php echo(RELATIVITY_PATH.$o_temp2->getPicture($i))?>'">
		            <div class="weui-cell__bd">
		                <p>证书照片</p>
		            </div>
		            <div class="weui-cell__ft" style="text-align:right;"><img style="width:100px" src="<?php echo(RELATIVITY_PATH.$o_temp2->getPicture($i))?>"/></div>
		        </div>
	            	<?php
	            }
	            ?>	            
	        </div>
        	<?php
        }
        if ($o_temp2->getAllCount()==0)
        echo($s_none);
		?>		
        <div style="padding:15px;">
        	<a class="weui-btn weui-btn_primary" onclick="location='teacher_info_training_add.php'">+ 添加新记录</a>
	    	<a class="weui-btn weui-btn_default" onclick="location='teacher_info.php'">返回</a>
	    </div>
    </div>
</div>
<script type="text/javascript">
   
</script>
<?php
require_once '../footer.php';
?>