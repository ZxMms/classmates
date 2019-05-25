<?php


class Table_job extends Table
{
    private static  $pre = "job_";
    static protected function struct($data)
    {
        $r = array();

        $r['id'] = $data['job_id'];
        $r['name'] = $data['job_name'];
        $r['content'] = $data['job_content'];
        $r['img'] = $data['job_img'];
        $r['addtime'] = $data['job_addtime'];


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
            "name"=>"string",
            "content"=>"string",
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

        $r=$mypdo->sqlinsert($mypdo->prefix.'job', $params);

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
            "job_id" => array('number', $id)
        );
        //返回结果
        $r = $mypdo->sqlupdate($mypdo->prefix.'job', $params, $where);
        return $r;
    }

    /**
     * @return array
     */
    static public function getList($params){

        global $mypdo;

        $sql = "select * from ".$mypdo->prefix."job";

        $where=" order by job_id desc";

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

        $sql = "select * from ".$mypdo->prefix."job where job_id= $id";

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
            "job_id" => array('number', $id)
        );

        return $mypdo->sqldelete($mypdo->prefix.'job', $where);
    }

    static public function getCount($param){
        global $mypdo;

        $sql = "select count(1) as act from ".$mypdo->prefix."job";

        $rs = $mypdo->sqlQuery($sql);

        return $rs[0]['act'];

    }


}

?>