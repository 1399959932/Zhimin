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
            var myChart10 = ec.init(document.getElementById('canvas10'));            
            var option = {
                 title : {
                    // text: '未来一周气温变化',
                    subtext: datas.unittype,
                    y:'20'
                },
                tooltip : {
			        trigger: 'axis'
			    },
                grid:{
                	x:'35',
                	y:'65',
                	x2:'20'
                },
                 legend: {
                    data:datas.date.danwei
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data : datas.date.xAxis1, 
                        boundaryGap : false
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : datas.date.series1
                // color:['#5fa6e6', '#8ac2ee'],
                // legendHoverLink:true,
            };    
            // 为echarts对象加载数据 
            myChart10.setOption(option);
            
        }
    );
})