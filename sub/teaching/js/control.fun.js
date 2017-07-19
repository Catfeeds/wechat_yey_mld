$(function(){
	$('#Vcl_KeyWeiTeach').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_wei_teach()   
	    }  
	}); 
})
function search_for_wei_teach()
{
	var fun='WeiTeachTable';
	var id='Vcl_KeyWeiTeach'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}