<?php

$code = safeCheck($_POST['code'],0);
try {
    $res = array();
    $fundinfo = fund_sum::getInfoByKeyword($code);//var_dump($stockinfo);exit();


    if(empty($fundinfo)){
        throw new MyException("未查询到相关基金!",1001);
    }


    $fileName = getFileName($fundinfo["code"]);
    $filepath = "http://111.231.246.141/Input/Tushare/fund/fund_nav/".$fileName;



    $beginDate = date("Ymd",time()-86400*365);

//    $fp = fopen($filepath, 'r');
//    $i = 1;
//    $date =array();
//    $unit_nav =array();
//    while($line = fgets($fp)){
//        if($i == 1){
//            $i++;
//            continue;
//        }
//        $line=str_replace("\t","_",$line);
//        $content=explode("_",$line);
//        $date[$i-2]=$content[2];
//        $unit_nav[$i-2]=$content[3];
//        $i++;
//    }
//    fclose($fp);



    $contents = file_get_contents($filepath);



    if(!empty($contents))
    {
        $contentsArr = explode("\r\n",$contents);

        $len = count($contentsArr);
        $date = array();
        $unit_nav = array();
        while($len>1)
        {
            $currentData = explode("\t",$contentsArr[$len-1]);
            $currentDate = $currentData[2];


            if($currentDate<$beginDate) break;


            $date[] = date("Y-m-d",strtotime($currentData[2]));
            $unit_nav[] = $currentData[3];
            $len--;


        }

        $date = array_reverse($date);
        $unit_nav = array_reverse($unit_nav);


        $res['date'] = $date;
        $res['unit_nav'] = $unit_nav;
    }





    echo action_msg_data(api::SUCCESS_MSG,api::SUCCESS,$res);
//检查手机验证码

}catch (MyException $e){
    echo action_msg($e->getMessage(),$e->getCode());

}



function getFileName($tsCode)
{
    $codeData = explode(".",$tsCode);

    return strtolower($codeData[1]).$codeData[0].".txt";
}