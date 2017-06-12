<div class="item" style="width: 98%;height:auto;font-size:14px;"><label>基本信息</label></div>
<div class="item">
	<label>
		<span class="must">*</span> 幼儿姓名：
	</label>
	<br />
	<input name="Vcl_Name" id="Vcl_Name" type="text" style="width: 100%" class="form-control" placeholder="必填"/>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 证件类型：
	</label>
	<br />
	<select name="Vcl_IdType" id="Vcl_IdType" class="selectpicker" data-style="btn-default" onchange="change_idtype(this)">
		<option value="居民身份证">居民身份证</option>
		<option value="香港特区护照/身份证明">香港特区护照/身份证明</option>
		<option value="澳门特区护照/身份证明">澳门特区护照/身份证明</option>
		<option value="台湾居民来往大陆通行证">台湾居民来往大陆通行证</option>
		<option value="境外永久居住证">境外永久居住证</option>
		<option value="护照">护照</option>
		<option value="其他">其他</option>
	</select>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 证件号：
	</label>
	<br />
	<input name="Vcl_ID" id="Vcl_ID" type="text" onBlur="check_id()" placeholder="必填" style="width: 100%" class="form-control">
</div>	
<div class="item">
	<label>
		<span class="must">*</span> 性别：
	</label>
	<br />
	<select name="Vcl_Sex" id="Vcl_Sex" class="selectpicker" data-style="btn-default" >
		<option value="男">男</option>
		<option value="女">女</option>
	</select>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 出生日期：
	</label>
	<br />
	<?php 
	if (MODULEID==120203)
	{
		//审核显示纯文本输入框
		?>
	<input name="Vcl_Birthday" id="Vcl_Birthday" type="text" placeholder="必填" style="width: 100%" class="form-control">
		<?php
	}else{
		?>
	<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
		<input class="form-control" size="16" type="text" id="Vcl_Birthday" name="Vcl_Birthday" readonly style="background-color:white">
		<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	</div>	
		<?php
	}
	?>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 国籍：
	</label>
	<br />
	<select name="Vcl_Nationality" id="Vcl_Nationality" onchange="change_nationality(this)" class="selectpicker" data-style="btn-default">
		<option selected="selected" value="中国">中国</option>
		<option value="中国香港">中国香港</option>
		<option value="中国澳门">中国澳门</option>
		<option value="中国台湾">中国台湾</option>	
		<option value="阿尔巴尼亚">阿尔巴尼亚</option>
		<option value="阿尔及利亚">阿尔及利亚</option>
		<option value="阿富汗">阿富汗</option>
		<option value="阿根廷">阿根廷</option>
		<option value="阿联酋">阿联酋</option>
		<option value="阿鲁巴">阿鲁巴</option>
		<option value="阿曼">阿曼</option>
		<option value="阿塞拜疆">阿塞拜疆</option>
		<option value="埃及">埃及</option>
		<option value="埃塞俄比亚">埃塞俄比亚</option>
		<option value="爱尔兰">爱尔兰</option>
		<option value="爱沙尼亚">爱沙尼亚</option>
		<option value="安道尔">安道尔</option>
		<option value="安哥拉（Angola）">安哥拉（Angola）</option>
		<option value="安圭拉(Anguilla)">安圭拉(Anguilla)</option>
		<option value="安提瓜和巴布达">安提瓜和巴布达</option>
		<option value="奥地利">奥地利</option>
		<option value="澳大利亚">澳大利亚</option>
		<option value="澳门">澳门</option>
		<option value="巴巴多斯">巴巴多斯</option>
		<option value="巴布亚新几内亚">巴布亚新几内亚</option>
		<option value="巴哈马">巴哈马</option>
		<option value="巴基斯坦">巴基斯坦</option>
		<option value="巴拉圭">巴拉圭</option>
		<option value="巴勒斯坦">巴勒斯坦</option>
		<option value="巴林">巴林</option>
		<option value="巴拿马">巴拿马</option>
		<option value="巴西">巴西</option>
		<option value="白俄罗斯">白俄罗斯</option>
		<option value="百慕大">百慕大</option>
		<option value="保加利亚">保加利亚</option>
		<option value="北马里亚纳">北马里亚纳</option>
		<option value="贝宁">贝宁</option>
		<option value="比利时">比利时</option>
		<option value="冰岛">冰岛</option>
		<option value="玻利维亚">玻利维亚</option>
		<option value="波多黎各">波多黎各</option>
		<option value="波黑">波黑</option>
		<option value="波兰">波兰</option>
		<option value="博茨瓦纳">博茨瓦纳</option>
		<option value="伯利兹">伯利兹</option>
		<option value="不丹">不丹</option>
		<option value="布基纳法索">布基纳法索</option>
		<option value="布隆迪">布隆迪</option>
		<option value="布维岛">布维岛</option>
		<option value="朝鲜">朝鲜</option>
		<option value="赤道几内亚">赤道几内亚</option>
		<option value="丹麦">丹麦</option>
		<option value="德国">德国</option>
		<option value="东帝汶">东帝汶</option>
		<option value="多哥">多哥</option>
		<option value="多米尼加">多米尼加</option>
		<option value="多米尼克">多米尼克</option>
		<option value="俄罗斯联邦">俄罗斯联邦</option>
		<option value="厄瓜多尔">厄瓜多尔</option>
		<option value="厄立特里亚">厄立特里亚</option>
		<option value="法国">法国</option>
		<option value="法罗群岛">法罗群岛</option>
		<option value="法属波利尼西亚">法属波利尼西亚</option>
		<option value="法属圭亚那">法属圭亚那</option>
		<option value="法属南部领地">法属南部领地</option>
		<option value="菲律宾">菲律宾</option>
		<option value="芬兰">芬兰</option>
		<option value="佛得角">佛得角</option>
		<option value="福克兰群岛(马尔维纳斯)">福克兰群岛(马尔维纳斯)</option>
		<option value="冈比亚">冈比亚</option>
		<option value="刚果（布）">刚果（布）</option>
		<option value="刚果（金）">刚果（金）</option>
		<option value="哥伦比亚">哥伦比亚</option>
		<option value="哥斯达黎加">哥斯达黎加</option>
		<option value="格林纳达">格林纳达</option>
		<option value="格陵兰">格陵兰</option>
		<option value="格鲁吉亚">格鲁吉亚</option>
		<option value="古巴">古巴</option>
		<option value="瓜德罗普">瓜德罗普</option>
		<option value="关岛">关岛</option>
		<option value="圭亚那">圭亚那</option>
		<option value="哈萨克斯坦">哈萨克斯坦</option>
		<option value="海地">海地</option>
		<option value="韩国">韩国</option>
		<option value="荷兰">荷兰</option>
		<option value="荷属安的列斯">荷属安的列斯</option>
		<option value="赫德岛和麦克唐纳岛">赫德岛和麦克唐纳岛</option>
		<option value="洪都拉斯">洪都拉斯</option>
		<option value="基里巴斯">基里巴斯</option>
		<option value="吉布提">吉布提</option>
		<option value="吉尔吉斯斯坦">吉尔吉斯斯坦</option>
		<option value="几内亚">几内亚</option>
		<option value="几内亚比绍">几内亚比绍</option>
		<option value="加拿大">加拿大</option>
		<option value="加纳">加纳</option>
		<option value="加蓬">加蓬</option>
		<option value="柬埔寨">柬埔寨</option>
		<option value="捷克">捷克</option>
		<option value="津巴布韦">津巴布韦</option>
		<option value="喀麦隆">喀麦隆</option>
		<option value="卡塔尔">卡塔尔</option>
		<option value="开曼群岛">开曼群岛</option>
		<option value="科科斯(基林)群岛">科科斯(基林)群岛</option>
		<option value="科摩罗">科摩罗</option>
		<option value="科特迪瓦">科特迪瓦</option>
		<option value="科威持">科威持</option>
		<option value="克罗地亚">克罗地亚</option>
		<option value="肯尼亚">肯尼亚</option>
		<option value="库克群岛">库克群岛</option>
		<option value="拉脱维亚">拉脱维亚</option>
		<option value="莱索托">莱索托</option>
		<option value="老挝">老挝</option>
		<option value="黎巴嫩">黎巴嫩</option>
		<option value="利比里亚">利比里亚</option>
		<option value="利比亚">利比亚</option>
		<option value="立陶宛">立陶宛</option>
		<option value="列支敦土登">列支敦土登</option>
		<option value="留尼汪">留尼汪</option>
		<option value="卢森堡">卢森堡</option>
		<option value="卢旺达">卢旺达</option>
		<option value="罗马尼亚">罗马尼亚</option>
		<option value="马达加斯加">马达加斯加</option>
		<option value="马耳他">马耳他</option>
		<option value="马尔代夫">马尔代夫</option>
		<option value="马拉维">马拉维</option>
		<option value="马来西亚">马来西亚</option>
		<option value="马里">马里</option>
		<option value="马绍尔群岛">马绍尔群岛</option>
		<option value="马提尼克">马提尼克</option>
		<option value="马约特">马约特</option>
		<option value="毛里求斯">毛里求斯</option>
		<option value="毛里塔尼亚">毛里塔尼亚</option>
		<option value="美国">美国</option>
		<option value="美国本土外小岛屿">美国本土外小岛屿</option>
		<option value="美属萨摩亚">美属萨摩亚</option>
		<option value="美属维尔京群岛">美属维尔京群岛</option>
		<option value="蒙古">蒙古</option>
		<option value="蒙特塞拉特">蒙特塞拉特</option>
		<option value="孟加拉国">孟加拉国</option>
		<option value="秘鲁">秘鲁</option>
		<option value="密克罗尼西亚联邦">密克罗尼西亚联邦</option>
		<option value="缅甸">缅甸</option>
		<option value="摩尔多瓦">摩尔多瓦</option>
		<option value="摩洛哥">摩洛哥</option>
		<option value="摩纳哥">摩纳哥</option>
		<option value="莫桑比克">莫桑比克</option>
		<option value="墨西哥">墨西哥</option>
		<option value="纳米比亚">纳米比亚</option>
		<option value="南非">南非</option>
		<option value="南极洲">南极洲</option>
		<option value="南乔治亚岛和南桑德韦奇岛">南乔治亚岛和南桑德韦奇岛</option>
		<option value="南斯拉夫">南斯拉夫</option>
		<option value="尼泊尔">尼泊尔</option>
		<option value="尼加拉瓜">尼加拉瓜</option>
		<option value="尼日尔">尼日尔</option>
		<option value="尼日利亚">尼日利亚</option>
		<option value="纽埃">纽埃</option>
		<option value="挪威">挪威</option>
		<option value="诺福克岛">诺福克岛</option>
		<option value="帕劳">帕劳</option>
		<option value="皮特凯恩">皮特凯恩</option>
		<option value="葡萄牙">葡萄牙</option>
		<option value="前南马其顿">前南马其顿</option>
		<option value="日本">日本</option>
		<option value="瑞典">瑞典</option>
		<option value="瑞士">瑞士</option>
		<option value="萨尔瓦多">萨尔瓦多</option>
		<option value="萨摩亚">萨摩亚</option>
		<option value="塞拉利昂">塞拉利昂</option>
		<option value="塞内加尔">塞内加尔</option>
		<option value="塞浦路斯">塞浦路斯</option>
		<option value="塞舌尔">塞舌尔</option>
		<option value="沙特阿拉伯">沙特阿拉伯</option>
		<option value="圣诞岛">圣诞岛</option>
		<option value="圣多美和普林西比">圣多美和普林西比</option>
		<option value="圣赫勒拿">圣赫勒拿</option>
		<option value="圣基茨和尼维斯">圣基茨和尼维斯</option>
		<option value="圣卢西亚">圣卢西亚</option>
		<option value="圣马力诺">圣马力诺</option>
		<option value="圣皮埃尔和密克隆">圣皮埃尔和密克隆</option>
		<option value="圣文森特和格林纳丁斯">圣文森特和格林纳丁斯</option>
		<option value="斯里兰卡">斯里兰卡</option>
		<option value="斯洛伐克">斯洛伐克</option>
		<option value="斯洛文尼亚">斯洛文尼亚</option>
		<option value="斯瓦尔巴岛和扬马延岛">斯瓦尔巴岛和扬马延岛</option>
		<option value="斯威士兰">斯威士兰</option>
		<option value="苏丹">苏丹</option>
		<option value="苏里南">苏里南</option>
		<option value="索马里">索马里</option>
		<option value="所罗门群岛">所罗门群岛</option>
		<option value="塔吉克斯坦">塔吉克斯坦</option>
		<option value="泰国">泰国</option>
		<option value="坦桑尼亚">坦桑尼亚</option>
		<option value="汤加">汤加</option>
		<option value="特克斯和凯科斯群岛">特克斯和凯科斯群岛</option>
		<option value="特立尼达和多巴哥">特立尼达和多巴哥</option>
		<option value="突尼斯">突尼斯</option>
		<option value="图瓦卢">图瓦卢</option>
		<option value="土耳其">土耳其</option>
		<option value="土库曼斯坦">土库曼斯坦</option>
		<option value="托克劳">托克劳</option>
		<option value="瓦利斯和富图纳">瓦利斯和富图纳</option>
		<option value="瓦努阿图">瓦努阿图</option>
		<option value="危地马拉">危地马拉</option>
		<option value="委内瑞拉">委内瑞拉</option>
		<option value="文莱">文莱</option>
		<option value="乌干达">乌干达</option>
		<option value="乌克兰">乌克兰</option>
		<option value="乌拉圭">乌拉圭</option>
		<option value="乌兹别克斯坦">乌兹别克斯坦</option>
		<option value="西班牙">西班牙</option>
		<option value="西撤哈拉">西撤哈拉</option>
		<option value="希腊">希腊</option>
		<option value="新加坡">新加坡</option>
		<option value="新喀里多尼亚">新喀里多尼亚</option>
		<option value="新西兰">新西兰</option>
		<option value="匈牙利">匈牙利</option>
		<option value="叙利亚">叙利亚</option>
		<option value="牙买加">牙买加</option>
		<option value="亚美尼亚">亚美尼亚</option>
		<option value="也门">也门</option>
		<option value="伊拉克">伊拉克</option>
		<option value="伊朗">伊朗</option>
		<option value="以色列">以色列</option>
		<option value="意大利">意大利</option>
		<option value="印度">印度</option>
		<option value="印度尼西亚">印度尼西亚</option>
		<option value="英国">英国</option>
		<option value="英属维尔京群岛">英属维尔京群岛</option>
		<option value="英属印度洋领土">英属印度洋领土</option>
		<option value="约旦">约旦</option>
		<option value="越南">越南</option>
		<option value="赞比亚">赞比亚</option>
		<option value="乍得">乍得</option>
		<option value="直布罗陀">直布罗陀</option>
		<option value="智利">智利</option>
		<option value="中非">中非</option>		
		<option value="瑙鲁">瑙鲁</option>
		<option value="梵蒂冈">梵蒂冈</option>
		<option value="斐济">斐济</option>
		<option value="塞尔维亚">塞尔维亚</option>
		<option value="埃及">埃及</option>
		<option value="阿塞拜疆">阿塞拜疆</option>
		<option value="阿曼">阿曼</option>
		<option value="阿鲁巴">阿鲁巴</option>
		<option value="阿联酋">阿联酋</option>
		<option value="阿根廷">阿根廷</option>
		<option value="阿富汗">阿富汗</option>
		<option value="阿尔及利亚">阿尔及利亚</option>
		<option value="阿尔巴尼亚">阿尔巴尼亚</option>
	</select>
</div>
<div class="item" id="nation">
	<label>
		<span class="must">*</span> 民族：
	</label>
	<br />
	<select name="Vcl_Nation" id="Vcl_Nation" class="selectpicker" data-style="btn-default">
		<option selected="selected" value="汉族">汉族</option>
		<option value="回族">回族</option>
		<option value="蒙古族">蒙古族</option>
		<option value="藏族">藏族</option>
		<option value="维吾尔族">维吾尔族</option>
		<option value="苗族">苗族</option>
		<option value="彝族">彝族</option>
		<option value="壮族">壮族</option>
		<option value="布依族">布依族</option>
		<option value="朝鲜族">朝鲜族</option>
		<option value="满族">满族</option>
		<option value="侗族">侗族</option>
		<option value="瑶族">瑶族</option>
		<option value="白族">白族</option>
		<option value="土家族">土家族</option>
		<option value="哈尼族">哈尼族</option>
		<option value="哈萨克族">哈萨克族</option>
		<option value="傣族">傣族</option>
		<option value="黎族">黎族</option>
		<option value="傈僳族">傈僳族</option>
		<option value="佤族">佤族</option>
		<option value="畲族">畲族</option>
		<option value="高山族">高山族</option>
		<option value="拉祜族">拉祜族</option>
		<option value="水族">水族</option>
		<option value="东乡族">东乡族</option>
		<option value="纳西族">纳西族</option>
		<option value="景颇族">景颇族</option>
		<option value="柯尔克孜族">柯尔克孜族</option>
		<option value="土族">土族</option>
		<option value="达斡尔族">达斡尔族</option>
		<option value="仫佬族">仫佬族</option>
		<option value="羌族">羌族</option>
		<option value="布朗族">布朗族</option>
		<option value="撒拉族">撒拉族</option>
		<option value="毛难族">毛难族</option>
		<option value="仡佬族">仡佬族</option>
		<option value="锡伯族">锡伯族</option>
		<option value="阿昌族">阿昌族</option>
		<option value="普米族">普米族</option>
		<option value="塔吉克族">塔吉克族</option>
		<option value="怒族">怒族</option>
		<option value="乌孜别克族">乌孜别克族</option>
		<option value="俄罗斯族">俄罗斯族</option>
		<option value="鄂温克族">鄂温克族</option>
		<option value="德昂族">德昂族</option>
		<option value="保安族">保安族</option>
		<option value="裕固族">裕固族</option>
		<option value="京族">京族</option>
		<option value="塔塔尔族">塔塔尔族</option>
		<option value="独龙族">独龙族</option>
		<option value="鄂伦春族">鄂伦春族</option>
		<option value="赫哲族">赫哲族</option>
		<option value="门巴族">门巴族</option>
		<option value="珞巴族">珞巴族</option>
		<option value="基诺族">基诺族</option>
		<option value="穿青人族">穿青人族</option>
		<option value="外国血统">外国血统</option>
		<option value="无">无</option>
	</select>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 港澳台侨：
	</label>
	<br />
	<select name="Vcl_Gangao" id="Vcl_Gangao" class="selectpicker" data-style="btn-default">
		<option selected="selected" value="非港澳台侨">非港澳台侨</option>
		<option value="香港同胞">香港同胞</option>
		<option value="香港同胞亲属">香港同胞亲属</option>
		<option value="澳门同胞">澳门同胞</option>
		<option value="澳门同胞亲属">澳门同胞亲属</option>
		<option value="台湾同胞">台湾同胞</option>
		<option value="台湾同胞亲属">台湾同胞亲属</option>
		<option value="华侨">华侨</option>
		<option value="侨眷">侨眷</option>
		<option value="归侨">归侨</option>
		<option value="归侨子女">归侨子女</option>
		<option value="归国留学人员">归国留学人员</option>
		<option value="非华裔中国人">非华裔中国人</option>
		<option value="外籍华裔人">外籍华裔人</option>
		<option value="外国人">外国人</option>
		<option value="其他">其他</option>
	</select>
</div>
<div id="other_base">
	<div class="item">
		<label>
			<span class="must">*</span> 是否有独生子女证：
		</label>
		<br />
		<select name="Vcl_Only" id="Vcl_Only" onchange="change_only(this)" class="selectpicker" data-style="btn-default" >
			<option value="否">否</option>
			<option value="是">是</option>
		</select>
	</div>
	<div class="item">
		<label>
			<span class="must">*</span> 是否烈士子女：
		</label>
		<br />
		<select name="Vcl_IsLieshi" id="Vcl_IsLieshi" class="selectpicker" data-style="btn-default" >
			<option value="否">否</option>
			<option value="是">是</option>
		</select>
	</div>
	<div class="item">
		<label>
			<span class="must">*</span> 是否孤儿：
		</label>
		<br />
		<select name="Vcl_IsGuer" id="Vcl_IsGuer" class="selectpicker" data-style="btn-default" >
			<option value="否">否</option>
			<option value="是">是</option>
		</select>
	</div>
	<div class="item">
		<label>
			<span class="must">*</span> 是否进城务工人员随迁子女：
		</label>
		<br />
		<select name="Vcl_IsWugong" id="Vcl_IsWugong" class="selectpicker" data-style="btn-default" >
			<option value="否">否</option>
			<option value="是">是</option>
		</select>
	</div>
	<div class="item" id="first">
		<label>
			<span class="must">*</span> 是否头胎：
		</label>
		<br />
		<select name="Vcl_IsFirst" id="Vcl_IsFirst" class="selectpicker" data-style="btn-default" >
			<option value="是">是</option>
			<option value="否">否</option>
		</select>
	</div>
	<div class="item" id="only_code" style="display:none">
		<label>
			<span class="must">*</span> 独生子女证号：
		</label>
		<br />
		<input name="Vcl_OnlyCode" id="Vcl_OnlyCode" type="text" placeholder="必填" style="width: 100%" class="form-control">
	</div>
	<div class="item">
		<label>
			<span class="must">*</span> 是否留守儿童：
		</label>
		<br />
		<select name="Vcl_IsLiushou" id="Vcl_IsLiushou" class="selectpicker" data-style="btn-default" >
			<option value="非留守儿童">非留守儿童</option>
			<option value="单亲留守儿童">单亲留守儿童</option>
			<option value="双亲留守儿童">双亲留守儿童</option>
		</select>
	</div>
	<div class="item">
		<label>
			<span class="must">*</span> 是否低保：
		</label>
		<br />
		<select name="Vcl_IsDibao" id="Vcl_IsDibao" onchange="change_isdibao(this)" class="selectpicker" data-style="btn-default" >
			<option value="否">否</option>
			<option value="是">是</option>
		</select>
	</div>
	<div class="item" id="dibao" style="display:none">
		<label>
			<span class="must">*</span> 低保证号：
		</label>
		<br />
		<input name="Vcl_DibaoCode" id="Vcl_DibaoCode" type="text" placeholder="必填" style="width: 100%" class="form-control">
	</div>
	<div class="item">
		<label>
			<span class="must">*</span> 是否正在接收资助：
		</label>
		<br />
		<select name="Vcl_IsZizhu" id="Vcl_IsZizhu" class="selectpicker" data-style="btn-default" >
			<option value="否">否</option>
			<option value="是">是</option>
		</select>
	</div>
	<div class="item">
		<label>
			<span class="must">*</span> 是否残疾儿童：
		</label>
		<br />
		<select name="Vcl_IsCanji" id="Vcl_IsCanji" onchange="change_iscanji(this)" class="selectpicker" data-style="btn-default" >
			<option value="否">否</option>
			<option value="是">是</option>
		</select>
	</div>
	<div id="canji" style="display:none">
		<div class="item">
			<label>
				<span class="must">*</span> 残疾幼儿类别：
			</label>
			<br />
			<select name="Vcl_CanjiType" id="Vcl_CanjiType" class="selectpicker" data-style="btn-default" >
				<option>请选择</option>
				<option value="视力残疾">视力残疾</option>
				<option value="听力残疾">听力残疾</option>
				<option value="言语残疾">言语残疾</option>
				<option value="肢体残疾">肢体残疾</option>
				<option value="智力残疾">智力残疾</option>
				<option value="精神残疾">精神残疾</option>
				<option value="多重残疾">多重残疾</option>
				<option value="其他残疾">其他残疾</option>
			</select>
		</div>
		<div class="item">
			<label>
				<span class="must">*</span> 残疾证号：
			</label>
			<br />
			<input name="Vcl_DibaoCode" id="Vcl_DibaoCode" type="text" placeholder="必填" style="width: 100%" class="form-control">
		</div>
	</div>
</div>
<div class="item" style="width:98%;height:auto;margin-top:15px;font-size:14px;"><label>班级信息</label></div>
<div class="item">
	<label>
		<span class="must">*</span> 入园班级：
	</label>
	<br />
	<select id="Vcl_ClassId" name="Vcl_ClassId" class="selectpicker" data-style="btn-default" >
		<option value="">请选择</option>
		<?php 
			//根据学校，动态读取年级与班级
			$o_class=new Student_Class();
			$o_class->PushOrder ( array ('Grade','A') );
			$o_class->PushOrder ( array ('ClassId','A') );
			$n_count=$o_class->getAllCount();
			for($i=0;$i<$n_count;$i++)
			{
				$s_grade_name='';
				//区分年级
			 	switch ($o_class->getGrade($i))
			 	{
			 		case 0:
			 			$s_grade_name='半日班';
			 			break;
			 		case 1:
			 			$s_grade_name='托班';
			 			break;
			 		case 2:
			 			$s_grade_name='小班';
			 			break;
			 		case 3:
			 			$s_grade_name='中班';
			 			break;
			 		case 4:
			 			$s_grade_name='大班';
			 			break;
			 	}
				echo('<option value="'.$o_class->getClassId($i).'">'.$s_grade_name.'('.$o_class->getClassName($i).')</option>');
			}		                    	
		?>
	</select>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 就读方式：
	</label>
	<br />
	<select id="Vcl_Jiudu" name="Vcl_Jiudu" class="selectpicker" data-style="btn-default" >
		<option value="走读">走读</option>
		<option value="住校">住校</option>		
	</select>
</div>
<div class="item" style="width:98%;height:auto;margin-top:15px;font-size:14px;"><label>健康信息</label></div>
<div class="item">
	<label>
		<span class="must">*</span> 总体健康状况：
	</label>
	<br />
	<select name="Vcl_Jiankang" id="Vcl_Jiankang" class="selectpicker" data-style="btn-default" >
		<option value="健康或良好">健康或良好</option>
		<option value="一般或较弱">一般或较弱</option>
		<option value="有慢性病">有慢性病</option>
		<option value="残疾">残疾</option>
	</select>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 血型：
	</label>
	<br />
	<select name="Vcl_Xuexing" id="Vcl_Xuexing" class="selectpicker" data-style="btn-default" >
		<option value="未知血型">未知血型</option>
		<option value="A血型">A血型</option>
		<option value="B血型">B血型</option>
		<option value="AB血型">AB血型</option>
		<option value="O血型">O血型</option>
		<option value="RH阳性血型">RH阳性血型</option>
		<option value="RH阴性血型">RH阴性血型</option>
		<option value="HLA血型">HLA血型</option>
		<option value="未定血型">未定血型</option>
		<option value="其他血型">其他血型</option>
	</select>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 是否有以往病史：
	</label>
	<br />
	<select name="Vcl_IsYiwang" id="Vcl_IsYiwang" onchange="change_yiwang(this)" class="selectpicker" data-style="btn-default" >
		<option value="否">否</option>
		<option value="是">是</option>
	</select>
</div>
<div class="item" id="yiwang" style="display:none">
	<label>
		<span class="must">*</span> 以往病史：
	</label>
	<br />
	<select name="Vcl_Illness" id="Vcl_Illness" class="selectpicker" data-style="btn-default" >
		<option>请选择</option>
		<option value="哮喘">哮喘史</option>
		<option value="癫痫史">癫痫史</option>
		<option value="惊厥史">惊厥史</option>
		<option value="先天性心脏病">先天性心脏病</option>
		<option value="其他">其他</option>
	</select>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 是否有手术史：
	</label>
	<br />
	<select name="Vcl_IsShoushu" id="Vcl_IsShoushu" onchange="change_shoushu(this)" class="selectpicker" data-style="btn-default" >
		<option value="否">否</option>
		<option value="是">是</option>
	</select>
</div>
<div class="item" style="display:none" id="shoushu">
	<label>
		<span class="must">*</span> 手术名称：
	</label>
	<br />
	<input name="Vcl_Shoushu" id="Vcl_Shoushu" type="text" placeholder="必填" style="width: 100%" class="form-control">
</div>
<div class="item">
	<label>
		<span class="must">*</span> 是否有器官移植史：
	</label>
	<br />
	<select name="Vcl_IsYizhi" id="Vcl_IsYizhi" class="selectpicker" data-style="btn-default" >
		<option value="否">否</option>
		<option value="是">是</option>
	</select>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 是否有过敏史：
	</label>
	<br />
	<select name="Vcl_IsGuomin" id="Vcl_IsGuomin" onchange="change_guomin(this)" class="selectpicker" data-style="btn-default" >
		<option value="否">否</option>
		<option value="是">是</option>
	</select>
</div>
<div class="item" id="guomin" style="display:none">
	<label>
		<span class="must">*</span> 过敏源：
	</label>
	<br />
	<input name="Vcl_Allergic" id="Vcl_Allergic" type="text" placeholder="必填" style="width: 100%" class="form-control">
</div>
<div class="item">
	<label>
		<span class="must">*</span> 是否有族遗传病史：
	</label>
	<br />
	<select name="Vcl_IsYichuan" id="Vcl_IsYichuan" onchange="change_yichuan(this)" class="selectpicker" data-style="btn-default" >
		<option value="否">否</option>
		<option value="是">是</option>
	</select>
</div>
<div class="item" id="yichuan" style="display:none">
	<label>
		<span class="must">*</span> 家族遗传病史名称：
	</label>
	<br />
	<input name="Vcl_Qitabingshi" id="Vcl_Qitabingshi" type="text" placeholder="必填" style="width: 100%" class="form-control">
</div>
<div class="item">
	<label>
		备注：
	</label>
	<br />
	<input name="Vcl_Beizhu" id="Vcl_Beizhu" type="text" placeholder="选填" style="width: 100%" class="form-control">
</div>
<div id="h_info">
	<div class="item" style="width:98%;height:auto;margin-top:15px;font-size:14px;"><label>户籍信息</label></div>
	<div class="item">
		<label>
			<span class="must">*</span> 出生所在（省/市）：
		</label>
		<br />
		<select name="Vcl_CCity" id="Vcl_CCity" onchange="change_c_city(this)" class="selectpicker" data-style="btn-default">
			<option value="">请选择</option>
			<option value="110000000000">北京市</option>
			<option value="120000000000">天津市</option>
			<option value="130000000000">河北省</option>
			<option value="140000000000">山西省</option>
			<option value="150000000000">内蒙古自治区</option>
			<option value="210000000000">辽宁省</option>
			<option value="220000000000">吉林省</option>
			<option value="230000000000">黑龙江省</option>
			<option value="310000000000">上海市</option>
			<option value="320000000000">江苏省</option>
			<option value="330000000000">浙江省</option>
			<option value="340000000000">安徽省</option>
			<option value="350000000000">福建省</option>
			<option value="360000000000">江西省</option>
			<option value="370000000000">山东省</option>
			<option value="410000000000">河南省</option>
			<option value="420000000000">湖北省</option>
			<option value="430000000000">湖南省</option>
			<option value="440000000000">广东省</option>
			<option value="450000000000">广西壮族自治区</option>
			<option value="460000000000">海南省</option>
			<option value="500000000000">重庆市</option>
			<option value="510000000000">四川省</option>
			<option value="520000000000">贵州省</option>
			<option value="530000000000">云南省</option>
			<option value="540000000000">西藏自治区</option>
			<option value="610000000000">陕西省</option>
			<option value="620000000000">甘肃省</option>
			<option value="630000000000">青海省</option>
			<option value="640000000000">宁夏回族自治区</option>
			<option value="650000000000">新疆维吾尔自治区</option>
			<option value="6A0000000000">新疆兵团</option>
		</select>
	</div>
	<div class="item" id="c_area" style="display:none"></div>
	<div class="item" id="c_street" style="display:none"></div>
	<div class="item">
		<label>
			<span class="must">*</span> 户口性质：
		</label>
		<br />
		<select name="Vcl_IdQuality" id="Vcl_IdQuality" onchange="change_qulity(this)" class="selectpicker" data-style="btn-default" >
			<option value="非农业户口">非农业户口</option>
			<option value="农业户口">农业户口</option>
		</select>
	</div>
	<div class="item" id="quality_type">
		<label>
			<span class="must">*</span> 户口性质：
		</label>
		<br />
		<select name="Vcl_IdQualityType" id="Vcl_IdQualityType" class="selectpicker" data-style="btn-default" >
			<option value="城市">城市</option>
			<option value="县城">县城</option>
			<option value="乡镇">乡镇</option>
		</select>
	</div>
	<div class="item" style="width:98%;height:auto;margin:0px;"></div>
	<div class="item">
		<label>
			<span class="must">*</span> 户籍所在（省/市）：
		</label>
		<br />
		<select name="Vcl_HCity" id="Vcl_HCity" onchange="change_h_city(this)" class="selectpicker" data-style="btn-default">
			<option value="110000000000" selected="selected">北京市</option>
			<option value="120000000000">天津市</option>
			<option value="130000000000">河北省</option>
			<option value="140000000000">山西省</option>
			<option value="150000000000">内蒙古自治区</option>
			<option value="210000000000">辽宁省</option>
			<option value="220000000000">吉林省</option>
			<option value="230000000000">黑龙江省</option>
			<option value="310000000000">上海市</option>
			<option value="320000000000">江苏省</option>
			<option value="330000000000">浙江省</option>
			<option value="340000000000">安徽省</option>
			<option value="350000000000">福建省</option>
			<option value="360000000000">江西省</option>
			<option value="370000000000">山东省</option>
			<option value="410000000000">河南省</option>
			<option value="420000000000">湖北省</option>
			<option value="430000000000">湖南省</option>
			<option value="440000000000">广东省</option>
			<option value="450000000000">广西壮族自治区</option>
			<option value="460000000000">海南省</option>
			<option value="500000000000">重庆市</option>
			<option value="510000000000">四川省</option>
			<option value="520000000000">贵州省</option>
			<option value="530000000000">云南省</option>
			<option value="540000000000">西藏自治区</option>
			<option value="610000000000">陕西省</option>
			<option value="620000000000">甘肃省</option>
			<option value="630000000000">青海省</option>
			<option value="640000000000">宁夏回族自治区</option>
			<option value="650000000000">新疆维吾尔自治区</option>
			<option value="6A0000000000">新疆兵团</option>
		</select>
	</div>
	<div class="item" id="h_qu">
		<label><span class="must">*</span> 户籍所在（市/区）：</label>
		<br/>
		<select id="Vcl_HArea" name="Vcl_HArea" onchange="change_h_qu(this)" class="selectpicker" data-style="btn-default">
			<option value="">请选择</option>
			<option value="110101000000">东城区</option>
			<option value="110102000000" selected="selected">西城区</option>
			<option value="110105000000">朝阳区</option>
			<option value="110106000000">丰台区</option>
			<option value="110107000000">石景山区</option>
			<option value="110108000000">海淀区</option>
			<option value="110109000000">门头沟区</option>
			<option value="110111000000">房山区</option>
			<option value="110112000000">通州区</option>
			<option value="110113000000">顺义区</option>
			<option value="110114000000">昌平区</option>
			<option value="110115000000">大兴区</option>
			<option value="110116000000">怀柔区</option>
			<option value="110117000000">平谷区</option>
			<option value="110228000000">密云县</option>
			<option value="110229000000">延庆县</option>
			<option value="11A1A1000000">燕山区</option>
		</select>
	</div>
	<div class="item" id="h_jiedao">
		<label><span class="must">*</span> 户籍所在街道：</label>
		<br/>
		<select id="Vcl_HStreet" name="Vcl_HStreet" onchange="change_h_jiedao(this)" class="selectpicker" data-style="btn-default">
			<option value="">请选择</option>
			<option value="德胜街道">德胜街道</option>
			<option value="什刹海街道">什刹海街道</option>
			<option value="西长安街街道">西长安街街道</option>
			<option value="大栅栏街道">大栅栏街道</option>
			<option value="天桥街道">天桥街道</option>
		    <option value="新街口街道">新街口街道</option>
		    <option value="金融街街道">金融街街道</option>
		    <option value="椿树街道">椿树街道</option>
		    <option value="陶然亭街道">陶然亭街道</option>
		    <option value="展览路街道">展览路街道</option>
		    <option value="月坛街道">月坛街道</option>
		    <option value="广内街道">广内街道</option>
		    <option value="牛街街道">牛街街道</option>
		    <option value="白纸坊街道">白纸坊街道</option>
		    <option value="广外街道">广外街道</option>
		</select>
	</div>
	<div class="item" id="h_shequ">
		<label><span class="must">*</span> 户籍所在社区：</label>
		<select id="Vcl_HShequ" name="Vcl_HShequ" class="selectpicker" data-style="btn-default">
			<option value="">请选择</option>
		</select>
	</div>
	<div class="item" style="width:98%;height:auto;margin:0px;"></div>
	<div class="item" style="width:48%">
		<label>
			<span class="must">*</span> 户籍详细地址：
		</label>
		<br />
		<input name="Vcl_HAdd" id="Vcl_HAdd" type="text" placeholder="必填" style="width: 100%" class="form-control">
	</div>
	<div class="item">
		<label>
			<span class="must">*</span> 户主姓名：
		</label>
		<br />
		<input name="Vcl_HOwner" id="Vcl_HOwner" type="text" placeholder="必填" style="width: 100%" class="form-control">
	</div>
	<div class="item">
		<label>
			<span class="must">*</span> 户主与幼儿关系：
		</label>
		<br />
		<select id="Vcl_HGuanxi" name="Vcl_HGuanxi" class="selectpicker" data-style="btn-default" >
			<option selected="selected" value="父母">父母</option>
	        <option value="祖父母或外祖父母">祖父母或外祖父母</option>
	        <option value="其他">其他</option>
		</select>
	</div>
</div>
<div class="item" style="width:98%;height:auto;margin-top:15px;font-size:14px;"><label>现住址信息（房产信息）</label></div>
<div class="item" id="is_same">
	<label>
		<span class="must">*</span> 现住址是否与户籍为同一地址：
	</label>
	<br />
	<select id="Vcl_ZSame" name="Vcl_ZSame" onchange="change_address(this)" class="selectpicker" data-style="btn-default" >
		<option selected="selected" value="否">否</option>
		<option value="是">是</option>
	</select>
</div>
<div class="item" style="width:98%;height:auto;margin:0px;"></div>
<div id="address">
	<div class="item">
		<label>
			<span class="must">*</span> 现住址所在（省/市）：
		</label>
		<br />
		<select name="Vcl_ZCity" id="Vcl_ZCity" onchange="change_z_city(this)" class="selectpicker" data-style="btn-default">
			<option value="北京市" selected="selected">北京市</option>
			<option value="天津市">天津市</option>
			<option value="河北省">河北省</option>
			<option value="山西省">山西省</option>
			<option value="内蒙古自治区">内蒙古自治区</option>
			<option value="辽宁省">辽宁省</option>
			<option value="吉林省">吉林省</option>
			<option value="黑龙江省">黑龙江省</option>
			<option value="上海市">上海市</option>
			<option value="江苏省">江苏省</option>
			<option value="浙江省">浙江省</option>
			<option value="安徽省">安徽省</option>
			<option value="福建省">福建省</option>
			<option value="江西省">江西省</option>
			<option value="山东省">山东省</option>
			<option value="河南省">河南省</option>
			<option value="湖北省">湖北省</option>
			<option value="湖南省">湖南省</option>
			<option value="广东省">广东省</option>
			<option value="广西壮族自治区">广西壮族自治区</option>
			<option value="海南省">海南省</option>
			<option value="重庆市">重庆市</option>
			<option value="四川省">四川省</option>
			<option value="贵州省">贵州省</option>
			<option value="云南省">云南省</option>
			<option value="西藏自治区">西藏自治区</option>
			<option value="陕西省">陕西省</option>
			<option value="甘肃省">甘肃省</option>
			<option value="青海省">青海省</option>
			<option value="宁夏回族自治区">宁夏回族自治区</option>
			<option value="新疆维吾尔自治区">新疆维吾尔自治区</option>
			<option value="新疆兵团">新疆兵团</option>
		</select>
	</div>
	<div class="item" id="z_qu">
		<label><span class="must">*</span> 现住址所在（市/区）：</label>
		<br/>
		<select id="Vcl_ZArea" name="Vcl_ZArea" onchange="change_z_qu(this)" class="selectpicker" data-style="btn-default">
			<option value="东城区">东城区</option>
			<option value="西城区" selected="selected">西城区</option>
			<option value="朝阳区">朝阳区</option>
			<option value="丰台区">丰台区</option>
			<option value="石景山区">石景山区</option>
			<option value="海淀区">海淀区</option>
			<option value="门头沟区">门头沟区</option>
			<option value="房山区">房山区</option>
			<option value="通州区">通州区</option>
			<option value="顺义区">顺义区</option>
			<option value="昌平区">昌平区</option>
			<option value="大兴区">大兴区</option>
			<option value="怀柔区">怀柔区</option>
			<option value="平谷区">平谷区</option>
			<option value="密云县">密云县</option>
			<option value="延庆县">延庆县</option>
			<option value="燕山区">燕山区</option>
		</select>
	</div>
	<div class="item" id="z_jiedao">
		<label><span class="must">*</span> 现住址所在街道：</label>
		<br/>
		<select id="Vcl_ZStreet" name="Vcl_ZStreet" onchange="change_z_jiedao(this)" class="selectpicker" data-style="btn-default">
			<option value="">请选择</option>
			<option value="德胜街道">德胜街道</option>
			<option value="什刹海街道">什刹海街道</option>
			<option value="西长安街街道">西长安街街道</option>
			<option value="大栅栏街道">大栅栏街道</option>
			<option value="天桥街道">天桥街道</option>
		    <option value="新街口街道">新街口街道</option>
		    <option value="金融街街道">金融街街道</option>
		    <option value="椿树街道">椿树街道</option>
		    <option value="陶然亭街道">陶然亭街道</option>
		    <option value="展览路街道">展览路街道</option>
		    <option value="月坛街道">月坛街道</option>
		    <option value="广内街道">广内街道</option>
		    <option value="牛街街道">牛街街道</option>
		    <option value="白纸坊街道">白纸坊街道</option>
		    <option value="广外街道">广外街道</option>
		</select>
	</div>
	<div class="item" id="z_shequ">
		<label><span class="must">*</span> 现住址所在社区：</label>
		<br/>
		<select id="Vcl_ZShequ" name="Vcl_ZShequ" class="selectpicker" data-style="btn-default">
			<option value="">请选择</option>
		</select>
	</div>
	<div class="item" style="width:98%;height:auto;margin:0px;"></div>
	<div class="item" style="width:48%">
		<label>
			<span class="must">*</span> 现住址详细地址：
		</label>
		<br />
		<input name="Vcl_ZAdd" id="Vcl_ZAdd" type="text" placeholder="必填" style="width: 100%" class="form-control">
	</div>
</div>
<div class="item" style="width:98%;height:auto;margin:0px;"></div>
<div class="item">
	<label><span class="must">*</span> 现住址房屋属性：</label>
	<br/>
	<select id="Vcl_ZProperty" name="Vcl_ZProperty" onchange="change_z_property(this)" class="selectpicker" data-style="btn-default">
		<option selected="selected" value="直系亲属房产">直系亲属房产</option>
		<option value="租借借用房产">租借借用房产</option>
	</select>
</div>
<div class="item" id="z_owner">
	<label><span class="must">*</span> 产权人姓名：</label>
	<br/>
	<input name="Vcl_ZOwner" id="Vcl_ZOwner" type="text" placeholder="必填" style="width: 100%" class="form-control">
</div>
<div class="item" id="z_guanxi">
	<label><span class="must">*</span> 产权人与孩子关系：</label>
	<br/>
	<select id="Vcl_ZGuanxi" name="Vcl_ZGuanxi" class="selectpicker" data-style="btn-default">
		<option selected="selected" value="直系亲属房产">直系亲属房产</option>
		<option value="租借借用房产">租借借用房产</option>
	</select>
</div>
<div class="item" style="width:98%;height:auto;margin-top:15px;font-size:14px;"><label>第一法定监护人信息</label></div>
<div class="item">
	<label>
		<span class="must">*</span> 关系：
	</label>
	<br />
	<select id="Vcl_Jh1Connection" name="Vcl_Jh1Connection" class="selectpicker" data-style="btn-default" >
		<option selected="selected" value="父亲">父亲</option>
		<option value="母亲">母亲</option>
		<option value="祖父">祖父</option>
		<option value="祖母">祖母</option>
		<option value="外祖父">外祖父</option>
		<option value="外祖母">外祖母</option>
		<option value="其他">其他</option>
	</select>
</div>
<div class="item">
	<label><span class="must">*</span> 姓名：</label>
	<br/>
	<input name="Vcl_Jh1Name" id="Vcl_Jh1Name" type="text" placeholder="必填" style="width: 100%" class="form-control">
</div>
<div class="item">
	<label>
		<span class="must">*</span> 证件类型：
	</label>
	<br />
	<select id="Vcl_Jh1IdType" name="Vcl_Jh1IdType" class="selectpicker" data-style="btn-default">
		<option value="居民身份证">居民身份证</option>
		<option value="军官证">军官证</option>
		<option value="士兵证">士兵证</option>
		<option value="文职干部证">文职干部证</option>
		<option value="部队离退休证">部队离退休证</option>
		<option value="香港特区护照/身份证明">香港特区护照/身份证明</option>
		<option value="澳门特区护照/身份证明">澳门特区护照/身份证明</option>
		<option value="台湾居民来往大陆通行证">台湾居民来往大陆通行证</option>
		<option value="境外永久居住证">境外永久居住证</option>
		<option value="护照">护照</option>
		<option value="户口簿">户口簿</option>
		<option value="其他">其他</option>
	</select>
</div>
<div class="item">
	<label><span class="must">*</span> 证件号：</label>
	<br/>
	<input name="Vcl_Jh1ID" id="Vcl_Jh1ID" type="text" placeholder="必填" style="width: 100%" class="form-control" onBlur="check_1_id()">
</div>
<div class="item">
	<label>
		<span class="must">*</span> 是否是直系亲属：
	</label>
	<br />
	<select id="Vcl_Jh1IsZhixi" name="Vcl_Jh1IsZhixi" class="selectpicker" data-style="btn-default" >
		<option value="是">是</option>
		<option value="否">否</option>
	</select>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 职业状况：
	</label>
	<br />
	<select name="Vcl_Jh1Job" id="Vcl_Jh1Job" class="selectpicker" data-style="btn-default">
		<option value="">请选择</option>
		<option value="机关或事业单位干部职工">机关或事业单位干部职工</option>
		<option value="专业技术人员">专业技术人员</option>
		<option value="退休">退休</option>
		<option value="企业管理人员">企业管理人员</option>
		<option value="一般企业职工">一般企业职工</option>
		<option value="私企老板或个体户">私企老板或个体户</option>
		<option value="文教科技人员">文教科技人员</option>
		<option value="学生">学生</option>
		<option value="下岗/失业人员">下岗/失业人员</option>
		<option value="军人/警察">军人/警察</option>
		<option value="务农人员">务农人员</option>
		<option value="其他">其他</option>
	</select>
</div>
<div class="item">
	<label>
		<span class="must">*</span> 教育程度：
	</label>
	<br />
	<select name="Vcl_Jh1Jiaoyu" id="Vcl_Jh1Jiaoyu" class="selectpicker" data-style="btn-default">
		<option value="">请选择</option>
		<option value="初中及以下">初中及以下</option>
		<option value="高中及中专">高中及中专</option>
		<option value="技校">技校</option>
		<option value="大专">大专</option>
		<option value="本科">本科</option>
		<option value="硕士研究生">硕士研究生</option>
		<option value="博士研究生及以上">博士研究生及以上</option>
	</select>
</div>
<div class="item">
	<label><span class="must">*</span> 联系电话：</label>
	<br/>
	<input name="Vcl_Jh1Phone" id="Vcl_Jh1Phone" type="text" placeholder="必填" style="width: 100%" class="form-control">
</div>
<div class="item">
	<label><span class="must">*</span> 工作单位全称：</label>
	<br/>
	<input name="Vcl_Jh1Danwei" id="Vcl_Jh1Danwei" type="text" placeholder="必填" style="width: 100%" class="form-control">
</div>
<div class="item">
	<label>
		<span class="must">*</span> 是否残疾：
	</label>
	<br />
	<select id="Vcl_Jh1IsCanji" name="Vcl_Jh1IsCanji" class="selectpicker" data-style="btn-default" onchange="change_canjizheng1(this)">
		<option value="否">否</option>
		<option value="是">是</option>
	</select>
</div>
<div class="item" id="canjizheng1" style="display:none">
	<label>
		残疾证号：
	</label>
	<br />
	<input name="Vcl_Jh1CanjiCode" id="Vcl_Jh1CanjiCode" type="text" placeholder="选填" style="width: 100%" class="form-control">
</div>
<div class="item" style="width:98%;height:auto;margin-top:15px;font-size:14px;"><label>第二法定监护人信息（选填）</label></div>
<div class="item">
	<label>
		关系：
	</label>
	<br />
	<select id="Vcl_Jh2Connection" name="Vcl_Jh2Connection" class="selectpicker" data-style="btn-default" >
		<option value=""> </option>
		<option value="父亲">父亲</option>
		<option value="母亲">母亲</option>
		<option value="祖父">祖父</option>
		<option value="祖母">祖母</option>
		<option value="外祖父">外祖父</option>
		<option value="外祖母">外祖母</option>
		<option value="其他">其他</option>
	</select>
</div>
<div class="item">
	<label>姓名：</label>
	<br/>
	<input name="Vcl_Jh2Name" id="Vcl_Jh2Name" type="text" style="width: 100%" class="form-control">
</div>
<div class="item">
	<label>
		证件类型：
	</label>
	<br />
	<select id="Vcl_Jh2IdType" name="Vcl_Jh2IdType" class="selectpicker" data-style="btn-default">
		<option value=""> </option>
		<option value="居民身份证">居民身份证</option>
		<option value="军官证">军官证</option>
		<option value="士兵证">士兵证</option>
		<option value="文职干部证">文职干部证</option>
		<option value="部队离退休证">部队离退休证</option>
		<option value="香港特区护照/身份证明">香港特区护照/身份证明</option>
		<option value="澳门特区护照/身份证明">澳门特区护照/身份证明</option>
		<option value="台湾居民来往大陆通行证">台湾居民来往大陆通行证</option>
		<option value="境外永久居住证">境外永久居住证</option>
		<option value="护照">护照</option>
		<option value="户口簿">户口簿</option>
		<option value="其他">其他</option>
	</select>
</div>
<div class="item">
	<label>证件号：</label>
	<br/>
	<input name="Vcl_Jh2ID" id="Vcl_Jh2ID" type="text" style="width: 100%" class="form-control" onBlur="check_2_id()">
</div>
<div class="item">
	<label>
		是否是直系亲属：
	</label>
	<br />
	<select id="Vcl_Jh2IsZhixi" name="Vcl_Jh2IsZhixi" class="selectpicker" data-style="btn-default" >
		<option value=""> </option>
		<option value="是">是</option>
		<option value="否">否</option>
	</select>
</div>
<div class="item">
	<label>
		职业状况：
	</label>
	<br />
	<select name="Vcl_Jh2Job" id="Vcl_Jh2Job" class="selectpicker" data-style="btn-default">
		<option value=""> </option>
		<option value="机关或事业单位干部职工">机关或事业单位干部职工</option>
		<option value="专业技术人员">专业技术人员</option>
		<option value="退休">退休</option>
		<option value="企业管理人员">企业管理人员</option>
		<option value="一般企业职工">一般企业职工</option>
		<option value="私企老板或个体户">私企老板或个体户</option>
		<option value="文教科技人员">文教科技人员</option>
		<option value="学生">学生</option>
		<option value="下岗/失业人员">下岗/失业人员</option>
		<option value="军人/警察">军人/警察</option>
		<option value="务农人员">务农人员</option>
		<option value="其他">其他</option>
	</select>
</div>
<div class="item">
	<label>
		教育程度：
	</label>
	<br />
	<select name="Vcl_Jh2Jiaoyu" id="Vcl_Jh2Jiaoyu" class="selectpicker" data-style="btn-default">
		<option value=""> </option>
		<option value="初中及以下">初中及以下</option>
		<option value="高中及中专">高中及中专</option>
		<option value="技校">技校</option>
		<option value="大专">大专</option>
		<option value="本科">本科</option>
		<option value="硕士研究生">硕士研究生</option>
		<option value="博士研究生及以上">博士研究生及以上</option>
	</select>
</div>
<div class="item">
	<label>联系电话：</label>
	<br/>
	<input name="Vcl_Jh2Phone" id="Vcl_Jh2Phone" type="text" style="width: 100%" class="form-control">
</div>
<div class="item">
	<label>工作单位全称：</label>
	<br/>
	<input name="Vcl_Jh2Danwei" id="Vcl_Jh2Danwei" type="text" style="width: 100%" class="form-control">
</div>
<div class="item">
	<label>
		是否残疾：
	</label>
	<br />
	<select id="Vcl_Jh2IsCanji" name="Vcl_Jh2IsCanji" class="selectpicker" data-style="btn-default" onchange="change_canjizheng2(this)">
		<option value=""> </option>
		<option value="否">否</option>
		<option value="是">是</option>
	</select>
</div>
<div class="item" id="canjizheng2" style="display:none">
	<label>
		残疾证号：
	</label>
	<br />
	<input name="Vcl_Jh2CanjiCode" id="Vcl_Jh2CanjiCode" type="text"style="width: 100%" class="form-control">
</div>
<div class="item" style="width:98%;height:auto;margin-top:15px;font-size:14px;"><label>第二法定监护人信息（选填）</label></div>
<div class="item">
	<label>
		关系：
	</label>
	<br />
	<select id="Vcl_JianhuConnection" name="Vcl_JianhuConnection" class="selectpicker" data-style="btn-default" >
		<option value=""> </option>
		<option value="祖父">祖父</option>
	    <option value="祖母">祖母</option>
	    <option value="外祖父">外祖父</option>
	    <option value="外祖母">外祖母</option>
	    <option value="其他">其他</option>
	</select>
</div>
<div class="item">
	<label>姓名：</label>
	<br/>
	<input name="Vcl_JianhuName" id="Vcl_JianhuName" type="text" style="width: 100%" class="form-control">
</div>
<div class="item">
	<label>联系电话：</label>
	<br/>
	<input name="Vcl_JianhuPhone" id="Vcl_JianhuPhone" type="text" style="width: 100%" class="form-control">
</div>