<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='幼儿请假';
require_once '../header.php';

require_once RELATIVITY_PATH.'include/bn_basic.class.php';
$o_bn_base=new Bn_Basic();
//验证是否为绑定家长
$o_stu=new Student_Onboard_Info_Class_Wechat_View();
$o_stu->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
if ($o_stu->getAllCount()==0)
{
	echo "<script>document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));</script>"; 
	exit(0);
}
require_once RELATIVITY_PATH . 'sub/ye_info/include/db_table.class.php';
//echo(date('Y-m-d',strtotime("+1 day",strtotime('2017-11-12'))));
?>
	<form action="../include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
		<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
		<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
		<input type="hidden" name="Vcl_FunName" value="ParentAskForLeave"/>
	<div class="page__bd">
	<div class="weui-cells__title">选择请假幼儿</div>
    <div class="weui-cells weui-cells_radio">
    	<?php 
    	for($i=0;$i<$o_stu->getAllCount();$i++)
    	{
    		$s_checked='';
    		if($i==0)
    		{
    			$s_checked=' checked="checked"';
    		}
    		echo('
	    	<label class="weui-cell weui-check__label" for="Vcl_StudentId_'.$o_stu->getStudentId($i).'">
	            <div class="weui-cell__bd">
	                <p>'.$o_stu->getName($i).' 	               
	                </p>	                
	            </div>
	            <div class="weui-cell__ft">
	                <input type="radio" class="weui-check" name="Vcl_StudentId" value="'.$o_stu->getStudentId($i).'" id="Vcl_StudentId_'.$o_stu->getStudentId($i).'"'.$s_checked.'>
	                <span class="weui-icon-checked"></span>
	            </div>
	        </label>
    		');
    	}
    	?>        
    </div>
    <div class="weui-cells__title">幼儿请假信息填写</div>
    <div class="weui-cells" style="margin-top:0px;">
    	<div class="weui-cell">
			<div class="weui-cell__hd"><label class="weui-label">请假日期</label></div>
			<div class="weui-cell__bd">
            	<input name="Vcl_StartDate" id="Vcl_StartDate" class="weui-input" type="date" value="<?php 
            	$o_date = new DateTime ( 'Asia/Chongqing' );
				echo($o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' ));
				
            	?>"/>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">请假天数<br/>含周六日</label></div>
			<div class="weui-cell__bd">
				<input class="weui-input" id="Vcl_EndDate" value="1" onkeyup="value=value.replace(/[^0-9]/g,'')" name="Vcl_EndDate" type="number" pattern="[0-9]*" placeholder="必填">
            </div>
		</div>
		<div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">请假类型</label></div>
			<div class="weui-cell__bd">
            	<select class="weui-select" name="Vcl_Type" id="Vcl_Type">
	                <option value="病假">病假</option>
					<option value="事假">事假</option>
	            </select>
            </div>
		</div>
		<div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">简述原因</label></div>
			<div class="weui-cell__bd">
            	<input class="weui-input" name="Vcl_Comment" id="Vcl_Comment" placeholder="必填">
            </div>
		</div>
	</div>
    </div>
    <br>    
	<div style="padding:15px; padding-top:0px">
		<a class="weui-btn weui-btn_primary" onclick="askforleave_submit()">提交请假信息</a>
		<a class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">关闭</a>
	</div>
	</form>
<script type="text/javascript" src="js/function.js"></script>
<script>
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>