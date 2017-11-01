<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='我的借阅';
require_once '../header.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
require_once RELATIVITY_PATH . 'sub/book/include/db_table.class.php';
$o_bn_basic=new Bn_Basic();
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前借阅记录</p></div>';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$s_search_init='';
$s_search_text='书名';
$o_book=new Book_Info_Teacher_Borrow_View();
$o_book->PushWhere(array("&&", "TeacherId", "=", $o_temp->getUid(0)));
$o_book->PushOrder ( array ('BorrowDate', 'D') );//随机排序
//需要对重复图书去重
$a_isbn=array();
$n_sum=0;
for($i=0;$i<$o_book->getAllCount();$i++)
{
	$s_button='';
	if ($o_bn_basic->GetDateForChinese($o_book->getReturnDate($i))=='')
	{
		$s_button='<div class="weui-form-preview__ft">
                		<a class="weui-form-preview__btn weui-form-preview__btn_primary" onclick="teacher_book_return('.$o_book->getBookId($i).')">马上归还</a>
            		</div>';
	}
	$s_html.='
	<div class="weui-panel weui-panel_access">
            <div class="weui-panel__bd">
					<a href="teacher_book_show.php?id='.$o_book->getBookId($i).'" class="weui-media-box weui-media-box_appmsg">
	                    <div class="weui-media-box__hd">
	                        <img class="weui-media-box__thumb" src="'.$RELATIVITY_PATH.$o_book->getImg($i).'" alt="">
	                    </div>
	                    <div class="weui-media-box__bd">
	                        <h4 class="weui-media-box__title">'.$o_book->getTitle($i).'</h4>
	                        <p class="weui-media-box__desc">借阅时间：'.$o_bn_basic->GetDateForChinese($o_book->getBorrowDate($i)).'</p>
	                        <p class="weui-media-box__desc">归还时间：'.$o_bn_basic->GetDateForChinese($o_book->getReturnDate($i)).'</p>
	                    </div>
	                </a>
	                '.$s_button.'			
            </div>
        </div>
	';
}
?>
<style>
<!--
.weui-media-box_appmsg .weui-media-box__hd {
    margin-right: .8em;
    width: 70px;
    height: 80px;
    line-height: 80px;
    text-align: center;
}
.weui-media-box_appmsg .weui-media-box__thumb {
    width: 100%;
    height: 80px;
    vertical-align: top;
}
.weui-media-box__desc
{
	margin-top:5px;
}
.weui-panel_access-panel
{
	margin-top:10px;
}
-->
</style>
<div class="page">
	<div class="page__bd">
            	<?php 
            		echo($s_html);
            		if($o_book->getAllCount()==0)
            		{
            			echo($s_none);
            		}
            	?> 
            	                              
            
    </div>
</div>
		<form style="display:none" action="<?php echo($RELATIVITY_PATH)?>sub/book/include/bn_submit.switch.php" id="submit_form" method="post" target="ajax_submit_frame" onsubmit="this.submit()">
			<input type="hidden" name="Vcl_Url" value="<?php echo(str_replace ( substr( $_SERVER['PHP_SELF'] , strrpos($_SERVER['PHP_SELF'] , '/')+1 ), '', $_SERVER['PHP_SELF']))?>"/>
			<input type="hidden" name="Vcl_BackUrl" value="<?php echo($_SERVER['HTTP_REFERER'])?>"/>
			<input type="hidden" name="Vcl_FunName" value="WechatTeacherBookReturn"/>
			<input type="hidden" name="Vcl_BookId" id="Vcl_BookId" value=""/>
		</form>
<script type="text/javascript">
function teacher_book_return(id)
{
	Dialog_Confirm('真的要归还此图书吗？',function(){
		document.getElementById("Vcl_BookId").value=id;
		Common_OpenLoading();
		document.getElementById("submit_form").submit();	
	});
}
</script>
<?php
require_once '../footer.php';
?>