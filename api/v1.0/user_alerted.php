<?php
/**
 * Created by PhpStorm.
 * User: wangming
 * Date: 2019/3/22
 * Time: 10:02
 */

require_once "../../init.php";

$uionid=$_COOKIE['uionid'];

$user_rs = User::getInfoByUionId($uionid);


//var_dump($user_rs);

$isalerted = $user_rs[0]['isalerted'];

$attrs = array(
    'isalerted' => 1,
);

User::update($user_rs[0]['id'], $attrs);