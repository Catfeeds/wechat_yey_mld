<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='幼儿图书';
require_once '../header.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
require_once RELATIVITY_PATH . 'sub/book/include/db_table.class.php';
$o_bn_basic=new Bn_Basic();
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有留言</p></div>';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
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
        <form style="display:none" action="<?php echo($RELATIVITY_PATH)?>sub/book/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="WechatBookComment"/>
			<input type="hidden" name="Vcl_BookId" value="<?php echo($_GET['id'])?>"/>
	        <div class="weui-cells__title">我的评论</div>
	        <div class="weui-cells weui-cells_form">
	            <div class="weui-cell">
	                <div class="weui-cell__bd">
	                    <textarea id="Vcl_Comment" name="Vcl_Comment" class="weui-textarea" placeholder="请输入评论内容" rows="5"></textarea>
	                </div>
	            </div>
	        </div>
        </form>
        <div style="padding:15px;">
	    	<a id="comment_show" class="weui-btn weui-btn_primary" onclick="show_comment_vcl()">我来评论</a>
	    	<a id="comment_submit" class="weui-btn weui-btn_primary" onclick="comment_submit()" style="display:none">提交评论</a>
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