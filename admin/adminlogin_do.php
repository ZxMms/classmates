<?php
/**
 * 登录表单处理
 * @version       v0.02
 * @create time   2014/9/4
 * @update time   2016/3/25
 * @author        dxl jt
 * @copyright     Copyright (c) 芝麻开发 (http://www.zhimawork.com)
 **/
require_once('admin_init.php');

//获取值
$account = safeCheck($_POST['account'], 0);
$password = safeCheck($_POST['pass'], 0);

global $remember;
//echo $account.$password;

//校验验证码

try {
    $admin = new Admin();

//    print_r($admin);
    $r = $admin->login($account, $password,0);
    echo $r;
} catch (MyException $e) {
    echo $e->jsonMsg();
}


?>