<?php
/**敏感电话处理
 * Created by
 * Date: 2018/7
 * Time:
 */
require_once ('admin_init.php');


$act=$_GET['act'];

switch ($act){

    case 'upload':

    $allowext     = array('jpg', 'png', 'gif','jpeg');
    $fileElement  = 'file';
    $filepath_rel = 'userfiles/upload/' . date('Ymd') . '/';//相对路径
    $filepath_abs = $FILE_PATH . $filepath_rel;//绝对路径
    if (!file_exists($filepath_abs)) {
        mkdir($filepath_abs);
    }
    try {
        $fup = new FileUpload('300KB', $allowext);
        $r   = $fup->upload($fileElement, $filepath_abs, '', true);
        $name_rel = $filepath_rel . $r;

        $code = 1;

        echo action_msg($name_rel, $code);
    } catch (Exception $e) {
        echo action_msg($e->getMessage(), $e->getCode());
    }

    break;




    case "add":
        $name = safeCheck($_POST['name'], 0);
        $sex = safeCheck($_POST['sex'], 0);
        $birth = safeCheck($_POST['birth'], 0);
        $pic = safeCheck($_POST['pic'], 0);
        $depart = safeCheck($_POST['depart'], 0);
        $major = safeCheck($_POST['major'], 0);
        $classes = safeCheck($_POST['class'], 0);

        $tel = safeCheck($_POST['tel'], 0);
        $email = safeCheck($_POST['email'], 0);
        $wechat = safeCheck($_POST['wechat'], 0);
        $qq = safeCheck($_POST['qq'], 0);
        $company = safeCheck($_POST['company'], 0);
        $job = safeCheck($_POST['job'], 0);
        $address = safeCheck($_POST['address'], 0);

        $degree = safeCheck($_POST['degree'], 0);
        $in_time = safeCheck($_POST['in_time'], 0);
        $out_time = safeCheck($_POST['out_time'], 0);

        $params=array();
        $params['name']=$name;
        $params['sex']=$sex;
        $params['birth']=strtotime($birth);
        $params['depart']=$depart;
        $params['major']=$major;
        $params['class']=$classes;
        $params['degree']=$degree;
        $params['company']=$company;
        $params['job']=$job;
        $params['tel']=$tel;
        $params['email']=$email;
        $params['weixin']=$wechat;
        $params['qq']=$qq;
        $params['address']=$address;
        $params['img']=$pic;


        $params['in_time']=$in_time;
        $params['out_time']=$out_time;

        try {
            $rs = People::add($params);
            echo action_msg('成功添加', 1);

        } catch (MyException $e) {
            echo $e->jsonMsg();
        }

        break;

    //社会满意度评价
    case 'toHanding'://评价
        $handingId=safeCheck($_POST['handingId'] );
        $handingIp=safeCheck($_POST['handingIp'],0);

        $handing_source=safeCheck($_POST['handing_source']);
        $handingResult=safeCheck($_POST['handingResult']);
//        $handing_type=safeCheck($_POST['handing_type']);
        $oldtime=Handing::getInfoById($handingId)['addtime'];
//            print_r(timediff_day((time()-$oldtime)));
        if(timediff_day((time()-$oldtime))>30){
            echo action_msg("超过该办件的评论时限",202);
            exit;
        }
        $action = null;
        switch ($handingResult){
            case array_keys($Array_satisfaction)[0]:
                $action = 5;
                break;
            case array_keys($Array_satisfaction)[1]:
                $action = 6;
                break;
            case array_keys($Array_satisfaction)[2]:
                $action = 7;
                break;
            default:
                break;
        }
        try {

            //判断该‘用户ip’是否评价过该‘办件’
            $params = array("handing_id"=>$handingId);
            $params["handing_ip"]=$handingIp;
            $params["type"]=2;
            $oldHanding = handing_log::getList($params);
            $handing = handing::getInfoById($handingId);
            if(!empty($oldHanding) && !empty($handingIp)){
                $msg = '您已评价过，不可重复评价！';
                $rs = action_msg($msg, 201);
            }else{
                $cResult = handing::doHanding($handingId,$handingResult,$handingIp);
                $arr = json_decode($cResult,true);
                if($arr['code'] == 1){
                    $rs =handing_log::add($handingId,$handingIp,$handing_source,$handingResult,2);
                }else{
                    $rs = $cResult;
                }
                minxinip::addWeixinRecord($handingIp,$action,$handing['index']);
            }
            echo $rs;
        }catch (MyException $e){
            echo $e->jsonMsg();
        }
        break;


    //个人满意度评价
    case 'toPerComment':
        $submitterIp = safeCheck($_POST['submitterIp'],0 );
        $handingId=safeCheck($_POST['handingId'] );


        $handing = handing::getInfoById($handingId);

        $handingResult=safeCheck($_POST['handingResult']);
        $action = null;
        switch ($handingResult-5){
            case array_keys($Array_per_satisfaction)[2]:
                $action = 2;
                break;
            case array_keys($Array_per_satisfaction)[1]:
                $action = 3;
                break;
            case array_keys($Array_per_satisfaction)[0]:
                $action = 4;
                break;
            default:
                break;
        }

        try{
//            $params = array("per_satisfaction"=>($handingResult-5));
//            $commentResult =   handing::edit($handingId,$params);

            $commentResult = Table_handing::toPerComment($handingId,$handingResult-5);
            minxinip::addWeixinRecord($submitterIp,$action,$handing['index']);

            //$arr = json_decode($commentResult,true);
            //if($arr['code'] == 1){
            if(isset($commentResult)){
                echo action_msg("评价成功！", 1);
            }else{
                echo action_msg("评价失败！", 202);

            }
        }catch (MyException $e){
            echo $e->jsonMsg();
        }
    break;

    //安卓APP首页搜索办件
    case 'checkHanding':
        $indexNum=safeCheck($_POST['indexNum'],0);
        $password=safeCheck($_POST['password'],0);

        $params = array("indexNumber"=>$indexNum);
        $params["minxin"] = 1;
        $params["if_child"] = 1;
        if(empty($password)){
            $params["problemPwd"] = $password;
            $params["if_public"] = 1;
            $params["if_secret"] = 0;
        }else{
            $params["problemPwd"] = $password;
        }


        try{

            //$rs = Handing::getAllList(array("indexNumber"=>$indexNum,"problemPwd"=>$password,"minxin"=>1,"if_public"=>1,"if_secret"=>0,"if_child"=>1));
            $rs = Handing::getAllList($params);

            if(empty($rs))
            {
                throw new MyException("办件不存在",101);

            }
            else
            {

                echo action_msg($rs[0],1);
            }

        }catch (MyException $e){
            echo $e->jsonMsg();
        }
        break;



    //检查办件密码输入正确性
    case 'checkPwd':
        $handingId=safeCheck($_POST['handingId'] );
        $inputPwd=safeCheck($_POST['inputPwd'] );

        try
        {

            $handing = Handing::getInfoById($handingId);
            if(isset($handing['password'])&& isset($inputPwd) && $handing['password'] == $inputPwd){
                $rs = action_msg("密码正确！",1);
            }else{
                $rs = action_msg("密码错误！",0);
            }

            echo $rs;

        }catch (MyException $e)
        {
            echo $e->jsonMsg();
        }
    break;



    case 'search':
        $page=safeCheck($_POST['page']);
        $pageSize=safeCheck($_POST['pageSize']);
        $type=safeCheck($_POST['type']);
        $status=safeCheck($_POST['status']);
        $indexNum=safeCheck($_POST['indexNumber'],0);
        $problemPwd=safeCheck($_POST['problemPwd'],0);

        try
        {
            $params = array();
            $params["min_status"]=$status;
            $params["minxin"]=1;
            $params["problem_category"] = $type;
            $params["search_value"] = $indexNum;
            $params["page"] = $page;
            $params["pageSize"] = $pageSize;

            if(empty($problemPwd)){
                $params['if_public']=1;
                $params["if_secret"]=0;
            }

            $params["problemPwd"] = $problemPwd;
            $rows = Handing::getAllList($params);

            $result = array();
            if(!empty($rows))
            {
                foreach ($rows as $row)
                {
                    $resultItem = array();
                    $resultItem["id"] = $row["id"];
                    $resultItem["index"] = $row["index"];
                    $resultItem["title"] = $row["problem_title"];
                    $resultItem["submitDate"] = date("Y-m-d",$row["submit_time"]);
                    if(!empty($row['resp_department']))
                    {
                        $departmentId = explode(",",$row['resp_department']);
                        $departmentInfo = Department::getInfoById($departmentId[0]);
                        if(!empty($departmentInfo)){
                            $resp_department = $departmentInfo['name'];
                        }else{
                            $resp_department = '暂无';
                        }
                    }
                    else
                    {
                        $resp_department = '暂无';
                    }
                    $resultItem["resp_department"] = $resp_department;
                    $resultItem["status"] = $row["status"];;
                    $result[] = $resultItem;
                }
            }

            echo action_msg($result,1);

        }catch (MyException $e)
        {
            echo $e->jsonMsg();
        }
        break;


}
?>