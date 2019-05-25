<?php

$page =  isset($_POST['page'])?safeCheck($_POST['page'],0):1;
$pagesize =  isset($_POST['pagesize'])?safeCheck($_POST['pagesize'],0):0;

try {

    $res = array();

    //获取最新的行业记录
    $industrys = stock_sector::getlastestindustry($page,$pagesize);

    if(!empty($industrys)){
        $res["industry"] = $industrys;
    }

    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
    //检查手机验证码

}catch (MyException $e){
    $err['code'] = $e->getCode();
    $err['message'] = $e->getMessage();
    echo json_encode_cn($err);
}