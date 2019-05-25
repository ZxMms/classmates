<?php
/**
 * Created by PhpStorm.
 * User: ftx
 * Date: 2019/2/28
 * Time: 10:23 AM
 */

$code = $_GET['code'];
$appid= "wx2e94e0f2c20f6144";
$appsecret = "aec1349c37c1f8580525bc8c092fe491";
//获取access_token
$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
$WxCon = file_get_contents($url);
$WxCon = json_decode($WxCon,true);
$access_token = $WxCon['access_token'];
//获取用户信息
$userInfoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$appid&lang=zh_CN";
$userInfo = file_get_contents($userInfoUrl);
echo '<pre>';
$userArr = json_decode($userInfo,true);
print_r($userArr);
