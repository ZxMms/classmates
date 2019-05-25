<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2019/3/11
 * Time: 12:29
 */

require_once('admin_init.php');
require_once('admincheck.php');
set_time_limit(0);//设置运行时间，防止数据多时运行时间过长而终止，2017/02/11
ini_set('memory_limit', '1024M');//修改php的运行内存限制,因为app层面导出数据出现内存不足的问题，2017/02/11



//上传附件
$level=$_POST['level'];
try {
    $fileElement = "file";
    $allowext = array( 'xls', 'xlsx',);

    $date = date("Ymdhmss");
    $filepath_rel = 'userfiles/upload/import_data/' . $date . '/';//相对路径
    $filepath_abs = $FILE_PATH . $filepath_rel;//绝对路径

    if (!file_exists($filepath_abs)) {
        mkdir($filepath_abs, 0777, true);
    }

    $fup = new FileUpload('50M', $allowext);

    $res = $fup->upload($fileElement, $filepath_abs, '', true);
    $full_url = $filepath_abs. $res;

    $annex_url =stripslashes($filepath_rel . $res);
}catch (Exception $e){
    echo action_msg($e->getMessage(), $e->getCode());
    exit();
}
switch($level){
    case 1:
        $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize'=>'50MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);



        $objPHPExcel = PHPExcel_IOFactory::load($full_url);

        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $i=1;
        $j=1;
        $count=0.1;
        $begin=3;

       try{
           for ($row = $begin; $row <= $highestRow; $row++) {
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
                       $params['class']=$data[4];
                   }

                   if($data[5]){
                       $params['depart']=  array_search($data[5], $Depart_type);
                       if($params['depart']==false){
                           $params['depart']=0;
                       }
                   }else{
                       $params['depart']=0;
                   }

                   if($data[6]){
                       $params['in_time']=$data[6];
                   }
                   if($data[7]){
                       $params['out_time']=$data[7];
                   }
                   if($data[8]){
                       $params['degree']=  array_search($data[8], $Degree_type);
                       if($params['degree']==false){
                           $params['degree']=0;
                       }
                   }else{
                       $params['degree']=  0;
                   }
                   if($data[9]){
                       $params['company']=$data[9];
                   }
                   if($data[10]){
                       $params['job']=$data[10];
                   }

                   if($data[11]){
                       $params['tel']=$data[11];
                   }
                   if($data[12]){
                       $params['email']=$data[12];
                   }

                   if($data[13]){
                       $params['weixin']=$data[13];
                   }


                   if($data[14]){
                       $params['qq']=$data[14];
                   }
//
                   if($data[15]){
                       $params['address']=$data[15];
                   }

//                   $params['img']=$data[15];
                   if($data[16]){
                       $params['group_id']=$data[17];
                   }




//                   print_r($params);
                   People::add($params);
                   $i++;

               }

           }
           echo action_msg("共".($j-1)."条数据，导入成功".($i-1)."条", 1);
       }catch (Exception $e){
           echo action_msg($e->getMessage(), $e->getCode());
           return;
       }

        break;

}

?>