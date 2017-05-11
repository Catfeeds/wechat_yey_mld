<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120203);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';

ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
$o_admission_setup=new Admission_Setup(1);
?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> 
                        	同步幼儿信息
                            </div>
                            </div>
                    </div>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<label>1. 同步信息采集系统“班级信息”到当前平台  <span id="step_1_icon" class="glyphicon glyphicon-ok" aria-hidden="true" style="color:#449d44;display:none"></span></label>
	                     		<div class="progress">
								  <div id="step_1_progress" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
								  </div>
								</div>
	                     	</div>  
	                     	<div class="item">
								<button id="refresh_btn" type="button" class="btn btn-primary" aria-hidden="true" style="float: right;outline: medium none;margin-left:15px;display:none" data-placement="left" onclick="location.reload()">刷新</button>
								<button id="start_sync_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none;" data-placement="left" onclick="start_sync()"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> 开始同步</button>
							</div>                   	
                     	</div>
<script src="js/control.fun.js" type="text/javascript"></script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>