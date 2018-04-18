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
            // 趋势月同比图（单位：周）
            var myChart9 = ec.init(document.getElementById('canvas9'));         
            var option = {
                 title : {
                    // text: '未来一周气温变化',
                    subtext: datas.unittype
                },
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
                        data : datas.date.xAxis1,                        
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
                        // "name":"本月",
                        "type":"line",
                        "data":datas.date.series1,
                        smooth:true,
                        itemStyle: {normal: {areaStyle: {type: 'default',color:'#8ac2ee'}}}
                    }
                ],
                color:['#5fa6e6', '#8ac2ee']
            };    
            // 为echarts对象加载数据 
            myChart9.setOption(option);
            
        }
    );
})