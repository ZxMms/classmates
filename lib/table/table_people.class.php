<?php

/**
 * table_admin.class.php 数据库表:管理员
 *
 * @version       $Id$ v0.01
 * @createtime    2014/9/3
 * @updatetime    2016/2/27
 * @author        dxl
 * @copyright     Copyright (c) 芝麻开发 (http://www.zhimawork.com)
 */

class Table_people extends Table {
    const PRE='people_';
	static protected function struct($data){
	   	$r = array();

		$r['id']         = $data['people_id'];
		$r['name']       = $data['people_name'];//学号
		$r['sex']    = $data['people_sex'];//姓名
        $r['birth']         = $data['people_birth'];
        $r['major']       = $data['people_major'];//学号
        $r['class']    = $data['people_class'];//姓名
        $r['depart']         = $data['people_depart'];
        $r['in_time']       = $data['people_in_time'];//学号
        $r['out_time']    = $data['people_out_time'];//姓名
        $r['degree']         = $data['people_degree'];
        $r['company']       = $data['people_company'];//学号
        $r['job']    = $data['people_job'];//姓名
        $r['tel']         = $data['people_tel'];
        $r['email']       = $data['people_email'];//学号
        $r['weixin']    = $data['people_weixin'];//姓名
        $r['qq']         = $data['people_qq'];
        $r['address']       = $data['people_address'];//学号
        $r['img']    = $data['people_img'];//姓名
        $r['group_id']         = $data['people_group_id'];
        $r['status']         = $data['people_status'];
        return $r;
	}



    static public function getTypeByAttr($attrs){
        $typeAtt=array(
            "id"=>"number",
            "name"=>"string",
            "sex"=>"number",
            "birth"=>"number",
            "major"=>"string",
            "class"=>"string",
            "depart"=>"number",
            "in_time"=>"string",
            "out_time"=>"string",
            "degree"=>"number",
            "company"=>"string",
            "job"=>"string",
            "tel"=>"string",
            "email"=>"string",
            "weixin"=>"string",
            "qq"=>"string",
            "address"=>"string",
            "img"=>"string",
            "group_id"=>"number",
            "status"=>"number",
        );

        return isset($typeAtt[$attrs])?$typeAtt[$attrs]:$typeAtt;
    }

    /**
     * 增加宿舍信息
     */
    static public function add($attrs){
        global $mypdo;
        $params = array();
        foreach ($attrs as $key=>$value)
        {
            $type = self::getTypeByAttr($key);
            $params[self::PRE.$key] =  array($type,$value);
        }
        return $mypdo->sqlinsert($mypdo->prefix.'people',$params);
    }

    /**
     * @param $id
     * @param $attrs
     * @return mixed
     */
    static public function edit($id,$attrs){
        global $mypdo;

        $params = array();
        foreach ($attrs as $key=>$value)
        {
            $type = self::getTypeByAttr($key);
            $params[self::PRE.$key] =  array($type,$value);
        }

        $where=array(
            'people_id'          =>array('number',$id)
        );
        return $mypdo->sqlupdate($mypdo->prefix.'people',$params,$where);
    }

    /**
     * @param $id
     * @return mixed
     */
    static public function dels($id){
        global $mypdo;

        $params = array(
            'people_status' => array('number', -1),

        );
        $where=array(
            'people_id'          =>array('number',$id)
        );
        return $mypdo->sqlupdate($mypdo->prefix.'people',$params,$where);

    }

    /**
     * @param $id
     * @return array
     */
    static public function getInfoById($id){

        global $mypdo;
        $sql="select * from ".$mypdo->prefix."people where people_id= ".$id;
        $sql.=" and people_status=1 ";
        $rs=$mypdo->sqlQuery($sql);
        $r=array();
        if($rs){
            foreach ($rs as $key => $val){
                $r[$key]=self::struct($val);
            }

            return $r[0];
        }else{
            return $r;
        }
    }

    /**
     * @param $params
     * @param $pages
     * @return array
     */
    static public function getList($params){
        global $mypdo;
        $sql="select * from ".$mypdo->prefix."people";

        $where=" where people_status=1 ";

        if(isset($params['depart']) and $params['depart']){
            $where.=" and people_depart ={$params['depart']}";
        }
        if(isset($params['group']) and $params['group']){
            $where.=" and people_group_id={$params['group']}";

        }
        if(isset($params['keyword']) and $params['keyword']){
            $where.=" and people_name like '%{$params["keyword"]}%' ";

        }


        if(isset($params['major']) and $params['major']){
            $where.=" and people_major  like '%{$params["major"]}%'  ";

        }
        if(isset($params['in_time']) and $params['in_time']){
            $where.=" and people_in_time='{$params['in_time']}'";

        }
        if(isset($params['out_time']) and $params['out_time']){
            $where.=" and people_out_time='{$params['out_time']}'";

        }
        if(isset($params['classes']) and $params['classes']){

            $where.=" and people_class  like '%{$params["classes"]}%'  ";

        }
        if(isset($params['company']) and $params['company']){

            $where.=" and people_company  like '%{$params["company"]}%'  ";

        }
        if(isset($params['contact']) and $params['contact']){
            if($params['contact']==1){
                $where.=" and people_company  is not null  ";
            }else  if($params['company']==2){
                $where.=" and people_tel  is not null  ";
            }else  if($params['company']==3){
                $where.=" and people_address  is not null  ";
            }else  if($params['company']==4){
                $where.=" and people_email  is not null  ";
            }else  if($params['company']==5){
                $where.=" and people_qq  is not null  ";
            }else  if($params['company']==6){
                $where.=" and people_weixin  is not null  ";
            }


        }


        $where.=" order by people_id desc";
        $sql.=$where;
        $limit = "";
        if(isset($params["page"]) and $params['page'])
        {
            $start = ($params["page"]-1)*$params["pageSize"];
            $limit = " limit {$start},{$params["pageSize"]}";
        }
        $sql .= $limit;


        $rs=$mypdo->sqlQuery($sql);
        $r=array();
        if($rs){
            foreach ($rs as $key => $val){
                $r[$key]=self::struct($val);
            }

            return $r;
        }else{
            return $r;
        }

    }

    /**
     * @return nullif(isset($_GET['town'])){
    $params['$params']=$_GET['town'];
    }
    //$keyword="";
    if(isset($_GET['floor'])){
    $params['floor']=$_GET['floor'];
     */
    static public function getCount($params){
        global $mypdo;
        $sql="select count(1) from ".$mypdo->prefix."people";

        $where=" where people_status=1 ";

        if(isset($params['keyword']) and $params['keyword']){
            $where.=" and people_name like '%{$params["keyword"]}%' ";

        }
        if(isset($params['depart']) and $params['depart']){
            $where.=" and people_depart={$params['depart']}";
        }
        if(isset($params['group']) and $params['group']){
            $where.=" and people_group_id={$params['group']}";

        }


        if(isset($params['major']) and $params['major']){
            $where.=" and people_major  like '%{$params["major"]}%'  ";

        }
        if(isset($params['in_time']) and $params['in_time']){
            $where.=" and people_in_time='{$params['in_time']}'";

        }
        if(isset($params['out_time']) and $params['out_time']){
            $where.=" and people_out_time='{$params['out_time']}'";

        }
        if(isset($params['classes']) and $params['classes']){

            $where.=" and people_class  like '%{$params["classes"]}%'  ";

        }
        if(isset($params['company']) and $params['company']){

            $where.=" and people_company  like '%{$params["company"]}%'  ";

        }
        if(isset($params['contact']) and $params['contact']){
            if($params['contact']==1){
                $where.=" and people_company  is not null  ";
            }else  if($params['company']==2){
                $where.=" and people_tel  is not null  ";
            }else  if($params['company']==3){
                $where.=" and people_address  is not null  ";
            }else  if($params['company']==4){
                $where.=" and people_email  is not null  ";
            }else  if($params['company']==5){
                $where.=" and people_qq  is not null  ";
            }else  if($params['company']==6){
                $where.=" and people_weixin  is not null  ";
            }


        }

        $sql.=$where;
        $rs=$mypdo->sqlQuery($sql);
        if($rs){

            return $rs[0][0];
        }else{
            return null;
        }
    }

    /**
     * @return array
     */
    static public function getGradeList(){
        global $mypdo;
        $sql="SELECT distinct(people_out_time) FROM ".$mypdo->prefix."people";
        $where=" where people_status=1 order by people_out_time";
        $sql.=$where;
        $rs=$mypdo->sqlQuery($sql);
        return $rs;
    }

    /**
     * @return array
     */
    static public function getnumberList($params){
        global $mypdo;
        $sql="SELECT COUNT( people_id ) as act FROM ".$mypdo->prefix."people";
        $where=" where people_status=1 ";
        if(isset($params['grade']) and $params['grade']){
            $where.=" and people_out_time ={$params['grade']}";
        }
        $sql.=$where;

        $rs=$mypdo->sqlQuery($sql);

        return $rs[0][0];
    }

    /**
     * @return array
     */
    static public function getCountByTel(){
        global $mypdo;
        $sql="SELECT COUNT( people_id ) as act FROM ".$mypdo->prefix."people";


        $where=" where people_status=1 and ( people_tel is  null or people_email is  null or people_weixin is  null or people_qq is  null  or people_company is  null)";

        $sql.=$where;


        $rs=$mypdo->sqlQuery($sql);

        return $rs[0][0];
    }

    /**
     * @param $type
     * @return mixed
     */
    static public function getCountByType($type){
        global $mypdo;
        $sql="SELECT COUNT( people_id ) as act FROM ".$mypdo->prefix."people";

        $where=" where people_status=1 ";

        if($type==1){
            $where.="  and  people_tel is not null";
        }else if($type==2){
            $where.="  and  people_qq is not null";
        }else if($type==3){
            $where.=" and  people_weixin is not null";
        }
        $sql.=$where;

        $rs=$mypdo->sqlQuery($sql);

        return $rs[0][0];
    }


}
?>