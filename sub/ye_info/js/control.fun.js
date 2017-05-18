$(function(){
	$('#Vcl_KeyYeInfo').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_yeinfo()   
	    }  
	});  
})
function search_for_yeinfo()
{
	var fun='YeInfo';
	var id='Vcl_KeyYeInfo'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"OtherKey",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,key,encodeURIComponent(document.getElementById(id).value));    
}
function download_pdf(url)
{
    dialog_message("下载PDF所用时间较长，<br/>请不要有任何操作，耐心等待。<br/>点击“确定”后开始下载...",function(){ 
		window.open(url,'_blank');
	})  
}