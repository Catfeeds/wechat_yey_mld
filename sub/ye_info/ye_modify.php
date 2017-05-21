<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120201);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';

ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单

?>
<style>
<!--
.sss_form div.item {
	width:23%;
	float:left;
	margin-left:1%;
	margin-right:1%;
	height:55px;
}
.sss_form
{
	overflow:hidden;
}
.sss_main
{
	padding-bottom: 0px;
}
-->
</style>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 
                            <?php
                            $s_funname='StuAdd'; 
                            if($_GET['id']>0)
                            {
                            	$o_stu=new Student_Onboard_Info($_GET['id']);
                            	$s_funname='StuModify'; 
                            	echo('修改幼儿信息');
								if($o_stu->getName()==null || $o_stu->getName()=='')
								{
									echo("<script>location='ye_info.php'</script>");
									exit(0);
								}
                            }else{
                            	echo('添加幼儿信息');
                            }
                            ?>
                            </div>
                            </div>
                    </div>
                    <form action="include/bn_submit.switch.php" id="submit_form_checkid" method="post" target="submit_form_frame">
				        <input type="hidden" name="Vcl_FunName" value="CheckId"/>
				        <input type="hidden" name="Vcl_CheckId" id="Vcl_CheckId" value=""/>
			        </form>
                    <form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" name="Vcl_FunName" value="<?php echo($s_funname)?>"/>
						<input type="hidden" name="Vcl_Id" value="<?php echo($_GET['id'])?>"/>
                    	<div class="sss_form">
                    		<?php 
                    		require_once 'ye_form.php';
                    		?>               	     	
							<div class="item" style="width:98%;margin-bottom:0px;">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Cancel'))?></button>
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="stu_modify(<?php 
							if($_GET['id']>0)
							{
								echo('true');
							}else{
								echo('false');
							}
							?>)"><?php echo(Text::Key('Submit'))?></button>
							</div>
                     	</div>
                     </form>
<script src="js/control.fun.js" type="text/javascript"></script>
<script src="js/data.code.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/css/bootstrap-datetimepicker.css"/>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/locales/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
<?php 
if($_GET['id']>0)
{
	echo('document.getElementById("Vcl_Name").value="'.$o_stu->getName().'";');
	echo('document.getElementById("Vcl_Sex").value="'.$o_stu->getSex().'";');
	echo('document.getElementById("Vcl_IdType").value="'.$o_stu->getIdType().'";');
	echo('document.getElementById("Vcl_ID").value="'.$o_stu->getId().'";');
	echo('document.getElementById("Vcl_Birthday").value="'.$o_stu->getBirthday().'";');
	
	
	
	echo('document.getElementById("Vcl_Xuexing").value="'.$o_stu->getXuexing().'";');
	echo('document.getElementById("Vcl_Jiankang").value="'.$o_stu->getJiankang().'";');
	echo('document.getElementById("Vcl_IsYiwang").value="'.$o_stu->getIsYiwang().'";');
	echo('change_yiwang(document.getElementById("Vcl_IsYiwang"));');
	if($o_stu->getIsYiwang()=='是')echo('document.getElementById("Vcl_Illness").value="'.$o_stu->getIllness().'";');
	echo('document.getElementById("Vcl_IsShoushu").value="'.$o_stu->getIsShoushu().'";');
	echo('change_shoushu(document.getElementById("Vcl_IsShoushu"));');
	if($o_stu->getIsShoushu()=='是')echo('document.getElementById("Vcl_Shoushu").value="'.$o_stu->getShoushu().'";');
	echo('document.getElementById("Vcl_IsYizhi").value="'.$o_stu->getIsYizhi().'";');
	echo('document.getElementById("Vcl_IsGuomin").value="'.$o_stu->getIsGuomin().'";');
	echo('change_guomin(document.getElementById("Vcl_IsGuomin"));');
	if($o_stu->getIsGuomin()=='是')echo('document.getElementById("Vcl_Allergic").value="'.$o_stu->getAllergic().'";');
	echo('document.getElementById("Vcl_IsYichuan").value="'.$o_stu->getIsYichuan().'";');
	echo('change_yichuan(document.getElementById("Vcl_IsYichuan"));');
	if($o_stu->getIsYichuan()=='是')echo('document.getElementById("Vcl_Qitabingshi").value="'.$o_stu->getQitabingshi().'";');
	echo('document.getElementById("Vcl_Beizhu").value="'.$o_stu->getBeizhu().'";');
	echo('document.getElementById("Vcl_Nationality").value="'.$o_stu->getNationality().'";');
	echo('document.getElementById("Vcl_ClassId").value="'.$o_stu->getClassNumber().'";');
	echo('document.getElementById("Vcl_Gangao").value="'.$o_stu->getGangao().'";'); 
	echo('document.getElementById("Vcl_Jiudu").value="'.$o_stu->getJiudu().'";');
	if ($o_stu->getNationality()=='中国')
	{
		echo('document.getElementById("Vcl_Only").value="'.$o_stu->getOnly().'";');
		echo('document.getElementById("Vcl_OnlyCode").value="'.$o_stu->getOnlyCode().'";');
		echo('document.getElementById("Vcl_Nation").value="'.$o_stu->getNation().'";');
		
		echo('document.getElementById("Vcl_Gangao").value="'.$o_stu->getGangao().'";');
		echo('change_only(document.getElementById("Vcl_Only"));');
		if ($o_stu->getOnly()=='否')echo('document.getElementById("Vcl_IsFirst").value="'.$o_stu->getIsFirst().'";');
		echo('document.getElementById("Vcl_IsLieshi").value="'.$o_stu->getIsLieshi().'";');
		echo('document.getElementById("Vcl_IsGuer").value="'.$o_stu->getIsGuer().'";');
		echo('document.getElementById("Vcl_IsWugong").value="'.$o_stu->getIsWugong().'";');
		echo('document.getElementById("Vcl_IsDibao").value="'.$o_stu->getIsDibao().'";');
		echo('document.getElementById("Vcl_IsLiushou").value="'.$o_stu->getIsLiushou().'";');
		echo('change_isdibao(document.getElementById("Vcl_IsDibao"));');
		if ($o_stu->getIsDibao()=='是')echo('document.getElementById("Vcl_DibaoCode").value="'.$o_stu->getDibaoCode().'";');
		echo('document.getElementById("Vcl_IsZizhu").value="'.$o_stu->getIsZizhu().'";');
	    echo('document.getElementById("Vcl_IsCanji").value="'.$o_stu->getIsCanji().'";');
		echo('change_iscanji(document.getElementById("Vcl_IsCanji"));');
		if($o_stu->getIsCanji()=='是')
		{
			echo('document.getElementById("Vcl_CanjiType").value="'.$o_stu->getCanjiType().'";');
			echo('document.getElementById("Vcl_CanjiCode").value="'.$o_stu->getCanjiCode().'";');		
		}
		//echo('document.getElementById("Vcl_InTime").value="'.$o_stu->getInTime().'";');
		
		
		//获取出生地编号
		if ($o_stu->getBirthplaceCode()=='')
		{
			
		}else{
			$o_birh_place_code1=new Student_City_Code($o_stu->getBirthplaceCode());
			$o_birh_place_code2=new Student_City_Code($o_birh_place_code1->getParentId());
			if ($o_birh_place_code2->getParentId()!='')
			{
				//说明是三级，否则是两级
				$o_birh_place_code3=new Student_City_Code($o_birh_place_code2->getParentId());
				echo('document.getElementById("Vcl_CCity").value="'.$o_birh_place_code3->getId().'";');
				echo('change_c_city(document.getElementById("Vcl_CCity"));');
				echo('document.getElementById("Vcl_CArea").value="'.$o_birh_place_code2->getId().'";');
				echo('change_c_area(document.getElementById("Vcl_CArea"));');
				echo('document.getElementById("Vcl_CStreet").value="'.$o_birh_place_code1->getId().'";');
			}else{
				echo('document.getElementById("Vcl_CCity").value="'.$o_birh_place_code2->getId().'";');
				echo('change_c_city(document.getElementById("Vcl_CCity"));');
				echo('document.getElementById("Vcl_CArea").value="'.$o_birh_place_code1->getId().'";');
			}
		}
		

		echo('document.getElementById("Vcl_IdQuality").value="'.$o_stu->getIdQuality().'";');
		echo('change_qulity(document.getElementById("Vcl_IdQuality"));');
		if ($o_stu->getIdQualityType()!='')
		{
			if($o_stu->getIdQuality()=='非农业户口')echo('document.getElementById("Vcl_IdQualityType").value="'.$o_stu->getIdQualityType().'";');
		}	
		
		//获取户籍编号
		if ($o_stu->getHCode()!='')
		{
			$o_h_code1=new Student_City_Code($o_stu->getHCode());
			$o_h_code2=new Student_City_Code($o_h_code1->getParentId());
			if ($o_h_code2->getParentId()!='')
			{
				//说明是三级，否则是两级
				$o_h_code3=new Student_City_Code($o_h_code2->getParentId());
				echo('document.getElementById("Vcl_HCity").value="'.$o_h_code3->getId().'";');
				echo('change_h_city(document.getElementById("Vcl_HCity"));');
				echo('document.getElementById("Vcl_HArea").value="'.$o_h_code2->getId().'";');
				echo('change_h_qu(document.getElementById("Vcl_HArea"));');
				echo('document.getElementById("Vcl_HStreet").value="'.$o_h_code1->getId().'";');
			}else{
				//如果是两级，需要判断是否是北京市西城区，如果是，需要显示街道和社区
				echo('document.getElementById("Vcl_HCity").value="'.$o_h_code2->getId().'";');
				echo('change_h_city(document.getElementById("Vcl_HCity"));');
				echo('document.getElementById("Vcl_HArea").value="'.$o_h_code1->getId().'";');
				echo('change_h_qu(document.getElementById("Vcl_HArea"));');
				if ($o_stu->getHCode()=='110102000000')
				{
					echo('document.getElementById("Vcl_HStreet").value="'.$o_stu->getHStreet().'";');
					echo('change_h_jiedao(document.getElementById("Vcl_HStreet"));');
					echo('document.getElementById("Vcl_HShequ").value="'.$o_stu->getHShequ().'";');
				}
			}
		}else{
			$s_space_id2=substr($o_stu->getId (),0,6);
			if ($s_space_id2=="110104")
			{
				$s_space_id2="110102";	
			}
			if ($s_space_id2=="110103")
			{
				$s_space_id2="110101";	
			}
			$s_space_id2="".$s_space_id2.'000000';
			$s_space_id1=substr($o_stu->getId (),0,3);
			if ($s_space_id1=="110104")
			{
				$s_space_id1="110102";	
			}
			if ($s_space_id1=="110103")
			{
				$s_space_id1="110101";	
			}
			$s_space_id1="".$s_space_id1.'000000000';
			echo('document.getElementById("Vcl_HCity").value="'.$s_space_id1.'";');
			echo('change_h_city(document.getElementById("Vcl_HCity"));');
			echo('document.getElementById("Vcl_HArea").value="'.$s_space_id2.'";');
			echo('change_h_qu(document.getElementById("Vcl_HArea"));');
			if ($s_space_id2=='110102000000')
			{
				echo('document.getElementById("Vcl_HStreet").value="'.$o_stu->getHStreet().'";');
				echo('change_h_jiedao(document.getElementById("Vcl_HStreet"));');
				echo('document.getElementById("Vcl_HShequ").value="";');
			}
		}	
		
		echo('document.getElementById("Vcl_HAdd").value="'.$o_stu->getHAdd().'";');
		echo('document.getElementById("Vcl_HOwner").value="'.$o_stu->getHOwner().'";');
		echo('document.getElementById("Vcl_HGuanxi").value="'.$o_stu->getHGuanxi().'";');
	}else{
		
		echo('change_nationality(document.getElementById("Vcl_Nationality"));');
	}
	echo('document.getElementById("Vcl_ZSame").value="'.$o_stu->getZSame().'";');
	echo('change_address(document.getElementById("Vcl_ZSame"));');
	if($o_stu->getZSame()=='否')
	{
		echo('document.getElementById("Vcl_ZCity").value="'.$o_stu->getZCity().'";');
		echo('change_z_city(document.getElementById("Vcl_ZCity"));');
		if($o_stu->getZCity()=='北京市')
		{
			echo('document.getElementById("Vcl_ZArea").value="'.$o_stu->getZArea().'";');
			echo('change_z_qu(document.getElementById("Vcl_ZArea"));');
			if($o_stu->getZArea()=="西城区")
			{
				echo('document.getElementById("Vcl_ZStreet").value="'.$o_stu->getZStreet().'";');
				echo('change_z_jiedao(document.getElementById("Vcl_ZStreet"));');
				echo('document.getElementById("Vcl_ZShequ").value="'.$o_stu->getZShequ().'";');
			}			
		}		
	}
	if($o_stu->getZSame()=='')
	{
		echo('document.getElementById("Vcl_ZCity").value="北京市";');
		echo('document.getElementById("Vcl_ZArea").value="'.$o_stu->getZArea().'区";');
		echo('change_z_qu(document.getElementById("Vcl_ZArea"));');
		echo('document.getElementById("Vcl_ZStreet").value="'.$o_stu->getZStreet().'";');
		echo('change_z_jiedao(document.getElementById("Vcl_ZStreet"));');
	}
	echo('document.getElementById("Vcl_ZAdd").value="'.$o_stu->getZAdd().'";');
	echo('document.getElementById("Vcl_ZProperty").value="'.$o_stu->getZProperty().'";');
	echo('change_z_property(document.getElementById("Vcl_ZProperty"));');
	echo('document.getElementById("Vcl_ZOwner").value="'.$o_stu->getZOwner().'";');
	echo('document.getElementById("Vcl_ZGuanxi").value="'.$o_stu->getZGuanxi().'";');
	if($o_stu->getJh1Connection()!='')
	{
		echo('document.getElementById("Vcl_Jh1Connection").value="'.$o_stu->getJh1Connection().'";');
		echo('document.getElementById("Vcl_Jh1IsZhixi").value="'.$o_stu->getJh1IsZhixi().'";');
		echo('document.getElementById("Vcl_Jh1IsCanji").value="'.$o_stu->getJh1IsCanji().'";');
		echo('change_canjizheng1(document.getElementById("Vcl_Jh1IsCanji"));');
		echo('document.getElementById("Vcl_Jh1Name").value="'.$o_stu->getJh1Name().'";');
		echo('document.getElementById("Vcl_Jh1Job").value="'.$o_stu->getJh1Job().'";');
		echo('document.getElementById("Vcl_Jh1Danwei").value="'.$o_stu->getJh1Danwei().'";');
		if($o_stu->getJh1IsCanji()=="是")
		{
			echo('document.getElementById("Vcl_Jh1CanjiCode").value="'.$o_stu->getJh1CanjiCode().'";');
		}
		echo('document.getElementById("Vcl_Jh1IdType").value="'.$o_stu->getJh1IdType().'";');
		echo('document.getElementById("Vcl_Jh1Jiaoyu").value="'.$o_stu->getJh1Jiaoyu().'";');
		echo('document.getElementById("Vcl_Jh1ID").value="'.$o_stu->getJh1Id().'";');
		echo('document.getElementById("Vcl_Jh1Phone").value="'.$o_stu->getJh1Phone().'";');
		
		if ($o_stu->getJh2Name()!='')
		{
			echo('document.getElementById("Vcl_Jh2Connection").value="'.$o_stu->getJh2Connection().'";');
			echo('document.getElementById("Vcl_Jh2IsZhixi").value="'.$o_stu->getJh2IsZhixi().'";');
			echo('document.getElementById("Vcl_Jh2IsCanji").value="'.$o_stu->getJh2IsCanji().'";');
			echo('change_canjizheng2(document.getElementById("Vcl_Jh2IsCanji"));');
			echo('document.getElementById("Vcl_Jh2Name").value="'.$o_stu->getJh2Name().'";');
			echo('document.getElementById("Vcl_Jh2Job").value="'.$o_stu->getJh2Job().'";');
			echo('document.getElementById("Vcl_Jh2Danwei").value="'.$o_stu->getJh2Danwei().'";');
			if($o_stu->getJh2IsCanji()=="是")
			{
				echo('document.getElementById("Vcl_Jh2CanjiCode").value="'.$o_stu->getJh2CanjiCode().'";');
			}
			echo('document.getElementById("Vcl_Jh2IdType").value="'.$o_stu->getJh2IdType().'";');
			echo('document.getElementById("Vcl_Jh2Jiaoyu").value="'.$o_stu->getJh2Jiaoyu().'";');
			echo('document.getElementById("Vcl_Jh2ID").value="'.$o_stu->getJh2Id().'";');
			echo('document.getElementById("Vcl_Jh2Phone").value="'.$o_stu->getJh2Phone().'";');
		}
		
		if ($o_stu->getJianhuName()!='')
		{
			echo('document.getElementById("Vcl_JianhuConnection").value="'.$o_stu->getJianhuConnection().'";');
			echo('document.getElementById("Vcl_JianhuName").value="'.$o_stu->getJianhuName().'";');
			echo('document.getElementById("Vcl_JianhuPhone").value="'.$o_stu->getJianhuPhone().'";');
		}
	}else{
		//读取监护人信息
		$o_janhuren=new Student_City_Code();
		$o_janhuren->PushWhere ( array ('&&', 'StudentId', '=',$o_stu->getUid() ) );
		$o_janhuren->PushOrder ( array ('GuardianId', 'A' ) );
		if ($o_janhuren->getAllCount()>0)
		{
			if ($o_janhuren->getName (0)=='')
			{
				echo('document.getElementById("Vcl_Jh1Connection").value="母亲";');
				echo('document.getElementById("Vcl_Jh1Name").value="'.$o_janhuren->getName(1).'";');
				echo('document.getElementById("Vcl_Jh1Danwei").value="'.$o_janhuren->getUnit(1).'";');
				echo('document.getElementById("Vcl_Jh1Phone").value="'.$o_janhuren->getPhone(1).'";');
			}else{
				echo('document.getElementById("Vcl_Jh1Name").value="'.$o_janhuren->getName(0).'";');
				echo('document.getElementById("Vcl_Jh1Danwei").value="'.$o_janhuren->getUnit(0).'";');
				echo('document.getElementById("Vcl_Jh1Phone").value="'.$o_janhuren->getPhone(0).'";');
				echo('document.getElementById("Vcl_Jh2Connection").value="母亲";');
				echo('document.getElementById("Vcl_Jh2Name").value="'.$o_janhuren->getName(1).'";');
				echo('document.getElementById("Vcl_Jh2Danwei").value="'.$o_janhuren->getUnit(1).'";');
				echo('document.getElementById("Vcl_Jh2Phone").value="'.$o_janhuren->getPhone(1).'";');
				if($o_janhuren->getName (2)!='')
				{
					echo('document.getElementById("Vcl_JianhuConnection").value="'.$o_janhuren->getConnection(2).'";');
					echo('document.getElementById("Vcl_JianhuName").value="'.$o_janhuren->getName(2).'";');
					echo('document.getElementById("Vcl_JianhuPhone").value="'.$o_janhuren->getPhone(2).'";');
				}
			}
			
		}
	}
}
?>
$('#c_area select').selectpicker('refresh');
$('#c_street select').selectpicker('refresh');
$('#h_qu select').selectpicker('refresh');
$('#h_jiedao select').selectpicker('refresh');
$('#h_shequ select').selectpicker('refresh');
$('#z_qu select').selectpicker('refresh');
$('#z_jiedao select').selectpicker('refresh');
$('#z_shequ select').selectpicker('refresh');
})
$('.form_date').datetimepicker({
    language:  'zh-CN',
    weekStart: 1,
    todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 0
});
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>