<?php
/**
 * 管理员处理  admin_do.php
 *
 * @version       v0.03
 * @create time   2014-9-4
 * @update time   2016/3/25
 * @author        dxl jt
 * @copyright     Copyright (c) 芝麻开发 (http://www.zhimawork.com)
 */
require_once('admin_init.php');


//echo "ok";

$POWERID = '1,2,3,4';//权限

$action = safeCheck($_REQUEST['act'], 0);


switch ($action) {
    case 'upload':

        $allowext     = array('jpg', 'jpeg', 'gif', 'png');
        $fileElement  = 'file';
        $filepath_rel = 'userfiles/upload/' . date('Ymd') . '/';//相对路径
        $filepath_abs =  $FILE_PATH.$filepath_rel;//绝对路径

        //    print_r($filepath_abs);exit;
        if (!file_exists($filepath_abs)) {
            mkdir($filepath_abs,0777,true);
        }
        try {
            $fup = new FileUpload('3M', $allowext);
            $r   = $fup->upload($fileElement, $filepath_abs, '', true);
            $name_rel = $filepath_rel . $r;
            $filepath =  $HTTP_PATH.$name_rel;

            $data=array();
            $data["filepath_abs"]=$filepath;
            $data["filepath_rel"]=$name_rel;

            //上传成功
            echo action_msg($name_rel, 1);


        } catch (Exception $e) {
            echo action_msg($e, 2);
        }

        break;

    case 'add':
        $name = safeCheck($_POST['name'], 0);
        $content = $_POST['content'];
        $people = safeCheck($_POST['people'], 0);
        $time = $_POST['time'];
        $class = safeCheck($_POST['classes'], 0);
        $img = safeCheck($_POST['img'], 0);
        $tel = safeCheck($_POST['tel'], 0);
        $params=array();
        $params['name']=$name;
        $params['tel']=$tel;
        $params['content']=$content;
        $params['people']=$people;
        $params['time']=strtotime($time);
        $params['class']=$class;
        $params['img']=$img;
        $params['addtime']=time();
        $params['status']=1;


        try {
            $rs = meeting::add($params);
            echo action_msg('申请已提交', 1);

        } catch (MyException $e) {
            echo $e->jsonMsg();
        }

        break;

    case 'del':

        $id = safeCheck($_POST['id'], 0);   // 1是检查数字，账号roleid
        try{

            meeting::del($id);
            echo action_msg("删除成功", 1);
        }catch (MyException $e) {
            echo $e->jsonMsg();
        }

        break;
    case 'edit':
        $id = safeCheck($_POST['id'], 0);
        $name = safeCheck($_POST['name'], 0);
        $content = $_POST['content'];
        $people = safeCheck($_POST['people'], 0);
        $time = $_POST['time'];
        $class = safeCheck($_POST['classes'], 0);
        $params=array();
        $params['name']=$name;
        $params['content']=$content;
        $params['people']=$people;
        $params['time']=strtotime($time);
        $params['class']=$class;
        $params['addtime']=time();
        $params['status']=1;
        try {
            $rs = meeting::update($id,$params);
            echo action_msg('成功修改', 1);

        } catch (MyException $e) {
            echo $e->jsonMsg();
        }

        break;

    case 'publish':
        $id = safeCheck($_POST['id'], 0);
        $params=array();
        $params['status']=2;
        try {
            $rs = meeting::update($id,$params);
            echo action_msg('成功发布', 1);

        } catch (MyException $e) {
            echo $e->jsonMsg();
        }

        break;
    case 'no_publish':
        $id = safeCheck($_POST['id'], 0);
        $params=array();
        $params['status']=1;
        try {
            $rs = meeting::update($id,$params);
            echo action_msg('成功取消发布', 1);

        } catch (MyException $e) {
            echo $e->jsonMsg();
        }

        break;

    case 'export':

        $table = array();
        $table[0] = ["序号", "姓名", "性别", "出生年月","所属院系", "专业","班级","入学时间","毕业时间","学历","现工作单位","职称","联系电话","邮箱","微信","QQ","地址","所属校友会"];
        try {

            $list = People::getList();

            $i = 1;
            if (!empty($list)) {
                foreach ($list as $value) {

                    $table[$i]['id'] = " ".$i;
                    $table[$i]['name'] = $value['name'];
                    $table[$i]['sex']="女";
                    if($value['sex']==1){
                        $table[$i]['sex']="男";
                    }
                    $table[$i]['birth'] =date('Y-m-d',$value['birth']);
                    $table[$i]['depart'] =$Depart_type[$value['depart']];
                    $table[$i]['major'] =$value['major'];
                    $table[$i]['class'] =$value['class'];
                    $table[$i]['in_time'] =$value['in_time'];
                    $table[$i]['out_time'] =$value['out_time'];
                    $table[$i]['degree'] =$Degree_type[$value['degree']];
                    $table[$i]['company'] =$value['company'];
                    $table[$i]['job'] =$value['job'];
                    $table[$i]['tel'] =$value['tel'];
                    $table[$i]['email'] =$value['email'];
                    $table[$i]['weixin'] =$value['weixin'];
                    $table[$i]['qq'] =$value['qq'];
                    $table[$i]['address'] =$value['address'];
                    $table[$i]['group'] =$Group_type[$value['group_id']];
                    $i++;

                }
            }
            $filename = date("YmdHis") . ".xlsx";
            to_excle($table);
            echo action_msg("导出成功,$filename", 1);
        } catch (Exception $e) {
            echo action_msg("导出失败,$filename", 2);
        }
        break;

}
function to_excle($table){
    global $FILE_PATH;
    global $filename;
    $arr = array(0 => "A", 1 => "B", 2 => "C", 3 => "D", 4 => "E", 5 => "F", 6 => "G", 7 => "H", 8 => "I", 9 => "J", 10 => "K", 11 => "L", 12 => "M", 13 => "N", 14 => "O", 15 => "P", 16 => "Q", 17 => "R");
    $i = 1;
    $objPHPExcel = new PHPExcel();
    $objActSheet = $objPHPExcel->getActiveSheet();
    $width_array = array('A' => 7.25,'B'=>20, 'C' => 20, 'D' => 20, 'E' => 20, 'F' => 20, 'G' => 20, 'H' => 20, 'I' => 20, 'J' => 20, 'K' => 50, 'L' => 50,'M' => 20, 'N' => 20, 'O' => 20, 'P' => 20, 'Q' => 20, 'R' => 20);//列宽度
    foreach ($width_array as $k => $v) {
        $objActSheet->getColumnDimension($k)->setWidth($v);
    }
    foreach ($table as $ary) {
        $j = 0;
        foreach ($ary as $value) {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($arr[$j] . $i, $value);
            $j++;
        }
        $i++;
    }

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $date = date("Ymd");
    $filepath_rel = 'userfiles/upload/' . $date . '/';//相对路径
    $filepath_abs = $FILE_PATH . $filepath_rel;//绝对路径
    if (!file_exists($filepath_abs)) {
        mkdir($filepath_abs, 0777, true);
    }
    $objWriter->save($filepath_abs . $filename);
}

?>