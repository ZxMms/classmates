<?php
/**
 * Created by PhpStorm.
 * User: 关欣
 * Date: 2019/3/7
 * Time: 9:16
 */

require_once "../../init.php";

$type = safeCheck($_POST['type'], 0);
$name = safeCheck($_POST['name'], 0);
//$userid = safeCheck($_POST['userid'], 0);
$code = safeCheck($_POST['code'], 0);

try {
    $params = array();
//    $data = stock::getInfoByKeyword($stockid);
    $uionid=$_COOKIE['uionid'];
    $params['type'] = $type;

    $params['name'] = $name;
    $params['code'] = $code;
    $params['time'] = time();
    $user = User::getInfoByUionId($uionid)[0];
    $count = $user['search_count'];
    $params['user_id'] = $user['id'];
//    $params['user_id'] = $userid;
    if ($count) {
        $param = array();
        $param['search_count'] = $count - 1;
        $params['count'] = $param['search_count'];
        $rs = User::update($params['user_id'], $param);
        if ($rs) {
            search::add($params);
        }
        echo action_msg_data(api::SUCCESS_MSG, api::SUCCESS, null);
    } else {
//        echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$count);
        echo action_msg($e->getMessage(), $e->getCode());
    }


//检查手机验证码

} catch (MyException $e) {
    echo action_msg($e->getMessage(), $e->getCode());

}