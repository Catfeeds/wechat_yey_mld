var O_Func
function Dialog_Error(s_message,o_func){
	var title = "错误提示";
	var btn_h = '<a href="javascript:;" onclick="Dialog_Ok_Button()" class="weui-dialog__btn weui-dialog__btn_primary">确定</a>';
	$('#dialog .weui-dialog__title').html(title);
	$('#dialog .weui-dialog__bd').html(s_message);
	$('#dialog .weui-dialog__ft').html(btn_h);
	$('#dialog').fadeIn(300);
	O_Func=o_func
}
function Dialog_Success(s_message,o_func){
	var title = "成功提示";
	var btn_h = '<a href="javascript:;" onclick="Dialog_Ok_Button()" class="weui-dialog__btn weui-dialog__btn_primary">确定</a>';
	$('#dialog .weui-dialog__title').html(title);
	$('#dialog .weui-dialog__bd').html(s_message);
	$('#dialog .weui-dialog__ft').html(btn_h);
	$('#dialog').fadeIn(300);
	O_Func=o_func
}
function Dialog_Message(s_message,o_func){
	var title = "系统提示";
	var btn_h = '<a href="javascript:;" onclick="Dialog_Ok_Button()" class="weui-dialog__btn weui-dialog__btn_primary">确定</a>';
	$('#dialog .weui-dialog__title').html(title);
	$('#dialog .weui-dialog__bd').html(s_message);
	$('#dialog .weui-dialog__ft').html(btn_h);
	$('#dialog').fadeIn(300);
	O_Func=o_func
}
function Dialog_Confirm(s_message,o_func){
	var title = "确认提示";
	var btn_h = '<a href="javascript:;" class="weui-dialog__btn weui-dialog__btn_default" onclick="Common_CloseDialog()">取消</a><a href="javascript:;" onclick="Dialog_Ok_Button()" class="weui-dialog__btn weui-dialog__btn_primary">确定</a>';
	$('#dialog .weui-dialog__title').html(title);
	$('#dialog .weui-dialog__bd').html(s_message);
	$('#dialog .weui-dialog__ft').html(btn_h);
	$('#dialog').fadeIn(300);
	O_Func=o_func
}
function Common_OpenLoading(){
    $('#loadingToast').show();
}
function Dialog_Ok_Button(){
    Common_CloseDialog()
    if(O_Func){
        O_Func();
    }
}
function Common_CloseDialog(){
	$('#dialog').hide();
	$('#loadingToast').hide();
}