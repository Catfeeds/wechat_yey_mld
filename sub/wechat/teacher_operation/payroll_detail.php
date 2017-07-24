<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_title='工资条明细';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$o_detail=new Dailywork_Payroll_Object_Detail_View($_GET['id']);
if ($o_detail->getWechatId()!=$o_wx_user->getId())
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
require_once '../header.php';
?>
    <div class="page__bd">
        <div class="weui-cells__title">我的工资条</div>
        <div class="weui-form-preview">
	        <div class="weui-form-preview__hd">
	            <div class="weui-form-preview__item">
	                <label class="weui-form-preview__label">姓名</label>
	                <em class="weui-form-preview__value"><?php echo($o_detail->getTeacherName())?></em>
	            </div>
	        </div>
	        <div class="weui-form-preview__bd">
		    	<div class="weui-form-preview__item">
		            <label class="weui-form-preview__label">日期</label>
		            <span class="weui-form-preview__value"><?php echo($o_detail->getDate())?></span>
		        </div>
		        <?php 
		        $a_data=json_decode($o_detail->getDetail());
		        for($i=0;$i<count($a_data);$i++)
		        {
		        	$a_temp=$a_data[$i];
		        	echo('
		        	<div class="weui-form-preview__item" style="border-top: 1px solid #ECECEC;padding-top:5px;padding-bottom:5px">
			            <label class="weui-form-preview__label">'.rawurldecode($a_temp[0]).'</label>
			            <span class="weui-form-preview__value">'.rawurldecode($a_temp[1]).'</span>
			        </div>
		        	');
		        }
		        ?>
		        
	        </div>
        </div> 
    </div>
	<div style="padding:15px;">
		<a id="next" class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
	</div>
<?php
require_once '../footer.php';
?>