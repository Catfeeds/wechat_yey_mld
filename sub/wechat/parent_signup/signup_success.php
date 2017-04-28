<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='信息提交成功';
require_once '../header.php';
$o_table=new Student_Info($_GET['id']);
//验证学生信息是否在该用户名下
$o_stu_wechat=new Student_Info_Wechat();
$o_stu_wechat->PushWhere ( array ('&&', 'StudentId', '=',$o_table->getStudentId()) ); 
$o_stu_wechat->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
if ($o_stu_wechat->getAllCount()==0)
{
	echo "<script>document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));</script>"; 
	exit(0);
}
$o_admission_setup=new Admission_Setup(1);
?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">信息提交成功</h2>
            <p class="weui-msg__desc">幼儿信息已提交成功，请等待下一步提示，谢谢。<br/>
            	本年<?php echo($o_table->getClassMode())?>预计招生<?php 
            	switch ($o_table->getClassMode())
            	{
            		case '托班':
            			echo($o_admission_setup->getTuoSum());
            			break;
            		case '小班':
            			echo($o_admission_setup->getXiaoSum());
            			break;
            		case '中班':
            			echo($o_admission_setup->getZhongSum());
            			break;
            		case '大班':
            			echo($o_admission_setup->getDaSum());
            			break;
            		case '半日班':
            			echo($o_admission_setup->getBanriSum());
            			break;
            		default:
            			echo(0);
            	}
            	?>人。<br/>
            	目前已有<?php 
            	//计算当前报名人数
            	$o_temp=new Student_Info();
            	$o_temp->PushWhere ( array ('&&', 'ClassMode', '=',$o_table->getClassMode()) ); 
            	$o_temp->PushWhere ( array ('&&', 'State', '=',0) ); 
            	echo($o_temp->getAllCount());
            	?>人报名<?php echo($o_table->getClassMode())?>。</p>
        </div>
    </div>
    <div class="weui-cells__title">幼儿报名信息</div>
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">幼儿编号</label>
                <em class="weui-form-preview__value"><?php echo($o_table->getStudentId())?></em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
        	<div class="weui-form-preview__item">
	           <label class="weui-form-preview__label">幼儿姓名</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getName())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	           <label class="weui-form-preview__label">证件类型</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getIdType())?></span>
	        </div>
	        <div class="weui-form-preview__item">
	            <label class="weui-form-preview__label">证件号</label>
	            <span class="weui-form-preview__value"><?php echo($o_table->getId())?></span>
	        </div>
        </div>
    </div>
    <div style="padding:15px;">
		    <a class="weui-btn weui-btn_primary" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">确定</a>
	    </div>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>