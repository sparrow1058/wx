//Global.js
$(document).ready(function(){
/*
	document.onclick = function(e){
                var target = e.target|| e.srcElement;
				if(target.tagName =="tr")
					alert(target.id)
            }
*/	
	
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
});

	