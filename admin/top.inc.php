<script type="text/javascript" src="static/js/bootstrap/js/bootstrap.js"></script>
<div class="mainHeader">
    <div class="mainHeader_title">欢迎进入友家校友信息管理系统！</div>
    <div class="btn-group mainHeader_user">
        <button type="button" class="btn btn-default dropdown-toggle noimage" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <?php $myName = Admin::getInfoById($_SESSION[$session_ADMINID]);
            echo $myName['account'];
            ?><span class="caret"></span>
        </button>
        <ul class="dropdown-menu no-imageposition">
            <li><a href="login.php">退出登录</a></li>

            <li><a onclick="openModelWindow('修改密码','change_pass.php', '450px', '300px');">修改密码</a></li>

        </ul>
    </div>



</div>