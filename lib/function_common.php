<?php

/**
 * function_common.php 常用函数文件，与业务无关的函数
 *
 * @version       v0.02
 * @createtime    2014/7/24
 * @updatetime    2016/3/19 2016/7/27
 * @author        jt
 * @copyright     Copyright (c) 芝麻开发 (http://www.zhimawork.com)
 * 2016/7/27 将一些功能相近的函数整理成类
 */

/**
 * safeCheck() 参数检查，并防XSS 和 SQL注入
 * 
 * @param mixed $str   
 * @param bool $number 是否做数字检查 1-（默认）数字 0-不是数字
 * @param bool $script 是否过滤script 1-（默认）过滤；0-不过滤
 * @return
 */
function safeCheck($str, $number = 1, $script = 1){

	$str = trim($str);
	//防止SQL注入
	if(!get_magic_quotes_gpc()){
		$str = addslashes($str);
	}
	//数字检查
	if($number == 1){
		$isint   = preg_match('/^-?\d+$/',$str);
		$isfloat = preg_match('/^(-?\d+)(\.\d+)?$/',$str);
		if(!$isint && !$isfloat){
			die('参数'.$str.'必须为数字!');
		}
	}else{
		//过滤script、防XSS
		if($script == 1){
			$str = str_replace(array(">", "<"), array("&gt;", "&lt;"), $str);
		}
	}
	return $str;
}

/**
 * ckReplace()  ckEditor编辑器内容处理
 * 
 * @param mixed $content
 * @return
 */
function ckReplace($content){
	if (!empty($content)){
		$content = str_replace("'", "&#39;", $content);
        $content = str_replace("<br />", "</p><p>", $content);
	}
	return $content;
}

/**
 * HTMLEncode()将特殊字符转成HTML格式，主要用于textarea获取值 
 * 
 * @param mixed $str
 * @return
 */
function getPageUrl(){
    $url = (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://';
    $url .= $_SERVER['HTTP_HOST'];
    $url .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : urlencode($_SERVER['PHP_SELF']) . '?' . urlencode($_SERVER['QUERY_STRING']);
    return $url;
}

function HTMLEncode($str){
	if (!empty($str)){
		$str = str_replace("&","&amp;",$str);
		$str = str_replace(">","&gt;",$str);
		$str = str_replace("<","&lt;",$str);
		$str = str_replace(CHR(32),"&nbsp;",$str);
		$str = str_replace(CHR(9),"&nbsp;&nbsp;&nbsp;&nbsp;",$str);
		$str = str_replace(CHR(9),"&#160;&#160;&#160;&#160;",$str);
		$str = str_replace(CHR(34),"&quot;",$str);
		$str = str_replace("'","&#39;",$str);
		$str = str_replace(CHR(39),"&#39;",$str);
		$str = str_replace(CHR(13),"",$str);
		$str = str_replace(CHR(10),"<br/>",$str);
	}
	return $str;
}

/**
 * HTMLDecode()将HTMLEncode的数据还原 
 * 
 * @param mixed $str
 * @return
 */
Function HTMLDecode($str){
	if (!empty($str)){
		$str = str_replace("&amp;","&",$str);
		$str = str_replace("&gt;",">",$str);
		$str = str_replace("&lt;","<",$str);
		$str = str_replace("&nbsp;",CHR(32),$str);
		$str = str_replace("&nbsp;&nbsp;&nbsp;&nbsp;",CHR(9),$str);
		$str = str_replace("&#160;&#160;&#160;&#160;",CHR(9),$str);
		$str = str_replace("&quot;",CHR(34),$str);
		$str = str_replace("&#39;",CHR(39),$str);
		$str = str_replace("",CHR(13),$str);
		$str = str_replace("<br/>",CHR(10),$str);
		$str = str_replace("<br />",CHR(10),$str);
		$str = str_replace("<br>",CHR(10),$str);
	}
	return $str;
}

/**
 * 生成随机数randcode()
 * 
 * @param mixed $len
 * @param integer $mode
 * @return
 */
function randcode($len, $mode = 2){
	$rcode = '';

	switch($mode){
		case 1: //去除0、o、O、l等易混淆字符
			$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghijkmnpqrstuvwxyz';
			break;
		case 2: //纯数字
			$chars = '0123456789';
			break;
		case 3: //全数字+大小写字母
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
			break;
		case 4: //全数字+大小写字母+一些特殊字符
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz~!@#$%^&*()';
			break;
	}
	
	$count = strlen($chars) - 1;
	mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $len; $i++) {
		$rcode .= $chars[mt_rand(0, $count)];
	}
	
	return $rcode;
}

/**
 * Json_encode的Unicode中文(\u4e2d\u56fd)问题
 * 
 * @param mixed $array
 * @return
 */
function json_encode_cn($array){
	$str = json_encode($array);
	$os  = Env::getOSType();
	if($os == 'windows')
		$ucs = 'UCS-2';
	else
		$ucs = 'UCS-2BE';

	if (version_compare(PHP_VERSION, '5.5.0') >= 0) {
		$str = preg_replace_callback("/\\\\u([0-9a-f]{4})/i", create_function('$matches', 'return iconv("'.$ucs.'", "UTF-8", pack("H*", $matches[1]));'), $str);
	}else{
		$str = preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('".$ucs."', 'UTF-8', pack('H4', '\\1'))", $str);
	}
	return $str;
}

/**
 * 操作响应通知(默认json格式)
 * 
 * @param $msg  消息内容
 * @param $code 消息代码
 * @return
 */
function action_msg($msg, $code, $json = true){
	$r = array(
		'code' => $code,
		'msg'  => $msg
	);
	if($json) 
		return json_encode_cn($r);
	else
		return $r;
}


function action_msg_data($msg, $code,$data=array(), $json = true){
    $r = array(
        'code' => $code,
        'message'  => $msg,
        'data'=>$data
    );
    if($json)
        return json_encode_cn($r);
    else
        return $r;
}





function getProblemChineseNum($level)
{
    $dataArr = array(

        1=>"一",
        2=>"二",
        3=>"三",
        4=>"四",
        5=>"五"
    );


    return isset($dataArr[$level])?$dataArr[$level]:"";

}

function getDepartmentChineseNum($level)
{
    $dataArr = array(

        1=>"一",
        2=>"二"
    );


    return isset($dataArr[$level])?$dataArr[$level]:"";

}

function explodeNew ($info)
{
    $results=array();
    $find = array(
        ",",
        '，',
        "~",
        "～",
        " ",
        "、",
        "<br/>"
    );

    $re = "#";
    $info = str_replace($find,$re,trim($info));
    foreach(explode("#",$info) as $item)
    {
        if(!empty($item)) $results[] = $item;
    }

    return $results;

}



function  subStrContent($content,$len,$dian=0)
{

    if(mb_strlen($content,"UTF-8")>$len)
    {

        $content = mb_substr($content,0,$len,"utf-8");
        if($dian)
        {
            $content .="...";
        }

    }


    return $content;
}



function  isVideo($ext)
{

    $extArr = array('mp4','MP4');
    if(in_array($ext,$extArr))
    {
        return true;
    }
    else
    {
        return false;
    }
}




function getFirstCharter($str)
{
    if (empty($str)) {
        return '';
    }

    $fchar = ord($str{0});
    if ($fchar >= ord('A') && $fchar <= ord('z'))
        return strtoupper($str{0});

    $s1 = iconv('UTF-8','gbk//ignore', $str);
    $s2 = iconv('gbk', 'UTF-8//ignore', $s1);
    $s = $s2 == $str ? $s1 : $str;

    $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;

    if ($asc >= -20319 && $asc <= -20284)
        return 'A';

    if ($asc >= -20283 && $asc <= -19776)
        return 'B';

    if ($asc >= -19775 && $asc <= -19219)
        return 'C';

    if ($asc >= -19218 && $asc <= -18711)
        return 'D';

    if ($asc >= -18710 && $asc <= -18527)
        return 'E';

    if ($asc >= -18526 && $asc <= -18240)
        return 'F';

    if ($asc >= -18239 && $asc <= -17923)
        return 'G';

    if ($asc >= -17922 && $asc <= -17418)
        return 'H';

    if ($asc >= -17417 && $asc <= -16475)
        return 'J';

    if ($asc >= -16474 && $asc <= -16213)
        return 'K';

    if ($asc >= -16212 && $asc <= -15641)
        return 'L';

    if ($asc >= -15640 && $asc <= -15166)
        return 'M';

    if ($asc >= -15165 && $asc <= -14923)
        return 'N';

    if ($asc >= -14922 && $asc <= -14915)
        return 'O';

    if ($asc >= -14914 && $asc <= -14631)
        return 'P';

    if ($asc >= -14630 && $asc <= -14150)
        return 'Q';

    if ($asc >= -14149 && $asc <= -14091)
        return 'R';

    if ($asc >= -14090 && $asc <= -13319)
        return 'S';

    if ($asc >= -13318 && $asc <= -12839)
        return 'T';

    if ($asc >= -12838 && $asc <= -12557)
        return 'W';

    if ($asc >= -12556 && $asc <= -11848)
        return 'X';

    if ($asc >= -11847 && $asc <= -11056)
        return 'Y';

    if ($asc >= -11055 && $asc <= -10247)
        return 'Z';

    return null;

}

?>