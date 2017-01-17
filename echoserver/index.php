<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Lottery</title>
	<link rel="stylesheet" type="text/css" href="html/mycss.css">
	<link rel="stylesheet" type="text/css" href="html/list.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<script src="./css/jquery.min.js" type="text/javascript"></script>
	<script src="./css/Global.js" type="text/javascript"></script>
	<script src="./css/echarts.js" type="text/javascript"></script>
	<script src="./css/mycharts.js" type="text/javascript"></script>

</script>
</head>
<body>
<div class="page">
        <div class="container" id="mainmenu" role="main">
            <ul class="menu">
                <li><a href="#">基本走势</a>
                    <ul class="submenu">
						 <li><a id="bt_current">近期分布</a></li>
                        <li><a id="bt_lost" href="#">红球遗漏</a></li>
                        <li><a id="bt_range" href="#">红球区间</a></li>						
                        <li><a id="bt_blue" href="#">篮球差值</a></li>
                    </ul>
                </li>
                <li><a href="#">图形分析</a>
                    <ul class="submenu">
                        <li><a id="bt_redlost" href="#">红球遗漏</a></li>
						<li><a id="bt_bluediff" href="#">篮球差值</a></li>
                        <li><a id="bt_bluerange" href="#">篮球区间</a></li>						
                    </ul>
				</li>	
				<li><a href="#">系统设置</a>
				     <ul class="submenu">
                        <li><a id="bt_updateFromFile" href="#">文件更新</a></li>
						<li><a id="bt_updateManual" href="#">手动更新</a></li>
                        <li><a id="bt_delNewest" href="#">删除最新</a></li>						
                    </ul>
				</li>
			</ul>
		</div>
<div id="mainpage" style="width:100%">		
<div id="curTable" class="datatable">
<?php
	require_once dirname (__FILE__).'/ssq.php';
	$webIndex="allballs";
	//$webIndex=$_GET['index'];
	$ssq=new ssq();
	$ssq->init();
	$ssq->showWeb($webIndex);
?>

</div>		
<div  id="subtable" style="width:100%;height:400px;" >

</div>		
<div id="maintable" class="datatable" style="width:100%;height:400px;">

</div>
<div id="updatetable" style="width:520px;height:34px">
		<ol class="rounded-list">
			<li id="ssqnum1"><a href="#">List item</a><span></li>
			<li id="ssqnum2"><a href="#">List item</a></li>
			<li id="ssqnum3"><a href="#">List item</a></li>
			<span  id="bt_del" class="blueStyle" >删除最新行</span>
			<input id="t_password" type="text" placeholder="验证密码"  style="height:30px"/>

		</ol>

		<input id="t_user" type="text" placeholder="更新密钥"  style="height:30px"/><BR>
		<input id="t_num" type="text" placeholder="期数"  style="height:30px"/><BR>
		<input id="t_data" type="text" placeholder="数据"  style="height:30px"/><br><BR>
		<a href="#" id="bt_ok" class="blueStyle" >确认更新</a><BR><BR>



</div>

</div>
</body>
</html>