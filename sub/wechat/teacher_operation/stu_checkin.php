<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='考勤班级列表';
require_once '../header.php';
?>      
<?php
		$o_table = new Student_Class();
		$o_table->PushOrder ( array ('Grade','A') );
		$o_table->PushOrder ( array ('ClassId','A') );
		for($i=0;$i<$o_table->getAllCount();$i++)
		{
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
				                <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="stu_checkin_form.php?id='.$o_table->getClassId($i).'">记录考勤</a>
				            </div>
				        </div>
				        <br>
        		');
			
		}
        ?>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>