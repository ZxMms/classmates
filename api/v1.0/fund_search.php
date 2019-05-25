<?php
/**
 * Created by PhpStorm.
 * User: zhima
 * Date: 2019/1/12
 * Time: 下午2:38
 */
$keyword = safeCheck($_POST['keyword'],0);

try {

    $res = array();
    $keyword = strtoupper($keyword);

    $fundlist = fund_sum::getListByKeyword($keyword);

    $res["fundlist"] = $fundlist;
    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}