<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120204);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';

ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
<link rel="stylesheet" type="text/css" href="css/report.css" />
<div class="panel panel-default sss_sub_table">
<div class="panel-heading" style="overflow: inherit; height: 43px;">
<div style="width: 150px;"><select id="Vcl_Date" class="selectpicker"
	data-style="btn-default" onchange="jijiao_get_data_detail(this.value)">
	<option>  </option>
</select></div>
</div>
<div style="padding:15px;">
	<div class="report_title">幼儿园、幼儿班分年龄幼儿数</div>
	<div class="report_text">基础基211幼儿园、幼儿园班数（单位：个）</div>
	<table class="report_table" border="0" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<td>&nbsp;</td>
				<td style="width: 5%">编号</td>
				<td>合计</td>
				<td>托班</td>
				<td>小班</td>
				<td>中班</td>
				<td>大班</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>甲</td>
				<td>乙</td>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
			</tr>
			<tr id="ReportClass">
				<td>合计</td>
				<td>01</td>
				<td class="report_disable">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</tbody>
	</table>
	<div style="height: 20px;"></div>
	<div class="report_text">基础基311幼儿园、幼儿班分年龄幼儿数（单位：人）</div>
	<table class="report_table" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td rowspan="2">&nbsp;&nbsp;</td>
			<td rowspan="2" style="width: 5%">编号</td>
			<td colspan="5">入园（班）人数</td>
			<td colspan="6">在园（班）人数</td>
			<td rowspan="2">离园（班）人数</td>
		</tr>
		<tr>
			<td>合计</td>
			<td>托班</td>
			<td>小班</td>
			<td>中班</td>
			<td>大班</td>
			<td>合计</td>
			<td>其中：女</td>
			<td>托班</td>
			<td>小班</td>
			<td>中班</td>
			<td>大班</td>
		</tr>
		<tr>
			<td>甲</td>
			<td>乙</td>
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>
			<td>5</td>
			<td>6</td>
			<td>7</td>
			<td>8</td>
			<td>9</td>
			<td>10</td>
			<td>11</td>
			<td>12</td>
		</tr>
		<tr>
			<td>总计</td>
			<td>01</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
		</tr>
		<?php 
		for($i=0;$i<8;$i++)
		{
			?>
			<tr id="ReportAge_<?php echo($i)?>">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="report_disable">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="report_disable">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php
		}
		?>
				
	</table>
	
	<div style="height: 20px;"></div>
	<div class="report_text">基础基341在校生中其他情况及外国籍学生情况（单位：人）</div>
	<table class="report_table" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td rowspan="2"></td>
			<td rowspan="2" style="width: 5%">编号</td>
			<td colspan="4">在校生中</td>
			<td rowspan="2">另有：外国学生</td>
		</tr>
		<tr>
			<td class="style1">共产党员</td>
			<td class="style1">共青团员</td>
			<td class="style1">华侨</td>
			<td class="style1">港澳台</td>
		</tr>
		<tr>
			<td>甲</td>
			<td>乙</td>
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>
			<td>5</td>
		</tr>
		<?php 
		for($i=0;$i<2;$i++)
		{
			?>
			<tr id="ReportNation_<?php echo($i)?>">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>-</td>
				<td>-</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php
		}
		?>
	</table>
	<div style="height: 20px;"></div>
	<div class="report_title">幼儿园、幼儿班北京市户籍分年龄幼儿数</div>
	<div class="report_text">基础基31A （<span class="Year"></span>学年初）</div>
	<table class="report_table" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td rowspan="2">&nbsp; &nbsp;</td>
			<td rowspan="2" style="width: 5%">编号</td>
			<td colspan="5">入园（班）人数</td>
			<td colspan="6">在园（班）人数</td>
			<td rowspan="2">离园（班）人数</td>
		</tr>
		<tr>
			<td>合计</td>
			<td>托班</td>
			<td>小班</td>
			<td>中班</td>
			<td>大班</td>
			<td>合计</td>
			<td>其中：女</td>
			<td>托班</td>
			<td>小班</td>
			<td>中班</td>
			<td>大班</td>
		</tr>
		<tr>
			<td>甲</td>
			<td>乙</td>
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>
			<td>5</td>
			<td>6</td>
			<td>7</td>
			<td>8</td>
			<td>9</td>
			<td>10</td>
			<td>11</td>
			<td>12</td>
		</tr>
		<tr>
			<td>总计</td>
			<td>01</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
			<td class="report_disable">&nbsp;</td>
		</tr>
		<?php 
		for($i=0;$i<8;$i++)
		{
			?>
			<tr id="ReportAgeBj_<?php echo($i)?>">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="report_disable">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class="report_disable">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php
		}
		?>
	</table>
	<div style="height: 20px;"></div>
	<div class="report_title">北京市幼儿园在园（班）幼儿补充资料</div>
	<div class="report_text">基础基99A （<span class="Year"></span>学年初）</div>
	<table class="report_table" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td rowspan="2">&nbsp;</td>
			<td rowspan="2" style="width: 5%">编号</td>
			<td colspan="6">在园（班）幼儿中</td>
		</tr>
		<tr>
			<td>合计</td>
			<td>其中：女</td>
			<td>托班</td>
			<td>小班</td>
			<td>中班</td>
			<td>大班</td>
		</tr>
		<tr>
			<td>甲</td>
			<td>乙</td>
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>
			<td>5</td>
			<td>6</td>
		</tr>
		<tr id="ReportClassBj">
			<td>本市农业户籍幼儿数</td>
			<td>01</td>
			<td class="report_disable">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>
</div>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	jijiao_get_data()
})
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
?>