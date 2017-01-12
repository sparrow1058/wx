//Global.js
$(document).ready(function(){
/*
	document.onclick = function(e){
                var target = e.target|| e.srcElement;
				if(target.tagName =="tr")
					alert(target.id)
            }
*/	document.getElementsByTagName( 'body' )[0].bgColor="#35393d";
	$("#updatetable").hide();
	$("#bt_update").click(function(event) {
		var jsonData="";
		var ssqnum="ssqnum1";
		$("#maintable").hide();
		$("#subtable").hide();
		$("#updatetable").show();
		$.getJSON("./css/test.php?action=update",function(json){
			//<a href="#">List item</a>
			$.each(json, function(i){  
				//	jsonData=sprintf('<a href="#"> %3d',json[i].R1);
							
                           jsonData ='<a href="#">'+ json[i].Num+" "+ strPad(json[i].R1,2)+" "+strPad(json[i].R2,2)+" "+strPad(json[i].R3,2)+" "+strPad(json[i].R4,2)+" "+ 
								strPad(json[i].R5,2)+" "+strPad(json[i].R6,2)+" <span class=spangBlue>"+strPad(json[i].B1,2)+"</span> "+json[i].OEC+" <span class=spanGreen>"+json[i].RANGE+"</span> "+"</a>"; 
							
							ssqnum="#ssqnum"+(i+1);
							$(ssqnum).html(jsonData);
                        });
		
		});
	});
	$("tr").bind("click",function(){
	     var id=$(this).attr('id');
		if(id>10000){
			var URL = "./css/test.php?action=showrlost";
				  $.ajax({
					type: "POST",
					url: URL,
					data: "&num="+id,
					success: function(msg){
						$("#subtable").html(msg);	

					}
				
				 });
		}
	});
	$("#bt_ok").click(function(event){
			var user=$("#t_user").val();
			var num=$("#t_num").val();
			var data=$("#t_data").val();
//			alert("user"+user+"&num"+num+"&data"+data);
			var URL = "./css/test.php?action=updateone";
				  $.ajax({
					type: "POST",
					url: URL,
					data:"user="+user+"&num="+trim(num)+"&data="+trim(data),
					success: function(msg){
						$("#subtable").html(msg);	
						$("#bt_update").trigger("click");		
					}
				
				 });
			 
	});
	$("#bt_del").click(function(event){
			var password=$("#t_password").val();
//			alert("user"+user+"&num"+num+"&data"+data);
			var URL = "./css/test.php?action=delnew";
				  $.ajax({
					type: "POST",
					url: URL,
					data:"password="+password,
					success: function(msg){
						if(msg==1)
							$("#bt_update").trigger("click");
						//	document.getElementById("bt_update").click();
								
						
							
					}
				
				 });
	});
	
});
function strPad(num, length) {  
 return ( "0000000000000000" + num ).substr( -length );  
}
function trim(str) {
  return str.replace(/[^0-9]/g, "");
} 
	