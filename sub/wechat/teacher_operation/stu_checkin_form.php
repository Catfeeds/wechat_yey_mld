<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/ye_info/include/db_table.class.php';
$s_title='考勤幼儿列表';
require_once '../header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有幼儿信息</p></div>';
$o_date = new DateTime ( 'Asia/Chongqing' );
$s_date=$o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' );

?>      

        <?php
        //验证是否名下有该课程，如果没有，返回
        /*$o_course=new Base_User_Wechat_Course_View();
        $o_course->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId ()) ); 
        $o_course->PushWhere ( array ('&&', 'IsRenew', '=',0) );   
        $o_course->PushWhere ( array ('&&', 'CourseId', '=',$_GET['id']) ); 
        if ($o_course->getAllCount()==0)
        {
        	echo "<script>location.href='stu_checkin.php'</script>"; 
			exit(0);
        }    */
        //读取本日是否已经记录考勤
        $o_checkin=new Student_Onboard_Checkingin();
        $o_checkin->PushWhere ( array ('&&', 'ClassId', '=',$_GET['id']) );
		$o_checkin->PushWhere ( array ('&&', 'Date', '=',$s_date) );
        
        $o_stu=new Student_Onboard_Info_Class_View();
        $o_stu->PushWhere ( array ('&&', 'ClassNumber', '=',$_GET['id']) );
		$o_stu->PushWhere ( array ('&&', 'State', '=',1) );
		$o_stu->PushOrder ( array ('Sex', A) );
		$o_stu->PushOrder ( array ('Name', A) );
		$s_html='';
        for($i=0;$i<$o_stu->getAllCount();$i++)
        {
        	$s_checked='checked="checked"';
        	$s_display='display:none';
        	$s_set_type='';
        	$o_stu_wechat=new Student_Onboard_Info_Class_Wechat_View($o_stu->getStudentId($i));
        	if ($o_checkin->getAllCount()>0)
        	{
        		//查找之前已经记录的考勤
        		$o_detail=new Student_Onboard_Checkingin_Detail();
				$o_detail->PushWhere ( array ('&&', 'CheckId', '=',$o_checkin->getId(0)) );
				$o_detail->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getStudentId($i)) );
				if ($o_detail->getAllCount()>0)
				{
					$s_checked='';
					$s_display='';
					if ($o_detail->getType(0)=='病假')
					{
						$s_set_type='$("#Vcl_Type_'.$o_stu->getStudentId($i).'_1").attr("checked","true");';
					}
					if ($o_detail->getType(0)=='事假')
					{
						$s_set_type='$("#Vcl_Type_'.$o_stu->getStudentId($i).'_2").attr("checked","true");';
					}
				}
        	}else{
        		//查找家长申请的考勤
        		$o_parent=new Student_Onboard_Checkingin_Parent();
				$o_parent->PushWhere ( array ('&&', 'UserId', '=',$o_stu_wechat->getUserId()) );
				$o_parent->PushWhere ( array ('&&', 'StudentId', '=',$o_stu_wechat->getStudentId()) );
				$o_parent->PushWhere ( array ('&&', 'StartDate', '<=',$s_date) );
				$o_parent->PushWhere ( array ('&&', 'EndDate', '>=',$s_date) );
				if ($o_parent->getAllCount()>0)
				{
					$s_checked='';
					$s_display='';
					if ($o_parent->getType(0)=='病假')
					{
						$s_set_type='$("#Vcl_Type_'.$o_stu->getStudentId($i).'_1").attr("checked","true");';
					}
					if ($o_parent->getType(0)=='事假')
					{
						$s_set_type='$("#Vcl_Type_'.$o_stu->getStudentId($i).'_2").attr("checked","true");';
					}
				}
        	}
        	$s_html.='
        	<div class="weui-cells weui-cells_checkbox">
        	<label class="weui-cell weui-check__label" for="Vcl_StudentId_'.$o_stu->getStudentId($i).'">
                <div class="weui-cell__hd">
                    <input onchange="total('.$o_stu->getStudentId($i).')" type="checkbox" class="weui-check stu" name="Vcl_StudentId_'.$o_stu->getStudentId($i).'" id="Vcl_StudentId_'.$o_stu->getStudentId($i).'" '.$s_checked.'/>
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                     				<p>'.$o_stu->getName($i).' 
					                <br>
					                <span style="font-size:0.7em;color:#999999">性别：'.$o_stu->getSex($i).'</span>
					                <br>
					                <span style="font-size:0.7em;color:#999999">监护人：'.$o_stu->getJh1Name($i).'</span>
					                <br>
					                <span style="font-size:0.7em;color:#999999">监护人手机：'.$o_stu->getJh1Phone($i).'</span>				                
					                </p> 
                </div>                          			
            </label> 
            </div>
            <div id="type_'.$o_stu->getStudentId($i).'" style="'.$s_display.'">
	            <div class="weui-cells__title">选择未出勤幼儿请假类型，可不选</div>
		        <div class="weui-cells weui-cells_radio">
		            <label class="weui-cell weui-check__label" for="Vcl_Type_'.$o_stu->getStudentId($i).'_1">
		                <div class="weui-cell__bd">
		                    <p>病假</p>
		                </div>
		                <div class="weui-cell__ft">
		                    <input value="病假" type="radio" class="weui-check" name="Vcl_Type_'.$o_stu->getStudentId($i).'" id="Vcl_Type_'.$o_stu->getStudentId($i).'_1">
		                    <span class="weui-icon-checked"></span>
		                </div>
		            </label>
		            <label class="weui-cell weui-check__label" for="Vcl_Type_'.$o_stu->getStudentId($i).'_2">	
		                <div class="weui-cell__bd">
		                    <p>事假</p>
		                </div>
		                <div class="weui-cell__ft">
		                    <input value="事假" type="radio" name="Vcl_Type_'.$o_stu->getStudentId($i).'" class="weui-check" id="Vcl_Type_'.$o_stu->getStudentId($i).'_2">
		                    <span class="weui-icon-checked"></span>
		                </div>
		            </label>
		        </div> 
	        </div>  
	        <script>
	        '.$s_set_type.'
	        </script>       
           ';
        }
        if ($i==0)
        {
        	echo($s_none);
        }else{
        	?>
        <form action="<?php echo($RELATIVITY_PATH)?>sub/ye_info/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="TeacherCheckinForm"/>
			<input type="hidden" name="Vcl_ClassId" value="<?php echo($_GET['id'])?>"/>
        	<div class="weui-cells__title">幼儿列表</div>
        	
        		<?php echo($s_html)?>
        	
        	<div class="weui-form-preview" style="margin-top:15px;">
				<div class="weui-form-preview__bd">
					<div class="weui-form-preview__item">
						<label class="weui-form-preview__label">全班人数</label>
						<span class="weui-form-preview__value"><?php echo($o_stu->getAllCount())?> 人</span>
					</div>
					<div class="weui-form-preview__item">
						<label class="weui-form-preview__label">出勤人数</label>
						<span class="weui-form-preview__value"><span id="in"><?php echo($o_stu->getAllCount())?></span> 人</span>
					</div>
					<div class="weui-form-preview__item">
						<label class="weui-form-preview__label">缺勤人数</label>
						<span class="weui-form-preview__value" style="color:red"><span id="out">0</span> 人</span>
					</div>
				</div>
			</div>
        	<div style="padding:15px;">
	    		<a href="javascript:;" class="weui-btn weui-btn_primary" onclick="teacher_stu_checkin()">提交结果</a>
	    		<a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
    		</div>
    	</form>	
        	<?php
        }
        ?>
<script>
function teacher_stu_checkin() {
    Dialog_Confirm('真的要提交考勤吗？',function(){
    	document.getElementById('submit_form').onsubmit();
    })
}
function total(id)
{
	var n_in=0;
	var n_out=0;
	var input=$('.stu')
	for(var i=0;i<input.length;i++)
	{
		if ($(input[i]).is(':checked'))
		{
			n_in++			
		}else{			
			n_out++
		}
	}
	if($('#Vcl_StudentId_'+id).is(':checked'))
	{
		//隐藏类型
		$('#type_'+id).hide()
		$('#Vcl_Type_'+id+'_1').removeAttr("checked"); 
		$('#Vcl_Type_'+id+'_2').removeAttr("checked"); 
	}else{
		//显示类型
		$('#type_'+id).show()
	}
	$('#in').html(n_in)
	$('#out').html(n_out)
}
$(function () {
	total()
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>