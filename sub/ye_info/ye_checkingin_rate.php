<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120209);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='YeCheckinginRateTable';
$s_item='Grade';
$s_page=1;
$s_sort='A';
$o_date = new DateTime ( 'Asia/Chongqing' );
$s_key=$o_date->format ( 'Y' ) . '-' . $o_date->format ( 'm' ).'-01' ;
$s_key=date("Y-m", strtotime("-1 months", strtotime($s_key)));
if($_COOKIE [$s_fun.'Item'])
{
	$s_item=$_COOKIE [$s_fun.'Item'];
	$s_page=$_COOKIE [$s_fun.'Page'];
	$s_sort=$_COOKIE [$s_fun.'Sort'];
}
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>

                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading" style="overflow: inherit; height: 43px;">
							         <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm" data-link-field="dtp_input2" style="width:200px;" data-link-format="yyyy-mm">
                    					<input onchange="checkingin_rate_change_date(this)" class="form-control" value="<?php echo($s_key);?>" size="16" type="text" id="Vcl_Date" name="Vcl_Date" readonly style="background-color:white">
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
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
					<?php 
					echo("table_sort('".$s_fun."','".$s_item."','".$s_sort."','".$s_page."','".$s_key."','')");
					?>
					</script>

<link rel="stylesheet" type="text/css" href="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/css/bootstrap-datetimepicker.css"/>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo(RELATIVITY_PATH)?>js/bootstrap/js/date/js/locales/bootstrap-datetimepicker.zh-CN.js" type="text/javascript"></script>	
<script>
$('.form_date').datetimepicker({
    language:  'zh-CN',
    weekStart: 1,
    todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 3,
	minView: 3,
	format: "yyyy-mm",//选择日期后，文本框显示的日期格式
	forceParse: 0
});
function checkingin_rate_change_date(obj)
{
	var fun='YeCheckinginRateTable';
	$('.small_loading').fadeIn(100);
	$.cookie(fun+"Page",1);
	var sort=$.cookie(fun+"Sort"); 
	var item=$.cookie(fun+"Item"); 
	table_load(fun,item,sort,1,obj.value,'');    
}
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>