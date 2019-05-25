<?php
/**
 * Created by PhpStorm.
 * User: ww
 * Date: 2019/3/17
 * Time: 22:02
 *
 * 行业资讯
 *
 */
require_once('../init.php');
$situationlist = good::getList();
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
    <title>优秀校友列表</title>
    <link rel="stylesheet" href="static/css/basic.css" />
    <link rel="stylesheet" href="static/css/style.css" />
    <link rel="stylesheet" href="static/css/query.css" />
    <script src="static/js/query.js"></script>
</head>
<body>
<div id="app">
    <div class="industry">
        <?php
        if($situationlist) {
            foreach ($situationlist as $situation) {
                $time = "";
                if (!empty($situation['addtime'])) {
                    $time = intval(((time() - $situation['addtime']) / 86400));
                }
                echo '<a href="people_detail.php?id='.$situation['id'].'" class="industry-item flex">
                    <div class="industry-item-left flex">
                        <p>'.$situation['name'].'</p>';
                        $situation['contents'] = HTMLDecode($situation['content']?$situation['content']:'');
                        $situation['contentss'] = strip_tags($situation['contents']);
                        $situation['content'] = mb_substr($situation['contentss'],0,25);
                        echo '<span>'.date('Y/m/d',$situation['addtime']) .'</span>
                    </div>';
                    if($situation['img']){
                        echo '<div class="industry-item-right" style="border:0px;">
                        <img src="'.$HTTP_PATH . $situation['img'].'" alt="" />
                        </div>';
                    }

                echo '</a>';
            }
        }
        else{
            echo '<div class="industry-item-left flex">
                <span >暂无新闻</span>
                </div>';
        }
        ?>
    </div>
</div>
</body>
<script src="static/js/jquery.min.js"></script>
<script>
    $(function () {

    })
</script>

</html>


