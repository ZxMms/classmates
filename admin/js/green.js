$(function () {
    function refresh() {
        var myChart = echarts.init(document.getElementById('main'));
        var keyword = getParam("keyword");
        var method = "fund_history";
        var timestamp = (new Date()).getTime();
        var sign = getSign(method,timestamp);
        var code = $('.btn-yes').val();
        var myDate = getNowFormatDate(code);
        $.ajax({
            type         : 'POST',
            data         : {
                method :method,
                timestamp:timestamp,
                code:keyword,
                sign   : sign
            },
            url : "../api/v1.0/api.php",
            dataType:'json',
            beforeSend :  function(data){
                // $('#Canvas').html('<p>请求处理中...</p>');
            },
            success :     function(data) {
                var msgData = data.data;
                //横坐标
                var time = msgData.date;
                var time_data = new Array();
                var index = new Array();
                var found_data = new Array();
                for (var i=0;i<time.length;i++){
                    if(myDate<=time[i]){
                        time_data.push(time[i]);
                        index.push(i);
                    }
                }
                var y_Axis=msgData.unit_nav;
                for (var j=0; j<index.length ;j++){
                    found_data.push(parseFloat(y_Axis[index[j]]));
                }

                if (time_data==''){
                    time_data.push("暂无数据")
                }
                var option = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    xAxis: {
                        type: 'category',
                        data: time_data
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [{
                        data: found_data,
                        type: 'line'
                    }]
                };
                // 使用刚指定的配置项和数据显示图表。
                myChart.setOption(option);
            }
        });
        function getNowFormatDate(code){
            var resultDate,year,month;
            var currDate = new Date();
            year = currDate.getFullYear();
            month = currDate.getMonth()+1;
            if (month<code){
                month += (12-code);
                year--;
            } else{
                if (code==3){
                    month=month-2;
                }
            }
            month = (month < 10) ? ('0' + month) : month;
            resultDate = year + '-'+month+'-'+'01';
            return resultDate;
        }
    }

    var myChart = echarts.init(document.getElementById('main'));
    var keyword = getParam("keyword");
    var method = "fund_history";
    var timestamp = (new Date()).getTime();
    var sign = getSign(method,timestamp);
    var code = $('.btn-yes').val();
    var myDate = getNowFormatDate(code);
    $.ajax({
        type         : 'POST',
        data         : {
            method :method,
            timestamp:timestamp,
            code:keyword,
            sign   : sign
        },
        url : "../api/v1.0/api.php",
        dataType:'json',
        beforeSend :  function(data){
            // $('#Canvas').html('<p>请求处理中...</p>');
        },
        success :     function(data) {
            var msgData = data.data;
            //横坐标
            var time = msgData.date;
            var time_data = new Array();
            var index = new Array();
            var found_data = new Array();
            for (var i=0;i<time.length;i++){
                if(myDate<=time[i]){
                    time_data.push(time[i]);
                    index.push(i);
                }
            }
            var y_Axis=msgData.unit_nav;
            for (var j=0; j<index.length ;j++){
                found_data.push(parseFloat(y_Axis[index[j]]));
            }

            if (time_data==''){
                time_data.push("暂无数据")
            }

            var option = {
                tooltip: {
                    trigger: 'axis'
                },
                xAxis: {
                    type: 'category',
                    data: time_data
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    data: found_data,
                    type: 'line'
                }]
            };
            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        }
    });
    function getNowFormatDate(code){
        var resultDate,year,month;
        var currDate = new Date();
        year = currDate.getFullYear();
        month = currDate.getMonth()+1;
        month = (month < 10) ? ('0' + month) : month;
        resultDate = year + '-'+month+'-'+'01';
        return resultDate;
    }

    //点击切换时间
    $(".btn-no").click(function () {
        $(this).addClass("btn-yes").siblings().removeClass("btn-yes");
        refresh();
    });
});