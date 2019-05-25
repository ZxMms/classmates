<?php
/**
 * Created by PhpStorm.
 * User: zhima
 * Date: 2018/8/31
 * Time: 下午2:21
 */

require_once("admin_init.php");

$weixin = new weixin();

$weixin->createMenu();

echo "ok";
