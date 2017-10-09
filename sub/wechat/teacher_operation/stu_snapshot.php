<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='生活随拍';
$s_creatives='管理员';
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
	    	echo "<script>location.href='stu_snapshot_option.php?id=".$a_class_id[0]."&back=0'</script>"; 
	    	exit(0);
	    }	
	    $n_sum=0;    
		for($i=0;$i<$o_table->getAllCount();$i++)
		{
			//如果教师绑定的班级，没有在数组中，那么就是没有权限，则跳过           		
	    	if (!in_array($o_table->getClassId($i), $a_class_id))
	        {
	        	continue;
	        }			
	        $n_sum++;
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
				        <div class="weui-form-preview">
				            <div class="weui-form-preview__hd">
				                <label class="weui-form-preview__label">班级</label>
				                <em class="weui-form-preview__value">'.$o_table->getClassName($i).'</em>
				            </div>
				            <div class="weui-form-preview__bd">
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">年级</label>
				                    <span class="weui-form-preview__value">'.$s_grade_name.'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">人数</label>
				                    <span class="weui-form-preview__value">'.$o_stu->getAllCount().' 人</span>
				                </div>				               
				            </div>
				            <div class="weui-form-preview__ft">
				                <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="stu_snapshot_option.php?id='.$o_table->getClassId($i).'">选择随拍幼儿</a>
				            </div>
				        </div>
				        <br>
        		');
			
		}
		if ($n_sum==0)
        {
        	echo($s_none);
        }
        ?>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>