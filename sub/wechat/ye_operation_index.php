<?php
define ( 'RELATIVITY_PATH', '../../' );
header ( 'Cache-Control: no-cache' );
header ( 'Pragma: no-cache' );
header ( 'Expires: Thu, 01 Jan 1970 00:00:00 GMT' );
header ( 'Last-Modified:' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
header ( 'content-type:text/html; charset=utf-8' );
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>幼儿管理</title>
    <link rel="stylesheet" href="<?php echo(RELATIVITY_PATH . 'sub/wechat/')?>css/weui.css"/>
    <link rel="stylesheet" href="<?php echo(RELATIVITY_PATH . 'sub/wechat/')?>css/weui_custom.css"/>
    
    <script type="text/javascript" src="<?php echo(RELATIVITY_PATH . 'sub/wechat/')?>js/jquery-2.1.0.min.js"></script>
    <script type="text/javascript" src="<?php echo(RELATIVITY_PATH . 'sub/wechat/')?>js/dialog.fun.js"></script>
</head>
<body ontouchstart="">
    <div class="page">
    <div class="page__hd">
        <h1 class="page__title">幼儿管理</h1>
    </div>
    <div class="weui-grids">
        <a href="teacher_operation/stu_checkin.php" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="images/ye_operation_icon_stu_checkin.png" alt="">
            </div>
            <p class="weui-grid__label">考勤记录</p>
        </a>
        <a href="teacher_operation/notice_list.php" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="images/ye_operation_icon_notice_list.png" alt="">
            </div>
            <p class="weui-grid__label">家长通知</p>
        </a>
        <a href="teacher_operation/teaching_sport_item.php" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="images/ye_operation_icon_teaching_sport_item.png" alt="">
            </div>
            <p class="weui-grid__label">体能测验</p>
        </a>
        <a href="teacher_operation/wei_teach.php" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="images/ye_operation_icon_wei_teach.png" alt="">
            </div>
            <p class="weui-grid__label">微视频</p>
        </a>
        <a href="teacher_operation/leavemsg.php" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="images/ye_operation_icon_leavemsg.png" alt="">
            </div>
            <p class="weui-grid__label">家长留言</p>
        </a>
        <a href="teacher_operation/stu_snapshot.php" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="images/ye_operation_icon_stu_snapshot.png" alt="">
            </div>
            <p class="weui-grid__label">幼儿随拍</p>
        </a>
    </div>
</div>
</body></html>