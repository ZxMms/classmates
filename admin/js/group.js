$(function () {
    //默认加载
    var count = $("#count").val();
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

            console.log(grades);
            console.log(numbers)
            // var msgData = data.data[count];
            // //横坐标
            // var time = msgData.date;
            var grade = new Array();
            var num = new Array();

            for (var key in grades) {
                grade.push(grades[key]);
                num.push(numbers[key]);

            }
            console.log(grade);
            console.log(num);

            var myChart1 = echarts.init(document.getElementById('annular'));
            console.log(myChart1);
            var option1 = {
                tooltip: {
                    trigger: 'axis',
                },
                color:['#3B48EE','#9c5977'],
                legend: {
                    data: ['基金组合净值', '同期沪深300指数'],
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
                    data: grade
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
                        name: "基金组合净值",
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
                        symbolSize: 5,
                        data: num

                    },
                    {
                        type: 'line',
                        symbol: "circle",
                        itemStyle: {
                            normal: {
                                lineStyle: {
                                    width: 1,
                                    color: "#9c5977",
                                },
                            }
                        },
                        areaStyle: {
                            normal: {
                                color: new echarts.graphic.LinearGradient(
                                    0, 0, 0, 1,
                                    [
                                        {offset: 0, color: 'rgba(156,89,119,0.4)'},
                                        {offset: 1, color: '#fff'}
                                    ]
                                )
                            }
                        },
                        symbolSize: 5,
                        name: "同期沪深300指数",
                        data: num
                    }
                ]
            };
            myChart1.setOption(option1);
        }
    });
    // $("#clickEcharts div").click(function () {
    //     var index = $(this).index();
    //     var count = $("#count").val();
    //     // alert(count);
    //     $("#index").val(index);
    //     $(this).siblings().removeClass("fontB").siblings().addClass("fontB");
    //     $(this).children().css("opacity", "1");
    //     $(this).siblings().children().css("opacity", "0");
    //     $(".tab_content > div").eq(index).show().siblings().hide();
    //
    //     // $("#annular").empty();
    //     var myChart1 = echarts.init(document.getElementById('annular'));
    //     var myChart2 = echarts.init(document.getElementById('doughnut'));
    //
    //     /**
    //      * 请求
    //      * @type {string}
    //      */
    //     var method = "group_buy";
    //     var timestamp = (new Date()).getTime();
    //     var sign = getSign(method, timestamp);
    //     $.ajax({
    //         type: 'POST',
    //         data: {
    //             method: method,
    //             timestamp: timestamp,
    //             sign: sign
    //         },
    //         url: "../api/v1.0/api.php",
    //         dataType: 'json',
    //         beforeSend: function (data) {
    //             // $('#Canvas').html('<p>请求处理中...</p>');
    //         },
    //         success: function (data) {
    //             var msgData = data.data[count];
    //             //横坐标
    //             var label = new Array();
    //             var value = new Array();
    //             var data = new Array();
    //             var list_data = msgData.ratioData;
    //             var history_date = new Array();
    //             var history_price = new Array();
    //             var market_price = new Array();
    //             for (var key in list_data) {
    //                 label.push(key);
    //                 value.push(list_data[key].split("%")[0]);
    //             }
    //             for (var i = 0; i < label.length; i++) {
    //                 data.push({value: value[i], name: label[i]})
    //             }
    //             var date_list = msgData.history_date;
    //             for (var key in date_list) {
    //                 history_date.push(date_list[key]);
    //                 history_price.push(parseFloat(msgData.history_price[key]));
    //                 market_price.push(parseFloat(msgData.market_price[key]));
    //             }
    //
    //             var option1 = {
    //                 tooltip: {
    //                     trigger: 'axis',
    //                 },
    //                 color:['#3B48EE','#9c5977'],
    //                 legend: {
    //                     data: ['基金组合净值', '同期沪深300指数'],
    //                     top: 270,
    //                 },
    //                 xAxis: {
    //                     type: 'category',
    //                     boundaryGap: false,
    //                     axisLine: {
    //                         lineStyle: {
    //                             color: '#E6EAF0',
    //                         }
    //                     },
    //                     axisLabel: {
    //                         textStyle: {
    //                             color: '#959FAC',//坐标值得具体的颜色
    //                         }
    //                     },
    //                     data: history_date
    //                 },
    //                 yAxis: {
    //                     type: 'value',
    //                     // scale: true,
    //                     boundaryGap: false,
    //                     axisLine: {
    //                         lineStyle: {
    //                             color: '#E6EAF0',
    //                         }
    //                     },
    //                     axisLabel: {
    //                         textStyle: {
    //                             color: '#959FAC',//坐标值得具体的颜色
    //                         }
    //                     },
    //                 },
    //                 series: [
    //                     {
    //                         name: "基金组合净值",
    //                         type: 'line',
    //                         symbol: "circle",
    //                         itemStyle: {
    //                             normal: {
    //                                 lineStyle: {
    //                                     width: 1,
    //                                     color: "#3B48EE",
    //                                 },
    //                             }
    //                         },
    //
    //                         areaStyle: {
    //                             normal: {
    //                                 color: new echarts.graphic.LinearGradient(
    //                                     0, 0, 0, 1,
    //                                     [
    //                                         {offset: 0, color: 'rgba(84,93,255,0.4)'},
    //                                         {offset: 1, color: '#fff'}
    //                                     ]
    //                                 )
    //                             }
    //                         },
    //                         symbolSize: 6,
    //                         data: history_price
    //
    //                     },
    //                     {
    //                         type: 'line',
    //                         symbol: "circle",
    //                         itemStyle: {
    //                             normal: {
    //                                 lineStyle: {
    //                                     width: 1,
    //                                     color: "#9c5977",
    //                                 },
    //                             }
    //                         },
    //                         areaStyle: {
    //                             normal: {
    //                                 color: new echarts.graphic.LinearGradient(
    //                                     0, 0, 0, 1,
    //                                     [
    //                                         {offset: 0, color: 'rgba(156,89,119,0.4)'},
    //                                         {offset: 1, color: '#fff'}
    //                                     ]
    //                                 )
    //                             }
    //                         },
    //                         symbolSize: 6,
    //                         name: "同期沪深300指数",
    //                         data: market_price
    //                     }
    //                 ]
    //             };
    //             var option2 = {
    //                 // tooltip: {
    //                 //     trigger: 'item',
    //                 //     formatter: "{a} <br/>{b}: {c} ({d}%)"
    //                 // },
    //                 color: ["#26DFDE", "#FFB500", "#3B48EE", "#FF5959", "#F44CFF", "#7ED321", "#FFFF00"],
    //                 legend: {
    //                     orient: 'vertical',  //垂直显示
    //                     x: '70%',
    //                     y: 'center',
    //                     itemWidth: 5, // 设置宽度
    //                     itemHeight: 15, // 设置高度
    //                     data: label,
    //                     selectedMode: false,
    //                     textStyle: {
    //                         color: '#959FAC',  //文字颜色
    //                         fontSize: 12    //文字大小
    //                     },
    //                     formatter: function (name) {
    //                         var index = 0;
    //                         var clientlabels = label;
    //                         var clientcounts = value;
    //                         clientlabels.forEach(function (value, i) {
    //                             if (value == name) {
    //                                 index = i;
    //                             }
    //                         });
    //                         return name + "  " + clientcounts[index] + "%";
    //                     },
    //                 },
    //                 graphic: {
    //                     elements: [
    //                         {
    //                             type: 'image',
    //                             style: {
    //                                 image: '../web/img/down-icon.png',
    //                                 width: 22,
    //                                 height: 22
    //                             },
    //                             left: '27%', // 相对父元素居中
    //                             top: '55%',  // 相对父元素上下的位置
    //                         },
    //                         {
    //                             type: 'text',
    //                             left: '20%', // 相对父元素居中
    //                             top: 'center',  // 相对父元素上下的位置
    //                             style: {
    //                                 fill: '#485465',
    //                                 text: '查看方案详情',
    //                                 textAlign: 'center',
    //                                 font: '14px Arial Normal',
    //                             }
    //                         }]
    //                 },
    //                 series: [
    //                     {
    //                         name: '',
    //                         type: 'pie',
    //                         radius: ['50%', '60%'],
    //                         center: ['30%', '50%'],//圆形居中
    //                         avoidLabelOverlap: false,
    //                         label: {
    //                             normal: {
    //                                 show: false,
    //                             },
    //                             emphasis: {
    //                                 show: false,
    //                             }
    //                         },
    //                         labelLine: {
    //                             normal: {
    //                                 show: false
    //                             }
    //                         },
    //                         data: data
    //                     }
    //                 ]
    //             };
    //             // 使用刚指定的配置项和数据显示图表。
    //
    //             myChart1.clear();
    //             myChart1.setOption(option1);
    //
    //             myChart2.setOption(option2);
    //         }
    //     });
    //
    // });
});