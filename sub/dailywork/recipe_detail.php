<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120602);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
$o_table=new Ek_Recomrecipe($_GET['id']);
$a_week=array('星期一','星期二','星期三','星期四','星期五');
$a_day=array('早餐','加餐','午餐','午点','晚餐');
$a_html=array(
    	'<div class="panel panel-info"><div class="panel-heading panel-heading2"><h3 class="panel-title">'.$a_week[0].'</h3></div><div class="panel-body"><table>%data%</table></div></div>',
    	'<div class="panel panel-info"><div class="panel-heading panel-heading2"><h3 class="panel-title">'.$a_week[1].'</h3></div><div class="panel-body"><table>%data%</table></div></div>',
    	'<div class="panel panel-info"><div class="panel-heading panel-heading2"><h3 class="panel-title">'.$a_week[2].'</h3></div><div class="panel-body"><table>%data%</table></div></div>',
    	'<div class="panel panel-info"><div class="panel-heading panel-heading2"><h3 class="panel-title">'.$a_week[3].'</h3></div><div class="panel-body"><table>%data%</table></div></div>',
    	'<div class="panel panel-info"><div class="panel-heading panel-heading2"><h3 class="panel-title">'.$a_week[4].'</h3></div><div class="panel-body"><table>%data%</table></div></div>',
    );
$a_food=json_decode($o_table->getRecipe());
//循环输出菜谱
    for($i=0;$i<count($a_day);$i++)
    {   	
    	$a_temp=$a_food[$i];
    	for($j=0;$j<count($a_html);$j++)
    	{
    		$a_temp_2=$a_temp[$j];
    		$a_html[$j]=str_replace('%data%', '
	    		<tr>
					<td style="width:100px;">
						<b>'.$a_day[$i].'</b>
					</td>
					<td>
					</td>
				<tr>
	    		%data%', $a_html[$j]);
    		for($k=0;$k<count($a_temp_2);$k++)
    		{
    			$a_temp_3=$a_temp_2[$k];
    			$a_html[$j]=str_replace('%data%', '
		    		<tr>
						<td>
							
						</td>
						<td>
							'.$a_temp_3[1].'&nbsp;&nbsp;<span style="color:#999999">'.$a_temp_3[0].'</span>&nbsp;&nbsp;<a title="更换" href="recipe_modify.php?id='.$_GET['id'].'&dishnum='.$a_temp_3[0].'&dishname='.rawurlencode($a_temp_3[1]).'"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></a> 
						</td>
					<tr>
		    		%data%', $a_html[$j]);  			
    		}
    	}	
    }
?>
<style>
.panel-heading2
{
	background-color: #3498DB !important;
	color: White !important;
	border-color: #DDDDDD !important;
}
.panel-info
{
	border-color: #DDDDDD !important;
}
.panel-body td
{
	line-height:20px;
}
</style>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                          <?php echo($o_table->getRecipename())?> 食谱详情
                            </div>
                        </div>
                    </div>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<?php 
	                     		for($i=0;$i<count($a_html);$i++)
							    {
							    	echo(str_replace('%data%', '', $a_html[$i]));
							    }
	                     		?>
	                     	</div>
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='recipe.php'"><?php echo(Text::Key('Back'))?></button>
							</div>
                     	</div>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">

</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>