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
        	if ($o_snap->getType($i)=='img') {
        		$s_type='照片';
        	}
        	if ($o_snap->getType($i)=='video') {
        		$s_type='视频';
        	}
        	$s_html.='
        		<div class="weui-cell weui-cell_access" onclick="">
        			<div class="weui-media-box__hd" style="margin-right: .8em;width: 60px;height:60px;line-height: 60px;text-align: center;">
                        <img class="weui-media-box__thumb" style="width:100%;max-height: 100%;vertical-align: top;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAB4CAMAAAAOusbgAAAAeFBMVEUAwAD///+U5ZTc9twOww7G8MYwzDCH4YcfyR9x23Hw+/DY9dhm2WZG0kbT9NP0/PTL8sux7LFe115T1VM+zz7i+OIXxhes6qxr2mvA8MCe6J6M4oz6/frr+us5zjn2/fa67rqB4IF13XWn6ad83nxa1loqyirn+eccHxx4AAAC/klEQVRo3u2W2ZKiQBBF8wpCNSCyLwri7v//4bRIFVXoTBBB+DAReV5sG6lTXDITiGEYhmEYhmEYhmEYhmEY5v9i5fsZGRx9PyGDne8f6K9cfd+mKXe1yNG/0CcqYE86AkBMBh66f20deBc7wA/1WFiTwvSEpBMA2JJOBsSLxe/4QEEaJRrASP8EVF8Q74GbmevKg0saa0B8QbwBdjRyADYxIhqxAZ++IKYtciPXLQVG+imw+oo4Bu56rjEJ4GYsvPmKOAB+xlz7L5aevqUXuePWVhvWJ4eWiwUQ67mK51qPj4dFDMlRLBZTqF3SDvmr4BwtkECu5gHWPkmDfQh02WLxXuvbvC8ku8F57GsI5e0CmUwLz1kq3kD17R1In5816rGvQ5VMk5FEtIiWislTffuDpl/k/PzscdQsv8r9qWq4LRWX6tQYtTxvI3XyrwdyQxChXioOngH3dLgOFjk0all56XRi/wDFQrGQU3Os5t0wJu1GNtNKHdPqYaGYQuRDfbfDf26AGLYSyGS3ZAK4S8XuoAlxGSdYMKwqZKM9XJMtyqXi7HX/CiAZS6d8bSVUz5J36mEMFDTlAFQzxOT1dzLRljjB6+++ejFqka+mXIe6F59mw22OuOw1F4T6lg/9VjL1rLDoI9Xzl1MSYDNHnPQnt3D1EE7PrXjye/3pVpr1Z45hMUdcACc5NVQI0bOdS1WA0wuz73e7/5TNqBPhQXPEFGJNV2zNqWI7QKBd2Gn6AiBko02zuAOXeWIXjV0jNqdKegaE/kJQ6Bfs4aju04lMLkA2T5wBSYPKDGF3RKhFYEa6A1L1LG2yacmsaZ6YPOSAMKNsO+N5dNTfkc5Aqe26uxHpx7ZirvgCwJpWq/lmX1hA7LyabQ34tt5RiJKXSwQ+0KU0V5xg+hZrd4Bn1n4EID+WkQdgLfRNtvil9SPfwy+WQ7PFBWQz6dGWZBLkeJFXZGCfLUjCgGgqXo5TuSu3cugdcTv/HjqnBTEMwzAMwzAMwzAMwzAMw/zf/AFbXiOA6frlMAAAAABJRU5ErkJggg==" alt="">
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