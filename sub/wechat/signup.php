<?php
require_once 'include/it_include.inc.php';
$s_title='选择课程';
require_once 'header.php';
if (!isset($_COOKIE ['SubjectId']))
{
	setcookie ( 'SubjectId', '',time()+3600*1 );
	setcookie ( 'Time', '',time()+3600*1 );
	setcookie ( 'Class', '',time()+3600*1 );
	setcookie ( 'Remain', '',time()+3600*1 );
}
?>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<div class="weui-cells__title">条件筛选</div>
    <div class="weui-cells">
        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">科目</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" id="Vcl_SubjectId" >
                	<option value="">全部</option>
                	<?php 
                	$o_temp=new Course_Info_View();
                	$o_temp->PushWhere ( array ('&&', 'IsRenew', '<',2) );
                	$o_temp->PushOrder ( array ('SubjectName','A' ) );
                	$id=0;
                	for($i=0;$i<$o_temp->getAllCount();$i++)
                	{
                		if ($o_temp->getSubjectId($i)==$id)
                		{
                			continue;
                		}
                		$id=$o_temp->getSubjectId($i);
                		echo('<option value="'.$o_temp->getSubjectId($i).'">'.$o_temp->getSubjectName($i).'</option>');
                	}
                	?>
                </select>
            </div>
        </div>
        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">时间</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" id="Vcl_Time">
                	<option value="">全部</option>
                    <option value="周一">周一</option>
                	<option value="周二">周二</option>
                	<option value="周三">周三</option>
                	<option value="周四">周四</option>
                	<option value="周五">周五</option>
                	<option value="周六">周六</option>
                	<option value="周日">周日</option>
                </select>
            </div>
        </div>
        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">教室</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" id="Vcl_Class" >
                	<option value="">全部</option>
                	<?php 
                	$o_temp=new Course_Info_View();
                	$o_temp->PushWhere ( array ('&&', 'IsRenew', '<',2) );
                	$o_temp->PushOrder ( array ('Class','A' ) );
                	$id='';
                	for($i=0;$i<$o_temp->getAllCount();$i++)
                	{
                		if ($o_temp->getClass($i)==$id)
                		{
                			continue;
                		}
                		$id=$o_temp->getClass($i);
                		echo('<option value="'.$o_temp->getClass($i).'">'.$o_temp->getClass($i).'</option>');
                	}
                	?>
                </select>
            </div>
        </div>        
        <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">名额</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select" id="Vcl_Remain">
                	<option value="">全部</option>
                	<option value="1">有名额</option>
                    <option value="2">已满</option>
                </select>
            </div>
        </div>
    </div>
    <div style="padding:15px;">
	    <a href="javascript:;" class="weui-btn weui-btn_primary" onclick="load_course()">查找</a>
    </div>
    <div class="weui-cells__title">课程列表 （<span id="count">0</span> 个结果）</div>
		<div id="course_list">
			
        </div>
<script>

$(function () {
	$('#Vcl_SubjectId').val('<?php echo($_COOKIE ['SubjectId'])?>');
	$('#Vcl_TeacherId').val('<?php echo($_COOKIE ['TeacherId'])?>');
	$('#Vcl_Target').val('<?php echo($_COOKIE ['Target'])?>');
	$('#Vcl_Remain').val('<?php echo($_COOKIE ['Remain'])?>');
	load_course();
    $(document).scroll(function () {
	    if($(window).scrollTop()>200)
		{
			//显示置顶按钮
			$('.sss_gotop').fadeIn(300)
		}else{
			//隐藏置顶按钮
			$('.sss_gotop').fadeOut(300)
		}
    });
}); 
//禁止分享
//document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once 'footer.php';?>