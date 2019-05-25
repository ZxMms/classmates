<?php
/**
 * Created by PhpStorm.
 * User: tianyi
 * Date: 2018/12/26
 * Time: 22:12
 */
class API {

    const SUCCESS = 200;
    const SUCCESS_MSG= "success";


    //API编号，数字
    public $code;

    //API来源
    public $source = 0;

    //API 某一天，时间戳
    public $day;

    //发生错误
    public $error = false;

    //是否统计错误调用
    public $errcount = false;

    public function __construct($code, $errcount = true) {

        $this->code = $code;
        $this->day = strtotime(date('Y-m-d'));
        if($errcount) $this->errcount = true;

    }

    //发生错误
    public function ApiError($errcode, $errmsg){
        $this->error = true;

        //统计
        if($this->errcount) $this->apicount();

        $err = array();
        $err['code'] = $errcode;
        $err['message'] = $errmsg;
        $err_json = json_encode_cn($err);
        echo $err_json;

        exit();//发生错误直接退出
    }
}