function change_idtype(obj)
{
	return;
	if (obj.value=="居民身份证")
	{
		$('#Vcl_Birthday').attr('readonly','readonly')
	}else{
		$('#Vcl_Birthday').attr('readonly','')
	}
}
function change_nationality(obj)
{
	if (obj.value=="中国")
	{
		document.getElementById("nation").style.display='';
		try {
			document.getElementById("other_base").style.display='';
		} 
		catch (e) {
		}		
		document.getElementById("h_info").style.display='';
		document.getElementById("is_same").style.display='';
	}else{
		document.getElementById("nation").style.display='none';
		try {
		}catch(e){
			document.getElementById("other_base").style.display='none';
		}		
		document.getElementById("h_info").style.display='none';
		document.getElementById("Vcl_ZSame").value='否';
		change_address(document.getElementById("Vcl_ZSame"))
		document.getElementById("is_same").style.display='none';
	}
}
function change_address(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("address").style.display='none';
	}else{
		document.getElementById("address").style.display='';
		
	}
}
function change_yiwang(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("yiwang").style.display='';
	}else{
		document.getElementById("yiwang").style.display='none';
	}
}
function change_guomin(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("guomin").style.display='';
	}else{
		document.getElementById("guomin").style.display='none';
	}
}
function change_h_city(obj)
{
	if (obj.value=="")
	{
		document.getElementById("h_qu").style.display='none';
		document.getElementById("h_jiedao").style.display='none';
		document.getElementById("h_shequ").style.display='none';
		$('#Vcl_HArea').html('');
	}else{
		var value=obj.value
		var a_shequ=CITY_I[value];
		var s_html=''
		for(var i=0;i<a_shequ.length;i++)
		{
			s_html=s_html+'<option value="'+a_shequ[i][0]+'">'+a_shequ[i][1]+'</option>'
		}
		$('#Vcl_HArea').html(s_html);
		document.getElementById("h_qu").style.display='';
		document.getElementById("h_jiedao").style.display='none';
		document.getElementById("h_shequ").style.display='none';
	}
}
function change_h_qu(obj)
{
	try{
		if (obj.value=="110102000000")
		{
			var s_jedao='<option value="">必选</option><option value="德胜街道">德胜街道</option><option value="什刹海街道">什刹海街道</option><option value="西长安街街道">西长安街街道</option><option value="大栅栏街道">大栅栏街道</option><option value="天桥街道">天桥街道</option><option value="新街口街道">新街口街道</option><option value="金融街街道">金融街街道</option><option value="椿树街道">椿树街道</option><option value="陶然亭街道">陶然亭街道</option><option value="展览路街道">展览路街道</option><option value="月坛街道">月坛街道</option><option value="广内街道">广内街道</option><option value="牛街街道">牛街街道</option><option value="白纸坊街道">白纸坊街道</option><option value="广外街道">广外街道</option>';
			document.getElementById("h_jiedao").style.display='';
			
			$('#Vcl_HStreet').html(s_jedao);
			document.getElementById("h_shequ").style.display='';
			$('#Vcl_HShequ').html('<option value="">必选</option>');
		}else{
			var value=obj.value
			var a_shequ=CITY_II[value];
			if (a_shequ==undefined)
			{
				document.getElementById("h_jiedao").style.display='none';
				document.getElementById("h_shequ").style.display='none';
				$('#Vcl_HStreet').html('');
				$('#Vcl_HShequ').html('');
				return;
			}
			var s_html=''
			for(var i=0;i<a_shequ.length;i++)
			{
				s_html=s_html+'<option value="'+a_shequ[i][0]+'">'+a_shequ[i][1]+'</option>'
			}
			$('#Vcl_HStreet').html(s_html);
			document.getElementById("h_jiedao").style.display='';
			document.getElementById("h_shequ").style.display='none';
			$('#Vcl_HShequ').html('');
		}
	}catch(e){};
}
function change_h_jiedao(obj)
{
	if (obj.value=="")
	{
		var s_html='<option value="">必选</option>'
		$('#Vcl_HShequ').html(s_html);
		return
	}
	var value=obj.value
	var a_shequ=JieDao[value];
	a_shequ.sort();
	var s_html='<option value="">必选</option>'
	for(var i=0;i<a_shequ.length;i++)
	{
		s_html=s_html+'<option value="'+a_shequ[i]+'">'+a_shequ[i]+'</option>'
	}
	$('#Vcl_HShequ').html(s_html);
}
function change_address(obj)
{
	if (obj.value=="是")
	{
		document.getElementById("z_city").style.display='none';
		document.getElementById("z_qu").style.display='none';
		document.getElementById("z_jiedao").style.display='none';
		document.getElementById("z_shequ").style.display='none';
		document.getElementById("z_address").style.display='none';
	}else{
		document.getElementById("z_city").style.display='';
		document.getElementById("z_qu").style.display='';
		document.getElementById("z_jiedao").style.display='';
		document.getElementById("z_shequ").style.display='';
		document.getElementById("z_address").style.display='';
		
	}
}
function change_z_city(obj)
{
	if (obj.value=="北京市")
	{
		document.getElementById("z_qu").style.display='';
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
		document.getElementById("z_jiedao").style.display='';
		document.getElementById("z_shequ").style.display='';
	}else{
		document.getElementById("z_jiedao").style.display='none';
		document.getElementById("z_shequ").style.display='none';
	}
}
function change_z_jiedao(obj)
{
	if (obj.value=="")
	{
		var s_html='<option value="">必选</option>'
		$('#Vcl_ZShequ').html(s_html);
		return
	}
	var value=obj.value
	var a_shequ=JieDao[value];
	a_shequ.sort();
	var s_html='<option value="">必选</option>'
	for(var i=0;i<a_shequ.length;i++)
	{
		s_html=s_html+'<option value="'+a_shequ[i]+'">'+a_shequ[i]+'</option>'
	}
	$('#Vcl_ZShequ').html(s_html);
}
function change_z_property(obj)
{
	if (obj.value=="租借借用房产")
	{
		document.getElementById("z_owner").style.display='none';
		document.getElementById("z_guanxi").style.display='none';
	}else{
		document.getElementById("z_owner").style.display='';
		document.getElementById("z_guanxi").style.display='';
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
		        Dialog_Message("幼儿身份证号长度应为15或者18位")
		        return false;
		   }else{
		   		var newCardNoAdd = checkId(studentCardNo.toLowerCase());
				if("身份证输入错误！" == newCardNoAdd){
		        	Dialog_Message("幼儿身份证输入错误！");
		            return false;
		    	}
		   		var sexValue = (newCardNoAdd.slice(14,17)%2 ? '男' : '女');
		      	var birthdayValue = newCardNoAdd.slice(6,10) +"-"+ newCardNoAdd.slice(10,12) +"-"+ newCardNoAdd.slice(12,14);
			    document.getElementById("Vcl_Birthday").value=birthdayValue;
			    var checkStr = "0123456789xX";
			    var reg = /^[0-9xX]+$/;
				
				
			    if (!reg.test(studentCardNo))
			    {
					Dialog_Message("幼儿身份证号格式错误，只能由数字或X组成。");   
					return false;  
				}
				document.getElementById("Vcl_Sex").value=sexValue;
		   	}
		 }
	  }else{
	  	var studentCardNo = document.getElementById("Vcl_ID").value;
		if(studentCardNo==""){
	  		Dialog_Message("基本信息的 [证件号] 不能为空值！");
		  	return false;
	  	}
	  }
	  document.getElementById("Vcl_CheckId").value=studentCardNo;
	  document.getElementById("submit_form_checkid").submit();
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
function submit_signin(modify)
{
	if (document.getElementById("Vcl_Name").value=="")
	{
		Dialog_Message("基本信息的 [幼儿姓名] 不能为空！")
		document.getElementById("Vcl_Name").focus()
		return
	}
	if (document.getElementById("Vcl_Birthday").value=="")
	{
		Dialog_Message("基本信息的 [出生日期] 不能为空！")
		document.getElementById("Vcl_Birthday").focus()
		return
	}
	if (modify == 'false') {
		if (check_id() == false) {
			document.getElementById("Vcl_ID").focus()
			return
		}
	}
	if (document.getElementById("Vcl_HospitalName").value=="")
	{
		Dialog_Message("健康信息的 [预防接种医院] 不能为空！")
		document.getElementById("Vcl_HospitalName").focus()
		return
	}
	if (document.getElementById("Vcl_IsYiwang").value=="是")
	{
		if (document.getElementById("Vcl_Illness").value=="")
		{
			Dialog_Message("请选择健康信息的 [以往病史] ！")
			document.getElementById("Vcl_Illness").focus()
			return
		}
	}
	if (document.getElementById("Vcl_IsGuomin").value=="是")
	{
		if (document.getElementById("Vcl_Allergic").value=="")
		{
			Dialog_Message("健康信息的 [过敏源] 不能为空！")
			document.getElementById("Vcl_Allergic").focus()
			return
		}
	}	
	if (document.getElementById("Vcl_Nationality").value == "中国") {
		if (document.getElementById("Vcl_HCity").value == "")
		{
			Dialog_Message("请选择户籍信息的 [户籍所在（省/市）] ！")
			document.getElementById("Vcl_HStreet").focus()
			return
		}
		if (document.getElementById("h_qu").innerHTML != "") {
			if (document.getElementById("Vcl_HArea").value == "") {
				Dialog_Message("请选择户籍信息的 [户籍所在（市/区）] ！")
				document.getElementById("Vcl_HArea").focus()
				return
			}
		}
		if ($('#h_jiedao').is(":hidden")==false) {
			if (document.getElementById("Vcl_HStreet").value == "") {
				if (document.getElementById("Vcl_HArea").value == "110102000000" && document.getElementById("Vcl_HCity").value == "110000000000") 
				{
					Dialog_Message("请选择户籍信息的 [户籍所在街道] ！")
				}
				else
				{
					Dialog_Message("请选择户籍信息的 [户籍所在（区/县）] ！")
				}
				document.getElementById("Vcl_HStreet").focus()
				return
			}
		}	
		if ($('#h_shequ').is(":hidden")==false) {
			if (document.getElementById("Vcl_HShequ").value == "") {
				Dialog_Message("请选择户籍信息的 [户籍所在社区] ！")
				document.getElementById("Vcl_HShequ").focus()
				return 
			}
		}
		if (document.getElementById("Vcl_HAdd").value == "") {
			Dialog_Message("户籍信息的 [户籍详细地址] 不能为空！")
			document.getElementById("Vcl_HAdd").focus()
			return
		}
	}
	if(document.getElementById("Vcl_ZSame").value=="否")
	{
		if (document.getElementById("Vcl_ZCity").value=="北京市" && document.getElementById("Vcl_ZArea").value=="西城区")
		{
			if (document.getElementById("Vcl_ZStreet").value=="")
			{
				Dialog_Message("请选择现住址信息的 [现住址所在街道]！")
				document.getElementById("Vcl_ZStreet").focus()
				return
			}
			if (document.getElementById("Vcl_ZShequ").value=="")
			{
				Dialog_Message("请选择现住址信息的 [现住址所在社区]！")
				document.getElementById("Vcl_ZShequ").focus()
				return
			}
		}
		if (document.getElementById("Vcl_ZAdd").value=="")
		{
			Dialog_Message("现住址信息的 [现住址详细地址] 不能为空！")
			document.getElementById("Vcl_ZAdd").focus()
			return
		}
	}
	if (document.getElementById("Vcl_ZOwner").value=="" && document.getElementById("Vcl_ZProperty").value=="直系亲属房产")
	{
		window.alert("现住址信息的 [产权人姓名] 不能为空！")
		document.getElementById("Vcl_ZOwner").focus()
		return
	}
	if (document.getElementById("Vcl_Jh1Name").value=="")
	{
		Dialog_Message("第一法定监护人信息的 [姓名] 不能为空！")
		document.getElementById("Vcl_Jh1Name").focus()
		return
	}	
	if (document.getElementById("Vcl_Jh1Jiaoyu").value=="")
	{
		Dialog_Message("请选择第一法定监护人信息的 [教育程度] ！")
		document.getElementById("Vcl_Jh1Jiaoyu").focus()
		return
	}
	if (document.getElementById("Vcl_Jh1Danwei").value=="")
	{
		Dialog_Message("第一法定监护人信息的 [工作单位] 不能为空！")
		document.getElementById("Vcl_Jh1Danwei").focus()
		return
	}			
	if (document.getElementById("Vcl_Jh2Name").value != "") {//如果第二法定监护人姓名不是空，那么
		if (document.getElementById("Vcl_Jh2Connection").value == "") {
			Dialog_Message("请选择第二法定监护人信息的 [关系] ！")
			document.getElementById("Vcl_Jh2Connection").focus()
			return
		}			
		if (document.getElementById("Vcl_Jh2Jiaoyu").value == "") {
			Dialog_Message("请选择第二法定监护人信息的 [教育程度] ！")
			document.getElementById("Vcl_Jh2Jiaoyu").focus()
			return
		}
		if (document.getElementById("Vcl_Jh2Danwei").value=="")
		{
			Dialog_Message("第二法定监护人信息的 [工作单位] 不能为空！")
			document.getElementById("Vcl_Jh2Danwei").focus()
			return
		}
	}	
	if (document.getElementById("Vcl_Jh1Phone").value=="")
	{
		Dialog_Message("报名联系方式的 [监护人手机号] 不能为空！")
		document.getElementById("Vcl_Jh1Phone").focus()
		return
	}
	Common_OpenLoading();
	document.getElementById("submit_form").submit();	 
}
function vcl_disabled(obj)
{
	$(obj).attr({"disabled":"disabled"});
	//$(obj).css({"color":"#ffffff"});
}
CITY_I=new Array();CITY_II=new Array();CITY_I["110000000000"]=new Array(new Array("110101000000","东城区"),new Array("110102000000","西城区"),new Array("110105000000","朝阳区"),new Array("110106000000","丰台区"),new Array("110107000000","石景山区"),new Array("110108000000","海淀区"),new Array("110109000000","门头沟区"),new Array("110111000000","房山区"),new Array("110112000000","通州区"),new Array("110113000000","顺义区"),new Array("110114000000","昌平区"),new Array("110115000000","大兴区"),new Array("110116000000","怀柔区"),new Array("110117000000","平谷区"),new Array("110228000000","密云县"),new Array("110229000000","延庆县"),new Array("11A1A1000000","燕山区"));
CITY_I["120000000000"]=new Array(new Array("120101000000","和平区"),new Array("120102000000","河东区"),new Array("120103000000","河西区"),new Array("120104000000","南开区"),new Array("120105000000","河北区"),new Array("120106000000","红桥区"),new Array("120110000000","东丽区"),new Array("120111000000","西青区"),new Array("120112000000","津南区"),new Array("120113000000","北辰区"),new Array("120114000000","武清区"),new Array("120115000000","宝坻区"),new Array("120116000000","滨海新区"),new Array("120221000000","宁河县"),new Array("120223000000","静海县"),new Array("120225000000","蓟县"));
CITY_I["130000000000"]=new Array(new Array("130100000000","石家庄市"),new Array("130200000000","唐山市"),new Array("130300000000","秦皇岛市"),new Array("130400000000","邯郸市"),new Array("130500000000","邢台市"),new Array("130600000000","保定市"),new Array("130700000000","张家口市"),new Array("130800000000","承德市"),new Array("130900000000","沧州市"),new Array("131000000000","廊坊市"),new Array("131100000000","衡水市"));
CITY_II["130100000000"]=new Array(new Array("130102000000","长安区"),new Array("130103000000","桥东区"),new Array("130104000000","桥西区"),new Array("130105000000","新华区"),new Array("130107000000","井陉矿区"),new Array("130108000000","裕华区"),new Array("130121000000","井陉县"),new Array("130123000000","正定县"),new Array("130124000000","栾城县"),new Array("130125000000","行唐县"),new Array("130126000000","灵寿县"),new Array("130127000000","高邑县"),new Array("130128000000","深泽县"),new Array("130129000000","赞皇县"),new Array("130130000000","无极县"),new Array("130131000000","平山县"),new Array("130132000000","元氏县"),new Array("130133000000","赵县"),new Array("130181000000","辛集市"),new Array("130182000000","藁城市"),new Array("130183000000","晋州市"),new Array("130184000000","新乐市"),new Array("130185000000","鹿泉市"),new Array("1301A2000000","高新区"));
CITY_II["130200000000"]=new Array(new Array("130202000000","路南区"),new Array("130203000000","路北区"),new Array("130204000000","古冶区"),new Array("130205000000","开平区"),new Array("130207000000","丰南区"),new Array("130208000000","丰润区"),new Array("130209000000","曹妃甸区"),new Array("130223000000","滦县"),new Array("130224000000","滦南县"),new Array("130225000000","乐亭县"),new Array("130227000000","迁西县"),new Array("130229000000","玉田县"),new Array("130281000000","遵化市"),new Array("130283000000","迁安市"),new Array("1302A2000000","芦台经济开发区"),new Array("1302A3000000","汉沽管理区"),new Array("1302A4000000","高新区"),new Array("1302A6000000","唐山南堡开发区"),new Array("1302A7000000","海港区"));
CITY_II["130300000000"]=new Array(new Array("130302000000","海港区"),new Array("130303000000","山海关区"),new Array("130304000000","北戴河区"),new Array("130321000000","青龙满族自治县"),new Array("130322000000","昌黎县"),new Array("130323000000","抚宁县"),new Array("130324000000","卢龙县"),new Array("1303A2000000","开发区"),new Array("1303A3000000","秦北新教育局"));
CITY_II["130400000000"]=new Array(new Array("130402000000","邯山区"),new Array("130403000000","丛台区"),new Array("130404000000","复兴区"),new Array("130406000000","峰峰矿区"),new Array("130421000000","邯郸县"),new Array("130423000000","临漳县"),new Array("130424000000","成安县"),new Array("130425000000","大名县"),new Array("130426000000","涉县"),new Array("130427000000","磁县"),new Array("130428000000","肥乡县"),new Array("130429000000","永年县"),new Array("130430000000","邱县"),new Array("130431000000","鸡泽县"),new Array("130432000000","广平县"),new Array("130433000000","馆陶县"),new Array("130434000000","魏县"),new Array("130435000000","曲周县"),new Array("130481000000","武安市"),new Array("1304A2000000","开发区"),new Array("1304A3000000","马头开发区"));
CITY_II["130500000000"]=new Array(new Array("130502000000","桥东区"),new Array("130503000000","桥西区"),new Array("130521000000","邢台县"),new Array("130522000000","临城县"),new Array("130523000000","内丘县"),new Array("130524000000","柏乡县"),new Array("130525000000","隆尧县"),new Array("130526000000","任县"),new Array("130527000000","南和县"),new Array("130528000000","宁晋县"),new Array("130529000000","巨鹿县"),new Array("130530000000","新河县"),new Array("130531000000","广宗县"),new Array("130532000000","平乡县"),new Array("130533000000","威县"),new Array("130534000000","清河县"),new Array("130535000000","临西县"),new Array("130581000000","南宫市"),new Array("130582000000","沙河市"),new Array("1305A2000000","开发区社发局"),new Array("1305A3000000","大曹庄管理区教育局"));
CITY_II["130600000000"]=new Array(new Array("130602000000","新市区"),new Array("130603000000","北市区"),new Array("130604000000","南市区"),new Array("130621000000","满城县"),new Array("130622000000","清苑县"),new Array("130623000000","涞水县"),new Array("130624000000","阜平县"),new Array("130625000000","徐水县"),new Array("130626000000","定兴县"),new Array("130627000000","唐县"),new Array("130628000000","高阳县"),new Array("130629000000","容城县"),new Array("130630000000","涞源县"),new Array("130631000000","望都县"),new Array("130632000000","安新县"),new Array("130633000000","易县"),new Array("130634000000","曲阳县"),new Array("130635000000","蠡县"),new Array("130636000000","顺平县"),new Array("130637000000","博野县"),new Array("130638000000","雄县"),new Array("130681000000","涿州市"),new Array("130682000000","定州市"),new Array("130683000000","安国市"),new Array("130684000000","高碑店市"),new Array("1306A3000000","高新区"),new Array("1306A4000000","白沟新城"));
CITY_II["130700000000"]=new Array(new Array("130702000000","桥东区"),new Array("130703000000","桥西区"),new Array("130705000000","宣化区"),new Array("130706000000","下花园区"),new Array("130721000000","宣化县"),new Array("130722000000","张北县"),new Array("130723000000","康保县"),new Array("130724000000","沽源县"),new Array("130725000000","尚义县"),new Array("130726000000","蔚县"),new Array("130727000000","阳原县"),new Array("130728000000","怀安县"),new Array("130729000000","万全县"),new Array("130730000000","怀来县"),new Array("130731000000","涿鹿县"),new Array("130732000000","赤城县"),new Array("130733000000","崇礼县"),new Array("1307A2000000","察北区"),new Array("1307A3000000","塞北区"),new Array("1307A4000000","高新区"));
CITY_II["130800000000"]=new Array(new Array("130802000000","双桥区"),new Array("130803000000","双滦区"),new Array("130804000000","鹰手营子矿区"),new Array("130821000000","承德县"),new Array("130822000000","兴隆县"),new Array("130823000000","平泉县"),new Array("130824000000","滦平县"),new Array("130825000000","隆化县"),new Array("130826000000","丰宁满族自治县"),new Array("130827000000","宽城满族自治县"),new Array("130828000000","围场满族蒙古族自治县"),new Array("1308A2000000","承德高新区"));
CITY_II["130900000000"]=new Array(new Array("130902000000","新华区"),new Array("130903000000","运河区"),new Array("130921000000","沧县"),new Array("130922000000","青县"),new Array("130923000000","东光县"),new Array("130924000000","海兴县"),new Array("130925000000","盐山县"),new Array("130926000000","肃宁县"),new Array("130927000000","南皮县"),new Array("130928000000","吴桥县"),new Array("130929000000","献县"),new Array("130930000000","孟村回族自治县"),new Array("130981000000","泊头市"),new Array("130982000000","任丘市"),new Array("130983000000","黄骅市"),new Array("130984000000","河间市"),new Array("1309A2000000","沧州开发区"),new Array("1309A3000000","河北沧州渤海新区中捷教育局 "),new Array("1309A4000000","南大港"),new Array("1309A5000000","黄骅港"),new Array("1309A6000000","石油分局"),new Array("1309A7000000","沧州高新区"));
CITY_II["131000000000"]=new Array(new Array("131002000000","安次区"),new Array("131003000000","广阳区"),new Array("131022000000","固安县"),new Array("131023000000","永清县"),new Array("131024000000","香河县"),new Array("131025000000","大城县"),new Array("131026000000","文安县"),new Array("131028000000","大厂回族自治县"),new Array("131081000000","霸州市"),new Array("131082000000","三河市"),new Array("1310A2000000","廊坊开发区"));
CITY_II["131100000000"]=new Array(new Array("131102000000","桃城区"),new Array("131121000000","枣强县"),new Array("131122000000","武邑县"),new Array("131123000000","武强县"),new Array("131124000000","饶阳县"),new Array("131125000000","安平县"),new Array("131126000000","故城县"),new Array("131127000000","景县"),new Array("131128000000","阜城县"),new Array("131181000000","冀州市"),new Array("131182000000","深州市"),new Array("1311A2000000","工业新区"),new Array("1311A3000000","滨湖新区"));
CITY_I["140000000000"]=new Array(new Array("140100000000","太原市"),new Array("140200000000","大同市"),new Array("140300000000","阳泉市"),new Array("140400000000","长治市"),new Array("140500000000","晋城市"),new Array("140600000000","朔州市"),new Array("140700000000","晋中市"),new Array("140800000000","运城市"),new Array("140900000000","忻州市"),new Array("141000000000","临汾市"),new Array("141100000000","吕梁市"));
CITY_II["140100000000"]=new Array(new Array("140105000000","小店区"),new Array("140106000000","迎泽区"),new Array("140107000000","杏花岭区"),new Array("140108000000","尖草坪区"),new Array("140109000000","万柏林区"),new Array("140110000000","晋源区"),new Array("140121000000","清徐县"),new Array("140122000000","阳曲县"),new Array("140123000000","娄烦县"),new Array("140181000000","古交市"));
CITY_II["140200000000"]=new Array(new Array("140202000000","城区"),new Array("140203000000","矿区"),new Array("140211000000","南郊区"),new Array("140212000000","新荣区"),new Array("140221000000","阳高县"),new Array("140222000000","天镇县"),new Array("140223000000","广灵县"),new Array("140224000000","灵丘县"),new Array("140225000000","浑源县"),new Array("140226000000","左云县"),new Array("140227000000","大同县"),new Array("1402A1000000","大同开发区"));
CITY_II["140300000000"]=new Array(new Array("140302000000","城区"),new Array("140303000000","矿区"),new Array("140311000000","郊区"),new Array("140321000000","平定县"),new Array("140322000000","盂县"),new Array("1403A1000000","阳泉开发区"));
CITY_II["140400000000"]=new Array(new Array("140402000000","城区"),new Array("140411000000","郊区"),new Array("140421000000","长治县"),new Array("140423000000","襄垣县"),new Array("140424000000","屯留县"),new Array("140425000000","平顺县"),new Array("140426000000","黎城县"),new Array("140427000000","壶关县"),new Array("140428000000","长子县"),new Array("140429000000","武乡县"),new Array("140430000000","沁县"),new Array("140431000000","沁源县"),new Array("140481000000","潞城市"),new Array("1404A1000000","长治开发区"));
CITY_II["140500000000"]=new Array(new Array("140502000000","城区"),new Array("140521000000","沁水县"),new Array("140522000000","阳城县"),new Array("140524000000","陵川县"),new Array("140525000000","泽州县"),new Array("140581000000","高平市"),new Array("1405A1000000","晋城开发区"));
CITY_II["140600000000"]=new Array(new Array("140602000000","朔城区"),new Array("140603000000","平鲁区"),new Array("140621000000","山阴县"),new Array("140622000000","应县"),new Array("140623000000","右玉县"),new Array("140624000000","怀仁县"),new Array("1406A1000000","朔州开发区"));
CITY_II["140700000000"]=new Array(new Array("140702000000","榆次区"),new Array("140721000000","榆社县"),new Array("140722000000","左权县"),new Array("140723000000","和顺县"),new Array("140724000000","昔阳县"),new Array("140725000000","寿阳县"),new Array("140726000000","太谷县"),new Array("140727000000","祁县"),new Array("140728000000","平遥县"),new Array("140729000000","灵石县"),new Array("140781000000","介休市"),new Array("1407A1000000","晋中开发区"));
CITY_II["140800000000"]=new Array(new Array("140802000000","盐湖区"),new Array("140821000000","临猗县"),new Array("140822000000","万荣县"),new Array("140823000000","闻喜县"),new Array("140824000000","稷山县"),new Array("140825000000","新绛县"),new Array("140826000000","绛县"),new Array("140827000000","垣曲县"),new Array("140828000000","夏县"),new Array("140829000000","平陆县"),new Array("140830000000","芮城县"),new Array("140881000000","永济市"),new Array("140882000000","河津市"),new Array("1408A1000000","运城空港经济开发区"),new Array("1408A2000000","运城市经济开发区"));
CITY_II["140900000000"]=new Array(new Array("140902000000","忻府区"),new Array("140921000000","定襄县"),new Array("140922000000","五台县"),new Array("140923000000","代县"),new Array("140924000000","繁峙县"),new Array("140925000000","宁武县"),new Array("140926000000","静乐县"),new Array("140927000000","神池县"),new Array("140928000000","五寨县"),new Array("140929000000","岢岚县"),new Array("140930000000","河曲县"),new Array("140931000000","保德县"),new Array("140932000000","偏关县"),new Array("140981000000","原平市"));
CITY_II["141000000000"]=new Array(new Array("141002000000","尧都区"),new Array("141021000000","曲沃县"),new Array("141022000000","翼城县"),new Array("141023000000","襄汾县"),new Array("141024000000","洪洞县"),new Array("141025000000","古县"),new Array("141026000000","安泽县"),new Array("141027000000","浮山县"),new Array("141028000000","吉县"),new Array("141029000000","乡宁县"),new Array("141030000000","大宁县"),new Array("141031000000","隰县"),new Array("141032000000","永和县"),new Array("141033000000","蒲县"),new Array("141034000000","汾西县"),new Array("141081000000","侯马市"),new Array("141082000000","霍州市"),new Array("1410A1000000","临汾开发区"));
CITY_II["141100000000"]=new Array(new Array("141102000000","离石区"),new Array("141121000000","文水县"),new Array("141122000000","交城县"),new Array("141123000000","兴县"),new Array("141124000000","临县"),new Array("141125000000","柳林县"),new Array("141126000000","石楼县"),new Array("141127000000","岚县"),new Array("141128000000","方山县"),new Array("141129000000","中阳县"),new Array("141130000000","交口县"),new Array("141181000000","孝义市"),new Array("141182000000","汾阳市"));
CITY_I["150000000000"]=new Array(new Array("150100000000","呼和浩特市"),new Array("150200000000","包头市"),new Array("150300000000","乌海市"),new Array("150400000000","赤峰市"),new Array("150500000000","通辽市"),new Array("150600000000","鄂尔多斯市"),new Array("150700000000","呼伦贝尔市"),new Array("150800000000","巴彦淖尔市"),new Array("150900000000","乌兰察布市"),new Array("152200000000","兴安盟"),new Array("152500000000","锡林郭勒盟"),new Array("152900000000","阿拉善盟"));
CITY_II["150100000000"]=new Array(new Array("150102000000","新城区"),new Array("150103000000","回民区"),new Array("150104000000","玉泉区"),new Array("150105000000","赛罕区"),new Array("150121000000","土默特左旗"),new Array("150122000000","托克托县"),new Array("150123000000","和林格尔县"),new Array("150124000000","清水河县"),new Array("150125000000","武川县"));
CITY_II["150200000000"]=new Array(new Array("150202000000","东河区"),new Array("150203000000","昆都仑区"),new Array("150204000000","青山区"),new Array("150205000000","石拐区"),new Array("150206000000","白云鄂博矿区"),new Array("150207000000","九原区"),new Array("150221000000","土默特右旗"),new Array("150222000000","固阳县"),new Array("150223000000","达尔罕茂明安联合旗"),new Array("1502A1000000","包头稀土高新区"));
CITY_II["150300000000"]=new Array(new Array("150302000000","海勃湾区"),new Array("150303000000","海南区"),new Array("150304000000","乌达区"));
CITY_II["150400000000"]=new Array(new Array("150402000000","红山区"),new Array("150403000000","元宝山区"),new Array("150404000000","松山区"),new Array("150421000000","阿鲁科尔沁旗"),new Array("150422000000","巴林左旗"),new Array("150423000000","巴林右旗"),new Array("150424000000","林西县"),new Array("150425000000","克什克腾旗"),new Array("150426000000","翁牛特旗"),new Array("150428000000","喀喇沁旗"),new Array("150429000000","宁城县"),new Array("150430000000","敖汉旗"));
CITY_II["150500000000"]=new Array(new Array("150502000000","科尔沁区"),new Array("150521000000","科尔沁左翼中旗"),new Array("150522000000","科尔沁左翼后旗"),new Array("150523000000","开鲁县"),new Array("150524000000","库伦旗"),new Array("150525000000","奈曼旗"),new Array("150526000000","扎鲁特旗"),new Array("150581000000","霍林郭勒市"),new Array("1505A1000000","开发区"));
CITY_II["150600000000"]=new Array(new Array("150602000000","东胜区"),new Array("150621000000","达拉特旗"),new Array("150622000000","准格尔旗"),new Array("150623000000","鄂托克前旗"),new Array("150624000000","鄂托克旗"),new Array("150625000000","杭锦旗"),new Array("150626000000","乌审旗"),new Array("150627000000","伊金霍洛旗"),new Array("1506A1000000","康巴什新区"));
CITY_II["150700000000"]=new Array(new Array("150702000000","海拉尔区"),new Array("150703000000","扎赉诺尔区"),new Array("150721000000","阿荣旗"),new Array("150722000000","莫力达瓦达斡尔族自治旗"),new Array("150723000000","鄂伦春自治旗"),new Array("150724000000","鄂温克族自治旗"),new Array("150725000000","陈巴尔虎旗"),new Array("150726000000","新巴尔虎左旗"),new Array("150727000000","新巴尔虎右旗"),new Array("150781000000","满洲里市"),new Array("150782000000","牙克石市"),new Array("150783000000","扎兰屯市"),new Array("150784000000","额尔古纳市"),new Array("150785000000","根河市"));
CITY_II["150800000000"]=new Array(new Array("150802000000","临河区"),new Array("150821000000","五原县"),new Array("150822000000","磴口县"),new Array("150823000000","乌拉特前旗"),new Array("150824000000","乌拉特中旗"),new Array("150825000000","乌拉特后旗"),new Array("150826000000","杭锦后旗"));
CITY_II["150900000000"]=new Array(new Array("150902000000","集宁区"),new Array("150921000000","卓资县"),new Array("150922000000","化德县"),new Array("150923000000","商都县"),new Array("150924000000","兴和县"),new Array("150925000000","凉城县"),new Array("150926000000","察哈尔右翼前旗"),new Array("150927000000","察哈尔右翼中旗"),new Array("150928000000","察哈尔右翼后旗"),new Array("150929000000","四子王旗"),new Array("150981000000","丰镇市"));
CITY_II["152200000000"]=new Array(new Array("152201000000","乌兰浩特市"),new Array("152202000000","阿尔山市"),new Array("152221000000","科尔沁右翼前旗"),new Array("152222000000","科尔沁右翼中旗"),new Array("152223000000","扎赉特旗"),new Array("152224000000","突泉县"));
CITY_II["152500000000"]=new Array(new Array("152501000000","二连浩特市"),new Array("152502000000","锡林浩特市"),new Array("152522000000","阿巴嘎旗"),new Array("152523000000","苏尼特左旗"),new Array("152524000000","苏尼特右旗"),new Array("152525000000","东乌珠穆沁旗"),new Array("152526000000","西乌珠穆沁旗"),new Array("152527000000","太仆寺旗"),new Array("152528000000","镶黄旗"),new Array("152529000000","正镶白旗"),new Array("152530000000","正蓝旗"),new Array("152531000000","多伦县"),new Array("1525A1000000","乌拉盖管理区"));
CITY_II["152900000000"]=new Array(new Array("152921000000","阿拉善左旗"),new Array("152922000000","阿拉善右旗"),new Array("152923000000","额济纳旗"),new Array("1529A1000000","开发区"),new Array("1529A2000000","示范区"));
CITY_I["210000000000"]=new Array(new Array("210100000000","沈阳市"),new Array("210200000000","大连市"),new Array("210300000000","鞍山市"),new Array("210400000000","抚顺市"),new Array("210500000000","本溪市"),new Array("210600000000","丹东市"),new Array("210700000000","锦州市"),new Array("210800000000","营口市"),new Array("210900000000","阜新市"),new Array("211000000000","辽阳市"),new Array("211100000000","盘锦市"),new Array("211200000000","铁岭市"),new Array("211300000000","朝阳市"),new Array("211400000000","葫芦岛市"));
CITY_II["210100000000"]=new Array(new Array("210102000000","和平区"),new Array("210103000000","沈河区"),new Array("210104000000","大东区"),new Array("210105000000","皇姑区"),new Array("210106000000","铁西区"),new Array("210111000000","苏家屯区"),new Array("210112000000","东陵区"),new Array("210113000000","沈北新区"),new Array("210114000000","于洪区"),new Array("210122000000","辽中县"),new Array("210123000000","康平县"),new Array("210124000000","法库县"),new Array("210181000000","新民市"));
CITY_II["210200000000"]=new Array(new Array("210202000000","中山区"),new Array("210203000000","西岗区"),new Array("210204000000","沙河口区"),new Array("210211000000","甘井子区"),new Array("210212000000","旅顺口区"),new Array("210213000000","金州区"),new Array("210224000000","长海县"),new Array("210281000000","瓦房店市"),new Array("210282000000","普兰店市"),new Array("210283000000","庄河市"),new Array("2102A1000000","长兴岛"),new Array("2102A2000000","大连高新区"),new Array("2102A3000000","花园口区"),new Array("2102A4000000","保税区"));
CITY_II["210300000000"]=new Array(new Array("210302000000","铁东区"),new Array("210303000000","铁西区"),new Array("210304000000","立山区"),new Array("210311000000","千山区"),new Array("210321000000","台安县"),new Array("210323000000","岫岩满族自治县"),new Array("210381000000","海城市"),new Array("2103A2000000","千山风景名胜区"),new Array("2103A3000000","经济开发区"),new Array("2103A4000000","高新技术产业开发区"));
CITY_II["210400000000"]=new Array(new Array("210402000000","新抚区"),new Array("210403000000","东洲区"),new Array("210404000000","望花区"),new Array("210411000000","顺城区"),new Array("210421000000","抚顺县"),new Array("210422000000","新宾满族自治县"),new Array("210423000000","清原满族自治县"),new Array("2104A2000000","开发区"));
CITY_II["210500000000"]=new Array(new Array("210502000000","平山区"),new Array("210503000000","溪湖区"),new Array("210504000000","明山区"),new Array("210505000000","南芬区"),new Array("210521000000","本溪满族自治县"),new Array("210522000000","桓仁满族自治县"),new Array("2105A3000000","开发区"));
CITY_II["210600000000"]=new Array(new Array("210602000000","元宝区"),new Array("210603000000","振兴区"),new Array("210604000000","振安区"),new Array("210624000000","宽甸满族自治县"),new Array("210681000000","东港市"),new Array("210682000000","凤城市"),new Array("2106A3000000","合作区"));
CITY_II["210700000000"]=new Array(new Array("210702000000","古塔区"),new Array("210703000000","凌河区"),new Array("210711000000","太和区"),new Array("210726000000","黑山县"),new Array("210727000000","义县"),new Array("210781000000","凌海市"),new Array("210782000000","北镇市"),new Array("2107A1000000","锦州开发区"),new Array("2107A2000000","松山新区"),new Array("2107A3000000","锦州龙栖湾新区"));
CITY_II["210800000000"]=new Array(new Array("210802000000","站前区"),new Array("210803000000","西市区"),new Array("210804000000","鲅鱼圈区"),new Array("210811000000","老边区"),new Array("210881000000","盖州市"),new Array("210882000000","大石桥市"));
CITY_II["210900000000"]=new Array(new Array("210902000000","海州区"),new Array("210903000000","新邱区"),new Array("210904000000","太平区"),new Array("210905000000","清河门区"),new Array("210911000000","细河区"),new Array("210921000000","阜新蒙古族自治县"),new Array("210922000000","彰武县"));
CITY_II["211000000000"]=new Array(new Array("211002000000","白塔区"),new Array("211003000000","文圣区"),new Array("211004000000","宏伟区"),new Array("211005000000","弓长岭区"),new Array("211011000000","太子河区"),new Array("211021000000","辽阳县"),new Array("211081000000","灯塔市"));
CITY_II["211100000000"]=new Array(new Array("211102000000","双台子区"),new Array("211103000000","兴隆台区"),new Array("211121000000","大洼县"),new Array("211122000000","盘山县"),new Array("2111A1000000","辽河油田"),new Array("2111A2000000","辽东湾新区"),new Array("2111A3000000","辽河口生态经济区"));
CITY_II["211200000000"]=new Array(new Array("211202000000","银州区"),new Array("211204000000","清河区"),new Array("211221000000","铁岭县"),new Array("211223000000","西丰县"),new Array("211224000000","昌图县"),new Array("211281000000","调兵山市"),new Array("211282000000","开原市"),new Array("2112A1000000","铁岭经济开发区"));
CITY_II["211300000000"]=new Array(new Array("211302000000","双塔区"),new Array("211303000000","龙城区"),new Array("211321000000","朝阳县"),new Array("211322000000","建平县"),new Array("211324000000","喀喇沁左翼蒙古族自治县"),new Array("211381000000","北票市"),new Array("211382000000","凌源市"),new Array("2113A1000000","朝阳市燕都新城"));
CITY_II["211400000000"]=new Array(new Array("211402000000","连山区"),new Array("211403000000","龙港区"),new Array("211404000000","南票区"),new Array("211421000000","绥中县"),new Array("211422000000","建昌县"),new Array("211481000000","兴城市"),new Array("2114A2000000","葫芦岛市杨家杖子经济开发区"),new Array("2114A3000000","觉华岛旅游度假区"));
CITY_I["220000000000"]=new Array(new Array("220100000000","长春市"),new Array("220200000000","吉林市"),new Array("220300000000","四平市"),new Array("220400000000","辽源市"),new Array("220500000000","通化市"),new Array("220600000000","白山市"),new Array("220700000000","松原市"),new Array("220800000000","白城市"),new Array("222400000000","延边朝鲜族自治州"));
CITY_II["220100000000"]=new Array(new Array("220102000000","南关区"),new Array("220103000000","宽城区"),new Array("220104000000","朝阳区"),new Array("220105000000","二道区"),new Array("220106000000","绿园区"),new Array("220112000000","双阳区"),new Array("220122000000","农安县"),new Array("220181000000","九台市"),new Array("220182000000","榆树市"),new Array("220183000000","德惠市"),new Array("2201A2000000","长春高新技术产业开发区"),new Array("2201A3000000","长春经济技术开发区"),new Array("2201A4000000","长春净月高新技术产业开发区"),new Array("2201A5000000","长春汽车经济技术开发区"),new Array("2201A7000000","长春莲花山生态旅游度假区"));
CITY_II["220200000000"]=new Array(new Array("220202000000","昌邑区"),new Array("220203000000","龙潭区"),new Array("220204000000","船营区"),new Array("220211000000","丰满区"),new Array("220221000000","永吉县"),new Array("220281000000","蛟河市"),new Array("220282000000","桦甸市"),new Array("220283000000","舒兰市"),new Array("220284000000","磐石市"),new Array("2202A2000000","吉林高新技术产业开发区"),new Array("2202A3000000","吉林经济技术开发区"));
CITY_II["220300000000"]=new Array(new Array("220302000000","铁西区"),new Array("220303000000","铁东区"),new Array("220322000000","梨树县"),new Array("220323000000","伊通满族自治县"),new Array("220381000000","公主岭市"),new Array("220382000000","双辽市"),new Array("2203A2000000","四平辽河农垦管理区"));
CITY_II["220400000000"]=new Array(new Array("220402000000","龙山区"),new Array("220403000000","西安区"),new Array("220421000000","东丰县"),new Array("220422000000","东辽县"),new Array("2204A2000000","辽源经济开发区"));
CITY_II["220500000000"]=new Array(new Array("220502000000","东昌区"),new Array("220503000000","二道江区"),new Array("220521000000","通化县"),new Array("220523000000","辉南县"),new Array("220524000000","柳河县"),new Array("220581000000","梅河口市"),new Array("220582000000","集安市"));
CITY_II["220600000000"]=new Array(new Array("220602000000","浑江区"),new Array("220605000000","江源区"),new Array("220621000000","抚松县"),new Array("220622000000","靖宇县"),new Array("220623000000","长白朝鲜族自治县"),new Array("220681000000","临江市"));
CITY_II["220700000000"]=new Array(new Array("220702000000","宁江区"),new Array("220721000000","前郭尔罗斯蒙古族自治县"),new Array("220722000000","长岭县"),new Array("220723000000","乾安县"),new Array("220781000000","扶余市"),new Array("2207A2000000","松原市油区"));
CITY_II["220800000000"]=new Array(new Array("220802000000","洮北区"),new Array("220821000000","镇赉县"),new Array("220822000000","通榆县"),new Array("220881000000","洮南市"),new Array("220882000000","大安市"));
CITY_II["222400000000"]=new Array(new Array("222401000000","延吉市"),new Array("222402000000","图们市"),new Array("222403000000","敦化市"),new Array("222404000000","珲春市"),new Array("222405000000","龙井市"),new Array("222406000000","和龙市"),new Array("222424000000","汪清县"),new Array("222426000000","安图县"));
CITY_I["230000000000"]=new Array(new Array("230100000000","哈尔滨市"),new Array("230200000000","齐齐哈尔市"),new Array("230300000000","鸡西市"),new Array("230400000000","鹤岗市"),new Array("230500000000","双鸭山市"),new Array("230600000000","大庆市"),new Array("230700000000","伊春市"),new Array("230800000000","佳木斯市"),new Array("230900000000","七台河市"),new Array("231000000000","牡丹江市"),new Array("231100000000","黑河市"),new Array("231200000000","绥化市"),new Array("232700000000","大兴安岭地区"),new Array("23A100000000","森工总局"));
CITY_II["230100000000"]=new Array(new Array("230102000000","道里区"),new Array("230103000000","南岗区"),new Array("230104000000","道外区"),new Array("230108000000","平房区"),new Array("230109000000","松北区"),new Array("230110000000","香坊区"),new Array("230111000000","呼兰区"),new Array("230112000000","阿城区"),new Array("230123000000","依兰县"),new Array("230124000000","方正县"),new Array("230125000000","宾县"),new Array("230126000000","巴彦县"),new Array("230127000000","木兰县"),new Array("230128000000","通河县"),new Array("230129000000","延寿县"),new Array("230182000000","双城市"),new Array("230183000000","尚志市"),new Array("230184000000","五常市"));
CITY_II["230200000000"]=new Array(new Array("230202000000","龙沙区"),new Array("230203000000","建华区"),new Array("230204000000","铁锋区"),new Array("230205000000","昂昂溪区"),new Array("230206000000","富拉尔基区"),new Array("230207000000","碾子山区"),new Array("230208000000","梅里斯达斡尔族区"),new Array("230221000000","龙江县"),new Array("230223000000","依安县"),new Array("230224000000","泰来县"),new Array("230225000000","甘南县"),new Array("230227000000","富裕县"),new Array("230229000000","克山县"),new Array("230230000000","克东县"),new Array("230231000000","拜泉县"),new Array("230281000000","讷河市"));
CITY_II["230300000000"]=new Array(new Array("230302000000","鸡冠区"),new Array("230303000000","恒山区"),new Array("230304000000","滴道区"),new Array("230305000000","梨树区"),new Array("230306000000","城子河区"),new Array("230307000000","麻山区"),new Array("230321000000","鸡东县"),new Array("230381000000","虎林市"),new Array("230382000000","密山市"));
CITY_II["230400000000"]=new Array(new Array("230402000000","向阳区"),new Array("230403000000","工农区"),new Array("230404000000","南山区"),new Array("230405000000","兴安区"),new Array("230406000000","东山区"),new Array("230407000000","兴山区"),new Array("230421000000","萝北县"),new Array("230422000000","绥滨县"));
CITY_II["230500000000"]=new Array(new Array("230502000000","尖山区"),new Array("230503000000","岭东区"),new Array("230505000000","四方台区"),new Array("230506000000","宝山区"),new Array("230521000000","集贤县"),new Array("230522000000","友谊县"),new Array("230523000000","宝清县"),new Array("230524000000","饶河县"));
CITY_II["230600000000"]=new Array(new Array("230602000000","萨尔图区"),new Array("230603000000","龙凤区"),new Array("230604000000","让胡路区"),new Array("230605000000","红岗区"),new Array("230606000000","大同区"),new Array("230621000000","肇州县"),new Array("230622000000","肇源县"),new Array("230623000000","林甸县"),new Array("230624000000","杜尔伯特蒙古族自治县"),new Array("2306A1000000","黑龙江省大庆油田"));
CITY_II["230700000000"]=new Array(new Array("230702000000","伊春区"),new Array("230703000000","南岔区"),new Array("230704000000","友好区"),new Array("230705000000","西林区"),new Array("230706000000","翠峦区"),new Array("230707000000","新青区"),new Array("230708000000","美溪区"),new Array("230709000000","金山屯区"),new Array("230710000000","五营区"),new Array("230711000000","乌马河区"),new Array("230712000000","汤旺河区"),new Array("230713000000","带岭区"),new Array("230714000000","乌伊岭区"),new Array("230715000000","红星区"),new Array("230716000000","上甘岭区"),new Array("230722000000","嘉荫县"),new Array("230781000000","铁力市"),new Array("2307A1000000","双丰局教育局"),new Array("2307A2000000","桃山局教育局"),new Array("2307A3000000","铁力局教育局"),new Array("2307A4000000","朗乡局教育局"));
CITY_II["230800000000"]=new Array(new Array("230803000000","向阳区"),new Array("230804000000","前进区"),new Array("230805000000","东风区"),new Array("230811000000","郊区"),new Array("230822000000","桦南县"),new Array("230826000000","桦川县"),new Array("230828000000","汤原县"),new Array("230833000000","抚远县"),new Array("230881000000","同江市"),new Array("230882000000","富锦市"));
CITY_II["230900000000"]=new Array(new Array("230902000000","新兴区"),new Array("230903000000","桃山区"),new Array("230904000000","茄子河区"),new Array("230921000000","勃利县"));
CITY_II["231000000000"]=new Array(new Array("231002000000","东安区"),new Array("231003000000","阳明区"),new Array("231004000000","爱民区"),new Array("231005000000","西安区"),new Array("231024000000","东宁县"),new Array("231025000000","林口县"),new Array("231081000000","绥芬河市"),new Array("231083000000","海林市"),new Array("231084000000","宁安市"),new Array("231085000000","穆棱市"));
CITY_II["231100000000"]=new Array(new Array("231102000000","爱辉区"),new Array("231121000000","嫩江县"),new Array("231123000000","逊克县"),new Array("231124000000","孙吴县"),new Array("231181000000","北安市"),new Array("231182000000","五大连池市"),new Array("2311A1000000","五大连池风景区管委会"));
CITY_II["231200000000"]=new Array(new Array("231202000000","北林区"),new Array("231221000000","望奎县"),new Array("231222000000","兰西县"),new Array("231223000000","青冈县"),new Array("231224000000","庆安县"),new Array("231225000000","明水县"),new Array("231226000000","绥棱县"),new Array("231281000000","安达市"),new Array("231282000000","肇东市"),new Array("231283000000","海伦市"));
CITY_II["232700000000"]=new Array(new Array("232701000000","加格达奇区"),new Array("232702000000","松岭区"),new Array("232703000000","新林区"),new Array("232704000000","呼中区"),new Array("232721000000","呼玛县"),new Array("232722000000","塔河县"),new Array("232723000000","漠河县"));
CITY_II["23A100000000"]=new Array(new Array("23A1A1000000","牡丹江林管局"),new Array("23A1A2000000","松花江林管局"),new Array("23A1A3000000","合江林管局"));
CITY_I["310000000000"]=new Array(new Array("310101000000","黄浦区"),new Array("310104000000","徐汇区"),new Array("310105000000","长宁区"),new Array("310106000000","静安区"),new Array("310107000000","普陀区"),new Array("310108000000","闸北区"),new Array("310109000000","虹口区"),new Array("310110000000","杨浦区"),new Array("310112000000","闵行区"),new Array("310113000000","宝山区"),new Array("310114000000","嘉定区"),new Array("310115000000","浦东新区"),new Array("310116000000","金山区"),new Array("310117000000","松江区"),new Array("310118000000","青浦区"),new Array("310120000000","奉贤区"),new Array("310230000000","崇明县"));
CITY_I["320000000000"]=new Array(new Array("320100000000","南京市"),new Array("320200000000","无锡市"),new Array("320300000000","徐州市"),new Array("320400000000","常州市"),new Array("320500000000","苏州市"),new Array("320600000000","南通市"),new Array("320700000000","连云港市"),new Array("320800000000","淮安市"),new Array("320900000000","盐城市"),new Array("321000000000","扬州市"),new Array("321100000000","镇江市"),new Array("321200000000","泰州市"),new Array("321300000000","宿迁市"));
CITY_II["320100000000"]=new Array(new Array("320102000000","玄武区"),new Array("320104000000","秦淮区"),new Array("320105000000","建邺区"),new Array("320106000000","鼓楼区"),new Array("320111000000","浦口区"),new Array("320113000000","栖霞区"),new Array("320114000000","雨花台区"),new Array("320115000000","江宁区"),new Array("320116000000","六合区"),new Array("320117000000","溧水区"),new Array("320118000000","高淳区"),new Array("3201A1000000","南京化学工业园区"));
CITY_II["320200000000"]=new Array(new Array("320202000000","崇安区"),new Array("320203000000","南长区"),new Array("320204000000","北塘区"),new Array("320205000000","锡山区"),new Array("320206000000","惠山区"),new Array("320211000000","滨湖区"),new Array("320281000000","江阴市"),new Array("320282000000","宜兴市"),new Array("3202A1000000","无锡学校管理中心"),new Array("3202A3000000","无锡新区"));
CITY_II["320300000000"]=new Array(new Array("320302000000","鼓楼区"),new Array("320303000000","云龙区"),new Array("320305000000","贾汪区"),new Array("320311000000","泉山区"),new Array("320312000000","铜山区"),new Array("320321000000","丰县"),new Array("320322000000","沛县"),new Array("320324000000","睢宁县"),new Array("320381000000","新沂市"),new Array("320382000000","邳州市"),new Array("3203A1000000","徐州市经济开发区"));
CITY_II["320400000000"]=new Array(new Array("320402000000","天宁区"),new Array("320404000000","钟楼区"),new Array("320405000000","戚墅堰区"),new Array("320411000000","新北区"),new Array("320412000000","武进区"),new Array("320481000000","溧阳市"),new Array("320482000000","金坛市"));
CITY_II["320500000000"]=new Array(new Array("320505000000","虎丘区"),new Array("320506000000","吴中区"),new Array("320507000000","相城区"),new Array("320508000000","姑苏区"),new Array("320509000000","吴江区"),new Array("320581000000","常熟市"),new Array("320582000000","张家港市"),new Array("320583000000","昆山市"),new Array("320585000000","太仓市"),new Array("3205A2000000","苏州工业园区"));
CITY_II["320600000000"]=new Array(new Array("320602000000","崇川区"),new Array("320611000000","港闸区"),new Array("320612000000","通州区"),new Array("320621000000","海安县"),new Array("320623000000","如东县"),new Array("320681000000","启东市"),new Array("320682000000","如皋市"),new Array("320684000000","海门市"),new Array("3206A2000000","南通开发区"));
CITY_II["320700000000"]=new Array(new Array("320703000000","连云区"),new Array("320705000000","新浦区"),new Array("320706000000","海州区"),new Array("320721000000","赣榆县"),new Array("320722000000","东海县"),new Array("320723000000","灌云县"),new Array("320724000000","灌南县"),new Array("3207A2000000","连云港开发区"),new Array("3207A4000000","连云港市徐圩新区"),new Array("3207A5000000","连云港市科教园区"));
CITY_II["320800000000"]=new Array(new Array("320802000000","清河区"),new Array("320803000000","淮安区"),new Array("320804000000","淮阴区"),new Array("320811000000","清浦区"),new Array("320826000000","涟水县"),new Array("320829000000","洪泽县"),new Array("320830000000","盱眙县"),new Array("320831000000","金湖县"),new Array("3208A1000000","淮安市经济技术开发区"),new Array("3208A2000000","淮安市工业园区"));
CITY_II["320900000000"]=new Array(new Array("320902000000","亭湖区"),new Array("320903000000","盐都区"),new Array("320921000000","响水县"),new Array("320922000000","滨海县"),new Array("320923000000","阜宁县"),new Array("320924000000","射阳县"),new Array("320925000000","建湖县"),new Array("320981000000","东台市"),new Array("320982000000","大丰市"),new Array("3209A2000000","盐城开发区"),new Array("3209A3000000","盐城市城南新区"));
CITY_II["321000000000"]=new Array(new Array("321002000000","广陵区"),new Array("321003000000","邗江区"),new Array("321012000000","江都区"),new Array("321023000000","宝应县"),new Array("321081000000","仪征市"),new Array("321084000000","高邮市"),new Array("3210A2000000","扬州开发区"));
CITY_II["321100000000"]=new Array(new Array("321102000000","京口区"),new Array("321111000000","润州区"),new Array("321112000000","丹徒区"),new Array("321181000000","丹阳市"),new Array("321182000000","扬中市"),new Array("321183000000","句容市"));
CITY_II["321200000000"]=new Array(new Array("321202000000","海陵区"),new Array("321203000000","高港区"),new Array("321204000000","姜堰区"),new Array("321281000000","兴化市"),new Array("321282000000","靖江市"),new Array("321283000000","泰兴市"),new Array("3212A1000000","泰州市医药高新区"));
CITY_II["321300000000"]=new Array(new Array("321302000000","宿城区"),new Array("321311000000","宿豫区"),new Array("321322000000","沭阳县"),new Array("321323000000","泗阳县"),new Array("321324000000","泗洪县"),new Array("3213A1000000","宿迁市经济开发区"),new Array("3213A3000000","宿迁市洋河新城"),new Array("3213A5000000","宿迁市骆马湖现代生态农业示范区"),new Array("3213A6000000","宿迁市苏宿工业园区"));
CITY_I["330000000000"]=new Array(new Array("330100000000","杭州市"),new Array("330200000000","宁波市"),new Array("330300000000","温州市"),new Array("330400000000","嘉兴市"),new Array("330500000000","湖州市"),new Array("330600000000","绍兴市"),new Array("330700000000","金华市"),new Array("330800000000","衢州市"),new Array("330900000000","舟山市"),new Array("331000000000","台州市"),new Array("331100000000","丽水市"));
CITY_II["330100000000"]=new Array(new Array("330102000000","上城区"),new Array("330103000000","下城区"),new Array("330104000000","江干区"),new Array("330105000000","拱墅区"),new Array("330106000000","西湖区"),new Array("330108000000","滨江区"),new Array("330109000000","萧山区"),new Array("330110000000","余杭区"),new Array("330122000000","桐庐县"),new Array("330127000000","淳安县"),new Array("330182000000","建德市"),new Array("330183000000","富阳市"),new Array("330185000000","临安市"),new Array("3301A1000000","杭州市本级"),new Array("3301A2000000","西湖风景名胜区　"),new Array("3301A3000000","下沙开发区"),new Array("3301A4000000","大江东产业集聚区"));
CITY_II["330200000000"]=new Array(new Array("330203000000","海曙区"),new Array("330204000000","江东区"),new Array("330205000000","江北区"),new Array("330206000000","北仑区"),new Array("330211000000","镇海区"),new Array("330212000000","鄞州区"),new Array("330225000000","象山县"),new Array("330226000000","宁海县"),new Array("330281000000","余姚市"),new Array("330282000000","慈溪市"),new Array("330283000000","奉化市"),new Array("3302A1000000","大榭开发区"),new Array("3302A2000000","宁波高新区"),new Array("3302A3000000","东钱湖度假区"),new Array("3302A4000000","宁波市本级"),new Array("3302A5000000","杭州湾新区"));
CITY_II["330300000000"]=new Array(new Array("330302000000","鹿城区"),new Array("330303000000","龙湾区"),new Array("330304000000","瓯海区"),new Array("330322000000","洞头县"),new Array("330324000000","永嘉县"),new Array("330326000000","平阳县"),new Array("330327000000","苍南县"),new Array("330328000000","文成县"),new Array("330329000000","泰顺县"),new Array("330381000000","瑞安市"),new Array("330382000000","乐清市"),new Array("3303A1000000","温州市本级"),new Array("3303A2000000","温州开发区"));
CITY_II["330400000000"]=new Array(new Array("330402000000","南湖区"),new Array("330411000000","秀洲区"),new Array("330421000000","嘉善县"),new Array("330424000000","海盐县"),new Array("330481000000","海宁市"),new Array("330482000000","平湖市"),new Array("330483000000","桐乡市"),new Array("3304A1000000","嘉兴市本级"));
CITY_II["330500000000"]=new Array(new Array("330502000000","吴兴区"),new Array("330503000000","南浔区"),new Array("330521000000","德清县"),new Array("330522000000","长兴县"),new Array("330523000000","安吉县"),new Array("3305A1000000","湖州市本级"));
CITY_II["330600000000"]=new Array(new Array("330602000000","越城区"),new Array("330621000000","绍兴县"),new Array("330624000000","新昌县"),new Array("330681000000","诸暨市"),new Array("330682000000","上虞市"),new Array("330683000000","嵊州市"),new Array("3306A1000000","绍兴市本级"));
CITY_II["330700000000"]=new Array(new Array("330702000000","婺城区"),new Array("330703000000","金东区"),new Array("330723000000","武义县"),new Array("330726000000","浦江县"),new Array("330727000000","磐安县"),new Array("330781000000","兰溪市"),new Array("330782000000","义乌市"),new Array("330783000000","东阳市"),new Array("330784000000","永康市"),new Array("3307A1000000","金华市本级"),new Array("3307A2000000","金华开发区"));
CITY_II["330800000000"]=new Array(new Array("330802000000","柯城区"),new Array("330803000000","衢江区"),new Array("330822000000","常山县"),new Array("330824000000","开化县"),new Array("330825000000","龙游县"),new Array("330881000000","江山市"),new Array("3308A1000000","衢州市本级"));
CITY_II["330900000000"]=new Array(new Array("330902000000","定海区"),new Array("330903000000","普陀区"),new Array("330921000000","岱山县"),new Array("330922000000","嵊泗县"),new Array("3309A1000000","舟山市本级"));
CITY_II["331000000000"]=new Array(new Array("331002000000","椒江区"),new Array("331003000000","黄岩区"),new Array("331004000000","路桥区"),new Array("331021000000","玉环县"),new Array("331022000000","三门县"),new Array("331023000000","天台县"),new Array("331024000000","仙居县"),new Array("331081000000","温岭市"),new Array("331082000000","临海市"),new Array("3310A1000000","台州开发区"),new Array("3310A2000000","台州市本级"));
CITY_II["331100000000"]=new Array(new Array("331102000000","莲都区"),new Array("331121000000","青田县"),new Array("331122000000","缙云县"),new Array("331123000000","遂昌县"),new Array("331124000000","松阳县"),new Array("331125000000","云和县"),new Array("331126000000","庆元县"),new Array("331127000000","景宁畲族自治县"),new Array("331181000000","龙泉市"),new Array("3311A1000000","丽水市本级"),new Array("3311A2000000","丽水开发区"));
CITY_I["340000000000"]=new Array(new Array("340100000000","合肥市"),new Array("340200000000","芜湖市"),new Array("340300000000","蚌埠市"),new Array("340400000000","淮南市"),new Array("340500000000","马鞍山市"),new Array("340600000000","淮北市"),new Array("340700000000","铜陵市"),new Array("340800000000","安庆市"),new Array("341000000000","黄山市"),new Array("341100000000","滁州市"),new Array("341200000000","阜阳市"),new Array("341300000000","宿州市"),new Array("341500000000","六安市"),new Array("341600000000","亳州市"),new Array("341700000000","池州市"),new Array("341800000000","宣城市"));
CITY_II["340100000000"]=new Array(new Array("340102000000","瑶海区"),new Array("340103000000","庐阳区"),new Array("340104000000","蜀山区"),new Array("340111000000","包河区"),new Array("340121000000","长丰县"),new Array("340122000000","肥东县"),new Array("340123000000","肥西县"),new Array("340124000000","庐江县"),new Array("340181000000","巢湖市"),new Array("3401A1000000","经开区"),new Array("3401A2000000","高新区"),new Array("3401A3000000","新站区"));
CITY_II["340200000000"]=new Array(new Array("340202000000","镜湖区"),new Array("340203000000","弋江区"),new Array("340207000000","鸠江区"),new Array("340208000000","三山区"),new Array("340221000000","芜湖县"),new Array("340222000000","繁昌县"),new Array("340223000000","南陵县"),new Array("340225000000","无为县"),new Array("3402A1000000","经开区"));
CITY_II["340300000000"]=new Array(new Array("340302000000","龙子湖区"),new Array("340303000000","蚌山区"),new Array("340304000000","禹会区"),new Array("340311000000","淮上区"),new Array("340321000000","怀远县"),new Array("340322000000","五河县"),new Array("340323000000","固镇县"),new Array("3403A1000000","经开区"),new Array("3403A2000000","高新区"));
CITY_II["340400000000"]=new Array(new Array("340402000000","大通区"),new Array("340403000000","田家庵区"),new Array("340404000000","谢家集区"),new Array("340405000000","八公山区"),new Array("340406000000","潘集区"),new Array("340421000000","凤台县"),new Array("3404A1000000","毛集区"));
CITY_II["340500000000"]=new Array(new Array("340503000000","花山区"),new Array("340504000000","雨山区"),new Array("340506000000","博望区"),new Array("340521000000","当涂县"),new Array("340522000000","含山县"),new Array("340523000000","和县"));
CITY_II["340600000000"]=new Array(new Array("340602000000","杜集区"),new Array("340603000000","相山区"),new Array("340604000000","烈山区"),new Array("340621000000","濉溪县"));
CITY_II["340700000000"]=new Array(new Array("340702000000","铜官山区"),new Array("340703000000","狮子山区"),new Array("340711000000","郊区"),new Array("340721000000","铜陵县"));
CITY_II["340800000000"]=new Array(new Array("340802000000","迎江区"),new Array("340803000000","大观区"),new Array("340811000000","宜秀区"),new Array("340822000000","怀宁县"),new Array("340823000000","枞阳县"),new Array("340824000000","潜山县"),new Array("340825000000","太湖县"),new Array("340826000000","宿松县"),new Array("340827000000","望江县"),new Array("340828000000","岳西县"),new Array("340881000000","桐城市"),new Array("3408A1000000","经开区"));
CITY_II["341000000000"]=new Array(new Array("341002000000","屯溪区"),new Array("341003000000","黄山区"),new Array("341004000000","徽州区"),new Array("341021000000","歙县"),new Array("341022000000","休宁县"),new Array("341023000000","黟县"),new Array("341024000000","祁门县"));
CITY_II["341100000000"]=new Array(new Array("341102000000","琅琊区"),new Array("341103000000","南谯区"),new Array("341122000000","来安县"),new Array("341124000000","全椒县"),new Array("341125000000","定远县"),new Array("341126000000","凤阳县"),new Array("341181000000","天长市"),new Array("341182000000","明光市"));
CITY_II["341200000000"]=new Array(new Array("341202000000","颍州区"),new Array("341203000000","颍东区"),new Array("341204000000","颍泉区"),new Array("341221000000","临泉县"),new Array("341222000000","太和县"),new Array("341225000000","阜南县"),new Array("341226000000","颍上县"),new Array("341282000000","界首市"));
CITY_II["341300000000"]=new Array(new Array("341302000000","埇桥区"),new Array("341321000000","砀山县"),new Array("341322000000","萧县"),new Array("341323000000","灵璧县"),new Array("341324000000","泗县"));
CITY_II["341500000000"]=new Array(new Array("341502000000","金安区"),new Array("341503000000","裕安区"),new Array("341521000000","寿县"),new Array("341522000000","霍邱县"),new Array("341523000000","舒城县"),new Array("341524000000","金寨县"),new Array("341525000000","霍山县"),new Array("3415A1000000","叶集区"));
CITY_II["341600000000"]=new Array(new Array("341602000000","谯城区"),new Array("341621000000","涡阳县"),new Array("341622000000","蒙城县"),new Array("341623000000","利辛县"));
CITY_II["341700000000"]=new Array(new Array("341702000000","贵池区"),new Array("341721000000","东至县"),new Array("341722000000","石台县"),new Array("341723000000","青阳县"),new Array("3417A1000000","池州市九华山风景区"));
CITY_II["341800000000"]=new Array(new Array("341802000000","宣州区"),new Array("341821000000","郎溪县"),new Array("341822000000","广德县"),new Array("341823000000","泾县"),new Array("341824000000","绩溪县"),new Array("341825000000","旌德县"),new Array("341881000000","宁国市"));
CITY_I["350000000000"]=new Array(new Array("350100000000","福州市"),new Array("350200000000","厦门市"),new Array("350300000000","莆田市"),new Array("350400000000","三明市"),new Array("350500000000","泉州市"),new Array("350600000000","漳州市"),new Array("350700000000","南平市"),new Array("350800000000","龙岩市"),new Array("350900000000","宁德市"),new Array("35A100000000","平潭综合实验区"));
CITY_II["350100000000"]=new Array(new Array("350102000000","鼓楼区"),new Array("350103000000","台江区"),new Array("350104000000","仓山区"),new Array("350105000000","马尾区"),new Array("350111000000","晋安区"),new Array("350121000000","闽侯县"),new Array("350122000000","连江县"),new Array("350122100000","连江县"),new Array("350123000000","罗源县"),new Array("350124000000","闽清县"),new Array("350125000000","永泰县"),new Array("350128000000","平潭县"),new Array("350181000000","福清市"),new Array("350182000000","长乐市"));
CITY_II["350200000000"]=new Array(new Array("350203000000","思明区"),new Array("350205000000","海沧区"),new Array("350206000000","湖里区"),new Array("350211000000","集美区"),new Array("350212000000","同安区"),new Array("350213000000","翔安区"));
CITY_II["350300000000"]=new Array(new Array("350302000000","城厢区"),new Array("350303000000","涵江区"),new Array("350304000000","荔城区"),new Array("350305000000","秀屿区"),new Array("350322000000","仙游县"),new Array("3503A1000000","湄洲岛国家旅游度假区"),new Array("3503A2000000","湄洲湾北岸经济开发区"));
CITY_II["350400000000"]=new Array(new Array("350402000000","梅列区"),new Array("350403000000","三元区"),new Array("350421000000","明溪县"),new Array("350423000000","清流县"),new Array("350424000000","宁化县"),new Array("350425000000","大田县"),new Array("350426000000","尤溪县"),new Array("350427000000","沙县"),new Array("350428000000","将乐县"),new Array("350429000000","泰宁县"),new Array("350430000000","建宁县"),new Array("350481000000","永安市"));
CITY_II["350500000000"]=new Array(new Array("350502000000","鲤城区"),new Array("350503000000","丰泽区"),new Array("350504000000","洛江区"),new Array("350505000000","泉港区"),new Array("350521000000","惠安县"),new Array("350524000000","安溪县"),new Array("350525000000","永春县"),new Array("350526000000","德化县"),new Array("350527000000","金门县"),new Array("350581000000","石狮市"),new Array("350582000000","晋江市"),new Array("350583000000","南安市"),new Array("3505A1000000","泉州市台商投资区"),new Array("3505A2000000","泉州市开发区"));
CITY_II["350600000000"]=new Array(new Array("350602000000","芗城区"),new Array("350603000000","龙文区"),new Array("350622000000","云霄县"),new Array("350623000000","漳浦县"),new Array("350624000000","诏安县"),new Array("350625000000","长泰县"),new Array("350626000000","东山县"),new Array("350627000000","南靖县"),new Array("350628000000","平和县"),new Array("350629000000","华安县"),new Array("350681000000","龙海市"),new Array("3506A1000000","常山开发区"),new Array("3506A2000000","招商局漳州开发区"),new Array("3506A3000000","漳州市台商投资区"));
CITY_II["350700000000"]=new Array(new Array("350702000000","延平区"),new Array("350721000000","顺昌县"),new Array("350722000000","浦城县"),new Array("350723000000","光泽县"),new Array("350724000000","松溪县"),new Array("350725000000","政和县"),new Array("350781000000","邵武市"),new Array("350782000000","武夷山市"),new Array("350783000000","建瓯市"),new Array("350784000000","建阳市"));
CITY_II["350800000000"]=new Array(new Array("350802000000","新罗区"),new Array("350821000000","长汀县"),new Array("350822000000","永定县"),new Array("350823000000","上杭县"),new Array("350824000000","武平县"),new Array("350825000000","连城县"),new Array("350881000000","漳平市"));
CITY_II["350900000000"]=new Array(new Array("350902000000","蕉城区"),new Array("350921000000","霞浦县"),new Array("350922000000","古田县"),new Array("350923000000","屏南县"),new Array("350924000000","寿宁县"),new Array("350925000000","周宁县"),new Array("350926000000","柘荣县"),new Array("350981000000","福安市"),new Array("350982000000","福鼎市"),new Array("3509A1000000","东桥经济开发区"));
CITY_II["35A100000000"]=new Array(new Array("35A1A1000000","平潭县"));
CITY_I["360000000000"]=new Array(new Array("360100000000","南昌市"),new Array("360200000000","景德镇市"),new Array("360300000000","萍乡市"),new Array("360400000000","九江市"),new Array("360500000000","新余市"),new Array("360600000000","鹰潭市"),new Array("360700000000","赣州市"),new Array("360800000000","吉安市"),new Array("360900000000","宜春市"),new Array("361000000000","抚州市"),new Array("361100000000","上饶市"));
CITY_II["360100000000"]=new Array(new Array("360102000000","东湖区"),new Array("360103000000","西湖区"),new Array("360104000000","青云谱区"),new Array("360105000000","湾里区"),new Array("360111000000","青山湖区"),new Array("360121000000","南昌县"),new Array("360122000000","新建县"),new Array("360123000000","安义县"),new Array("360124000000","进贤县"),new Array("3601A2000000","南昌经开区"),new Array("3601A3000000","红谷滩新区"),new Array("3601A4000000","高新区"),new Array("3601A6000000","桑海开发区"));
CITY_II["360200000000"]=new Array(new Array("360202000000","昌江区"),new Array("360203000000","珠山区"),new Array("360222000000","浮梁县"),new Array("360281000000","乐平市"),new Array("3602A2000000","陶瓷工业园"),new Array("3602A3000000","高新区"));
CITY_II["360300000000"]=new Array(new Array("360302000000","安源区"),new Array("360313000000","湘东区"),new Array("360321000000","莲花县"),new Array("360322000000","上栗县"),new Array("360323000000","芦溪县"),new Array("3603A2000000","萍乡开发区"));
CITY_II["360400000000"]=new Array(new Array("360402000000","庐山区"),new Array("360403000000","浔阳区"),new Array("360421000000","九江县"),new Array("360423000000","武宁县"),new Array("360424000000","修水县"),new Array("360425000000","永修县"),new Array("360426000000","德安县"),new Array("360427000000","星子县"),new Array("360428000000","都昌县"),new Array("360429000000","湖口县"),new Array("360430000000","彭泽县"),new Array("360481000000","瑞昌市"),new Array("360482000000","共青城市"),new Array("3604A2000000","开发区　"),new Array("3604A3000000","庐山局"));
CITY_II["360500000000"]=new Array(new Array("360502000000","渝水区"),new Array("360521000000","分宜县"),new Array("3605A2000000","仙女湖区"),new Array("3605A3000000","孔目江区"),new Array("3605A4000000","高新区"));
CITY_II["360600000000"]=new Array(new Array("360602000000","月湖区"),new Array("360622000000","余江县"),new Array("360681000000","贵溪市"),new Array("3606A2000000","鹰潭高新区"),new Array("3606A3000000","鹰潭信江新区"),new Array("3606A4000000","鹰潭龙虎山景区"));
CITY_II["360700000000"]=new Array(new Array("360702000000","章贡区"),new Array("360721000000","赣县"),new Array("360722000000","信丰县"),new Array("360723000000","大余县"),new Array("360724000000","上犹县"),new Array("360725000000","崇义县"),new Array("360726000000","安远县"),new Array("360727000000","龙南县"),new Array("360728000000","定南县"),new Array("360729000000","全南县"),new Array("360730000000","宁都县"),new Array("360731000000","于都县"),new Array("360732000000","兴国县"),new Array("360733000000","会昌县"),new Array("360734000000","寻乌县"),new Array("360735000000","石城县"),new Array("360781000000","瑞金市"),new Array("360782000000","南康市"),new Array("3607A2000000","开发区"));
CITY_II["360800000000"]=new Array(new Array("360802000000","吉州区"),new Array("360803000000","青原区"),new Array("360821000000","吉安县"),new Array("360822000000","吉水县"),new Array("360823000000","峡江县"),new Array("360824000000","新干县"),new Array("360825000000","永丰县"),new Array("360826000000","泰和县"),new Array("360827000000","遂川县"),new Array("360828000000","万安县"),new Array("360829000000","安福县"),new Array("360830000000","永新县"),new Array("360881000000","井冈山市"));
CITY_II["360900000000"]=new Array(new Array("360902000000","袁州区"),new Array("360921000000","奉新县"),new Array("360922000000","万载县"),new Array("360923000000","上高县"),new Array("360924000000","宜丰县"),new Array("360925000000","靖安县"),new Array("360926000000","铜鼓县"),new Array("360981000000","丰城市"),new Array("360982000000","樟树市"),new Array("360983000000","高安市"),new Array("3609A2000000","经开区管委会"),new Array("3609A3000000","宜阳新区管委会"),new Array("3609A4000000","明月山管委会"));
CITY_II["361000000000"]=new Array(new Array("361002000000","临川区"),new Array("361021000000","南城县"),new Array("361022000000","黎川县"),new Array("361023000000","南丰县"),new Array("361024000000","崇仁县"),new Array("361025000000","乐安县"),new Array("361026000000","宜黄县"),new Array("361027000000","金溪县"),new Array("361028000000","资溪县"),new Array("361029000000","东乡县"),new Array("361030000000","广昌县"),new Array("3610A2000000","高新区"));
CITY_II["361100000000"]=new Array(new Array("361102000000","信州区"),new Array("361121000000","上饶县"),new Array("361122000000","广丰县"),new Array("361123000000","玉山县"),new Array("361124000000","铅山县"),new Array("361125000000","横峰县"),new Array("361126000000","弋阳县"),new Array("361127000000","余干县"),new Array("361128000000","鄱阳县"),new Array("361129000000","万年县"),new Array("361130000000","婺源县"),new Array("361181000000","德兴市"),new Array("3611A2000000","三管委"));
CITY_I["370000000000"]=new Array(new Array("370100000000","济南市"),new Array("370200000000","青岛市"),new Array("370300000000","淄博市"),new Array("370400000000","枣庄市"),new Array("370500000000","东营市"),new Array("370600000000","烟台市"),new Array("370700000000","潍坊市"),new Array("370800000000","济宁市"),new Array("370900000000","泰安市"),new Array("371000000000","威海市"),new Array("371100000000","日照市"),new Array("371200000000","莱芜市"),new Array("371300000000","临沂市"),new Array("371400000000","德州市"),new Array("371500000000","聊城市"),new Array("371600000000","滨州市"),new Array("371700000000","荷泽市"));
CITY_II["370100000000"]=new Array(new Array("370102000000","历下区"),new Array("370103000000","市中区"),new Array("370104000000","槐荫区"),new Array("370105000000","天桥区"),new Array("370112000000","历城区"),new Array("370113000000","长清区"),new Array("370124000000","平阴县"),new Array("370125000000","济阳县"),new Array("370126000000","商河县"),new Array("370181000000","章丘市"),new Array("3701A1000000","济南高新区"));
CITY_II["370200000000"]=new Array(new Array("370202000000","市南区"),new Array("370203000000","市北区"),new Array("370211000000","黄岛区"),new Array("370212000000","崂山区"),new Array("370213000000","李沧区"),new Array("370214000000","城阳区"),new Array("370281000000","胶州市"),new Array("370282000000","即墨市"),new Array("370283000000","平度市"),new Array("370285000000","莱西市"));
CITY_II["370300000000"]=new Array(new Array("370302000000","淄川区"),new Array("370303000000","张店区"),new Array("370304000000","博山区"),new Array("370305000000","临淄区"),new Array("370306000000","周村区"),new Array("370321000000","桓台县"),new Array("370322000000","高青县"),new Array("370323000000","沂源县"),new Array("3703A1000000","文昌湖旅游度假区"),new Array("3703A2000000","淄博高新区"));
CITY_II["370400000000"]=new Array(new Array("370402000000","市中区"),new Array("370403000000","薛城区"),new Array("370404000000","峄城区"),new Array("370405000000","台儿庄区"),new Array("370406000000","山亭区"),new Array("370481000000","滕州市"));
CITY_II["370500000000"]=new Array(new Array("370502000000","东营区"),new Array("370503000000","河口区"),new Array("370521000000","垦利县"),new Array("370522000000","利津县"),new Array("370523000000","广饶县"),new Array("3705A1000000","东营开发区"),new Array("3705A3000000","胜利教管中心"));
CITY_II["370600000000"]=new Array(new Array("370602000000","芝罘区"),new Array("370611000000","福山区"),new Array("370612000000","牟平区"),new Array("370613000000","莱山区"),new Array("370634000000","长岛县"),new Array("370681000000","龙口市"),new Array("370682000000","莱阳市"),new Array("370683000000","莱州市"),new Array("370684000000","蓬莱市"),new Array("370685000000","招远市"),new Array("370686000000","栖霞市"),new Array("370687000000","海阳市"),new Array("3706A2000000","烟台高新区"),new Array("3706A3000000","烟台开发区"));
CITY_II["370700000000"]=new Array(new Array("370702000000","潍城区"),new Array("370703000000","寒亭区"),new Array("370704000000","坊子区"),new Array("370705000000","奎文区"),new Array("370724000000","临朐县"),new Array("370725000000","昌乐县"),new Array("370781000000","青州市"),new Array("370782000000","诸城市"),new Array("370783000000","寿光市"),new Array("370784000000","安丘市"),new Array("370785000000","高密市"),new Array("370786000000","昌邑市"),new Array("3707A1000000","潍坊高新区"),new Array("3707A2000000","潍坊滨海开发区"),new Array("3707A3000000","潍坊经济区"),new Array("3707A4000000","潍坊市峡山区"),new Array("3707A5000000","潍坊综合保税区"));
CITY_II["370800000000"]=new Array(new Array("370802000000","市中区"),new Array("370811000000","任城区"),new Array("370826000000","微山县"),new Array("370827000000","鱼台县"),new Array("370828000000","金乡县"),new Array("370829000000","嘉祥县"),new Array("370830000000","汶上县"),new Array("370831000000","泗水县"),new Array("370832000000","梁山县"),new Array("370881000000","曲阜市"),new Array("370882000000","兖州市"),new Array("370883000000","邹城市"),new Array("3708A1000000","济宁高新区"),new Array("3708A2000000","济宁北湖新区"),new Array("3708A3000000","济宁经济技术开发区"));
CITY_II["370900000000"]=new Array(new Array("370902000000","泰山区"),new Array("370911000000","岱岳区"),new Array("370921000000","宁阳县"),new Array("370923000000","东平县"),new Array("370982000000","新泰市"),new Array("370983000000","肥城市"),new Array("3709A1000000","泰山景区"),new Array("3709A2000000","泰安高新区"));
CITY_II["371000000000"]=new Array(new Array("371002000000","环翠区"),new Array("371081000000","文登市"),new Array("371082000000","荣成市"),new Array("371083000000","乳山市"),new Array("3710A1000000","威海工业新区"),new Array("3710A2000000","威海经区"),new Array("3710A3000000","威海高区"));
CITY_II["371100000000"]=new Array(new Array("371102000000","东港区"),new Array("371103000000","岚山区"),new Array("371121000000","五莲县"),new Array("371122000000","莒县"),new Array("3711A1000000","日照国际海洋城"),new Array("3711A2000000","日照旅游区"),new Array("3711A3000000","日照经济区"));
CITY_II["371200000000"]=new Array(new Array("371202000000","莱城区"),new Array("371203000000","钢城区"),new Array("3712A1000000","莱芜经济开发区"),new Array("3712A2000000","莱芜市雪野旅游区"),new Array("3712A3000000","莱芜市泰钢工业园"),new Array("3712A4000000","莱芜市高新开发区"));
CITY_II["371300000000"]=new Array(new Array("371302000000","兰山区"),new Array("371311000000","罗庄区"),new Array("371312000000","河东区"),new Array("371321000000","沂南县"),new Array("371322000000","郯城县"),new Array("371323000000","沂水县"),new Array("371324000000","苍山县"),new Array("371325000000","费县"),new Array("371326000000","平邑县"),new Array("371327000000","莒南县"),new Array("371328000000","蒙阴县"),new Array("371329000000","临沭县"),new Array("3713A1000000","临沂市临港开发区"),new Array("3713A2000000","临沂市经济开发区"),new Array("3713A3000000","临沂市高新开发区"));
CITY_II["371400000000"]=new Array(new Array("371402000000","德城区"),new Array("371421000000","陵县"),new Array("371422000000","宁津县"),new Array("371423000000","庆云县"),new Array("371424000000","临邑县"),new Array("371425000000","齐河县"),new Array("371426000000","平原县"),new Array("371427000000","夏津县"),new Array("371428000000","武城县"),new Array("371481000000","乐陵市"),new Array("371482000000","禹城市"),new Array("3714A1000000","运河经济开发区"),new Array("3714A2000000","德州经济技术开发区"),new Array("3714A3000000","德州市新城建设处"));
CITY_II["371500000000"]=new Array(new Array("371502000000","东昌府区"),new Array("371521000000","阳谷县"),new Array("371522000000","莘县"),new Array("371523000000","茌平县"),new Array("371524000000","东阿县"),new Array("371525000000","冠县"),new Array("371526000000","高唐县"),new Array("371581000000","临清市"),new Array("3715A1000000","聊城市经济开发区"),new Array("3715A2000000","聊城市高新开发区"));
CITY_II["371600000000"]=new Array(new Array("371602000000","滨城区"),new Array("371621000000","惠民县"),new Array("371622000000","阳信县"),new Array("371623000000","无棣县"),new Array("371624000000","沾化县"),new Array("371625000000","博兴县"),new Array("371626000000","邹平县"),new Array("3716A1000000","滨州北海经济开发区"),new Array("3716A2000000","滨州高新区"),new Array("3716A3000000","滨州经济开发区"));
CITY_II["371700000000"]=new Array(new Array("371702000000","牡丹区"),new Array("371721000000","曹县"),new Array("371722000000","单县"),new Array("371723000000","成武县"),new Array("371724000000","巨野县"),new Array("371725000000","郓城县"),new Array("371726000000","鄄城县"),new Array("371727000000","定陶县"),new Array("371728000000","东明县"),new Array("3717A1000000","菏泽市经济开发区"),new Array("3717A2000000","菏泽高新技术产业开发区"));
CITY_I["410000000000"]=new Array(new Array("410100000000","郑州市"),new Array("410200000000","开封市"),new Array("410300000000","洛阳市"),new Array("410400000000","平顶山市"),new Array("410500000000","安阳市"),new Array("410600000000","鹤壁市"),new Array("410700000000","新乡市"),new Array("410800000000","焦作市"),new Array("410900000000","濮阳市"),new Array("411000000000","许昌市"),new Array("411100000000","漯河市"),new Array("411200000000","三门峡市"),new Array("411300000000","南阳市"),new Array("411400000000","商丘市"),new Array("411500000000","信阳市"),new Array("411600000000","周口市"),new Array("411700000000","驻马店市"),new Array("419001000000","济源市"));
CITY_II["410100000000"]=new Array(new Array("410102000000","中原区"),new Array("410103000000","二七区"),new Array("410104000000","管城回族区"),new Array("410105000000","金水区"),new Array("410106000000","上街区"),new Array("410108000000","惠济区"),new Array("410122000000","中牟县"),new Array("410181000000","巩义市"),new Array("410182000000","荥阳市"),new Array("410183000000","新密市"),new Array("410184000000","新郑市"),new Array("410185000000","登封市"),new Array("4101A1000000","高新区"),new Array("4101A2000000","经开区"),new Array("4101A3000000","郑东新区"),new Array("4101A4000000","航空港区"));
CITY_II["410200000000"]=new Array(new Array("410202000000","龙亭区"),new Array("410203000000","顺河回族区"),new Array("410204000000","鼓楼区"),new Array("410205000000","禹王台区"),new Array("410211000000","金明区"),new Array("410221000000","杞县"),new Array("410222000000","通许县"),new Array("410223000000","尉氏县"),new Array("410224000000","开封县"),new Array("410225000000","兰考县"));
CITY_II["410300000000"]=new Array(new Array("410302000000","老城区"),new Array("410303000000","西工区"),new Array("410304000000","瀍河回族区"),new Array("410305000000","涧西区"),new Array("410306000000","吉利区"),new Array("410311000000","洛龙区"),new Array("410322000000","孟津县"),new Array("410323000000","新安县"),new Array("410324000000","栾川县"),new Array("410325000000","嵩县"),new Array("410326000000","汝阳县"),new Array("410327000000","宜阳县"),new Array("410328000000","洛宁县"),new Array("410329000000","伊川县"),new Array("410381000000","偃师市"),new Array("4103A1000000","龙门管委会"),new Array("4103A2000000","伊滨区"),new Array("4103A3000000","高新区"));
CITY_II["410400000000"]=new Array(new Array("410402000000","新华区"),new Array("410403000000","卫东区"),new Array("410404000000","石龙区"),new Array("410411000000","湛河区"),new Array("410421000000","宝丰县"),new Array("410422000000","叶县"),new Array("410423000000","鲁山县"),new Array("410425000000","郏县"),new Array("410481000000","舞钢市"),new Array("410482000000","汝州市"),new Array("4104A1000000","新城区"));
CITY_II["410500000000"]=new Array(new Array("410502000000","文峰区"),new Array("410503000000","北关区"),new Array("410505000000","殷都区"),new Array("410506000000","龙安区"),new Array("410522000000","安阳县"),new Array("410523000000","汤阴县"),new Array("410526000000","滑县"),new Array("410527000000","内黄县"),new Array("410581000000","林州市"),new Array("4105A1000000","高新区"),new Array("4105A2000000","新区"));
CITY_II["410600000000"]=new Array(new Array("410602000000","鹤山区"),new Array("410603000000","山城区"),new Array("410611000000","淇滨区"),new Array("410621000000","浚县"),new Array("410622000000","淇县"));
CITY_II["410700000000"]=new Array(new Array("410702000000","红旗区"),new Array("410703000000","卫滨区"),new Array("410704000000","凤泉区"),new Array("410711000000","牧野区"),new Array("410721000000","新乡县"),new Array("410724000000","获嘉县"),new Array("410725000000","原阳县"),new Array("410726000000","延津县"),new Array("410727000000","封丘县"),new Array("410728000000","长垣县"),new Array("410781000000","卫辉市"),new Array("410782000000","辉县市"),new Array("4107A2000000","新乡高新区"),new Array("4107A3000000","新乡平原新区"),new Array("4107A4000000","新乡经开区"));
CITY_II["410800000000"]=new Array(new Array("410802000000","解放区"),new Array("410803000000","中站区"),new Array("410804000000","马村区"),new Array("410811000000","山阳区"),new Array("410821000000","修武县"),new Array("410822000000","博爱县"),new Array("410823000000","武陟县"),new Array("410825000000","温县"),new Array("410882000000","沁阳市"),new Array("410883000000","孟州市"),new Array("4108A2000000","焦作新区"));
CITY_II["410900000000"]=new Array(new Array("410902000000","华龙区"),new Array("410922000000","清丰县"),new Array("410923000000","南乐县"),new Array("410926000000","范县"),new Array("410927000000","台前县"),new Array("410928000000","濮阳县"),new Array("4109A1000000","濮阳开发区"),new Array("4109A2000000","濮阳新区"),new Array("4109A3000000","工业园区"),new Array("4109A4000000","濮阳油田"));
CITY_II["411000000000"]=new Array(new Array("411002000000","魏都区"),new Array("411023000000","许昌县"),new Array("411024000000","鄢陵县"),new Array("411025000000","襄城县"),new Array("411081000000","禹州市"),new Array("411082000000","长葛市"),new Array("4110A1000000","开发区"),new Array("4110A2000000","东城区"));
CITY_II["411100000000"]=new Array(new Array("411102000000","源汇区"),new Array("411103000000","郾城区"),new Array("411104000000","召陵区"),new Array("411121000000","舞阳县"),new Array("411122000000","临颍县"),new Array("4111A1000000","开发区"));
CITY_II["411200000000"]=new Array(new Array("411202000000","湖滨区"),new Array("411221000000","渑池县"),new Array("411222000000","陕县"),new Array("411224000000","卢氏县"),new Array("411281000000","义马市"),new Array("411282000000","灵宝市"));
CITY_II["411300000000"]=new Array(new Array("411302000000","宛城区"),new Array("411303000000","卧龙区"),new Array("411321000000","南召县"),new Array("411322000000","方城县"),new Array("411323000000","西峡县"),new Array("411324000000","镇平县"),new Array("411325000000","内乡县"),new Array("411326000000","淅川县"),new Array("411327000000","社旗县"),new Array("411328000000","唐河县"),new Array("411329000000","新野县"),new Array("411330000000","桐柏县"),new Array("411381000000","邓州市"),new Array("4113A1000000","高新区"),new Array("4113A2000000","南阳油田"),new Array("4113A3000000","官庄工区"),new Array("4113A4000000","鸭河工区"),new Array("4113A5000000","南阳新区"));
CITY_II["411400000000"]=new Array(new Array("411402000000","梁园区"),new Array("411403000000","睢阳区"),new Array("411421000000","民权县"),new Array("411422000000","睢县"),new Array("411423000000","宁陵县"),new Array("411424000000","柘城县"),new Array("411425000000","虞城县"),new Array("411426000000","夏邑县"),new Array("411481000000","永城市"),new Array("4114A1000000","经济技术开发区"));
CITY_II["411500000000"]=new Array(new Array("411502000000","浉河区"),new Array("411503000000","平桥区"),new Array("411521000000","罗山县"),new Array("411522000000","光山县"),new Array("411523000000","新县"),new Array("411524000000","商城县"),new Array("411525000000","固始县"),new Array("411526000000","潢川县"),new Array("411527000000","淮滨县"),new Array("411528000000","息县"));
CITY_II["411600000000"]=new Array(new Array("411602000000","川汇区"),new Array("411621000000","扶沟县"),new Array("411622000000","西华县"),new Array("411623000000","商水县"),new Array("411624000000","沈丘县"),new Array("411625000000","郸城县"),new Array("411626000000","淮阳县"),new Array("411627000000","太康县"),new Array("411628000000","鹿邑县"),new Array("411681000000","项城市"),new Array("4116A1000000","开发区"),new Array("4116A2000000","东新区"),new Array("4116A3000000","黄泛区"),new Array("4116A4000000","港区"));
CITY_II["411700000000"]=new Array(new Array("411702000000","驿城区"),new Array("411721000000","西平县"),new Array("411722000000","上蔡县"),new Array("411723000000","平舆县"),new Array("411724000000","正阳县"),new Array("411725000000","确山县"),new Array("411726000000","泌阳县"),new Array("411727000000","汝南县"),new Array("411728000000","遂平县"),new Array("411729000000","新蔡县"),new Array("4117A1000000","市开发区"));
CITY_I["420000000000"]=new Array(new Array("420100000000","武汉市"),new Array("420200000000","黄石市"),new Array("420300000000","十堰市"),new Array("420500000000","宜昌市"),new Array("420600000000","襄樊市"),new Array("420700000000","鄂州市"),new Array("420800000000","荆门市"),new Array("420900000000","孝感市"),new Array("421000000000","荆州市"),new Array("421100000000","黄冈市"),new Array("421200000000","咸宁市"),new Array("421300000000","随州市"),new Array("422800000000","恩施土家族苗族自治州"),new Array("429000000000","省直辖行政单位"));
CITY_II["420100000000"]=new Array(new Array("420102000000","江岸区"),new Array("420103000000","江汉区"),new Array("420104000000","硚口区"),new Array("420105000000","汉阳区"),new Array("420106000000","武昌区"),new Array("420107000000","青山区"),new Array("420111000000","洪山区"),new Array("420112000000","东西湖区"),new Array("420113000000","汉南区"),new Array("420114000000","蔡甸区"),new Array("420115000000","江夏区"),new Array("420116000000","黄陂区"),new Array("420117000000","新洲区"),new Array("4201A1000000","武汉市经济技术开发区"),new Array("4201A2000000","武汉市东湖新技术开发区"),new Array("4201A3000000","武汉市化学工业区"),new Array("4201A5000000","武汉市东湖生态旅游风景区"));
CITY_II["420200000000"]=new Array(new Array("420202000000","黄石港区"),new Array("420203000000","西塞山区"),new Array("420204000000","下陆区"),new Array("420205000000","铁山区"),new Array("420222000000","阳新县"),new Array("420281000000","大冶市"),new Array("4202A2000000","黄石经济技术开发区"));
CITY_II["420300000000"]=new Array(new Array("420302000000","茅箭区"),new Array("420303000000","张湾区"),new Array("420321000000","郧县"),new Array("420322000000","郧西县"),new Array("420323000000","竹山县"),new Array("420324000000","竹溪县"),new Array("420325000000","房县"),new Array("420381000000","丹江口市"),new Array("4203A2000000","十堰市武当山特区"),new Array("4203A3000000","十堰市东风分局"),new Array("4203A5000000","十堰市经济技术开发区"));
CITY_II["420500000000"]=new Array(new Array("420502000000","西陵区"),new Array("420503000000","伍家岗区"),new Array("420504000000","点军区"),new Array("420505000000","猇亭区"),new Array("420506000000","夷陵区"),new Array("420525000000","远安县"),new Array("420526000000","兴山县"),new Array("420527000000","秭归县"),new Array("420528000000","长阳土家族自治县"),new Array("420529000000","五峰土家族自治县"),new Array("420581000000","宜都市"),new Array("420582000000","当阳市"),new Array("420583000000","枝江市"),new Array("4205A2000000","宜昌市高新技术开发区"));
CITY_II["420600000000"]=new Array(new Array("420602000000","襄城区"),new Array("420606000000","樊城区"),new Array("420607000000","襄州区"),new Array("420624000000","南漳县"),new Array("420625000000","谷城县"),new Array("420626000000","保康县"),new Array("420682000000","老河口市"),new Array("420683000000","枣阳市"),new Array("420684000000","宜城市"),new Array("4206A1000000","襄阳市国家高新技术产业开发区"),new Array("4206A4000000","襄阳市东津新区"));
CITY_II["420700000000"]=new Array(new Array("420702000000","梁子湖区"),new Array("420703000000","华容区"),new Array("420704000000","鄂城区"),new Array("4207A2000000","鄂州市经济技术开发区"),new Array("4207A3000000","鄂州市经济技术葛店开发区"));
CITY_II["420800000000"]=new Array(new Array("420802000000","东宝区"),new Array("420804000000","掇刀区"),new Array("420821000000","京山县"),new Array("420822000000","沙洋县"),new Array("420881000000","钟祥市"),new Array("4208A1000000","荆门市屈家岭管理区"),new Array("4208A3000000","荆门市漳河新区"));
CITY_II["420900000000"]=new Array(new Array("420902000000","孝南区"),new Array("420921000000","孝昌县"),new Array("420922000000","大悟县"),new Array("420923000000","云梦县"),new Array("420981000000","应城市"),new Array("420982000000","安陆市"),new Array("420984000000","汉川市"),new Array("4209A2000000","孝感市高新经济开发区"));
CITY_II["421000000000"]=new Array(new Array("421002000000","沙市区"),new Array("421003000000","荆州区"),new Array("421022000000","公安县"),new Array("421023000000","监利县"),new Array("421024000000","江陵县"),new Array("421081000000","石首市"),new Array("421083000000","洪湖市"),new Array("421087000000","松滋市"),new Array("4210A1000000","荆州市开发区"));
CITY_II["421100000000"]=new Array(new Array("421102000000","黄州区"),new Array("421121000000","团风县"),new Array("421122000000","红安县"),new Array("421123000000","罗田县"),new Array("421124000000","英山县"),new Array("421125000000","浠水县"),new Array("421126000000","蕲春县"),new Array("421127000000","黄梅县"),new Array("421181000000","麻城市"),new Array("421182000000","武穴市"),new Array("4211A1000000","黄冈市龙感湖管理区"));
CITY_II["421200000000"]=new Array(new Array("421202000000","咸安区"),new Array("421221000000","嘉鱼县"),new Array("421222000000","通城县"),new Array("421223000000","崇阳县"),new Array("421224000000","通山县"),new Array("421281000000","赤壁市"));
CITY_II["421300000000"]=new Array(new Array("421303000000","曾都区"),new Array("421321000000","随县"),new Array("421381000000","广水市"),new Array("4213A2000000","随州市大洪山风景名胜区"),new Array("4213A3000000","随州市经济开发区"));
CITY_II["422800000000"]=new Array(new Array("422801000000","恩施市"),new Array("422802000000","利川市"),new Array("422822000000","建始县"),new Array("422823000000","巴东县"),new Array("422825000000","宣恩县"),new Array("422826000000","咸丰县"),new Array("422827000000","来凤县"),new Array("422828000000","鹤峰县"));
CITY_II["429000000000"]=new Array(new Array("429004000000","仙桃市"),new Array("429005000000","潜江市"),new Array("429006000000","天门市"),new Array("429021000000","神农架林区"));
CITY_I["430000000000"]=new Array(new Array("430100000000","长沙市"),new Array("430200000000","株洲市"),new Array("430300000000","湘潭市"),new Array("430400000000","衡阳市"),new Array("430500000000","邵阳市"),new Array("430600000000","岳阳市"),new Array("430700000000","常德市"),new Array("430800000000","张家界市"),new Array("430900000000","益阳市"),new Array("431000000000","郴州市"),new Array("431100000000","永州市"),new Array("431200000000","怀化市"),new Array("431300000000","娄底市"),new Array("433100000000","湘西土家族苗族自治州"));
CITY_II["430100000000"]=new Array(new Array("430102000000","芙蓉区"),new Array("430103000000","天心区"),new Array("430104000000","岳麓区"),new Array("430105000000","开福区"),new Array("430111000000","雨花区"),new Array("430112000000","望城区"),new Array("430121000000","长沙县"),new Array("430124000000","宁乡县"),new Array("430181000000","浏阳市"),new Array("4301A1000000","长沙市高新区"),new Array("4301A2000000","长沙市市本级"));
CITY_II["430200000000"]=new Array(new Array("430202000000","荷塘区"),new Array("430203000000","芦淞区"),new Array("430204000000","石峰区"),new Array("430211000000","天元区"),new Array("430221000000","株洲县"),new Array("430223000000","攸县"),new Array("430224000000","茶陵县"),new Array("430225000000","炎陵县"),new Array("430281000000","醴陵市"),new Array("4302A1000000","云龙示范区"),new Array("4302A2000000","株洲市市本级"));
CITY_II["430300000000"]=new Array(new Array("430302000000","雨湖区"),new Array("430304000000","岳塘区"),new Array("430321000000","湘潭县"),new Array("430381000000","湘乡市"),new Array("430382000000","韶山市"),new Array("4303A1000000","九华经开区"),new Array("4303A2000000","昭山示范区"),new Array("4303A3000000","湘潭市市本级"));
CITY_II["430400000000"]=new Array(new Array("430405000000","珠晖区"),new Array("430406000000","雁峰区"),new Array("430407000000","石鼓区"),new Array("430408000000","蒸湘区"),new Array("430412000000","南岳区"),new Array("430421000000","衡阳县"),new Array("430422000000","衡南县"),new Array("430423000000","衡山县"),new Array("430424000000","衡东县"),new Array("430426000000","祁东县"),new Array("430481000000","耒阳市"),new Array("430482000000","常宁市"),new Array("4304A1000000","衡阳市市本级"));
CITY_II["430500000000"]=new Array(new Array("430502000000","双清区"),new Array("430503000000","大祥区"),new Array("430511000000","北塔区"),new Array("430521000000","邵东县"),new Array("430522000000","新邵县"),new Array("430523000000","邵阳县"),new Array("430524000000","隆回县"),new Array("430525000000","洞口县"),new Array("430527000000","绥宁县"),new Array("430528000000","新宁县"),new Array("430529000000","城步苗族自治县"),new Array("430581000000","武冈市"),new Array("4305A1000000","邵阳市市本级"));
CITY_II["430600000000"]=new Array(new Array("430602000000","岳阳楼区"),new Array("430603000000","云溪区"),new Array("430611000000","君山区"),new Array("430621000000","岳阳县"),new Array("430623000000","华容县"),new Array("430624000000","湘阴县"),new Array("430626000000","平江县"),new Array("430681000000","汨罗市"),new Array("430682000000","临湘市"),new Array("4306A1000000","岳阳市市本级"),new Array("4306A2000000","经济开发区"),new Array("4306A3000000","南湖风景区"),new Array("4306A4000000","屈原管理区"));
CITY_II["430700000000"]=new Array(new Array("430702000000","武陵区"),new Array("430703000000","鼎城区"),new Array("430721000000","安乡县"),new Array("430722000000","汉寿县"),new Array("430723000000","澧县"),new Array("430724000000","临澧县"),new Array("430725000000","桃源县"),new Array("430726000000","石门县"),new Array("430781000000","津市市"),new Array("4307A1000000","经济开发区"),new Array("4307A2000000","桃花源管理区"),new Array("4307A3000000","柳叶湖旅游渡假区"),new Array("4307A4000000","西湖管理区"),new Array("4307A5000000","西洞庭管理区"),new Array("4307A6000000","常德市市本级"),new Array("4307A7000000","贺家山原种场"));
CITY_II["430800000000"]=new Array(new Array("430802000000","永定区"),new Array("430811000000","武陵源区"),new Array("430821000000","慈利县"),new Array("430822000000","桑植县"),new Array("4308A1000000","张家界市市本级"));
CITY_II["430900000000"]=new Array(new Array("430902000000","资阳区"),new Array("430903000000","赫山区"),new Array("430921000000","南县"),new Array("430922000000","桃江县"),new Array("430923000000","安化县"),new Array("430981000000","沅江市"),new Array("4309A1000000","大通湖区"));
CITY_II["431000000000"]=new Array(new Array("431002000000","北湖区"),new Array("431003000000","苏仙区"),new Array("431021000000","桂阳县"),new Array("431022000000","宜章县"),new Array("431023000000","永兴县"),new Array("431024000000","嘉禾县"),new Array("431025000000","临武县"),new Array("431026000000","汝城县"),new Array("431027000000","桂东县"),new Array("431028000000","安仁县"),new Array("431081000000","资兴市"),new Array("4310A1000000","郴州市市本级"));
CITY_II["431100000000"]=new Array(new Array("431102000000","零陵区"),new Array("431103000000","冷水滩区"),new Array("431121000000","祁阳县"),new Array("431122000000","东安县"),new Array("431123000000","双牌县"),new Array("431124000000","道县"),new Array("431125000000","江永县"),new Array("431126000000","宁远县"),new Array("431127000000","蓝山县"),new Array("431128000000","新田县"),new Array("431129000000","江华瑶族自治县"),new Array("4311A1000000","回龙圩管理区"),new Array("4311A2000000","金洞管理区"),new Array("4311A3000000","永州市市本级"));
CITY_II["431200000000"]=new Array(new Array("431202000000","鹤城区"),new Array("431221000000","中方县"),new Array("431222000000","沅陵县"),new Array("431223000000","辰溪县"),new Array("431224000000","溆浦县"),new Array("431225000000","会同县"),new Array("431226000000","麻阳苗族自治县"),new Array("431227000000","新晃侗族自治县"),new Array("431228000000","芷江侗族自治县"),new Array("431229000000","靖州苗族侗族自治县"),new Array("431230000000","通道侗族自治县"),new Array("431281000000","洪江市"),new Array("4312A1000000","洪江区"),new Array("4312A2000000","怀化市市本级"));
CITY_II["431300000000"]=new Array(new Array("431302000000","娄星区"),new Array("431321000000","双峰县"),new Array("431322000000","新化县"),new Array("431381000000","冷水江市"),new Array("431382000000","涟源市"),new Array("4313A1000000","娄底市经济开发区"),new Array("4313A2000000","娄底市市本级"));
CITY_II["433100000000"]=new Array(new Array("433101000000","吉首市"),new Array("433122000000","泸溪县"),new Array("433123000000","凤凰县"),new Array("433124000000","花垣县"),new Array("433125000000","保靖县"),new Array("433126000000","古丈县"),new Array("433127000000","永顺县"),new Array("433130000000","龙山县"));
CITY_I["440000000000"]=new Array(new Array("440103000000","荔湾区"),new Array("440104000000","越秀区"),new Array("440105000000","海珠区"),new Array("440106000000","天河区"),new Array("440111000000","白云区"),new Array("440112000000","黄埔区"),new Array("440113000000","番禺区"),new Array("440114000000","花都区"),new Array("440115000000","南沙区"),new Array("440116000000","萝岗区"),new Array("440183000000","增城市"),new Array("440184000000","从化市"),new Array("440200000000","韶关市"),new Array("440300000000","深圳市"),new Array("440400000000","珠海市"),new Array("440500000000","汕头市"),new Array("440600000000","佛山市"),new Array("440700000000","江门市"),new Array("440800000000","湛江市"),new Array("440900000000","茂名市"),new Array("441200000000","肇庆市"),new Array("441300000000","惠州市"),new Array("441400000000","梅州市"),new Array("441500000000","汕尾市"),new Array("441600000000","河源市"),new Array("441700000000","阳江市"),new Array("441800000000","清远市"),new Array("441900000000","东莞市"),new Array("442000000000","中山市"),new Array("445100000000","潮州市"),new Array("445200000000","揭阳市"),new Array("445300000000","云浮市"));
CITY_II["440200000000"]=new Array(new Array("440203000000","武江区"),new Array("440204000000","浈江区"),new Array("440205000000","曲江区"),new Array("440222000000","始兴县"),new Array("440224000000","仁化县"),new Array("440229000000","翁源县"),new Array("440232000000","乳源瑶族自治县"),new Array("440233000000","新丰县"),new Array("440281000000","乐昌市"),new Array("440282000000","南雄市"));
CITY_II["440300000000"]=new Array(new Array("440303000000","罗湖区"),new Array("440304000000","福田区"),new Array("440305000000","南山区"),new Array("440306000000","宝安区"),new Array("440307000000","龙岗区"),new Array("440308000000","盐田区"),new Array("4403A1000000","广东省深圳市光明新区"),new Array("4403A2000000","广东省深圳市坪山新区"),new Array("4403A3000000","广东省深圳市龙华新区"),new Array("4403A4000000","广东省深圳市大鹏新区"));
CITY_II["440400000000"]=new Array(new Array("440402000000","香洲区"),new Array("440403000000","斗门区"),new Array("440404000000","金湾区"),new Array("4404A1000000","横琴新区"),new Array("4404A2000000","高新区"),new Array("4404A3000000","万山"),new Array("4404A4000000","高栏港"));
CITY_II["440500000000"]=new Array(new Array("440507000000","龙湖区"),new Array("440511000000","金平区"),new Array("440512000000","濠江区"),new Array("440513000000","潮阳区"),new Array("440514000000","潮南区"),new Array("440515000000","澄海区"),new Array("440523000000","南澳县"));
CITY_II["440600000000"]=new Array(new Array("440604000000","禅城区"),new Array("440605000000","南海区"),new Array("440606000000","顺德区"),new Array("440607000000","三水区"),new Array("440608000000","高明区"));
CITY_II["440700000000"]=new Array(new Array("440703000000","蓬江区"),new Array("440704000000","江海区"),new Array("440705000000","新会区"),new Array("440781000000","台山市"),new Array("440783000000","开平市"),new Array("440784000000","鹤山市"),new Array("440785000000","恩平市"));
CITY_II["440800000000"]=new Array(new Array("440802000000","赤坎区"),new Array("440803000000","霞山区"),new Array("440804000000","坡头区"),new Array("440811000000","麻章区"),new Array("440823000000","遂溪县"),new Array("440825000000","徐闻县"),new Array("440881000000","廉江市"),new Array("440882000000","雷州市"),new Array("440883000000","吴川市"),new Array("4408A2000000","湛江开发区"));
CITY_II["440900000000"]=new Array(new Array("440902000000","茂南区"),new Array("440903000000","茂港区"),new Array("440923000000","电白县"),new Array("440981000000","高州市"),new Array("440982000000","化州市"),new Array("440983000000","信宜市"),new Array("4409A1000000","茂名市滨海新区"),new Array("4409A2000000","茂名市高新区"));
CITY_II["441200000000"]=new Array(new Array("441202000000","端州区"),new Array("441203000000","鼎湖区"),new Array("441223000000","广宁县"),new Array("441224000000","怀集县"),new Array("441225000000","封开县"),new Array("441226000000","德庆县"),new Array("441283000000","高要市"),new Array("441284000000","四会市"),new Array("4412A1000000","广东省肇庆市大旺区"));
CITY_II["441300000000"]=new Array(new Array("441302000000","惠城区"),new Array("441303000000","惠阳区"),new Array("441322000000","博罗县"),new Array("441323000000","惠东县"),new Array("441324000000","龙门县"),new Array("4413A1000000","广东省惠州市大亚湾区"),new Array("4413A2000000","广东省惠州市仲恺区"));
CITY_II["441400000000"]=new Array(new Array("441402000000","梅江区"),new Array("441421000000","梅县"),new Array("441422000000","大埔县"),new Array("441423000000","丰顺县"),new Array("441424000000","五华县"),new Array("441426000000","平远县"),new Array("441427000000","蕉岭县"),new Array("441481000000","兴宁市"));
CITY_II["441500000000"]=new Array(new Array("441502000000","城区"),new Array("441521000000","海丰县"),new Array("441523000000","陆河县"),new Array("441581000000","陆丰市"),new Array("4415A1000000","广东省汕尾红海湾经济开放区"),new Array("4415A2000000","广东省汕尾市华侨管理区"));
CITY_II["441600000000"]=new Array(new Array("441602000000","源城区"),new Array("441621000000","紫金县"),new Array("441622000000","龙川县"),new Array("441623000000","连平县"),new Array("441624000000","和平县"),new Array("441625000000","东源县"));
CITY_II["441700000000"]=new Array(new Array("441702000000","江城区"),new Array("441721000000","阳西县"),new Array("441723000000","阳东县"),new Array("441781000000","阳春市"),new Array("4417A1000000","海陵区"),new Array("4417A2000000","农垦局"),new Array("4417A3000000","高新区"));
CITY_II["441800000000"]=new Array(new Array("441802000000","清城区"),new Array("441803000000","清新区"),new Array("441821000000","佛冈县"),new Array("441823000000","阳山县"),new Array("441825000000","连山壮族瑶族自治县"),new Array("441826000000","连南瑶族自治县"),new Array("441881000000","英德市"),new Array("441882000000","连州市"));
CITY_II["445100000000"]=new Array(new Array("445102000000","湘桥区"),new Array("445103000000","潮安区"),new Array("445122000000","饶平县"),new Array("4451A1000000","广东省潮州市枫溪区"));
CITY_II["445200000000"]=new Array(new Array("445202000000","榕城区"),new Array("445203000000","揭东区"),new Array("445222000000","揭西县"),new Array("445224000000","惠来县"),new Array("445281000000","普宁市"),new Array("4452A1000000","广东省揭阳市蓝城区"),new Array("4452A2000000","广东省揭阳市空港经济区"));
CITY_II["445300000000"]=new Array(new Array("445302000000","云城区"),new Array("445321000000","新兴县"),new Array("445322000000","郁南县"),new Array("445323000000","云安县"),new Array("445381000000","罗定市"));
CITY_I["450000000000"]=new Array(new Array("450100000000","南宁市"),new Array("450200000000","柳州市"),new Array("450300000000","桂林市"),new Array("450400000000","梧州市"),new Array("450500000000","北海市"),new Array("450600000000","防城港市"),new Array("450700000000","钦州市"),new Array("450800000000","贵港市"),new Array("450900000000","玉林市"),new Array("451000000000","百色市"),new Array("451100000000","贺州市"),new Array("451200000000","河池市"),new Array("451300000000","来宾市"),new Array("451400000000","崇左市"));
CITY_II["450100000000"]=new Array(new Array("450102000000","兴宁区"),new Array("450103000000","青秀区"),new Array("450105000000","江南区"),new Array("450107000000","西乡塘区"),new Array("450108000000","良庆区"),new Array("450109000000","邕宁区"),new Array("450122000000","武鸣县"),new Array("450123000000","隆安县"),new Array("450124000000","马山县"),new Array("450125000000","上林县"),new Array("450126000000","宾阳县"),new Array("450127000000","横县"),new Array("4501A1000000","南宁市经开区"),new Array("4501A3000000","南宁市高新区"),new Array("4501A6000000","南宁市华侨区"));
CITY_II["450200000000"]=new Array(new Array("450202000000","城中区"),new Array("450203000000","鱼峰区"),new Array("450204000000","柳南区"),new Array("450205000000","柳北区"),new Array("450221000000","柳江县"),new Array("450222000000","柳城县"),new Array("450223000000","鹿寨县"),new Array("450224000000","融安县"),new Array("450225000000","融水苗族自治县"),new Array("450226000000","三江侗族自治县"),new Array("4502A2000000","柳州市柳东新区"),new Array("4502A3000000","柳州市阳和工业新区"));
CITY_II["450300000000"]=new Array(new Array("450302000000","秀峰区"),new Array("450303000000","叠彩区"),new Array("450304000000","象山区"),new Array("450305000000","七星区"),new Array("450311000000","雁山区"),new Array("450312000000","临桂区"),new Array("450321000000","阳朔县"),new Array("450323000000","灵川县"),new Array("450324000000","全州县"),new Array("450325000000","兴安县"),new Array("450326000000","永福县"),new Array("450327000000","灌阳县"),new Array("450328000000","龙胜各族自治县"),new Array("450329000000","资源县"),new Array("450330000000","平乐县"),new Array("450331000000","荔浦县"),new Array("450332000000","恭城瑶族自治县"));
CITY_II["450400000000"]=new Array(new Array("450403000000","万秀区"),new Array("450405000000","长洲区"),new Array("450406000000","龙圩区"),new Array("450421000000","苍梧县"),new Array("450422000000","藤县"),new Array("450423000000","蒙山县"),new Array("450481000000","岑溪市"),new Array("4504A2000000","梧州市工业园区"));
CITY_II["450500000000"]=new Array(new Array("450502000000","海城区"),new Array("450503000000","银海区"),new Array("450512000000","铁山港区"),new Array("450521000000","合浦县"),new Array("4505A1000000","北海市涠洲岛旅游度假区"));
CITY_II["450600000000"]=new Array(new Array("450602000000","港口区"),new Array("450603000000","防城区"),new Array("450621000000","上思县"),new Array("450681000000","东兴市"));
CITY_II["450700000000"]=new Array(new Array("450702000000","钦南区"),new Array("450703000000","钦北区"),new Array("450721000000","灵山县"),new Array("450722000000","浦北县"));
CITY_II["450800000000"]=new Array(new Array("450802000000","港北区"),new Array("450803000000","港南区"),new Array("450804000000","覃塘区"),new Array("450821000000","平南县"),new Array("450881000000","桂平市"));
CITY_II["450900000000"]=new Array(new Array("450902000000","玉州区"),new Array("450903000000","福绵区"),new Array("450921000000","容县"),new Array("450922000000","陆川县"),new Array("450923000000","博白县"),new Array("450924000000","兴业县"),new Array("450981000000","北流市"),new Array("4509A2000000","玉林市玉东新区"));
CITY_II["451000000000"]=new Array(new Array("451002000000","右江区"),new Array("451021000000","田阳县"),new Array("451022000000","田东县"),new Array("451023000000","平果县"),new Array("451024000000","德保县"),new Array("451025000000","靖西县"),new Array("451026000000","那坡县"),new Array("451027000000","凌云县"),new Array("451028000000","乐业县"),new Array("451029000000","田林县"),new Array("451030000000","西林县"),new Array("451031000000","隆林各族自治县"));
CITY_II["451100000000"]=new Array(new Array("451102000000","八步区"),new Array("451121000000","昭平县"),new Array("451122000000","钟山县"),new Array("451123000000","富川瑶族自治县"));
CITY_II["451200000000"]=new Array(new Array("451202000000","金城江区"),new Array("451221000000","南丹县"),new Array("451222000000","天峨县"),new Array("451223000000","凤山县"),new Array("451224000000","东兰县"),new Array("451225000000","罗城仫佬族自治县"),new Array("451226000000","环江毛南族自治县"),new Array("451227000000","巴马瑶族自治县"),new Array("451228000000","都安瑶族自治县"),new Array("451229000000","大化瑶族自治县"),new Array("451281000000","宜州市"));
CITY_II["451300000000"]=new Array(new Array("451302000000","兴宾区"),new Array("451321000000","忻城县"),new Array("451322000000","象州县"),new Array("451323000000","武宣县"),new Array("451324000000","金秀瑶族自治县"),new Array("451381000000","合山市"));
CITY_II["451400000000"]=new Array(new Array("451402000000","江州区"),new Array("451421000000","扶绥县"),new Array("451422000000","宁明县"),new Array("451423000000","龙州县"),new Array("451424000000","大新县"),new Array("451425000000","天等县"),new Array("451481000000","凭祥市"));
CITY_I["460000000000"]=new Array(new Array("460100000000","海口市"),new Array("460200000000","三亚市"),new Array("460300000000","三沙市"),new Array("469001000000","五指山市"),new Array("469002000000","琼海市"),new Array("469003000000","儋州市"),new Array("469005000000","文昌市"),new Array("469006000000","万宁市"),new Array("469007000000","东方市"),new Array("469021000000","定安县"),new Array("469022000000","屯昌县"),new Array("469023000000","澄迈县"),new Array("469024000000","临高县"),new Array("469025000000","白沙黎族自治县"),new Array("469026000000","昌江黎族自治县"),new Array("469027000000","乐东黎族自治县"),new Array("469028000000","陵水黎族自治县"),new Array("469029000000","保亭黎族苗族自治县"),new Array("469030000000","琼中黎族苗族自治县"));
CITY_II["460100000000"]=new Array(new Array("460105000000","秀英区"),new Array("460106000000","龙华区"),new Array("460107000000","琼山区"),new Array("460108000000","美兰区"));
CITY_II["460300000000"]=new Array(new Array("460321000000","西沙群岛"),new Array("460322000000","南沙群岛"),new Array("460323000000","中沙群岛的岛礁及其海域"));
CITY_I["500000000000"]=new Array(new Array("500101000000","万州区"),new Array("500102000000","涪陵区"),new Array("500103000000","渝中区"),new Array("500104000000","大渡口区"),new Array("500105000000","江北区"),new Array("500106000000","沙坪坝区"),new Array("500107000000","九龙坡区"),new Array("500108000000","南岸区"),new Array("500109000000","北碚区"),new Array("500110000000","綦江区"),new Array("500111000000","大足区"),new Array("500112000000","渝北区"),new Array("500113000000","巴南区"),new Array("500114000000","黔江区"),new Array("500115000000","长寿区"),new Array("500116000000","江津区"),new Array("500117000000","合川区"),new Array("500118000000","永川区"),new Array("500119000000","南川区"),new Array("500223000000","潼南县"),new Array("500224000000","铜梁县"),new Array("500226000000","荣昌县"),new Array("500227000000","璧山县"),new Array("500228000000","梁平县"),new Array("500229000000","城口县"),new Array("500230000000","丰都县"),new Array("500231000000","垫江县"),new Array("500232000000","武隆县"),new Array("500233000000","忠县"),new Array("500234000000","开县"),new Array("500235000000","云阳县"),new Array("500236000000","奉节县"),new Array("500237000000","巫山县"),new Array("500238000000","巫溪县"),new Array("500240000000","石柱土家族自治县"),new Array("500241000000","秀山土家族苗族自治县"),new Array("500242000000","酉阳土家族苗族自治县"),new Array("500243000000","彭水苗族土家族自治县"),new Array("50A100000000","重庆北部新区"),new Array("50A200000000","重庆市万盛经开区"));
CITY_I["510000000000"]=new Array(new Array("510100000000","成都市"),new Array("510300000000","自贡市"),new Array("510400000000","攀枝花市"),new Array("510500000000","泸州市"),new Array("510600000000","德阳市"),new Array("510700000000","绵阳市"),new Array("510800000000","广元市"),new Array("510900000000","遂宁市"),new Array("511000000000","内江市"),new Array("511100000000","乐山市"),new Array("511300000000","南充市"),new Array("511400000000","眉山市"),new Array("511500000000","宜宾市"),new Array("511600000000","广安市"),new Array("511700000000","达州市"),new Array("511800000000","雅安市"),new Array("511900000000","巴中市"),new Array("512000000000","资阳市"),new Array("513200000000","阿坝藏族羌族自治州"),new Array("513300000000","甘孜藏族自治州"),new Array("513400000000","凉山彝族自治州"));
CITY_II["510100000000"]=new Array(new Array("510104000000","锦江区"),new Array("510105000000","青羊区"),new Array("510106000000","金牛区"),new Array("510107000000","武侯区"),new Array("510108000000","成华区"),new Array("510112000000","龙泉驿区"),new Array("510113000000","青白江区"),new Array("510114000000","新都区"),new Array("510115000000","温江区"),new Array("510121000000","金堂县"),new Array("510122000000","双流县"),new Array("510124000000","郫县"),new Array("510129000000","大邑县"),new Array("510131000000","蒲江县"),new Array("510132000000","新津县"),new Array("510181000000","都江堰市"),new Array("510182000000","彭州市"),new Array("510183000000","邛崃市"),new Array("510184000000","崇州市"),new Array("5101A1000000","成都高新区"),new Array("5101A2000000","天府新区成都片区"));
CITY_II["510300000000"]=new Array(new Array("510302000000","自流井区"),new Array("510303000000","贡井区"),new Array("510304000000","大安区"),new Array("510311000000","沿滩区"),new Array("510321000000","荣县"),new Array("510322000000","富顺县"),new Array("5103A2000000","自贡高新区"));
CITY_II["510400000000"]=new Array(new Array("510402000000","东区"),new Array("510403000000","西区"),new Array("510411000000","仁和区"),new Array("510421000000","米易县"),new Array("510422000000","盐边县"));
CITY_II["510500000000"]=new Array(new Array("510502000000","江阳区"),new Array("510503000000","纳溪区"),new Array("510504000000","龙马潭区"),new Array("510521000000","泸县"),new Array("510522000000","合江县"),new Array("510524000000","叙永县"),new Array("510525000000","古蔺县"));
CITY_II["510600000000"]=new Array(new Array("510603000000","旌阳区"),new Array("510623000000","中江县"),new Array("510626000000","罗江县"),new Array("510681000000","广汉市"),new Array("510682000000","什邡市"),new Array("510683000000","绵竹市"),new Array("5106A1000000","德阳经济技术开发区"));
CITY_II["510700000000"]=new Array(new Array("510703000000","涪城区"),new Array("510704000000","游仙区"),new Array("510722000000","三台县"),new Array("510723000000","盐亭县"),new Array("510724000000","安县"),new Array("510725000000","梓潼县"),new Array("510726000000","北川羌族自治县"),new Array("510727000000","平武县"),new Array("510781000000","江油市"),new Array("5107A1000000","绵阳高新区"),new Array("5107A2000000","绵阳科创区"),new Array("5107A3000000","绵阳经开区"),new Array("5107A4000000","绵阳高新区"),new Array("5107A5000000","科学城"));
CITY_II["510800000000"]=new Array(new Array("510802000000","利州区"),new Array("510811000000","元坝区"),new Array("510812000000","朝天区"),new Array("510821000000","旺苍县"),new Array("510822000000","青川县"),new Array("510823000000","剑阁县"),new Array("510824000000","苍溪县"));
CITY_II["510900000000"]=new Array(new Array("510903000000","船山区"),new Array("510904000000","安居区"),new Array("510921000000","蓬溪县"),new Array("510922000000","射洪县"),new Array("510923000000","大英县"),new Array("5109A2000000","国开区"),new Array("5109A3000000","河东新区"));
CITY_II["511000000000"]=new Array(new Array("511002000000","市中区"),new Array("511011000000","东兴区"),new Array("511024000000","威远县"),new Array("511025000000","资中县"),new Array("511028000000","隆昌县"),new Array("5110A2000000","内江经济开发区"));
CITY_II["511100000000"]=new Array(new Array("511102000000","市中区"),new Array("511111000000","沙湾区"),new Array("511112000000","五通桥区"),new Array("511113000000","金口河区"),new Array("511123000000","犍为县"),new Array("511124000000","井研县"),new Array("511126000000","夹江县"),new Array("511129000000","沐川县"),new Array("511132000000","峨边彝族自治县"),new Array("511133000000","马边彝族自治县"),new Array("511181000000","峨眉山市"),new Array("5111A1000000","乐山高新区"));
CITY_II["511300000000"]=new Array(new Array("511302000000","顺庆区"),new Array("511303000000","高坪区"),new Array("511304000000","嘉陵区"),new Array("511321000000","南部县"),new Array("511322000000","营山县"),new Array("511323000000","蓬安县"),new Array("511324000000","仪陇县"),new Array("511325000000","西充县"),new Array("511381000000","阆中市"));
CITY_II["511400000000"]=new Array(new Array("511402000000","东坡区"),new Array("511421000000","仁寿县"),new Array("511422000000","彭山县"),new Array("511423000000","洪雅县"),new Array("511424000000","丹棱县"),new Array("511425000000","青神县"));
CITY_II["511500000000"]=new Array(new Array("511502000000","翠屏区"),new Array("511503000000","南溪区"),new Array("511521000000","宜宾县"),new Array("511523000000","江安县"),new Array("511524000000","长宁县"),new Array("511525000000","高县"),new Array("511526000000","珙县"),new Array("511527000000","筠连县"),new Array("511528000000","兴文县"),new Array("511529000000","屏山县"));
CITY_II["511600000000"]=new Array(new Array("511602000000","广安区"),new Array("511603000000","前锋区"),new Array("511621000000","岳池县"),new Array("511622000000","武胜县"),new Array("511623000000","邻水县"),new Array("511681000000","华蓥市"),new Array("5116A2000000","广安市前锋区"),new Array("5116A4000000","枣山园区"));
CITY_II["511700000000"]=new Array(new Array("511702000000","通川区"),new Array("511703000000","达川区"),new Array("511722000000","宣汉县"),new Array("511723000000","开江县"),new Array("511724000000","大竹县"),new Array("511725000000","渠县"),new Array("511781000000","万源市"),new Array("5117A1000000","达州经开区"));
CITY_II["511800000000"]=new Array(new Array("511802000000","雨城区"),new Array("511803000000","名山区"),new Array("511822000000","荥经县"),new Array("511823000000","汉源县"),new Array("511824000000","石棉县"),new Array("511825000000","天全县"),new Array("511826000000","芦山县"),new Array("511827000000","宝兴县"));
CITY_II["511900000000"]=new Array(new Array("511902000000","巴州区"),new Array("511903000000","恩阳区"),new Array("511921000000","通江县"),new Array("511922000000","南江县"),new Array("511923000000","平昌县"));
CITY_II["512000000000"]=new Array(new Array("512002000000","雁江区"),new Array("512021000000","安岳县"),new Array("512022000000","乐至县"),new Array("512081000000","简阳市"));
CITY_II["513200000000"]=new Array(new Array("513221000000","汶川县"),new Array("513222000000","理县"),new Array("513223000000","茂县"),new Array("513224000000","松潘县"),new Array("513225000000","九寨沟县"),new Array("513226000000","金川县"),new Array("513227000000","小金县"),new Array("513228000000","黑水县"),new Array("513229000000","马尔康县"),new Array("513230000000","壤塘县"),new Array("513231000000","阿坝县"),new Array("513232000000","若尔盖县"),new Array("513233000000","红原县"));
CITY_II["513300000000"]=new Array(new Array("513321000000","康定县"),new Array("513322000000","泸定县"),new Array("513323000000","丹巴县"),new Array("513324000000","九龙县"),new Array("513325000000","雅江县"),new Array("513326000000","道孚县"),new Array("513327000000","炉霍县"),new Array("513328000000","甘孜县"),new Array("513329000000","新龙县"),new Array("513330000000","德格县"),new Array("513331000000","白玉县"),new Array("513332000000","石渠县"),new Array("513333000000","色达县"),new Array("513334000000","理塘县"),new Array("513335000000","巴塘县"),new Array("513336000000","乡城县"),new Array("513337000000","稻城县"),new Array("513338000000","得荣县"));
CITY_II["513400000000"]=new Array(new Array("513401000000","西昌市"),new Array("513422000000","木里藏族自治县"),new Array("513423000000","盐源县"),new Array("513424000000","德昌县"),new Array("513425000000","会理县"),new Array("513426000000","会东县"),new Array("513427000000","宁南县"),new Array("513428000000","普格县"),new Array("513429000000","布拖县"),new Array("513430000000","金阳县"),new Array("513431000000","昭觉县"),new Array("513432000000","喜德县"),new Array("513433000000","冕宁县"),new Array("513434000000","越西县"),new Array("513435000000","甘洛县"),new Array("513436000000","美姑县"),new Array("513437000000","雷波县"));
CITY_I["520000000000"]=new Array(new Array("520100000000","贵阳市"),new Array("520200000000","六盘水市"),new Array("520300000000","遵义市"),new Array("520400000000","安顺市"),new Array("520500000000","毕节市"),new Array("520600000000","铜仁市"),new Array("522300000000","黔西南布依族苗族自治州"),new Array("522600000000","黔东南苗族侗族自治州"),new Array("522700000000","黔南布依族苗族自治州"),new Array("52A100000000","贵安新区"));
CITY_II["520100000000"]=new Array(new Array("520102000000","南明区"),new Array("520103000000","云岩区"),new Array("520111000000","花溪区"),new Array("520112000000","乌当区"),new Array("520113000000","白云区"),new Array("520115000000","观山湖区"),new Array("520121000000","开阳县"),new Array("520122000000","息烽县"),new Array("520123000000","修文县"),new Array("520181000000","清镇市"),new Array("5201A1000000","观山湖区"));
CITY_II["520200000000"]=new Array(new Array("520201000000","钟山区"),new Array("520203000000","六枝特区"),new Array("520221000000","水城县"),new Array("520222000000","盘县"));
CITY_II["520300000000"]=new Array(new Array("520302000000","红花岗区"),new Array("520303000000","汇川区"),new Array("520321000000","遵义县"),new Array("520322000000","桐梓县"),new Array("520323000000","绥阳县"),new Array("520324000000","正安县"),new Array("520325000000","道真仡佬族苗族自治县"),new Array("520326000000","务川仡佬族苗族自治县"),new Array("520327000000","凤冈县"),new Array("520328000000","湄潭县"),new Array("520329000000","余庆县"),new Array("520330000000","习水县"),new Array("520381000000","赤水市"),new Array("520382000000","仁怀市"),new Array("5203A1000000","新蒲新区"));
CITY_II["520400000000"]=new Array(new Array("520402000000","西秀区"),new Array("520421000000","平坝县"),new Array("520422000000","普定县"),new Array("520423000000","镇宁布依族苗族自治县"),new Array("520424000000","关岭布依族苗族自治县"),new Array("520425000000","紫云苗族布依族自治县"),new Array("5204A1000000","安顺市经济开发区"),new Array("5204A2000000","黄果树管委会"),new Array("5204A3000000","龙宫"));
CITY_II["520500000000"]=new Array(new Array("520502000000","七星关区"),new Array("520521000000","大方县"),new Array("520522000000","黔西县"),new Array("520523000000","金沙县"),new Array("520524000000","织金县"),new Array("520525000000","纳雍县"),new Array("520526000000","威宁彝族回族苗族自治县"),new Array("520527000000","赫章县"),new Array("5205A1000000","百里杜鹃"),new Array("5205A2000000","毕节经开区"),new Array("5205A3000000","双山新区"));
CITY_II["520600000000"]=new Array(new Array("520602000000","碧江区"),new Array("520603000000","万山区"),new Array("520621000000","江口县"),new Array("520622000000","玉屏侗族自治县"),new Array("520623000000","石阡县"),new Array("520624000000","思南县"),new Array("520625000000","印江土家族苗族自治县"),new Array("520626000000","德江县"),new Array("520627000000","沿河土家族自治县"),new Array("520628000000","松桃苗族自治县"));
CITY_II["522300000000"]=new Array(new Array("522301000000","兴义市"),new Array("522322000000","兴仁县"),new Array("522323000000","普安县"),new Array("522324000000","晴隆县"),new Array("522325000000","贞丰县"),new Array("522326000000","望谟县"),new Array("522327000000","册亨县"),new Array("522328000000","安龙县"),new Array("5223A1000000","义龙新区"));
CITY_II["522600000000"]=new Array(new Array("522601000000","凯里市"),new Array("522622000000","黄平县"),new Array("522623000000","施秉县"),new Array("522624000000","三穗县"),new Array("522625000000","镇远县"),new Array("522626000000","岑巩县"),new Array("522627000000","天柱县"),new Array("522628000000","锦屏县"),new Array("522629000000","剑河县"),new Array("522630000000","台江县"),new Array("522631000000","黎平县"),new Array("522632000000","榕江县"),new Array("522633000000","从江县"),new Array("522634000000","雷山县"),new Array("522635000000","麻江县"),new Array("522636000000","丹寨县"),new Array("5226A1000000","凯里经济开发区"));
CITY_II["522700000000"]=new Array(new Array("522701000000","都匀市"),new Array("522702000000","福泉市"),new Array("522722000000","荔波县"),new Array("522723000000","贵定县"),new Array("522725000000","瓮安县"),new Array("522726000000","独山县"),new Array("522727000000","平塘县"),new Array("522728000000","罗甸县"),new Array("522729000000","长顺县"),new Array("522730000000","龙里县"),new Array("522731000000","惠水县"),new Array("522732000000","三都水族自治县"),new Array("5227A1000000","都匀经开区"));
CITY_II["52A100000000"]=new Array(new Array("52A1A1000000","贵安新区本级"));
CITY_I["530000000000"]=new Array(new Array("530100000000","昆明市"),new Array("530300000000","曲靖市"),new Array("530400000000","玉溪市"),new Array("530500000000","保山市"),new Array("530600000000","昭通市"),new Array("530700000000","丽江市"),new Array("530800000000","思茅市"),new Array("530900000000","临沧市"),new Array("532300000000","楚雄彝族自治州"),new Array("532500000000","红河哈尼族彝族自治州"),new Array("532600000000","文山壮族苗族自治州"),new Array("532800000000","西双版纳傣族自治州"),new Array("532900000000","大理白族自治州"),new Array("533100000000","德宏傣族景颇族自治州"),new Array("533300000000","怒江傈僳族自治州"),new Array("533400000000","迪庆藏族自治州"));
CITY_II["530100000000"]=new Array(new Array("530102000000","五华区"),new Array("530103000000","盘龙区"),new Array("530111000000","官渡区"),new Array("530112000000","西山区"),new Array("530113000000","东川区"),new Array("530114000000","呈贡区"),new Array("530122000000","晋宁县"),new Array("530124000000","富民县"),new Array("530125000000","宜良县"),new Array("530126000000","石林彝族自治县"),new Array("530127000000","嵩明县"),new Array("530128000000","禄劝彝族苗族自治县"),new Array("530129000000","寻甸回族彝族自治县"),new Array("530181000000","安宁市"),new Array("5301A1000000","阳宗海"),new Array("5301A2000000","度假区"),new Array("5301A3000000","倘甸"));
CITY_II["530300000000"]=new Array(new Array("530302000000","麒麟区"),new Array("530321000000","马龙县"),new Array("530322000000","陆良县"),new Array("530323000000","师宗县"),new Array("530324000000","罗平县"),new Array("530325000000","富源县"),new Array("530326000000","会泽县"),new Array("530328000000","沾益县"),new Array("530381000000","宣威市"));
CITY_II["530400000000"]=new Array(new Array("530402000000","红塔区"),new Array("530421000000","江川县"),new Array("530422000000","澄江县"),new Array("530423000000","通海县"),new Array("530424000000","华宁县"),new Array("530425000000","易门县"),new Array("530426000000","峨山彝族自治县"),new Array("530427000000","新平彝族傣族自治县"),new Array("530428000000","元江哈尼族彝族傣族自治县"));
CITY_II["530500000000"]=new Array(new Array("530502000000","隆阳区"),new Array("530521000000","施甸县"),new Array("530522000000","腾冲县"),new Array("530523000000","龙陵县"),new Array("530524000000","昌宁县"));
CITY_II["530600000000"]=new Array(new Array("530602000000","昭阳区"),new Array("530621000000","鲁甸县"),new Array("530622000000","巧家县"),new Array("530623000000","盐津县"),new Array("530624000000","大关县"),new Array("530625000000","永善县"),new Array("530626000000","绥江县"),new Array("530627000000","镇雄县"),new Array("530628000000","彝良县"),new Array("530629000000","威信县"),new Array("530630000000","水富县"));
CITY_II["530700000000"]=new Array(new Array("530702000000","古城区"),new Array("530721000000","玉龙纳西族自治县"),new Array("530722000000","永胜县"),new Array("530723000000","华坪县"),new Array("530724000000","宁蒗彝族自治县"));
CITY_II["530800000000"]=new Array(new Array("530802000000","思茅区"),new Array("530821000000","宁洱哈尼族彝族自治县"),new Array("530822000000","墨江哈尼族自治县"),new Array("530823000000","景东彝族自治县"),new Array("530824000000","景谷傣族彝族自治县"),new Array("530825000000","镇沅彝族哈尼族拉祜族自治县"),new Array("530826000000","江城哈尼族彝族自治县"),new Array("530827000000","孟连傣族拉祜族佤族自治县"),new Array("530828000000","澜沧拉祜族自治县"),new Array("530829000000","西盟佤族自治县"));
CITY_II["530900000000"]=new Array(new Array("530902000000","临翔区"),new Array("530921000000","凤庆县"),new Array("530922000000","云县"),new Array("530923000000","永德县"),new Array("530924000000","镇康县"),new Array("530925000000","双江拉祜族佤族布朗族傣族自治县"),new Array("530926000000","耿马傣族佤族自治县"),new Array("530927000000","沧源佤族自治县"));
CITY_II["532300000000"]=new Array(new Array("532301000000","楚雄市"),new Array("532322000000","双柏县"),new Array("532323000000","牟定县"),new Array("532324000000","南华县"),new Array("532325000000","姚安县"),new Array("532326000000","大姚县"),new Array("532327000000","永仁县"),new Array("532328000000","元谋县"),new Array("532329000000","武定县"),new Array("532331000000","禄丰县"));
CITY_II["532500000000"]=new Array(new Array("532501000000","个旧市"),new Array("532502000000","开远市"),new Array("532503000000","蒙自市"),new Array("532504000000","弥勒市"),new Array("532523000000","屏边苗族自治县"),new Array("532524000000","建水县"),new Array("532525000000","石屏县"),new Array("532527000000","泸西县"),new Array("532528000000","元阳县"),new Array("532529000000","红河县"),new Array("532530000000","金平苗族瑶族傣族自治县"),new Array("532531000000","绿春县"),new Array("532532000000","河口瑶族自治县"));
CITY_II["532600000000"]=new Array(new Array("532601000000","文山市"),new Array("532622000000","砚山县"),new Array("532623000000","西畴县"),new Array("532624000000","麻栗坡县"),new Array("532625000000","马关县"),new Array("532626000000","丘北县"),new Array("532627000000","广南县"),new Array("532628000000","富宁县"));
CITY_II["532800000000"]=new Array(new Array("532801000000","景洪市"),new Array("532822000000","勐海县"),new Array("532823000000","勐腊县"));
CITY_II["532900000000"]=new Array(new Array("532901000000","大理市"),new Array("532922000000","漾濞彝族自治县"),new Array("532923000000","祥云县"),new Array("532924000000","宾川县"),new Array("532925000000","弥渡县"),new Array("532926000000","南涧彝族自治县"),new Array("532927000000","巍山彝族回族自治县"),new Array("532928000000","永平县"),new Array("532929000000","云龙县"),new Array("532930000000","洱源县"),new Array("532931000000","剑川县"),new Array("532932000000","鹤庆县"));
CITY_II["533100000000"]=new Array(new Array("533102000000","瑞丽市"),new Array("533103000000","芒市"),new Array("533122000000","梁河县"),new Array("533123000000","盈江县"),new Array("533124000000","陇川县"));
CITY_II["533300000000"]=new Array(new Array("533321000000","泸水县"),new Array("533323000000","福贡县"),new Array("533324000000","贡山独龙族怒族自治县"),new Array("533325000000","兰坪白族普米族自治县"));
CITY_II["533400000000"]=new Array(new Array("533421000000","香格里拉县"),new Array("533422000000","德钦县"),new Array("533423000000","维西傈僳族自治县"));
CITY_I["540000000000"]=new Array(new Array("540100000000","拉萨市"),new Array("542100000000","昌都地区"),new Array("542200000000","山南地区"),new Array("542300000000","日喀则地区"),new Array("542400000000","那曲地区"),new Array("542500000000","阿里地区"),new Array("542600000000","林芝地区"),new Array("54A100000000","西藏自治区"));
CITY_II["540100000000"]=new Array(new Array("540102000000","城关区"),new Array("540121000000","林周县"),new Array("540122000000","当雄县"),new Array("540123000000","尼木县"),new Array("540124000000","曲水县"),new Array("540125000000","堆龙德庆县"),new Array("540126000000","达孜县"),new Array("540127000000","墨竹工卡县"),new Array("5401A1000000","　"));
CITY_II["542100000000"]=new Array(new Array("542121000000","昌都县"),new Array("542122000000","江达县"),new Array("542123000000","贡觉县"),new Array("542124000000","类乌齐县"),new Array("542125000000","丁青县"),new Array("542126000000","察雅县"),new Array("542127000000","八宿县"),new Array("542128000000","左贡县"),new Array("542129000000","芒康县"),new Array("542132000000","洛隆县"),new Array("542133000000","边坝县"),new Array("5421A1000000","西藏自治区昌都地区直属"));
CITY_II["542200000000"]=new Array(new Array("542221000000","乃东县"),new Array("542222000000","扎囊县"),new Array("542223000000","贡嘎县"),new Array("542224000000","桑日县"),new Array("542225000000","琼结县"),new Array("542226000000","曲松县"),new Array("542227000000","措美县"),new Array("542228000000","洛扎县"),new Array("542229000000","加查县"),new Array("542231000000","隆子县"),new Array("542232000000","错那县"),new Array("542233000000","浪卡子县"),new Array("5422A1000000","　"));
CITY_II["542300000000"]=new Array(new Array("542301000000","日喀则市"),new Array("542322000000","南木林县"),new Array("542323000000","江孜县"),new Array("542324000000","定日县"),new Array("542325000000","萨迦县"),new Array("542326000000","拉孜县"),new Array("542327000000","昂仁县"),new Array("542328000000","谢通门县"),new Array("542329000000","白朗县"),new Array("542330000000","仁布县"),new Array("542331000000","康马县"),new Array("542332000000","定结县"),new Array("542333000000","仲巴县"),new Array("542334000000","亚东县"),new Array("542335000000","吉隆县"),new Array("542336000000","聂拉木县"),new Array("542337000000","萨嘎县"),new Array("542338000000","岗巴县"),new Array("5423A1000000","　"));
CITY_II["542400000000"]=new Array(new Array("542421000000","那曲县"),new Array("542422000000","嘉黎县"),new Array("542423000000","比如县"),new Array("542424000000","聂荣县"),new Array("542425000000","安多县"),new Array("542426000000","申扎县"),new Array("542427000000","索县"),new Array("542428000000","班戈县"),new Array("542429000000","巴青县"),new Array("542430000000","尼玛县"),new Array("542431000000","双湖县"),new Array("5424A1000000","西藏自治区那曲地区双湖县"),new Array("5424A2000000","西藏自治区那曲地区直属"));
CITY_II["542500000000"]=new Array(new Array("542521000000","普兰县"),new Array("542522000000","札达县"),new Array("542523000000","噶尔县"),new Array("542524000000","日土县"),new Array("542525000000","革吉县"),new Array("542526000000","改则县"),new Array("542527000000","措勤县"),new Array("5425A1000000","西藏自治区阿里地区直属"));
CITY_II["542600000000"]=new Array(new Array("542621000000","林芝县"),new Array("542622000000","工布江达县"),new Array("542623000000","米林县"),new Array("542624000000","墨脱县"),new Array("542625000000","波密县"),new Array("542626000000","察隅县"),new Array("542627000000","朗县"),new Array("5426A1000000","　"));
CITY_II["54A100000000"]=new Array(new Array("54A1A1000000","西藏自治区西格办直属"),new Array("54A1A2000000","西藏自治区民院附中直属"),new Array("54A1A3000000","西藏自治区教育厅厅直属"));
CITY_I["610000000000"]=new Array(new Array("610100000000","西安市"),new Array("610200000000","铜川市"),new Array("610300000000","宝鸡市"),new Array("610400000000","咸阳市"),new Array("610500000000","渭南市"),new Array("610600000000","延安市"),new Array("610700000000","汉中市"),new Array("610800000000","榆林市"),new Array("610900000000","安康市"),new Array("611000000000","商洛市"),new Array("61A100000000","杨凌示范区"));
CITY_II["610100000000"]=new Array(new Array("610102000000","新城区"),new Array("610103000000","碑林区"),new Array("610104000000","莲湖区"),new Array("610111000000","灞桥区"),new Array("610112000000","未央区"),new Array("610113000000","雁塔区"),new Array("610114000000","阎良区"),new Array("610115000000","临潼区"),new Array("610116000000","长安区"),new Array("610122000000","蓝田县"),new Array("610124000000","周至县"),new Array("610125000000","户县"),new Array("610126000000","高陵县"),new Array("6101A1000000","沣东新城"));
CITY_II["610200000000"]=new Array(new Array("610202000000","王益区"),new Array("610203000000","印台区"),new Array("610204000000","耀州区"),new Array("610222000000","宜君县"),new Array("6102A1000000","新区"));
CITY_II["610300000000"]=new Array(new Array("610302000000","渭滨区"),new Array("610303000000","金台区"),new Array("610304000000","陈仓区"),new Array("610322000000","凤翔县"),new Array("610323000000","岐山县"),new Array("610324000000","扶风县"),new Array("610326000000","眉县"),new Array("610327000000","陇县"),new Array("610328000000","千阳县"),new Array("610329000000","麟游县"),new Array("610330000000","凤县"),new Array("610331000000","太白县"),new Array("6103A1000000","高新区"));
CITY_II["610400000000"]=new Array(new Array("610402000000","秦都区"),new Array("610403000000","杨陵区"),new Array("610404000000","渭城区"),new Array("610422000000","三原县"),new Array("610423000000","泾阳县"),new Array("610424000000","乾县"),new Array("610425000000","礼泉县"),new Array("610426000000","永寿县"),new Array("610427000000","彬县"),new Array("610428000000","长武县"),new Array("610429000000","旬邑县"),new Array("610430000000","淳化县"),new Array("610431000000","武功县"),new Array("610481000000","兴平市"));
CITY_II["610500000000"]=new Array(new Array("610502000000","临渭区"),new Array("610521000000","华县"),new Array("610522000000","潼关县"),new Array("610523000000","大荔县"),new Array("610524000000","合阳县"),new Array("610525000000","澄城县"),new Array("610526000000","蒲城县"),new Array("610527000000","白水县"),new Array("610528000000","富平县"),new Array("610581000000","韩城市"),new Array("610582000000","华阴市"),new Array("6105A1000000","渭南市高新区"),new Array("6105A2000000","渭南市经开区"));
CITY_II["610600000000"]=new Array(new Array("610602000000","宝塔区"),new Array("610621000000","延长县"),new Array("610622000000","延川县"),new Array("610623000000","子长县"),new Array("610624000000","安塞县"),new Array("610625000000","志丹县"),new Array("610626000000","吴起县"),new Array("610627000000","甘泉县"),new Array("610628000000","富县"),new Array("610629000000","洛川县"),new Array("610630000000","宜川县"),new Array("610631000000","黄龙县"),new Array("610632000000","黄陵县"));
CITY_II["610700000000"]=new Array(new Array("610702000000","汉台区"),new Array("610721000000","南郑县"),new Array("610722000000","城固县"),new Array("610723000000","洋县"),new Array("610724000000","西乡县"),new Array("610725000000","勉县"),new Array("610726000000","宁强县"),new Array("610727000000","略阳县"),new Array("610728000000","镇巴县"),new Array("610729000000","留坝县"),new Array("610730000000","佛坪县"));
CITY_II["610800000000"]=new Array(new Array("610802000000","榆阳区"),new Array("610821000000","神木县"),new Array("610822000000","府谷县"),new Array("610823000000","横山县"),new Array("610824000000","靖边县"),new Array("610825000000","定边县"),new Array("610826000000","绥德县"),new Array("610827000000","米脂县"),new Array("610828000000","佳县"),new Array("610829000000","吴堡县"),new Array("610830000000","清涧县"),new Array("610831000000","子洲县"),new Array("6108A1000000","榆林市高新区"));
CITY_II["610900000000"]=new Array(new Array("610902000000","汉滨区"),new Array("610921000000","汉阴县"),new Array("610922000000","石泉县"),new Array("610923000000","宁陕县"),new Array("610924000000","紫阳县"),new Array("610925000000","岚皋县"),new Array("610926000000","平利县"),new Array("610927000000","镇坪县"),new Array("610928000000","旬阳县"),new Array("610929000000","白河县"),new Array("6109A1000000","高新区"));
CITY_II["611000000000"]=new Array(new Array("611002000000","商州区"),new Array("611021000000","洛南县"),new Array("611022000000","丹凤县"),new Array("611023000000","商南县"),new Array("611024000000","山阳县"),new Array("611025000000","镇安县"),new Array("611026000000","柞水县"));
CITY_II["61A100000000"]=new Array(new Array("61A1A1000000","杨陵区"));
CITY_I["620000000000"]=new Array(new Array("620100000000","兰州市"),new Array("620200000000","嘉峪关市"),new Array("620300000000","金昌市"),new Array("620400000000","白银市"),new Array("620500000000","天水市"),new Array("620600000000","武威市"),new Array("620700000000","张掖市"),new Array("620800000000","平凉市"),new Array("620900000000","酒泉市"),new Array("621000000000","庆阳市"),new Array("621100000000","定西市"),new Array("621200000000","陇南市"),new Array("622900000000","临夏回族自治州"),new Array("623000000000","甘南藏族自治州"));
CITY_II["620100000000"]=new Array(new Array("620102000000","城关区"),new Array("620103000000","七里河区"),new Array("620104000000","西固区"),new Array("620105000000","安宁区"),new Array("620111000000","红古区"),new Array("620121000000","永登县"),new Array("620122000000","皋兰县"),new Array("620123000000","榆中县"),new Array("6201A1000000","兰州新区"));
CITY_II["620300000000"]=new Array(new Array("620302000000","金川区"),new Array("620321000000","永昌县"));
CITY_II["620400000000"]=new Array(new Array("620402000000","白银区"),new Array("620403000000","平川区"),new Array("620421000000","靖远县"),new Array("620422000000","会宁县"),new Array("620423000000","景泰县"));
CITY_II["620500000000"]=new Array(new Array("620502000000","秦州区"),new Array("620503000000","麦积区"),new Array("620521000000","清水县"),new Array("620522000000","秦安县"),new Array("620523000000","甘谷县"),new Array("620524000000","武山县"),new Array("620525000000","张家川回族自治县"));
CITY_II["620600000000"]=new Array(new Array("620602000000","凉州区"),new Array("620621000000","民勤县"),new Array("620622000000","古浪县"),new Array("620623000000","天祝藏族自治县"));
CITY_II["620700000000"]=new Array(new Array("620702000000","甘州区"),new Array("620721000000","肃南裕固族自治县"),new Array("620722000000","民乐县"),new Array("620723000000","临泽县"),new Array("620724000000","高台县"),new Array("620725000000","山丹县"));
CITY_II["620800000000"]=new Array(new Array("620802000000","崆峒区"),new Array("620821000000","泾川县"),new Array("620822000000","灵台县"),new Array("620823000000","崇信县"),new Array("620824000000","华亭县"),new Array("620825000000","庄浪县"),new Array("620826000000","静宁县"));
CITY_II["620900000000"]=new Array(new Array("620902000000","肃州区"),new Array("620921000000","金塔县"),new Array("620922000000","瓜州县"),new Array("620923000000","肃北蒙古族自治县"),new Array("620924000000","阿克塞哈萨克族自治县"),new Array("620981000000","玉门市"),new Array("620982000000","敦煌市"),new Array("6209A1000000","玉门油田"));
CITY_II["621000000000"]=new Array(new Array("621002000000","西峰区"),new Array("621021000000","庆城县"),new Array("621022000000","环县"),new Array("621023000000","华池县"),new Array("621024000000","合水县"),new Array("621025000000","正宁县"),new Array("621026000000","宁县"),new Array("621027000000","镇原县"));
CITY_II["621100000000"]=new Array(new Array("621102000000","安定区"),new Array("621121000000","通渭县"),new Array("621122000000","陇西县"),new Array("621123000000","渭源县"),new Array("621124000000","临洮县"),new Array("621125000000","漳县"),new Array("621126000000","岷县"));
CITY_II["621200000000"]=new Array(new Array("621202000000","武都区"),new Array("621221000000","成县"),new Array("621222000000","文县"),new Array("621223000000","宕昌县"),new Array("621224000000","康县"),new Array("621225000000","西和县"),new Array("621226000000","礼县"),new Array("621227000000","徽县"),new Array("621228000000","两当县"));
CITY_II["622900000000"]=new Array(new Array("622901000000","临夏市"),new Array("622921000000","临夏县"),new Array("622922000000","康乐县"),new Array("622923000000","永靖县"),new Array("622924000000","广河县"),new Array("622925000000","和政县"),new Array("622926000000","东乡族自治县"),new Array("622927000000","积石山保安族东乡族撒拉族自治县"));
CITY_II["623000000000"]=new Array(new Array("623001000000","合作市"),new Array("623021000000","临潭县"),new Array("623022000000","卓尼县"),new Array("623023000000","舟曲县"),new Array("623024000000","迭部县"),new Array("623025000000","玛曲县"),new Array("623026000000","碌曲县"),new Array("623027000000","夏河县"));
CITY_I["630000000000"]=new Array(new Array("630100000000","西宁市"),new Array("630200000000","海东市"),new Array("632200000000","海北藏族自治州"),new Array("632300000000","黄南藏族自治州"),new Array("632500000000","海南藏族自治州"),new Array("632600000000","果洛藏族自治州"),new Array("632700000000","玉树藏族自治州"),new Array("632800000000","海西蒙古族藏族自治州"));
CITY_II["630100000000"]=new Array(new Array("630102000000","城东区"),new Array("630103000000","城中区"),new Array("630104000000","城西区"),new Array("630105000000","城北区"),new Array("630121000000","大通回族土族自治县"),new Array("630122000000","湟中县"),new Array("630123000000","湟源县"));
CITY_II["630200000000"]=new Array(new Array("630202000000","乐都区"),new Array("630221000000","平安县"),new Array("630222000000","民和回族土族自治县"),new Array("630223000000","互助土族自治县"),new Array("630224000000","化隆回族自治县"),new Array("630225000000","循化撒拉族自治县"));
CITY_II["632200000000"]=new Array(new Array("632221000000","门源回族自治县"),new Array("632222000000","祁连县"),new Array("632223000000","海晏县"),new Array("632224000000","刚察县"));
CITY_II["632300000000"]=new Array(new Array("632321000000","同仁县"),new Array("632322000000","尖扎县"),new Array("632323000000","泽库县"),new Array("632324000000","河南蒙古族自治县"));
CITY_II["632500000000"]=new Array(new Array("632521000000","共和县"),new Array("632522000000","同德县"),new Array("632523000000","贵德县"),new Array("632524000000","兴海县"),new Array("632525000000","贵南县"));
CITY_II["632600000000"]=new Array(new Array("632621000000","玛沁县"),new Array("632622000000","班玛县"),new Array("632623000000","甘德县"),new Array("632624000000","达日县"),new Array("632625000000","久治县"),new Array("632626000000","玛多县"));
CITY_II["632700000000"]=new Array(new Array("632701000000","玉树市"),new Array("632722000000","杂多县"),new Array("632723000000","称多县"),new Array("632724000000","治多县"),new Array("632725000000","囊谦县"),new Array("632726000000","曲麻莱县"));
CITY_II["632800000000"]=new Array(new Array("632801000000","格尔木市"),new Array("632802000000","德令哈市"),new Array("632821000000","乌兰县"),new Array("632822000000","都兰县"),new Array("632823000000","天峻县"),new Array("6328A1000000","大柴旦行委"),new Array("6328A2000000","冷湖行委"),new Array("6328A3000000","茫崖行委"),new Array("6328A4000000","青海油田"));
CITY_I["640000000000"]=new Array(new Array("640100000000","银川市"),new Array("640200000000","石嘴山市"),new Array("640300000000","吴忠市"),new Array("640400000000","固原市"),new Array("640500000000","中卫市"));
CITY_II["640100000000"]=new Array(new Array("640104000000","兴庆区"),new Array("640105000000","西夏区"),new Array("640106000000","金凤区"),new Array("640121000000","永宁县"),new Array("640122000000","贺兰县"),new Array("640181000000","灵武市"));
CITY_II["640200000000"]=new Array(new Array("640202000000","大武口区"),new Array("640205000000","惠农区"),new Array("640221000000","平罗县"));
CITY_II["640300000000"]=new Array(new Array("640302000000","利通区"),new Array("640303000000","红寺堡区"),new Array("640323000000","盐池县"),new Array("640324000000","同心县"),new Array("640381000000","青铜峡市"));
CITY_II["640400000000"]=new Array(new Array("640402000000","原州区"),new Array("640422000000","西吉县"),new Array("640423000000","隆德县"),new Array("640424000000","泾源县"),new Array("640425000000","彭阳县"));
CITY_II["640500000000"]=new Array(new Array("640502000000","沙坡头区"),new Array("640521000000","中宁县"),new Array("640522000000","海原县"));
CITY_I["650000000000"]=new Array(new Array("650100000000","乌鲁木齐市"),new Array("650200000000","克拉玛依市"),new Array("652100000000","吐鲁番地区"),new Array("652200000000","哈密地区"),new Array("652300000000","昌吉回族自治州"),new Array("652700000000","博尔塔拉蒙古自治州"),new Array("652800000000","巴音郭楞蒙古自治州"),new Array("652900000000","阿克苏地区"),new Array("653000000000","克孜勒苏柯尔克孜自治州"),new Array("653100000000","喀什地区"),new Array("653200000000","和田地区"),new Array("654000000000","伊犁哈萨克自治州"),new Array("654200000000","塔城地区"),new Array("654300000000","阿勒泰地区"),new Array("659001000000","石河子市"),new Array("659002000000","阿拉尔市"),new Array("659003000000","图木舒克市"),new Array("659004000000","五家渠市"));
CITY_II["650100000000"]=new Array(new Array("650102000000","天山区"),new Array("650103000000","沙依巴克区"),new Array("650104000000","新市区"),new Array("650105000000","水磨沟区"),new Array("650106000000","头屯河区"),new Array("650107000000","达坂城区"),new Array("650109000000","米东区"),new Array("650121000000","乌鲁木齐县"));
CITY_II["650200000000"]=new Array(new Array("650202000000","独山子区"),new Array("650203000000","克拉玛依区"),new Array("650204000000","白碱滩区"),new Array("650205000000","乌尔禾区"));
CITY_II["652100000000"]=new Array(new Array("652101000000","吐鲁番市"),new Array("652122000000","鄯善县"),new Array("652123000000","托克逊县"));
CITY_II["652200000000"]=new Array(new Array("652201000000","哈密市"),new Array("652222000000","巴里坤哈萨克自治县"),new Array("652223000000","伊吾县"));
CITY_II["652300000000"]=new Array(new Array("652301000000","昌吉市"),new Array("652302000000","阜康市"),new Array("652323000000","呼图壁县"),new Array("652324000000","玛纳斯县"),new Array("652325000000","奇台县"),new Array("652327000000","吉木萨尔县"),new Array("652328000000","木垒哈萨克自治县"));
CITY_II["652700000000"]=new Array(new Array("652701000000","博乐市"),new Array("652702000000","阿拉山口市"),new Array("652722000000","精河县"),new Array("652723000000","温泉县"));
CITY_II["652800000000"]=new Array(new Array("652801000000","库尔勒市"),new Array("652822000000","轮台县"),new Array("652823000000","尉犁县"),new Array("652824000000","若羌县"),new Array("652825000000","且末县"),new Array("652826000000","焉耆回族自治县"),new Array("652827000000","和静县"),new Array("652828000000","和硕县"),new Array("652829000000","博湖县"));
CITY_II["652900000000"]=new Array(new Array("652901000000","阿克苏市"),new Array("652922000000","温宿县"),new Array("652923000000","库车县"),new Array("652924000000","沙雅县"),new Array("652925000000","新和县"),new Array("652926000000","拜城县"),new Array("652927000000","乌什县"),new Array("652928000000","阿瓦提县"),new Array("652929000000","柯坪县"));
CITY_II["653000000000"]=new Array(new Array("653001000000","阿图什市"),new Array("653022000000","阿克陶县"),new Array("653023000000","阿合奇县"),new Array("653024000000","乌恰县"));
CITY_II["653100000000"]=new Array(new Array("653101000000","喀什市"),new Array("653121000000","疏附县"),new Array("653122000000","疏勒县"),new Array("653123000000","英吉沙县"),new Array("653124000000","泽普县"),new Array("653125000000","莎车县"),new Array("653126000000","叶城县"),new Array("653127000000","麦盖提县"),new Array("653128000000","岳普湖县"),new Array("653129000000","伽师县"),new Array("653130000000","巴楚县"),new Array("653131000000","塔什库尔干塔吉克自治县"));
CITY_II["653200000000"]=new Array(new Array("653201000000","和田市"),new Array("653221000000","和田县"),new Array("653222000000","墨玉县"),new Array("653223000000","皮山县"),new Array("653224000000","洛浦县"),new Array("653225000000","策勒县"),new Array("653226000000","于田县"),new Array("653227000000","民丰县"));
CITY_II["654000000000"]=new Array(new Array("654002000000","伊宁市"),new Array("654003000000","奎屯市"),new Array("654021000000","伊宁县"),new Array("654022000000","察布查尔锡伯自治县"),new Array("654023000000","霍城县"),new Array("654024000000","巩留县"),new Array("654025000000","新源县"),new Array("654026000000","昭苏县"),new Array("654027000000","特克斯县"),new Array("654028000000","尼勒克县"));
CITY_II["654200000000"]=new Array(new Array("654201000000","塔城市"),new Array("654202000000","乌苏市"),new Array("654221000000","额敏县"),new Array("654223000000","沙湾县"),new Array("654224000000","托里县"),new Array("654225000000","裕民县"),new Array("654226000000","和布克赛尔蒙古自治县"));
CITY_II["654300000000"]=new Array(new Array("654301000000","阿勒泰市"),new Array("654321000000","布尔津县"),new Array("654322000000","富蕴县"),new Array("654323000000","福海县"),new Array("654324000000","哈巴河县"),new Array("654325000000","青河县"),new Array("654326000000","吉木乃县"));
CITY_I["6A0000000000"]=new Array(new Array("6AA100000000","第一师"),new Array("6AA200000000","第二师"),new Array("6AA300000000","第三师"),new Array("6AA400000000","第四师"),new Array("6AA500000000","第五师"),new Array("6AA600000000","第六师"),new Array("6AA700000000","第七师"),new Array("6AA800000000","第八师"),new Array("6AA900000000","第九师"),new Array("6AB100000000","第十师"),new Array("6AB200000000","建工师"),new Array("6AB300000000","第十二师"),new Array("6AB400000000","第十三师"),new Array("6AB500000000","第十四师"),new Array("6AB600000000","兵团直属"));
CITY_II["6AA100000000"]=new Array(new Array("6AA1A1000000","1团"),new Array("6AA1A2000000","2团"),new Array("6AA1A3000000","3团"),new Array("6AA1A4000000","4团"),new Array("6AA1A5000000","5团"),new Array("6AA1A6000000","6团"),new Array("6AA1A7000000","7团"),new Array("6AA1A8000000","8团"),new Array("6AA1A9000000","10团"),new Array("6AA1B1000000","11团"),new Array("6AA1B2000000","12团"),new Array("6AA1B3000000","13团"),new Array("6AA1B4000000","14团"),new Array("6AA1B5000000","16团"),new Array("6AA1B6000000","塔水处"),new Array("6AA1B7000000","水工处"),new Array("6AA1B8000000","直属"));
CITY_II["6AA200000000"]=new Array(new Array("6AA2A1000000","21团"),new Array("6AA2A2000000","22团"),new Array("6AA2A3000000","23团"),new Array("6AA2A4000000","24团"),new Array("6AA2A5000000","25团"),new Array("6AA2A6000000","26团"),new Array("6AA2A7000000","27团"),new Array("6AA2A8000000","28团"),new Array("6AA2A9000000","29团"),new Array("6AA2B1000000","30团"),new Array("6AA2B2000000","31团"),new Array("6AA2B3000000","32团"),new Array("6AA2B4000000","33团"),new Array("6AA2B5000000","34团"),new Array("6AA2B6000000","35团"),new Array("6AA2B7000000","36团"),new Array("6AA2B8000000","38团"),new Array("6AA2B9000000","223团"),new Array("6AA2C1000000","且末支队"),new Array("6AA2C2000000","直属"));
CITY_II["6AA300000000"]=new Array(new Array("6AA3A1000000","41团"),new Array("6AA3A2000000","42团"),new Array("6AA3A3000000","44团"),new Array("6AA3A4000000","45团"),new Array("6AA3A5000000","46团"),new Array("6AA3A6000000","48团"),new Array("6AA3A7000000","49团"),new Array("6AA3A8000000","50团"),new Array("6AA3A9000000","51团"),new Array("6AA3B1000000","53团"),new Array("6AA3B2000000","伽师总场"),new Array("6AA3B3000000","东风农场"),new Array("6AA3B4000000","红旗农场"),new Array("6AA3B5000000","托云牧场"),new Array("6AA3B6000000","叶城二牧场"),new Array("6AA3B7000000","直属"));
CITY_II["6AA400000000"]=new Array(new Array("6AA4A1000000","61团"),new Array("6AA4A2000000","62团"),new Array("6AA4A3000000","63团"),new Array("6AA4A4000000","64团"),new Array("6AA4A5000000","65团"),new Array("6AA4A6000000","66团"),new Array("6AA4A7000000","67团"),new Array("6AA4A8000000","68团"),new Array("6AA4A9000000","69团"),new Array("6AA4B1000000","70团"),new Array("6AA4B2000000","71团"),new Array("6AA4B3000000","72团"),new Array("6AA4B4000000","73团"),new Array("6AA4B5000000","74团"),new Array("6AA4B6000000","75团"),new Array("6AA4B7000000","76团"),new Array("6AA4B8000000","77团"),new Array("6AA4B9000000","78团"),new Array("6AA4C1000000","79团"),new Array("6AA4C2000000","拜什墩农场"),new Array("6AA4C3000000","良繁场"),new Array("6AA4C4000000","直属"));
CITY_II["6AA500000000"]=new Array(new Array("6AA5A1000000","81团"),new Array("6AA5A2000000","82团"),new Array("6AA5A3000000","83团"),new Array("6AA5A4000000","84团"),new Array("6AA5A5000000","85团"),new Array("6AA5A6000000","86团"),new Array("6AA5A7000000","87团"),new Array("6AA5A8000000","88团"),new Array("6AA5A9000000","89团"),new Array("6AA5B1000000","90团"),new Array("6AA5B2000000","91团"),new Array("6AA5B3000000","直属"));
CITY_II["6AA600000000"]=new Array(new Array("6AA6A1000000","101团"),new Array("6AA6A2000000","102团"),new Array("6AA6A3000000","103团"),new Array("6AA6A4000000","105团"),new Array("6AA6A5000000","106团"),new Array("6AA6A6000000","芳草湖农场"),new Array("6AA6A7000000","新湖农场"),new Array("6AA6A8000000","军户农场"),new Array("6AA6A9000000","共青团农场"),new Array("6AA6B1000000","六运湖农场"),new Array("6AA6B2000000","土墩子农场"),new Array("6AA6B3000000","红旗农场"),new Array("6AA6B4000000","奇台农场"),new Array("6AA6B5000000","北塔山牧场"),new Array("6AA6B6000000","大黄山社区"),new Array("6AA6B7000000","十三户社区"),new Array("6AA6B8000000","直属"));
CITY_II["6AA700000000"]=new Array(new Array("6AA7A1000000","123团"),new Array("6AA7A2000000","124团"),new Array("6AA7A3000000","125团"),new Array("6AA7A4000000","126团"),new Array("6AA7A5000000","127团"),new Array("6AA7A6000000","128团"),new Array("6AA7A7000000","129团"),new Array("6AA7A8000000","130团"),new Array("6AA7A9000000","131团"),new Array("6AA7B1000000","137团"),new Array("6AA7B2000000","直属"));
CITY_II["6AA800000000"]=new Array(new Array("6AA8A1000000","121团"),new Array("6AA8A2000000","132团"),new Array("6AA8A3000000","133团"),new Array("6AA8A4000000","134团"),new Array("6AA8A5000000","135团"),new Array("6AA8A6000000","136团"),new Array("6AA8A7000000","141团"),new Array("6AA8A8000000","142团"),new Array("6AA8A9000000","143团"),new Array("6AA8B1000000","144团"),new Array("6AA8B2000000","石总场"),new Array("6AA8B3000000","147团"),new Array("6AA8B4000000","148团"),new Array("6AA8B5000000","149团"),new Array("6AA8B6000000","150团"),new Array("6AA8B7000000","151团"),new Array("6AA8B8000000","152团"),new Array("6AA8B9000000","直属"));
CITY_II["6AA900000000"]=new Array(new Array("6AA9A1000000","161团"),new Array("6AA9A2000000","162团"),new Array("6AA9A3000000","163团"),new Array("6AA9A4000000","164团"),new Array("6AA9A5000000","165团"),new Array("6AA9A6000000","166团"),new Array("6AA9A7000000","167团"),new Array("6AA9A8000000","168团"),new Array("6AA9A9000000","169团"),new Array("6AA9B1000000","170团"),new Array("6AA9B2000000","团结农场"),new Array("6AA9B3000000","直属"));
CITY_II["6AB100000000"]=new Array(new Array("6AB1A1000000","181团"),new Array("6AB1A2000000","182团"),new Array("6AB1A3000000","183团"),new Array("6AB1A4000000","184团"),new Array("6AB1A5000000","185团"),new Array("6AB1A6000000","186团"),new Array("6AB1A7000000","187团"),new Array("6AB1A8000000","188团"),new Array("6AB1A9000000","直属"));
CITY_II["6AB200000000"]=new Array(new Array("6AB2A1000000","直属"));
CITY_II["6AB300000000"]=new Array(new Array("6AB3A1000000","104团"),new Array("6AB3A2000000","221团"),new Array("6AB3A3000000","西山农场"),new Array("6AB3A4000000","五一农场"),new Array("6AB3A5000000","三坪农场"),new Array("6AB3A6000000","头屯河农场"),new Array("6AB3A7000000","养禽场"));
CITY_II["6AB400000000"]=new Array(new Array("6AB4A1000000","红星一场"),new Array("6AB4A2000000","红星二场"),new Array("6AB4A3000000","红星三场"),new Array("6AB4A4000000","红星四场"),new Array("6AB4A5000000","黄田农场"),new Array("6AB4A6000000","火箭农场"),new Array("6AB4A7000000","柳树泉农场"),new Array("6AB4A8000000","红星一牧场"),new Array("6AB4A9000000","红星二牧场"),new Array("6AB4B1000000","红山农场"),new Array("6AB4B2000000","淖毛湖农场"),new Array("6AB4B3000000","直属"));
CITY_II["6AB500000000"]=new Array(new Array("6AB5A1000000","47团"),new Array("6AB5A2000000","皮山农场"),new Array("6AB5A3000000","一牧场"),new Array("6AB5A4000000","224团"));
CITY_II["6AB600000000"]=new Array(new Array("6AB6A1000000","直属"));
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
