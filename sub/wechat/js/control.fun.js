function load_course()
{
	$.cookie("SubjectId",$('#Vcl_SubjectId').val());
	$.cookie("Time",$('#Vcl_TeacherId').val());
	$.cookie("Class",$('#Vcl_Class').val());
	$.cookie("Remain",$('#Vcl_Remain').val());
	Common_OpenLoading();
    var data = 'Ajax_FunName=LoadCourse'; //后台方法
    data = data + '&subjectid=' + $('#Vcl_SubjectId').val()+ '&time=' +$('#Vcl_Time').val()+ '&remain=' + $('#Vcl_Remain').val()+ '&class=' + $('#Vcl_Class').val();
    $.getJSON("include/bn_submit.switch.php", data, function (json) {
	     build_course_list(json)       	
	})
}
function build_course_list(json)
{
	$('#count').html(json.length)
	var a_arr=[];
	for(var i=0;i<json.length;i++)
	{
		var data=json[i];
		a_arr.push('	<div class="weui-form-preview">');
	    a_arr.push('        <div class="weui-form-preview__hd">');
	    a_arr.push('            <div class="weui-form-preview__item">');
	    a_arr.push('                <label class="weui-form-preview__label">课程名称</label>');
	    a_arr.push('                <em class="weui-form-preview__value">'+data.name+'</em>');
	    a_arr.push('            </div>');
	    a_arr.push('        </div>');
	    a_arr.push('        <div class="weui-form-preview__bd">');
	    a_arr.push('        	<div class="weui-form-preview__item">');
	    a_arr.push('                <label class="weui-form-preview__label">上课时间</label>');
	    a_arr.push('                <span class="weui-form-preview__value">'+data.time+'</span>');
	    a_arr.push('            </div>');
	    a_arr.push('        	<div class="weui-form-preview__item">');
	    a_arr.push('               <label class="weui-form-preview__label">科目</label>');
	    a_arr.push('                <span class="weui-form-preview__value">'+data.subject_name+'</span>');
	    a_arr.push('            </div>');
		a_arr.push('        	<div class="weui-form-preview__item">');
	    a_arr.push('               <label class="weui-form-preview__label">教室</label>');
	    a_arr.push('                <span class="weui-form-preview__value">'+data.class+'</span>');
	    a_arr.push('            </div>');
	    a_arr.push('            <div class="weui-form-preview__item">');
	    a_arr.push('                <label class="weui-form-preview__label">任课教师</label>');
	    a_arr.push('                <span class="weui-form-preview__value">'+data.teacher_name+'</span>');
	    a_arr.push('            </div>');
	    a_arr.push('            <div class="weui-form-preview__item">');
	    a_arr.push('                <label class="weui-form-preview__label">招生对象</label>');
	    a_arr.push('                <span class="weui-form-preview__value">'+data.target+'</span>');
	    a_arr.push('            </div>');
	    a_arr.push('            <div class="weui-form-preview__item">');
	    a_arr.push('                <label class="weui-form-preview__label">容纳人数</label>');
	    a_arr.push('                <span class="weui-form-preview__value">'+data.sum+'人</span>');
	    a_arr.push('            </div>      ');
	    a_arr.push('            <div class="weui-form-preview__item">');
	    a_arr.push('                <label class="weui-form-preview__label">课时</label>');
	    a_arr.push('                <span class="weui-form-preview__value">'+data.counts+'次</span>');
	    a_arr.push('            </div>');
	    a_arr.push('            <div class="weui-form-preview__item">');
	    a_arr.push('                <label class="weui-form-preview__label" style="font-size:1.2em">总价</label>');
	    a_arr.push('                <span class="weui-form-preview__value" style="font-size:1.4em;color:red">¥'+data.total.toFixed(2)+'</span>');
	    a_arr.push('            </div>');
	    a_arr.push('        </div>');
	    a_arr.push('        <div class="weui-form-preview__ft">');
		if (data.remain==1)
		{
			a_arr.push('            <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="signup_info.php?id='+data.id+'">报名</a>');
		}else{
			a_arr.push('            <div style="text-align:center;width:100%;color:red">名额已满</div>');
		}	    
	    a_arr.push('        </div>');
	    a_arr.push('    </div>');
	    a_arr.push('    <br>');
	}
	$('#course_list').html(a_arr.join('\n'));
	Common_CloseDialog()
}
function isMobile(str) 
{
    if (str.toString().length != 11) return false;
    var prefix = [130,133,135,189,137,136,131,134,138,139,150,151,152,155,156,185,132,153,158,187,182,159,186,180,181,157,182,187,188,145,147,188];
    var re = new RegExp("^(" + prefix.join("|") + ")\\d+$");
    return re.test(str);
}
function check_id(){
	//
	var documentType=document.getElementById("Vcl_IdType").value;
	if(documentType=='居民身份证'){
	 	var studentCardNo = document.getElementById("Vcl_IdCard").value;
		if(studentCardNo!="" || studentCardNo!=null){
		   if(studentCardNo.length != 15 && studentCardNo.length != 18){
		   		document.getElementById("Vcl_Birthday").value="";
		        Dialog_Message("身份证号长度应为15或者18位")
		        return false;
		   }else{
		   		var newCardNoAdd = checkId(studentCardNo.toLowerCase());
				if("身份证输入错误！" == newCardNoAdd){
		        	Dialog_Message("身份证输入错误！");
		            return false;
		    	}
		   		var sexValue = (newCardNoAdd.slice(14,17)%2 ? '男' : '女');
		      	var birthdayValue = newCardNoAdd.slice(6,10) +"-"+ newCardNoAdd.slice(10,12) +"-"+ newCardNoAdd.slice(12,14);
			    document.getElementById("Vcl_Birthday").value=birthdayValue;
			    var checkStr = "0123456789xX";
			    var reg = /^[0-9xX]+$/;
			    if (!reg.test(studentCardNo))
			    {
					Dialog_Message("身份证号格式错误，只能由数字或X组成。");   
					return false;  
				}
				//判断身份证号前六位是否为110102
				if(studentCardNo.substring(0,6)=='110102' || studentCardNo.substring(0,6)=='110104')
				{
					document.getElementById("Vcl_HArea").value='西城区';
				}else{
					document.getElementById("Vcl_HArea").value='非西城区';
				}
				document.getElementById("Vcl_Sex").value=sexValue;
		   	}
		 }
	  }else{
	  	var studentCardNo = document.getElementById("Vcl_IdCard").value;
		if(studentCardNo==""){
	  		Dialog_Message("证件号不能为空值！");
		  	return false;
	  	}
	  }
}
function checkId(pId){
    var arrVerifyCode = [1,0,"x",9,8,7,6,5,4,3,2];
    var Wi = [7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2];
    var Checker = [1,9,8,7,6,5,4,3,2,1,1];
    if(pId.length != 15 && pId.length != 18) return "身份证号共有 15 码或18位";
    var Ai=pId.length==18 ?  pId.substring(0,17)   :   pId.slice(0,6) + "19" + pId.slice(6,16);
    if (!/^\d+$/.test(Ai))  return "身份证除最后一位外，必须为数字！";
    var yyyy=Ai.slice(6,10) ,  mm=Ai.slice(10,12)-1  ,  dd=Ai.slice(12,14);
    var d=new Date(yyyy,mm,dd) ,  now=new Date();
    var year=d.getFullYear() ,  mon=d.getMonth() , day=d.getDate();
    if (year!=yyyy || mon!=mm || day!=dd || d>now || year<1940) return "身份证输入错误！";
    for(var i=0,ret=0;i<17;i++)  ret+=Ai.charAt(i)*Wi[i];    
    Ai+=arrVerifyCode[ret %=11];     
    return pId.length ==18 && pId != Ai?"身份证输入错误！":Ai;        
}
function student_change_idtype(obj)
{
	if (obj.value=='居民身份证')
	{
		$('#sex').hide();
		$('#harea').hide();
		$('#birthday').hide();
	}else{
		$('#sex').show();
		$('#harea').show();
		$('#birthday').show();
	}
	$('#Vcl_IdCard').val('');
}
function sutdent_add()
{
	if ($("#Vcl_Name").val()=='')
	{
		Dialog_Message('学生姓名不能为空！');
		return;
	}
	if(check_id()==false)
	{
		return;
	}
	if ($("#Vcl_Sex").val()=='')
	{
		Dialog_Message('请选择性别！');
		return;
	}
	if ($("#Vcl_Birthday").val()=='')
	{
		Dialog_Message('出生日期不能为空！');
		return;
	}
	if ($("#Vcl_HArea").val()=='')
	{
		Dialog_Message('请选择户籍！');
		return;
	}
	if ($("#Vcl_XArea").val()=='')
	{
		Dialog_Message('请选择学籍！');
		return;
	}
	if ($("#Vcl_ParentName").val()=='')
	{
		Dialog_Message('监护人姓名！');
		return;
	}
	if ($("#Vcl_Phone").val()=='' || isMobile($("#Vcl_Phone").val())==false)
    {
		Dialog_Message('请填写正确的监护人手机号！');
		return;
	}
	document.getElementById('submit_form').onsubmit();
	Common_OpenLoading();
}
function course_signup(n_sum)
{
	if (n_sum==0)
    {
		Dialog_Message('请添加报名学生信息！');
		return;
	}
	document.getElementById('submit_form').onsubmit();
	Common_OpenLoading();
}
function signup_cancel(id) {
    Dialog_Confirm('真的要取消报名吗？',function(){
    	Common_OpenLoading();
    	var data = 'Ajax_FunName=SignupCancel'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	window.location.href="waiting_signup.php?"+Date.parse(new Date());    	
        })
    })
}
function invoice_apply(id) {
    Dialog_Confirm('真的要申请发票吗？',function(){
    	Common_OpenLoading();
    	var data = 'Ajax_FunName=InvoiceApply'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	window.location.href="record_pay_invoice_successful.php";    	
        })
    })
}
function invoice_cancel(id) {
    Dialog_Confirm('真的要取消发票申请吗？',function(){
    	Common_OpenLoading();
    	var data = 'Ajax_FunName=InvoiceCancel'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	window.location.href="record_pay.php?"+Date.parse(new Date());    	
        })
    })
}
function teacher_in_confirm(id) {
    Dialog_Confirm('真的要确认录取吗？',function(){
    	Common_OpenLoading();
    	var data = 'Ajax_FunName=MyCourseInConfirm'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("../../../sub/mycourse/include/bn_submit.switch.php", data, function (json) {
        	if(json.flag==0)
			{
        		Dialog_Error(json.msg);
			}else{
				//修改状态
				$('.state'+json.flag).css("color","red");
				$('.state'+json.flag).html("未交费");
				//修改按钮
				$('.btn'+json.flag).html('<a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="teacher_pay_remind('+json.flag+')">提醒交费</a><a class="weui-form-preview__btn weui-form-preview__btn_default" onclick="teacher_in_cancel('+json.flag+')" style="color:red">取消录取</a>');
			}
        	Common_CloseDialog()
        })
    })
}
function teacher_pay_remind(id) {
    Dialog_Confirm('确认要提醒交费吗？监护人会收到微信提醒。',function(){
    	Common_OpenLoading();
    	var data = 'Ajax_FunName=MyCoursePayRemind'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("../../../sub/mycourse/include/bn_submit.switch.php", data, function (json) {
        	Common_CloseDialog()
        	Dialog_Success(json.msg)
        })
    })
}
function teacher_in_cancel(id) {
    Dialog_Confirm('真的要取消录取吗？',function(){
    	Common_OpenLoading();
    	var data = 'Ajax_FunName=MyCourseInCancel'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("../../../sub/mycourse/include/bn_submit.switch.php", data, function (json) {
        	if(json.flag==0)
			{
        		Dialog_Error(json.msg);
			}else{
				//修改状态
				$('.state'+json.flag).css("color","#EEA236");
				$('.state'+json.flag).html("等待录取");
				//修改按钮
				$('.btn'+json.flag).html('<a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="teacher_in_confirm('+json.flag+')">确认录取</a>');
			}
        	Common_CloseDialog()
        })
    })
}
function teacher_stu_checkingin() {
    Dialog_Confirm('真的要提交考勤吗？',function(){
    	document.getElementById('submit_form').onsubmit();
    })
}