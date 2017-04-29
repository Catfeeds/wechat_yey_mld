<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='修改报名信息';
require_once '../header.php';
//先判断这个幼儿是否在名下
$o_stu=new Student_Info_Wechat_Wiew();
$o_stu->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
$o_stu->PushWhere ( array ('&&', 'StudentId', '=',$_GET['id']) ); 
if ($o_stu->getAllCount()==0)
{
	echo "<script>location.href='my_signup.php'</script>"; 
	exit(0);
}

?>
	<form action="../include/bn_submit.switch.php" id="submit_form_checkid" method="post" target=ajax_submit_frame>
		<input type="hidden" name="Vcl_FunName" value="CheckId"/>
		<input type="hidden" name="Vcl_CheckId" id="Vcl_CheckId" value=""/>
	</form>
	<form action="../include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
		<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
		<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
		<input type="hidden" name="Vcl_FunName" value="SignupModify"/>
		<input type="hidden" name="Vcl_StudentId" value="<?php echo($_GET['id'])?>"/>
			<?php 
				require_once 'signup_detail.php';
			?>
	    <div style="padding:15px;">
	    	<a id="next" class="weui-btn weui-btn_primary" onclick="submit_signin(true)">提交修改</a>
	    	<a id="next" class="weui-btn weui-btn_default" onclick="javascript:history.back();">返回</a>
	    </div>
	</form>
<script type="text/javascript" src="js/function.js"></script>
<script>
<?php 
//基本信息
	echo('document.getElementById("Vcl_Name").value="'.$o_stu->getName(0).'";
	');
	echo('document.getElementById("Vcl_Sex").value="'.$o_stu->getSex(0).'";
	');
	echo('document.getElementById("Vcl_IdType").value="'.$o_stu->getIdType(0).'";
	');
	echo('document.getElementById("Vcl_ID").value="'.$o_stu->getId(0).'";
	');
	echo('document.getElementById("Vcl_Birthday").value="'.$o_stu->getBirthday(0).'";
	');
//健康信息
	echo('document.getElementById("Vcl_Jiankang").value="'.$o_stu->getJiankang(0).'";
	');
	echo('document.getElementById("Vcl_HospitalName").value="'.$o_stu->getHospitalName(0).'";
	');
	echo('document.getElementById("Vcl_IsYiwang").value="'.$o_stu->getIsYiwang(0).'";
	');
	echo('change_yiwang(document.getElementById("Vcl_IsYiwang"));
	');
	if($o_stu->getIsYiwang(0)=='是')echo('document.getElementById("Vcl_Illness").value="'.$o_stu->getIllness(0).'";
	');
	echo('document.getElementById("Vcl_IsGuomin").value="'.$o_stu->getIsGuomin(0).'";
	');
	echo('change_guomin(document.getElementById("Vcl_IsGuomin"));
	');
	if($o_stu->getIsGuomin(0)=='是')echo('document.getElementById("Vcl_Allergic").value="'.$o_stu->getAllergic(0).'";
	');
	echo('document.getElementById("Vcl_Nationality").value="'.$o_stu->getNationality(0).'";
	');
	if ($o_stu->getNationality(0)=='中国')
	{
		echo('document.getElementById("Vcl_Nation").value="'.$o_stu->getNation(0).'";
		');		
		//获取户籍编号
		$o_h_code1=new Student_City_Code($o_stu->getHCode(0));
		$o_h_code2=new Student_City_Code($o_h_code1->getParentId());
		if ($o_h_code2->getParentId()!='')
		{
			//说明是三级，否则是两级
			$o_h_code3=new Student_City_Code($o_h_code2->getParentId(0));
			echo('document.getElementById("Vcl_HCity").value="'.$o_h_code3->getId().'";
			');
			echo('change_h_city(document.getElementById("Vcl_HCity"));
			');
			echo('document.getElementById("Vcl_HArea").value="'.$o_h_code2->getId().'";
			');
			echo('change_h_qu(document.getElementById("Vcl_HArea"));
			');
			echo('document.getElementById("Vcl_HStreet").value="'.$o_h_code1->getId().'";
			');
		}else{
			//如果是两级，需要判断是否是北京市西城区，如果是，需要显示街道和社区
			echo('document.getElementById("Vcl_HCity").value="'.$o_h_code2->getId().'";
			');
			echo('change_h_city(document.getElementById("Vcl_HCity"));
			');
			echo('try{document.getElementById("Vcl_HArea").value="'.$o_h_code1->getId().'"}catch(e){};
			');
			echo('change_h_qu(document.getElementById("Vcl_HArea"));
			');
			if ($o_stu->getHCode(0)=='110102000000')
			{
				echo('document.getElementById("Vcl_HStreet").value="'.$o_stu->getHStreet(0).'";
				');
				echo('change_h_jiedao(document.getElementById("Vcl_HStreet"));
				');
				echo('document.getElementById("Vcl_HShequ").value="'.$o_stu->getHShequ(0).'";
				');
			}
		}		
		echo('document.getElementById("Vcl_HAdd").value="'.$o_stu->getHAdd(0).'";');
	}else{
		echo('change_nationality(document.getElementById("Vcl_Nationality"));
		');
	}
	echo('document.getElementById("Vcl_ZSame").value="'.$o_stu->getZSame(0).'";
	');
	echo('change_address(document.getElementById("Vcl_ZSame"));
	');
	if($o_stu->getZSame(0)=='否')
	{
		echo('document.getElementById("Vcl_ZCity").value="'.$o_stu->getZCity(0).'";
		');
		echo('change_z_city(document.getElementById("Vcl_ZCity"));
		');
		if($o_stu->getZCity(0)=='北京市')
		{
			echo('document.getElementById("Vcl_ZArea").value="'.$o_stu->getZArea(0).'";
			');
			echo('change_z_qu(document.getElementById("Vcl_ZArea"));
			');
			if($o_stu->getZArea(0)=="西城区")
			{
				echo('document.getElementById("Vcl_ZStreet").value="'.$o_stu->getZStreet(0).'";
				');
				echo('change_z_jiedao(document.getElementById("Vcl_ZStreet"));
				');
				echo('document.getElementById("Vcl_ZShequ").value="'.$o_stu->getZShequ(0).'";
				');
			}			
		}
		echo('document.getElementById("Vcl_ZAdd").value="'.$o_stu->getZAdd(0).'";
		');		
	}
	echo('document.getElementById("Vcl_ZProperty").value="'.$o_stu->getZProperty(0).'";
	');
	echo('change_z_property(document.getElementById("Vcl_ZProperty"));
	');
	if ($o_stu->getZProperty(0)=='直系亲属房产')
	{
		echo('document.getElementById("Vcl_ZOwner").value="'.$o_stu->getZOwner(0).'";
		');
		echo('document.getElementById("Vcl_ZGuanxi").value="'.$o_stu->getZGuanxi(0).'";
		');	
	}	
	echo('document.getElementById("Vcl_Jh1Connection").value="'.$o_stu->getJh1Connection(0).'";
	');
	echo('document.getElementById("Vcl_Jh1Name").value="'.$o_stu->getJh1Name(0).'";
	');
	echo('document.getElementById("Vcl_Jh1Danwei").value="'.$o_stu->getJh1Danwei(0).'";
	');
	echo('document.getElementById("Vcl_Jh1Jiaoyu").value="'.$o_stu->getJh1Jiaoyu(0).'";
	');
	echo('document.getElementById("Vcl_Jh1Phone").value="'.$o_stu->getJh1Phone(0).'";
	');
	if ($o_stu->getJh2Name(0)!='')
	{
		echo('document.getElementById("Vcl_Jh2Connection").value="'.$o_stu->getJh2Connection(0).'";
		');
		echo('document.getElementById("Vcl_Jh2Name").value="'.$o_stu->getJh2Name(0).'";
		');
		echo('document.getElementById("Vcl_Jh2Danwei").value="'.$o_stu->getJh2Danwei(0).'";
		');
		echo('document.getElementById("Vcl_Jh2Jiaoyu").value="'.$o_stu->getJh2Jiaoyu(0).'";
		');
	}
	echo('document.getElementById("Vcl_Jh2Phone").value="'.$o_stu->getJh2Phone(0).'";
	');
	echo('document.getElementById("Vcl_Compliance").value="'.$o_stu->getCompliance(0).'";
	');
	echo('document.getElementById("Vcl_ClassMode").value="'.$o_stu->getClassMode(0).'";
	');
?>
vcl_disabled(document.getElementById("Vcl_ID"))
vcl_disabled(document.getElementById("Vcl_IdType"))


</script>
<?php
require_once '../footer.php';
?>