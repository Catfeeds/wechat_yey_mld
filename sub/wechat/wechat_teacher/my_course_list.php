<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='我的课程列表';
require_once '../header.php';
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有相关课程</p></div>';
function AilterTextArea($s_text) {
	$s_content = $s_text;
	$s_content = str_replace ( "\n", "<br/>", $s_content );
	$s_content = str_replace ( "\r", "", $s_content );
	$s_content = str_replace ( "\\", "\\\\\\\\", $s_content );
	while ( ! (strpos ( $s_content, "<br/><br/>" ) === false) ) {
		$s_content = str_replace ( "<br/><br/>", "<br/>", $s_content );
	}
	$s_content = str_replace ( '  ', '&nbsp;&nbsp;', $s_content );
	return $s_content;
}
?>      
        <?php
        $o_course=new Base_User_Wechat_Course_View();
        $o_course->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId ()) ); 
        //$o_course->PushWhere ( array ('&&', 'IsRenew', '=',0) );       	
        for($i=0;$i<$o_course->getAllCount();$i++)
        {	
        	//计算已录取的学生
			$o_temp=new Student_Signup();
			$o_temp->PushWhere ( array ('&&', 'CourseId', '=',$o_course->getCourseId($i)) );	
			$o_temp->PushWhere ( array ('&&', 'State', '=',1) );	
			$n_isin=$o_temp->getAllCount();
			//计算已交费的学生
			$o_temp=new Student_Signup();
			$o_temp->PushWhere ( array ('&&', 'CourseId', '=',$o_course->getCourseId($i)) );	
			$o_temp->PushWhere ( array ('&&', 'State', '=',1) );	
			$o_temp->PushWhere ( array ('&&', 'IsPay', '=',1) );	
			$n_ispay=$o_temp->getAllCount();
			//计算待录取的学生
			$o_temp=new Student_Signup();
			$o_temp->PushWhere ( array ('&&', 'CourseId', '=',$o_course->getCourseId($i)) );	
			$o_temp->PushWhere ( array ('&&', 'State', '=',0) );	
			$n_waiting=$o_temp->getAllCount();
        				echo('
				        <div class="weui-form-preview">
				            <div class="weui-form-preview__hd">
				                <label class="weui-form-preview__label">课程名称</label>
				                <em class="weui-form-preview__value">'.$o_course->getCourseName($i).'</em>
				            </div>
				            <div class="weui-form-preview__bd">
				            	<div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">学期</label>
						            <span class="weui-form-preview__value">'.$o_course->getTerm($i).'</span>
						        </div>
						        <div class="weui-form-preview__item">
						           <label class="weui-form-preview__label">科目</label>
						            <span class="weui-form-preview__value">'.$o_course->getSubjectName($i).'</span>
						        </div>
				                <div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">上课时间</label>
						            <span class="weui-form-preview__value">'.$o_course->getTime($i).'</span>
						        </div>
						        <div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">校址</label>
						            <span class="weui-form-preview__value">'.$o_course->getAddressName($i).'</span>
						        </div>
						        <div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">教室</label>
						            <span class="weui-form-preview__value">'.$o_course->getClass($i).'</span>
						        </div>	    	
						        <div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">招生对象</label>
						            <span class="weui-form-preview__value">'.$o_course->getTarget($i).'</span>
						        </div>
						        <div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">容纳人数</label>
						            <span class="weui-form-preview__value">'.$o_course->getSum($i).'人</span>
						        </div>    
						        <div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">学费（元/次）</label>
						            <span class="weui-form-preview__value">'.$o_course->getPrice($i).'元</span>
						        </div>
						        <div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">材料费</label>
						            <span class="weui-form-preview__value">'.$o_course->getMateriale($i).'元</span>
						        </div>
						        <div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">课时</label>
						            <span class="weui-form-preview__value">'.$o_course->getCounts($i).'次</span>
						        </div>
						        <div class="weui-form-preview__item">
						            <label class="weui-form-preview__label">备注</label>
						            <span class="weui-form-preview__value">'.AilterTextArea($o_course->getNote($i)).'</span>
						        </div>
						        <div class="weui-form-preview__item">
						    		<label class="weui-form-preview__label" style="font-size:1.2em">总价</label>
						    		<span class="weui-form-preview__value" style="font-size:1.4em;color:red">¥'.sprintf("%.2f",$o_course->getCounts ($i)*$o_course->getPrice ($i)+$o_course->getMateriale ($i)).'</span>
						    	</div>
				            </div>
				        </div>
				        <br>
        				');
        }
        if ($i==0)
        {
        	echo($s_none);
        }     
        ?>
<script>
$(function () {
	
}); 
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>