//web charts 
//document.write("<script language='javascript' src='one.js'></script>");
//$("#subtable").show();
var myChart = echarts.init(document.getElementById('subtable'));
//var myChart = echarts.init(document.getElementsByTagName("echarts"));
//var myChart=echars.init(document.getElementById('subtable'));
var arr1=[],arr2=[];
function arrTest(){
	$.ajax({
		type:"post",
		async:false,
		url:"./css/test.php?action=test",
		data:"",
		dataType:"json",
		success:function(result){
			if(result){
				for(var i=0;i<result.length;i++){
					arr1.push(result[i].Num);
					arr2.push(result[i].B1);
					}
				}
			}
		})
		return arr1,arr2;
	}
	arrTest();
	var option={
			tooltip:{
				show:true
			},
			legend:{
				data:['age']
			},
			xAxis:[
			{
				type:"category",
				data:arr1
			}
			],
			yAxis:[
			{
				type:'value'
			}
			],
			series:[
			{
				"name":"age",
				"type":"bar",
				"data":arr2
			}
			]
	};
	myChart.setOption(option);