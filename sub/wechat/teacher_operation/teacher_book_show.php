<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='教师用书';
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
$o_book=new Book_Info_Teacher($_GET['id']);
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
	                <p class="weui-media-box__desc">图书位置：<?php echo($o_book->getLocation());?></p>
	                <a style="margin-top:10px;" href="http://search.m.dangdang.com/search.php?cid=0&keyword=<?php echo($o_book->getIsbn());?>" class="weui-btn weui-btn_mini weui-btn_primary">当当</a>
	                <a style="margin-top:10px;" href="https://www.amazon.cn/gp/aw/s/ref=nb_sb_noss/458-2617695-3884453?k=<?php echo($o_book->getIsbn());?>" class="weui-btn weui-btn_mini weui-btn_primary">亚马逊</a>
	                <a style="margin-top:10px;" href="https://so.m.jd.com/ware/search.action?keyword=<?php echo($o_book->getIsbn());?>" class="weui-btn weui-btn_mini weui-btn_primary">京东</a>
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
            <div class="weui-panel__hd">借阅记录</div>
			<div class="weui-panel__bd">
			<?php 
			$o_borrow_log=new Book_Info_Teacher_Borrow_View();
			$o_borrow_log->PushWhere ( array ('&&', 'BookId', '=',$o_book->getId()) ); 
			$o_borrow_log->PushOrder ( array ('BorrowDate', 'A') );
			for($i=0;$i<$o_borrow_log->getAllCount();$i++)
			{
				//判断是否已经归还
				if($o_borrow_log->getReturnDate($i)=='0000-00-00 00:00:00')
				{
					//未归还
					#E64340
					$s_return_time='<span style="color:#E64340">未归还</span>';
				}else{
					$s_return_time=$o_bn_basic->GetDateForChinese($o_borrow_log->getReturnDate($i)).' 归还';
				}
				echo('
				<div class="weui-media-box weui-media-box_text" style="padding-top:8px;padding-bottom:8px;">
                	<h4 class="weui-media-box__title" style="font-size:14px;margin-bottom:0px">'.$o_bn_basic->GetDateForChinese($o_borrow_log->getBorrowDate($i)).'&nbsp;&nbsp;&nbsp;&nbsp;'.$o_borrow_log->getTeacherName($i).'老师&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$s_return_time.'</h4>
                </div>
				');
			}
			?>             
            </div>
        </div> 
        <?php 
	        //如果之前借阅过，那么显示归还图书，否则显示借阅
	        $o_borrow_log=new Book_Info_Teacher_Borrow();
	        $o_borrow_log->PushWhere ( array ('&&', 'BookId', '=',$o_book->getId()) ); 
	        $o_borrow_log->PushWhere ( array ('&&', 'TeacherId', '=',$o_temp->getUid(0)) ); 
	        $o_borrow_log->PushWhere ( array ('&&', 'ReturnDate', '=','0000-00-00 00:00:00') ); 
	        $s_funname='WechatTeacherBookBorrow';
	        if($o_book->getState()==1)
	        {
	        	//已被借阅
	        	$s_button='<a class="weui-btn weui-btn_primary" onclick="teacher_book_borrow(1)">借阅</a>';
	        }else{
	        	$s_button='<a class="weui-btn weui-btn_primary" onclick="teacher_book_borrow(0)">借阅</a>';
	        }	        
	        if ($o_borrow_log->getAllCount()>0)
	        {
	        	$s_funname='WechatTeacherBookReturn';
	        	$s_button='<a class="weui-btn weui-btn_warn" onclick="teacher_book_return()">归还图书</a>';
	        }
	        
        ?>
        <form style="display:none" action="<?php echo($RELATIVITY_PATH)?>sub/book/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="<?php echo($s_funname)?>"/>
			<input type="hidden" name="Vcl_BookId" value="<?php echo($_GET['id'])?>"/>
		</form>
        <div style="padding:15px;">  
        	<?php echo($s_button)?>
	    	<a class="weui-btn weui-btn_default" href="teacher_book_myborrow.php">我的借阅</a>
	    	<a class="weui-btn weui-btn_default" onclick="history.go(-1)">返回</a>
	    </div>
    </div>
</div>
<script type="text/javascript">
function teacher_book_borrow(state)
{
	if (state==1)
	{
		Dialog_Message('对不起，改图书已被借阅，请等待归还后再借阅。');
		return;
	}
	Dialog_Confirm('真的借阅此图书吗？',function(){
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	});
}
function teacher_book_return()
{
	Dialog_Confirm('真的要归还此图书吗？',function(){
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	});
}
</script>
<?php
require_once '../footer.php';
?>