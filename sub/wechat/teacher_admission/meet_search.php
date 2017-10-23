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
	<div class="page__hd" style="padding-bottom:10px;">
        <h1 class="page__title" style="font-size:28px;">幼儿见面</h1>
        <p class="page__desc">输入幼儿的编号，例如：1001</p>
    </div>
    <div class="page__hd" style="margin-top:15px;padding:0px;color:#1AAD19;padding:15px;">
    	<input style="width:100%;text-align:center;font-size:38px;line-height:38px;color:#1AAD19;padding-top:5px;padding:bottom:5px;" class="weui-search-bar__input" id="Vcl_SearchInput" required type="number" pattern="[0-9]*"/>
    </div>
	 <div style="padding:15px;">
		<a id="search_btu" class="weui-btn weui-btn_primary">搜索</a>
	</div>
<script>
$(function(){
    $('#search_btu').on('click', function(){
        if ($('#Vcl_SearchInput').val()!='')
        {
        	location='meet_search_result.php?id='+$('#Vcl_SearchInput').val();
        }        
    });
});
</script>
<?php
require_once '../footer.php';
?>