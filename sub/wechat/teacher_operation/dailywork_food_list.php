<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='菜肴管理';
require_once '../header.php';
require_once RELATIVITY_PATH . 'include/bn_basic.class.php';  
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$o_bn_basic=new Bn_Basic();
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有菜肴</p></div>';
//想判断教师权限，是否为绑定用户
$o_temp=new Base_User_Wechat();
$o_temp->PushWhere ( array ('&&', 'WechatId', '=',$o_wx_user->getId()) ); 
if ($o_temp->getAllCount()==0)
{
	echo "<script>location.href='access_failed.php'</script>"; 
	exit(0);
}
$s_search_init='';
$s_search_text='菜肴名称';
$o_book=new Ek_Cuisine();
if ($_GET['key']!='')
{
	$o_book->PushWhere(array("&&", "Dishname", "Like", '%'.$_GET['key'].'%'));
	$s_search_text=$_GET['key'];
	$s_search_init=$_GET['key'];
}
//需要对重复图书去重
$a_isbn=array();
$n_sum=0;
$a_i=array();
$a_1=array();
$a_2=array();
$a_3=array();
for($i=0;$i<$o_book->getAllCount();$i++)
{
	$o_temp=new Ek_Cuisine_Modify();
	$o_temp->PushWhere ( array ('&&', 'Dishnum', '=',$o_book->getDishnum($i)) ); 
	if ($o_temp->getAllCount()==0 && $o_book->getPicture($i)=='')
	{
		array_push($a_1, $i);
	}else if($o_temp->getAllCount()==0)
	{
		array_push($a_2, $i);
	}else if($o_book->getPicture($i)=='')
	{
		array_push($a_2, $i);
	}else{
		array_push($a_3, $i);
	}
}
for($i=0;$i<count($a_1);$i++)
{
	$s_picture='images/food_default.jpg';
	if ($o_book->getPicture($a_1[$i])!='')
	{ 
		$s_picture=$RELATIVITY_PATH.$o_book->getPicture($a_1[$i]);
	}
	//检查是否已经更新过带量
	$o_temp=new Ek_Cuisine_Modify();
	$o_temp->PushWhere ( array ('&&', 'Dishnum', '=',$o_book->getDishnum($a_1[$i])) ); 
	$s_dailiang='<span style="color:#F43530">未更新</span>';
	if ($o_temp->getAllCount()>0)
	{
		$s_dailiang='<span style="color:#0BB20C">已更新</span>';	
	}
	$s_html.='
	<a href="dailywork_food_modify.php?id='.$o_book->getDishnum($a_1[$i]).'" class="weui-media-box weui-media-box_appmsg">
	                    <div class="weui-media-box__hd">
	                        <img class="weui-media-box__thumb" src="'.$s_picture.'" alt="">
	                    </div>
	                    <div class="weui-media-box__bd">
	                        <h4 class="weui-media-box__title">'.$o_book->getDishname($a_1[$i]).'</h4>
	                        <p class="weui-media-box__desc">带量状态：'.$s_dailiang.'</p>
	                    </div>
	                </a>
	';
}
for($i=0;$i<count($a_2);$i++)
{
	$s_picture='images/food_default.jpg';
	if ($o_book->getPicture($a_2[$i])!='')
	{
		$s_picture=$RELATIVITY_PATH.$o_book->getPicture($a_2[$i]);
	}
	//检查是否已经更新过带量
	$o_temp=new Ek_Cuisine_Modify();
	$o_temp->PushWhere ( array ('&&', 'Dishnum', '=',$o_book->getDishnum($a_2[$i])) ); 
	$s_dailiang='<span style="color:#F43530">未更新</span>';
	if ($o_temp->getAllCount()>0)
	{
		$s_dailiang='<span style="color:#0BB20C">已更新</span>';	
	}
	$s_html.='
	<a href="dailywork_food_modify.php?id='.$o_book->getDishnum($a_2[$i]).'" class="weui-media-box weui-media-box_appmsg">
	                    <div class="weui-media-box__hd">
	                        <img class="weui-media-box__thumb" src="'.$s_picture.'" alt="">
	                    </div>
	                    <div class="weui-media-box__bd">
	                        <h4 class="weui-media-box__title">'.$o_book->getDishname($a_2[$i]).'</h4>
	                        <p class="weui-media-box__desc">带量状态：'.$s_dailiang.'</p>
	                    </div>
	                </a>
	';
}
for($i=0;$i<count($a_3);$i++)
{
	$s_picture='images/food_default.jpg';
	if ($o_book->getPicture($a_3[$i])!='')
	{
		$s_picture=$RELATIVITY_PATH.$o_book->getPicture($a_3[$i]);
	}
	//检查是否已经更新过带量
	$o_temp=new Ek_Cuisine_Modify();
	$o_temp->PushWhere ( array ('&&', 'Dishnum', '=',$o_book->getDishnum($a_3[$i])) ); 
	$s_dailiang='<span style="color:#F43530">未更新</span>';
	if ($o_temp->getAllCount()>0)
	{
		$s_dailiang='<span style="color:#0BB20C">已更新</span>';	
	}
	$s_html.='
	<a href="dailywork_food_modify.php?id='.$o_book->getDishnum($a_3[$i]).'" class="weui-media-box weui-media-box_appmsg">
	                    <div class="weui-media-box__hd">
	                        <img class="weui-media-box__thumb" src="'.$s_picture.'" alt="">
	                    </div>
	                    <div class="weui-media-box__bd">
	                        <h4 class="weui-media-box__title">'.$o_book->getDishname($a_3[$i]).'</h4>
	                        <p class="weui-media-box__desc">带量状态：'.$s_dailiang.'</p>
	                    </div>
	                </a>
	';
}
?>
<style>
<!--
.weui-media-box_appmsg .weui-media-box__hd {
    margin-right: .8em;
    width: 142px;
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
            <div class="weui-search-bar__form" id="scarchSubmit">
                <div class="weui-search-bar__box">
                    <i class="weui-icon-search"></i>
                    <input type="text" class="weui-search-bar__input" id="searchInput" value="<?php echo($s_search_init)?>" placeholder="菜肴名称"/>
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
            <div class="weui-panel__hd">菜肴列表（共 <?php echo($o_book->getAllCount())?> 种）</div>
            <div class="weui-panel__bd">
            	<?php 
            		echo($s_html);
            	?>                               
            </div>
        </div>
    </div>
</div>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" charset="utf-8"></script>
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
        	location='dailywork_food_list.php?key='+$searchInput.val();
        });
        $searchSubmit.on('submit', function(){
            //location='teacher_book_list.php?id=123';
        });
    });
</script>
<?php
require_once '../footer.php';
?>