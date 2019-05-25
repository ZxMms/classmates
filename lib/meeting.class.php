<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2019/3/8
 * Time: 9:40
 */
class meeting {


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

        $id =  Table_meeting::add($attrs);

        return $id;
    }

    /**
     * @param $id
     * @param $attrs
     * @return mixed
     * zx
     */
    static public function update($id, $attrs){
        return Table_meeting::update($id, $attrs);
    }


    /**
     * @return array
     * @author zx
     */
    static public function getList($param=null){
        return Table_meeting::getList($param);
    }
    /**
     * @return array
     * @author zx
     */
    static public function getInfoById($id){
        return Table_meeting::getInfoById($id);
    }

    /**
     * @return array
     * @author zx
     */
    static public function del($id){
        return Table_meeting::del($id);
    }


    static public function getCount($param){
        return Table_meeting::getCount($param);
    }

}