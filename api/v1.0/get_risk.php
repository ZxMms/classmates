<?php

try {

    $res = array();

    $risk = fund_risk::getAllRisk();


    foreach ($risk as &$item)
    {
        $item["name"] = $item["name"]."-".$item["desc"];
        unset($item["desc"]);
    }

    $res['risk'] = $risk;

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
    //检查手机验证码

}catch (MyException $e){
    $err['code'] = $e->getCode();
    $err['message'] = $e->getMessage();
    echo json_encode_cn($err);
}