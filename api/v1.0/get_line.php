<?php
require_once "../../init.php";

try {
    $res = array();

    $res["grade"] = array();
    $res["number"] = array();
    $grades = people::getGradeList();

    $i=0;
    if(!empty($grades)){
        foreach ($grades as $grade){
            foreach ($grade as $k=>$item){
                $param=array();
                $param['grade']=$item;
                $res["grade"][$i]=$item;
//            $res["number"][$k] = date('Y-m-d',$item['trade_date']);
                $res["number"][$i] = people::getnumberList($param);
//            $res["market_price"][$k] = $item['market_price'];

            }
            $i++;
        }

    }



    $data[] = $res;


    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$data);
//检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}