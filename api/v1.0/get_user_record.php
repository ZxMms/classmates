<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2019/3/2
 * Time: 14:45
 */


require_once "../../init.php";

//
//$keyword= safeCheck($_POST['keyword'],0);
//$page =  isset($_POST['page'])?safeCheck($_POST['page'],0):1;
//$pagesize =  isset($_POST['pagesize'])?safeCheck($_POST['pagesize'],0):0;
try {

    $res = array();
    $params=array();
    $uionid=$_COOKIE['uionid'];
//    echo $uionid;
//    exit;
//    $params["id"]=$keyword;
    $record_List = Recharge::getInfoByUionId($uionid);
//    $record_List = Recharge::getListById($keyword);
    if(empty($record_List)){
        throw new MyException("未查询到相关记录!",1001);
    }

    $res['record'] = $record_List;


    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
    //检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}
