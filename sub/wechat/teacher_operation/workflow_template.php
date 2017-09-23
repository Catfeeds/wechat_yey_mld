<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='工作流程模板';
//想判断教师权限，是否为绑定用户
require_once '../header.php';
?>
<div class="page">
    <div class="page__bd">
    
    

<div class="weui-cells__title">文本类型</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">
		</div>
	</div>
</div>
<div class="weui-cells__title">日期类型</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" type="date" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">
		</div>
	</div>
</div>
<div class="weui-cells__title">下拉框类型</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<select class="weui-select" id="Vcl_%id%" name="Vcl_%id%">
	        	<option value="">必选</option>
				<option value="初中及以下">初中及以下</option>
				<option value="高中及中专">高中及中专</option>
				<option value="技校">技校</option>
				<option value="大专">大专</option>
				<option value="本科">本科</option>
				<option value="硕士研究生">硕士研究生</option>
				<option value="博士研究生及以上">博士研究生及以上</option>
	        </select>
		</div>
	</div>
</div>
<div class="weui-cells__title">多选类型</div>
<div class="weui-cells weui-cells_form">
	<div class="weui-cell weui-cell_switch">
		<div class="weui-cell__bd">选项1</div>
		<div class="weui-cell__ft">
			<input class="weui-switch" onchange="dailywork_workflow_new_change_check(this,'%id%','选项1')" type="checkbox"/>
		</div>
	</div>
	<div class="weui-cell weui-cell_switch">
		<div class="weui-cell__bd">选项2</div>
		<div class="weui-cell__ft">
			<label for="switchCP" class="weui-switch-cp">
				<input class="weui-switch" onchange="dailywork_workflow_new_change_check(this,'%id%','选项2')" type="checkbox"/>
			</label>
		</div>
	</div>
	<input type="hidden"  id="Vcl_%id%" name="Vcl_%id%" value=""/>
</div>
<div class="weui-cells__title">单选类型</div>
<div class="weui-cells weui-cells_radio">
	<label class="weui-cell weui-check__label" for="Vcl_%id%_1">
		<div class="weui-cell__bd">
			<p>选项01</p>
		</div>
	<div class="weui-cell__ft">
		<input type="radio" class="weui-check" value="选项01" id="Vcl_%id%_1" name="Vcl_%id%">
		<span class="weui-icon-checked"></span>
	</div>
	</label>
	<label class="weui-cell weui-check__label" for="Vcl_%id%_2">
		<div class="weui-cell__bd">
			<p>选项02</p>
		</div>
		<div class="weui-cell__ft">
			<input type="radio" class="weui-check" value="选项02" id="Vcl_%id%_2" name="Vcl_%id%">
			<span class="weui-icon-checked"></span>
		</div>
	</label>
</div>
<div class="weui-cells__title">手机类型</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" type="number" pattern="[0-9]*" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">
		</div>
	</div>
</div>
<div class="weui-cells__title">数字类型</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" type="number" id="Vcl_%id%" onkeyup="value=value.replace(/[^0-9.]/g,'')" name="Vcl_%id%" placeholder="必填">
		</div>
	</div>
</div>




<div class="weui-cells__title">审批意见</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="选填">
		</div>
	</div>
</div>


<div class="weui-cells__title">休假时间段（结束时间）</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" type="datetime-local" value="" placeholder="必填">
		</div>
	</div>
</div>

<div class="weui-cells__title">休假时间段（终止日期）</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" type="datetime-local" value="" placeholder="必填">
		</div>
	</div>
</div>

<div class="weui-cells__title">工作安排</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<input class="weui-input" id="Vcl_%id%" name="Vcl_%id%" placeholder="必填">
		</div>
	</div>
</div>




<div class="weui-gallery" id="gallery_%id%">
	<span class="weui-gallery__img" id="galleryImg_%id%" title=""></span>
	<div class="weui-gallery__opr">
	   	<a href="javascript:" class="weui-gallery__del" onclick="delete_image()">
	       	<i class="weui-icon-delete weui-icon_gallery-delete"></i>
	    </a>
	</div>
</div>
<div class="weui-cells__title">上传图片（最多8张，可选项目）</div>
<div class="weui-cells">
	<div class="weui-cell">
		<div class="weui-cell__bd">
			<div class="weui-uploader">
				<div class="weui-uploader__bd">
					<ul class="weui-uploader__files" id="uploaderFiles_%id%">
					</ul>
					<div class="weui-uploader__input-box" id="upload_btn_%id%" onclick="choose_image_%id%('%token%')">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="Vcl_%id%" id="Vcl_%id%" value=""/>
<script type="text/javascript">
$(function(){
    var $gallery = $("#gallery_%id%"), $galleryImg = $("#galleryImg_%id%"),
        $uploaderFiles = $("#uploaderFiles_%id%")
        ;
    $uploaderFiles.on("click", "li", function(){
        $galleryImg.attr("style", this.getAttribute("style"));
        $galleryImg.attr("title", this.getAttribute("id"));
        $gallery.fadeIn(100);
    });
    $gallery.on("click", function(){    	
        $gallery.fadeOut(100);
    });
    var a_files_%id%=[];
});
function delete_image()
{
	Dialog_Confirm('真的要删除这张图片吗？',function(){
		var url=$('#'+$("#galleryImg_%id%").attr('title')).attr('title')//获取图片URL
		$('#'+$("#galleryImg_%id%").attr('title')).remove();//删除元素
		check_upload_btn_show()//判断是否显示上传图片按钮
		var urls=$('#Vcl_%id%').val();
		urls=urls.replace(','+url,'')//将控件的值替换为空
		urls=urls.replace(url,'')//将控件的值替换为空
		$('#Vcl_%id%').val(urls)
	});	
}
function choose_image_%id%(token)
{
	var number=8//设置最大能上传多少张图片
	var a_obj=$("#uploaderFiles_%id% li")
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
	    	sync_upload_%id%(localids,token);   	
	    }
	});
}
function check_upload_btn_show()
{
	var number=8//设置最大能上传多少张图片
	var a_obj=$("#uploaderFiles_%id% li")
	if(a_obj.length>=number)
	{
		$('#upload_btn_%id%').hide();
	}else{
		$('#upload_btn_%id%').show();
	}
}
function sync_upload_%id%(localIds,token)
{
	wx.uploadImage({
	    localId:localIds.pop(), // 需要上传的图片的本地ID，由chooseImage接口获得
	    isShowProgressTips: 1, // 默认为1，显示进度提示
	    success: function (res) {
	        var serverId = res.serverId; // 返回图片的服务器端ID
	        //成功后，需要把上传成功的ID，保存到控件中
	        if ($('#Vcl_%id%').val()=='')
	        {
		        //说明是第一个
	        	$('#Vcl_%id%').val('http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId);
		    }else{
		    	$('#Vcl_%id%').val($('#Vcl_%id%').val()+',http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId);
			}			
			//将图片控件插入到最后
	        $("#uploaderFiles_%id%").append('<li id="Vcl_Image_'+(new Date()).valueOf()+'" class="weui-uploader__file" title="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId+'" style="background-image:url(http://file.api.weixin.qq.com/cgi-bin/media/get?access_token='+token+'&media_id='+serverId+')"></li>')
	        //判断是否该隐藏添加图片的按钮
	        check_upload_btn_show()
	        if(localIds.length > 0){
	        	sync_upload_%id%(localIds,token); 
	        }
	    },
	    fail:function(res){
	    	Dialog_Message('您有一张图片上传失败，请重试！');
	    	if(localIds.length > 0){
	        	sync_upload_%id%(localIds);
	        }
	   }
	});
}
</script>



</div>
    <div style="padding:15px;">
	    <a href="javascript:;" class="weui-btn weui-btn_primary" onclick="">提交申请</a>
	    <a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
    </div>   					
</div>
<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript">

</script>
<?php
require_once '../footer.php';
?>