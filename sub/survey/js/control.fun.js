$(function(){
	$('#Vcl_KeySignup').keypress(function(event){  
	    var keycode = (event.keyCode ? event.keyCode : event.which);  
	    if(keycode == '13'){  
	    	search_for_parent_survey_manage()   
	    }  
	}); 
})
function search_for_parent_survey_manage()
{
	var fun='ParentSurveyManage';
	var id='Vcl_KeyParentSurveyManage'
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	$.cookie(fun+"Key",document.getElementById(id).value);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	var key=$.cookie(fun+"Key");
	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
}
function parent_survey_manage_modify()
{	
    var val = $('#Vcl_Title').val();
    if (val.length == 0) {
        dialog_message('对不起，问卷标题不能为空！')
        return
    }
	loading_show();
	$('#submit_form').submit();
}
function parent_survey_manage_question_modify()
{	
    var val = $('#Vcl_Question').val();
    if (val.length == 0) {
        dialog_message('对不起，题目不能为空！')
        return
    }
    var val = $('#Vcl_Option_1').val();
    if (val.length == 0) {
        dialog_message('对不起，选项A不能为空！')
        return
    }
    var val = $('#Vcl_Option_2').val();
    if (val.length == 0) {
    	dialog_message('对不起，选项B不能为空！')
        return
    }
	loading_show();
	$('#submit_form').submit();
}