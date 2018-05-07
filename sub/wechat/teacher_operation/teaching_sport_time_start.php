<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
$s_title='开始计时';
require_once '../header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有幼儿信息</p></div>';
$o_table=new Student_Onboard_Info_Class_View();
$o_table->PushWhere ( array ('&&', 'ClassNumber', '=',$_GET['class_id']) );
$o_table->PushWhere ( array ('&&', 'State', '=',1) );
$o_table->PushOrder ( array ('Name', A) );
$o_item=new Teaching_Sport_Item($_GET['item_id']);
if (!($o_item->getNumber()>0))
{
	echo "<script>location.href='teaching_sport_item.php'</script>";
	exit(0);
}
?>      
<div class="page" id="timer">
	<div class="page__bd">
		<div class="weui-cells__title" style="font-size:2em;color:#000000"><?php echo($o_item->getName())?></div>
	</div>
	<div class="page__hd">		
        <h1 id="timer_text" class="page__title" style="text-align: center;color:#1AAD19;font-size:3em">0.0</h1>
    </div>
    <div style="padding:15px;padding-top:0px;margin-top:-15px;">
        <a id="btu_start" href="javascript:;" class="weui-btn weui-btn_primary" style="margin-top:15px;" onclick="start()">开始</a>
        <a id="btu_record" href="javascript:;" class="weui-btn weui-btn_primary" style="background-color: #FFBE00;display:none" onclick="record()">记录</a>
        <a id="btu_stop" href="javascript:;" class="weui-btn weui-btn_warn" style="display:none" onclick="stop()">停止</a>
        <a id="btu_clear" href="javascript:;" class="weui-btn weui-btn_warn" style="display:none" onclick="clear_record()">清零</a>
    </div>
    <div class="page__bd">
		<div class="weui-cells__title">当前成绩列表</div>
		<div class="weui-cells" id="record">
            
        </div>
	</div>
	<div style="padding:15px;">
	  	<a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
	</div>
</div>
<div class="page" id="stu_list" style="display:none">
	<div style="width:100%;position:fixed;z-index:999999;background-color:#f8f8f8;">
		<div class="page__bd">
			<div class="weui-cells__title" style="margin-top:5px;">当前成绩</div>	
		</div>
		<div class="page__hd" style="padding:0px;width:100%;background-color:#ffffff;border-top: 1px solid #EBEBEB;border-bottom: 1px solid #EBEBEB;">	
	        <h1 id="this_score" class="" style="text-align: center;color:#1AAD19;font-size:2em;"></h1>
	    </div>
	</div>	
    <div class="page__bd" style="">
    	<div class="weui-cells__title" style="padding-top:88px;margin-top:0px;">选择幼儿</div>
        <div class="weui-cells">
	    <?php
	    $o_date = new DateTime ( 'Asia/Chongqing' );
	    $s_date=$o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ) ;
		for($i=0;$i<$o_table->getAllCount();$i++)
		{
			$s_value='';
			$o_temp = new Teaching_Sport_Records();
			$o_temp->PushWhere ( array ('&&', 'Date', '=',$s_date) );
			$o_temp->PushWhere ( array ('&&', 'StudentId', '=',$o_table->getStudentId($i)) );
			$o_temp->PushWhere ( array ('&&', 'ItemId', '=',$o_item->getId()) );
			if ($o_temp->getAllCount()>0)
			{
				continue;
				$s_value=$o_temp->getScore(0).' '.$o_item->getUnit();
			}
			echo('
					<div class="weui-cell weui-cell_access" onclick="save_score(\''.$o_table->getStudentId($i).'\',\''.$o_item->getId().'\',a_record[save_value],\''.$o_table->getName($i).'\')">
		                <div class="weui-cell__bd">'.$o_table->getName($i).'</div>
		                <div class="weui-cell__ft" style="font-size: 0">
		                    <span id="stu_value_'.$o_table->getStudentId($i).'" style="vertical-align:middle; font-size: 17px;color:#3CC51F;">'.$s_value.'</span>
		                </div>
		            </div>
			');
		}
		for($i=0;$i<$o_table->getAllCount();$i++)
		{
			$s_value='';
			$o_temp = new Teaching_Sport_Records();
			$o_temp->PushWhere ( array ('&&', 'Date', '=',$s_date) );
			$o_temp->PushWhere ( array ('&&', 'StudentId', '=',$o_table->getStudentId($i)) );
			$o_temp->PushWhere ( array ('&&', 'ItemId', '=',$o_item->getId()) );
			if ($o_temp->getAllCount()>0)
			{
				$s_value=$o_temp->getScore(0).' '.$o_item->getUnit();
			}else{
				continue;
			}
			echo('
					<div class="weui-cell weui-cell_access" onclick="save_score(\''.$o_table->getStudentId($i).'\',\''.$o_item->getId().'\',a_record[save_value],\''.$o_table->getName($i).'\')">
		                <div class="weui-cell__bd">'.$o_table->getName($i).'</div>
		                <div class="weui-cell__ft" style="font-size: 0">
		                    <span id="stu_value_'.$o_table->getStudentId($i).'" style="vertical-align:middle; font-size: 17px;color:#3CC51F;">'.$s_value.'</span>
		                </div>
		            </div>
			');
		}
        ?>
        </div>   
    </div>
    <div style="padding:15px;">
	  	<a class="weui-btn weui-btn_default" onclick="close_stu()">返回</a>
	</div>
</div>	
<script>
function save_score(stu_id,item_id,value,name) {
	if(value!='')
	{
		$('#stu_value_'+stu_id).html(value+' 秒')
		var data = 'Ajax_FunName=SportSaveInputScore'; //后台方法
	    data = data + '&student_id=' + stu_id+'&item_id='+item_id+'&value='+value;
	    $.getJSON("../../../sub/teaching/include/bn_submit.switch.php", data, function (json) {
	    	$('#timer').show();
	    	$('#stu_list').hide();
	    	$('#score_'+save_value).html(name+' ');
	    })
	}
    
}
var time=0.0;
var timer=0;
var a_record=[];
var save_value=0;//存储当前要给哪个幼儿的成绩
function looptimer()
{ 
	time=Math.round((time+0.1)*10)/10;
	if (time%1==0)
	{
		//整数
		$('#timer_text').html(time+'.0')
	}else{
		$('#timer_text').html(time)
	}	
}
function start()
{
	timer=setInterval('looptimer()',100);
	$('#btu_start').hide()
	$('#btu_record').show()
	$('#btu_stop').show()
	$('#btu_clear').hide()
}
function record()
{
	var temp=Math.round((time+0.1)*10)/10;
	if (temp%1==0)
	{
		//整数
		temp=temp+'.0';
	}
	a_record.push(temp);
	var html=$('#record').html()
	html=html+'<div class="weui-cell weui-cell_access" onclick="select_stu('+(a_record.length-1)+')"><div class="weui-cell__bd">'+temp+' <?php echo($o_item->getUnit())?></div><div class="weui-cell__ft" style="font-size: 0"><span id="score_'+(a_record.length-1)+'" style="vertical-align:middle; font-size: 17px;">选幼儿 </span></div></div>';
	$('#record').html(html)
}
function select_stu(i)
{
	$('#timer').hide();
	$('#this_score').html(a_record[i]+' 秒');
	$('#stu_list').show();
	save_value=i;
}
function stop()
{
	clearInterval(timer)
	$('#btu_record').hide()
	$('#btu_stop').hide()
	$('#btu_clear').show()
}
function clear_record()
{
	location.reload()
}
function close_stu()
{
	$('#timer').show();
	$('#stu_list').hide();
}
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>