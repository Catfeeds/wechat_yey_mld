<?php
require_once 'include/it_include.inc.php';
$s_title='添加学生信息';
require_once 'header.php';
?>
	
	<div class="weui-cells__title">学生信息</div>
	<form action="include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
		<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
		<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
		<input type="hidden" name="Vcl_FunName" value="StudentAdd"/>
		<input type="hidden" name="Vcl_CourseId" value="<?php echo($_GET['course_id'])?>"/>
	    <div class="weui-cells" style="margin-top:0px;">
	        <div class="weui-cell">
	            <div class="weui-cell__bd">
	                <input id="Vcl_Name" name="Vcl_Name" class="weui-input" type="text" placeholder="学生姓名"/>
	            </div>
	        </div>
	        <div class="weui-cell weui-cell_select weui-cell_select-after">
	            <div class="weui-cell__hd">
	                <label for="" class="weui-label">证件类型</label>
	            </div>
	            <div class="weui-cell__bd">
	                <select class="weui-select" id="Vcl_IdType" name="Vcl_IdType" onchange="student_change_idtype(this)">
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
	            <div class="weui-cell__bd">
	                <input class="weui-input" type="text" placeholder="证件号码" id="Vcl_IdCard" name="Vcl_IdCard" onBlur="check_id()"/>
	            </div>
	        </div>
	        <div id="sex" class="weui-cell weui-cell_select weui-cell_select-after" style="display:none">
	            <div class="weui-cell__hd">
	                <label for="" class="weui-label">性别</label>
	            </div>
	            <div class="weui-cell__bd">
	                <select class="weui-select" id="Vcl_Sex" name="Vcl_Sex">
	                    <option value="男">男</option>
						<option value="女">女</option>
	                </select>
	            </div>
	        </div>
	        <div id="birthday" class="weui-cell" style="display:none">
	            <div class="weui-cell__hd"><label for="" class="weui-label">出生日期</label></div>
	            <div class="weui-cell__bd">
	                <input class="weui-input" type="date" value="" name="Vcl_Birthday" id="Vcl_Birthday"/>
	            </div>
	        </div>
	        <div class="weui-cell weui-cell_select weui-cell_select-after">
	            <div class="weui-cell__hd">
	                <label for="" class="weui-label">民族</label>
	            </div>
	            <div class="weui-cell__bd">
	                <select class="weui-select" name="Vcl_Nation" id="Vcl_Nation">
	                    <option selected="selected" value="汉族">汉族</option>
						<option value="回族">回族</option>
						<option value="蒙古族">蒙古族</option>
						<option value="藏族">藏族</option>
						<option value="维吾尔族">维吾尔族</option>
						<option value="苗族">苗族</option>
						<option value="彝族">彝族</option>
						<option value="壮族">壮族</option>
						<option value="布依族">布依族</option>
						<option value="朝鲜族">朝鲜族</option>
						<option value="满族">满族</option>
						<option value="侗族">侗族</option>
						<option value="瑶族">瑶族</option>
						<option value="白族">白族</option>
						<option value="土家族">土家族</option>
						<option value="哈尼族">哈尼族</option>
						<option value="哈萨克族">哈萨克族</option>
						<option value="傣族">傣族</option>
						<option value="黎族">黎族</option>
						<option value="傈僳族">傈僳族</option>
						<option value="佤族">佤族</option>
						<option value="畲族">畲族</option>
						<option value="高山族">高山族</option>
						<option value="拉祜族">拉祜族</option>
						<option value="水族">水族</option>
						<option value="东乡族">东乡族</option>
						<option value="纳西族">纳西族</option>
						<option value="景颇族">景颇族</option>
						<option value="柯尔克孜族">柯尔克孜族</option>
						<option value="土族">土族</option>
						<option value="达斡尔族">达斡尔族</option>
						<option value="仫佬族">仫佬族</option>
						<option value="羌族">羌族</option>
						<option value="布朗族">布朗族</option>
						<option value="撒拉族">撒拉族</option>
						<option value="毛难族">毛难族</option>
						<option value="仡佬族">仡佬族</option>
						<option value="锡伯族">锡伯族</option>
						<option value="阿昌族">阿昌族</option>
						<option value="普米族">普米族</option>
						<option value="塔吉克族">塔吉克族</option>
						<option value="怒族">怒族</option>
						<option value="乌孜别克族">乌孜别克族</option>
						<option value="俄罗斯族">俄罗斯族</option>
						<option value="鄂温克族">鄂温克族</option>
						<option value="德昂族">德昂族</option>
						<option value="保安族">保安族</option>
						<option value="裕固族">裕固族</option>
						<option value="京族">京族</option>
						<option value="塔塔尔族">塔塔尔族</option>
						<option value="独龙族">独龙族</option>
						<option value="鄂伦春族">鄂伦春族</option>
						<option value="赫哲族">赫哲族</option>
						<option value="门巴族">门巴族</option>
						<option value="珞巴族">珞巴族</option>
						<option value="基诺族">基诺族</option>
						<option value="穿青人族">穿青人族</option>
						<option value="外国血统">外国血统</option>
						<option value="无">无</option>
	                </select>
	            </div>
	        </div>
	        <div id="harea" class="weui-cell weui-cell_select weui-cell_select-after">
	            <div class="weui-cell__hd">
	                <label for="" class="weui-label">户籍</label>
	            </div>
	            <div class="weui-cell__bd">
	                <select class="weui-select" id="Vcl_HArea" name="Vcl_HArea">
	                	<option value=""></option>
	                    <option value="西城区">西城区</option>
	                    <option value="非西城区">非西城区</option>
	                </select>
	            </div>
	        </div>
	        <div class="weui-cell weui-cell_select weui-cell_select-after">
	            <div class="weui-cell__hd">
	                <label for="" class="weui-label">学籍</label>
	            </div>
	            <div class="weui-cell__bd">
	                <select class="weui-select" id="Vcl_XArea" name="Vcl_XArea">
	                    <option value=""></option>
	                    <option value="西城区">西城区</option>
	                    <option value="非西城区">非西城区</option>
	                </select>
	            </div>
	        </div>
	        <div class="weui-cell">
	            <div class="weui-cell__bd">
	                <input class="weui-input" type="text" placeholder="监护人姓名" id="Vcl_ParentName" name="Vcl_ParentName"/>
	            </div>
	        </div>
	        <div class="weui-cell">
	            <div class="weui-cell__bd">
	                <input class="weui-input" type="text" pattern="[0-9]*" placeholder="监护人手机" id="Vcl_Phone" name="Vcl_Phone"/>
	            </div>
	        </div>
	    </div>
	    <div class="weui-cells__title">为保证您的孩子具有老学生优先报名权，请真实填写信息。</div>
	    <div style="padding:15px;">
		    <a class="weui-btn weui-btn_primary" onclick="sutdent_add()">添加</a>
	    </div>
	    <div style="padding:15px;padding-top:0px;">
		    <a href="javascript:history.go(-1);" class="weui-btn weui-btn_default">取消</a>
	    </div>
	</form>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once 'footer.php';?>