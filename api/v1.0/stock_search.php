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

    $stocklist = stock::getListByKeyword($keyword);

    $res["stocklist"] = $stocklist;
    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}