<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2019/2/28
 * Time: 14:36
 */

require_once "../../init.php";

try {

    $count_array=array();
    $count_array[1]=stock::getCountByBoard(stock::MAIN_BOARD);
    $count_array[2]=stock::getCountByBoard(stock::MEDIUM_BOARD);
    $count_array[3]=stock::getCountByBoard(stock::CREATE_BOARD);

    $introduction=Config::getInfoByKey(Config::TREND_INTRODUCTION)['value'];
    $params=array();


    $j=0;
    for ($i=1;$i<4;$i++){
       $param=array();
       $param['name']=$BOARD_type[$i];
       $param['count']=$count_array[$i]."支";
       $params[$j]['data']=$param;
       $j++;
    }
    $params['interduction']=$introduction;
    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$params);
//检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}