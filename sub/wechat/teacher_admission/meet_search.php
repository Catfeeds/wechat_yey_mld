<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='幼儿见面';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
require_once '../header.php';
?>
<style>
<!--
.weui-search-bar__box {
	height:35px;
}
.weui-icon-search {
	font-size:20px;
}
.weui-search-bar__label span {
	font-size:20px;
}
.weui-search-bar__box .weui-search-bar__input {
	font-size:20px;
}
.weui-grid
{
	padding-top:10px;
	padding-bottom:10px;
}
.weui-grid__label
{
	font-size:24px;
}
-->
</style>
	<div class="page__hd" style="padding-bottom:10px;">
        <h1 class="page__title" style="font-size:28px;">幼儿见面</h1>
        <p class="page__desc">输入幼儿的编号，例如：1001</p>
    </div>
    <div class="page__hd" style="margin-top:0px;padding:0px;color:#1AAD19">
        <h1 id="search_input" class="page__title" style="width:100%;font-size:38px;text-align:center;height:60px;"></h1>
    </div>
		<div class="weui-grids" style="margin-top:15px">
	        <a onclick="input_text(1)" class="weui-grid">
	            <p class="weui-grid__label">1</p>
	        </a>
	        <a onclick="input_text(2)" href="javascript:;" class="weui-grid">
	            <p class="weui-grid__label">2</p>
	        </a> 
	         <a onclick="input_text(3)" href="javascript:;" class="weui-grid">
	            <p class="weui-grid__label">3</p>
	        </a> 
	         <a onclick="input_text(4)" href="javascript:;" class="weui-grid">
	            <p class="weui-grid__label">4</p>
	        </a> 
	         <a onclick="input_text(5)" href="javascript:;" class="weui-grid">
	            <p class="weui-grid__label">5</p>
	        </a> 
	         <a onclick="input_text(6)" href="javascript:;" class="weui-grid">
	            <p class="weui-grid__label">6</p>
	        </a> 
	         <a onclick="input_text(7)" href="javascript:;" class="weui-grid">
	            <p class="weui-grid__label">7</p>
	        </a> 
	         <a onclick="input_text(8)" href="javascript:;" class="weui-grid">
	            <p class="weui-grid__label">8</p>
	        </a> 
	         <a onclick="input_text(9)" href="javascript:;" class="weui-grid">
	            <p class="weui-grid__label">9</p>
	        </a> 
	         <a class="weui-grid">
	            <p class="weui-grid__label">&nbsp;</p>
	        </a> 
	         <a onclick="input_text(0)" href="javascript:;" class="weui-grid">
	            <p class="weui-grid__label">0</p>
	        </a> 
	         <a onclick="input_text(-1)" href="javascript:;" class="weui-grid">
	            <p class="weui-grid__label">重置</p>
	        </a>       
	    </div>
	<div style="padding:15px;">
		<a id="search_btu" class="weui-btn weui-btn_primary">搜索</a>
	</div>
<script>
$(function(){
    $('#search_btu').on('click', function(){
        if ($('#search_input').html()!='')
        {
        	location='meet_search_result.php?id='+$('#search_input').html();
        }        
    });
});
function input_text(number)
{
	if (number>=0)
	{
		var temp=$('#search_input').html()
		if (temp.length>=10)
		{
			Dialog_Message("幼儿编号位不能大于10位！")
			return
		}
		$('#search_input').html($('#search_input').html()+number)
	}else{
		$('#search_input').html('')
	}
}
</script>
<?php
require_once '../footer.php';
?>