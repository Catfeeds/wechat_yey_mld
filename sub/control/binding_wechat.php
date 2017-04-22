<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 100304);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';

ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单

?>
					<div class="panel panel-default sss_sub_table">
                        <div class="panel-heading">
                        <div class="caption">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                            微信绑定信息
                            </div>
                        </div>
                    </div>
                    <?php 
                    //如果已经绑定，那么显示微信头像和昵称
                    $o_table=new Base_User_Wechat();
                    $o_table->PushWhere ( array ('&&', 'Uid', '=', $O_Session->getUid() ) );
                    if($o_table->getAllCount()>0)
                    {
                    	require_once RELATIVITY_PATH . 'sub/wechat/include/db_table.class.php';
                    	$o_wechat=new WX_User_Info($o_table->getWechatId(0));
                    	?>
                    	<div class="sss_form">
                    		
	                     	<div class="item" style="text-align:center">
	                     		<img style="width:50%" src="<?php echo($o_wechat->getPhoto())?>">
	                     	</div>
	                     	<div class="item">
	                     		<label>当前绑定微信昵称：</label>
	                     		<fieldset disabled>
	                     		<input value="<?php echo($o_wechat->getNickname())?>" maxlength="20" type="text" style="width:100%" class="form-control" aria-describedby="basic-addon1" readonly="readonly"/>
	                     		</fieldset>	
	                     	</div>
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-danger" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="wechat_unbinding()">解除绑定</button>
							</div>
                     	</div>
                    	<?php
                    }else{
                    	//如果未绑定，那么显示二维码
                    	?>
                    	<div class="sss_form">
                    		<div class="item" style="text-align:center">
	                     		<label>打开微信扫一扫，扫描下方二维码，绑定微信帐号</label>
	                     	</div>
	                     	<div class="item" style="text-align:center">
	                     		<img style="width:50%" src="binding_wechat_qrcode.php?id=<?php echo($O_Session->getUid())?>">
	                     	</div>
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-success" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='binding_wechat.php'">刷新</button>
							</div>
                     	</div>
                    	<?php
                    }
                    ?>
                    	
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">
var N_Timer=window.setInterval(wechat_get_binding_status,5000)
</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>