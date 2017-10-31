<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='幼儿读物';
require_once '../header.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
require_once RELATIVITY_PATH . 'sub/book/include/db_table.class.php';
$o_bn_basic=new Bn_Basic();
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有留言</p></div>';
//验证是否为绑定家长
$o_stu=new Student_Onboard_Info_Class_Wechat_View();
$o_stu->PushWhere ( array ('&&', 'UserId', '=',$o_wx_user->getId()) ); 
if ($o_stu->getAllCount()==0)
{
	echo "<script>document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));</script>"; 
	exit(0);
}
$o_book=new Book_Info_Stu($_GET['id']);
if ($o_book->getTitle()=='')
{
	exit(0);
}
?>
<style>
.weui-media-box__desc
{
	margin-top:5px;
}
.page__hd {
    padding: 40px;
	padding-top:30px;
	padding-bottom:10px;
}
</style>
<div class="page">
	<div class="page__hd">
        <h1 class="page__title" style="text-align:center"><img src="<?php echo(RELATIVITY_PATH.$o_book->getImg());?>" style="width:140px;height:180px;" alt=""></h1>
    </div>
	<div class="page__bd">
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">图书信息</div>
			<div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_text">
                    <h4 class="weui-media-box__title"><?php echo($o_book->getTitle());?></h4>
                    <p class="weui-media-box__desc">作者：<?php echo($o_book->getAuthor());?></p>
	                <p class="weui-media-box__desc">出版社：<?php echo($o_book->getPublisher());?></p>
	                <p class="weui-media-box__desc">出版时间：<?php echo($o_book->getPubdate());?></p>
                </div>
            </div>
        </div>
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">简介</div>
			<div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_text">
                    <p class="weui-media-box__desc" style="margin-top:0px;display:inherit;line-height:18px;color:#000000"><?php 
                    if ($o_book->getSummary()=='')
                    {
                    	echo('无');
                    }else{
                    	echo($o_book->getSummary());
                    }
                    ?></p>
                </div>
            </div>
        </div>
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">教师评论</div>
			<div class="weui-panel__bd">
			<?php 
			$o_comment=new Book_Info_Comment_View();
			$o_comment->PushWhere ( array ('&&', 'Id', '=',$o_book->getId()) ); 
			$o_comment->PushOrder ( array ('CommentDate', 'D') );
			for($i=0;$i<$o_comment->getAllCount();$i++)
			{
				echo('
				<div class="weui-media-box weui-media-box_text">
                	<h4 class="weui-media-box__title" style="font-size:14px;">'.$o_comment->getTeacherName($i).'老师</h4>
                    <p class="weui-media-box__desc">'.$o_comment->getCommentDate($i).'</p>
                    <p class="weui-media-box__desc" style="color:#000000">'.$o_comment->getComment($i).'</p>
                </div>
				');
			}
			?>             
            </div>
        </div>       
        <div style="padding:15px;">
	    	<a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
	    </div>
    </div>
</div>
<script type="text/javascript">
function show_comment_vcl()
{
	$('#submit_form').show();
	$('#comment_submit').show();
	$('#comment_show').hide();
	$('#Vcl_Comment').focus();
}
function comment_submit()
{
	if ($('#Vcl_Comment').val()=='')
	{
		Dialog_Message("[评论] 不能为空！",function(){
			document.getElementById("Vcl_Comment").focus()
		})		
		return
	}
	Common_OpenLoading();
	document.getElementById("submit_form").submit();
}
</script>
<?php
require_once '../footer.php';
?>