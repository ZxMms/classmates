<?php
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID = '1,2,3,4';//什么样的权限能访问 如role_level


$FLAG_FIRST_LEFTNAV = 'service';

$FLAG_SECOND_LEFTNAV = 'service_job';
$param=array();

$shownum  = 15;


$total_count=job::getCount($param);


$pagecount = ceil($total_count / $shownum);

$page      = getPage($pagecount);

$param["page"]=$page;
$param["pageSize"]=$shownum;


$stu_list=job::getList($param);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>招聘信息</title>
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
            $('#add').click(function(){
                layer.open({
                    type: 2,
                    title: '添加招聘信息',
                    shadeClose: true,
                    shade: 0.3,
                    area: ['1000px', '600px'],
                    content: 'service_job_add.php'
                });
            });
            $('.editinfo').click(function(){
                var id = $(this).parent('td').find('#aid').val();
                layer.open({
                    type: 2,
                    title: '修改招聘信息',
                    shadeClose: true,
                    shade: 0.3,
                    area: ['1000px', '600px'],
                    content: 'service_job_edit.php?id=' + id
                });
            });

            $('.delete').click(function(){
                var id = $(this).parent('td').find('#aid').val();
                //alert(id);
                layer.confirm('确认删除招聘信息吗？', {
                    btn: ['确认','取消']
                }, function(){
                    $.ajax({
                        type:'POST',
                        data:{
                            id:id
                        },
                        url:"service_job_do.php?act=del",
                        dataType:'json',
                        success : function(data){
                            var code =data.code;
                            var msg = data.msg;
                            switch(code){
                                case 1:
                                    layer.alert(msg, {icon: 6}, function(index){
                                        location.reload();
                                    });
                                    break;
                                default:
                                    layer.alert(msg,{icon: 5});
                            }
                        }
                    });
                });
            });
        });

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
                <a href="">招聘信息</a>
            </div>
            <!----当前位置--->
            <!----内容区域--->
            <div class="page_body">
                <div class="pageSearch">
                    <div class="form-inline">
                        <button  type="button" id="add" class="btn btn-primary">添加 </button>
                    </div>
                <table class="table table-bordered form_table set_margin">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>图片展示</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody id="tbody">
                    <?php
                    if(is_array($stu_list)) {
                        $i = ($page-1)*$shownum+1;
                        foreach ($stu_list as $item) {
                            echo '<tr>
                                 
									<td>' . $i . '</td>
									<td>' . $item['name'] . '</td>						
									
									<td>' ;
                                    if($item['img']){
                                        echo '<img src="'.$HTTP_PATH . $item['img'].'" width="100" height="50">';
                                    }

                                    echo '</td>
							        <td>' . date('Y-m-d H:i',$item['addtime']) . '</td>
									<td>
									<a class="editinfo" href="javascript:void(0)">修改</a>
                                    <a class="delete" href="javascript:void(0)">删除</a>
                                    <input type="hidden" id="aid" value="'.$item['id'].'"/>
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