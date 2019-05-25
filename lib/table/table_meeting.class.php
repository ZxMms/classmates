<?php


class Table_meeting extends Table
{
    private static  $pre = "meeting_";
    static protected function struct($data)
    {
        $r = array();

        $r['id'] = $data['meeting_id'];
        $r['time'] = $data['meeting_time'];
        $r['name'] = $data['meeting_name'];
        $r['content'] = $data['meeting_content'];

        $r['people'] = $data['meeting_people'];
        $r['class'] = $data['meeting_class'];
        $r['status'] = $data['meeting_status'];

        $r['addtime'] = $data['meeting_addtime'];
        $r['img'] = $data['meeting_img'];

        return $r;
    }

    /**
     * @param $attr
     * @return array|mixed
     *
     */
    static public function getTypeByAttr($attr)
    {
        $typeAttr = array(
            "id"=>"number",
            "time"=>"number",
            "name"=>"string",
            "content"=>"string",
            "people"=>"string",
            "class"=>"string",
            "status"=>"number",
            "img"=>"string",
            "addtime"=>"number"
        );

        return isset($typeAttr[$attr])?$typeAttr[$attr]:$typeAttr;
    }


    /**
     * @param $attrs
     * @return mixed
     *
     */
    static public function add($attrs){
        global $mypdo;

        $params = array();
        foreach ($attrs as $key=>$value)
        {
            $type = self::getTypeByAttr($key);
            $params[self::$pre.$key] =  array($type,$value);
        }

        $r=$mypdo->sqlinsert($mypdo->prefix.'meeting', $params);

        return $r;

    }


    /**
     * @param $id
     * @param $attrs
     * @return mixed
     */
    static public function update($id,$attrs){
        global $mypdo;

        $params = array();
        foreach ($attrs as $key=>$value)
        {
            $type = self::getTypeByAttr($key);
            $params[self::$pre.$key] =  array($type,$value);

        }
        //where条件
        $where = array(
            "meeting_id" => array('number', $id)
        );
        //返回结果
        $r = $mypdo->sqlupdate($mypdo->prefix.'meeting', $params, $where);
        return $r;
    }

    /**
     * @return array
     */
    static public function getList($params){

        global $mypdo;

        $sql = "select * from ".$mypdo->prefix."meeting";

        $where="";
        if(isset($params["status"]) and $params['status'])
        {
            $where.=" where meeting_status =  '{$params['status']}'" ;
        }

        $where.=" order by meeting_id desc";

        $sql.=$where;

        $limit = "";

        if(isset($params["page"]) and $params['page'])
        {
            $start = ($params["page"]-1)*$params["pageSize"];
            $limit = " limit {$start},{$params["pageSize"]}";
        }
        $sql .= $limit;

        $rs = $mypdo->sqlQuery($sql);
        $r  = array();
        if($rs){
            foreach($rs as $key => $val){
                $r[$key] = self::struct($val);
            }
            return $r;
        }else{
            return $r;
        }
    }
    /**
     * @param $id
     * @return array
     */
    static public function getInfoById($id){
        global $mypdo;

        $sql = "select * from ".$mypdo->prefix."meeting where meeting_id= $id";

        $rs = $mypdo->sqlQuery($sql);
        $r  = array();
        if($rs){
            foreach($rs as $key => $val){
                $r[$key] = self::struct($val);
            }
            return $r[0];
        }else{
            return $r;
        }
    }

    /**
     * @param $adminId
     * @return mixed
     */
    static public function del($id){

        global $mypdo;

        $where = array(
            "meeting_id" => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'meeting', $where);
    }

    static public function getCount($param){
        global $mypdo;

        $sql = "select count(1) as act from ".$mypdo->prefix."meeting";

        $rs = $mypdo->sqlQuery($sql);

        return $rs[0]['act'];

    }


}

?>