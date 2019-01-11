<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120100);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='SignupTable';
$s_item='Id';
$s_page=1;
$s_sort='A';
$s_key='';
if($_COOKIE [$s_fun.'Item'])
{
	$s_item=$_COOKIE [$s_fun.'Item'];
	$s_page=$_COOKIE [$s_fun.'Page'];
	$s_sort=$_COOKIE [$s_fun.'Sort'];
	$s_key=$_COOKIE [$s_fun.'Key'];
}
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
//获取报名平台时间节点信息
require_once RELATIVITY_PATH.'sub/admission/include/ajax_operate.class.php';
$o_operate = new Operate_Admission();
$s_url=$o_operate->S_Url.'get_student_info.php';
$a_data=array(
    'license'=>$o_operate->S_License,
    'studentid'=>$_GET['id']
);
$o_base=new Bn_Basic();
$s_result=$o_base->httpsRequest($s_url,$a_data);
$a_result=json_decode($s_result,true);
if ($a_result["errcode"]==0 && $s_result!='' && $_COOKIE [$s_fun.'Note']!='close')
{
    $a_data=$a_result['info'];
}else{
    echo("<script>window.history.go(-1);</script>");
    exit(0);
}
function filter($str)
{
    if ($str=='')
    {
        echo('\\');
    }else{
        echo($str);
    }
}
?>

<style>
.flip-content td{
	font-size:14px !important;
	padding: 8px !important;
}
.flip-content th{
	font-size:14px !important;
	padding: 8px !important;
}
hr {
    margin-top:10px; 
    margin-bottom: 10px;
}
h4 {
    padding-top:20px; 
}
.table-bordered .label {
    font-size: 10px;
    border-radius: 10px!important;
}
.table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
	border-bottom-width: 1px;
}
</style>
					<link rel="stylesheet" type="text/css" href="css/style.css"/>
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption">
                            	<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 
                                	幼儿报名详细信息
                            </div>
                        </div>
                    </div>
                    						<div style="padding-left:50px;padding-right:50px;padding-bottom:30px;">
                    							<h4>基本信息</h4>
                                                <hr>   
                                                <table class="table table-bordered table-striped table-condensed flip-content">
                                                    <thead>
                                                        <tr>
                                                            <th> 姓名 </th>
                                                            <th> 性别 </th>
                                                            <th> 证件类型 </th>
                                                            <th> 证件号码 </th>
                                                            <th> 出生日期 </th>
                                                            <th> 国籍 </th>
                                                            <th> 民族 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['Name'])?> </td>
                                                            <td> <?php filter($a_data['Sex'])?> </td>
                                                            <td> <?php filter($a_data['CardType'])?> </td>
                                                            <td> <?php filter($a_data['CardId'])?> </td>
                                                            <td> <?php filter($a_data['Birthday'])?> </td>
                                                            <td> <?php filter($a_data['Nationality'])?> </td>
                                                            <td> <?php filter($a_data['Nation'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th> 港澳台侨 </th>
                                                            <th> 是否头胎 </th>
                                                            <th> 是否烈士子女 </th>
                                                            <th> 是否孤儿 </th>
                                                            <th> 是否进城务工随迁子女 </th>
                                                            <th> 是否留守儿童 </th>
                                                            <th> 是否低保 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['Gangao'])?> </td>
                                                            <td> <?php filter($a_data['IsFirst'])?> </td>
                                                            <td> <?php filter($a_data['IsLieshi'])?> </td>
                                                            <td> <?php filter($a_data['IsGuer'])?> </td>
                                                            <td> <?php filter($a_data['IsWugong'])?> </td>
                                                            <td> <?php filter($a_data['IsLiushou'])?> </td>
                                                            <td> <?php filter($a_data['IsDibao'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2"> 低保证号 </th>
                                                            <th > 是否正在接收资助 </th>
                                                            <th> 是否残疾儿童 </th>
                                                            <th colspan="2"> 残疾儿童类别 </th>
                                                            <th> 残疾证号 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td colspan="2"> <?php filter($a_data['DibaoCode'])?> </td>
                                                            <td> <?php filter($a_data['IsZizhu'])?> </td>
                                                            <td> <?php filter($a_data['IsCanji'])?> </td>
                                                            <td colspan="2"> <?php filter($a_data['CanjiType'])?> </td>
                                                            <td> <?php filter($a_data['CanjiCode'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                            	</table>
                                            	<h4>健康信息</h4>
                                                <hr>   
                                                <table class="table table-bordered table-striped table-condensed flip-content">
                                                    <thead>
                                                        <tr>
                                                            <th> 总体健康状况 </th>
                                                            <th> 血型 </th>
                                                            <th> 是否有以往病史 </th>
                                                            <th> 以往病史 </th>
                                                            <th> 是否有手术史 </th>
                                                            <th> 手术名称 </th>
                                                            <th> 是否有器官移植史 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['Jiankang'])?> </td>
                                                            <td> <?php filter($a_data['Xuexing'])?> </td>
                                                            <td> <?php filter($a_data['IsYiwang'])?> </td>
                                                            <td> <?php filter($a_data['Illness'])?> </td>
                                                            <td> <?php filter($a_data['IsShoushu'])?> </td>
                                                            <td> <?php filter($a_data['Shoushu'])?> </td>
                                                            <td> <?php filter($a_data['IsYizhi'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th> 是否有过敏史 </th>
                                                            <th> 过敏源 </th>
                                                            <th> 是否有族遗传病史 </th>
                                                            <th> 家族遗传病史名称 </th>
                                                            <th colspan="3"> 备注 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['IsGuomin'])?> </td>
                                                            <td> <?php filter($a_data['Allergic'])?> </td>
                                                            <td> <?php filter($a_data['IsYichuan'])?> </td>
                                                            <td> <?php filter($a_data['Qitabingshi'])?> </td>
                                                            <td colspan="3"> <?php filter($a_data['Beizhu'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                            	</table>
                                            	<h4>户籍信息</h4>
                                                <hr>  
                                                <table class="table table-bordered table-striped table-condensed flip-content">
                                                    <thead>
                                                        <tr>
                                                            <th> 出生所在地 </th>
                                                            <th> 户口性质 </th>
                                                            <th> 非农业户口类型 </th>
                                                            <th> 落户日期 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['Birthplace '])?> </td>
                                                            <td> <?php filter($a_data['IdQuality '])?> </td>
                                                            <td> <?php filter($a_data['IdQualityType '])?> </td>
                                                            <td> <?php filter($a_data['HInTime'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                        	<th> 户籍所在地 </th>
                                                            <th> 户籍详细地址</th>
                                                            <th> 户主姓名 </th>
                                                            <th> 户主与幼儿关系 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                    		<td> <?php filter($a_data['Birthplace '])?> </td>
                                                        	<td> <?php filter($a_data['HAdd '])?> </td>
                                                            <td> <?php filter($a_data['HOwner '])?> </td>
                                                            <td> <?php filter($a_data['HGuanxi '])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                            	</table> 
                                            	<h4>住址信息</h4>
                                                <hr>    
                                                <table class="table table-bordered table-striped table-condensed flip-content">
                                                    <thead>
                                                        <tr>
                                                            <th> 现住址是否与户籍为同一地址 </th>
                                                            <th> 现住址所在地 </th>
                                                            <th> 现住址详细地址 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['ZSame'])?> </td>
                                                            <td> <?php filter($a_data['ZCity'].$a_data['ZArea'].$a_data['ZStreet'].$a_data['Z_Shequ'])?> </td>
                                                            <td> <?php filter($a_data['ZAdd '])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th> 现住址房屋属性 </th>
                                                            <th> 产权人姓名 </th>
                                                            <th> 产权人与孩子关系 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['ZProperty'])?> </td>
                                                            <td> <?php filter($a_data['ZOwner'])?> </td>
                                                            <td> <?php filter($a_data['ZGuanxi'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                            	</table>   
                                            	<h4>第一法定监护人信息</h4>
                                                <hr>     
                                                <table class="table table-bordered table-striped table-condensed flip-content">
                                                    <thead>
                                                        <tr>
                                                            <th> 关系 </th>
                                                            <th> 姓名 </th>
                                                            <th> 证件类型 </th>
                                                            <th> 证件号码 </th>
                                                            <th> 是否是直系亲属 </th>
                                                            <th> 职业状况 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['Jh1Connection'])?> </td>
                                                        	<td> <?php filter($a_data['Jh1Name'])?> </td>
                                                        	<td> <?php filter($a_data['Jh1IdType'])?> </td>
                                                        	<td> <?php filter($a_data['Jh1Id'])?> </td>
                                                        	<td> <?php filter($a_data['Jh1IsZhixi'])?> </td>
                                                        	<td> <?php filter($a_data['Jh1Job'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th> 教育程度 </th>
                                                            <th> 联系电话 </th>
                                                            <th colspan="2"> 工作单位 </th>
                                                            <th> 是否残疾 </th>
                                                            <th> 残疾证号 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['Jh1Jiaoyu'])?> </td>
                                                        	<td> <?php filter($a_data['Jh1Phone'])?> </td>
                                                        	<td colspan="2"> <?php filter($a_data['Jh1Danwei'])?> </td>
                                                        	<td> <?php filter($a_data['Jh1IsCanji'])?> </td>
                                                        	<td> <?php filter($a_data['Jh1CanjiCode'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                            	</table>
                                                <table class="table table-bordered table-striped table-condensed flip-content">
                                                    <thead>
                                                        <tr>
                                                            <th> 关系 </th>
                                                            <th> 姓名 </th>
                                                            <th> 证件类型 </th>
                                                            <th> 证件号码 </th>
                                                            <th> 是否是直系亲属 </th>
                                                            <th> 职业状况 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['Jh2Connection'])?> </td>
                                                        	<td> <?php filter($a_data['Jh2Name'])?> </td>
                                                        	<td> <?php filter($a_data['Jh2IdType'])?> </td>
                                                        	<td> <?php filter($a_data['Jh2Id'])?> </td>
                                                        	<td> <?php filter($a_data['Jh2IsZhixi'])?> </td>
                                                        	<td> <?php filter($a_data['Jh2Job'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th> 教育程度 </th>
                                                            <th> 联系电话 </th>
                                                            <th colspan="2"> 工作单位 </th>
                                                            <th> 是否残疾 </th>
                                                            <th> 残疾证号 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['Jh2Jiaoyu'])?> </td>
                                                        	<td> <?php filter($a_data['Jh2Phone'])?> </td>
                                                        	<td colspan="2"> <?php filter($a_data['Jh2Danwei'])?> </td>
                                                        	<td> <?php filter($a_data['Jh2IsCanji'])?> </td>
                                                        	<td> <?php filter($a_data['Jh2CanjiCode'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                            	</table>
                                            	<h4>其他监护人信息</h4>
                                                <hr>     
                                                <table class="table table-bordered table-striped table-condensed flip-content">
                                                    <thead>
                                                        <tr>
                                                            <th> 关系 </th>
                                                            <th> 姓名 </th>
                                                            <th> 联系电话 </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    	<tr>
                                                        	<td> <?php filter($a_data['JianhuConnection'])?> </td>
                                                        	<td> <?php filter($a_data['JianhuName'])?> </td>
                                                        	<td> <?php filter($a_data['JianhuPhone'])?> </td>
                                                        </tr>                                                                                                             
                                                    </tbody>
                                            	</table>
                                            	<div class="item">
                    							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Back'))?></button>
                    							</div>
                    						</div>
                    							
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>