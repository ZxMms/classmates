<?php
/**
 * Created by PhpStorm.
 * User: hhx
 * Date: 2019/3/19
 * Time: 14:41
 * 资讯详情
 */
require_once('../init.php');


if(isset($_GET['id'])){
    $id=$_GET['id'];
};
$rows = paper::getInfoById($id);
//print_r($rows);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title></title>
    <link rel="stylesheet" href="static/css/basic.css" />
    <link rel="stylesheet" href="static/css/style.css" />
    <link rel="stylesheet" href="static/css/query.css" />
    <script src="static/js/query.js"></script>
    <script src="static/js/jquery.min.js"></script>
    <script src="static/js/common.js"></script>
    <script>
        $(function () {
            var image=$('.news-con img');
            for(var i=0;i<image.length;i++){
                if($('.news-con img')[i].width > 200){
                    $('.news-con img')[i].style='width:100%;'
                }
            }
        })
    </script>

</head>
<body>
<div id="app">
    <div class="industry">
        <div class="news-wrap">
            <?php

            //$rows['contents'] = HTMLDecode($rows['content']?$rows['content']:'');
            if (!empty($rows['content'])){
                $str = str_replace("&amp;","&",$rows['content']);
                $str = str_replace("&gt;",">",$str);
                $str = str_replace("&lt;","<",$str);
                //$str = str_replace("&nbsp;",CHR(32),$str);
                //$str = str_replace("&nbsp;&nbsp;&nbsp;&nbsp;",CHR(9),$str);
                $str = str_replace("&#160;&#160;&#160;&#160;",CHR(9),$str);
                $str = str_replace("&quot;",CHR(34),$str);
                $str = str_replace("&#39;",CHR(39),$str);
                $str = str_replace("",CHR(13),$str);
                $str = str_replace("<br/>",CHR(10),$str);
                $str = str_replace("<br />",CHR(10),$str);
                $rows['contents'] = str_replace("<br>",CHR(10),$str);
                $rows['contentss'] = str_replace("\\","",$rows['contents']);
            }else{
                $rows['contentss'] = '';
            }

            echo '<div class="news-title"><b>'.$rows['name'].'</b></div>
                <div class="news-tip flex">
                    <span>发布日期</span>
                    <span class="news-time">'.date('Y/m/d H:i',$rows['addtime']).'</span>
                </div>
                
                <div class="news-con" >
                    <p >'.$rows['contentss'].'</p>   
                </div>';
            ?>

        </div>
    </div>
    <div class="footer-tel">
        <div class="footer-tel-flex flex">
            <img src="images/tell.png" alt="">

            <span class="color-pub">陕西省西安市电子二路东段18号</span>
        </div>
        <div class="footer-tel-cop">西安石油大学</div>
    </div>
</div>
</body>
</html>

