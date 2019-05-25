<?php
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID = '1,2,3,4';//什么样的权限能访问 如role_level


$FLAG_FIRST_LEFTNAV = 'classmates';

$FLAG_SECOND_LEFTNAV = 'classmates_list';
$param=array();

$shownum  = 14;
if(isset($_GET['depart'])){
    $param["depart"]=$_GET['depart'];
}
if(isset($_GET['group'])){
    $param["group"]=$_GET['group'];
}

if(isset($_GET['keyword'])){
    $param["keyword"]=$_GET['keyword'];
}


if(isset($_GET['contact'])){
    $param["contact"]=$_GET['contact'];
}
if(isset($_GET['major'])){
    $param["major"]=$_GET['major'];
}
$param["out_time"]=0;
$param["in_time"]=0;
if(isset($_GET['in_time'])){
    $param["in_time"]=$_GET['in_time'];
}
if(isset($_GET['out_time'])){
    $param["out_time"]=$_GET['out_time'];
}
if(isset($_GET['classes'])){
    $param["classes"]=$_GET['classes'];
}

if(isset($_GET['company'])){
    $param["company"]=$_GET['company'];
}
$total_count=People::getCount($param);

$pagecount = ceil($total_count / $shownum);

$page      = getPage($pagecount);

$param["page"]=$page;
$param["pageSize"]=$shownum;


$stu_list=People::getList($param);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>校友信息</title>
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
                  location.href="classmates_add.php";
                });
            $('#search').click(function () {
                var group=$("#group").val();
                var depart=$("#depart").val();
                var keyword=$("#keyword").val();
                var url = location.href.substr(0,location.href.indexOf('.php')+4);

                var major=$("#major").val();
                var in_time=$("#in_time").val();
                var out_time=$("#out_time").val();
                var classes=$("#classes").val();
                var company=$("#company").val();
                var contact=$("#contact").val();

                url+='?page=1&group='+group;
                if(depart != null){
                    url+='&depart='+depart;
                }
                if(keyword != null){
                    url+='&keyword='+keyword;
                }
                if(major != null){
                    url+='&major='+major;
                }
                if(in_time != null){
                    url+='&in_time='+in_time;
                }
                if(out_time != null){
                    url+='&out_time='+out_time;
                }
                if(classes != null){
                    url+='&classes='+classes;
                }
                if(company != null){
                    url+='&company='+company;
                }
                if(contact != null){
                    url+='&contact='+contact;
                }

                location.href=url;
                });
            $('#export').click(function(){
                layer.confirm('确认导出信息？', {
                        btn: ['确认','取消']
                    }, function(){
                        var index = layer.load(0, {shade: false});
                        $.ajax({
                            type        : 'POST',
                            data        : {
                            },
                            dataType : 'json',
                            url : 'classmates_do.php?action=export',
                            success : function(data){
                                layer.close(index);

                                var code = data.code;
                                var msg  = data.msg;
                                str=msg.split(",");
                                msg=str[0];
                                switch(code){
                                    case 1:
                                        layer.alert(msg, {icon: 6,shade: false}, function(index){
                                            location.href = '<?php echo $HTTP_PATH;?>userfiles/upload/<?php echo date("Ymd");?>/'+str[1];
                                            layer.close(index);
                                        });
                                        break;
                                    default:
                                        layer.alert(msg, {icon: 5});
                                }
                            }
                        });
                    }, function(){}
                );
            });
            $('#del_data').click(function () {

                var id_array=new Array();
                $('input[name="exam"]:checked').each(function(){
                    id_array.push($(this).val());//向数组中添加元素

                });
                var item=id_array.join('#');//将数组元素连接起来以构建一个字符串

                layer.confirm('确定删除吗？', {
                    btn: ['确认','取消']
                }, function(){
                    $.ajax({
                        type: 'POST',
                        data: {
                            item: item
                        },
                        dataType: 'json',
                        url: 'classmates_do.php?action=dels',
                        success: function (data) {
                            var code = data.code;
                            var resData = data.msg;
                            if (code == 1) {
                                layer.alert("删除成功", {icon: 6, shade: false}, function (index) {
                                    window.location.reload();
                                });
                            }
                        }
                    });
                })
                return true; // 在这里加上原来的代码
            });
            $('#add_data').click(function () {
                    layer.open({
                        type: 2,
                        title: '导入文件',
                        shadeClose: true,
                        shade: 0.3,
                        area: ['600px', '500px'],
                        content: 'import_data.php'
                    });
                });
            $("#total").click(function(){
                var total = $(this).prop("checked");
                var ck = $(".item").prop("checked",total);
            });
            });


        function view_account(id) {
            location.href="classmates_view.php?id="+id;
        }
        function edit_account(id) {
            location.href="classmates_edit.php?id="+id;
        }

        function del_account(id) {

            console.log(id);
                layer.confirm('确定删除吗？', {
                    btn: ['确认','取消']
                }, function(){
                    $.ajax({
                        type: 'POST',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        url: 'classmates_do.php?action=del',
                        success: function (data) {
                            var code = data.code;
                            var resData = data.msg;
                            if (code == 1) {
                                layer.alert("删除成功", {icon: 6, shade: false}, function (index) {
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
                <a href="">校友信息</a>
            </div>
            <!----当前位置--->
            <!----内容区域--->
            <div class="page_body">
                <div class="pageSearch">
                    <div class="form-inline">

                        <label for="selectbody" class="set_margin20">姓名：</label>
                        <input type="text" class="form-control width150" name="keyword" id="keyword" value="<?php echo $param["keyword"];?>">
                        <label for="selectbody" class="set_margin20">专业：</label>
                        <input type="text" class="form-control width150" name="major" id="major" value="<?php echo $param["major"];?>">
                        <label for="selectbody" class="set_margin20">入学时间：</label>
                        <select name="in_time" id="in_time" class="form-control width150">
                            <option value="0"  <?php if($param["in_time"]==0) echo "selected"?> >其他</option>
                            <?php foreach ($time_type as $key => $item){
                                ?>
                                <option value="<?php echo $item; ?>" <?php if($param["in_time"]==$item) echo "selected"?>><?php echo $item?></option>
                            <?php }?>
                        </select>
                        <label for="selectbody" class="set_margin20">毕业时间：</label>
                        <select name="out_time" id="in_time" class="form-control width150">
                            <option value="0"  <?php if($param["out_time"]==0) echo "selected"?> >其他</option>
                            <?php foreach ($time_type as $key => $item){
                                ?>
                                <option value="<?php echo $item; ?>" <?php if($param["out_time"]==$item) echo "selected"?>><?php echo $item?></option>
                            <?php }?>
                        </select>
                        <label for="selectbody" class="set_margin20">工作单位：</label>
                        <input type="text" class="form-control width150" name="company" id="company" value="<?php echo $param["company"];?>">
                        <label for="selectbody" class="set_margin20">班级：</label>
                        <input type="text" class="form-control width150" name="classes" id="classes" value="<?php echo $param["classes"];?>">
                        <br><br>
                        <label for="selectbody" class="set_margin20">校友会：</label>
                        <select id="group"  class="form-control width200">
                            <?php
                            $i=0;
                            foreach($Group_type as $item){
                                ?>
                                <option value="<?php echo $i?>" <?php if( $param["group"]==$i) echo "selected";?>><?php echo $item?></option>
                                <?php
                                $i++;
                            }
                            ?>
                        </select>
                        <label for="selectbody" class="set_margin20">学院：</label>
                        <select id="depart"  class="form-control width200">
                            <?php
                            $i=0;
                            foreach($Depart_type as $item){
                                ?>
                                <option value="<?php echo $i?>" <?php if( $param["depart"]==$i) echo "selected";?>><?php echo $item?></option>
                                <?php
                                $i++;
                            }
                            ?>
                        </select>
                        <label for="selectbody" class="set_margin20">可联系校友：</label>
                        <select id="contact"  class="form-control width200">
                            <?php
                            $i=0;
                            foreach($Contact_type as $item){
                                ?>
                                <option value="<?php echo $i?>" <?php if($param["contact"]==$i) echo "selected";?>><?php echo $item?></option>
                                <?php
                                $i++;
                            }
                            ?>
                        </select>
                            <button  type="button" id="add" class="btn btn-primary" style="float:right">添加 </button>
                            <button type="button" id="search" class="btn btn-primary" style="float:right">查询</button>
                            <button  type="button" id="add_data" class="btn btn-primary" style="float:right">导入信息</button>
                            <button  type="button" id="export" class="btn btn-primary" style="float:right">导出信息</button>
                            <button  type="button" id="del_data" class="btn btn-primary" style="float:right">删除</button>
                        </div>
                    </div>
                <table class="table table-bordered form_table set_margin">
                    <thead>
                    <tr>
                        <th><input type="checkbox" style="zoom:100%;" id="total" name="total" value=""/></th>
                        <th>序号</th>
                        <th>姓名</th>
                        <th>学院</th>
                        <th>专业</th>
                        <th>班级</th>
                        <th>公司</th>
                        <th>职称</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody id="tbody">
                    <?php
                    if(is_array($stu_list)) {
                        $i = ($page-1)*$shownum+1;
                        foreach ($stu_list as $item) {
                            echo '<tr>
                                 <td class="center">
                                    <input id="gid" value="'.$item['id'].'" type="hidden"/>
                                    <input type="checkbox" id="inlineCheckbox6" class="item" name="exam" style="zoom:100%;" value="'.$item['id'].'"/>   
                                </td>
                                  
									<td>' . $i . '</td>
									<td>' . $item['name'] . '</td>
									<td>' . $Depart_type[$item['depart']] . '</td>
									<td>' . $item['major'] . '</td>
									<td>' .  $item['class'] . '</td>
							        <td>' . $item['company'] . '</td>
									<td>' .  $item['job'] . '</td>
									<td>
										<a onclick="view_account(' . $item['id'] . ')" class="table_link" href="#">查看</a>
										<a onclick="edit_account(' . $item['id'] . ')" class="table_link" href="#">修改</a>			
										<a onclick="del_account(' . $item['id'] . ')" class="table_dange" href="#">删除</a>
									</td>
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