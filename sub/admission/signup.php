<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120101);
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
		<p> 开始时间：<b><?php echo($a_result["audit_start_date"])?></b><br/>结束时间：<b><?php echo($a_result["audit_stop_date"])?></b><br/><br/>注：规定时间段内，未对报名信息进行操作，报名信息将自动变为<b>“不允许核验”</b>状态！ </p>
	</div>
    <?php
}
?>
					<link rel="stylesheet" type="text/css" href="css/style.css"/>
					<form action="include/bn_submit.switch.php" id="submit_form" method="post" target="submit_form_frame">
						<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
						<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
						<input type="hidden" id="Vcl_FunName" name="Vcl_FunName" value=""/>
						<input type="hidden" name="Vcl_RejectReason" id="Vcl_RejectReason"/>
						<input type="hidden" name="Vcl_Id" id="Vcl_Id"/>
					</form>
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption">报名列表</div>
                            	<div class="row">
								  <div class="col-lg-6">
								    <div class="input-group" style="width:300px;" >
								      <input id="Vcl_Key" type="text" class="form-control" placeholder="编号/姓名/证件号" value="<?php echo($s_key)?>">
								      <span class="input-group-btn">
								        <button class="btn btn-primary" type="button" onclick="search()"><span  class="glyphicon glyphicon-search"></span></button>
								        <script>
    								        $(function(){
    								        	$('#Vcl_Key').keypress(function(event){  
    								        	    var keycode = (event.keyCode ? event.keyCode : event.which);  
    								        	    if(keycode == '13'){  
    								        	    	search()   
    								        	    }  
    								        	}); 
							        	    });
    								        function search()
    								        {
    								        	var fun='<?php echo($s_fun)?>';
    								        	var id='Vcl_Key'
    								        	$('.small_loading').fadeIn(100);
    								        	$.cookie(fun+"Page",1);
    								        	$.cookie(fun+"Key",document.getElementById(id).value);
    								        	var sort=$.cookie(fun+"Sort"); 
    								        	var item=$.cookie(fun+"Item"); 
    								        	var key=$.cookie(fun+"Key");
    								        	table_load(fun,item,sort,1,encodeURIComponent(document.getElementById(id).value),'');    
    								        }
								        </script>
								      </span>
								    </div>
								  </div>
								</div>								
								<button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;outline: medium none;margin-left:10px;" onclick="output(1)">
                                <span  class="glyphicon glyphicon-floppy-save"></span>&nbsp;导出全部</button>
                                <button id="user_add_btn" type="button" class="btn btn-danger" aria-hidden="true" style="float: right;outline: medium none;margin-left:10px;" onclick="reject()">
                                <span  class="glyphicon glyphicon glyphicon-remove"></span>&nbsp;不允许核验</button>
								<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none;margin-left:10px;" onclick="allow()">
                                <span  class="glyphicon glyphicon-ok"></span>&nbsp;允许核验</button>
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
    function allow()
    {
    	var a_data=[];
    	for(var i=0;i<$('tbody input[type=checkbox]').length;i++)
    	{
    		obj=$('tbody input[type=checkbox]')[i]
    		if (obj.checked)
    		{
    			a_data.push(obj.value);
    		}
    	}
    	if(a_data.length==0)
    	{
    		dialog_message("请先选择报名记录！")
    		return
    	}
    	$('#Vcl_FunName').val('AllowAudit');
    	$('#Vcl_Id').val(arrayToJson(a_data));
    	dialog_confirm('确认允许信息核验吗？<br/><br/>确认后：<br/>1. <b>'+a_data.length+'</b> 个报名记录幼儿监护人的微信将收到信息核验通知。<br/>2. 选中的幼儿报名信息将会进入“<b>待发体检通知</b>”模块。<br/>3. 本页面将会被刷新。<br/><br/>注：该操作不能撤销，请谨慎操作。',function (){
    		loading_show();		
    		$('#submit_form').submit();
    	});	
    }
    function reject()
    {
    	var a_data=[];
    	for(var i=0;i<$('tbody input[type=checkbox]').length;i++)
    	{
    		obj=$('tbody input[type=checkbox]')[i]
    		if (obj.checked)
    		{
    			a_data.push(obj.value);
    		}
    	}
    	if(a_data.length==0)
    	{
    		dialog_message("请先选择报名记录！")
    		return
    	}
    	$('#Vcl_FunName').val('RejectAudit');
    	$('#Vcl_Id').val(arrayToJson(a_data));
    	dialog_confirm('确认不允许信息核验吗？<br/><br/>确认后：<br/>1. <b>'+a_data.length+'</b> 个报名记录将不允许信息核验！<br/>2. 选中的幼儿报名信息将会进入“<b>不允许核验</b>”模块。<br/>3. 本页面将会被刷新。<br/>注：该操作不能撤销，请谨慎操作。<div style="text-align:left;margin-top:15px;margin-bottom:5px;">请填写原因：</div><input id="Vcl_Reason" type="text" maxlength="200" style="width:100%" placeholder="必填" class="form-control"/>',function (){
    		$('#Vcl_RejectReason').val($('#Vcl_Reason').val());
    		loading_show();		
    		$('#submit_form').submit();
    	});	
    }
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>