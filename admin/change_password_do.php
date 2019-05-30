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

    case 'edit_pass':

        $passwd = safeCheck($_REQUEST['password'], 0);
        $accountid = safeCheck($_REQUEST['account'],1);
        $oldpass = safeCheck($_REQUEST['old_pass'], 0);
        try {

            admin::myupdatePwd($accountid, $oldpass, $passwd);   // 先更新密码

        } catch (MyException $e) {
            echo $e->jsonMsg();
            exit();
        }

        echo action_msg_data("修改密码成功！",1);

        break;


}


?>