<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='考勤幼儿列表';
require_once '../header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有幼儿信息</p></div>';
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
        $o_stu=new Student_Onboard_Info_Class_View();
        $o_stu->PushWhere ( array ('&&', 'ClassNumber', '=',$_GET['id']) );
		$o_stu->PushWhere ( array ('&&', 'State', '=',1) );
		$o_stu->PushOrder ( array ('Sex', A) );
		$o_stu->PushOrder ( array ('Name', A) );
		$s_html='';
        for($i=0;$i<$o_stu->getAllCount();$i++)
        {
        	$s_html.='
        	<label class="weui-cell weui-check__label" for="Vcl_StudentId_'.$o_stu->getStudentId($i).'">
                <div class="weui-cell__hd">
                    <input onchange="total()" type="checkbox" class="weui-check" name="Vcl_StudentId_'.$o_stu->getStudentId($i).'" id="Vcl_StudentId_'.$o_stu->getStudentId($i).'" checked="checked">
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
            </label>';
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
        	<div class="weui-cells weui-cells_checkbox">
        		<?php echo($s_html)?>
        	</div>
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