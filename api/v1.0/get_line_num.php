<?php
require_once "../../init.php";

try {
    $res = array();

    $res["type"] = array();
    $res["number"] = array();

    $all_acount=people::getCount();
    $res["type"][0]="有电话号码";
    $res["number"][0] = people::getCountByType(1)-0;
    $res["type"][1]="有QQ号码";
    $res["number"][1] = people::getCountByType(2)-0;
    $res["type"][2]="有微信号码";
    $res["number"][2] = people::getCountByType(3)-0;
    $res["type"][3]="无联系方式";
    $res["number"][3] = $all_acount-people::getCountByTel();
    $res["type"][4]="有联系方式";
    $res["number"][4] = people::getCountByTel()-0;

    $data[] = $res;


    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$data);
//检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}