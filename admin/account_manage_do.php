<?php
/**
 * 管理员处理  admin_do.php
 *
 * @version       v0.03
 * @create time   2014-9-4
 * @update time   2016/3/25
 * @author        dxl jt
 * @copyright     Copyright (c) 芝麻开发 (http://www.zhimawork.com)
 */
require_once('admin_init.php');
require_once('admincheck.php');

//echo "ok";

$POWERID = '1,2,3,4';//权限

$action = safeCheck($_REQUEST['action'], 0);

//echo $action;

switch ($action) {
    case 'add':
        $account = safeCheck($_POST['account'], 0);  // 账号名称
        $pwd = safeCheck($_POST['password'], 0); //账号密码
        $group = safeCheck($_POST['group'], 1);   // 1是检查数字，账号roleid
        try {
            $rs = Admin::add($account, $pwd, $group);
            echo action_msg($rs, 1);
        } catch (MyException $e) {
            echo $e->jsonMsg();
        }

        break;
    case 'getInfo':
        $page = safeCheck($_REQUEST['page'], 1);
        $rs = accountdata::getaccount($page, $pageSize = 10);

        echo action_msg($rs, 1);
        break;
    case 'del':

        $id = safeCheck($_POST['id'], 0);   // 1是检查数字，账号roleid
        $rs = Admin::del($id);

        echo action_msg($rs, 1);
        break;
    case 'edit':
        $account = safeCheck($_POST['account'], 0);  // 账号名称
        $pwd = safeCheck($_POST['password'], 0); //账号密码
        $group = safeCheck($_POST['group'], 1);   // 1是检查数字，账号roleid
        $id = safeCheck($_POST['id'], 0);   // 1是检查数字，账号roleid
        try {
            Admin::resetPwd($id, $pwd);
            $rs = Admin::edit($id, $account, $group);
            echo action_msg($rs, 1);

        } catch (MyException $e) {
            echo $e->jsonMsg();
        }

        break;

      case "search":
        $roleid = safeCheck($_POST['roleid'], 1);
        $page = safeCheck($_REQUEST['page'], 1);

        $rs = accountdata::getaccountbyroleid($roleid, $page, 10000);

        echo action_msg($rs, 1);
        break;


}


?>