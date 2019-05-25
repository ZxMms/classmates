<?php
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID = '1,2,3,4';//什么样的权限能访问 如role_level


$FLAG_FIRST_LEFTNAV = 'accout';

$FLAG_SECOND_LEFTNAV = 'account_manage';
$group=0;
if(isset($_GET['group'])){
    $group=$_GET['group'];
}
$keyword="";
if(isset($_GET['keyword'])){
    $keyword=$_GET['keyword'];
}
$shownum  = 2;


$total_count=admin::getCount($group,$keyword);

$pagecount = ceil($total_count / $shownum);

$page      = getPage($pagecount);
$pages=array();
$pages["page"]=1;
$pages["pageSize"]=$shownum;
if(isset($_GET['page'])){
    $pages["page"]=$page;
}


$admin_list=admin::getList($group,$keyword,$pages);

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>账号管理</title>
    <link rel="stylesheet" href="static/css/common.css"/>
    <link rel="stylesheet" href="static/css/index.css"/>
    <link rel="stylesheet" href="static/css/other.css"/>
    <link rel="stylesheet" href="static/js/bootstrap/css/bootstrap.css"/>
    <link rel="stylesheet" href="static/js/layer/skin/default/layer.css"/>
    <script type="text/javascript" src="static/js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="static/js/jquery.nicescroll.min.js"></script>
    <script type="text/javascript" src="static/js/layer/layer.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#add').click(function () {
                    layer.open({
                        type: 2,
                        title: '新增用户',
                        shadeClose: true,
                        shade: 0.3,
                        area: ['600px', '300px'],
                        content: 'account_add.php'
                    });
                });
            $('#search').click(function () {
                var group=$("#group").val();
                var keyword=$("#keyword").val();
                var url = location.href.substr(0,location.href.indexOf('.php')+4);

                url+='?page=1&group='+group;
                if(keyword != null){
                    url+='&keyword='+keyword;
                }

                location.href=url;
                });
            });
        function view_account(id) {
            layer.open({
                type: 2,
                title: '查看用户',
                shadeClose: true,
                shade: 0.3,
                area: ['600px', '300px'],
                content: 'account_show.php?id='+id
            });
        }
        function edit_account(id) {
            layer.open({
                type: 2,
                title: '修改用户',
                shadeClose: true,
                shade: 0.3,
                area: ['600px', '340px'],
                content: 'account_edit.php?id='+id
            });
        }
        function del_account(accountid) {

                layer.confirm('确定删除吗？', {
                    btn: ['确认','取消']
                }, function(){
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: accountid
                        },
                        dataType: 'json',
                        url: 'account_manage_do.php?action=del',
                        success: function (data) {
                            var code = data.code;
                            var resData = data.msg;
                            if (code == 1) {
                                layer.alert("删除账号成功", {icon: 6, shade: false}, function (index) {
                                    window.location.reload();
                                });
                            }
                        }
                    });
                })
                return true; // 在这里加上原来的代码

        }


    </script>
</head>

<body>
<div id="wrapper">
    <div class="mainLeft">
        <div class="mainLogo">
            <a href=""><img src="static/img/common/logo.png"/></a>
        </div>
        <div class="admin_nav">
            <div class="navLeftTab">
                <?php include_once("nav.inc.php"); ?>
            </div>
        </div>
    </div>
    <?php include_once "top.inc.php"?>

    <div class="mainBox">
        <!----主页面--->
        <div class="mainPage">
            <!----当前位置--->
            <div class="page_header">
                <a href="">当前位置</a><span>：</span>
                <a href="">账号管理</a>
            </div>
            <!----当前位置--->
            <!----内容区域--->
            <div class="page_body">
                <div class="pageSearch">
                    <div class="form-inline">
                            <button  type="button" id="add" class="btn btn-primary">添加 </button>
                            <label for="selectbody" class="set_margin20">所属角色：</label>
                            <select id="group"  class="form-control width200">
                                <option value="0" <?php if($group==0) echo "selected";?> >全部</option>
                                <?php
                                $i=1;
                                foreach($ARRAY_admin_type as $item){
                                    ?>
                                    <option value="<?php echo $i?>" <?php if($group==$i) echo "selected";?>><?php echo $item?></option>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </select>
                        &nbsp;&nbsp;
                            <label for="selectbody" class="set_margin20">用户名称：</label>
                            <input type="text" class="form-control width150" name="keyword" id="keyword" value="<?php echo $keyword;?>">
                            <button type="button" id="search" class="btn btn-primary" style="float:right">查询</button>
                        </div>
                    </div>
                <table class="table table-bordered form_table set_margin">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>登陆账号</th>
                        <th>角色层级</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody id="tbody">
                    <?php
                    if(is_array($admin_list)) {
                        $i = ($page-1)*$shownum+1;
                        foreach ($admin_list as $item) {
//                                if ($_SESSION['role_level'] < $item['role_level']) {
                            echo '<tr>
                                    <input type="hidden" id="id" value="' . $item['id'] . '">
									<td>' . $i . '</td>
									<td>' . $item['account'] . '</td>
									<td>' . $item['group'] . '</td>
						
									<td>
										<a onclick="view_account(' . $item['id'] . ')" class="table_link" href="#">查看</a>
										<a onclick="edit_account(' . $item['id'] . ')" class="table_link" href="#">修改</a>			
										<a onclick="del_account(' . $item['id'] . ')" class="table_dange" href="#">删除</a>
										
								</tr>';
                            $i++;

                        }
                    }
                    ?>
                    </tbody>
                </table>
                <?php
                if($pagecount>=1)
                {

                    echo dspPages(getPageUrl(), $page, $shownum, $total_count, $pagecount);

                }

                ?>




            </div>
            <!----内容区域--->
        </div>
        <!----主页面--->
    </div>

</div>
<script type="text/javascript" src="static/js/common.js"></script>
</body>

</html>