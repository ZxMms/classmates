<?php
/**
 * Created by PhpStorm.
 * User: ftx
 * Date: 2019/2/28
 * Time: 10:17 AM
 */

$appid= "wx2e94e0f2c20f6144";
$redirect_uri = urlencode ( 'http://118.24.12.222/getUserInfo.php' );
$url = "https://open.weixin.qq.com/connect/qrconnect?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect";
Header("Location: $url");
