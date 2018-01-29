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
								      			<b>添加日期</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getCreateDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>毕业时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getGraduateDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>学历类型</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getEducationType($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>学历与学位</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getEducation($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>毕业学校</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getSchool($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>所学专业</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getProfession($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>学制</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getLength($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>专业类别</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getProType($i))?>
								      		</td>
								      	<tr>								      	
								      </table>
								  <?php
								  	if (($i+1)<$o_table->getAllCount())
								  	{
								  		echo('<div style="width:100%;margin:10px;border-color:#DDDDDD;border-top: 1px solid #DDDDDD;"></div>');
								  	}
							      }
							      ?>			      	
							      </div>
							    </div>
							    <div class="panel panel-info">
							      <div class="panel-heading panel-heading2">
							        <h3 class="panel-title">资格职称</h3>
							      </div>
							      <div class="panel-body" style="line-height:20px;">	
							      <?php 
							      $o_table=new Wechat_Base_User_Info_Jobtitle();
								  $o_table->PushWhere ( array ('&&', 'Uid', '=',$_GET['id']) ); 
								  $o_table->PushOrder ( array ('CreateDate', 'A') );
							      for($i=0;$i<$o_table->getAllCount();$i++)
							      {
							      	
									?>									
								      <table>
								      	<tr>
								      		<td style="width:100px;">
								      			<b>添加日期</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getCreateDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>类型</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getType($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>证书编号</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getNumber($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>发证机关</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getOrganization($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>发证时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>证书照片</b>
								      		</td>
								      		<td>
								      			<a href="<?php echo(RELATIVITY_PATH.$o_table->getPicture($i))?>" target="_blank"><img style="width:130px" src="<?php echo(RELATIVITY_PATH.$o_table->getPicture($i))?>"/></a>
								      		</td>
								      	<tr>								      					      	
								      </table>
								  <?php
								  	if (($i+1)<$o_table->getAllCount())
								  	{
								  		echo('<div style="width:100%;margin:10px;border-color:#DDDDDD;border-top: 1px solid #DDDDDD;"></div>');
								  	}
							      }
							      ?>			      	
							      </div>
							    </div>
							    <div class="panel panel-info">
							      <div class="panel-heading panel-heading2">
							        <h3 class="panel-title">学习培训</h3>
							      </div>
							      <div class="panel-body" style="line-height:20px;">	
							      <?php 
							      $o_table=new Wechat_Base_User_Info_Training();
								  $o_table->PushWhere ( array ('&&', 'Uid', '=',$_GET['id']) ); 
								  $o_table->PushOrder ( array ('CreateDate', 'A') );
							      for($i=0;$i<$o_table->getAllCount();$i++)
							      {
							      	
									?>									
								      <table>
								      	<tr>
								      		<td style="width:100px;">
								      			<b>添加日期</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getCreateDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>开始时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getStartDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>结束时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getEndDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>培训类型</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getType($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>培训内容</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getContent($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>主办单位</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getOrganization($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>是否取得证书</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getIsCertificate($i))?>
								      		</td>
								      	<tr>
								      	<?php 
								      	if ($o_table->getIsCertificate($i)=='是')
								      	{
								      	?>
								      	<tr>
								      		<td>
								      			<b>证书照片</b>
								      		</td>
								      		<td>
								      			<a href="<?php echo(RELATIVITY_PATH.$o_table->getPicture($i))?>" target="_blank"><img style="width:130px" src="<?php echo(RELATIVITY_PATH.$o_table->getPicture($i))?>"/></a>
								      		</td>
								      	<tr>	
								      	<?php 
								      	}
								      	?>							      					      	
								      </table>
								  <?php
								  	if (($i+1)<$o_table->getAllCount())
								  	{
								  		echo('<div style="width:100%;margin:10px;border-color:#DDDDDD;border-top: 1px solid #DDDDDD;"></div>');
								  	}
							      }
							      ?>			      	
							      </div>
							    </div>
							    <div class="panel panel-info">
							      <div class="panel-heading panel-heading2">
							        <h3 class="panel-title">工作经历</h3>
							      </div>
							      <div class="panel-body" style="line-height:20px;">	
							      <?php 
							      $o_table=new Wechat_Base_User_Info_Work();
								  $o_table->PushWhere ( array ('&&', 'Uid', '=',$_GET['id']) ); 
								  $o_table->PushOrder ( array ('CreateDate', 'A') );
							      for($i=0;$i<$o_table->getAllCount();$i++)
							      {
							      	
									?>									
								      <table>
								      	<tr>
								      		<td style="width:100px;">
								      			<b>添加日期</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getCreateDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>开始时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getStartDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>结束时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getEndDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>工作岗位</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getJob($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>工作内容</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getContent($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>工作类别</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getType($i))?>
								      		</td>
								      	<tr>								      					      	
								      </table>
								  <?php
								  	if (($i+1)<$o_table->getAllCount())
								  	{
								  		echo('<div style="width:100%;margin:10px;border-color:#DDDDDD;border-top: 1px solid #DDDDDD;"></div>');
								  	}
							      }
							      ?>			      	
							      </div>
							    </div>
							    <div class="panel panel-info">
							      <div class="panel-heading panel-heading2">
							        <h3 class="panel-title">获奖情况</h3>
							      </div>
							      <div class="panel-body" style="line-height:20px;">	
							      <?php 
							      $o_table=new Wechat_Base_User_Info_Awards();
								  $o_table->PushWhere ( array ('&&', 'Uid', '=',$_GET['id']) ); 
								  $o_table->PushOrder ( array ('CreateDate', 'A') );
							      for($i=0;$i<$o_table->getAllCount();$i++)
							      {
							      	
									?>									
								      <table>
								      	<tr>
								      		<td style="width:100px;">
								      			<b>添加日期</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getCreateDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>获奖时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>项目名称</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getName($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>种类</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getCategory($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>类别</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getType($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>级别</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getGrade($i))?>
								      		</td>
								      	<tr>
								      	<?php 
							            if ($o_table->getCategory($i)!='荣誉类')
							            {
							            	?>
							            <tr>
								      		<td>
								      			<b>等级</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getLevel($i))?>
								      		</td>
								      	<tr>
							            	<?php
							            }
							            ?>	
								      	<tr>
								      		<td>
								      			<b>角色排名</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getRoleLevel($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>批准部门</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getApproveDept($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>是否取得证书</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getIsCertificate($i))?>
								      		</td>
								      	<tr>
								      	<?php 
								      	if ($o_table->getIsCertificate($i)=='是')
								      	{
								      	?>
								      	<tr>
								      		<td>
								      			<b>证书照片</b>
								      		</td>
								      		<td>
								      			<a href="<?php echo(RELATIVITY_PATH.$o_table->getPicture($i))?>" target="_blank"><img style="width:130px" src="<?php echo(RELATIVITY_PATH.$o_table->getPicture($i))?>"/></a>
								      		</td>
								      	<tr>	
								      	<?php 
								      	}
								      	?>							      					      	
								      </table>
								  <?php
								  	if (($i+1)<$o_table->getAllCount())
								  	{
								  		echo('<div style="width:100%;margin:10px;border-color:#DDDDDD;border-top: 1px solid #DDDDDD;"></div>');
								  	}
							      }
							      ?>			      	
							      </div>
							    </div>
							    <div class="panel panel-info">
							      <div class="panel-heading panel-heading2">
							        <h3 class="panel-title">论文著作</h3>
							      </div>
							      <div class="panel-body" style="line-height:20px;">	
							      <?php 
							      $o_table=new Wechat_Base_User_Info_Thesis();
								  $o_table->PushWhere ( array ('&&', 'Uid', '=',$_GET['id']) ); 
								  $o_table->PushOrder ( array ('CreateDate', 'A') );
							      for($i=0;$i<$o_table->getAllCount();$i++)
							      {
							      	
									?>									
								      <table>
								      	<tr>
								      		<td style="width:150px;">
								      			<b>添加日期</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getCreateDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>题目</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getTitle($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>刊物名称（出版单位）</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getBookName($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>本人角色或排名</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getRoleLevel($i))?>
								      		</td>
								      	<tr>								      					      	
								      </table>
								  <?php
								  	if (($i+1)<$o_table->getAllCount())
								  	{
								  		echo('<div style="width:100%;margin:10px;border-color:#DDDDDD;border-top: 1px solid #DDDDDD;"></div>');
								  	}
							      }
							      ?>			      	
							      </div>
							    </div>
							    <div class="panel panel-info">
							      <div class="panel-heading panel-heading2">
							        <h3 class="panel-title">学术报告</h3>
							      </div>
							      <div class="panel-body" style="line-height:20px;">	
							      <?php 
							      $o_table=new Wechat_Base_User_Info_Tech();
								  $o_table->PushWhere ( array ('&&', 'Uid', '=',$_GET['id']) ); 
								  $o_table->PushOrder ( array ('CreateDate', 'A') );
							      for($i=0;$i<$o_table->getAllCount();$i++)
							      {
							      	
									?>									
								      <table>
								      	<tr>
								      		<td style="width:100px;">
								      			<b>添加日期</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getCreateDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>题目</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getTitle($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>本人角色或排名</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getRoleLevel($i))?>
								      		</td>
								      	<tr>								      					      	
								      </table>
								  <?php
								  	if (($i+1)<$o_table->getAllCount())
								  	{
								  		echo('<div style="width:100%;margin:10px;border-color:#DDDDDD;border-top: 1px solid #DDDDDD;"></div>');
								  	}
							      }
							      ?>			      	
							      </div>
							    </div>
							    <div class="panel panel-info">
							      <div class="panel-heading panel-heading2">
							        <h3 class="panel-title">课题立项</h3>
							      </div>
							      <div class="panel-body" style="line-height:20px;">	
							      <?php 
							      $o_table=new Wechat_Base_User_Info_Project();
								  $o_table->PushWhere ( array ('&&', 'Uid', '=',$_GET['id']) ); 
								  $o_table->PushOrder ( array ('CreateDate', 'A') );
							      for($i=0;$i<$o_table->getAllCount();$i++)
							      {
							      	
									?>									
								      <table>
								      	<tr>
								      		<td style="width:100px;">
								      			<b>添加日期</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getCreateDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>课题名称</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getName($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>课题级别</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getLevel($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>参与角色</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getRole($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>开题时间</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getStartDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>结题时间</b>
								      		</td>
								      		<td>
								      			<?php 
								                if($o_table->getEndDate($i)!='0000-00-00')
								                echo($o_table->getEndDate($i))?>
								      		</td>
								      	<tr>
								      	<tr>
								      		<td>
								      			<b>课题成果</b>
								      		</td>
								      		<td>
								      			<?php echo($o_table->getResult($i))?>
								      		</td>
								      	<tr>								      					      	
								      </table>
								  <?php
								  	if (($i+1)<$o_table->getAllCount())
								  	{
								  		echo('<div style="width:100%;margin:10px;border-color:#DDDDDD;border-top: 1px solid #DDDDDD;"></div>');
								  	}
							      }
							      ?>			      	
							      </div>
							    </div>
	                     	</div>
							<div class="item">
							<button id="user_add_btn" type="button" class="btn btn-default cancel" aria-hidden="true" style="float: right;outline: medium none" data-placement="left" onclick="location='teacher_info.php'"><?php echo(Text::Key('Back'))?></button>
							</div>
                     	</div>
<script src="js/control.fun.js" type="text/javascript"></script>
<script type="text/javascript">

</script>
<?php
require_once RELATIVITY_PATH . 'foot.php';
 ?>