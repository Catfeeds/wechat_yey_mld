<?php
define ( 'RELATIVITY_PATH', '../../' );
define ( 'MODULEID', 120603);
$O_Session = '';
require_once RELATIVITY_PATH . 'include/it_include.inc.php';
require_once RELATIVITY_PATH . 'head.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
ExportMainTitle(MODULEID,$O_Session->getUid());
//获取子模块菜单
?>
<style>
.panel-heading2
{
	background-color: #EEEEEE !important;
	color: #777777 !important;
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
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                            教师成长经历详情
                            </div>
                        </div>
                    </div>
                    	<div class="sss_form">
	                     	<div class="item">
	                     		<div class="panel panel-info">
							      <div class="panel-heading panel-heading2">
							        <h3 class="panel-title">基本信息</h3>
							      </div>
							      <div class="panel-body">	
							      <?php 
							      $o_table=new Wechat_Base_User_Info_Base($_GET['id']);
							      ?>
							      <table>
							      	<tr>
							      		<td style="width:100px;">
							      			<b>姓名</b>
							      		</td>
							      		<td>
							      			<?php echo($o_table->getName())?>
							      		</td>
							      	<tr>
							      	<tr>
							      		<td>
							      			<b>身份证</b>
							      		</td>
							      		<td>
							      			<?php echo($o_table->getCardId())?>
							      		</td>
							      	<tr>
							      	<tr>
							      		<td>
							      			<b>性别</b>
							      		</td>
							      		<td>
							      			<?php echo($o_table->getSex())?>
							      		</td>
							      	<tr>
							      	<tr>
							      		<td>
							      			<b>出生日期</b>
							      		</td>
							      		<td>
							      			<?php echo($o_table->getBirthday())?>
							      		</td>
							      	<tr>
							      	<tr>
							      		<td>
							      			<b>民族</b>
							      		</td>
							      		<td>
							      			<?php echo($o_table->getNation())?>
							      		</td>
							      	<tr>
							      	<tr>
							      		<td>
							      			<b>政治面貌</b>
							      		</td>
							      		<td>
							      			<?php echo($o_table->getPolitics())?>
							      		</td>
							      	<tr>
							      	<tr>
							      		<td>
							      			<b>参加工作时间</b>
							      		</td>
							      		<td>
							      			<?php echo($o_table->getJoinWorkDate())?>
							      		</td>
							      	<tr>
							      	<tr>
							      		<td>
							      			<b>出生地</b>
							      		</td>
							      		<td>
							      			<?php echo($o_table->getBirthplace())?>
							      		</td>
							      	<tr>
							      	<tr>
							      		<td>
							      			<b>籍贯</b>
							      		</td>
							      		<td>
							      			<?php echo($o_table->getNative())?>
							      		</td>
							      	<tr>
							      	<tr>
							      		<td>
							      			<b>人员进入形式</b>
							      		</td>
							      		<td>
							      			<?php echo($o_table->getInType())?>
							      		</td>
							      	<tr>
							      </table>				      	
							      </div>
							    </div>
							    
							    <div class="panel panel-info">
							      <div class="panel-heading panel-heading2">
							        <h3 class="panel-title">学历学位</h3>
							      </div>
							      <div class="panel-body" style="line-height:20px;">	
							      <?php 
							      $o_table=new Wechat_Base_User_Info_Education();
								  $o_table->PushWhere ( array ('&&', 'Uid', '=',$_GET['id']) ); 
								  $o_table->PushOrder ( array ('CreateDate', 'A') );
							      for($i=0;$i<$o_table->getAllCount();$i++)
							      {
									?>									
								      <table>
								      	<tr>
								      		<td style="width:100px;">
								      			<b>姓名</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getName())?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>身份证</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getCardId())?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>性别</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getSex())?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>出生日期</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getBirthday())?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>民族</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getNation())?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>政治面貌</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getPolitics())?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>参加工作时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getJoinWorkDate())?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>出生地</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getBirthplace())?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>籍贯</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getNative())?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>人员进入形式</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getInType())?>
								      		</td>
								      	<tr>
								      </table>
								  <?php
							      }
							      ?>			      	
							      </div>
							    </div>
	                     	</div>
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='<?php echo($_SERVER['HTTP_REFERER'])?>'"><?php echo(Text::Key('Back'))?></button>
							</div>
                     	</div>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">

</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>