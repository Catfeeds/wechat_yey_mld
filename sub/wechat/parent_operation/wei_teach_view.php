<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
require_once RELATIVITY_PATH . 'sub/teaching/include/db_table.class.php';
$o_stu=new Student_Onboard_Info_Class_Wechat_View();
$o_stu->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
$o_stu->getAllCount();
$o_table=new Teaching_Wei_Teach_View($_GET['id']);
$o_tabel_count_visitor=new Teaching_Wei_Teach($_GET['id']);
$a_target=json_decode($o_table->getTarget());
//判断用户是否有权限观看
if (!in_array($o_stu->getClassNumber(0), $a_target))
{
	echo "<script>location.href='wei_teach.php'</script>"; 
	exit(0);
}
$s_title=$o_table->getTitle();
//计算观看次数
$o_tabel_count_visitor->setVisitorNum($o_tabel_count_visitor->getVisitorNum()+1);
$o_tabel_count_visitor->Save();
require_once '../header.php';
?>
<style>
.weui-media-box_text p{
	margin-top:10px !important;
	padding-top:0px !important;
	padding-bottom:0px !important;
	font-size:18px !important;
	line-height:150% !important;;
}
.weui-media-box_text b{
	font-size:20px !important;
}
.weui-media-box_text strong{
	font-size:20px !important;
}
</style>
 	<div class="page__hd" style="padding:15px;padding-top:0px;">
        <h1 class="page__title" style="font-size:25px;text-align:center;padding-top:20px;padding-bottom:10px;"><?php echo($o_table->getTitle())?></h1>
        <div style="color:#999999">
			日期：<?php 
			$s_release=explode(' ', $o_table->getReleaseDate());
			echo($s_release[0])?><br/>
			发布者：<?php echo($o_table->getOwnerName())?>老师
			</div>
        <div class="weui-media-box_text">
			<?php echo(rawurldecode($o_table->getComment()))?>			
      	</div>
      	<iframe style="margin-top:15px;" frameborder="0" width="100%" src="<?php echo($o_table->getVideo())?>" allowfullscreen></iframe>
    </div>
	<div style="padding:15px;">
		<a id="next" class="weui-btn weui-btn_primary" onclick="location='wei_teach.php'">所有微视频</a>
	</div>
<script type="text/javascript">
$('iframe').height(Math.floor($('iframe').width()*9/16));
</script>
<?php
require_once '../footer.php';
?>