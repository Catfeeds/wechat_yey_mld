<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120107);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                            分配班级出现错误汇总
                            </div>
                        </div>
                    </div>
                    	<div class="sss_form">
	                     		<?php echo($_GET['text'])?>
							<div class="item">
								<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='admission.php'"><?php echo(Text::Key('Back'))?></button>
							</div>
                     	</div>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">

</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>