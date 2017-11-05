<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_title='工作流程申请';
$s_creatives='尹陆明';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat_View();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
require_once '../header.php';
$o_main=new Dailywork_Workflow_Main($_GET['id']);
if (!($o_main->getNumber()>0))
{
	//非法ID，那么退出
	echo "<script>location.href='workflow_list.php'</script>"; 
	exit(0);
}
//设置分享图标和标题与说明
require_once RELATIVITY_PATH . 'sub/wechat/include/accessToken.class.php';
$o_token = new accessToken ();
$s_token = $o_token->getRefreshToken();
$jsapiTicket =getJsApiTicket($s_token);
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$timestamp = time();
$nonceStr =createNonceStr();
$string = 'jsapi_ticket='.$jsapiTicket.'&noncestr='.$nonceStr.'&timestamp='.$timestamp.'&url='.$url;
$signature = sha1($string);
function createNonceStr($length = 16) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$str = "";
	for($i = 0; $i < $length; $i ++) {
		$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
	}
	return $str;
}
function getJsApiTicket($s_token) {
	$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$s_token;
	$o_util=new curlUtil();
	$s_return=$o_util->https_request($url);
	$res=json_decode($s_return, true);
	return $res['ticket'];
}
?>
<div class="page">
    <div class="page__hd" style="padding:20px;padding-bottom:10px;">
        <h1 class="page__title" style="font-size: 1.6em;"><?php echo($o_main->getTitle())?></h1>
    </div>
    <div class="page__bd">
    	<div class="weui-cells__title">申请人姓名</div>
		<div class="weui-cells">
			<div class="weui-cell">
				<div class="weui-cell__bd">
					<?php 
						echo($o_temp->getName(0));
					?>
				</div>
			</div>
		</div>
    	<form action="<?php echo($RELATIVITY_PATH)?>sub/dailywork/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="WechatWorkflowNew"/>
			<input type="hidden" name="Vcl_Id" value="<?php echo($o_main->getId())?>"/>
			<script type="text/javascript">
				var a_must=[];
				var a_id=[];
				var a_name=[];
			</script>
			<?php 
			$o_main_vcl=new Dailywork_Workflow_Main_Vcl();
			$o_main_vcl->PushWhere ( array ('&&', 'MainId', '=',$o_main->getId()) ); 
			$o_main_vcl->PushOrder ( array ('Number', 'A') );
			for($i=0;$i<$o_main_vcl->getAllCount();$i++)
			{
				$s_html=str_replace('%id%', $o_main_vcl->getId($i), $o_main_vcl->getHtml($i));
				$s_html=str_replace('%token%',$s_token,$s_html);
				echo($s_html);
				//是否必填项输出数组，去掉单选控件，单选控件如果验证必填，需要去后台验证
				if($o_main_vcl->getType($i)=='single')
				{
					continue;
				}
				echo('
				<script type="text/javascript">
					a_id.push('.$o_main_vcl->getId($i).');
					a_must.push('.$o_main_vcl->getIsMust($i).');
					a_name.push(\''.$o_main_vcl->getName($i).'\');
				</script>
				');
			}
			?>
			<div class="weui-gallery" id="gallery_1">
	            <span class="weui-gallery__img" id="galleryImg_1" title=""></span>
	            <div class="weui-gallery__opr">
	                <a href="javascript:" class="weui-gallery__del" onclick="delete_image()">
	                    <i class="weui-icon-delete weui-icon_gallery-delete"></i>
	                </a>
	            </div>
	        </div>
			<div class="weui-cells__title">上传图片（最多8张）</div>
			<div class="weui-cells">
				<div class="weui-cell">
					<div class="weui-cell__bd">
	                    <div class="weui-uploader">
	                        <div class="weui-uploader__bd">
	                            <ul class="weui-uploader__files" id="uploaderFiles_1">
	                            	
	                            </ul>
	                            <div class="weui-uploader__input-box" id="upload_btn_1" onclick="choose_image_1('<?php echo($s_token)?>')">
	                            </div>
	                        </div>
	                    </div>
	                </div>
				</div>
			</div>
			<input type="hidden" name="Vcl_1" id="Vcl_1" value=""/>
			<script type="text/javascript">
			$(function(){
			    var $gallery = $("#gallery_1"), $galleryImg = $("#galleryImg_1"),
			        $uploaderFiles = $("#uploaderFiles_1")
			        ;
			    $uploaderFiles.on("click", "li", function(){
			        $galleryImg.attr("style", this.getAttribute("style"));
			        $galleryImg.attr("title", this.getAttribute("id"));
			        $gallery.fadeIn(100);
			    });
			    $gallery.on("click", function(){			    	
			        $gallery.fadeOut(100);
			    });
			    var a_files_1=[];
			});
			function delete_image()
			{
				Dialog_Confirm('真的要删除这张图片吗？',function(){
					var url=$('#'+$("#galleryImg_1").attr('title')).attr('title')//获取图片URL
					$('#'+$("#galleryImg_1").attr('title')).remove();//删除元素
					check_upload_btn_show()//判断是否显示上传图片按钮
					var urls=$('#Vcl_1').val();
					urls=urls.replace(url,'')//将控件的值替换为空
					$('#Vcl_1').val(urls)
				});				
			}
			function choose_image_1(token)
			{
				var number=8//设置最大能上传多少张图片
				var a_obj=$("#uploaderFiles_1 li")
				number=number-a_obj.length
				if (number==0)
				{
					Dialog_Message('对不起，最多只能上传8张图片！');
					return;
				}
				wx.chooseImage({
				    count: number, // 默认9
				    sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
				    sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
				    success: function (res) {
				    	var localids=res.localIds;
				    	sync_upload_1(localids,token);   	
				    }
				});
			}
			function check_upload_btn_show()
			{
				var number=8//设置最大能上传多少张图片
				var a_obj=$("#uploaderFiles_1 li")
				if((a_obj.length+1)>=number)
				{
					$('#upload_btn_1').hide();
				}else{
					$('#upload_btn_1').show();
				}
			}
			function sync_upload_1(localIds,token)
			{
				wx.uploadImage({
				    localId:localIds.pop(), // 需要上传的图片的本地ID，由chooseImage接口获得
				    isShowProgressTips: 1, // 默认为1，显示进度提示
				    success: function (res) {
				        var serverId = res.serverId; // 返回图片的服务器端ID
				        //成功后，需要把上传成功的ID，保存到控件中
				        if ($('#Vcl_1').val()=='')
				        {
					        //说明是第一个
				        	$('#Vcl_1').val('http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId);
					    }else{
					    	$('#Vcl_1').val($('#Vcl_1').val()+',http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId);
						}
						//判断是否该隐藏添加图片的按钮
				        check_upload_btn_show()
						//将图片控件插入到最后
				        $("#uploaderFiles_1").append('<li id="Vcl_Image_'+(new Date()).valueOf()+'" class="weui-uploader__file" title="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId+'" style="background-image:url(http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId+')"></li>')
				        if(localIds.length > 0){
				        	sync_upload_1(localIds,token); 
				        }
				    },
				    fail:function(res){
				    	Dialog_Message('您有一张图片上传失败，请重试！');
				    	if(localIds.length > 0){
				        	sync_upload_1(localIds);
				        }
				   }
				});
			}
			</script>	
		</form>
    </div>
    <div style="padding:15px;">
	    <a href="javascript:;" class="weui-btn weui-btn_primary" onclick="dailywork_workflow_submit(a_id,a_must,a_name)">提交申请</a>
	    <a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
    </div>   					
</div>
<script type="text/javascript" src="js/function.js"></script>
<script src="<?php echo(RELATIVITY_PATH)?>sub/wechat/js/jweixin-1.0.0.js" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: 'wxf38509d7749bb56d', // 必填，公众号的唯一标识
        timestamp: <?php echo($timestamp)?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo($nonceStr)?>', // 必填，生成签名的随机串
        signature: '<?php echo($signature);?>',// 必填，签名，见附录1
        jsApiList: ['chooseImage','uploadImage','wx.checkJsApi'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
});
</script>
<?php
require_once '../footer.php';
?>