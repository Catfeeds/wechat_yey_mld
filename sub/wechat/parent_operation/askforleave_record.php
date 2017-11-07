<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='幼儿请假';
require_once '../header.php';

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
$o_date = new DateTime ( 'Asia/Chongqing' );
require_once RELATIVITY_PATH . 'sub/ye_info/include/db_table.class.php';
?>
	<div class="page__bd">
		<div class="weui-tab">
            <div class="weui-navbar">
                <div class="weui-navbar__item" onclick="location='askforleave_apply.php'">
                    幼儿请假
                </div>
                <div class="weui-navbar__item weui-bar__item_on">
                    记录
                </div>
            </div>
        </div>
	    <div class="weui-tab__panel" style="padding-top:50px;">
	    	<div class="weui-cells__title">本页只显示最近5次请假记录</div>
	    	<?php	
	    	$o_table=new Student_Onboard_Checkingin_Parent_View();
	    	$o_table->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) );
	    	$o_table->PushOrder ( array ('StartDate',D) );
	    	$o_table->setStartLine (0); //起始记录
			$o_table->setCountLine (5);	
			$n_count=$o_table->getAllCount();
			$n_count=$o_table->getCount();
	    	for($i=0;$i<$n_count;$i++)
	    	{
	    		$s_button='';
	    		//判断是否显示撤销按钮，查找checkin数据库，有无当前日期和班级的记录
	    		$o_checkin=new Student_Onboard_Checkingin();
	    		$o_checkin->PushWhere ( array ('&&', 'Date', '=',$o_table->getStartDate($i)) );
	    		$o_checkin->PushWhere ( array ('&&', 'ClassId', '=',$o_table->getClassNumber($i)) );
	    		if ($o_checkin->getAllCount()==0)
	    		{
	    			$s_button='<div class="weui-form-preview__ft">				            	
				            	<a class="weui-form-preview__btn weui-form-preview__btn_default" onclick="askforleave_cancel('.$o_table->getId($i).')" style="color:#d9534f">撤销请假</a>			            	
				            </div>';
	    		}elseif ($o_table->getComment($i)==''){
	    			$s_button='<div class="weui-form-preview__ft">				            	
				            	<a class="weui-form-preview__btn weui-form-preview__btn_primary" href="askforleave_comment.php?id='.$o_table->getId($i).'">补充请假信息</a>			            	
				            </div>';
	    		}
	    		//计算天数
	    		
	    		echo('
        				<div class="weui-form-preview">
				            <div class="weui-form-preview__hd">
				                <label class="weui-form-preview__label">幼儿姓名</label>
				                <em class="weui-form-preview__value">'.$o_table->getName($i).'</em>
				            </div>
				            <div class="weui-form-preview__bd">
				            	<div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">请假日期</label>
						            <span class="weui-form-preview__value">'.$o_table->getStartDate($i).'</span>
						        </div>
						        <div class="weui-form-preview__item">
						           <label class="weui-form-preview__label">请假天数</label>
						            <span class="weui-form-preview__value">'.((strtotime($o_table->getEndDate($i)) - strtotime($o_table->getStartDate($i)))/86400+1).'</span>
						        </div>			
						        <div class="weui-form-preview__item">
						           <label class="weui-form-preview__label">请假类型</label>
						            <span class="weui-form-preview__value">'.$o_table->getType($i).'</span>
						        </div>	
						        <div class="weui-form-preview__item">
						           <label class="weui-form-preview__label">请假原因</label>
						            <span class="weui-form-preview__value">'.$o_table->getComment($i).'</span>
						        </div>		       
				            </div>				            			            	
				            	'.$s_button.'			            	
				        </div>
				        <br/>
        					');
	    	}
	    	?>        
		</div>
	</div>
<script type="text/javascript" src="js/function.js"></script>
<script>
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>