<?php

require_once "../../init.php";
//$keyword= safeCheck($_POST['keyword'],0);

try {
    $uionid=$_COOKIE['uionid'];
//    echo $uionid;
    if(!$uionid){

        $res = array();
//    $user_info = User::getInfoByAccount($keyword)[0];
//        $user_info = User::getInfoByUionId($uionid)[0];
//        if(empty($user_info)){
//            throw new MyException("未查询到相关用户!",1001);
//        }

//    echo $_COOKIE['uionid'];

//        $res['id'] = $user_info['id'];
//        $res['wx_name'] = $user_info['wx_name'];
//        $res["wx_account"] = $user_info['wx_account'];
//        $res['wx_photourl'] = $user_info['wx_photourl'];
//        $res['sex'] = $user_info['sex'];
//        $res["address"] = $user_info['address'];
//        $res['first_logintime'] = $user_info['first_logintime'];
//        $res['last_logintime'] = $user_info['last_logintime'];
//        $res["total_money"] = $user_info['total_money'];
//        $res['last_money'] = $user_info['last_money'];
        $res['search_count'] = 10000;
//        $res["user_uionid"] = $user_info['uionid'];

        echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
    }else{



    $res = array();
//    $user_info = User::getInfoByAccount($keyword)[0];
    $user_info = User::getInfoByUionId($uionid)[0];
    if(empty($user_info)){
        throw new MyException("未查询到相关用户!",1001);
    }

//    echo $_COOKIE['uionid'];

    $res['id'] = $user_info['id'];
    $res['wx_name'] = $user_info['wx_name'];
    $res["wx_account"] = $user_info['wx_account'];
    $res['wx_photourl'] = $user_info['wx_photourl'];
    $res['sex'] = $user_info['sex'];
    $res["address"] = $user_info['address'];
    $res['first_logintime'] = $user_info['first_logintime'];
    $res['last_logintime'] = $user_info['last_logintime'];
    $res["total_money"] = $user_info['total_money'];
    $res['last_money'] = $user_info['last_money'];
    $res['search_count'] = $user_info['search_count'];
    $res["user_uionid"] = $user_info['uionid'];

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
    //检查手机验证码
    }
}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}
