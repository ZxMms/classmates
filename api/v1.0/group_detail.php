<?php
/**
 * Created by PhpStorm.
 * User: zhima
 * Date: 2019/1/9
 * Time: 下午12:58
 */



try{

    $type = safeCheck($_POST["type"]);




    $data = array();


    $typeInfo = fund_group_perform::getInfoByType($type);

    if(empty($typeInfo))
    {
        throw new MyException("找不到对应的对合",101);
    }

    $data["name"] = $typeInfo["name"]."组合";


    $sumweight = fund_group_port::getSumweightByType($type);

    if(!empty($sumweight)){
        foreach ($sumweight as $k=>$item){

            $dataItem = array();

            $dataItem["name"] = $item["fund_type"];
            $dataItem["weight"] = $item["sum_weight"];

            $dataItem["itemData"] = fund_group_port::getItemByFundtype($type,$item["fund_type"]);

            $data["item"][] = $dataItem;
        }
    }
    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$data);

}catch (MyException $e)
{
    echo $e->jsonMsg();
}

