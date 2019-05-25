<?php

require_once "../../init.php";
$tscode = safeCheck($_POST['tscode'],0);

try {

    $res = array();
    $symbol = substr($tscode,0,6);
    $stock_curr = Stock_data::getStockReal($symbol);
    $res['curr_price'] = $stock_curr["close_price"];

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
    //检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}
