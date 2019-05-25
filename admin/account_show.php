<?php
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID = '1,2,3,4';//什么样的权限能访问 如role_level
$id=$_GET['id'];
$info=Admin::getInfoById($id);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>弹窗类</title>
    <link rel="stylesheet" href="static/css/common.css"/>
    <link rel="stylesheet" href="static/css/index.css"/>
    <link rel="stylesheet" href="static/js/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="static/js/layer/skin/default/layer.css"/>
    <script type="text/javascript" src="static/js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="static/js/jquery.nicescroll.min.js"></script>

    <script type="text/javascript" src="static/js/layer/layer.js"></script>
</head>

<body>
<div id="layerMain">
    <div class="formBox">
        <div class="form-group">
            <label for="username" class="control-label">用户名称</label>
            <div class="control-counten">
                <input type="text" class="form-control width200" id="account" value="<?php echo $info['account']?>">
            </div>
        </div>

        <div class="form-group">
            <label for="selectbody" class="control-label">所属角色</label>
            <div class="control-counten">
                <select id="group"  class="form-control width200">
                    <?php
                    $i=1;
                    foreach($ARRAY_admin_type as $item){
                        ?>
                        <option value="<?php echo $i?>" <?php  if($info['group']==$i) echo "selected";?>><?php echo $item?></option>
                        <?php
                        $i++;
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="passwd1" class="control-label">密码</label>
            <div class="control-counten">
                <input type="password" class="form-control width200" id="pwd1" value="******">
            </div>
        </div>

        <br>
        <dev>

        </dev>
        <br>



    </div>
</div>
<script type="text/javascript" src="static/js/common.js"></script>

</body>

</html>