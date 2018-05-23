<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='班级列表';
require_once '../header.php';
//想判断教师权限，是否为绑定用户
$o_user=new Base_User_Wechat();
$o_user->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_user->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有班级信息</p></div>';
?>   
		<?php
		$o_table = new Student_Class();
		$o_table->PushOrder ( array ('Grade','A') );
		$o_table->PushOrder ( array ('ClassId','A') );
		$o_role=new Base_User_Role($o_user->getUid(0));
	    $a_class_id=array();
	    $a_class_id=json_decode($o_role->getClassId());
	    //如果绑定的班级只有一个，那么直接进入
	    if(count($a_class_id)==1)
	    {
	    	echo "<script>location.href='teaching_sport_view_stu.php?item_id=".$_GET['item_id']."=&class_id=".$a_class_id[0]."'</script>"; 
	    	exit(0);
	    }
	    ?>
<?php 
if($o_table->getAllCount()>0)
{
?>
<div class="page">
    <div class="page__bd">
    	<div class="weui-cells__title">选择班级</div>
        <div class="weui-cells">
	    <?php
		for($i=0;$i<$o_table->getAllCount();$i++)
		{
			//如果教师绑定的班级，没有在数组中，那么就是没有权限，则跳过           		
	    	if (!in_array($o_table->getClassId($i), $a_class_id))
	        {
	        	continue;
	        }
			$s_grade_name='';
			//区分年级
			switch ($o_table->getGrade($i))
			{
				case 0:
					$s_grade_name='半日班';
					break;
				case 1:
					$s_grade_name='托班';
					break;
				case 2:
					$s_grade_name='小班';
					break;
				case 3:
					$s_grade_name='中班';
					break;
				case 4:
					$s_grade_name='大班';
					break;
			}
			//计算班内人数
			$o_stu=new Student_Onboard_Info();
			$o_stu->PushWhere ( array ('&&', 'ClassNumber', '=',$o_table->getClassId($i)) );
			$o_stu->PushWhere ( array ('&&', 'State', '=',1) );
			echo('
				<div class="weui-cell weui-cell_access" onclick="location=\'teaching_sport_view_stu.php?class_id='.$o_table->getClassId($i).'&item_id='.$_GET['item_id'].'\'">
	                <div class="weui-cell__bd">'.$s_grade_name.' （'.$o_table->getClassName($i).'）</div>
	                <div class="weui-cell__ft" style="font-size: 0">
	                    <span style="vertical-align:middle; font-size: 17px;">'.$o_stu->getAllCount().'人</span>
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
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>