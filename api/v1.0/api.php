<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/19
 * Time: 19:51
 */
include_once '../../init.php';
include_once '../../setting.inc.php';
$method = safeCheck($_REQUEST["method"],0);
$timestamp = safeCheck($_REQUEST["timestamp"],0);
$sign = safeCheck($_REQUEST["sign"],0);

$token = "zhimakaihua";

$verSign = md5($method.$timestamp.$token);

if($sign!=$verSign)
{
    echo action_msg("接口校验未通过!",101);
    exit;
}

require_once $method.".php";





?>