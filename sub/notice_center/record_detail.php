<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120302);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
//获取子模块菜单
ExportMainTitle(MODULEID,$O_Session->getUid());

//获取刚刚发的通知
require_once RELATIVITY_PATH . 'sub/notice_center/include/db_table.class.php';
$o_table=new Notice_Center_Record($_GET['id']);
if (!($o_table->getUid()>0))
{
	//不合法就退出
	echo "<script>location='record.php'</script>"; 
	exit(0);
}
?>
<style>
.comment p{
	margin-top:10px !important;
	padding-top:0px !important;
	padding-bottom:0px !important;
	font-size:14px !important;
	line-height:150% !important;;
}
.comment b{
	font-size:16px !important;
}
.comment strong{
	font-size:16px !important;
}
</style>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        	通知详情
                            </div>
                            </div>
                    </div>
                    	<div class="sss_form">	                     	
	                     	<div class="item comment">	                     	
	                     		<?php echo(rawurldecode($o_table->getComment()))?>
	                     	</div>
	                     	<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Back'))?></button>
							</div>                   	
                     	</div>
<script src="js/control.fun.js" type="text/javascript"></script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>