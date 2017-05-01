<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='幼儿见面';
require_once '../header.php';
?>
<style>
<!--
.weui-search-bar__box {
	height:35px;
}
.weui-icon-search {
	font-size:20px;
}
.weui-search-bar__label span {
	font-size:20px;
}
.weui-search-bar__box .weui-search-bar__input {
	font-size:20px;
}
-->
</style>
 	<div class="page__hd">
        <h1 class="page__title" style="font-size:28px;">幼儿见面</h1>
        <p class="page__desc">请在搜索框中，输入幼儿的编号，例如：1001</p>
    </div>
    	<div class="weui-search-bar" id="searchBar">
            <form class="weui-search-bar__form">
                <div class="weui-search-bar__box">
                    <input class="weui-search-bar__input" id="searchInput" placeholder="搜索幼儿编号" required type="number" pattern="[0-9]*"/>
                </div>
                <label class="weui-search-bar__label" id="searchText">
                    <i class="weui-icon-search"></i>
                    <span>搜索幼儿编号</span>
                </label>
            </form>
            <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel" style="line-height:35px;font-size:20px;">搜索</a>
        </div>
<script>
$(function(){
    var $searchBar = $('#searchBar'),
        $searchResult = $('#searchResult'),
        $searchText = $('#searchText'),
        $searchInput = $('#searchInput'),
        $searchClear = $('#searchClear'),
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
            if(!this.value.length) cancelSearch();
        })
        .on('input', function(){
            if(this.value.length) {
                $searchResult.show();
            } else {
                $searchResult.hide();
            }
        })
    ;
    $searchCancel.on('click', function(){
        if ($('#searchInput').val()!='')
        {
        	location='meet_search_result.php?id='+$('#searchInput').val();
        }        
    });
});
</script>
<?php
require_once '../footer.php';
?>