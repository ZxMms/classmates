<?php
/**
 * Created by PhpStorm.
 * User: tianyi
 * Date: 2018/12/26
 * Time: 21:04
 */

try {

    $res = array();

    //获取最新一条板块记录
    $market = market::getlastestmarket();
    $introduction=Config::getInfoByKey(Config::TREND_INTRODUCTION)['value'];

    if(!empty($market)){
        $res["market"] = $market[0];
    }
    $res['interduction']=$introduction;
    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
    //检查手机验证码

}catch (MyException $e){
    $err['code'] = $e->getCode();
    $err['message'] = $e->getMessage();
    echo json_encode_cn($err);
}