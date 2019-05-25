<?php
/**
 * Created by PhpStorm.
 * User: xiepeng
 * Date: 2017/8/17
 */


//$wechatObj = new weixin();
//
//$wechatObj->index();



class weixin
{

    /**线上***/


    const SCOPE_USERINFO = 'snsapi_base'; //授权方法

    /**测试***/


    const TOKEN_BASE_KEY = "weixin_access_token";
    const JS_TICKET_KEY = "weixin_js_ticket";
    const LimitTime = 7100;



    public $setFlag = false;
    public $msgtype = 'text';   //('text','image','location')
    public $msg = array();

    /****微信支付支付向相关参数****/


    public function __construct()
    {
    }

    public function index()
    {

        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $token = 'weixin_xian_rd_2018';
        $signature = $_GET['signature'];
        $echostr = $_GET['echostr'];

        $array = array($timestamp, $nonce, $token);
        sort($array);
        $tmpstr = sha1(implode('', $array));
        if ($tmpstr == $signature && $echostr) {
            echo $echostr;
        }
    }


    public function getAccessToken()
    {
        $rs = Baseconfig::getInfoByKey(self::TOKEN_BASE_KEY);


        if (empty($rs) || (time() - $rs["lastupdate"]) > self::LimitTime) {

            $accessToken = self::refreshToken();
        } else {

            $accessToken = $rs["value"];

        }

        return $accessToken;
    }

    public function refreshToken()
    {

        $conf = $this->_conf();
        $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $conf["appid"] . "&secret=" . $conf["appkey"];

        $res = file_get_contents($token_access_url); //
        $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量s
        $access_token = $result['access_token'];

        $rs = Baseconfig::getInfoByKey(self::TOKEN_BASE_KEY);
        if ($rs) {
            $res = Baseconfig::update($rs["id"], array("value" => $access_token, "lastupdate" => time()));
        } else {
            $res = Baseconfig::add(self::TOKEN_BASE_KEY, $access_token, "微信开发access_token");
        }
        if ($res) {
            return $access_token;
        }
    }

    public function getUserInfo($openId)
    {
        $token = $this->getAccessToken();
        $token_access_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $token . "&openid=" . $openId . "&lang=zh_CN";
        $res = file_get_contents($token_access_url); //
        return json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
    }

    public function getInfoByCode()
    {
        $code = isset($_REQUEST["code"])?$_REQUEST["code"]:"";
        if(empty($code))
        {
            return 0;
        }

        $conf = $this->_conf();

        $token_access_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $conf["appid"] . "&secret=" . $conf["appkey"] . "&code=" . $code . "&grant_type=authorization_code";
        $res = file_get_contents($token_access_url); //
        return json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
    }

    public function createMenu()
    {

        global $HTTP_PATH;
        $access_token = $this->getAccessToken();

        echo $access_token;
        $data = '{
                     "button":[
                      {

                         "name":"校友信息",

                          "sub_button":[{

                          "type":"view",
                          "name":"校友新闻",
                          "url":"'.$HTTP_PATH.'weixin/news_list.php"
                          },
                          {
                           "type":"view",
                          "name":"出彩校友",
                          "url":"'.$HTTP_PATH.'weixin/people_list.php"
                          },
                          {
                             "type":"view",
                          "name":"校友捐赠",
                          "url":"'.$HTTP_PATH.'weixin/donate_list.php"
                          },
                           
                           {
                          "type":"view",
                          "name":"聚会公告",
                          "url":"'.$HTTP_PATH.'weixin/meeting_list.php"
                          },
                          {
                          "type":"view",
                          "name":"校友文苑",
                          "url":"'.$HTTP_PATH.'weixin/paper_list.php"
                          }
                          ]
                     },
                     {

                         "name":"校友服务",

                          "sub_button":[{

                          "type":"view",
                          "name":"个人信息录入",
                          "url":"'.$HTTP_PATH.'weixin/class_add.php"
                          },
                       
                          {
                          "type":"view",
                          "name":"聚会申请录入",
                           "url":"'.$HTTP_PATH.'weixin/meeting_add.php"
                          },
                           {
                          "type":"view",
                          "name":"校友英才招聘",
                          "url":"'.$HTTP_PATH.'weixin/job_list.php"
                          }
                         
                          ]
                     },
                     {
                         "name":"石大信息",

                          "sub_button":[{

                          "type":"view",
                          "name":"回到石大",
                          "url":"http://www.xapi.edu.cn/"
                          },
                          {
                          "type":"view",
                          "name":"校友信息",
                          "url":"https://www.wenjuan.com/s/fUveQr/"
                          },
                          {
                          "type":"view",
                          "name":"联系我们",
                          "url":"http://xyl.xsyu.edu.cn/lxwm.jhtml"
                          }
                          ]

                     },
                     
                    
                     ]
                }';

        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token;

        return $this->curlPost($data, $url);
    }

    public function curlPost($data, $url)
    {
        //var_dump($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        //   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);

        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        curl_close($ch);

        return $tmpInfo;
    }



    public function getMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)) {
            $this->msg = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->msgtype = strtolower($this->msg['MsgType']);
        }
    }

    public function makeText($text='')
    {
        $CreateTime = time();
        $FuncFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg['FromUserName']}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg['ToUserName']}]]></FromUserName>
            <CreateTime>{$CreateTime}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        return sprintf($textTpl,$text,$FuncFlag);
    }



    public function makeTextPic($arr)
    {
        $CreateTime = time();

        $len = count($arr);
        $textTpl = "<xml><ToUserName><![CDATA[{$this->msg['FromUserName']}]]></ToUserName><FromUserName><![CDATA[{$this->msg['ToUserName']}]]></FromUserName><CreateTime>{$CreateTime}</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>{$len}</ArticleCount><Articles>";

        $itemTpl = "<item><Title><![CDATA[%s]]></Title><Description><![CDATA[%s]]></Description><PicUrl><![CDATA[%s]]></PicUrl><Url><![CDATA[%s]]></Url></item>";
        foreach ($arr as $item)
        {
            $textTpl .= sprintf($itemTpl,$item["title"],$item["description"],$item["picUrl"],$item["url"]);
        }

        $textTpl .= "</Articles></xml>";
        return $textTpl;

    }

    public function reply($data)
    {
        echo $data;
    }



    public function getSignPackage() {
        $jsapiTicket = $this->getJsTicket();

        $conf = $this->_conf();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $nonceStr = $this->createNonceStr();
        $timestamp = time();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $conf["appid"],
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );

        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


    public function downLoadFile($serverId,$foldername){

        $access_token = $this->getAccessToken();


        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$serverId;
        if (!file_exists($foldername)) {
            mkdir($foldername, 0777, true);
        }
        $targetName = date('YmdHis').rand(1000,9999).'.jpg';

        $targetPathName = $foldername.$targetName;

        //获取微信“获取临时素材”接口返回来的内容（即刚上传的图片）
        $a = file_get_contents($url);
        //以读写方式打开一个文件，若没有，则自动创建
        $resource = fopen($targetPathName , 'w+');
        //将图片内容写入上述新建的文件
        fwrite($resource, $a);
        //关闭资源
        fclose($resource);

        return $targetName;
    }

    public function sendImageToUser($openId,$mediaId)
    {
        $acccess_token = $this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$acccess_token}";
        $sendData=' {
                        "touser":"'.$openId.'",
                        "msgtype":"image",
                        "image":
                        {
                          "media_id":"'.$mediaId.'"
                        }
                    }';

        return $this->curlPost($sendData,$url);
    }


    public function sendMsgToUser($openId,$content)
    {
        $acccess_token = $this->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$acccess_token}";
        $sendData='{
                        "touser": "'.$openId.'",
                        "msgtype": "text",
                        "text": {
                                "content": "'.$content.'"
                        }
                    }';

        return $this->curlPost($sendData,$url);

    }


    public function getJsTicket(){ // 只允许本类调用，继承的都不可以调用，公开调用就更不可以了

        $rs = Baseconfig::getInfoByKey(self::JS_TICKET_KEY);

        if(empty($rs)||(time()-$rs["lastupdate"])>self::LimitTime)
        {
            $jsticket = self::refreshJsTicket();
        }
        else
        {
            $jsticket = $rs["value"];
        }

        return $jsticket ;

    }

    public function refreshJsTicket()
    {
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$access_token."&type=jsapi"; // 两小时有效
        $rurl = file_get_contents($url);
        $rurl = json_decode($rurl,true);
        if($rurl['errcode'] != 0){
            return false;
        }else{
            $jsticket = $rurl['ticket'];
            $rs = Baseconfig::getInfoByKey(self::JS_TICKET_KEY);
            if($rs)
            {
                $res = Baseconfig::update($rs["id"],array("value"=>$jsticket,"lastupdate"=>time()));
            }
            else
            {
                $res = Baseconfig::add(self::JS_TICKET_KEY,$jsticket,"微信开发js_ticket");
            }

            if($res)
            {
                return $jsticket;
            }
        }
    }


    /**
     *
     * 获取支付结果通知数据
     * return array
     */
    public function getNotifyData(){
        //获取通知的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $data = array();
        if( empty($xml) ){
            return false;
        }
        $data = self::xml_to_data( $xml );
        if( !empty($data['return_code']) ){
            if( $data['return_code'] == 'FAIL' ){
                return false;
            }
        }
        return $data;
    }

    /**
     * 将xml转为array
     * @param string $xml
     * return array
     */
    public function xml_to_data($xml){
        if(!$xml){
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }


    /**
     * 用户隐秘授权
     * @param $redirectUrl
     * @return string
     */
    function login_url($redirectUrl)
    {

        $conf = $this->_conf();

        $params = array(
            'appid' => $conf["appid"],
            'redirect_uri' => $redirectUrl,
            'response_type' => 'code',
            'scope' => self::SCOPE_USERINFO,
            'state' => time(),
        );


        return 'https://open.weixin.qq.com/connect/oauth2/authorize?' . http_build_query($params) . '#wechat_redirect';
    }


    public static function savePicToServer($url,$fileName) {
        // 要存在你服务器哪个位置？
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $fp = fopen($fileName,'wb');
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_FILE,$fp);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

    }



    public function _conf()
    {

        $arr = Baseconfig::getInfoByArr(array(Baseconfig::CFG_WEIXIN_APPID,Baseconfig::CFG_WEIXIN_APPKEY));
        $info = array();
        foreach ($arr as $v)
        {
            if ($v['key'] == Baseconfig::CFG_WEIXIN_APPID)
            {
                $info['appid'] = $v['value'];
            }
            if ($v['key'] == Baseconfig::CFG_WEIXIN_APPKEY)
            {
                $info['appkey'] = $v['value'];
            }
        }

        return $info;
    }
    public function sendMsgToUserHaveUrl($openid,$text)
    {

        $ToUserName = Baseconfig::getInfoByKey(Baseconfig::CFG_WEIXIN_APPID)['value'];
        $CreateTime = time();

        $textTpl = "<xml>
            <ToUserName><![CDATA[$ToUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$openid}]]></FromUserName>
            <CreateTime>{$CreateTime}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>";

        return sprintf($textTpl,$text);
    }





}