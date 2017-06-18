<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120201);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
$s_fun='YeInfo';
$s_item='State';
$s_page=1;
$s_sort='D';
$s_key='';
if($_COOKIE [$s_fun.'Item'])
{
	$s_item=$_COOKIE [$s_fun.'Item'];
	$s_page=$_COOKIE [$s_fun.'Page'];
	$s_sort=$_COOKIE [$s_fun.'Sort'];
	$s_key=$_COOKIE [$s_fun.'Key'];
	$s_otherkey=$_COOKIE [$s_fun.$s_key.'OtherKey']; //因为Key当参数用了，所以就不要获取了
}
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>

                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading" style="overflow:inherit;height:43px;">
                            <div class="caption">在园幼儿信息列表</div>                            
                            <div class="row">
								  <div class="col-lg-6">
								    <div class="input-group" style="width:300px;" >
								      <input id="Vcl_KeyYeInfo" type="text" class="form-control" placeholder="幼儿姓名/证件号" value="">
								      <span class="input-group-btn">
								        <button class="btn btn-primary" type="button" onclick="search_for_yeinfo()"><span  class="glyphicon glyphicon-search"></span></button>
								      </span>
								    </div>
								  </div>
								</div>
								<div class="btn-group output" style="float:right;outline: medium none;margin-left:10px;display:none">
								  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    导出 <span class="caret"></span>
								  </button>
								  <ul class="dropdown-menu" style="transition-duration: 0.3s;">
								    <li><a href="javascript:;" onclick="window.open('output_for_country.php?classid='+$.cookie('<?php echo($s_fun)?>Key'),'_blank')">Excel 全国系统数据项</a></li>
								    <li><a href="javascript:;" onclick="window.open('output_roster.php?classid='+$.cookie('<?php echo($s_fun)?>Key'),'_blank')">Excel 花名册</a></li>
								    <li><a href="javascript:;" onclick="download_pdf('download_pdf_multiple.php?classid='+$.cookie('<?php echo($s_fun)?>Key'))">PDF 幼儿信息</a></li>
								  </ul>
								</div>														 
								</div>
						<div class="table_nav">
							<div class="<?php if($s_key=='')echo('on')?>" onclick="change_table_nav('<?php echo($s_fun)?>','')">
								全部在园幼儿
							</div>
							<script type="text/javascript">
							//将班级列表压入js数组
							var a_class_list=[];
							</script>
							<?php 
							 $o_table = new Student_Class();
							 $o_table->PushOrder ( array ('Grade','A') );
							 $o_table->PushOrder ( array ('ClassId','A') );
							 for($i=0;$i<$o_table->getAllCount();$i++)
							 {
							 	$s_class='';
							 	if ($s_key==$o_table->getClassId($i))
							 	{
							 		$s_class='on';
							 	}
							 	$s_grade_name='';
							 	//区分年级
							 	switch ($o_table->getGrade($i))
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
							 	?>
							 	<script type="text/javascript">
							 	a_class_list.push(new Array("<?php echo($o_table->getClassId($i))?>","<?php echo($s_grade_name.'('.$o_table->getClassName($i).')');?>"));
							 	</script>
							 	<div class="<?php echo($s_class)?>" onclick="change_table_nav('<?php echo($s_fun)?>','<?php echo($o_table->getClassId($i))?>')">
							 	<?php echo($s_grade_name.'('.$o_table->getClassName($i).')');?>
							 	</div>
							 	<?php
							 }
							?>
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
					table_sort('<?php echo($s_fun)?>','<?php echo($s_item)?>','<?php echo($s_sort)?>',<?php echo($s_page)?>,'<?php echo($s_key)?>','')
					</script>
		
<script>
//clear_cookie('YeInfoList');//清除cookie为了让每次点击进去都显示新的，而不是待缓存的。
function change_table_nav(fun,class_id)
{
	table_sort(fun,'State','D',1,class_id,'');
	$('#Vcl_KeyYeInfo').val('');
	if (class_id!='')
	{
		//显示导出按钮
		$('.output').css('display','black');
	}else{
		//不显示导出按钮
		$('.output').css('display','none');
	}
}
set_btu_state('<?php echo($s_key)?>');
function set_btu_state(class_id)
{
	if (class_id!='')
	{
		//显示导出按钮
		$('.output').css('display','black');
	}else{
		//不显示导出按钮
		$('.output').css('display','none');
	}
}
var table='<?php echo($s_fun)?>';
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>