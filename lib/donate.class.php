<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2019/3/8
 * Time: 9:40
 */
class donate {


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

        $id =  Table_donate::add($attrs);

        return $id;
    }

    /**
     * @param $id
     * @param $attrs
     * @return mixed
     * zx
     */
    static public function update($id, $attrs){
        return Table_donate::update($id, $attrs);
    }


    /**
     * @return array
     * @author zx
     */
    static public function getList($param=null){
        return Table_donate::getList($param);
    }
    /**
     * @return array
     * @author zx
     */
    static public function getInfoById($id){
        return Table_donate::getInfoById($id);
    }

    /**
     * @return array
     * @author zx
     */
    static public function del($id){
        return Table_donate::del($id);
    }


    static public function getCount($param){
        return Table_donate::getCount($param);
    }

}