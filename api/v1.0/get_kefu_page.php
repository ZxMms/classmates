<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2019/3/7
 * Time: 15:08
 */

require_once "../../init.php";

try {


    $pay_info = Config::getInfoByKey(Config::KEFU_PAGE)['value'];

    if(empty($pay_info)){
        throw new MyException("无协议!",1001);
    }

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$pay_info);
//检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}