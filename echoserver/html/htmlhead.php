<?php
define ('CSS0','p0');
define ('CSS1','p1');
define ('CSS2','p2');
define ('CSS3','p3');
define ('CSS4','p4');
define ('CSS5','p5');
define ('CSS6','p6');
define ('JSCODE','
<script language=javascript>
function change(divName){
    var div = document.getElementById(divName);
    if(obj.value=="隐藏"){
        div.style.display = "none";
        obj.value = "显示";
    } else {
        div.style.display = "block";
        obj.value = "隐藏";
    }
}

</script>');

define('HTML_HEAD',
	'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<HEAD>
<style type="text/css">
.p0 { background-color:#CCCCFF;COLOR: #0;text-align=right}
.p1 { background-color:#CCFFFF;COLOR: #0 ;text-align=right}
.p2 { background-color:#CCCCFF;COLOR: #0;text-align="right"}
.p3 { background-color:#CC99FF; COLOR:#0;text-align="right"}
.p4 {background-color:#FFCCFF; COLOR:#0;text-align="right"}
.p5{background-color:#383C54}
.p7 {background-color:#0099ff; COLOR:#0;text-align="right"}
.p8 {background-color:#ccffcc; COLOR:#0;text-align="right"}
.p9 {background-color:#ffcccc; COLOR:#0;text-align="right"}
.p10 {background-color:#ccffcc; COLOR:#0;text-align="right"}
.p11 {background-color:#ccccff; COLOR:#0;text-align="right"}
.percents {
background:url(image/shade.png) center;	
 position:absolute;
 height: 38px;
 width:439px;
 z-index:11;
 left: 10px;
 top: 38px;
 text-align: right;
}
.blocks {
background:url(image/bar.png) center;	
 height: 38px;
 width: 439px;
 position: absolute;
 color:#ff1122;
 z-index:10;
 left: -400px;
 top: 38px;
 filter: alpha(opacity=50);
 -moz-opacity: 0.5;
 opacity: 0.5;
 -khtml-opacity: .5
}

#coupon1 {
    position: fixed;
	top: 20px;
	left: -230px;
}
#coupon2 {
    position: fixed;
	top: 100px;
	left: -230px;
}
#coupon3 {
    position: fixed;
	top: 180px;
	left: -230px;
}
#coupon4 {
    position: fixed;
	top: 240px;
	left: 0px;
}
#upateform{
    position: fixed;
	background:url(image/ticket.gif) center;
	top: 300px;
	left: -200px;
	width:273px;
	height:143px;
	text-align:center;
	padding-top:10px auto;

}
#coupon a, img {
    border: none;
}
</style>'.JSCODE.
' </HEAD>
<BODY  background="image/bg.jpg">
<div id="coupon1">
	<a href="ssq.php?index=allballs" title="号码推荐">
		<img src="image/ticket.gif" alt="号码推荐">
	</a>
</div>
<div id="coupon2">
	<a href="ssq.php?index=rballs" title="红球预测图">
		<img src="image/ticket.gif" alt="红球预测图">
	</a>
</div>
<div id="coupon3">
	<a href="ssq.php?index=bballs" title="篮球预测图">
		<img src="image/ticket.gif" alt="篮球预测图">
	</a>
</div>
<div id="upateform">
<form action="ssq.php?index=update" method="POST" aligin=center>
    Name:  <input type="text" name="username"><br />
    Email: <input type="text" name="email"><br />
    <input type="submit" name="submit" value="submit" />
</form>
</div>
 
<TABLE style="BORDER-COLLAPSE: collapse" borderColor=#31659c cellSpacing=0 cellPadding=0 align="center"  bgColor=#ffffff border=1>
<TBODY>
');
define('HTML_TAIL',
'</TBODY >
</TABLE>
</BODY>
</HTML>');

