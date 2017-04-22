<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='学生点名列表';
require_once '../header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有学生信息</p></div>';
?>      

        <?php
        //验证是否名下有该课程，如果没有，返回
        $o_course=new Base_User_Wechat_Course_View();
        $o_course->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId ()) ); 
        $o_course->PushWhere ( array ('&&', 'IsRenew', '=',0) );   
        $o_course->PushWhere ( array ('&&', 'CourseId', '=',$_GET['id']) ); 
        if ($o_course->getAllCount()==0)
        {
        	echo "<script>location.href='stu_checkingin_course.php'</script>"; 
			exit(0);
        }    
        $o_signup=new Student_Signup_View();
        $o_signup->PushWhere ( array ('&&', 'CourseId', '=',$_GET['id']) );
		$o_signup->PushWhere ( array ('&&', 'State', '=',1) );//所有被录取的人数，如果要改这个值，后台结果提交也要改。
		$s_html='';
        for($i=0;$i<$o_signup->getAllCount();$i++)
        {
        	$s_html.='
        	<label class="weui-cell weui-check__label" for="Vcl_StudentId_'.$o_signup->getStudentId($i).'">
                <div class="weui-cell__hd">
                    <input onchange="total()" type="checkbox" class="weui-check" name="Vcl_StudentId_'.$o_signup->getStudentId($i).'" id="Vcl_StudentId_'.$o_signup->getStudentId($i).'" checked="checked">
                    <i class="weui-icon-checked"></i>
                </div>
                <div class="weui-cell__bd">
                     				<p>'.$o_signup->getName($i).' 
					                <br>
					                <span style="font-size:0.7em;color:#999999">监护人：'.$o_signup->getParentName($i).'</span>
					                <br>
					                <span style="font-size:0.7em;color:#999999">监护人手机：'.$o_signup->getPhone($i).'</span>
					                </p>	
                </div>
            </label>';
        }
        if ($i==0)
        {
        	echo($s_none);
        }else{
        	?>
        <form action="<?php echo($RELATIVITY_PATH)?>sub/mycourse/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="TeacherStuCheckingin"/>
			<input type="hidden" name="Vcl_CourseId" value="<?php echo($_GET['id'])?>"/>
        	<div class="weui-cells__title">学生列表</div>
        	<div class="weui-cells weui-cells_checkbox">
        		<?php echo($s_html)?>
        	</div>
        	<div class="weui-form-preview" style="margin-top:15px;">
				<div class="weui-form-preview__bd">
					<div class="weui-form-preview__item">
						<label class="weui-form-preview__label">全班人数</label>
						<span class="weui-form-preview__value"><?php echo($o_signup->getAllCount())?> 人</span>
					</div>
					<div class="weui-form-preview__item">
						<label class="weui-form-preview__label">出勤人数</label>
						<span class="weui-form-preview__value"><span id="in"><?php echo($o_signup->getAllCount())?></span> 人</span>
					</div>
					<div class="weui-form-preview__item">
						<label class="weui-form-preview__label">缺勤人数</label>
						<span class="weui-form-preview__value" style="color:red"><span id="out">0</span> 人</span>
					</div>
				</div>
			</div>
        	<div style="padding:15px;">
	    		<a href="javascript:;" class="weui-btn weui-btn_primary" onclick="teacher_stu_checkingin()">提交结果</a>
    		</div>
    	</form>	
        	<?php
        }
        ?>
<script>
function total()
{
	var n_in=0;
	var n_out=0;
	var input=$('.weui-check')
	for(var i=0;i<input.length;i++)
	{
		if ($(input[i]).is(':checked'))
		{
			n_in++
		}else{
			n_out++
		}
	}
	$('#in').html(n_in)
	$('#out').html(n_out)
}
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>