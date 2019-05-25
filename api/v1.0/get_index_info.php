<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2019/2/28
 * Time: 14:36
 */

require_once "../../init.php";

try {

//    $params=array();
//    $params["page"]=1;
//    $params["pageSize"]=3;
//    $advertisement_info = Advertisement::getList($params);
//
//    if(empty($advertisement_info)){
//        throw new MyException("无广告图片!",1001);
//    }

    $index_list = market_index::getList();

    if(empty($index_list)){
        throw new MyException("无指数信息!",1001);
    }
    $str_info="";

    foreach ($index_list as $item){
        $str=$item['name']." ".sprintf("%.2f",$item['last'])."，";
        $str_info.=$str;
    }
    $buy_count=stock_curr::getCountByType(stock_curr::BUY);
    $sell_count=stock_curr::getCountByType(stock_curr::SELL);
    $str_info.="{$buy_count}只股票出现买入机会，{$sell_count}只股票出现卖出机会";

    $justindex = 0;
    if (isset($_POST['justindex']) && $_POST['justindex']==1) {
        $justindex = 1;
    }

    if ($justindex != 1) {
        $user_rs = User::getNewRechargeList(1, 30, 0);
//var_dump($rs);

        $user_arr = array();
        foreach ($user_rs as $user_r) {
            $user_arr[] = array(
                'name'=>'****'.substr($user_r['user_uionid'], strlen($user_r['user_uionid']) - 6) ,
                'img'=>str_replace('http://','https://', $user_r['user_wx_photourl']),
                'count' => $user_r['recharge_count'],
            );

        }

    }

    $res = array();
//    $res['picurl'] = $HTTP_PATH.$advertisement_info[0]['picurl'];
//    $res['url'] = $advertisement_info[0]['url'];

    $res['title'] = $str_info;

    if ($justindex != 1) {
        $res['newpayinfo'] = $user_arr;
    }


//    $i=0;
//    foreach ($advertisement_info as $value){
//        $res['ad'][$i]=$value;
//        $i++;
//    }

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
//检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}