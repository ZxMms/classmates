<?php

require_once "../../init.php";
$keyword = safeCheck($_POST['keyword'],0);
try {
    $res = array();

    $fundinfo = fund_sum::getInfoByKeyword($keyword);//var_dump($stockinfo);exit();

    if(empty($fundinfo)){
        throw new MyException("未查询到相关基金!",1001);
    }

    //根据基金代码，调用接口查询
    $fund_cur = fund::getFundReal($keyword);
    $res = array();
    $res['symbol'] = $fundinfo['symbol'];
    $res['code'] = $fundinfo['code'];
    $res['name'] = $fundinfo['name'];
    $res["current_price"] = $fund_cur['current_price'];
    $res["change"] = $fund_cur['change'];
    $res["ratio"] = $fund_cur['ratio'];
    $res["today"] = date("Y-m-d",time());

    $res["last_status"] = $fundinfo["last_status"];
    $res["last_trade_time"] = date("Y-m-d",$fundinfo["last_trade_time"]);
    $res["last_price"] = $fundinfo["last_price"];
    $res["display_flag"] = $fundinfo["display_flag"];

    $res["last_holding_time"] = $fundinfo["last_holding_time"];

    $risk_rank = fund_risk_rank::getInfoBySymbol($keyword);
    if (!empty($risk_rank)){
        $res["risk_return1"] = $risk_rank["return1"];
        $res["risk_return3"] = $risk_rank["return3"];
        $res["risk_return6"] = $risk_rank["return6"];
        $res["risk_return12"] = $risk_rank["return12"];
        $res["risk_rank1"] = $risk_rank["rank1"];
        $res["risk_rank3"] = $risk_rank["rank3"];
        $res["risk_rank6"] = $risk_rank["rank6"];
        $res["risk_rank12"] = $risk_rank["rank12"];
        $res["risk_median1"] = $risk_rank["median1"];
        $res["risk_median3"] = $risk_rank["median3"];
        $res["risk_median6"] = $risk_rank["median6"];
        $res["risk_median12"] = $risk_rank["median12"];
        $res["risk_count_type"] = $risk_rank["count_type"];
    }

    $type_rank = fund_type_rank::getInfoBySymbol($keyword);
    if (!empty($type_rank)){
        $res["type_return1"] = $type_rank["return1"];
        $res["type_return3"] = $type_rank["return3"];
        $res["type_return6"] = $type_rank["return6"];
        $res["type_return12"] = $type_rank["return12"];
        $res["type_rank1"] = $type_rank["rank1"];
        $res["type_rank3"] = $type_rank["rank3"];
        $res["type_rank6"] = $type_rank["rank6"];
        $res["type_rank12"] = $type_rank["rank12"];
        $res["type_median1"] = $type_rank["median1"];
        $res["type_median3"] = $type_rank["median3"];
        $res["type_median6"] = $type_rank["median6"];
        $res["type_median12"] = $type_rank["median12"];

        $res["type_count_type"] = $type_rank["count_type"];
    }
    //获取fundinfo，再获取$fundinfo["code"]
    $predict = fund_details::getPredictLastyear($fundinfo['code']);

    if(!empty($predict)){
        $res["trade_count"] = count($predict);
        foreach ($predict as &$item){
            $item['buy_time'] = date("Y-m-d",$item['buy_time']);
            $item['sell_time'] = date("Y-m-d",$item['sell_time']);

            unset($item["last_update"]);
        }
    }
    $res['predict'] = $predict;

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
//检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}