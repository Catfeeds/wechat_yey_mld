<?php
?>
		<!--BEGIN dialog1-->
        <div class="js_dialog" id="dialog" style="display: none;">
            <div class="weui-mask"></div>
            <div class="weui-dialog">
                <div class="weui-dialog__hd"><strong class="weui-dialog__title"></strong></div>
                <div class="weui-dialog__bd"></div>
                <div class="weui-dialog__ft">
                </div>
            </div>
        </div>
        <!--END dialog1-->
        <!--BEGIN toast-->
	    <div id="toast" style="display: none;">
	        <div class="weui-mask_transparent"></div>
	        <div class="weui-toast">
	            <i class="weui-icon-success-no-circle weui-icon_toast"></i>
	            <p class="weui-toast__content">已完成</p>
	        </div>
	    </div>
	    <!--end toast-->
	
	    <!-- loading toast -->
	    <div id="loadingToast" style="display:none;">
	        <div class="weui-mask_transparent"></div>
	        <div class="weui-toast">
	            <i class="weui-loading weui-icon_toast"></i>
	            <p class="weui-toast__content">数据加载中</p>
	        </div>
	    </div>
	    <div class="sss_gotop" data-placement="left">
			<img src="images/gotop.png" style="width:23px"/>
		</div>
	    <iframe id="ajax_submit_frame" name="ajax_submit_frame" width="0" height="0" marginwidth="0" border="0" frameborder="0" src="about:blank" style="display:none"></iframe>
	    <script type="text/javascript">
	    $(function(){
			$('.sss_gotop').click(function () {
				$("body,html").animate({scrollTop:0}, 500);
			});	
		});
		</script>
</body>
</html>