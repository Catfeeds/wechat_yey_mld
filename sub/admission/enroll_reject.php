<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120106);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='EnrollRejectTable';
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
?>
					<link rel="stylesheet" type="text/css" href="css/style.css"/>
                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                            <div class="caption">报名列表（未被录取）</div>
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
    								        	    	search();
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
								<button id="user_add_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;outline: medium none;margin-left:10px;" onclick="output(6)">
                                <span  class="glyphicon glyphicon-floppy-save"></span>&nbsp;导出全部</button>
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
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>