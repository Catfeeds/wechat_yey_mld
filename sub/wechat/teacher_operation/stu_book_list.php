<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='幼儿图书';
require_once '../header.php';
//引入微信JS接口
require_once RELATIVITY_PATH.'sub/wechat/include/db_table.class.php';
require_once RELATIVITY_PATH.'sub/wechat/include/accessToken.class.php';
//报名页面需要验证是否已经关注微信号，如果没有关注，需要跳转到邀请函，进行二维码扫描。
$o_token = new accessToken ();
$s_token = $o_token->getRefreshToken();
$jsapiTicket =getJsApiTicket($s_token);
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$timestamp = time();
$nonceStr =createNonceStr();

$string = 'jsapi_ticket='.$jsapiTicket.'&noncestr='.$nonceStr.'&timestamp='.$timestamp.'&url='.$url;
$signature = sha1($string);
function createNonceStr($length = 16) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$str = "";
	for($i = 0; $i < $length; $i ++) {
		$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
	}
	return $str;
}
function getJsApiTicket($s_token) {
	$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$s_token;
	$o_util=new curlUtil();
	$s_return=$o_util->https_request($url);
	$res=json_decode($s_return, true);
	//var_dump($res);
	return $res['ticket'];
}
//-------------------
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
if ($_GET['isbn']!='')
{
	$o_book->PushWhere(array("&&", "Isbn", "=", $_GET['isbn']));
}
$o_book->PushWhere(array("&&", "InOpen", "<>", '0000-00-00'));
$o_book->PushOrder ( array ('Id', 'R') );//随机排序
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
		    <img onclick="scan_barcode()" src="images/scanonescan.png" style="margin-right:5px;width:32px;height:32px;"/>
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
        	location='stu_book_list.php?key='+$searchInput.val();
        });
        $searchSubmit.on('submit', function(){
            //location='stu_book_list.php?id=123';
        });
    });
    wx.config({
	    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	    appId: 'wxf38509d7749bb56d', // 必填，公众号的唯一标识
	    timestamp: <?php echo($timestamp)?>, // 必填，生成签名的时间戳
	    nonceStr: '<?php echo($nonceStr)?>', // 必填，生成签名的随机串
	    signature: '<?php echo($signature);?>',// 必填，签名，见附录1
	    jsApiList: ['wx.checkJsApi','scanQRCode'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});
	function scan_barcode()
	{
		wx.scanQRCode({
		    needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
		    scanType: ["barCode"], // 可以指定扫二维码还是一维码，默认二者都有
		    success: function (res) {
		    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
		    result=result.split(",")
		    location='stu_book_list.php?isbn='+result[1];
		}
		});
	}
</script>
<?php
require_once '../footer.php';
?>