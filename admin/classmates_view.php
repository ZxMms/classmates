<?php
/**新建办件
 */
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID = '1,2,3,4,5,6';//什么样的权限能访问 如role_level

$FLAG_FIRST_LEFTNAV = 'classmates';
$FLAG_SECOND_LEFTNAV = 'classmates_list';
$id=$_GET['id'];
$people_info=People::getInfoById($id);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>新增校友信息</title>
    <link rel="stylesheet" type="text/css" href="static/select2-4.0.6-rc.1/dist/css/select2.min.css">
    <link rel="stylesheet" href="static/css/common.css" />
    <link rel="stylesheet" href="static/css/index.css" />
    <link rel="stylesheet" href="static/css/other.css" />
    <link rel="stylesheet" href="static/js/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="static/js/layer/skin/default/layer.css" />
    <link rel="stylesheet" href="static/css/popup.css"/>
    <script type="text/javascript" src="static/js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="static/js/layer/layer.js"></script>
    <script type="text/javascript" src="static/js/jquery.form.min.js"></script>
    <script type="text/javascript" src="static/js/jquery.nicescroll.min.js" ></script>
    <script type="text/javascript" src="static/js/upload.js"></script>
    <script src="static/js/index.js"></script>
    <script type="text/javascript" src="static/select2-4.0.6-rc.1/dist/js/select2.full.min.js"></script>
    <!-- 新增Bootstrap样式制作多选框js结束 -->
    <script type="text/javascript">

        $(function(){
            function  ajaxFile() {

                var HTTP_PATH = "<?php echo $HTTP_PATH?>";

                var index = layer.msg("正在上传请稍等....",{time:1000000});


                var uploadUrl = 'classmates_do.php?action=upload';//处理上传的图片
                $.ajaxFileUpload({
                    url           : uploadUrl,
                    fileElementId : 'file',
                    dataType      : 'json',
                    success       : function(data, status){
//                        alert(data);
                        var code = data.code;
                        var msg  = data.msg;
                        layer.close(index);
                        switch(code){
                            case 1:
                                $(".up-img").attr("src","../"+msg);
                                $("#file_url").val(msg);

                                break;

                            default:
                                layer.alert(msg, {icon: 5,closeBtn: 0});
                        }
                    },
                    error: function (data, status, e){
                        layer.alert(e);
                    }
                });

                $('input[type="file"]').change(function(e) {
                    ajaxFile(this);
                });

            };

            $("#submit").click(function () {

                var id=<?php echo $id;?>;

                var name=$("#name").val();
                var sex=$("#sex").val();
                var birth=$("#birth").val();
                var pic=$("#file_url").val();

                var depart=$("#depart").val();
                var major=$("#major").val();
                var classes=$("#class").val();
                var tel=$("#tel").val();
                var email=$("#email").val();
                var wechat=$("#wechat").val();
                var qq=$("#qq").val();
                var company=$("#company").val();
                var job=$("#job").val();
                var address=$("#address").val();
                var groups=$("#groups").val();
                var degree=$("#degree").val();

                var in_time=$("#in_time").val();
                var out_time=$("#out_time").val();
                $.ajax({
                    type: 'POST',
                    data: {
                        id:id,
                        name: name,
                        sex: sex,
                        birth: birth,
                        pic: pic,
                        depart: depart,
                        major: major,
                        class: classes,
                        tel: tel,
                        email: email,
                        wechat: wechat,
                        qq: qq,
                        company: company,
                        job: job,
                        address: address,
                        groups: groups,
                        out_time:out_time,
                        in_time:in_time,
                        degree: degree
                    },
                    dataType: 'json',
                    url: 'classmates_do.php?action=edit',
                    success: function (data) {
                        console.log(data);
                        var code = data.code;
                        var msg = data.msg;
                        switch (code) {
                            case 1:
                                layer.alert(msg, {icon: 6, shade: false}, function (index) {
                                    location.href="classmates_list.php";
                                });
                                break;
                            default:
                                layer.alert("添加失败 " , {icon: 2, shade: false});
                                location.href="classmates_list.php";
                        }
                    }
                });
                return true;

            });
            $('#add_data').click(function () {
                layer.open({
                    type: 2,
                    title: '导入文件',
                    shadeClose: true,
                    shade: 0.3,
                    area: ['600px', '340px'],
                    content: 'import_data.php'
                });
            });

        });
    </script>
<body>
<div id="wrapper">
    <div class="mainLeft">
        <div class="mainLogo">
            <a href=""><img src="static/img/common/logo.png"/></a>
        </div>
        <?php include('nav.inc.php');?>
    </div>
    <?php include('top.inc.php');?>
    <div class="mainBox">
        <!----主页面--->
        <div class="mainPage">
            <!----当前位置--->
            <div class="page_header">
                <a href="">当前位置</a><span>：</span>
                <a href="">新增学生信息</a>

            </div>
            <!----当前位置--->
            <!----内容区域--->
            <div class="page_body">
                <form enctype="multipart/form-data" id="user_info">
                    <table class="table table-bordered form_table">
                        <thead>
                        <tr>
                            <th colspan="8">学生信息</th>
                        </tr>
                        </thead>
                        <tr align="center">
                            <td width="64" height="33">姓名</td>
                            <td width="180"> <input type="text" id="name" name="name" class="form-control" value="<?php echo $people_info['name']?>"/></td>
                            <td>性别</td>
                            <td width="360">
                                <?php
                                if(1==$people_info['sex']){
                                    ?>
                                    <input type="radio" value="1" name="sex" id ="sex" checked/>男
                                    <input type="radio" value="2" name="sex" id ="sex" />女
                                    <?php
                                }else{
                                    ?>
                                    <input type="radio" value="1" name="sex" id ="sex" />男
                                    <input type="radio" value="2" name="sex" id ="sex" checked/>女
                                    <?php
                                }
                                ?>


                            </td>
                            <td>出生日期</td>
                            <td>
                                <input type="text" class="form-control width120" name="birth" id="birth" value="<?php echo date("Y-m-d",$people_info['birth'])?>"/>
                                <script type="text/javascript" src="laydate/laydate.js"></script>
                                <script type="text/javascript">
                                    laydate.skin("molv");//设置皮肤
                                    var start = {
                                        elem: '#birth',
                                        format: 'YYYY-MM-DD',
                                        min: '1800-06-16', //设定最小日期为当前日期
                                        max: '2099-06-16', //最大日期
                                        istime: true,
                                        istoday: false,
                                    };
                                    laydate(start);
                                </script>
                            </td>


                            <td width="20" rowspan="5" colspan="2" class="tl">

                                <div class="up-file" align="right">
                                    <div class="img-file">
                                        <img src="<?php echo "../".$people_info['img']?>" alt="" class="up-img">
                                        <input style="position: absolute;top: 0;width: 350px;height: 220px;opacity: 0;" type="file" multiple=""
                                               id="file" name="file" class="add_email_file" >
                                        <input type="hidden" id="file_url" value="admin/static/default.png">
                                    </div>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="112">培养院系</td>
                            <td class="tl" style="width:30%;" align="right">
                                <div class="form-inline">
                                    <select name="political" id="depart" class="form-control width150">
                                        <?php foreach ($Depart_type as $key => $item){
                                            if($key==$people_info['depart']){
                                                ?>
                                                <option value="<?php echo $key; ?>" selected><?php echo $item?></option>
                                            <?php }else{?>
                                                <option value="<?php echo $key; ?>"><?php echo $item?></option>
                                            <?php }}?>
                                    </select>
                                </div>
                            </td>
                            <td height="31">专业</td>
                            <td width="180"> <input type="text" id="major" name="major" class="form-control" value="<?php echo $people_info['major']?>"/></td>
                            <td>班级</td>
                            <td width="180"> <input type="text" id="class" name="class" class="form-control" value="<?php echo $people_info['class']?>"/></td>

                        </tr>

                        <tr>
                            <td width="112">联系电话</td>
                            <td width="360"> <input type="text" id="tel" name="tel" class="form-control" value="<?php echo $people_info['tel']?>"/></td>
                            <td height="31">邮箱</td>
                            <td width="180"> <input type="text" id="email" name="email" class="form-control" value="<?php echo $people_info['email']?>"/></td>
                            <td>微信</td>
                            <td width="180"> <input type="text" id="wechat" name="wechat" class="form-control" value="<?php echo $people_info['weixin']?>"/></td>

                        </tr>
                        <tr>
                            <td width="112">入学时间</td>
                            <td>
                                <select name="in_time" id="in_time" class="form-control width150">
                                    <?php foreach ($time_type as $key => $item){
                                        if($item==$people_info['in_time']){
                                            ?>
                                            <option value="<?php echo $item; ?>" selected><?php echo $item?></option>
                                        <?php }else{
                                            ?>
                                            <option value="<?php echo $item; ?>"><?php echo $item?></option>
                                        <?php }
                                        ?>
                                    <?php }?>
                                </select>
                            </td>
                            <td height="31">毕业时间</td>
                            <td>
                                <select name="out_time" id="out_time" class="form-control width150">
                                    <?php foreach ($time_type as $key => $item){
                                        if($item==$people_info['out_time']){
                                            ?>
                                            <option value="<?php echo $item; ?>" selected><?php echo $item?></option>
                                        <?php }else{
                                            ?>
                                            <option value="<?php echo $item; ?>"><?php echo $item?></option>
                                        <?php }
                                        ?>
                                    <?php }?>
                                </select>
                            </td>
                            <td>qq</td>
                            <td width="200"> <input type="text" id="qq" name="qq" class="form-control" value="<?php echo $people_info['qq']?>"/></td>
                        </tr>
                        <tr>

                            <td>现工作单位</td>
                            <td  align="center"> <input type="text" id="company" name="company" class="form-control" value="<?php echo $people_info['company']?>"/></td>
                            <td>职称</td>
                            <td  align="center"> <input type="text" id="job" name="job" class="form-control" value="<?php echo $people_info['job']?>"/></td>
                            <td>学历</td>
                            <td class="tl" style="width:40%;">
                                <div class="form-inline">
                                    <select name="political" id="degree" class="form-control width150">
                                        <?php foreach ($Degree_type as $key => $item){
                                            if($key==$people_info['degree']){
                                                ?>
                                                <option value="<?php echo $key; ?>" selected><?php echo $item?></option>
                                            <?php }else{?>
                                                <option value="<?php echo $key; ?>"><?php echo $item?></option>
                                            <?php }}?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>

                            <td>详细地址</td>
                            <td colspan="2" align="center"> <input type="text" id="address" name="address" class="form-control" value="<?php echo $people_info['address']?>"/></td>
                            <td>校友会</td>
                            <td colspan="2" align="center"> <input type="text" id="groups" name="groups" class="form-control" value="<?php echo $Group_type[$people_info['group_id']]?>"/></td>
                        </tr>


                    </table>
                    <p>&nbsp;</p>

                    </center>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
<!--                    <p class="center">-->
<!--                        <input type="button" name="submit" id="submit" class="btn btn-null-primary" value="提交" />-->
<!--                        <input type="reset" name="reset" id="reset"  class="btn btn-null-primary"  value="重置" />-->
<!--                    </p>-->
                </form>
            </div>
        </div>
        <!----主页面--->
    </div>

</div>
<script type="text/javascript" src="static/js/common.js"></script>
</body>
</html>