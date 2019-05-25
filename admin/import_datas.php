<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2019/3/11
 * Time: 12:29
 */

require_once('admin_init.php');
set_time_limit(0);//设置运行时间，防止数据多时运行时间过长而终止，2017/02/11
ini_set('memory_limit', '1024M');//修改php的运行内存限制,因为app层面导出数据出现内存不足的问题，2017/02/11


$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
$cacheSettings = array('memoryCacheSize'=>'500MB');
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

$objPHPExcel = PHPExcel_IOFactory::load("../userfiles/upload/import_data/2019052412052525/201905241238254565.xlsx");

$objWorksheet = $objPHPExcel->getActiveSheet();
$highestRow = $objWorksheet->getHighestRow();
$highestColumn = $objWorksheet->getHighestColumn();
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
$i=1;
$j=1;
$count=0.1;
$begin=3;
try{
    for ($row = $begin; $row <= $highestRow*$count; $row++) {
        $data = array();
        for ($col = 0; $col < $highestColumnIndex; $col++) {

            $data[] = trim((string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue());

        }
        $params=array();
        if (!empty($data)) {
            $j++;

            $params['name']=$data[0];
            $sex=2;
            if($data[1]=="男"){
                $sex=1;
            }
            $params['sex']=$sex;

            if($data[2]){
                $params['birth']=strtotime($data[2]);
            }

            if($data[3]){
                $params['major']=$data[3];
            }
            if($data[4]){
                $params['depart']=  array_search($data[4], $Depart_type);
            }else{
                $params['depart']=0;
            }
            if($data[5]){
                $params['in_time']=$data[5];
            }
            if($data[6]){
                $params['out_time']=$data[6];
            }
            if($data[7]){
                $params['degree']=  array_search($data[7], $Degree_type);
            }else{
                $params['degree']=  0;
            }
            if($data[8]){
                $params['company']=$data[8];
            }
            if($data[9]){
                $params['job']=$data[9];
            }

            if($data[10]){
                $params['tel']=$data[10];
            }
            if($data[11]){
                $params['email']=$data[11];
            }

            if($data[12]){
                $params['weixin']=$data[12];
            }


            if($data[13]){
                $params['qq']=$data[13];
            }
//
            if($data[14]){
                $params['address']=$data[14];
            }

//                   $params['img']=$data[15];
            if($data[15]){
                $params['group_id']=$data[15];
            }

            if($data[16]){
                $params['class']=$data[16];
            }


//                   print_r($params);
            People::add($params);
            $i++;
            print_r($i);

        }
        $count+=0.1;
        $begin=$row;
    }
    echo action_msg("共".($j-1)."条数据，导入成功".($i-1)."条", 1);
}catch (Exception $e){
    echo action_msg($e->getMessage(), $e->getCode());
    return;
}


?>