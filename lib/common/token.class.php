<?php

/**
 * token.class.php
 *
 * @version       v0.01
 * @create time   2017/7/14
 * @update time
 * @author        TQ
 * @copyright     Copyright (c) 微普科技 WiiPu Tech Inc. (http://www.wiipu.com)
 */
class token
{

    const LimitTime = 31536000;
    const TOKEN_KEY = "***rongcheng110***";


    static public function genToken($id){
        $str = json_encode(array(time(),mt_rand(1000,9999),$id));
        return self::authcode($str, 'ENCODE', self::TOKEN_KEY);
    }


    static public function checkToken($token){
        $str = self::authcode($token, 'DECODE', self::TOKEN_KEY);
        $result = json_decode($str);
        if(is_array($result)){
            if(time()-$result[0]>self::LimitTime)
            {
                throw new MyException("token已失效!",100);
            }
            return $result[2];
        }else{
            throw new MyException("解密失败!",100);
        }
    }


    static function authcode($string, $operation = 'DECODE', $key){

        $ckey_length = 4;   // 随机密钥长度 取值 0-32;

        $key = md5($key);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }
}
?>
