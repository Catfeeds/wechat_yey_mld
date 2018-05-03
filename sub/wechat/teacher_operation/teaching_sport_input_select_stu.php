<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
$s_title='输入成绩';
require_once '../header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有幼儿信息</p></div>';
$o_table=new Student_Onboard_Info_Class_View();
$o_table->PushWhere ( array ('&&', 'ClassNumber', '=',$_GET['class_id']) );
$o_table->PushWhere ( array ('&&', 'State', '=',1) );
$o_table->PushOrder ( array ('Sex', A) );
$o_table->PushOrder ( array ('Name', A) );
$o_item=new Teaching_Sport_Item($_GET['item_id']);
if (!($o_item->getNumber()>0))
{
	echo "<script>location.href='teaching_sport_item.php'</script>";
	exit(0);
}
?>      
<?php 
if($o_table->getAllCount()>0)
{
?>
<div class="page">
    <div class="page__bd">
    	<div class="weui-cells__title">输入<?php echo($o_item->getName())?>成绩</div>
        <div class="weui-cells weui-cells_form">
	    <?php
	    $o_date = new DateTime ( 'Asia/Chongqing' );
	    $o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) ;
		for($i=0;$i<$o_table->getAllCount();$i++)
		{
			$s_value='';
			$o_temp = new Teaching_Sport_Records();
			$o_temp->PushWhere ( array ('&&', 'Year', '=',$o_date->format ( 'Y' )) );
			$o_temp->PushWhere ( array ('&&', 'Month', '=',(int)$o_date->format ( 'm' )) );
			$o_temp->PushWhere ( array ('&&', 'StudentId', '=',$o_table->getStudentId($i)) );
			$o_temp->PushWhere ( array ('&&', 'ItemId', '=',$o_item->getId()) );
			if ($o_temp->getAllCount()>0)
			{
				$s_value=$o_temp->getScore(0);
			}
			echo('
				
		            <div class="weui-cell">
		                <div class="weui-cell__hd"><label class="weui-label">'.$o_table->getName($i).'</label></div>
		                <div class="weui-cell__bd">
		                    <input value="'.$s_value.'" onkeyup="save_score(\''.$o_table->getStudentId($i).'\',\''.$o_item->getId().'\',this)" style="text-align:right;color:#3CC51F;" class="weui-input" type="number" pattern="[0-9]*" placeholder="成绩">
		                </div>
		                <div class="weui-cell__hd"><label class="weui-label" style="width:80px;text-align:center">'.$o_item->getUnit().'</label></div>
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