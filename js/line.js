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
/*            // 周同比图
            var myChart1 = ec.init(document.getElementById('canvas1'));            
            var option = {
                tooltip: {
                    show: true
                },
                chart:{
                    "plotFillAlpha": "90"
                },
                grid:{
                	x:'25',
                	y:'10',
                	x2:'0'
                },
                
                xAxis : [
                    {
                        type : 'category',
                        data : ["上周","本周"],
                        splitLine:false
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        "name":"时间",
                        "type":"bar",
                        "data":[42, 85],
                        "barWidth":"40",
                        itemStyle: {
			                normal: {
			                    color: function(params) {
			                        // build a color map as your need.
			                        var colorList = [
			                          '#5fa6e6','#8ac2ee','#FCCE10','#E87C25','#27727B',
			                           '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
			                           '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
			                        ];
			                        return colorList[params.dataIndex]
			                    },
			                    //label: {
			                    //    show: true,
			                     //   position: 'top',
			                     //   formatter: '{b}\n{c}'
			                    //}
			                }
			            }
                    }
                ],
                color:['#96caf1', '#082a44', '#9cc0d6', '#9ccd32', '#9cc5ed']
            };    
            // 为echarts对象加载数据 
            myChart1.setOption(option); 
            // 趋势周同比图（单位：周）
            var myChart2 = ec.init(document.getElementById('canvas2'));            
            var option = {
                tooltip: {
                    show: true
                },
                grid:{
                	x:'25',
                	y:'10',
                	x2:'0'
                },
                
                xAxis : [
                    {
                        type : 'category',
                        data : ["周一","周二","周三","周四","周五","周六","周日"],                        
                        splitLine:false,
                        splitLine :{
                        	show:false
                        },
                        boundaryGap:true
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        "name":"上周",
                        "type":"bar",
                        "data":[45,45,45,45,45,45,45],
                        "barWidth":"5",
                        itemStyle: {
			                normal: {
			                    color: function(params) {
			                        // build a color map as your need.
			                        var colorList = [
			                          '#5fa6e6', '#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6',
			                        ];
			                        return colorList[params.dataIndex]
			                    },
			                }
			            }
                    },
                    {
                        "name":"本周",
                        "type":"bar",
                        "data":[20,25,55,80,65,95,75],
                        "barWidth":"5",
                        itemStyle: {
			                normal: {
			                    color: function(params) {
			                        // build a color map as your need.
			                        var colorList = [
			                           '#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee'
			                        ];
			                        return colorList[params.dataIndex]
			                    },
			                }
			            }
                    }
                ],
                color:['#5fa6e6', '#8ac2ee']
            };    
            // 为echarts对象加载数据 
            myChart2.setOption(option); 
            // 月同比图（单位：月）
            var myChart3 = ec.init(document.getElementById('canvas3'));            
            var option = {
                tooltip: {
                    show: true
                },
                grid:{
                	x:'35',
                	y:'10',
                	x2:'0'
                },
                
                xAxis : [
                    {
                        type : 'category',
                        data : ["上月","本月"],
                        splitLine:false
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        "name":"时间",
                        "type":"bar",
                        "data":[0.9, 1.43],
                        "barWidth":"40",
                        itemStyle: {
			                normal: {
			                    color: function(params) {
			                        // build a color map as your need.
			                        var colorList = [
			                          '#5fa6e6','#8ac2ee','#FCCE10','#E87C25','#27727B',
			                           '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
			                           '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
			                        ];
			                        return colorList[params.dataIndex]
			                    },
			                    
			                }
			            }
                    }
                ],
                color:['#96caf1', '#082a44', '#9cc0d6', '#9ccd32', '#9cc5ed']
            };    
            // 为echarts对象加载数据 
            myChart3.setOption(option); 
            // 趋势月同比图（单位：周）
            var myChart4 = ec.init(document.getElementById('canvas4'));            
            var option = {
                tooltip : {
			        trigger: 'axis'
			    },
                grid:{
                	x:'25',
                	y:'50',
                	x2:'5',
                },
                
                xAxis : [
                    {
                        type : 'category',
                        data : [ '01','\n02','03','\n04','05','\n06','07','\n08',
                    '09','\n10','11','\n12','13','\n14','15','\n16',
                    '17','\n18','19','\n20','21','\n22','23','\n24',
                    '25','\n26','27','\n28','29','\n30','31'],                        
                        splitLine:false,
                        splitLine :{
                        	show:false
                        },
                        boundaryGap : false,
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
                        "name":"上月",
                        "type":"line",
                        "data":[0.2,0.8,0.6,0.2,0.8,0.5,0.2,0.6,0.1,0.5,0.4,0.3,0.9,0.8,0.1,0.5,0.1,0.2,0.8,0.6,0.2,0.8,0.5,0.2,0.6,0.1,0.5,0.4,0.3,0.9,0.2],
                        smooth:true,
                        itemStyle: {normal: {areaStyle: {type: 'default',color:'#5fa6e6'}}},
                    },
                    {
                        "name":"本月",
                        "type":"line",
                        "data":[0.5,0.2,0.6,0.9,0.8,0.7,0.2,0.3,0.9,0.8,0.4,0.3,0.5,0.6,0.6,0.1,0.1,0.8,0.3,0.1,0.9,0.3,0.1,0.2,0.8,0.1,0.5,0.4,0.9,0.1,0.2],
                        smooth:true,
                        itemStyle: {normal: {areaStyle: {type: 'default',color:'#8ac2ee'}}},
                    }
                ],
                color:['#5fa6e6', '#8ac2ee']
            };    
            // 为echarts对象加载数据 
            myChart4.setOption(option); 
            // 年同比图
            var myChart5 = ec.init(document.getElementById('canvas5'));            
            var option = {
                tooltip: {
                    show: true
                },
                grid:{
                	x:'35',
                	y:'10',
                	x2:'0'
                },
                
                xAxis : [
                    {
                        type : 'category',
                        data : ["去年","今年"],
                        splitLine:false
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
                        "data":[0.81, 1.5],
                        "barWidth":"40",
                        itemStyle: {
			                normal: {
			                    color: function(params) {
			                        // build a color map as your need.
			                        var colorList = [
			                          '#5fa6e6','#8ac2ee','#FCCE10','#E87C25','#27727B',
			                           '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
			                           '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
			                        ];
			                        return colorList[params.dataIndex]
			                    },
			                }
			            }
                    }
                ],
                color:['#96caf1', '#082a44', '#9cc0d6', '#9ccd32', '#9cc5ed']
            };    
            // 为echarts对象加载数据 
            myChart5.setOption(option); 
            // 趋势年同比图（单位：月）
            var myChart6 = ec.init(document.getElementById('canvas6'));            
            var option = {
                tooltip: {
                    show: true
                },
                grid:{
                	x:'25',
                	y:'10',
                	x2:'0'
                },
                
                xAxis : [
                    {
                        type : 'category',
                        data : ["1","2","3","4","5","6","7","8","9","10","11","12"],                        
                        splitLine:false,
                        splitLine :{
                        	show:false
                        },
                        boundaryGap:true
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        "name":"去年",
                        "type":"bar",
                        "data":[0.2,0.3,0.6,0.8,0.7,0.8,0.4,0.1,0.7,0.6,0.4,0.2],
                        "barWidth":"15",
                        itemStyle: {
			                normal: {
			                    color: function(params) {
			                        // build a color map as your need.
			                        var colorList = [
			                          '#5fa6e6', '#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6', '#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6'
			                        ];
			                        return colorList[params.dataIndex]
			                    },
			                }
			            }
                    },
                    {
                        "name":"今年",
                        "type":"bar",
                        "data":[0.2,0.5,0.7,0.1,0.9,0.4,0.8,0.2,0.1,0.6,0.6,0.1],
                        "barWidth":"5",
                        itemStyle: {
			                normal: {
			                    color: function(params) {
			                        // build a color map as your need.
			                        var colorList = [
			                           '#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee'
			                        ];
			                        return colorList[params.dataIndex]
			                    },
			                }
			            }
                    }
                ],
                color:['#5fa6e6', '#8ac2ee']
            };    
            // 为echarts对象加载数据 
            myChart6.setOption(option);
            // 趋势月同比图（单位：周）
            var myChart7 = ec.init(document.getElementById('canvas7'));            
            var option = {
                tooltip : {
			        trigger: 'axis'
			    },
                grid:{
                	x:'25',
                	y:'50',
                	x2:'5',
                },
                
                xAxis : [
                    {
                        type : 'category',
                        data : [ '01','02','03','04','05','06','07','08',
                    '09','10','11','12','13','14','15','16',
                    '17','18','19','20','21','22','23','24',
                    '25','26','27','28','29','30','31'],                        
                        splitLine:false,
                        splitLine :{
                        	show:false
                        },
                        boundaryGap : false,
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
                        // "name":"上月",
                        "type":"line",
                        "data":[20,25,29,35,37,45,41,35,25,15,10,5,25,45,65,80,100,78,45,40,56,85,89,60,55,45,35,25,10,5,0],
                        smooth:true,
                        itemStyle: {normal: {areaStyle: {type: 'default',color:'#b4d8f2'}}},
                    }
                ],
                color:['#5fa6e6', '#8ac2ee']
            };    
            // 为echarts对象加载数据 
            myChart7.setOption(option); */
            
        }
    );
})