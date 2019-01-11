<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120108);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='AreaSupplementTable';
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
$a_key=explode(' ', $s_key);
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
//获取报名平台时间节点信息
require_once RELATIVITY_PATH.'sub/admission/include/ajax_operate.class.php';
$o_operate = new Operate_Admission();
$s_url=$o_operate->S_Url.'get_signup_setup.php';
$a_data=array(
    'license'=>$o_operate->S_License
);
$o_base=new Bn_Basic();
$s_result=$o_base->httpsRequest($s_url,$a_data);
$a_result=json_decode($s_result,true);
if ($a_result["errcode"]==0 && $s_result!='' && $_COOKIE [$s_fun.'Note']!='close')
{
    ?>
    <div class="alert alert-danger">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="closeNote(this,'<?php echo($s_fun)?>Note')"></button>
		<strong>操作时间段</strong>
		<br/><br/>
		<p> 补录开始时间：<b><?php echo($a_result["supplement_start_date"])?></b><br/>补录结束时间：<b><?php echo($a_result["supplement_stop_date"])?></b><br/><br/>注：此搜索范围为全区（除本幼儿园以外）等待补录幼儿信息。如果搜索的幼儿，已经被其他幼儿园录取，那么将无法进行补录。 </p>
	</div>
    <?php
}
//获取可报名班级列表
require_once RELATIVITY_PATH.'sub/admission/include/ajax_operate.class.php';
$o_operate = new Operate_Admission();
$s_url=$o_operate->S_Url.'get_grade.php';
$a_data=array(
    'license'=>$o_operate->S_License
);
$o_base=new Bn_Basic();
$s_result=$o_base->httpsRequest($s_url,$a_data);
$a_result=json_decode($s_result,true);
$s_select='';
if ($a_result["errcode"]==0 && $s_result!='')
{
    for($i=0;$i<count($a_result['list']);$i++)
    {
        $s_select.='<option value="'.$a_result['list'][$i]['id'].'">'.$a_result['list'][$i]['name'].'</option>';
    }
}
?>
					<link rel="stylesheet" type="text/css" href="css/style.css"/>
					<h4 style="padding:20px;"><b>全区幼儿报名记录</b></h4>
					<div class="search-bar" style="padding-bottom: 20px;">
                    	<div style="padding-bottom:40px;">
                        	<div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                            	<div class="input-group">
                                	<input id="Vcl_Name" type="text" class="form-control" value="<?php echo($a_key[0])?>" placeholder="幼儿姓名" style="width:30%;border-right:0px;"><input id="Vcl_CardId" value="<?php echo($a_key[1])?>" type="text" class="form-control" placeholder="幼儿证件号码" style="width:70%;border-right:0px;">
                                    	<span class="input-group-btn">
                                        	<button class="btn btn-primary" type="button" onclick="search()" style="border: 1px solid #3498DB;"><span class="glyphicon glyphicon-search"></span> 搜索</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>
                        </div>
					<hr style="margin-bottom:0px;">
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption">搜索结果</div>							
                            </div>
                        <table class="table table-striped">
                            <thead>
                                <tr></tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="sss_page"></div>
					<script src="js/control.fun.js" type="text/javascript"></script>
					<script>
						table_sort('<?php echo($s_fun)?>','<?php echo($s_item)?>','<?php echo($s_sort)?>',<?php echo($s_page)?>,'<?php echo($s_key)?>')
					</script>
		
<script>
    var table='<?php echo($s_fun)?>';
    function search()
	{
		if ($('#Vcl_Name').val()=='')
		{
			dialog_message('[ 幼儿姓名 ] 不能为空！');
			return;
		}
		if ($('#Vcl_CardId').val()=='')
		{
			dialog_message('[ 幼儿证件号码 ] 不能为空！');
			return;
		}
		var fun=table;
		var sort=$.cookie(fun+"Sort"); 
		var item=$.cookie(fun+"Item");
        var otherKey=$.cookie(fun+"OtherKey"); 
		table_sort(fun,item,sort,1,$('#Vcl_Name').val()+' '+$('#Vcl_CardId').val(),'');    
	}
    function allow(id,name,state)
	{
		var title='确认幼儿“<b>'+name+'”</b>允许信息核验吗？';
		var comment='请选择报名年级：<select name="Vcl_Grade" id="Vcl_Grade" class="form-control" style="width:auto;display:initial;"><option value="">必选</option><?php echo($s_select)?></select><br/>确认后：<br/>1. 系统将自动生成二维码。<br/>2. 请将二维码拍照后发送给幼儿家长。<br/>3. 家长在微信中，长按照片识别照片中的二维码后即可。';
		dialog_confirm(title+'<br/><br/>'+comment,function(){
			if ($('#Vcl_Grade').val()=='')
			{
				dialog_message('请选择正确的 [ 报名年级 ]', function(){allow(id,name,state)});
				return;
			}
			var grade=$('#Vcl_Grade').val();
			loading_show();
			var data = 'Ajax_FunName=AllowAreaSupplementVerifyAuditTime'; //后台方法
	        $.getJSON("include/bn_submit.switch.php", data, function (json) {
	        	loading_hide();
	        	if (json.success==0)
	        	{
	        		dialog_error(json.text)
	        	}else{
	        		dialog_message('请拍照后发送给幼儿家长，幼儿家长在微信中，长按照片识别照片中的二维码后即可。<br/>注：拍照发送成功后，即可关闭此对话框，继续操作。<br/><img style="margin-left:20%;width:60%;" src="<?php echo(RELATIVITY_PATH)?>sub/webservice/signup_qrcode.php?id=supplement_'+id+'_'+grade+'_0"/>');
	        	}        	
	        })
	    })
	}
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>