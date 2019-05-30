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


$POWERID = '1,2,3,4';//权限



?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>弹窗类</title>
    <link rel="stylesheet" href="static/css/common.css"/>
    <link rel="stylesheet" href="static/css/index.css"/>
    <link rel="stylesheet" href="static/css/other.css"/>
    <link rel="stylesheet" href="css/group.css">
    <link rel="stylesheet" href="static/js/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="static/js/layer/skin/default/layer.css"/>
    <script type="text/javascript" src="static/js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="static/js/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="static/js/layer/layer.js"></script>
    <script type="text/javascript" src="js/echarts.min.js"></script>
    <script type="text/javascript" src="js/jquery.md5.js">//$.md5()</script>
    <script type="text/javascript" src="js/func.common.js">//$.md5()</script>
    <script type="text/javascript" src="js/sign.js">//$.md5()</script>
    <script src="js/fingerprint.js"></script>
</head>


<body>
<div id="layerMain">
    <div class="formBox">

        <div class="form-group">
            <label for="passwd2" class="control-label">旧密码</label>
            <div class="control-counten">
                <input type="password" class="form-control width200" id="old_pass" placeholder="">
            </div>
        </div>

        <div class="form-group">
            <label for="passwd2" class="control-label">新密码</label>
            <div class="control-counten">
                <input type="password" class="form-control width200" id="new_pass1" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="passwd3" class="control-label">确认新密码</label>
            <div class="control-counten">
                <input type="password" class="form-control width200" id="new_pass2" placeholder="">
            </div>
        </div>


        <div class="form-group">
            <div class="control-counten">
                <button id="btn_submit" type="button" class="btn btn-primary">确定</button>
            </div>
        </div>


        <script>
            $(document).keydown(function (e) {
                {
                    var e = e || event,
                        keycode = e.which || e.keyCode;
                    if (keycode == 13) {
                        if ($(".layui-layer-btn0").length > 0) {
                            $(".layui-layer-btn0")[$(".layui-layer-btn0").length-1].click();
                            return false;
                        }
                        else {
                            $("#btn_submit").trigger("click");
                            return false;
                        }

                    } else if (keycode == 27) {
                        if ($(".layui-layer-btn0").length > 0) {
                            layer.closeAll();
                            return false;
                        }
                    }
                }
            });

            $(document).ready(function () {
                $('#btn_submit').click(function () {

                    var old_pass = $("#old_pass").val();
                    var password = $('#new_pass1').val();
                    var repassword = $('#new_pass2').val();


                    if (old_pass == '') {
                        layer.tips("旧密码不能为空！", '#old_pass');
                        return false;
                    }
                    if (password == '') {
                        layer.tips("密码不能为空", '#new_pass1');
                        return false;
                    }

                    if (repassword == '') {
                        layer.tips("请再次输入密码", '#new_pass2');
                        return false;
                    }

                    if (password != repassword) {
                        layer.tips("两次密码输入不一致！", '#new_pass2');
                        return false;
                    }

                    var p1 = /[0-9]/i;
                    var p2 = /[a-z]/i;

                    if ((!p1.test(repassword)) || (!p2.test(repassword))) {
                        layer.alert("密码太弱！请换高强度密码,必修大于六位且包含字母和数字！");
                        return false;
                    }

                    var myarray = ['000000', '0000000',
                        '111111', '666666', '888888', '999999', '88888888', '11111111',
                        'aaaaaa',
                        '123456789', '1234567890', '0123456789', '12345678',
                        '123456', '654321', 'abcdef',
                        'abc123', '123123', '321321', '112233', 'abcabc',
                        'aaa111', 'a1b2c3',
                        'qwerty', 'qweasd',
                        'password', 'p@ssword', 'passwd', 'passw0rd',
                        'iloveyou', '5201314',
                        'admin1234', 'admin888', 'admin123'];

                    for (var i = 0; i < myarray.length; i++) {
                        if (repassword == myarray[i] || repassword.length < 6) {
                            layer.alert("密码太弱！请换高强度密码");
                            return false;
                        }
                    }


                    $.ajax({
                        type: 'POST',
                        data: {
                            account: <?php echo $_SESSION[$session_ADMINID]?>,
                            old_pass: old_pass,
                            password: password

                        },
                        dataType: 'json',
                        url: 'change_password_do.php?action=edit_pass',
                        success: function (data) {
                            var code = data.code;
                            var msg = data.msg;
                            switch (code) {
                                case 1:
                                    layer.alert("修改密码成功！", {icon: 6, shade: false}, function (index) {
                                        parent.layer.closeAll();
                                    });

                                    break;
                                default:
                                    layer.alert("修改密码失败 " + msg, {icon: 2, shade: false});
                            }
                        }
                    });
                });

            });


        </script>


    </div>
</div>
<script type="text/javascript" src="../static/js/common.js"></script>

</body>


</html>