<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>后台管理系统-登录界面</title>
    <link rel="stylesheet" href="static/css/common.css"/>
    <link rel="stylesheet" href="static/css/login.css"/>
    <link rel="stylesheet" href="static/js/layer/skin/default/layer.css"/>
    <script type="text/javascript" src="static/js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="static/js/common.js"></script>
    <script type="text/javascript" src="static/js/layer/layer.js"></script>
    <script type="text/javascript" src="static/js/jquery.nicescroll.min.js" ></script>
</head>
<body>
<div id="wrapper">
    <div class="loginBj"></div>
    <div class="loginBox">
        <div class="loginHeader">友家校友信息管理系统</div>
        <div class="loginSub">Public service platform</div>
        <div class="loginForm">
            <div class="loginForm_tit">welcome</div>
            <div class="login_line">
                <input type="text" name="account" id="account" value="" placeholder="用户名"/>
            </div>
            <div class="login_line">
                <input  type="password" name="pwd" id="pwd" value="" placeholder="密码"/>
            </div>
            <div class="login_line text-center">
                <button id="btn_login" type="button">登 录</button>
            </div>
            <script type="text/javascript">
                $(function () {
                    $(document).keydown(function (e) {

                        var e = e || event,
                            keycode = e.which || e.keyCode;

                        if (keycode == 13) {
                            $("#btn_login").trigger("click");
                        }
                    });


                    /**点击登录**/
                    $('#btn_login').click(function () {
                        var ac = $('input[name="account"]').val();
                        var pwd = $('input[name="pwd"]').val();

                        var remember = 0;


                        if (ac == '') {
                            $('input[name="account"]').focus();
                            return false;
                        }
                        if (pwd == '') {
                            $('input[name="pwd"]').focus();
                            return false;
                        }

                        $.ajax({
                            type: 'POST',
                            data: {
                                account: ac,
                                pass: pwd
                            },
                            dataType : 'json',
                            url :         'adminlogin_do.php',
                            success :     function(data){
//                                alert(data);
                                code = data.code;
                                msg  = data.msg;
                                switch(code){
                                    case 1:
                                        location.href = 'index.php';
                                        break;
                                    default:
                                        layer.alert(msg, {icon: 5});
                                }
                            }
                        });
                        });
                    });
            </script>

        </div>
    </div>
</div>
</body>
</html>
