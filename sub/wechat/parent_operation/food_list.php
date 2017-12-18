<?php
$RELATIVITY_PATH='../../../';
require_once '../include/it_include.inc.php';
$s_title='食谱';
require_once '../header.php';
require_once RELATIVITY_PATH . 'sub/dailywork/include/db_table.class.php';
$s_none='<div class="weui-footer" style="padding-top:100px;padding-bottom:100px;"><p class="weui-footer__text" style="font-size:1.5em">目前没有食谱</p></div>';
$o_table=new Ek_Recomrecipe();
$o_table->PushOrder ( array ('Id','D') );
$o_table->getAllCount();
$o_onboard=new Student_Onboard_Info_Class_Wechat_View();
$o_onboard->PushWhere ( array ('&&', 'UserId', '=', $o_wx_user->getId() ) );
$o_onboard->getAllCount();
?>

<style>

</style>
<div class="page">
	<div class="page__hd" style="padding-bottom:10px;">
        <h1 class="page__title" style="font-size:1.5em">
        <?php 
        $s_title=str_replace("至", '&nbsp;&nbsp;至<br/>',$o_table->getRecipename(0));
        $s_title=str_replace("食谱", '',$s_title);
        echo($s_title);
        ?> 食谱
        </h1>
    </div>
    <div class="page__bd">
    <?php
    $a_week=array('星期一','星期二','星期三','星期四','星期五');
    $a_day=array('早餐','加餐','午餐','午点','晚餐');
    $a_html=array(
    	'<div class="weui-cells__title">'.$a_week[0].'</div><div class="weui-cells">',
    	'<div class="weui-cells__title">'.$a_week[1].'</div><div class="weui-cells">',
    	'<div class="weui-cells__title">'.$a_week[2].'</div><div class="weui-cells">',
    	'<div class="weui-cells__title">'.$a_week[3].'</div><div class="weui-cells">',
    	'<div class="weui-cells__title">'.$a_week[4].'</div><div class="weui-cells">'
    );
    $a_food=json_decode($o_table->getRecipe(0));
    //循环输出菜谱
    for($i=0;$i<count($a_day);$i++)
    {
    	if ($a_day[$i]=='早餐' && $o_onboard->getGrade(0)==2)
    	{
    		//小班不现实早餐
    		continue;
    	}    	
    	$a_temp=$a_food[$i];
    	for($j=0;$j<count($a_html);$j++)
    	{
    		$a_temp_2=$a_temp[$j];
    		$a_html[$j].='    		
    			<div class="weui-cell">
	                <div class="weui-cell__bd">
	                    <p style="text-align:center">'.$a_day[$i].'</p>
	                </div>
	            </div>
    		'; 
    		for($k=0;$k<count($a_temp_2);$k++)
    		{
    			$a_temp_3=$a_temp_2[$k];
	    		if ($k>1 && $o_onboard->getGrade(0)>2 && $a_day[$i]=='加餐')
		    	{
		    		//大班加餐，只显示牛乳(三元牌)
		    		continue;
		    	}   			
    			$a_html[$j].='
    			<div class="weui-cell weui-cell_access" onclick="window.open(\'food_list_detail.php?id='.$a_temp_3[0].'\',\'_parent\')">
	                <div class="weui-cell__bd">
	                    <span style="vertical-align: middle">'.$a_temp_3[1].'</span>
	                </div>
	                <div class="weui-cell__ft"></div>
	            </div>
    			';
    		}
    	}	
    }
    for($i=0;$i<count($a_html);$i++)
    {
    	echo($a_html[$i].'</div>');
    }
    ?>
</div>	


	<div style="padding:15px;">
		<a id="next" class="weui-btn weui-btn_default" onclick="document.addEventListener('WeixinJSBridgeReady', WeixinJSBridge.call('closeWindow'));">关闭</a>
	</div>
<?php
require_once '../footer.php';
?>