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
$s_search_init='';
$s_search_text='书名';
$o_book=new Book_Info_Stu();
if ($_GET['key']!='')
{
	$o_book->PushWhere(array("&&", "Title", "Like", '%'.$_GET['key'].'%'));
	$s_search_text=$_GET['key'];
	$s_search_init=$_GET['key'];
}
$o_book->PushWhere(array("&&", "InOpen", "<>", '0000-00-00'));
$o_book->PushOrder ( array ('Pubdate', 'D') );
$o_book->PushOrder ( array ('Id', 'A') );
//需要对重复图书去重
$a_isbn=array();
$n_sum=0;
for($i=0;$i<$o_book->getAllCount();$i++)
{
	if (in_array($o_book->getIsbn($i),$a_isbn))
	{
		continue;
	}
	$n_sum++;
	array_push($a_isbn, $o_book->getIsbn($i));
	$s_html.='
	<a href="stu_book_show.php?id='.$o_book->getId($i).'" class="weui-media-box weui-media-box_appmsg">
	                    <div class="weui-media-box__hd">
	                        <img class="weui-media-box__thumb" src="'.$RELATIVITY_PATH.$o_book->getImg($i).'" alt="">
	                    </div>
	                    <div class="weui-media-box__bd">
	                        <h4 class="weui-media-box__title">'.$o_book->getTitle($i).'</h4>
	                        <p class="weui-media-box__desc">作者：'.$o_book->getAuthor($i).'</p>
	                        <p class="weui-media-box__desc">出版社：'.$o_book->getPublisher($i).'</p>
	                        <p class="weui-media-box__desc">出版时间：'.$o_book->getPubdate($i).'</p>
	                    </div>
	                </a>
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
.weui-search-bar
{
	position: fixed;
	z-index:9999999;
	width:100%;
	margin-top:-43px;
}
.weui-panel
{
	margin-top:43px;
}
-->
</style>
<div class="page">
	<div class="page__bd">
		<div class="weui-search-bar" id="searchBar">
		    <img src="images/scanonescan.png" style="margin-right:5px;width:32px;height:32px;"/>
            <div class="weui-search-bar__form" id="scarchSubmit">
                <div class="weui-search-bar__box">
                    <i class="weui-icon-search"></i>
                    <input type="text" class="weui-search-bar__input" id="searchInput" value="<?php echo($s_search_init)?>" placeholder="书名"/>
                    <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                </div>
                <label class="weui-search-bar__label" id="searchText">
                    <i class="weui-icon-search"></i>
                    <span><?php echo($s_search_text)?></span>
                </label>
            </div>
            <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">搜索</a>
        </div>
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">幼儿图书列表（共 <?php echo($n_sum)?> 种图书）</div>
            <div class="weui-panel__bd">
            	<?php 
            		echo($s_html);
            	?>                               
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        var $searchBar = $('#searchBar'),
            $searchResult = $('#searchResult'),
            $searchText = $('#searchText'),
            $searchInput = $('#searchInput'),
            $searchClear = $('#searchClear'),
            $searchSubmit = $('#scarchSubmit'),
            $searchCancel = $('#searchCancel');

        function hideSearchResult(){
            $searchResult.hide();
            $searchInput.val('');
        }
        function cancelSearch(){
            hideSearchResult();
            $searchBar.removeClass('weui-search-bar_focusing');
            $searchText.show();
        }

        $searchText.on('click', function(){
            $searchBar.addClass('weui-search-bar_focusing');
            $searchInput.focus();
        });
        $searchInput
            .on('blur', function () {
                //if(!this.value.length) cancelSearch();
            })
            .on('input', function(){
                //window.alert()
                /*
                if(this.value.length) {
                    $searchResult.show();
                } else {
                    $searchResult.hide();
                }*/
            })
        ;
        $searchClear.on('click', function(){
            hideSearchResult();
            $searchInput.focus();
        });
        $searchCancel.on('click', function(){
            //window.alert($searchInput.val());
        	location='stu_book_list.php?key='+$searchInput.val();
        });
        $searchSubmit.on('submit', function(){
            //location='stu_book_list.php?id=123';
        });
    });
</script>
<?php
require_once '../footer.php';
?>