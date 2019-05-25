<?php
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID = '1,2,3,4';//什么样的权限能访问 如role_level

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
                <input type="text" class="form-control width200" id="account" placeholder="">
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
                        <option value="<?php echo $i?>"><?php echo $item?></option>
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
                <input type="password" class="form-control width200" id="pwd1" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="passwd2" class="control-label">确认密码</label>
            <div class="control-counten">
                <input type="password" class="form-control width200" id="pwd2" placeholder="">
            </div>
        </div>

        <br>
        <dev>

        </dev>
        <br>
        <div class="form-group">
            <div class="control-counten">
                <button id="btn_submit" type="button" class="btn btn-primary">确定</button>
            </div>
        </div>
        <script>
            $(function () {
                $('#btn_submit').click(function () {
                    var account = $('#account').val();
                    var password = $('#pwd1').val();
                    var repassword = $('#pwd2').val();
                    var group = $('#group').val();

                    if (account == '') {
                        layer.tips("账号不能为空！", '#account');
                        return false;
                    }

                    if (password == '') {
                        layer.tips("密码不能为空！", '#pwd1');
                        return false;
                    }

                    if (repassword == '') {
                        layer.tips("请再次输入密码！", '#pwd2');

                        return false;
                    }
                    if (password != repassword) {
                        layer.tips("两次密码输入不一致！", '#pwd2');
                        return false;
                    }

                    $.ajax({
                        type: 'POST',
                        data: {
                            account: account,
                            password: password,
                            group: group

                        },
                        dataType: 'json',
                        url: 'account_manage_do.php?action=add',
                        success: function (data) {

                            var code = data.code;
                            var msg = data.msg;
                            switch (code) {
                                case 1:
                                    layer.alert("添加账号成功！", {icon: 6, shade: false}, function (index) {
                                        parent.location.reload();
                                    });
                                    break;
                                default:
//                            layer.alert(msg, {icon: 5});
                                    layer.alert("添加失败 " + msg, {icon: 2, shade: false});
                            }
                        }
                    });

                    return true; // 在这里加上原来的代码
                });
            });

        </script>


    </div>
</div>
<script type="text/javascript" src="static/js/common.js"></script>

</body>

</html>