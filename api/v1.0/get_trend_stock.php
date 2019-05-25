<?php
/**
 * Created by PhpStorm.
 * User: 关欣
 * Date: 2019/3/1
 * Time: 12:23
 */

require_once "../../init.php";

try {

    $count_array=array();
    $count_array[1]=stock_curr::getCountByType(stock_curr::BUY);
    $count_array[2]=stock_curr::getCountByType(stock_curr::SELL);

    $data_array = array();
    $data_array[1] = stock_curr::getStockByType(stock_curr::BUY);
    $data_array[2] = stock_curr::getStockByType(stock_curr::SELL);

    $param=array();
    $params=array();
    $params[1]['count']=$count_array[1]."支股票出现买入机会";
    $params[1]['stocklist']=$data_array[1];

    $params[2]['count']=$count_array[2]."支股票出现卖出机会";
    $params[2]['stocklist']=$data_array[2];

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$params);
//检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}