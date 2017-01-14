$(document).ready(function(){
		var arr1=[],arr2=[];
			
function arrTest(){
	$.ajax({
		type:"post",
		async:false,
		url:"../css/test.php?action=test",
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
        var myChart = echarts.init(document.getElementById('main'));
arrTest();
        // 指定图表的配置项和数据
option = {
    title : {
        text: '数据列表',
        subtext: '纯属虚构'
    },
    tooltip : {
        trigger: 'axis'
    },
    legend: {
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
            data : arr1
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel : {
                formatter: '{value}'
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
		}
		
		});
                    
                    

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
	window.onresize = myChart.resize;
});