<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/ye_info/include/db_table.class.php';
$s_title='随拍';
$s_creatives='管理员';
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
$s_none='<div class="weui-footer" style="padding-top:100px;"><p class="weui-footer__text" style="font-size:1.5em">没有随拍记录</p></div>';
?>      

        <?php
        $o_snap=new Student_Onboard_Snapshot_View();
        $o_snap->PushWhere ( array ('&&', 'Url', '<>','') );
        $o_snap->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) );
        $o_snap->PushOrder ( array ('Date', D) );
        for($i=0;$i<$o_snap->getAllCount();$i++)
        {
        	$s_thumb='';
        	if ($o_snap->getType($i)=='img') {
        		$s_type='照片';
        		$s_thumb=$RELATIVITY_PATH.$o_snap->getUrl($i);
        	}
        	if ($o_snap->getType($i)=='video') {
        		$s_type='视频';
        		$s_thumb='images/video.png';
        	}
        	$s_html.='
        		<div class="weui-cell weui-cell_access" onclick="location=\''.$RELATIVITY_PATH.$o_snap->getUrl($i).'\'">
        			<div class="weui-media-box__hd" style="margin-right: .8em;width: 60px;height:60px;line-height: 60px;text-align: center;">
                        <img class="weui-media-box__thumb" style="width:100%;max-height: 100%;vertical-align: top;" src="'.$s_thumb.'" alt="">
                    </div>
	                <div class="weui-cell__bd">
	                    <span style="vertical-align: middle">'.$o_bn_base->GetDateForChinese($o_snap->getDate($i)).'</span>
					    <br>
					    <span style="font-size:0.7em;color:#999999">幼儿姓名：'.$o_snap->getStudentName($i).'</span>
					    &nbsp;&nbsp;
					    <span style="font-size:0.7em;color:#999999">拍摄者：'.$o_snap->getTeacherName($i).'</span>
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
        	<div class="weui-cells__title">随拍列表</div>
        	<div class="weui-cells">
        		<?php echo($s_html)?>
        	</div>
        	<div style="padding:15px;">
	    		<a class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'))">关闭</a>
    		</div>
        	<?php
        }
        ?>
<script>
//禁止分享
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {WeixinJSBridge.call('hideOptionMenu');});
</script>  
<?php require_once '../footer.php';?>