<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='补充幼儿请假信息';
require_once '../header.php';
require_once RELATIVITY_PATH . 'sub/ye_info/include/db_table.class.php';
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
//读取家长请假必填项目
$o_parent= new Student_Onboard_Checkingin_Parent_View($_GET['id']);
if ($o_parent->getUserId()!=$o_wx_user->getId() || $o_wx_user->getComment()!='')
{
	echo "<script>document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));</script>"; 
	exit(0);
}
?>
<form action="../include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
	<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
	<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
	<input type="hidden" name="Vcl_FunName" value="ParentAskForLeaveComment"/>
	<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
	<div class="page__bd">
	    	<div class="weui-cells__title">补充幼儿请假信息</div>
		    <div class="weui-cells" style="margin-top:0px;">
		    	<div class="weui-cell">
					<div class="weui-cell__hd"><label class="weui-label">幼儿姓名</label></div>
					<div class="weui-cell__bd">
		            	<?php 
						echo($o_parent->getName());
		            	?>
		            </div>
		        </div>
		    	<div class="weui-cell">
					<div class="weui-cell__hd"><label class="weui-label">请假日期</label></div>
					<div class="weui-cell__bd">
		            	<?php 
						echo($o_parent->getStartDate());
		            	?>
		            </div>
		        </div>
		        <div class="weui-cell">
		            <div class="weui-cell__hd"><label class="weui-label">请假天数</label></div>
					<div class="weui-cell__bd">
						1
		            </div>
				</div>
				<div class="weui-cell">
		            <div class="weui-cell__hd"><label class="weui-label">请假类型</label></div>
					<div class="weui-cell__bd">
					<?php 
					//判断是否老师已经选择了请假类型，如果选择了，这个地方是只读
					$s_readonly='';
					$s_html='<option value="病假">病假</option>
							 <option value="事假">事假</option>';
					if ($o_parent->getType()!='')
					{
						$s_readonly='disabled';	
						if ($o_parent->getType()=='事假')
						{
							$s_html='<option value="病假">病假</option>
									 <option value="事假" selected="selected">事假</option>';
						}
						echo('
						<select class="weui-select" disabled>
			                '.$s_html.'
			            </select>
			            <input type="hidden" name="Vcl_Type" value="'.$o_parent->getType().'"/>
						');					
					}else{
						echo('
						<select class="weui-select" name="Vcl_Type" id="Vcl_Type">
			                '.$s_html.'
			            </select>
						');
					}					
					?>		            	
		            </div>
				</div>
				<div class="weui-cell">
		            <div class="weui-cell__hd"><label class="weui-label">简述原因</label></div>
					<div class="weui-cell__bd">
		            	<input class="weui-input" name="Vcl_Comment" id="Vcl_Comment" placeholder="必填">
		            </div>
				</div>
			</div>	    
	    	<br>    
			<div style="padding:15px; padding-top:0px">
				<a class="weui-btn weui-btn_primary" onclick="askforleave_comment_submit()">提交信息</a>
				<a class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">关闭</a>
			</div>
	</div>
</form>
<script type="text/javascript" src="js/function.js"></script>
<script>
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>