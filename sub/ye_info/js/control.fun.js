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
function class_modify()
{
	var val = $('#Vcl_Grade').val();
    if (val.length == 0) {
        dialog_message('请选择年级！')
        return
    }
    var val = $('#Vcl_ClassName').val();
    if (val.length == 0) {
        dialog_message('班级名称不能为空！')
        return
    }
    loading_show();
	$('#submit_form').submit();
}
function class_delete(id) {
    dialog_confirm('真的要删除这个班级吗？删除后不能恢复，请谨慎操作。',function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=ClassDelete'; //后台方法
        data = data + '&id=' + id;
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
        		table_refresh('YeClassTable')
        	}        	
        })
    })
}
function stu_change_class(id,name,class_name) {
	var a_arr=[];
	a_arr.push('<select name="Vcl_ClassId" id="Vcl_ClassId" class="form-control" style="width:auto">');
	a_arr.push('<option value="">请选择班级</option>');
	for(var i=0;i<a_class_list.length;i++)
	{
		var temp=a_class_list[i];
		a_arr.push('<option value="'+temp[0]+'">'+temp[1]+'</option>');
	}
	a_arr.push('</select>');
    dialog_confirm('幼儿姓名：<b>'+name+'</b><br/>原始班级名称：<b>'+class_name+'</b><br/><br/>请选择调整后的班级，之后请按确认按钮完成调班。<br/><br/>'+a_arr.join('\n'),function(){
    	$('.small_loading').fadeIn(100);
    	var data = 'Ajax_FunName=StuChangeClass'; //后台方法
        data = data + '&id=' + id+'&classid='+$('#Vcl_ClassId').val();
        $.getJSON("include/bn_submit.switch.php", data, function (json) {
        	if (json.success==0)
        	{
        		$('.small_loading').fadeOut(100);
        		dialog_error(json.text)
        	}else{
				$('.small_loading').fadeOut(100);
				dialog_success('调班成功！',function(){
					table_refresh('YeInfo')
				})
        	}        	
        })
    })
}
function change_nationality(obj)
{
	if (obj.value=="中国")
	{
		document.getElementById("nation").style.display='block';
		document.getElementById("other_base").style.display='block';
		document.getElementById("h_info").style.display='block';
		document.getElementById("is_same").style.display='block';
	}else{
		document.getElementById("nation").style.display='none';
		document.getElementById("other_base").style.display='none';
		document.getElementById("h_info").style.display='none';
		document.getElementById("Vcl_ZSame").value='否';
		change_address(document.getElementById("Vcl_ZSame"))
		document.getElementById("is_same").style.display='none';
	}
}
function change_idtype(obj)
{
	if (obj.value=="居民身份证")
	{
		document.getElementById("birthday").innerHTML='<label>出生日期</label><input name="Vcl_Birthday" id="Vcl_Birthday" maxlength="10" type="text" readonly="readonly" value="">';
	}else{
		document.getElementById("birthday").innerHTML='<label>出生日期</label><input name="Vcl_Birthday" id="Vcl_Birthday" maxlength="10" type="text" readonly="readonly" onclick="WdatePicker()" value="">';
	}
}
function change_iscanji(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("canji").style.display='block';
	}else{
		document.getElementById("canji").style.display='none';
	}
}
function change_isdibao(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("dibao").style.display='block';
	}else{
		document.getElementById("dibao").style.display='none';
	}
}
function change_yiwang(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("yiwang").style.display='block';
	}else{
		document.getElementById("yiwang").style.display='none';
	}
}
function change_yichuan(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("yichuan").style.display='block';
	}else{
		document.getElementById("yichuan").style.display='none';
	}
}
function change_shoushu(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("shoushu").style.display='block';
	}else{
		document.getElementById("shoushu").style.display='none';
	}
}
function change_guomin(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("guomin").style.display='block';
	}else{
		document.getElementById("guomin").style.display='none';
	}
}
function change_only(obj)
{
	if (obj.value=="否")
	{
		document.getElementById("first").style.display='block';
		document.getElementById("only_code").style.display='none';
	}else{
		document.getElementById("only_code").style.display='block';
		document.getElementById("first").style.display='none';
	}
}
function change_qulity(obj)
{
	if (obj.value=="非农业户口")
	{
		document.getElementById("quality_type").style.display='block';
	}else{
		document.getElementById("quality_type").style.display='none';
	}
}
function change_canjizheng1(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("canjizheng1").style.display='block';
	}else{
		document.getElementById("canjizheng1").style.display='none';
	}
}
function change_canjizheng2(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("canjizheng2").style.display='block';
	}else{
		document.getElementById("canjizheng2").style.display='none';
	}
}
function change_address(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("address").style.display='none';
	}else{
		document.getElementById("address").style.display='block';
		
	}
}
function change_h_city(obj)
{
	if (obj.value=="")
	{
		document.getElementById("h_qu").style.display='none';
		document.getElementById("h_jiedao").style.display='none';
		document.getElementById("h_shequ").style.display='none';
		document.getElementById("h_qu").innerHTML=''
		document.getElementById("h_jiedao").innerHTML=''
		document.getElementById("h_shequ").innerHTML=''
	}else{
		var value=obj.value
		var a_shequ=CITY_I[value];
		var s_html='<label><span class="must">*</span> 户籍所在（省/市）：</label><br/><select onchange="change_h_qu(this)" id="Vcl_HArea" name="Vcl_HArea"class="selectpicker" data-style="btn-default"><option value="">请选择</option>'
		for(var i=0;i<a_shequ.length;i++)
		{
			s_html=s_html+'<option value="'+a_shequ[i][0]+'">'+a_shequ[i][1]+'</option>'
		}
		s_html=s_html+'</select>'
		document.getElementById("h_qu").innerHTML=s_html
		document.getElementById("h_qu").style.display='block';
		document.getElementById("h_jiedao").style.display='none';
		document.getElementById("h_shequ").style.display='none';
		document.getElementById("h_jiedao").innerHTML=''
		document.getElementById("h_shequ").innerHTML=''
		$('#h_qu select').selectpicker('refresh')
	}
}
function change_h_qu(obj)
{
	if (obj.value=="110102000000")
	{
		var s_jedao='<label><span class="must">*</span> 户籍所在街道：</label><br/><select id="Vcl_HStreet" name="Vcl_HStreet" onchange="change_h_jiedao(this)" class="selectpicker" data-style="btn-default"><option value="">请选择</option><option value="德胜街道">德胜街道</option><option value="什刹海街道">什刹海街道</option><option value="西长安街街道">西长安街街道</option><option value="大栅栏街道">大栅栏街道</option><option value="天桥街道">天桥街道</option><option value="新街口街道">新街口街道</option><option value="金融街街道">金融街街道</option><option value="椿树街道">椿树街道</option><option value="陶然亭街道">陶然亭街道</option><option value="展览路街道">展览路街道</option><option value="月坛街道">月坛街道</option><option value="广内街道">广内街道</option><option value="牛街街道">牛街街道</option><option value="白纸坊街道">白纸坊街道</option><option value="广外街道">广外街道</option></select>';
		document.getElementById("h_jiedao").style.display='block';
		document.getElementById("h_jiedao").innerHTML=s_jedao;
		document.getElementById("h_shequ").style.display='block';
		document.getElementById("h_shequ").innerHTML='<label><span class="must">*</span> 户籍所在社区：</label><br/><select id="Vcl_HShequ" name="Vcl_HShequ" class="selectpicker" data-style="btn-default"><option value="">请选择</option></select>';
	}else{
		var value=obj.value
		var a_shequ=CITY_II[value];
		if (a_shequ==undefined)
		{
			document.getElementById("h_jiedao").style.display='none';
			document.getElementById("h_shequ").style.display='none';
			document.getElementById("h_jiedao").innerHTML=''
			document.getElementById("h_shequ").innerHTML=''
			return;
		}
		var s_html='<label><span class="must">*</span> 户籍所在（区/县）：</label><br/><select id="Vcl_HStreet" name="Vcl_HStreet" class="selectpicker" data-style="btn-default"><option value="">请选择</option>'
		for(var i=0;i<a_shequ.length;i++)
		{
			s_html=s_html+'<option value="'+a_shequ[i][0]+'">'+a_shequ[i][1]+'</option>'
		}
		s_html=s_html+'</select>'
		document.getElementById("h_jiedao").innerHTML=s_html
		document.getElementById("h_jiedao").style.display='block';
		
		document.getElementById("h_shequ").style.display='none';
		document.getElementById("h_shequ").innerHTML=''
	}
	$('#h_jiedao select').selectpicker('refresh')
	$('#h_shequ select').selectpicker('refresh')
}
function change_c_city(obj)
{
	if (obj.value=="")
	{
		document.getElementById("c_street").innerHTML=''
		document.getElementById("c_street").style.display="block"
		document.getElementById("c_area").innerHTML=''
		document.getElementById("c_area").style.display="block"
		return
	}
	var value=obj.value
	var a_shequ=CITY_I[value];
	var s_html='<label><span class="must">*</span> 出生所在（市/区）</label><br/><select onchange="change_c_area(this)" id="Vcl_CArea" name="Vcl_CArea" class="selectpicker" data-style="btn-default"><option value="">请选择</option>'
	for(var i=0;i<a_shequ.length;i++)
	{
		s_html=s_html+'<option value="'+a_shequ[i][0]+'">'+a_shequ[i][1]+'</option>'
	}
	s_html=s_html+'</select>'
	document.getElementById("c_area").innerHTML=s_html
	document.getElementById("c_area").style.display="block"
	document.getElementById("c_street").innerHTML=''
	document.getElementById("c_street").style.display="none"
	$('#c_area select').selectpicker('refresh')
}
function change_c_area(obj)
{
	if (obj.value=="")
	{
		document.getElementById("c_street").innerHTML=''
		document.getElementById("c_street").style.display="none"
		return
	}
	var value=obj.value
	var a_shequ=CITY_II[value];
	if (a_shequ==undefined)
	{
		document.getElementById("c_street").innerHTML=''
		document.getElementById("c_street").style.display="none"
		return;
	}
	var s_html='<label><span class="must">*</span> 出生所在（区/县）</label><br/><select id="Vcl_CStreet" name="Vcl_CStreet" class="selectpicker" data-style="btn-default"><option value="">请选择</option>'
	for(var i=0;i<a_shequ.length;i++)
	{
		s_html=s_html+'<option value="'+a_shequ[i][0]+'">'+a_shequ[i][1]+'</option>'
	}
	s_html=s_html+'</select>'
	document.getElementById("c_street").innerHTML=s_html
	document.getElementById("c_street").style.display="block"
	$('#c_street select').selectpicker('refresh')
}
function change_h_jiedao(obj)
{
	if (obj.value=="")
	{
		var s_html='<label><span class="must">*</span> 户籍所在社区：</label><br/><select id="Vcl_HShequ" name="Vcl_HShequ" class="selectpicker" data-style="btn-default"><option value="">请选择</option></select>'
		document.getElementById("h_shequ").innerHTML=s_html
		$('#h_shequ select').selectpicker('refresh')
		return
	}
	var value=obj.value
	var a_shequ=JieDao[value];
	a_shequ.sort();
	var s_html='<label><span class="must">*</span> 户籍所在社区：</label><br/><select id="Vcl_HShequ" name="Vcl_HShequ" class="selectpicker" data-style="btn-default"><option value="">请选择</option>'
	for(var i=0;i<a_shequ.length;i++)
	{
		s_html=s_html+'<option value="'+a_shequ[i]+'">'+a_shequ[i]+'</option>'
	}
	s_html=s_html+'</select>'
	document.getElementById("h_shequ").innerHTML=s_html
	$('#h_shequ select').selectpicker('refresh')
}
function change_z_city(obj)
{
	if (obj.value=="北京市")
	{
		document.getElementById("z_qu").style.display='block';
		change_z_qu(document.getElementById("Vcl_ZArea"))
	}else{
		document.getElementById("z_qu").style.display='none';
		document.getElementById("z_jiedao").style.display='none';
		document.getElementById("z_shequ").style.display='none';
	}
}
function change_z_qu(obj)
{
	if (obj.value=="西城区")
	{
		document.getElementById("z_jiedao").style.display='block';
		document.getElementById("z_shequ").style.display='block';
	}else{
		document.getElementById("z_jiedao").style.display='none';
		document.getElementById("z_shequ").style.display='none';
	}
}
function change_z_jiedao(obj)
{
	if (obj.value=="")
	{
		var s_html='<label><span class="must">*</span> 现住址所在社区：</label><br/><select id="Vcl_ZShequ" name="Vcl_ZShequ" class="selectpicker" data-style="btn-default"><option value="">请选择</option></select>'
		document.getElementById("z_shequ").innerHTML=s_html
		$('#z_shequ select').selectpicker('refresh')
		return
	}
	var value=obj.value
	var a_shequ=JieDao[value];
	a_shequ.sort();
	var s_html='<label><span class="must">*</span> 现住址所在社区：</label><br/><select id="Vcl_ZShequ" name="Vcl_ZShequ" class="selectpicker" data-style="btn-default"><option value="">请选择</option>'
	for(var i=0;i<a_shequ.length;i++)
	{
		s_html=s_html+'<option value="'+a_shequ[i]+'">'+a_shequ[i]+'</option>'
	}
	s_html=s_html+'</select>'
	document.getElementById("z_shequ").innerHTML=s_html
	$('#z_shequ select').selectpicker('refresh')
}
function change_z_property(obj)
{
	if (obj.value=="租借借用房产")
	{
		document.getElementById("z_owner").style.display='none';
		document.getElementById("z_guanxi").style.display='none';
	}else{
		document.getElementById("z_owner").style.display='block';
		document.getElementById("z_guanxi").style.display='block';
	}
}
function check_id(){
	//
	var documentType=document.getElementById("Vcl_IdType").value;
	//var documentType=$("#Vcl_IdType").val();
	//如果证件类型为 居民身份证 则校验身份证是否有效
	if(documentType=='居民身份证'){
	 	var studentCardNo = document.getElementById("Vcl_ID").value;
		if(studentCardNo!="" || studentCardNo!=null){
		   if(studentCardNo.length != 15 && studentCardNo.length != 18){
		   		document.getElementById("Vcl_Birthday").value="";
		        dialog_message("幼儿身份证号长度应为15或者18位")
		        return false;
		   }else{
		   		var newCardNoAdd = checkId(studentCardNo.toLowerCase());
				if("身份证输入错误！" == newCardNoAdd){
		        	dialog_message("幼儿身份证输入错误！");
		            return false;
		    	}
		   		var sexValue = (newCardNoAdd.slice(14,17)%2 ? '男' : '女');
		      	var birthdayValue = newCardNoAdd.slice(6,10) +"-"+ newCardNoAdd.slice(10,12) +"-"+ newCardNoAdd.slice(12,14);
			    document.getElementById("Vcl_Birthday").value=birthdayValue;
			    var checkStr = "0123456789xX";
			    var reg = /^[0-9xX]+$/;
				
				
			    if (!reg.test(studentCardNo))
			    {
					dialog_message("幼儿身份证号格式错误，只能由数字或X组成。");   
					return false;  
				}
				document.getElementById("Vcl_Sex").value=sexValue;
		   	}
		 }
	  }else{
	  	var studentCardNo = document.getElementById("Vcl_ID").value.trim();
		if(studentCardNo==""){
	  		dialog_message("基本信息的 [证件号] 不能为空值！");
		  	return false;
	  	}
	  }
	  document.getElementById("Vcl_CheckId").value=studentCardNo;
	  document.getElementById("submit_form_checkid").submit();	
}
function check_id_submit(){
	var documentType=document.getElementById("Vcl_IdType").value;
	//var documentType=$("#Vcl_IdType").val();
	//如果证件类型为 居民身份证 则校验身份证是否有效
	if(documentType=='居民身份证'){
	 	var studentCardNo = document.getElementById("Vcl_ID").value;
		if(studentCardNo!="" || studentCardNo!=null){
		   if(studentCardNo.length != 15 && studentCardNo.length != 18){
		   		document.getElementById("Vcl_Birthday").value="";
		        dialog_message("幼儿身份证号长度应为15或者18位")
		        return false;
		   }else{
		   		var newCardNoAdd = checkId(studentCardNo.toLowerCase());
				if("身份证输入错误！" == newCardNoAdd){
		        	dialog_message("幼儿身份证输入错误！");
		            return false;
		    	}
		   		var sexValue = (newCardNoAdd.slice(14,17)%2 ? '男' : '女');
		      	var birthdayValue = newCardNoAdd.slice(6,10) +"-"+ newCardNoAdd.slice(10,12) +"-"+ newCardNoAdd.slice(12,14);
			    document.getElementById("Vcl_Birthday").value=birthdayValue;
			    var checkStr = "0123456789xX";
			    var reg = /^[0-9xX]+$/;
				
				
			    if (!reg.test(studentCardNo))
			    {
					dialog_message("幼儿身份证号格式错误，只能由数字或X组成。");   
					return false;  
				}
				document.getElementById("Vcl_Sex").value=sexValue;
		   	}
		 }
	  }else{
	  	var studentCardNo = document.getElementById("Vcl_ID").value.trim();
		if(studentCardNo==""){
	  		dialog_message("基本信息的 [证件号] 不能为空值！");
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
function check_1_id(){
	
	var documentType=document.getElementById("Vcl_Jh1IdType").value;
	//var documentType=$("#Vcl_IdType").val();
	//如果证件类型为 居民身份证 则校验身份证是否有效
	if(documentType=='居民身份证'){
	 	var studentCardNo = document.getElementById("Vcl_Jh1ID").value;		
		if(studentCardNo!="" || studentCardNo!=null){
		   if(studentCardNo.length != 15 && studentCardNo.length != 18){
		   		//document.getElementById("Vcl_Birthday").value="";
		        dialog_message("第一法定监护人信息的 [身份证] 长度应为15或者18位")
		        return false;
		   }else{
		   	
		   		var newCardNoAdd = checkId(studentCardNo.toLowerCase());
				if("身份证输入错误！" == newCardNoAdd){
		        	dialog_message("第一法定监护人信息的 [身份证] 输入错误！");
		            return false;
		    	}
		   		var sexValue = (newCardNoAdd.slice(14,17)%2 ? '男' : '女');
		      	var birthdayValue = newCardNoAdd.slice(6,10) +"-"+ newCardNoAdd.slice(10,12) +"-"+ newCardNoAdd.slice(12,14);
			    //document.getElementById("Vcl_Birthday").value=birthdayValue;
			    var checkStr = "0123456789xX";
			    var reg = /^[0-9xX]+$/;

			    if (!reg.test(studentCardNo))
			    {
					dialog_message("第一法定监护人信息的 [身份证] 格式错误，只能由数字或X组成。");   
					return false;  
				}
				//document.getElementById("Vcl_Sex").value=sexValue;
		   	}
		 }
		 
	  }else{
	  	var studentCardNo = document.getElementById("Vcl_ID").value.trim();
		if(studentCardNo==""){
	  		dialog_message("第一法定监护人信息的 [证件号] 不能为空值！");
		  	return false;
	  	}
	  }	 
}
function check_2_id(){
	var documentType=document.getElementById("Vcl_Jh2IdType").value;
	//var documentType=$("#Vcl_IdType").val();
	//如果证件类型为 居民身份证 则校验身份证是否有效
	if(documentType=='居民身份证'){
	 	var studentCardNo = document.getElementById("Vcl_Jh2ID").value;
		if(studentCardNo!="" || studentCardNo!=null){
		   if(studentCardNo.length != 15 && studentCardNo.length != 18){
		   		//document.getElementById("Vcl_Birthday").value="";
		        dialog_message("第二法定监护人信息的 [身份证] 长度应为15或者18位")
		        return false;
		   }else{
		   		var newCardNoAdd = checkId(studentCardNo.toLowerCase());
				if("身份证输入错误！" == newCardNoAdd){
		        	dialog_message("第二法定监护人信息的 [身份证] 输入错误！");
		            return false;
		    	}
		   		var sexValue = (newCardNoAdd.slice(14,17)%2 ? '男' : '女');
		      	var birthdayValue = newCardNoAdd.slice(6,10) +"-"+ newCardNoAdd.slice(10,12) +"-"+ newCardNoAdd.slice(12,14);
			    //document.getElementById("Vcl_Birthday").value=birthdayValue;
			    var checkStr = "0123456789xX";
			    var reg = /^[0-9xX]+$/;
				
				
			    if (!reg.test(studentCardNo))
			    {
					dialog_message("第二法定监护人信息的 [身份证] 格式错误，只能由数字或X组成。");   
					return false;  
				}
				//document.getElementById("Vcl_Sex").value=sexValue;
		   	}
		 }
	  }else{
	  	var studentCardNo = document.getElementById("Vcl_ID").value.trim();
		if(studentCardNo==""){
	  		dialog_message("第二法定监护人信息的 [证件号] 不能为空值！");
		  	return false;
	  	}
	  }	 
}
function stu_modify(modify)
{
	if(modify==false)
	{
		if (document.getElementById("Vcl_Name").value=="")
		{
			dialog_message("基本信息的 [幼儿姓名] 不能为空！")
			document.getElementById("Vcl_Name").focus()
			return
		}
		if (check_id_submit()==false)
		{
			return
		}
	} 
	if (document.getElementById("Vcl_Birthday").value=="")
		{
			dialog_message("基本信息的 [出生日期] 不能为空！")
			document.getElementById("Vcl_Birthday").focus()
			return
		}
	if (document.getElementById("Vcl_Nationality").value == "中国") {
		if (document.getElementById("Vcl_Only").value=="是")
		{
			if (document.getElementById("Vcl_OnlyCode").value=="")
			{ 
				dialog_message("基本信息的 [独生子女证号] 不能为空！")
				document.getElementById("Vcl_OnlyCode").focus()
				return
			}
		}
		if (document.getElementById("Vcl_IsDibao").value == "是") {
			if (document.getElementById("Vcl_DibaoCode").value == "") {
				dialog_message("基本信息的 [低保证号]不能为空 ！")
				document.getElementById("Vcl_DibaoCode").focus()
				return
			}
		}
		if (document.getElementById("Vcl_IsCanji").value == "是") {
			if (document.getElementById("Vcl_CanjiType").value == "") {
				dialog_message("请选择基本信息的 [残疾幼儿类别] ！")
				document.getElementById("Vcl_CanjiType").focus()
				return
			}
			if (document.getElementById("Vcl_CanjiCode").value == "") {
				dialog_message("基本信息的 [幼儿残疾证号] 不能为空！")
				document.getElementById("Vcl_CanjiCode").focus()
				return
			}
		}
	}
	//if (document.getElementById('Vcl_InTime').value=="")
	//{
		//dialog_message("请填写 [入园日期]！");
		//return;
	//}

	if (document.getElementById('Vcl_ClassId').value=="")
	{
		dialog_message("请选择 [入园班级]！");
		return;
	}	
	if (document.getElementById("Vcl_IsYiwang").value=="是")
	{
		if (document.getElementById("Vcl_Illness").value=="")
		{
			dialog_message("请选择基本信息的 [以往病史] ！")
			document.getElementById("Vcl_Illness").focus()
			return
		}
	}
	if (document.getElementById("Vcl_IsShoushu").value=="是")
	{
		if (document.getElementById("Vcl_Shoushu").value=="")
		{
			dialog_message("健康信息的 [手术名称] 不能为空！")
			document.getElementById("Vcl_Shoushu").focus()
			return
		}
	}
	if (document.getElementById("Vcl_IsGuomin").value=="是")
	{
		if (document.getElementById("Vcl_Allergic").value=="")
		{
			dialog_message("健康信息的 [过敏源] 不能为空！")
			document.getElementById("Vcl_Allergic").focus()
			return
		}
	}
	if (document.getElementById("Vcl_IsYichuan").value=="是")
	{
		if (document.getElementById("Vcl_Qitabingshi").value=="")
		{
			dialog_message("健康信息的 [家族遗传病史名称] 不能为空！")
			document.getElementById("Vcl_Qitabingshi").focus()
			return
		}
	}
				
	if (document.getElementById("Vcl_Nationality").value == "中国") {
		//判断出生地
		if (document.getElementById("Vcl_CCity").value == "") {
			dialog_message("请选择户籍信息的 [出生所在（省/市）] ！")
			document.getElementById("Vcl_CCity").focus()
			return
		}
		if (document.getElementById("c_area").innerHTML != "") {
			if (document.getElementById("Vcl_CArea").value == "") {
				dialog_message("请选择户籍信息的 [出生所在（市/区）] ！")
				document.getElementById("Vcl_CArea").focus()
				return
			}
		}
		if (document.getElementById("c_street").innerHTML != "") {
			if (document.getElementById("Vcl_CStreet").value == "") {
				dialog_message("请选择户籍信息的 [出生所在（区/县）] ！")
				document.getElementById("Vcl_CStreet").focus()
				return
			}
		}
		if (document.getElementById("Vcl_HCity").value == "")
		{
			dialog_message("请选择户籍信息的 [户籍所在（省/市）] ！")
			document.getElementById("Vcl_HStreet").focus()
			return
		}
		if (document.getElementById("h_qu").innerHTML != "") {
			if (document.getElementById("Vcl_HArea").value == "") {
				dialog_message("请选择户籍信息的 [户籍所在（市/区）] ！")
				document.getElementById("Vcl_HArea").focus()
				return
			}
		}
		if (document.getElementById("h_jiedao").innerHTML != "") {
			if (document.getElementById("Vcl_HStreet").value == "") {
				if (document.getElementById("Vcl_HArea").value == "110102000000" && document.getElementById("Vcl_HCity").value == "110000000000") 
				{
					dialog_message("请选择户籍信息的 [户籍所在街道] ！")
				}
				else
				{
					dialog_message("请选择户籍信息的 [户籍所在（区/县）] ！")
				}
				document.getElementById("Vcl_HStreet").focus()
				return
			}
		}	
		if (document.getElementById("h_shequ").innerHTML != "") {
			if (document.getElementById("Vcl_HShequ").value == "") {
				dialog_message("请选择户籍信息的 [户籍所在社区] ！")
				document.getElementById("Vcl_HShequ").focus()
				return
			}
		}
		if (document.getElementById("Vcl_HAdd").value == "") {
			dialog_message("户籍信息的 [户籍详细地址] 不能为空！")
			document.getElementById("Vcl_HAdd").focus()
			return
		}
		if (document.getElementById("Vcl_HOwner").value == "") {
			dialog_message("户籍信息的 [户主姓名] 不能为空！")
			document.getElementById("Vcl_HOwner").focus()
			return
		}
	}
	
	if(document.getElementById("Vcl_ZSame").value=="否")
	{
		if (document.getElementById("Vcl_ZCity").value=="北京市" && document.getElementById("Vcl_ZArea").value=="西城区")
		{
			if (document.getElementById("Vcl_ZStreet").value=="")
			{
				dialog_message("请选择现住址信息的 [现住址所在街道]！")
				document.getElementById("Vcl_ZStreet").focus()
				return
			}
			if (document.getElementById("Vcl_ZShequ").value=="")
			{
				dialog_message("请选择现住址信息的 [现住址所在社区]！")
				document.getElementById("Vcl_ZShequ").focus()
				return
			}
		}
		if (document.getElementById("Vcl_ZAdd").value=="")
		{
			dialog_message("现住址信息的 [现住址详细地址] 不能为空！")
			document.getElementById("Vcl_ZAdd").focus()
			return
		}
	}
	if (document.getElementById("Vcl_ZOwner").value=="" && document.getElementById("Vcl_ZProperty").value=="直系亲属房产")
	{
		dialog_message("现住址信息的 [产权人姓名] 不能为空！")
		document.getElementById("Vcl_ZOwner").focus()
		return
	}
	if (document.getElementById("Vcl_Jh1Name").value=="")
	{
		dialog_message("第一法定监护人信息的 [姓名] 不能为空！")
		document.getElementById("Vcl_Jh1Name").focus()
		return
	}
	
	if (check_1_id()==false)
	{
		//document.getElementById("Vcl_Jh1ID").focus()
		return
	}
	
	if (document.getElementById("Vcl_Jh1Job").value=="")
	{
		dialog_message("请选择第一法定监护人信息的 [职业状况] ！")
		document.getElementById("Vcl_Jh1Job").focus()
		return
	}
	if (document.getElementById("Vcl_Jh1Danwei").value=="")
	{
		dialog_message("第一法定监护人信息的 [工作单位全称] 不能为空！")
		document.getElementById("Vcl_Jh1Danwei").focus()
		return
	}
	if (document.getElementById("Vcl_Jh1Jiaoyu").value=="")
	{
		dialog_message("请选择第一法定监护人信息的 [教育程度] ！")
		document.getElementById("Vcl_Jh1Jiaoyu").focus()
		return
	}
	if (document.getElementById("Vcl_Jh1Phone").value=="")
	{
		dialog_message("第一法定监护人信息的 [联系电话] 不能为空！")
		document.getElementById("Vcl_Jh1Phone").focus()
		return
	}
	
	if (document.getElementById("Vcl_Jh1Phone").value=="")
	{
		dialog_message("第一法定监护人信息的 [联系电话] 不能为空！")
		document.getElementById("Vcl_Jh1Phone").focus()
		return
	}	
	
	if (document.getElementById("Vcl_Jh1IsCanji").value=="是")
	{
		if (document.getElementById("Vcl_Jh1CanjiCode").value=="")
		{
			//dialog_message("第一法定监护人信息的 [残疾证号] 不能为空！")
			//document.getElementById("Vcl_Jh1CanjiCode").focus()
			//return
		}
	}
	
	if (document.getElementById("Vcl_Jh2Name").value != "") {//如果第二法定监护人姓名不是空，那么
		if (document.getElementById("Vcl_Jh2Connection").value == "") {
			dialog_message("请选择第二法定监护人信息的 [关系] ！")
			document.getElementById("Vcl_Jh2Connection").focus()
			return
		}
		if (document.getElementById("Vcl_Jh2Name").value == "") {
			dialog_message("第二法定监护人信息的 [姓名] 不能为空！")
			document.getElementById("Vcl_Jh2Name").focus()
			return
		}
		if (document.getElementById("Vcl_Jh2IdType").value == "") {
			dialog_message("请选择第二法定监护人信息的 [证件类型] ！")
			document.getElementById("Vcl_Jh2IdType").focus()
			return
		}
		if (check_2_id() == false) {
			//document.getElementById("Vcl_Jh2ID").focus()
			return
		}
		if (document.getElementById("Vcl_Jh2IsZhixi").value == "") {
			dialog_message("请选择第二法定监护人信息的 [是否是直系亲属] ！")
			document.getElementById("Vcl_Jh2IsZhixi").focus()
			return
		}
		if (document.getElementById("Vcl_Jh2Job").value == "") {
			dialog_message("请选择第二法定监护人信息的 [职业状况] ！")
			document.getElementById("Vcl_Jh2Job").focus()
			return
		}
		if (document.getElementById("Vcl_Jh2Danwei").value=="")
		{
			dialog_message("第二法定监护人信息的 [工作单位全称] 不能为空！")
			document.getElementById("Vcl_Jh2Danwei").focus()
			return
		}
		if (document.getElementById("Vcl_Jh2Jiaoyu").value == "") {
			dialog_message("请选择第二法定监护人信息的 [教育程度] ！")
			document.getElementById("Vcl_Jh2Jiaoyu").focus()
			return
		}
		if (document.getElementById("Vcl_Jh2Phone").value == "") {
			dialog_message("第二法定监护人信息的 [联系电话] 不能为空！")
			document.getElementById("Vcl_Jh2Phone").focus()
			return
		}
		if (document.getElementById("Vcl_Jh2IsCanji").value == "") {
			dialog_message("请选择第二法定监护人信息的 [是否残疾] ！")
			document.getElementById("Vcl_Jh2IsCanji").focus()
			return
		}
		if (document.getElementById("Vcl_Jh2IsCanji").value == "是") {
			if (document.getElementById("Vcl_Jh2CanjiCode").value == "") {
			}
		}
	}
	if (document.getElementById("Vcl_JianhuName").value!="")
	{
		if (document.getElementById("Vcl_JianhuConnection").value=="")
		{
			dialog_message("请选择其他监护人信息的 [关系] ！")
			document.getElementById("Vcl_JianhuConnection").focus()
			return
		}
		if (document.getElementById("Vcl_JianhuName").value=="")
		{
			dialog_message("其他监护人信息的 [姓名] 不能为空！")
			document.getElementById("Vcl_JianhuName").focus()
			return
		}
		if (document.getElementById("Vcl_JianhuPhone").value=="")
		{
			dialog_message("其他监护人信息的 [联系电话] 不能为空！")
			document.getElementById("Vcl_JianhuPhone").focus()
			return
		}
	}
	if (modify)
	{
		dialog_confirm("修改信息后会进入审核，是否继续？",function(){
			loading_show();
			$('#submit_form').submit();
		})
	}else{
		loading_show();
		$('#submit_form').submit();
	}
}
function audit_student()
{
	//对于有重复标记的数据审核，给出提示，需要到教委去重。
	if (document.getElementById("Vcl_Question").value=="1")
	{
		dialog_confirm("该幼儿信息和其他幼儿园存在重复，批准后将由学前科审核，是否继续？",function (){parent.parent.Common_OpenLoading();document.getElementById('submit_form_2').submit();});
	}else{
		dialog_confirm("真的要批准这个幼儿的信息吗？",function (){parent.parent.Common_OpenLoading();document.getElementById('submit_form_2').submit();});
	}
    
}
var JieDao=new Array();
JieDao['德胜街道']=new Array("石油社区","六铺炕水电社区","六铺炕煤炭社区","安德路南社区","安德路北社区","德外大街东社区","德外大街西社区","人定湖西里社区","新外大街南社区","新外大街北社区","德胜里社区","新明家园社区","新康社区","新风中直社区","北广社区","马甸社区","双旗杆社区","裕中西里社区","裕中东里社区","黄寺大街西社区","黄寺大街24号社区","阳光丽景社区","新风街1号社区");
JieDao['大栅栏街道']=new Array("百顺社区","大安澜营社区","大栅栏西街社区","煤市街东社区","前门西河沿社区","三井社区","石头社区","铁树斜街社区","延寿街社区");
JieDao['什刹海街道']=new Array("西四北社区","柳荫街社区","大红罗社区","护国寺社区","簸箩仓社区","前铁社区","前海北沿社区","景山社区","前海东沿社区","松树街社区","西巷社区","西什库社区","兴华社区","鼓西社区","西安门社区","米粮库社区","后海社区","后海西沿社区","四环社区","爱民街社区","西海社区","苇坑社区","旧鼓楼社区","双寺社区","白米社区");
JieDao['西长安街街道']=new Array("义达里社区","和平门社区","西单北社区","六部口社区","光明社区","未英社区","北新华街社区","南北长街社区","府右街南社区","太仆寺街社区","西交民巷社区","西黄城根南街社区","钟声社区");
JieDao['天桥街道']=new Array("虎坊路社区","留学路社区","禄长街社区","太平街社区","天桥小区社区","先农坛社区","香厂路社区","永安路社区");
JieDao['新街口街道']=new Array("西四北头条社区","西四北三条社区","西四北六条社区","育德社区","冠英园社区","玉桃园社区","前公用社区","官园社区","大觉社区","宫门口社区","南小街社区","西里一区社区","北顺社区","半壁街社区","西里二区社区","富国里社区","北草厂社区","西里三区社区","安平巷社区","中直社区","西里四区社区");
JieDao['椿树街道']=new Array("椿树园社区","红线社区","宣武门外东大街社区","梁家园社区","琉璃厂西街社区","四川营社区","香炉营社区");
JieDao['陶然亭街道']=new Array("福州馆社区","南华里社区","黑窑厂社区","红土店社区","龙泉社区","米市社区","新兴里社区","粉房琉璃街社区");
JieDao['展览路街道']=new Array("德宝社区","露园社区","朝阳庵社区","新华南社区","文兴街社区","黄瓜园社区","团结社区","北营房西里社区","榆树馆社区","北营房东里社区","新华东社区","阜外西社区","新华里社区","洪茂沟社区","车公庄社区","阜外东社区","百万庄西社区","南营房社区","百万庄东社区","万明园社区","三塔社区","滨河社区");
JieDao['月坛街道']=new Array("社会路社区","铁道部住宅区第三社区","月坛社区","公安住宅区社区","三里河社区","南沙沟社区","铁道部住宅区第二·一社区","白云观社区","二炮住宅区社区","复兴门北大街社区","全国总工会住宅区社区","三里河三区第三社区","三里河三区第一社区","三里河二区社区","广电总局住宅区第一社区","西便门社区","真武庙社区","铁道部住宅区第二·二社区","木樨地社区","铁道部住宅区第四社区","广电总局住宅区第二社区","复兴门外社区","南礼士路社区","三里河一区社区","汽车局河南社区","汽车局河北社区");
JieDao['广内街道']=new Array("西便门西里社区","西便门东里社区","西便门内社区","长椿街西社区","槐柏树街北里社区","槐柏树街南里社区","核桃园社区","报国寺社区","长椿里社区","宣武门西大街社区","三庙街社区","校场社区","长椿街社区","康乐里社区","上斜街社区","大街东社区","广安东里社区","老墙根社区");
JieDao['牛街街道']=new Array("牛街西里一区社区","牛街西里二区社区","牛街东里社区","南线阁社区","枫桦社区","菜园北里社区","钢院社区","法源寺社区","春风社区","白广路社区")
JieDao['白纸坊街道']=new Array("建功北里社区","右内后身社区","新安中里社区","右北大街社区","新安南里社区","平原里社区","建功南里社区","万博苑社区","清芷园社区","光源里社区","双槐里社区","樱桃园社区","菜园街社区","崇效寺社区","右内西街社区","自新路社区","半步桥社区","里仁街社区");
JieDao['广外街道']=new Array("鸭子桥社区","青年湖社区","椿树馆社区","白菜湾社区","车站东街社区","手帕口南街社区","朗琴园社区","红居街社区","红居南街社区","车站西街15号院社区","车站西街社区","乐城社区","红莲北里社区","红莲中里社区","红莲南里社区","三义东里社区","三义里社区","马连道中里社区","马连道社区","湾子街社区","依莲轩社区","小马厂社区","手帕口北街社区","天宁寺北里社区","天宁寺二热社区","天宁寺南里社区","莲花河社区","荣丰社区","蝶翠华庭社区","中新佳园社区");
JieDao['金融街街道']=new Array("宏汇园社区","文昌社区","受水河社区","丰汇园社区","大院社区","民康社区","丰融园社区","手帕社区","京畿道社区","二龙路社区","音乐学院社区","砖塔社区","新文化街社区","新华社社区","西太平街社区","丰盛社区","教育部社区","温家街社区","东太平街社区");
