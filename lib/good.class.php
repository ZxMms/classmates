<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2019/3/8
 * Time: 9:40
 */
class good {


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

        $id =  Table_good::add($attrs);

        return $id;
    }

    /**
     * @param $id
     * @param $attrs
     * @return mixed
     * zx
     */
    static public function update($id, $attrs){
        return Table_good::update($id, $attrs);
    }


    /**
     * @return array
     * @author zx
     */
    static public function getList($param=null){
        return Table_good::getList($param);
    }
    /**
     * @return array
     * @author zx
     */
    static public function getInfoById($id){
        return Table_good::getInfoById($id);
    }

    /**
     * @return array
     * @author zx
     */
    static public function del($id){
        return Table_good::del($id);
    }


    static public function getCount($param){
        return Table_good::getCount($param);
    }

}