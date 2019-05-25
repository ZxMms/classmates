<?php
/**
 * Created by PhpStorm.
 * User: tianyi
 * Date: 2018/12/27
 * Time: 20:42
 */
$keyword = safeCheck($_POST['keyword'],0);

try {

    $res = array();
    $keyword = strtoupper($keyword);

    $stockinfo = stock::getInfoByKeyword($keyword);//var_dump($stockinfo);exit();

    if(empty($stockinfo))
    {
        throw new MyException("未查询到相关股票!",1001);
    }



    //根据股票编码，调用接口查询
    $stock_cur = Stock_data::getStockReal($stockinfo["symbol"]);



    $res['tscode'] = $stockinfo['tscode'];


    $res['code'] = $stockinfo['symbol'];
    $res['name'] = $stockinfo['name'];
    $res['today'] = date("Y-m-d",time());
    $res['close_price'] = $stock_cur['close_price'];
    $res['rate'] = $stock_cur['rate'];
    $res['change_price'] = round($stock_cur['close_price']-$stock_cur['close_price']/(1+$stock_cur['rate']/100),2);

    $res['current_status_name'] = stock::getStatusname($stockinfo['current_status']);
    $res['tradetime'] = !empty($stockinfo['tradetime'])?date("Y-m-d",$stockinfo['tradetime']):"无";
    $res['tradepice'] = $stockinfo['tradeprice'];
    $res['holdday'] = round($stockinfo['holdday'],2);

    $res['sector'] = $stockinfo['sector'];

    $industrys = stock_sector::getAllIndustrys();
    $res['total_sector'] = count($industrys);
    $res['sector_rank'] = stock_sector::getRankBySector($stockinfo['sector']);
    $res['industrys'] = $industrys;

    $marketinfo = market::getlastestmarket();
    $res["market_status"] = $marketinfo[0]['status'];

    $res["beta_val"] = number_format($stockinfo['beta_val'],2,'.','');
    $res["next_drop_ratio"] = $stockinfo['next_drop_ratio'];


    $stock_predict = stock_history_predict::getPredictLastyear($stockinfo['tscode']);
    $res["trade_count"] = count($stock_predict);

    if(!empty($stock_predict)){
        foreach ($stock_predict as $k=>$item){

            $stock_predict[$k]['max_return'] = number_format($item["max_return"],1,'.','');
            $stock_predict[$k]['holdday'] = number_format($item["holdday"],1,'.','');

            $stock_predict[$k]['buytime'] = date("Y-m-d",$item['buytime']);
            $stock_predict[$k]['selltime'] = date("Y-m-d",$item['selltime']);
            $stock_predict[$k]['addtime'] = date("Y-m-d",$item['addtime']);
        }
    }
    $res['predict'] = $stock_predict;

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
    //检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}