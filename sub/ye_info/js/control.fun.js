/**
 * 
 */
function start_sync()
{
	dialog_confirm("确认开始同步吗？<br/><br/>开始后请不要关闭或刷新浏览器，耐心等待同步结束提示。",function (){
		$('#start_sync_btn').attr({"disabled":"disabled"});//将开始按钮变为禁用，防止反复点击
		start_sync_class()
	});
}
var timer=0;
var sum=0;
function start_sync_class()
{
	timer=setInterval('start_sync_class_progress()',300)
	var data = 'Ajax_FunName=SyncClass'; //后台方法
    $.getJSON("include/bn_submit.switch.php", data, function (json) {
		clearInterval(timer)//停止动画
		sum=0;//宽度归零
       	if (json.flag==0)
		{
			dialog_error(json.msg,function(){location.reload()});
			clearInterval(timer)
		}else{
			$('#step_1_progress').css('width','100%')//进度变成100
			$('#step_1_icon').css('display','')//显示对勾
			//开始下一个
			dialog_success('恭喜您，幼儿信息同步成功');
			$('#refresh_btn').css('display','');
			//$('#start_sync_btn').removeAttr("disabled");
		}
    })
}
function start_sync_class_progress()
{
	sum=sum+2
	$('#step_1_progress').css('width',sum+'%')
}
