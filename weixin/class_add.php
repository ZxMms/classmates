<!DOCTYPE html>
<html>

<?php
require_once ("admin_init.php");
?>
<head>
    <title>校友注册</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <link rel="stylesheet" href="css/weui.css">
    <link rel="stylesheet" href="css/jquery.weui.css">
    <link rel="stylesheet" href="css/common.css" />
    <script type="text/javascript" src="js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="js/layer_mobile/layer.js"></script>

    <script type="text/javascript" src="js/common.js"></script>

    <script src="static/js/jquery.min.js"></script>
    <script src="static/js/common.js"></script>

    <script src="static/weui/js/jquery-weui.min.js"></script>
    <script src="static/weui/js/picker.city.js"></script>
    <script src="static/js/swiper.min.js"></script>
    <script type="text/javascript" src="static/js/rolldate.min.js"></script>
    <script type="text/javascript" src="static/layer/layer.js"></script>
    <script type="text/javascript" src="js/upload.js"></script>
    <!--    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>-->
    <script type="text/javascript">


    </script>

    <script type="text/javascript">

        $(function(){
            var HTTP_PATH = "<?php echo $HTTP_PATH?>";
            function  ajaxFile() {

                var isUpNum = $(".fileList_item").length;
                if(isUpNum>=1)
                {
                    layerContent("最多上传一个文件");
                    return false;
                }

                var index = layer.open({
                    content: "正在上传请稍等...."
                    ,skin: 'msg'
                    ,time: 100 //100秒后自动关闭
                });


                var uploadUrl = 'handing_do.php?act=upload';//处理上传的图片

                $.ajaxFileUpload({
                    url           : uploadUrl,
                    fileElementId : 'file',
                    dataType      : 'json',
                    success       : function(data, status){
                        var code = data.code;
                        var msg  = data.msg;
                        layer.close(index);
                        switch(code){
                            case 1:

                                var httpUrl = HTTP_PATH + msg;
                                var  html  = ' <div class="fileList_item" id="fileList"  >' +
                                    '             <img  src="'+httpUrl+'" ><div class="fileList_item_close"></div>' +
                                    '              <input type="hidden" value="'+msg+'" id="imgUrl">'+
                                    '          </div>';
                                $("#upimg").append(html);


                                break;
                            default:
                                layerContent(msg);
                        }
                    },
                    error: function (data, status, e){
                        layerContent(e);
                    }
                });

                $('#file').change(function() {
                    ajaxFile();
                });

            };


            $('#file').change(function(){
                ajaxFile();
                return false;
            });




            $("#btn_submit").click(function () {

                var name=$("#name").val();
                if(name == ""){
                    layer.msg("姓名不能为空！");
                    return false;
                }
                var sex=$("#sex").val();

                var birth=$("#birth").val();
                if(birth == ""){
                    layer.msg("出生日期不能为空！");
                    return false;
                }
                var pic=$("#imgUrl").val();
                var depart=$("#depart").val();
                if(depart == ""){
                    layer.msg("培养院系不能为空！");
                    return false;
                }
                var major=$("#major").val();
                if(major == ""){
                    layer.msg("专业不能为空！");
                    return false;
                }
                var classes=$("#class").val();
                if(classes == ""){
                    layer.msg("班级不能为空！");
                    return false;
                }
                var tel=$("#tel").val();
                if(tel == ""){
                    layer.msg("联系电话不能为空！");
                    return false;
                }
                var email=$("#email").val();
                if(email == ""){
                    layer.msg("邮箱不能为空！");
                    return false;
                }
                var wechat=$("#wechat").val();
                if(wechat == ""){
                    layer.msg("微信不能为空！");
                    return false;
                }
                var qq=$("#qq").val();

                var company=$("#company").val();

                var job=$("#job").val();
                var address=$("#address").val();
                var degree=$("#degree").val();
                var in_time=$("#in_time").val();
                var out_time=$("#out_time").val();

                $.ajax({
                    type: 'POST',
                    data: {
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
                        out_time:out_time,
                        in_time:in_time,
                        degree: degree
                    },
                    dataType: 'json',
                    url: 'handing_do.php?act=add',
                    success: function (data) {
                        var code = data.code;
                        var msg = data.msg;
                        switch(code){
                            case 1:
                                layer.msg(msg, {
                                    icon: 1,
                                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                                }, function(){
                                    //do something
                                    window.location.href="class_add.php";
                                });

                                break;
                            default:
                                layerContent(resultMsg);
                        }
                    }
                });
                return true;

            });

            $(document).on("click",".fileList_item_close",function(){
                $(this).parent().remove();
            });


        });
            window.onload = function(){
                new rolldate.Date({
                    el:'#birth',
                    format:'YYYY-MM-DD',
                    beginYear:2000,
                    endYear:2100
                })

            }

    </script>
</head>

<body ontouchstart>
<div class="pageMain">
    <div class="weui-cells fromPage">
        <div class="weui-cell">
            <div class="weui-cell__hd fromPage_line">
                <p>个人信息</p>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>姓名<span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="" id="name" value="" placeholder="请输入您的姓名" />
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>性别<span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <label class='question_radio'  >
                    <input type='radio'  value='1'  name='sex'  id ="sex" checked> 男
                </label>
                <label class='question_radio'  >
                    <input type='radio'  value='2'  name='sex'  id ="sex" > 女
                </label>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>出生日期 <span>*</span></p>
            </div>
            <div class="weui-cell__bd" >
            <div class="form-input flex">
                   <input readonly class="form-control" type="text" id="birth" placeholder="请输入出生日期">
             </div>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>照片</p>
            </div>
            <div class="weui-cell__bd">

                <div class="fileList" id="upimg">
                </div>
                <div class="blabk10px"></div>

                <div class="file_fromPageBtn">
                    <span>添加图片</span>
                    <input type="file" name="file" accept="image/*" value="上传图片" id="file" >
                </div>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>培养院系 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <div class="blabk15px"></div>
                <select name="political" id="depart" class="form-control width150">
                    <?php foreach ($Depart_type as $key => $item){
                        ?>
                        <option value="<?php echo $key; ?>"><?php echo $item?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>专业 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="major" id="major" value="" placeholder="请输入您的专业" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>班级 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="class" id="class" value="" placeholder="请输入您的班级" />
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>联系电话 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="tel" id="tel" value="" placeholder="请输入您的联系电话" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>邮箱 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="email" id="email" value="" placeholder="请输入您的邮箱" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>微信 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="wechat" id="wechat" value="" placeholder="请输入您的微信" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>入学时间 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <div class="blabk15px"></div>
                <select name="in_time" id="in_time" class="form-control width150">
                    <?php foreach ($time_type as $key => $item){
                        ?>
                        <option value="<?php echo $item; ?>"><?php echo $item?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>毕业时间 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <div class="blabk15px"></div>
                <select name="out_time" id="out_time" class="form-control width150">
                    <?php foreach ($time_type as $key => $item){
                        ?>
                        <option value="<?php echo $item; ?>"><?php echo $item?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>qq <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="qq" id="qq" value="" placeholder="请输入您的qq" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>现工作单位 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="company" id="company" value="" placeholder="请输入您的现工作单位" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>职称 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="job" id="job" value="" placeholder="请输入您的职称" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>学历 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <div class="blabk15px"></div>
                <select name="political" id="degree" class="form-control width150">
                    <?php foreach ($Degree_type as $key => $item){
                        ?>
                        <option value="<?php echo $key; ?>"><?php echo $item?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>详细地址 <span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="address" id="address" value="" placeholder="请输入您的详细地址" />
            </div>
        </div>


        <div class="fromPage_submie">
            <button class="fromPageBtn open-popup"   id="btn_submit">提交</button>
            <!--            <button class="fromPageClear" id="btn_cancel">重置</button>-->

        </div>
    </div>
    <div class="submit_layer" style="display: none">
        <div class="submit_layer_container">
            <img src="img/pop_img.png">
            <p id="submit_layer_container_content">提交成功</p>
            <p><c id="second">5</c>s后跳转返回</p>
        </div>
    </div>
    <script src="js/fastclick.js"></script>
    <script>
        $(function() {
            FastClick.attach(document.body);
        });
    </script>
    <script src="js/jquery.weui.js"></script>

    <script type="text/javascript">

    </script>

</body>

</html>