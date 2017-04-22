<?php
require_once 'include/it_include.inc.php';
$s_title='交费记录';
require_once 'header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有交费记录</p></div>';
?>      
        <?php
        $o_sut_wechat=new Student_Info_Wechat();
        $o_sut_wechat->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId ()) ); 
        if ($o_sut_wechat->getAllCount()>0)
        {
        	$n_sum=0;
        	//根据学生编号，查找报名信息
        	for($i=0;$i<$o_sut_wechat->getAllCount();$i++)
        	{
        		$o_signup=new Student_Signup_View();
        		$o_signup->PushWhere ( array ('&&', 'StudentId', '=',$o_sut_wechat->getStudentId ($i)) ); 
        		$o_signup->PushWhere ( array ('&&', 'State', '>',0) ); 
        		$o_signup->PushWhere ( array ('&&', 'IsPay', '=',1) ); 
        		$o_signup->PushOrder ( array ('PayTime','D' ) );
        		for($j=0;$j<$o_signup->getAllCount();$j++)
        		{
        			//显示开发票信息
        			//1.
        			$s_invoice_state='';
        			$s_button='';
        			switch ($o_signup->getInvoiceState($j))
        			{
        				case 0:
							$s_invoice_state='<span class="weui-form-preview__value">未申请</span>';
							$s_button='<a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="invoice_apply('.$o_signup->getId($j).')">申请发票</a>';
							break;
						case 1:
							$s_invoice_state='<span class="weui-form-preview__value" style="color:#3498DB">已申请，等待领取通知</span>';
							$s_button='<a class="weui-form-preview__btn weui-form-preview__btn_default" style="color:red" onclick="invoice_cancel('.$o_signup->getId($j).')">取消发票申请</a>';
							break;
						case 2:
							$s_invoice_state='<span class="weui-form-preview__value" style="color:#F0AD4E">等待领取</span>';
							break;
						case 3:
							$s_invoice_state='<span class="weui-form-preview__value" style="color:#5CB85C">已领取</span>';
							break;
   						default:
      						break;
        			}
        			$n_sum++;
        			echo('
				        <div class="weui-form-preview">
				            <div class="weui-form-preview__hd">
				                <label class="weui-form-preview__label">课程名称</label>
				                <em class="weui-form-preview__value">'.$o_signup->getCourseName($j).'</em>
				            </div>
				            <div class="weui-form-preview__bd">
				            	<div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">交费编号</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getChargeNumber($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">交费类型</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getChargeType($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">报名日期</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getSignupTime($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">交费时间</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getPayTime($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">科目</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getSubjectName($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">任课教师</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getTeacherName($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">学生姓名</label>
				                    <span class="weui-form-preview__value">'.$o_signup->getName($j).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label" style="font-size:1.2em">交费金额</label>
				                    <span class="weui-form-preview__value" style="font-size:1.4em;color:red">¥'.sprintf("%.2f",$o_signup->getCounts ( $j )*$o_signup->getPrice ( $j )+$o_signup->getMateriale ( $j )).'</span>
				                </div>
				                <div class="weui-form-preview__item">
				                    <label class="weui-form-preview__label">发票状态</label>
				                    '.$s_invoice_state.'
				                </div>
				            </div>
				            <div class="weui-form-preview__ft">
				            	'.$s_button.'
				                <a class="weui-form-preview__btn weui-form-preview__btn_default" href="signup_show_detail.php?id='.$o_signup->getId($j).'">详细</a>
				            </div>
				        </div>
				        <br>
        			');
        		}
        	}
        	if ($n_sum==0)
        	{
        		echo($s_none);
        	}
        }else{
        	echo($s_none);
        }        
        ?>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once 'footer.php';?>