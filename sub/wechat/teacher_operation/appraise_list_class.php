<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='评价问卷-选择班级';
require_once '../header.php';
require_once RELATIVITY_PATH . 'sub/survey/include/db_table.class.php';
require_once RELATIVITY_PATH.'include/bn_basic.class.php';
$o_bn_base=new Bn_Basic();
$s_none='';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}

$o_role=new Student_Class();
$o_role->PushOrder ( array ('Grade','A') );
$o_role->PushOrder ( array ('ClassNumber','A') );
?>
<?php 
if($o_role->getAllCount()>0)
{
	//如果用户存在，并且有微视频
	?>
<style>
.weui-media-box__desc
{
	line-height:20px;
}
.weui-media-box__thumb
{
	width:60px;
	height:60px;
}
</style>
<div class="page">
    <div class="page__bd">
    	<div class="weui-cells__title">班级列表</div>
    	<div class="weui-cells">                
                <?php 
                for($i=0;$i<$o_role->getAllCount();$i++)
                {
                	echo('
				<div class="weui-cell weui-cell_access" onclick="location=\'appraise_answer.php?appraise_id='.$_GET['appraise_id'].'&class_id='.$o_role->getClassId($i).'\'">
					<div class="weui-cell__bd">'.$o_role->getClassName($i).'</div>
	            	<div class="weui-cell__ft" style="font-size: 0"">
	                </div>
				</div>
	            	');
                }
                ?>
        </div>
        
    </div>
</div>	
	<?php
}else{
	echo($s_none);
}
?>

	<div style="padding:15px;">
		<a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
	</div>
<?php
require_once '../footer.php';
?>