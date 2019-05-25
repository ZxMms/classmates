<?php

try {

    $res = array();

    $fundcategory = fund_category::getAllCates();

    if(!empty($fundcategory)){
        $res["fundcategory"] = $fundcategory;
    }

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
    //检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}