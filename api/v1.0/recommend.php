<?php

try {

    $res = array();

    $buy = stock_curr::getStockByType(stock_curr::BUY);
    $sell = stock_curr::getStockByType(stock_curr::SELL);
    if(!empty($buy)){
        foreach ($buy as $k=>$item){
            $buy[$k]['addtime'] = date('Y-m-d',$item['addtime']);
            /*$stockinfo = Stock_data::getStockReal(substr($item['tscode'],0,6));
            $buy[$k]['curr_price'] = $stockinfo['close_price'];*/
        }
    }

    if(!empty($sell)){
        foreach ($sell as $k=>$item){
            $sell[$k]['addtime'] = date('Y-m-d',$item['addtime']);
            /*$stockinfo = Stock_data::getStockReal(substr($item['tscode'],0,6));
            $sell[$k]['curr_price'] = $stockinfo['close_price'];*/
        }
    }


    $res['buy'] = $buy;
    $res['sell'] = $sell;

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
    //检查手机验证码

}catch (MyException $e){
    $err['code'] = $e->getCode();
    $err['message'] = $e->getMessage();
    echo json_encode_cn($err);
}