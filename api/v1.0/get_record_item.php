<?php


try {
    $res = array();

    $itemList = Recharge_item::getList();

    if(empty($itemList)){
        throw new MyException("无选项!",1001);
    }
    $res['item_list']=$itemList;


    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
//检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}