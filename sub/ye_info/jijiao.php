<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120204);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';

ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>

                    <div class="panel panel-default sss_sub_table">
                        <div class="panel-heading" style="overflow:inherit;height:43px;">
                            <div class="caption">基教统计结果列表</div>                            
						 
						</div>
						<div class="table_nav">						
						</div>
                        <table>
                            <tbody>
                            <tr>
                            <td>
                            	
                            </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
					<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
	jijiao_get_data()
})
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>