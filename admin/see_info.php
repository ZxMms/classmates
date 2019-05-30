<?php
require_once('admin_init.php');
require_once('admincheck.php');

$POWERID = '1,2,3,4';//什么样的权限能访问 如role_level


$FLAG_FIRST_LEFTNAV = 'classmates';

$FLAG_SECOND_LEFTNAV = 'see_info';
$param=array();

$shownum  = 14;
if(isset($_GET['depart'])){
    $param["depart"]=$_GET['depart'];
}
if(isset($_GET['group'])){
    $param["group"]=$_GET['group'];
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

    <script type="text/javascript">
        $(function () {
            line();
            $("#style").change(function () {
                var value=$("#style").val();
                var type=$("#type").val();
                if(value==1){
                    if(type==1){
                        line();
                    }else{
                        line_01();
                    }
                }else{
                    if(type==1){
                        yuan();
                    }else{
                        yuan_01();
                    }
                }
            });
            $("#type").change(function () {
                var value=$("#style").val();
                var type=$("#type").val();

                if(type==1){
                    if(value==1){
                        line();
                    }else{
                        yuan();
                    }
                }else{
                    if(value==1){
                        line_01();
                    }else{
                        yuan_01();
                    }
                }
            });

        });
        function line() {
            $("#doughnut").hide();
            $("#annular").show();
            var myChart1 = echarts.init(document.getElementById('annular'));
            var method = "get_line";
            var timestamp = (new Date()).getTime();
            var sign = getSign(method, timestamp);
            var index;
            $.ajax({
                type: 'POST',
                data: {
                    method: method,
                    timestamp: timestamp,
                    sign: sign
                },
                url: "../api/v1.0/api.php",
                dataType: 'json',
                beforeSend: function (data) {
                    index = layer.msg('正在加载，请稍后...', {
                        icon: 16
                        , shade: 0.3
                        , time: 1000000
                    });
                    // $('#Canvas').html('<p>请求处理中...</p>');
                },
                success: function (data) {

                    layer.close(index);
                    var grades=data.data[0].grade;
                    var numbers=data.data[0].number;
                    var label = new Array();
                    var value = new Array();

                    for (var key in grades) {
                        label.push(grades[key]);
                        value.push(numbers[key]);
                    }
                    console.log(label);
                    console.log(value);

                    var option1 = {
                        tooltip: {
                            trigger: 'axis',
                        },
                        title : {
                            text: '毕业生数量统计',

                            x:'center'
                        },
                        color:['#3B48EE'],
                        legend: {
                            data: ['毕业人数'],
                            top: 270,
                        },
                        xAxis: {
                            type: 'category',
                            boundaryGap: false,
                            axisLine: {
                                lineStyle: {
                                    color: '#E6EAF0',
                                }
                            },
                            axisLabel: {
                                textStyle: {
                                    color: '#959FAC',//坐标值得具体的颜色
                                }
                            },
                            data: label
                        },
                        yAxis: {
                            type: 'value',
                            // scale: true,
                            boundaryGap: false,
                            axisLine: {
                                lineStyle: {
                                    color: '#E6EAF0',
                                }
                            },
                            axisLabel: {
                                textStyle: {
                                    color: '#959FAC',//坐标值得具体的颜色
                                }
                            },
                        },
                        series: [
                            {
                                name: "毕业人数",
                                type: 'line',
                                symbol: "circle",
                                itemStyle: {
                                    normal: {
                                        lineStyle: {
                                            width: 1,
                                            color: "#3B48EE",
                                        },
                                    }
                                },

                                areaStyle: {
                                    normal: {
                                        color: new echarts.graphic.LinearGradient(
                                            0, 0, 0, 1,
                                            [
                                                {offset: 0, color: 'rgba(84,93,255,0.4)'},
                                                {offset: 1, color: '#fff'}
                                            ]
                                        )
                                    }
                                },
                                symbolSize: 6,
                                data: value

                            }

                        ]
                    };
                    myChart1.setOption(option1);
                }
            });
        }
        function yuan() {
            $("#annular").hide();
            $("#doughnut").show();
            var myChart2 = echarts.init(document.getElementById('doughnut'));
            var method = "get_line";
            var timestamp = (new Date()).getTime();
            var sign = getSign(method, timestamp);
            var index;
            $.ajax({
                type: 'POST',
                data: {
                    method: method,
                    timestamp: timestamp,
                    sign: sign
                },
                url: "../api/v1.0/api.php",
                dataType: 'json',
                beforeSend: function (data) {
                    index = layer.msg('正在加载，请稍后...', {
                        icon: 16
                        , shade: 0.3
                        , time: 1000000
                    });
                    // $('#Canvas').html('<p>请求处理中...</p>');
                },
                success: function (data) {

                    layer.close(index);
                    var grades=data.data[0].grade;
                    var numbers=data.data[0].number;
                    var label = new Array();
                    var value = new Array();
                    var data = new Array();
                    var sum=0;
                    for (var key in grades) {
                        label.push(grades[key]);
                        value.push(numbers[key]);
                        sum+=parseInt(numbers[key]);
                    }
                    console.log(sum);
                    console.log(label);
                    console.log(value);
                    for (var i = 0; i < label.length; i++) {
                        data.push({value: value[i], name: label[i]})
                    }
                    var value1 = new Array();
                    for (var i = 0; i < value.length; i++) {
                        value1.push(((value[i]/sum)*100).toFixed(2))
                    }
                    var option2 = {
                        title : {
                            text: '毕业生数量统计',

                            x:'center'
                        },
                        color: ["#26DFDE", "#FFB500", "#3B48EE", "#FF5959", "#F44CFF", "#7ED321", "#FFFF00"],
                        legend: {
                            name:"毕业人数",
                            orient: 'vertical',  //垂直显示
                            x: '70%',
                            y: 'center',
                            itemWidth: 5, // 设置宽度
                            itemHeight: 15, // 设置高度
                            data: label,
                            selectedMode: false,
                            textStyle: {
                                color: '#959FAC',  //文字颜色
                                fontSize: 12    //文字大小
                            },
                            formatter: function (name) {
                                var index = 0;
                                var clientlabels = label;
                                var clientcounts = value1;
                                clientlabels.forEach(function (value, i) {
                                    if (value == name) {
                                        index = i;
                                    }
                                });
                                return name + " " + clientcounts[index] + "%";
                            },
                        },
                        graphic: {
                            name: "毕业人数",
                            elements: [
                                {
                                    type: 'image',
                                    style: {
                                        image: '../web/img/down-icon.png',
                                        width: 22,
                                        height: 22
                                    },
                                    left: '27%', // 相对父元素居中
                                    top: '55%',  // 相对父元素上下的位置
                                },
                                {
                                    type: 'text',
                                    left: '20%', // 相对父元素居中
                                    top: 'center',  // 相对父元素上下的位置
                                    style: {
                                        fill: '#485465',
                                        textAlign: 'center',
                                        font: '14px Arial Normal',
                                    }
                                }]
                        },
                        series: [
                            {
                                name: "毕业人数",
                                type: 'pie',
                                radius: ['50%', '60%'],
                                center: ['30%', '50%'],//圆形居中
                                avoidLabelOverlap: false,
                                label: {
                                    normal: {
                                        show: false,
                                    },
                                    emphasis: {
                                        show: false,
                                    }
                                },
                                labelLine: {
                                    normal: {
                                        show: false
                                    }
                                },
                                data: data
                            }
                        ]
                    };
                    myChart2.setOption(option2);
                }
            });
        }
        function line_01() {
            $("#doughnut").hide();
            $("#annular").show();
            var myChart1 = echarts.init(document.getElementById('annular'));
            var method = "get_line_num";
            var timestamp = (new Date()).getTime();
            var sign = getSign(method, timestamp);
            var index;
            $.ajax({
                type: 'POST',
                data: {
                    method: method,
                    timestamp: timestamp,
                    sign: sign
                },
                url: "../api/v1.0/api.php",
                dataType: 'json',
                beforeSend: function (data) {
                    index = layer.msg('正在加载，请稍后...', {
                        icon: 16
                        , shade: 0.3
                        , time: 1000000
                    });
                    // $('#Canvas').html('<p>请求处理中...</p>');
                },
                success: function (data) {

                    layer.close(index);
                    var label=data.data[0].type;
                    var value=data.data[0].number;

//                    var label = new Array();
//                    var value = new Array();
//
//                    for (var key in grades) {
//                        label.push(grades[key]);
//                        value.push(numbers[key]);
//                    }
                    console.log(label);
                    console.log(value);


                    var option1 = {
                        title : {
                            text: '毕业生数量统计',
//                            subtext: '纯属虚构',
                            x:'center'
                        },
                        xAxis: {
                            type: 'category',
                            boundaryGap:true,
                            data: label
                        },
                        yAxis: {
                            type: 'value'
                        },
                        series: [{
                            data: value,
                            barGap:'-100%',
                            barCategoryGap:'90%',
                            animation: false,
                            type: 'bar'
                        }]
                    };


                    myChart1.setOption(option1);
                }
            });
        }
        function yuan_01() {
            $("#annular").hide();
            $("#doughnut").show();
            var myChart2 = echarts.init(document.getElementById('doughnut'));
            var method = "get_line_num";
            var timestamp = (new Date()).getTime();
            var sign = getSign(method, timestamp);
            var index;
            $.ajax({
                type: 'POST',
                data: {
                    method: method,
                    timestamp: timestamp,
                    sign: sign
                },
                url: "../api/v1.0/api.php",
                dataType: 'json',
                beforeSend: function (data) {
                    index = layer.msg('正在加载，请稍后...', {
                        icon: 16
                        , shade: 0.3
                        , time: 1000000
                    });
                    // $('#Canvas').html('<p>请求处理中...</p>');
                },
                success: function (data) {

                    layer.close(index);
                    var grades=data.data[0].type;
                    var numbers=data.data[0].number;
                    var label = new Array();
                    var value = new Array();
                    var data = new Array();
                    var sum=0;
                    for (var key in grades) {
                        label.push(grades[key]);
                        value.push(numbers[key]);
                        if(key==3 || key==4){
                            sum+=parseInt(numbers[key]);
                        }

                    }
                    console.log(sum);
                    console.log(label);
                    console.log(value);
                    for (var i = 0; i < label.length; i++) {
                        data.push({value: value[i], name: label[i]})
                    }
                    var value1 = new Array();
                    for (var i = 0; i < value.length; i++) {
                        value1.push(((value[i]/sum)*100).toFixed(2))
                    }
                    var option2 = {
                        title : {
                            text: '毕业生数量统计',
//                            subtext: '纯属虚构',
                            x:'center'
                        },
                        color: ["#26DFDE", "#FFB500", "#3B48EE", "#FF5959", "#F44CFF", "#7ED321", "#FFFF00"],
                        legend: {
                            name:"毕业人数",
                            orient: 'vertical',  //垂直显示
                            x: '70%',
                            y: 'center',
                            itemWidth: 5, // 设置宽度
                            itemHeight: 15, // 设置高度
                            data: label,
                            selectedMode: false,
                            textStyle: {
                                color: '#959FAC',  //文字颜色
                                fontSize: 12    //文字大小
                            },
                            formatter: function (name) {
                                var index = 0;
                                var clientlabels = label;
                                var clientcounts = value1;
                                clientlabels.forEach(function (value, i) {
                                    if (value == name) {
                                        index = i;
                                    }
                                });
                                return name + " " + clientcounts[index] + "%";
                            },
                        },
                        graphic: {
                            name: "毕业人数",
                            elements: [
                                {
                                    type: 'image',
                                    style: {
                                        image: '../web/img/down-icon.png',
                                        width: 22,
                                        height: 22
                                    },
                                    left: '27%', // 相对父元素居中
                                    top: '55%',  // 相对父元素上下的位置
                                },
                                {
                                    type: 'text',
                                    left: '20%', // 相对父元素居中
                                    top: 'center',  // 相对父元素上下的位置
                                    style: {
                                        fill: '#485465',
                                        textAlign: 'center',
                                        font: '14px Arial Normal',
                                    }
                                }]
                        },
                        series: [
                            {
                                name: "毕业人数",
                                type: 'pie',
                                radius: ['50%', '60%'],
                                center: ['30%', '50%'],//圆形居中
                                avoidLabelOverlap: false,
                                label: {
                                    normal: {
                                        show: false,
                                    },
                                    emphasis: {
                                        show: false,
                                    }
                                },
                                labelLine: {
                                    normal: {
                                        show: false
                                    }
                                },
                                data: data
                            }
                        ]
                    };
                    myChart2.setOption(option2);
                }
            });
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
                <a href="">信息可视化</a>
            </div>
            <!----当前位置--->
            <!----内容区域--->
            <div class="page_body">
                <div class="pageSearch">
                    <div class="form-inline">
                        <label for="selectbody" class="set_margin20">形式：</label>
                        <select id="style"  class="form-control width200">
                           <option value="1">折线(柱状)图</option>
                            <option value="2">扇形图</option>
                        </select>
                        <label for="selectbody" class="set_margin20">类型：</label>
                        <select id="type"  class="form-control width200">
                            <option value="1">毕业人数</option>
                            <option value="2">可联系人数</option>
                        </select>
<!--                        <button  type="button" id="del_data" class="btn btn-primary" style="float:right">查询</button>-->
                    </div>
                </div>
            </div>
            <div class="tab_content">
                 <div class="annular" id="doughnut" style="width: 100%;height: 300px;background: #fff;display: none""></div>
                <div class="annular" id="annular" style="width: 100%;height: 300px;background: #fff;display: block"></div>
            </div>
        </div>

        <!----主页面--->
    </div>

</div>
<script type="text/javascript" src="static/js/common.js"></script>
</body>

</html>