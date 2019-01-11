<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120107);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='WaitingSupplementTable';
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
		<p> 补录开始时间：<b><?php echo($a_result["supplement_start_date"])?></b><br/>补录结束时间：<b><?php echo($a_result["supplement_stop_date"])?></b><br/><br/>注：等待补录报名列表内为报名状态：“不允许核验”、“核验不通过”、“未录取”的报名记录。如果幼儿被其他幼儿园允许体检或录取，那么该幼儿报名记录将从此列表中消失。 </p>
	</div>
    <?php
}
?>
					<link rel="stylesheet" type="text/css" href="css/style.css"/>
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption">报名列表（等待补录）</div>
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
    function allow(id,name,state)
	{
		var title='';
		var comment='';
		if (state==2)
		{
			var title='确认幼儿“<b>'+name+'”</b>允许信息核验吗？';
			var comment='确认后：<br/>1. 幼儿监护人的微信将收到信息核验通知。<br/>2. 选中的幼儿报名信息将会进入“<b>待发体检通知</b>”模块。<br/>3. 本页面将会被刷新。<br/><br/>注：该操作不能撤销，请谨慎操作。';
		}
		if (state==4)
		{
			var title='确认幼儿“<b>'+name+'”</b>允许体检吗？';
			var comment='确认后：<br/>1. 幼儿监护人的微信将收到允许体检通知。<br/>2. 选中的幼儿报名信息将会进入“<b>等待录取</b>”模块。<br/>3. 本页面将会被刷新。<br/><br/>注：该操作不能撤销，请谨慎操作。';
		}
		if (state==6)
		{
			var title='确认录取幼儿“<b>'+name+'”</b>吗？';
			var comment='确认后：<br/>1. 幼儿监护人的微信将收到录取通知。<br/>2. 选中的幼儿报名信息将会进入“<b>等待分班</b>”模块。<br/>3. 本页面将会被刷新。<br/><br/>注：该操作不能撤销，请谨慎操作。';
		}
		dialog_confirm(title+'<br/><br/>'+comment,function(){
			loading_show();
	    	var data = 'Ajax_FunName=AllowSupplement'; //后台方法
	        data = data + '&Id=' + id;
	        $.getJSON("include/bn_submit.switch.php", data, function (json) {
	        	loading_hide();
	        	if (json.success==0)
	        	{
	        		dialog_error(json.text)
	        	}else{
		        	dialog_success('操作成功，点击“确定”继续！',function(){location.reload();});
	        	}  
	        })
	    })
	}
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>