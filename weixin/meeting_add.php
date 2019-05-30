<!DOCTYPE html>
<html>

<?php
require_once ("admin_init.php");
?>
<head>
    <title>校友聚会申请</title>
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


                var uploadUrl = 'meeting_do.php?act=upload';//处理上传的图片

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

                var title = $("#name").val();

                var content   = $("#content").val();

                var titlength = $("#name").val().length;

                var people = $("#people").val();
                var time =$("#time").val();

                var classes = $("#classes").val();

                var tel =$("#tel").val();

                var pic=$("#imgUrl").val();
                //var contlength = $("#content").val().length;
                if(titlength == 0){
                    layer.tips('聚会标题不能为空', '#name');
                    return false;
                }
                if (content == '') {
                    layer.tips('聚会内容不能为空', '#content');
                    return false;
                }

                if(people == ''){
                    layer.tips('申请人不能为空', '#people');
                    return false;
                }
                if (time == '') {
                    layer.tips('聚会时间不能为空', '#time');
                    return false;
                }
                if (classes == '') {
                    layer.tips('班级不能为空', '#classes');
                    return false;
                }
                if (pic == '') {
                    layer.tips('封面图不能为空', '#content');
                    return false;
                }
                if (tel == '') {
                    layer.tips('联系方式不能为空', '#content');
                    return false;
                }
                $(this).unbind();

                $.ajax({
                        type: 'post',
                        url: 'meeting_do.php?act=add',
                        data: {
                            name : title,
                            content : content,
                            people:people,
                            time:time,
                            img:pic,
                            tel:tel,
                            classes:classes
                        },
                     dataType: 'json',
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
                                    window.location.href="meeting_list.php";
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
                    el:'#time',
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
                <p>聚会信息</p>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>标题<span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="" id="name" value="" placeholder="请输入您的申请标题" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>申请内容 </p>
            </div>
            <div class="weui-cell__bd">
                <textarea class="ask_weui_textarea"  rows="5" placeholder="请输入内容,内容字数保持在500字以内" id="content"></textarea>
            </div>
        </div>

        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>申请人<span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="" id="people" value="" placeholder="请输入您的名字" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>联系电话<span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="tel" id="tel" value="" placeholder="请输入您的联系方式" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>聚会班级<span>*</span></p>
            </div>
            <div class="weui-cell__bd">
                <input type="text" name="" id="classes" value="" placeholder="请输入您的班级" />
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <p>聚会日期 <span>*</span></p>
            </div>
            <div class="weui-cell__bd" >
                <div class="form-input flex">
                    <input readonly class="form-control" type="text" id="time" placeholder="请输入聚会日期">
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