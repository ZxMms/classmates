<?php
/**
 * Created by PhpStorm.
 * User: zhima
 * Date: 2018/5/16
 * Time: 下午2:52
 */

require_once("admin_init.php");

$weixin = new weixin();




$reply = "";
$weixin->getMsg();
if($weixin->msgtype==='event')
{
    if($weixin->msg['Event']=="subscribe")
    {

        $content = "欢迎关注西安石油大学校友公众号!";

        $reply = $weixin->makeText($content);
    }

    $weixin->reply($reply);

}

