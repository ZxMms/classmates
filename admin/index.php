<?php
/**
 * 系统首页  index.php
 *
 * @version       v0.03
 * @create time   2014/8/4
 * @update time   2014/9/4 2016/3/25
 * @author        hlc jt
 * @copyright     Copyright (c) 芝麻开发 (http://www.zhimawork.com)
 */
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID = '1,2,3,4';//权限

$FLAG_FIRST_LEFTNAV = 'index';
//$FLAG_SECOND_LEFTNAV='';

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <link rel="stylesheet" href="static/css/common.css"/>
    <link rel="stylesheet" href="static/css/index.css"/>
    <link rel="stylesheet" href="static/js/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="static/js/layer/skin/default/layer.css"/>
    <script type="text/javascript" src="static/js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="static/js/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="static/js/layer/layer.js"></script>
    <script type="text/javascript">


    </script>
</head>
<body>
<div id="wrapper">


                <?php
                include_once ("nav.inc.php");
                include_once ("top.inc.php");

                ?>

                <?php
                $time =strtotime(date("Y-m-d"));
                ?>

    <div class="mainBox">
            <!----主页面--->
            <div class="mainPage">
                <!----当前位置--->
                <div class="page_header">
                    <a href="">当前位置</a><span>：</span>
                    <a href="">首页</a>

                </div>
                <style>

                </style>

                <div class="page_body" style="background:none;">
                    <img src="images/1.jpg" width="100%" height="30%">
                </div>

            </div>
    </div>

</div>

<?php
//session_start();
//if ($_SESSION['islogin'])
//        echo '
//        <div class="popup" type="hidden" id="islogin" value="1">
//            <div class="popup-head">
//            <img src="../static/img/close.png" alt="" class="close-icon">
//            </div>
//        <div class="popup-con">
//            <img src="../static/img/email.png" alt="" class="email-icon">
//            <div class="popup-text">
//            <span class="you">您有新邮件</span><br>
//            <a href="" class="go-look">前去查看</a>
//            </div>
//        </div>
//    </div>
//    ';
//?>
<script type="text/javascript" src="static/js/common.js"></script>
</body>

</html>

