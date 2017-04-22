$(function(){
	$('#Vcl_MsgKey').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_msg()   
	    }  
	}); 
	$('#Vcl_ImgmsgKey').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_imgmsg()   
	    }  
	}); 
	$('#Vcl_ImgKey').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_img()   
	    }  
	}); 
})
function open_photo(photo)
{
    dialog_photo('<img style="width:414px;height:230px;" src="'+photo+'"/>')	 
}
function dialog_photo(text,fun)
{
    $.teninedialog({
        width:'450px',
        title: '<span style="' + Language.Font + '">图片预览</span>',
        content: '<span style="' + Language.Font + 'font-size:14px;">' + text + '</span>',
        showCloseButton:false,
        otherButtons:['<span style="'+Language.Font+'">'+Language.Confirm+'</span>'],
        otherButtonStyles:['btn-primary'],
        bootstrapModalOption:{keyboard: true},
        dialogShow:function(){
            //alert('即将显示对话框');
        },
        dialogShown:function(){
            //alert('显示对话框');
			/*$('.modal-backdrop fade in').backgroundBlur({
		    	imageURL:'images/2.png',
		    	blurAmount : 10,
		        sharpness: 40,
		        endOpacity : 1
		    });*/ 
        },
        dialogHide:function(){
            //alert('即将关闭对话框');
        },
        dialogHidden:function(){
            //alert('关闭对话框');
        },                    
        clickButton:function(sender,modal,index){
            //alert('选中第'+index+'个按钮：'+sender.html());
            if(fun){
                fun();
            }
            
            $(this).closeDialog(modal);
        }
    });
}
function search_for_msg()
{
	var fun='MsgTable';
	var id='Vcl_MsgKey'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value));    
}
function search_for_imgmsg()
{
	var fun='ImgmsgTable';
	var id='Vcl_ImgmsgKey'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value));    
}
function search_for_img()
{
	var fun='ImgTable';
	var id='Vcl_ImgKey'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value));    
}
function msg_modify()
{
	var val = $('#Vcl_Content').val();
    if (val.length == 0) {
        dialog_message('“文字消息内容”不能为空！')
        return
    }
    loading_show();
	$('#submit_form').submit();
}
function msg_delete(id) {
    dialog_confirm('您真的要删除吗？删除后将不能恢复，请谨慎操作！',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=MsgDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('MsgTable')
        	}        	
        })
    })
}
function imgmsg_modify()
{
	var val = $('#Vcl_Title').val();
    if (val.length == 0) {
        dialog_message('“标题”不能为空！')
        return
    }
	var val = $('#Vcl_MessageUrl').val();
    if (val.length == 0) {
        dialog_message('“跳转链接”不能为空！')
        return
    }
    loading_show();
	$('#submit_form').submit();
}
function imgmsg_delete(id) {
    dialog_confirm('您真的要删除吗？删除后将不能恢复，请谨慎操作！',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=ImgmsgDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('ImgmsgTable')
        	}        	
        })
    })
}
function img_modify()
{
	var val = $('#Vcl_Description').val();
    if (val.length == 0) {
        dialog_message('“说明”不能为空！')
        return
    }
    loading_show();
	$('#submit_form').submit();
}
function img_delete(id) {
    dialog_confirm('您真的要删除吗？删除后将不能恢复，请谨慎操作！',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=ImgDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('ImgTable')
        	}        	
        })
    })
}