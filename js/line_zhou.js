$(document).ready(function(){
	
	
	$("#li_after_zhou").click(function(){
		var ind=$(this).index();
		var hand=$(".tab_wrap:eq("+ind+")");
		var unitcode = $("#li_after_zhou").val();
		var type = $("#li_after_qushi").val();
		$.ajax({
            type: "POST",
            url: "./?_a=supchat&_c=sup&_m=index&action=zhou",
            data: {"unitcode":unitcode,"type":type
            },
            dataType: "json",
            success: function(data){
                if(data.status == 1 )
                    {
                    	var date=data.date;
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
                    	// 周同比图
				            var myChart1 = ec.init(document.getElementById('canvas1'));            
				            var option = {
				                tooltip: {
				                    show: true
				                },
				                chart:{
				                    "plotFillAlpha": "90"
				                },
				                grid:{
				                	x:'40',
				                	y:'10',
				                	x2:'10'
				                },
				                
				                xAxis : [
				                    {
				                        type : 'category',
				                        data : date.xAxis,
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
				                        "data":date.series,
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
							                    }
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
				                	x:'40',
				                	y:'10',
				                	x2:'10'
				                },
				                
				                xAxis : [
				                    {
				                        type : 'category',
				                        data : date.xAxis1,                        
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
				                        "data":date.series1.prevWeek,
				                        "barWidth":"5",
				                        itemStyle: {
							                normal: {
							                    color: function(params) {
							                        // build a color map as your need.
							                        var colorList = [
							                          '#5fa6e6', '#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6'
							                        ];
							                        return colorList[params.dataIndex]
							                    }
							                }
							            }
				                    },
				                    {
				                        "name":"本周",
				                        "type":"bar",
				                        "data":date.series1.nowWeek,
				                        "barWidth":"5",
				                        itemStyle: {
							                normal: {
							                    color: function(params) {
							                        // build a color map as your need.
							                        var colorList = [
							                           '#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee'
							                        ];
							                        return colorList[params.dataIndex]
							                    }
							                }
							            }
				                    }
				                ],
				                color:['#5fa6e6', '#8ac2ee']
				            };    
				            // 为echarts对象加载数据 
				            myChart2.setOption(option); 
				        })
                    }else{
						//错误
						
                    }
            	}
    	});
	});
	

	
	$("#li_after_yue").click(function(){
		var ind=$(this).index();
		var hand=$(".tab_wrap:eq("+ind+")");
		var unitcode = $("#li_after_zhou").val();
		var type = $("#li_after_qushi").val();
		$.ajax({
            type: "POST",
            url: "./?_a=supchat&_c=sup&_m=index&action=yue",
            data: {"unitcode":unitcode,"type":type
            },
            dataType: "json",
            success: function(data){
                if(data.status == 1 )
                    {
                    	var date=data.date;
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
				            // 月同比图（单位：月）
				            var myChart3 = ec.init(document.getElementById('canvas3'));            
				            var option = {
				                tooltip: {
				                    show: true
				                },
				                grid:{
				                	x:'50',
				                	y:'10',
				                	x2:'10'
				                },
				                
				                xAxis : [
				                    {
				                        type : 'category',
				                        data : date.xAxis,
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
				                        "data":date.series,
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
							                    }
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
				                	x:'50',
				                	y:'10',
				                	x2:'10'
				                },
				                
				                xAxis : [
				                    {
				                        type : 'category',
				                        data :  ['01','\n02','03','\n04','05','\n06','07','\n08',
				                        '09','\n10','11','\n12','13','\n14','15','\n16',
				                        '17','\n18','19','\n20','21','\n22','23','\n24',
				                        '25','\n26','27','\n28','29','\n30','31'],                        
				                        splitLine:false,
				                        splitLine :{
				                        	show:false
				                        },
				                        boundaryGap : false,
				                        axisLabel:{'interval':0}
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
				                        "data":date.series1.prevWeek,
				                        smooth:true,
				                        itemStyle: {normal: {areaStyle: {type: 'default',color:'#5fa6e6'}}}
				                    },
				                    {
				                        "name":"本月",
				                        "type":"line",
				                        "data":date.series1.nowWeek,
				                        smooth:true,
				                        itemStyle: {normal: {areaStyle: {type: 'default',color:'#8ac2ee'}}}
				                    }
				                ],
				                color:['#5fa6e6', '#8ac2ee']
				            };    
				            // 为echarts对象加载数据 
				            myChart4.setOption(option); 
				        })
                    }else{
						//错误
						
                    }
            	}
    	});
	});

	
	$("#li_after_nian").click(function(){
		var ind=$(this).index();
		var hand=$(".tab_wrap:eq("+ind+")");
		var unitcode = $("#li_after_nian").val();
		var type = $("#li_after_qushi").val();
		$.ajax({
            type: "POST",
            url: "./?_a=supchat&_c=sup&_m=index&action=nian",
            data: {"unitcode":unitcode,"type":type
            },
            dataType: "json",
            success: function(data){
                if(data.status == 1 )
                    {
                    	var date=data.date;
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
				            var myChart5 = ec.init(document.getElementById('canvas5'));            
				            var option = {
				                tooltip: {
				                    show: true
				                },
				                grid:{
				                	x:'50',
				                	y:'10',
				                	x2:'10'
				                },
				                
				                xAxis : [
				                    {
				                        type : 'category',
				                        data : date.xAxis,
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
				                        "data":date.series,
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
							                    }
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
				                	x:'45',
				                	y:'10',
				                	x2:'10'
				                },
				                
				                xAxis : [
				                    {
				                        type : 'category',
				                        data : date.xAxis1,                        
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
				                        "data":date.series1.prevWeek,
				                        "barWidth":"15",
				                        itemStyle: {
							                normal: {
							                    color: function(params) {
							                        // build a color map as your need.
							                        var colorList = [
							                          '#5fa6e6', '#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6', '#5fa6e6','#5fa6e6','#5fa6e6','#5fa6e6'
							                        ];
							                        return colorList[params.dataIndex]
							                    }
							                }
							            }
				                    },
				                    {
				                        "name":"今年",
				                        "type":"bar",
				                        "data":date.series1.nowWeek,
				                        "barWidth":"5",
				                        itemStyle: {
							                normal: {
							                    color: function(params) {
							                        // build a color map as your need.
							                        var colorList = [
							                           '#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee','#8ac2ee'
							                        ];
							                        return colorList[params.dataIndex]
							                    }
							                }
							            }
				                    }
				                ],
				                color:['#5fa6e6', '#8ac2ee']
				            };    
				            // 为echarts对象加载数据 
				            myChart6.setOption(option);
				        })
                    }else{
						//错误
						
                    }
            	}
    	});
	});	

	
	$("#li_after_qushi").click(function(){
		var ind=$(this).index();
		var hand=$(".tab_wrap:eq("+ind+")");
		var unitcode = $("#li_after_yue").val();
		var type = $("#li_after_qushi").val();
		$.ajax({
            type: "POST",
            url: "./?_a=supchat&_c=sup&_m=index&action=qushi",
            data: {"unitcode":unitcode,"type":type
            },
            dataType: "json",
            success: function(data){
                if(data.status == 1 )
                    {
                    	var date=data.date;
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
				            // 趋势月同比图（单位：周）
				            var myChart7 = ec.init(document.getElementById('canvas7'));            
				            var option = {
				                tooltip : {
							        trigger: 'axis'
							    },
				                grid:{
				                	x:'40',
				                	y:'50',
				                	x2:'10'
				                },
				                
				                xAxis : [
				                    {
				                        type : 'category',
				                        data : date.xAxis1,                        
				                        splitLine:false,
				                        splitLine :{
				                        	show:false
				                        },
				                        boundaryGap : false,
				                        axisLabel:{'interval':0}
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
				                        "data":date.series1,
				                        smooth:true,
				                        itemStyle: {normal: {areaStyle: {type: 'default',color:'#b4d8f2'}}}
				                    }
				                ],
				                color:['#5fa6e6', '#8ac2ee']
				            };    
				            // 为echarts对象加载数据 
				            myChart7.setOption(option); 
				        })
                    }else{
						//错误
						
                    }
            	}
    	});
	});
	
	
});