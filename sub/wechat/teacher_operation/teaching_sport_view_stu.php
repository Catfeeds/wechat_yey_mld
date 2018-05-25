<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
$s_title='查看成绩';
require_once '../header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有幼儿信息</p></div>';
$o_table=new Student_Onboard_Info_Class_View();
$o_table->PushWhere ( array ('&&', 'ClassNumber', '=',$_GET['class_id']) );
$o_table->PushWhere ( array ('&&', 'State', '=',1) );
$o_table->PushOrder ( array ('Name', 'A') );
$o_item=new Teaching_Sport_Item($_GET['item_id']);
if (!($o_item->getNumber()>0))
{
	echo "<script>location.href='teaching_sport_item.php'</script>";
	exit(0);
}
function get_target($n_item_id,$s_birthday,$s_sex)
{
	$o_temp=new Teaching_Sport_Item_Target();
	$o_temp->PushWhere ( array ('&&', 'ItemId', '=',$n_item_id) );
	$o_temp->PushWhere ( array ('&&', 'Sex', '=',$s_sex) );
	$o_temp->PushWhere ( array ('&&', 'Age', '=',ComputeYear::getYear($s_birthday)) );
	$o_temp->getAllCount();
	//return ComputeYear::getYear($s_birthday);
	return $o_temp->getTarget(0);
}
class ComputeYear{
	private static $leapYears = 0;
	
	public static function getYear($birthday){
		$currentDay = new \DateTime();
		self::getLeapYears($currentDay->format('Y-m-d'),$birthday);
		$daysDiff = date_diff($currentDay,date_create($birthday));
		$realDays = $daysDiff->days-self::$leapYears;
		if($realDays >= 365){
			$age = floor($realDays/365*10)/10;
			//return $age;
			if ($age<round($age))
			{
				//说明 年龄超过半岁
				$age=floor($age)+0.5;
			}else{
				$age=floor($age);
			}
			return $age;
		}
		return 0;
	}	
	private static function getLeapYears($currentDay,$birthDay){
		$currentYear = date('Y',strtotime($currentDay));
		$currentMonth = date('m',strtotime($currentDay));
		$birthYear = date('Y',strtotime($birthDay));
		$birthMonth = date('m',strtotime($birthDay));
		if($birthMonth > 2){
			$birthYear += 1;
		}
		if($currentMonth < 2){
			$currentYear += 1;
		}
		for($i = $birthYear;$i<=$currentYear;$i++){
			if(self::checkLeap($i)){
				self::$leapYears++;
			}
		}
	}	
	private static function checkLeap($year){
		$time = mktime(20,20,20,2,1,$year);
		if (date("t",$time)==29){
			return true;
		}else{
			return false;
		}
	}
};  
?>      
<?php 
if($o_table->getAllCount()>0)
{
?>
<div class="page">
    <div class="page__bd">
    	<div class="weui-cells__title">查看<?php echo($o_item->getName())?>成绩</div>        
	    <?php
	    $o_date = new DateTime ( 'Asia/Chongqing' );
	    $s_date=$o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) ;
		for($i=0;$i<$o_table->getAllCount();$i++)
		{
			$s_value='';
			$o_temp = new Teaching_Sport_Records();
			$o_temp->PushWhere ( array ('&&', 'Date', '>=',$o_date->format ( 'Y' ).'-01-01') );
			$o_temp->PushWhere ( array ('&&', 'Date', '<=',$o_date->format ( 'Y' ).'-12-31') );
			$o_temp->PushWhere ( array ('&&', 'StudentId', '=',$o_table->getStudentId($i)) );
			$o_temp->PushWhere ( array ('&&', 'ItemId', '=',$o_item->getId()) );
			$s_result='';
			$s_more='';
			$n_count=$o_temp->getAllCount();
			if ($n_count>2)
			{
				$n_count=2;
			}
			for($j=0;$j<$n_count;$j++)
			{
				$s_result.='<div class="weui-cell">
				                <div class="weui-cell__hd" style="width:100%;"><label class="weui-label" style="width:100%;text-align:right;color:#999999;font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$o_temp->getDate($j).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$o_temp->getScore($j).'&nbsp;&nbsp;'.$o_item->getUnit().'</label></div>
								<div class="weui-cell__ft">
									<button class="weui-vcode-btn" onclick="sport_delete_score(\''.$o_temp->getId($j).'\',this.parentElement.parentElement)" style="color:red;font-size:14px;height:auto;line-height:14px;width:50px;margin-left:10px;">删除</button>
								</div>
				            </div>';
			}
			for($j=2;$j<$o_temp->getAllCount();$j++)
			{
				$s_result.='<div class="weui-cell more_'.$o_table->getId($i).'" style="display:none">
				                <div class="weui-cell__hd" style="width:100%;"><label class="weui-label" style="width:100%;text-align:right;color:#999999;font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;'.$o_temp->getDate($j).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$o_temp->getScore($j).'&nbsp;&nbsp;'.$o_item->getUnit().'</label></div>
								<div class="weui-cell__ft">
									<button class="weui-vcode-btn" onclick="sport_delete_score(\''.$o_temp->getId($j).'\',this.parentElement.parentElement)" style="color:red;font-size:14px;height:auto;line-height:14px;width:50px;margin-left:10px;">删除</button>
								</div>
				            </div>';
			}
			if ($o_temp->getAllCount()>2)
			{
				$s_result.='<a onclick="$(\'.more_'.$o_table->getId($i).'\').show();$(this).hide()" class="weui-cell weui-cell_link">
			                	<div class="weui-cell__bd" style="text-align:right">更多&nbsp;&nbsp;&nbsp;&nbsp;</div>
			            	</a>';
			}
			echo('
				<div class="weui-cells weui-cells_form">
		            <div class="weui-cell">
		                <div class="weui-cell__hd"><label class="weui-label">'.$o_table->getName($i).'</label></div>
		                <div class="weui-cell__hd"><label class="weui-label" style="width:200px;text-align:right">'.get_target($o_item->getId(),$o_table->getBirthday($i),$o_table->getSex($i)).' '.$o_item->getUnit().'</label></div>
		            </div>
					'.$s_result.'
				</div>
			');
		}
        ?>
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
<script type="text/javascript" src="js/function.js"></script>
<script>
function save_score(stu_id,item_id,obj) {
	if(obj.value!='')
	{
		var data = 'Ajax_FunName=SportSaveInputScore'; //后台方法
	    data = data + '&student_id=' + stu_id+'&item_id='+item_id+'&value='+obj.value;
	    $.getJSON("../../../sub/teaching/include/bn_submit.switch.php", data, function (json) {
	    })
	}
    
}
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>