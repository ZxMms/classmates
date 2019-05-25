<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2019/3/8
 * Time: 9:40
 */
class job {


    public function __construct() {

    }

    /**
     * @param $attrs
     * @return mixed
     * @throws Exception
     * zx
     */
    static public function add($attrs){
        if(empty($attrs)) throw new Exception('参数不能为空', 102);

        $id =  Table_job::add($attrs);

        return $id;
    }

    /**
     * @param $id
     * @param $attrs
     * @return mixed
     * zx
     */
    static public function update($id, $attrs){
        return Table_job::update($id, $attrs);
    }


    /**
     * @return array
     * @author zx
     */
    static public function getList($param=null){
        return Table_job::getList($param);
    }
    /**
     * @return array
     * @author zx
     */
    static public function getInfoById($id){
        return Table_job::getInfoById($id);
    }

    /**
     * @return array
     * @author zx
     */
    static public function del($id){
        return Table_job::del($id);
    }


    static public function getCount($param){
        return Table_job::getCount($param);
    }

}