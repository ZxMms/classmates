<?php
/**
 * Created by PhpStorm.
 * User: zhima
 * Date: 2018/12/14
 * Time: 下午2:33
 */



$keyword = safeCheck($_REQUEST['keyword'], 0);

$replay = new Reply();

$content = $replay->checkReply($keyword);

if($content)
{
    $content =  "点击链接查看".$content["url"];
}
else
{
    $result = xunfei::testWebaiui($keyword);
    if(!empty($result)&&!empty($result["data"][0]["intent"]["answer"]["text"]))
    {
        $content = $result["data"][0]["intent"]["answer"]["text"];
    }
    else
    {
        $content = $replay->ramdonResult();
    }
}
echo action_msg($content,1);