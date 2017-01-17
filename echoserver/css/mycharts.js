var arr1=[],arr2=[];
$(document).ready(function(){
	arrTest();
	$("#bt_bluediff").click(function(event){
	hideAllDiv();
	$("#maintable").show();
	showEcharts();
		
		
	});
});
//document.getElementById('main')[0].bgColor="#FFFFFF";			
function arrTest(){
	$.ajax({
		type:"post",
		async:false,
		url:"css/test.php?action=test",
		data:"",
		dataType:"json",
		success:function(result){
			if(result){
				var len=result.length;
				for(var i=len-1;i>-1;i--){
					arr1.push(result[i].BB);
					arr2.push(result[i].DIFF);
					}
				}
			}
		})
		return arr1,arr2;
}



function showEcharts(){
	
var myChart = echarts.init(document.getElementById('maintable'));

        // 指定图表的配置项和数据
option = {
    title : {
        text: '篮球差值',
        subtext: '仅供参考',
		textStyle:{
			color:'#00ffcc',
		}
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
		padding: [5, 100, 5, 5],
		data:[]
    },
    toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            magicType : {show: true, type: ['line', 'bar']},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    calculable : true,
    xAxis : [
        {
            type : 'category',
            boundaryGap : false,
            data : arr1,
			axisLabel : {
				show: true,
				textStyle: {
					color: '#aaac00'
				}
			},
			axisLine: {
				lineStyle:{
					color:'#00ff00'
				}
			}
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}',
				textStyle: {
					color: '#aaac00'
					}
            },
			axisLine: {
				lineStyle:{
					color:'#00ff00'
				}
			}			
        }
    ],
    series : [

    ]
};
	option.legend.data.push('diff');
	option.series.push({
		name:'diff',
		type:'line',
		data:arr2,
		markPoint : {
			data : [
			{type : 'max', name: '最大值'},
			{type : 'min', name: '最小值'}
			]
		},
		markLine : {
			data : [
			{type : 'average', name: '平均值'}
			]
		},
	 itemStyle : { normal: {label : {show: true}}},
		
		});
                    
                    

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
	window.onresize = myChart.resize;
}