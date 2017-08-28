<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='工作流程模板';
//想判断教师权限，是否为绑定用户
require_once '../header.php';
?>
<div class="page">
    <div class="page__bd">
    
    

<div class="weui-cells__title">文本类型</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">
		</div>
	</div>
</div>
<div class="weui-cells__title">日期类型</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" type="date" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">
		</div>
	</div>
</div>
<div class="weui-cells__title">下拉框类型</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<select class="weui-select" id="Vcl_%id%" name="Vcl_%id%">
	        	<option value="">必选</option>
				<option value="初中及以下">初中及以下</option>
				<option value="高中及中专">高中及中专</option>
				<option value="技校">技校</option>
				<option value="大专">大专</option>
				<option value="本科">本科</option>
				<option value="硕士研究生">硕士研究生</option>
				<option value="博士研究生及以上">博士研究生及以上</option>
	        </select>
		</div>
	</div>
</div>
<div class="weui-cells__title">多选类型</div>
<div class="weui-cells weui-cells_form">
	<div class="weui-cell weui-cell_switch">
		<div class="weui-cell__bd">选项1</div>
		<div class="weui-cell__ft">
			<input class="weui-switch" onchange="dailywork_workflow_new_change_check(this,'%id%','选项1')" type="checkbox"/>
		</div>
	</div>
	<div class="weui-cell weui-cell_switch">
		<div class="weui-cell__bd">选项2</div>
		<div class="weui-cell__ft">
			<label for="switchCP" class="weui-switch-cp">
				<input class="weui-switch" onchange="dailywork_workflow_new_change_check(this,'%id%','选项2')" type="checkbox"/>
			</label>
		</div>
	</div>
	<input type="hidden"  id="Vcl_%id%" name="Vcl_%id%" value=""/>
</div>
<div class="weui-cells__title">单选类型</div>
<div class="weui-cells weui-cells_radio">
	<label class="weui-cell weui-check__label" for="Vcl_%id%_1">
		<div class="weui-cell__bd">
			<p>选项01</p>
		</div>
	<div class="weui-cell__ft">
		<input type="radio" class="weui-check" value="选项01" id="Vcl_%id%_1" name="Vcl_%id%">
		<span class="weui-icon-checked"></span>
	</div>
	</label>
	<label class="weui-cell weui-check__label" for="Vcl_%id%_2">
		<div class="weui-cell__bd">
			<p>选项02</p>
		</div>
		<div class="weui-cell__ft">
			<input type="radio" class="weui-check" value="选项02" id="Vcl_%id%_2" name="Vcl_%id%">
			<span class="weui-icon-checked"></span>
		</div>
	</label>
</div>
<div class="weui-cells__title">手机类型</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" type="number" pattern="[0-9]*" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">
		</div>
	</div>
</div>
<div class="weui-cells__title">数字类型</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" type="number" id="Vcl_%id%" onkeyup="value=value.replace(/[^0-9.]/g,'')" name="Vcl_%id%" placeholder="必填">
		</div>
	</div>
</div>




<div class="weui-cells__title">审批意见</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">
		</div>
	</div>
</div>


<div class="weui-cells__title">休假时间段（结束时间）</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" type="datetime-local" value="" placeholder="必填">
		</div>
	</div>
</div>

<div class="weui-cells__title">休假时间段（终止日期）</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" type="datetime-local" value="" placeholder="必填">
		</div>
	</div>
</div>

<div class="weui-cells__title">工作安排</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">
		</div>
	</div>
</div>

</div>
    <div style="padding:15px;">
	    <a href="javascript:;" class="weui-btn weui-btn_primary" onclick="">提交申请</a>
	    <a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
    </div>   					
</div>
<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript">

</script>
<?php
require_once '../footer.php';
?>