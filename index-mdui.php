<!-- jquery mobile 教程：http://www.runoob.com/jquerymobile/jquerymobile-tutorial.html -->
<!DOCTYPE html>
<?php
session_start();

// 开始记录当前用户发送的表白数，在Seesion的生命周期内，最多限制3条。
if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = 1;
}
?>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <title>广西科技大学表白墙2016</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.min.css" />
    <link rel="stylesheet" href="css/homepage.css" media="screen" title="no title">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" media="screen" />
    <link rel="stylesheet" href="https://unpkg.com/mdui@1.0.2/dist/css/mdui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mobile/1.4.5/jquery.mobile.min.js"></script>
    <script src="js/display.js" charset="utf-8"></script>
    <script src="js/layer_mobile/layer.js"></script>
    <script src="https://unpkg.com/mdui@1.0.2/dist/js/mdui.min.js"></script>
</head>

<body class="mdui-theme-layout-auto mdui-theme-primary-light-blue-400 mdui-color-blue-200 mdui-theme-accent">
    <nav class="mdui-appbar mdui-ripple mdui-hoverable">
        <div class="mdui-toolbar">
            <a href="#" class="mdui-typo-headline">表白墙</a>
            <a href="saylove.html" class="mdui-typo-title">我要表白</a>
            <div class="mdui-toolbar-spacer"></div>
            <a href="search.html" class="mdui-btn mdui-btn-icon">
                <i class="mdui-icon material-icons">search</i>
            </a>
            <a href="javascript:;" class="mdui-btn mdui-btn-icon" mdui-drawer="{target: '#sort-drawer'}">
                <i class="mdui-icon material-icons">sort</i>
            </a>

            <a href="javascript:location.reload();" class="mdui-btn mdui-btn-icon">
                <i class="mdui-icon material-icons">refresh</i>
            </a>
            <a href="help.html" class="mdui-btn mdui-btn-icon">
                <i class="mdui-icon material-icons">help</i>
            </a>
        </div>
    </nav>
    <!-- 左侧抽屉 -->
    <div class="mdui-drawer mdui-drawer-close mdui-hoverable mdui-color-white" id="sort-drawer">
        <ul class="mdui-list">
            <h2 class="mdui-list-item mdui-ripple">
                进行排序筛选
            </h2>
            <hr />
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-icon material-icons">access_time</i>
                <input class="mdui-list-item-content" id="new-posts" type="button" value="最新表白（默认）">
            </li>
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-icon material-icons">access_time</i>
                <input id="old-posts" type="button" value="最早表白">
            </li>
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-icon material-icons">exposure_plus_1</i>
                <input id="most-liked" type="button" value="点赞数最多">
            </li>
            <li class="mdui-list-item mdui-ripple">
                <i class="mdui-icon material-icons">exposure_neg_1</i>
                <input id="less-liked" type="button" value="点赞数最少">
            </li>
            <li>
                <i class="mdui-icon material-icons">help</i>
                <input id="random-posts" type="button" value="随机显示">
            </li>
        </ul>
        <hr />
        <button class="mdui-btn" mdui-drawer-close>关闭</button>
    </div>

    <!-- 页头的信息 -->
    <div id="Header" class="Header" data-role="header">
        <img src="images/logo.png" class="Header-logo" width="100%" height="400px" alt="" />
        <img src="images/title.png" class="Header-title" width="250px" alt="广西科技大学表白墙" />
        <!-- <h1>科大表白墙</h1> -->
    </div>

    <!-- 网站主体 -->
    <div class="main-body" id="main" data-role="content">
        <!-- 这里是表白的心跳载入logo，当表白获取成功就会覆盖这里 -->
        <img src="images/icon/heart.gif" alt="" class="loading" />
    </div>
    <p style="text-align:center;color:#00bcd4;font-size:12px;">
        博客链接： <a href="https://pingxonline.com/">https://pingxonline.com/</a>
    </p>
    <p style="text-align:center;color:#9e9e9e;font-size:12px;">
        蓝色下划线：男生 / 红色下划线：女生 / 黑色下划线：保密
    </p>
    <p id="pageNum" style="text-align:center;color:#9e9e9e;font-size:12px;">

    </p>
    <div id="pages" data-role="footer" style="text-align:center;margin-bottom:56px;" page="1" mode="1" max="0">
        <div data-role="controlgroup" data-type="horizontal">
            <a href="#" id="previous" class="ui-btn ui-corner-all ui-shadow ui-icon-arrow-l ui-btn-icon-notext">上一页</a>
            <a href="#myPanel" id="" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-notext">删除</a>
            <a href="#" id="returnTop" class="ui-btn  ui-corner-all ui-icon-carat-u ui-shadow ui-btn-icon-notext">返回顶部</a>
            <a href="#" id="next" class="ui-btn ui-corner-all ui-shadow ui-icon-arrow-r ui-btn-icon-notext">下一页</a>
        </div>
    </div>
    <div data-role="popup" class="ui-content" data-overlay-theme="b" id="guess-Name-Popup">
        <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right">关闭</a>
        <h4>猜名字</h4>
        <p>
            已猜中 <span id="guess_right"></span> 次, 被猜 <span id="guess_all"></span> 次.
        </p>
        <p class="guess-hint">
            猜名字游戏介绍请点击查看：<a style="color:#333;" href="help.html">帮助</a>
        </p>
        <div class="ui-field-contain">
            <label for="guess-input">猜一猜发起者的名字：</label>
            <input type="search" name="search" id="guess-input" placeholder="名字">
        </div>
        <input id="guess-submit" style="text-align:center;display:block;margin:0 auto;" type="submit" data-inline="true" value="猜！">
        <span id="guess-hint"></span>
    </div>

    <div data-role="popup" class="ui-content" data-overlay-theme="b" id="comment-Popup">
        <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right">关闭</a>
        <h4>评论列表</h4>
        <div class="" id="comment-lists">
            <ul id="comment-lists-ul">
                <li style="visibility: hidden;">
                    <span class="comment-floor">2楼</span>
                    <span class="comment-ip">192.168.1.***</span>
                    <span class="comment-time">2016/11/7 18:00:56</span>
                    <p>占位占位占位占位占位占位占位占位占位占位占位</p>
                </li>
            </ul>
        </div>
        <div class="ui-field-contain">
            <label for="guess-input">评论：</label>
            <input type="search" name="search" id="guess-input" placeholder="我想说...">
        </div>
        <input id="comment-submit" style="text-align:center;display:block;margin:0 auto;" type="submit" data-inline="true" value="评论">
        <span id="comment-hint"></span>
    </div>


    <div data-role="popup" class="ui-content" data-overlay-theme="b" id="share-Popup">
        <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn ui-icon-delete ui-btn-icon-notext ui-btn-right">关闭</a>
        <h4>链接分享</h4>
        <h5>复制链接给朋友或者点击打开链接</h5>
        <div id="link">
            <a href=""></a>
        </div>
    </div>

    <div class="" style="display:none;">
        <script src="https://s11.cnzz.com/z_stat.php?id=1260775797&web_id=1260775797" language="JavaScript"></script>
    </div>

    <!-- 这里是下雪的插件，取消注释自动调用 -->
    <!-- <script type="text/javascript" src="js/snow.src.js"></script> -->
</body>

</html>