<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/ye_info/include/db_table.class.php';
$s_title='选择随拍幼儿';
require_once '../header.php';
//想判断教师权限，是否为绑定用户
$o_user=new Base_User_Wechat();
$o_user->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_user->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有幼儿信息</p></div>';
?>      

        <?php
        $o_stu=new Student_Onboard_Info_Class_View();
        $o_stu->PushWhere ( array ('&&', 'ClassNumber', '=',$_GET['id']) );
		$o_stu->PushWhere ( array ('&&', 'State', '=',1) );
		$o_stu->PushOrder ( array ('Sex', A) );
		$o_stu->PushOrder ( array ('Name', A) );
		$s_html='';
		$a_info=array();
		for($i=0;$i<$o_stu->getAllCount();$i++)
		{
			//获取幼儿最后一次随拍记录时间
			$n_date=0;
			$o_snap=new Student_Onboard_Snapshot();
			$o_snap->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getStudentId($i)) );
 			$o_snap->PushWhere ( array ('&&', 'Url', '<>','') );
			$o_snap->PushOrder ( array ('Date', D) );
			$o_snap->setStartLine (0); //起始记录
			$o_snap->setCountLine (1);
			if ($o_snap->getAllCount()>0)
			{
				$n_date=strtotime($o_snap->getDate(0));
			}
			//查看今天是否有缺勤，如果缺勤，那么时间设置为最大，目的是为了排在最后
			$o_checkingin=new Student_Onboard_Checkingin();
			$o_date = new DateTime ( 'Asia/Chongqing' );
			$o_checkingin->PushWhere ( array ('&&', 'Date', '=',$o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ) . '-' . $o_date->format ( 'd' )) );
			$o_checkingin->PushWhere ( array ('&&', 'AbsenteeismStu', 'Like','%"'.$o_stu->getStudentId($i).'"%') );
			if ($o_checkingin->getAllCount()>0)
			{
				//说明今天缺勤
				$n_date=99000000000;
			}
			$a_temp=array(
				'StudentId'=>$o_stu->getStudentId($i),
				'Name'=>$o_stu->getName($i),
				'Sex'=>$o_stu->getSex($i),
				'Date'=>$n_date
			);
			array_push($a_info, $a_temp);
		}
		//根据Date升序排列。
		$flag = array();  
		foreach($a_info as $v){  
		    $flag[] = $v['Date'];  
		}  
		array_multisort($flag,SORT_ASC,$a_info); 
        for($i=0;$i<count($a_info);$i++)
        {
        	$a_temp=$a_info[$i];
        	$s_html.='
        		<div class="weui-cell weui-cell_access" onclick="submit_task('.$a_temp['StudentId'].')">
	                <div class="weui-cell__bd">
	                    <span style="vertical-align: middle">'.$a_temp['Name'].'</span>
	                    <br>
					    <span style="font-size:0.7em;color:#999999">性别：'.$a_temp['Sex'].'</span>
	                </div>
	                <div class="weui-cell__ft"></div>
	            </div>       
           ';
        }
        if ($i==0)
        {
        	echo($s_none);
        }else{
        	?>
        <form action="../include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="TeacherSendSnapshotTask"/>
			<input type="hidden" name="Vcl_StudentId" id="Vcl_StudentId" value=""/>
        	<div class="weui-cells__title">幼儿列表</div>
        	<div class="weui-cells">
        		<?php echo($s_html)?>
        	</div>
        	<div style="padding:15px;">
	    		<?php 
	    		if ($_GET['back']==0)
	    		{
	    			//因为只有一个班级权限，那么就显示关闭，否则显示返回
	    			?>
	    			<a class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'))">关闭</a>
	    			<?php	
	    		}else{
	    			?>
	    			<a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
	    			<?php	
	    		}	    		
	    		?>
    		</div>
    	</form>	
        	<?php
        }
        ?>
<script>
function submit_task(id) {
	Common_OpenLoading();
	$('#Vcl_StudentId').val(id);
	document.getElementById('submit_form').onsubmit();
}
function close_window()
{
	document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));
}
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>