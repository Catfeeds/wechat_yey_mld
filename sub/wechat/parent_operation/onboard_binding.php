<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='在园幼儿信息绑定';
require_once '../header.php';
?>
	<form action="../include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
		<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
		<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
		<input type="hidden" name="Vcl_FunName" value="OnboardBinding"/>
		<div class="weui-cells__title">绑定幼儿信息</div>
	    <div class="weui-cells" style="margin-top:0px;">
			<div class="weui-cell">
				<div class="weui-cell__hd"><label class="weui-label">幼儿姓名</label></div>
				<div class="weui-cell__bd">
                    <input class="weui-input" id="Vcl_Name" name="Vcl_Name" placeholder="必填">
                </div>
	        </div>
	        <div class="weui-cell">
				<div class="weui-cell__hd"><label class="weui-label">证件类型</label></div>
				<div class="weui-cell__bd">
	                <select class="weui-select" id="Vcl_IdType" name="Vcl_IdType">
	                    <option value="居民身份证">居民身份证</option>
						<option value="香港特区护照/身份证明">香港特区护照/身份证明</option>
						<option value="澳门特区护照/身份证明">澳门特区护照/身份证明</option>
						<option value="台湾居民来往大陆通行证">台湾居民来往大陆通行证</option>
						<option value="境外永久居住证">境外永久居住证</option>
						<option value="护照">护照</option>
						<option value="其他">其他</option>
	                </select>
	            </div>
	        </div>
	        <div class="weui-cell">
				<div class="weui-cell__hd"><label class="weui-label">证件号码</label></div>
				<div class="weui-cell__bd">
                    <input class="weui-input" id="Vcl_ID" name="Vcl_ID" placeholder="必填">
                </div>
	        </div>
	    </div>
	    <div class="weui-cells__title">家长信息</div>
	    <div class="weui-cells" style="margin-top:0px;">
			<div class="weui-cell">
				<div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
				<div class="weui-cell__bd">
                    <input class="weui-input" id="Vcl_JhName" name="Vcl_JhName" placeholder="必填">
                </div>
	        </div>
	        <div class="weui-cell">
				<div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
				<div class="weui-cell__bd">
	                 <input class="weui-input" id="Vcl_JhPhone" name="Vcl_JhPhone" type="number" pattern="[0-9]*" placeholder="必填">
	            </div>
            </div>	       
	    </div>
	    <div style="padding:15px;">
	    	<a id="next" class="weui-btn weui-btn_primary" onclick="submit_binding()">提交绑定</a>
	    	<a id="next" class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">取消</a>
	    </div>
	</form>
<script type="text/javascript" src="js/function.js"></script>
<script>

</script>
<?php
require_once '../footer.php';
?>