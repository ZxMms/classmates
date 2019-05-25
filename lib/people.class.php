<?php


class People{


	public function __construct() {

	}

    static public function add($attrs){
       $rs=Table_people::add($attrs);
        if($rs > 0){
            $msg = '成功添加';
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    static public function edit($id,$attrs){
        $rs=Table_people::edit($id,$attrs);
        if($rs > 0){
            $msg = '成功修改';
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }
    }
    static public function dels($id){
        $rs=Table_people::dels($id);
        if($rs > 0){
            $msg = '成功删除';
            return action_msg($msg, 1);
        }else{
            throw new MyException('操作失败', 106);
        }

    }
    static public function getInfoById($id){

      return Table_people::getInfoById($id);
    }

    static public function getList($params=array()){
        return Table_people::getList($params);
    }

    static public function getCount($params=array()){
        return Table_people:: getCount($params);
    }

    static public function getGradeList(){
        return Table_people:: getGradeList();
    }

    /**
     * @return array
     */
    static public function getnumberList($params){
        return Table_people:: getnumberList($params);
    }

    static public function getCountByTel(){
        return Table_people:: getCountByTel();
    }
    static public function getCountByType($type){
        return Table_people:: getCountByType($type);
    }

}

?>