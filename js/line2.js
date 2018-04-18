$(document).ready(function() {
	require.config({
        paths: {
            echarts: './js/'
        }
    });
    require(
        [
            'echarts',
            'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
            'echarts/chart/line' // 使用柱状图就加载bar模块，按需加载
        ],
        function (ec) {
            var myChart8 = ec.init(document.getElementById('canvas8'));            
            var option = {
                tooltip: {
                    show: true
                },
                grid:{
                    x:'40',
                    y:'10',
                    x2:'0'
                },
                
                xAxis : [
                    {
                        type : 'category',
                        data : ["｛单位总称｝","\n｛单位总称｝","｛单位总称｝","\n｛单位总称｝"],
                        splitLine:false,
                        axisLabel:{'interval':0},
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        // "name":"时间",
                        "type":"bar",
                        "data":[1800, 3200,2800,4300],
                        "barWidth":"40",
                        itemStyle: {
                            normal: {
                                color: function(params) {
                                    // build a color map as your need.
                                    var colorList = [
                                      '#5fa6e6','#8ac2ee','#5fa6e6','#8ac2ee'
                                    ];
                                    return colorList[params.dataIndex]
                                },
                                /*label: {
                                    show: true,
                                    position: 'top',
                                    formatter: '{b}\n{c}'
                                }*/
                            }
                        }
                    }
                ],
                color:['#96caf1', '#082a44', '#9cc0d6', '#9ccd32', '#9cc5ed']
            }; 
            // 为echarts对象加载数据 
            myChart8.setOption(option);
            
        }
    );
})